<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class StringToLower
{
    public function __invoke(string $string): string
    {
        return mb_strtolower($string);
    }
}
