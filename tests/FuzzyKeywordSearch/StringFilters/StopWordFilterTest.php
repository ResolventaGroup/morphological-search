<?php

namespace Tests\FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\StopWordFilter;
use PHPUnit\Framework\TestCase;

class StopWordFilterTest extends TestCase
{
    /**
     * @dataProvider texts
     *
     * @param string[] $stopWords
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText, array $stopWords): void
    {
        $filter = new StopWordFilter($stopWords);

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'Lorem ipsum',
            'Lorem ipsum',
            [],
        ];

        yield [
            'Lorem   ipsum',
            'Lorem fully ipsum',
            ['fully'],
        ];

        yield [
            ' onetic Al abet',
            'Phonetic Alphabet',
            ['ph'],
        ];
    }
}
