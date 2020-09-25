<?php

namespace FuzzyKeywordSearch\Word;

use Morphy\FuzzyKeywordSearch\Word\GroupedWordsCollection;
use Morphy\FuzzyKeywordSearch\Word\Word;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;
use PHPUnit\Framework\TestCase;

class WordCollectionTest extends TestCase
{
    public function testConstructorWithInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new WordCollection(['string']);
    }

    public function testConstructorWithValidArgument(): void
    {
        $collection = new WordCollection([new Word(1, 'word', ['word'])]);

        $this->assertCount(1, $collection);
    }

    public function testContainsWordOnCollectionByBaseWordForm(): void
    {
        $collection = new WordCollection([new Word(1, 'originalWord', ['baseWord'])]);

        $this->assertTrue($collection->containsWord(new Word(1, 'word', ['baseWord'])));
    }

    public function testContainsWordOnCollectionByOriginalWordForm(): void
    {
        $collection = new WordCollection([new Word(1, 'originalWord', ['baseWord'])]);

        $this->assertTrue($collection->containsWord(new Word(1, 'originalWord', ['word'])));
    }

    public function testContainsWordOnCollectionWithoutWordsWithOriginalOrBaseForms(): void
    {
        $collection = new WordCollection([new Word(1, 'originalWord', ['baseWord'])]);

        $this->assertFalse($collection->containsWord(new Word(1, 'word', ['word'])));
    }

    public function testFullContainsWordsFromOneCollectionInAnother(): void
    {
        $collection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'secondOriginalWord', ['secondBaseWord']),
            new Word(1, 'thirdsOriginalWord', ['thirdsBaseWord']),
        ]);
        $otherCollection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'thirdsOriginalWord', ['thirdsBaseWord']),
        ]);

        $this->assertTrue($collection->containsWords($otherCollection));
    }

    public function testPartialContainsWordsFromOneCollectionInAnother(): void
    {
        $collection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'secondOriginalWord', ['secondBaseWord']),
            new Word(1, 'thirdsOriginalWord', ['thirdsBaseWord']),
        ]);
        $otherCollection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'anotherOriginalWord', ['anotherBaseWord']),
        ]);

        $this->assertFalse($collection->containsWords($otherCollection));
    }

    public function testIntersectCollections(): void
    {
        $collection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'secondOriginalWord', ['secondBaseWord']),
            new Word(1, 'thirdsOriginalWord', ['thirdsBaseWord']),
        ]);
        $otherCollection = new WordCollection([
            new Word(1, 'firstOriginalWord', ['firstBaseWord']),
            new Word(1, 'thirdsOriginalWord', ['thirdsBaseWord']),
        ]);

        $intersectCollection = $collection->intersect($otherCollection);

        $this->assertCount(2, $intersectCollection);
    }

    public function testGroupByAdjacentWords(): void
    {
        $collection = new WordCollection([
            new Word(1, 'to', ['to']),
            new Word(2, 'be', ['be']),
            new Word(3, 'or', ['or']),
            new Word(4, 'not', ['not']),
            new Word(5, 'to', ['to']),
            new Word(6, 'be', ['be']),
        ]);

        $groupedWordsCollection = $collection->groupByAdjacentWords(3);

        $this->assertInstanceOf(GroupedWordsCollection::class, $groupedWordsCollection);
        $this->assertCount(4, $groupedWordsCollection);

        foreach($groupedWordsCollection as $wordCollection) {
            $this->assertCount(3, $wordCollection);
        }
    }

    public function testToStringConvert(): void
    {
        $collection = new WordCollection([
            new Word(1, 'to', ['to']),
            new Word(2, 'be', ['be']),
            new Word(3, 'or', ['or']),
            new Word(4, 'not', ['not']),
            new Word(5, 'to', ['to']),
            new Word(6, 'be', ['be']),
        ]);

        $this->assertEquals('to be or not to be', (string) $collection);
    }

    public function testArrayMethods(): void
    {
        $expected = new Word(3, 'or', ['or']);

        $collection = new WordCollection([
            new Word(1, 'to', ['to']),
            new Word(2, 'be', ['be']),
            $expected,
            new Word(4, 'not', ['not']),
            new Word(5, 'to', ['to']),
            new Word(6, 'be', ['be']),
        ]);

        $this->assertEquals($expected, $collection->get(2));
        $this->assertEquals(2, $collection->indexOf($expected));
        $this->assertCount(6, $collection);
    }
}
