<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class MultipleSpacesToSingleSpaceFilter
{
    public function __invoke(string $string): string
    {
        return (string) preg_replace('/ {2,}/', ' ', $string);
    }
}
