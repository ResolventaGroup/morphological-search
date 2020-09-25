<?php

namespace FuzzyKeywordSearch\Word;

use Morphy\FuzzyKeywordSearch\Word\Word;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    /**
     * @dataProvider nearWords
     */
    public function testNearPosition(bool $expectedValue, Word $firstWord, Word $secondWord): void
    {
        $this->assertEquals($expectedValue, $firstWord->isNear($secondWord));
    }

    public function nearWords(): \Generator
    {
        yield [
            true,
            new Word(3, 'lorem', ['lorem']),
            new Word(2, 'ipsum', ['ipsum']),
        ];

        yield [
            true,
            new Word(3, 'lorem', ['lorem']),
            new Word(4, 'ipsum', ['ipsum']),
        ];

        yield [
            false,
            new Word(3, 'lorem', ['lorem']),
            new Word(1, 'ipsum', ['ipsum']),
        ];

        yield [
            false,
            new Word(3, 'lorem', ['lorem']),
            new Word(5, 'ipsum', ['ipsum']),
        ];
    }
}
