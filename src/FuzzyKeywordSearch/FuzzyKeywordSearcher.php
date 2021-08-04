<?php

namespace Morphy\FuzzyKeywordSearch;

use Morphy\FuzzyKeywordSearch\Analyzer\PresenceGroupsWordsInStringAnalyzer;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;

class FuzzyKeywordSearcher
{
    public function __construct(private PresenceGroupsWordsInStringAnalyzer $presenceGroupsWordsInStringAnalyzer)
    {
    }

    public function searchKeywordInSourceString(WordCollection $sourceWords, WordCollection $searchWords): string
    {
        $foundIdenticalWords = $sourceWords->intersect($searchWords);

        if (count($foundIdenticalWords) < count($searchWords)) {
            return '';
        }

        $foundGroupsWords = $foundIdenticalWords
            ->groupByAdjacentWords($searchWords->count())
            ->filterContainingAllWords($searchWords);

        return $this->presenceGroupsWordsInStringAnalyzer->analyze($foundGroupsWords, (string) $sourceWords);
    }
}
