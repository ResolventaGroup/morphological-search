<?php

namespace Morphy\SemanticText;

class SemanticMatch
{
    public $semanticObject;
    public $matchedKeyword;

    public function __construct(SemanticObjectInterface $semanticObject, string $matchedKeyword)
    {
        $this->semanticObject = $semanticObject;
        $this->matchedKeyword = $matchedKeyword;
    }
}
