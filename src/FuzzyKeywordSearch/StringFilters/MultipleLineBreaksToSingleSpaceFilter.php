<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class MultipleLineBreaksToSingleSpaceFilter
{
    public function __invoke(string $string): string
    {
        return (string) preg_replace('/[!\n+?\-]/', ' ', $string);
    }
}
