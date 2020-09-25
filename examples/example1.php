<?php

/**
 * Example create WordFactory
 */

use Morphy\FuzzyKeywordSearch\Word\Factory\WordFactory;

require_once '../vendor/autoload.php';

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
