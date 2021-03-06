<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class DotAndCommaToSingleSpaceFilter
{
    public function __invoke(string $string): string
    {
        return (string) preg_replace('/\.|,/', ' ', $string);
    }
}
