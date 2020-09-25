<?php

/**
 * Example create WordCollectionFactory
 */

use Morphy\FuzzyKeywordSearch\StringFilters\DotAndCommaToSingleSpaceFilter;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordCollectionFactory;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordFactory;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordsParser;

require_once '../vendor/autoload.php';

$wordParser = new WordsParser([
    new DotAndCommaToSingleSpaceFilter(),
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
