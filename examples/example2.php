<?php

/**
 * Example create WordsParser with filters
 */

use Morphy\FuzzyKeywordSearch\StringFilters\DotAndCommaToSingleSpaceFilter;
use Morphy\FuzzyKeywordSearch\StringFilters\StopWordFilter;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordsParser;

require_once '../vendor/autoload.php';

$wordParser = new WordsParser([
    new DotAndCommaToSingleSpaceFilter(),
    new StopWordFilter([
        'word1',
        'another',
    ]),
]);
