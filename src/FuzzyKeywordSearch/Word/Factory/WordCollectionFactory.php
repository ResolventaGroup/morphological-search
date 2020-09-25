<?php

namespace Morphy\FuzzyKeywordSearch\Word\Factory;

use Morphy\FuzzyKeywordSearch\Word\WordCollection;

class WordCollectionFactory
{
    private $wordsParser;
    private $wordFactory;

    public function __construct(WordsParser $wordsParser, WordFactory $wordFactory)
    {
        $this->wordsParser = $wordsParser;
        $this->wordFactory = $wordFactory;
    }

    public function createFromString(string $string): WordCollection
    {
        $originalWords = $this->wordsParser->parseFromString($string);

        $words = [];

        foreach ($originalWords as $positionInString => $word) {
            $words[] = $this->wordFactory->create($positionInString, $word);
        }

        return new WordCollection($words);
    }
}
