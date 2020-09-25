<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class StripTagsFilter
{
    public function __invoke(string $string): string
    {
        return strip_tags($string);
    }
}
