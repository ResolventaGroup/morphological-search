<?php

namespace FuzzyKeywordSearch\Word\Factory;

use Morphy\FuzzyKeywordSearch\Word\Factory\WordFactory;
use Morphy\FuzzyKeywordSearch\Word\Word;
use phpMorphy;
use PHPUnit\Framework\TestCase;

class WordFactoryTest extends TestCase
{
    public function testWordFactoryCreate(): void
    {
        $wordFactory = new WordFactory($this->createPhpMorphy());

        $word = $wordFactory->create(1, 'word');

        $this->assertInstanceOf(Word::class, $word);
        $this->assertEquals(1, $word->positionInString);
        $this->assertEquals('word', $word->originalForm);
        $this->assertEquals(['baseForm'], $word->baseForm);
    }

    private function createPhpMorphy(): phpMorphy
    {
        $mock = $this->createMock(phpMorphy::class);
        $mock->method('getBaseForm')
            ->willReturn(['baseForm']);

        return $mock;
    }
}
