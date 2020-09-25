<?php

namespace Tests\FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\HtmlLineBreaksToSingleBreakFilter;
use PHPUnit\Framework\TestCase;

class HtmlLineBreaksToSingleBreakFilterTest extends TestCase
{
    /**
     * @dataProvider texts
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText): void
    {
        $filter = new HtmlLineBreaksToSingleBreakFilter();

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'Lorem ipsum',
            'Lorem ipsum',
        ];

        yield [
            "Lorem\nipsum",
            'Lorem<br>ipsum',
        ];

        yield [
            "Lorem\nipsum",
            'Lorem<br/>ipsum',
        ];

        yield [
            "Lorem\nipsum",
            'Lorem<br />ipsum',
        ];
    }
}
