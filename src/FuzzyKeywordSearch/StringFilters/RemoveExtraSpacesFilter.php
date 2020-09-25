<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class RemoveExtraSpacesFilter
{
    public function __invoke(string $string): string
    {
        return trim($string, ' ');
    }
}
