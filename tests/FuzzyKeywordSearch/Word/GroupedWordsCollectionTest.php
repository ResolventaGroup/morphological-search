<?php

namespace FuzzyKeywordSearch\Word;

use Morphy\FuzzyKeywordSearch\Word\GroupedWordsCollection;
use Morphy\FuzzyKeywordSearch\Word\Word;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;
use PHPUnit\Framework\TestCase;

class GroupedWordsCollectionTest extends TestCase
{
    public function testFilterContainingAllWords(): void
    {
        $expectedWordCollection = new WordCollection([new Word(5, 'or', ['or']), new Word(4, 'not', ['not'])]);

        $groupedWordCollection = new GroupedWordsCollection([
            new WordCollection([new Word(1, 'to', ['to']), new Word(2, 'do', ['do'])]),
            $expectedWordCollection,
            new WordCollection([new Word(7, 'to', ['to']), new Word(3, 'run', ['run'])]),
        ]);

        $filteredGroupedWordCollection = $groupedWordCollection->filterContainingAllWords($expectedWordCollection);

        $this->assertCount(1, $filteredGroupedWordCollection);
    }
}
