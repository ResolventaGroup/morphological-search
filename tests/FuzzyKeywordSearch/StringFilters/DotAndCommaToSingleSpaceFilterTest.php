<?php

namespace Tests\FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\DotAndCommaToSingleSpaceFilter;
use PHPUnit\Framework\TestCase;

class DotAndCommaToSingleSpaceFilterTest extends TestCase
{
    /**
     * @dataProvider texts
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText): void
    {
        $filter = new DotAndCommaToSingleSpaceFilter();

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'Lorem ipsum',
            'Lorem ipsum',
        ];

        yield [
            'Lorem  ipsum',
            'Lorem. ipsum',
        ];

        yield [
            'Lorem  ipsum',
            'Lorem, ipsum',
        ];

        yield [
            'Lorem  ipsum ',
            'Lorem. ipsum,',
        ];
    }
}
