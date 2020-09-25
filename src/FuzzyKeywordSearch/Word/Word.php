<?php

namespace Morphy\FuzzyKeywordSearch\Word;

final class Word
{
    private const POSITION_PREVIOUS_WORD = -1;
    private const POSITION_NEXT_WORD = 1;

    public $positionInString;
    public $originalForm;
    public $baseForm;

    public function __construct(int $positionInString, string $originalForm, array $baseForm)
    {
        $this->positionInString = $positionInString;
        $this->originalForm = $originalForm;
        $this->baseForm = $baseForm;
    }

    public function isNear(Word $word): bool
    {
        return in_array($word->positionInString - $this->positionInString, [self::POSITION_PREVIOUS_WORD, self::POSITION_NEXT_WORD]);
    }
}
