<?php

namespace Morphy\SemanticText;

class CachedSemanticObject implements SemanticObjectInterface
{
    public function __construct(private $identifier, private string $text)
    {
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
