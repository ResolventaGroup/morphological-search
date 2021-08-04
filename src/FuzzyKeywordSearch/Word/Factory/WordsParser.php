<?php

namespace Morphy\FuzzyKeywordSearch\Word\Factory;

class WordsParser
{
    /**
     * @param callable[] $filters
     */
    public function __construct(private array $filters)
    {
        self::assertFilterIsCallable($filters);

        $this->filters = $filters;
    }

    /**
     * @return string[]
     */
    public function parseFromString(string $string): array
    {
        foreach ($this->filters as $filter) {
            $string = $filter($string);
        }

        $words = explode(' ', $string);

        return array_values(array_filter($words));
    }

    /**
     * @param callable[] $filters
     */
    private static function assertFilterIsCallable(array $filters): void
    {
        foreach ($filters as $filter) {
            if (!is_callable($filter)) {
                throw new \InvalidArgumentException('Filter should be callable');
            }
        }
    }
}
