<?php

namespace Morphy\FuzzyKeywordSearch;

use Morphy\FuzzyKeywordSearch\Analyzer\PresenceGroupsWordsInStringAnalyzer;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;

class FuzzyKeywordSearcher
{
    private $presenceGroupsWordsInStringAnalyzer;

    public function __construct(PresenceGroupsWordsInStringAnalyzer $presenceGroupsWordsInStringAnalyzer)
    {
        $this->presenceGroupsWordsInStringAnalyzer = $presenceGroupsWordsInStringAnalyzer;
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
