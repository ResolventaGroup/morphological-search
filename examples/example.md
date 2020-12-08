```php
<?php

use Morphy\FuzzyKeywordSearch\Analyzer\PresenceGroupsWordsInStringAnalyzer;
use Morphy\FuzzyKeywordSearch\FuzzyKeywordSearcher;
use Morphy\FuzzyKeywordSearch\StringFilters\DotAndCommaToSingleSpaceFilter;
use Morphy\FuzzyKeywordSearch\StringFilters\MultipleLineBreaksToSingleSpaceFilter;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordCollectionFactory;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordFactory;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordsParser;
use Morphy\SemanticText\SemanticObjectInterface;
use Morphy\SemanticText\SemanticObjectRepositoryInterface;
use Morphy\SemanticText\SemanticPresenceInTextAnalyzer;

require_once '../vendor/autoload.php';

class Word implements SemanticObjectInterface
{
    private $text;

    public function __construct(string $text)
    {

        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

class WordRepository implements SemanticObjectRepositoryInterface
{
    public function findAllForSemanticAnalyze(): iterable
    {
        yield new Word('sleep');
        yield new Word('can');
        yield new Word('reach');
        yield new Word('run');
    }
}

$presenceGroupsWordsInStringAnalyzer = new PresenceGroupsWordsInStringAnalyzer();

$fuzzyKeywordSearchService = new FuzzyKeywordSearcher($presenceGroupsWordsInStringAnalyzer);

$wordParser = new WordsParser([
    new DotAndCommaToSingleSpaceFilter(),
    new MultipleLineBreaksToSingleSpaceFilter(),
]);

$phpMorphy = new phpMorphy(
    __DIR__.'/../dictionaries/',
    'en_en',
    [
        'storage' => 'file',
        'predict_by_suffix' => true,
        'predict_by_db' => true,
        'graminfo_as_text' => true,
    ]
);

$wordFactory = new WordFactory($phpMorphy);

$wordCollectionFactory = new WordCollectionFactory($wordParser, $wordFactory);

$semanticObjectRepository = new WordRepository();

$semanticPresenceInTextAnalyzer = new SemanticPresenceInTextAnalyzer(
    $fuzzyKeywordSearchService,
    $wordCollectionFactory,
    $semanticObjectRepository
);

$sourceText = '
The Tortoise never stopped for a moment, walking slowly but steadily, right to the end of the course. 
The Hare ran fast and stopped to lie down for a rest. But he fell fast asleep. 
Eventually, he woke up and ran as fast as he could. 
But when he reached the end, he saw the Tortoise there already, sleeping comfortably after her effort.
';

$semanticMatches = $semanticPresenceInTextAnalyzer->analyzeText($sourceText);

print_r($semanticMatches);
```

Result 
```php
Array
(
    [0] => Morphy\SemanticText\SemanticMatch Object
        (
            [semanticObject] => Word Object
                (
                    [text:Word:private] => 'sleep'
                )

            [matchedKeyword] => 'sleeping'
        )

    [1] => Morphy\SemanticText\SemanticMatch Object
        (
            [semanticObject] => Word Object
                (
                    [text:Word:private] => 'can'
                )

            [matchedKeyword] => 'could'
        )

    [2] => Morphy\SemanticText\SemanticMatch Object
        (
            [semanticObject] => Word Object
                (
                    [text:Word:private] => 'reach'
                )

            [matchedKeyword] => 'reached'
        )

    [3] => Morphy\SemanticText\SemanticMatch Object
        (
            [semanticObject] => Word Object
                (
                    [text:Word:private] => 'run'
                )

            [matchedKeyword] => 'ran'
        )

)
```
