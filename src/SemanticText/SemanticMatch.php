<?php

namespace Morphy\SemanticText;

class SemanticMatch
{
    public function __construct(public SemanticObjectInterface $semanticObject, public string $matchedKeyword)
    {
    }
}
