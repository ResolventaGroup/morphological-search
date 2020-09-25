<?php

namespace Morphy\FuzzyKeywordSearch\Word;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final class GroupedWordsCollection implements IteratorAggregate, Countable
{
    private $elements;

    public function __construct(array $elements = [])
    {
        self::assertInstanceOfWordCollection($elements);

        $this->elements = $elements;
    }

    public function filterContainingAllWords(WordCollection $searchWords): GroupedWordsCollection
    {
        $filteredElements = array_filter($this->elements, static function (WordCollection $sourceWords) use ($searchWords) {
            return $sourceWords->containsWords($searchWords);
        });

        return new self($filteredElements);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function count(): int
    {
        return count($this->elements);
    }

    private static function assertInstanceOfWordCollection(array $elements)
    {
        foreach ($elements as $element) {
            if (!$element instanceof WordCollection) {
                throw new \InvalidArgumentException();
            }
        }
    }
}
