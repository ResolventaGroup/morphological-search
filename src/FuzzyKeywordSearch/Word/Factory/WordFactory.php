<?php

namespace Morphy\FuzzyKeywordSearch\Word\Factory;

use Morphy\FuzzyKeywordSearch\Word\Word;

class WordFactory
{
    private $phpMorphy;

    public function __construct(\phpMorphy $phpMorphy)
    {
        $this->phpMorphy = $phpMorphy;
    }

    public function create(int $positionInString, string $word): Word
    {
        $prepareWord = $this->prepareStringForPhpMorphy($word);

        $baseFormsWord = $this->phpMorphy->getBaseForm($prepareWord);

        return new Word($positionInString, $word, $baseFormsWord);
    }

    private function prepareStringForPhpMorphy(string $prepareString): string
    {
        $prepareString = self::replaceDoubleQuotesAndBackslashToEmptyString($prepareString);

        return self::stringToUpper($prepareString);
    }

    private static function replaceDoubleQuotesAndBackslashToEmptyString(string $string): string
    {
        return (string) preg_replace('/\\\\|"/', '', $string);
    }

    private static function stringToUpper(string $string): string
    {
        return mb_strtoupper($string);
    }
}
