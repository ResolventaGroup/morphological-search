<?php

namespace FuzzyKeywordSearch\Word\Factory;

use Generator;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordsParser;
use PHPUnit\Framework\TestCase;

class WordsParserTest extends TestCase
{
    /**
     * @dataProvider texts
     *
     * @param callable[] $filters
     */
    public function testFilterOnTextWithoutTags(array $expectedWords, string $sourceText, array $filters): void
    {
        $wordsParser = new WordsParser($filters);

        $this->assertEquals($expectedWords, $wordsParser->parseFromString($sourceText));
    }

    public static function texts(): Generator
    {
        yield [
            ['Lorem', 'ipsum', 'dolor', 'sit', 'amet'],
            'Lorem ipsum dolor sit amet',
            [],
        ];

        yield [
            ['Lorem', 'ipsum', 'dolor', 'sit', 'amet'],
            ' Lorem ipsum dolor sit amet ',
            [
                'trim'
            ],
        ];

        yield [
            ['Lorem', 'ipsum', 'dolor', 'sit', 'amet'],
            'Lorem   ipsum dolor   sit  amet',
            [],
        ];
    }
}
