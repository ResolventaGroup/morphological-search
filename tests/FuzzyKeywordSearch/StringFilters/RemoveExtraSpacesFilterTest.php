<?php

namespace Tests\FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\RemoveExtraSpacesFilter;
use PHPUnit\Framework\TestCase;

class RemoveExtraSpacesFilterTest extends TestCase
{
    /**
     * @dataProvider texts
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText): void
    {
        $filter = new RemoveExtraSpacesFilter();

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'Lorem ipsum',
            ' Lorem ipsum',
        ];

        yield [
            'Lorem ipsum',
            'Lorem ipsum ',
        ];

        yield [
            'Lorem ipsum',
            '  Lorem ipsum',
        ];

        yield [
            'Lorem ipsum',
            'Lorem ipsum  ',
        ];

        yield [
            'Lorem ipsum',
            '  Lorem ipsum  ',
        ];
    }
}
