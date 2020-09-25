<?php

namespace Morphy\FuzzyKeywordSearch\StringFilters;

class HtmlLineBreaksToSingleBreakFilter
{
    public function __invoke(string $string): string
    {
        return (string) preg_replace('/<br>|<br\/>|<br \/>/', "\n", $string);
    }
}
