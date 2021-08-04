<?php

namespace Morphy\FuzzyKeywordSearch\Word\Factory;

use Morphy\FuzzyKeywordSearch\Word\WordCollection;

class WordCollectionFactory
{
    public function __construct(private WordsParser $wordsParser, private WordFactory $wordFactory)
    {
    }

    public function createFromString(string $string): WordCollection
    {
        $originalWords = $this->wordsParser->parseFromString($string);

        $words = [];

        foreach ($originalWords as $positionInString => $word) {
            $words[] = $this->wordFactory->create($positionInString, $word);
        }

        return new WordCollection($words);
    }
}
