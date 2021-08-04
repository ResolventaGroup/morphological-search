<?php

namespace Morphy\FuzzyKeywordSearch\Word;

final class Word
{
    private const POSITION_PREVIOUS_WORD = -1;
    private const POSITION_NEXT_WORD = 1;

    public function __construct(public int $positionInString, public string $originalForm, public array $baseForm)
    {
    }

    public function isNear(Word $word): bool
    {
        return in_array($word->positionInString - $this->positionInString, [self::POSITION_PREVIOUS_WORD, self::POSITION_NEXT_WORD]);
    }
}
