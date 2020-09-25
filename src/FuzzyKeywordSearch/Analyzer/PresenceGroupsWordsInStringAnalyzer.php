<?php

namespace Morphy\FuzzyKeywordSearch\Analyzer;

use Morphy\FuzzyKeywordSearch\Word\GroupedWordsCollection;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;

class PresenceGroupsWordsInStringAnalyzer
{
    public function analyze(GroupedWordsCollection $groupsWords, string $originalString): string
    {
        /** @var WordCollection $groupWords */
        foreach ($groupsWords as $groupWords) {
            $similarString = (string) $groupWords;

            $numberOccurrencesStringFound = preg_match_all(
                self::createRegexFindSubstringInStringPatternWithSkipUrlHtmlTag($similarString),
                $originalString
            );

            if ($numberOccurrencesStringFound > 0) {
                return $similarString;
            }
        }

        return '';
    }

    private static function createRegexFindSubstringInStringPatternWithSkipUrlHtmlTag(string $text): string
    {
        return "#".preg_quote($text, '/').'#';
    }
}
