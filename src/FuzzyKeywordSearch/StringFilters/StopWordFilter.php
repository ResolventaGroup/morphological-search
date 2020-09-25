<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class StopWordFilter
{
    private $stopWords;

    public function __construct(array $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    public function __invoke(string $string): string
    {
        return str_ireplace($this->stopWords, ' ', $string);
    }
}
