<?php

namespace Tests\FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\MultipleSpacesToSingleSpaceFilter;
use PHPUnit\Framework\TestCase;

class MultipleSpacesToSingleSpaceFilterTest extends TestCase
{
    /**
     * @dataProvider texts
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText): void
    {
        $filter = new MultipleSpacesToSingleSpaceFilter();

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'Lorem ipsum',
            'Lorem ipsum',
        ];

        yield [
            'Lorem ipsum',
            'Lorem  ipsum',
        ];

        yield [
            'Lorem ipsum',
            'Lorem   ipsum',
        ];
    }
}
