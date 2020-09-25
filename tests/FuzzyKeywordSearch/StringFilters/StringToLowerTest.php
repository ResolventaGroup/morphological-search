<?php

namespace FuzzyKeywordSearch\StringFilters;

use Generator;
use Morphy\FuzzyKeywordSearch\StringFilters\StringToLower;
use PHPUnit\Framework\TestCase;

class StringToLowerTest extends TestCase
{
    /**
     * @dataProvider texts
     */
    public function testFilterOnTextWithoutTags(string $expectedText, string $sourceText): void
    {
        $filter = new StringToLower();

        $this->assertEquals($expectedText, $filter($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            'lorem ipsum',
            'lorem ipsum',
        ];

        yield [
            'lorem ipsum',
            'Lorem Ipsum',
        ];

        yield [
            'lorem ipsum',
            'LOREM IPSUM',
        ];

        yield [
            'lorem ipsum',
            'LOrem IpsUM',
        ];
    }
}
