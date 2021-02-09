<?php

namespace Morphy\SemanticText;

interface SemanticObjectInterface
{
    public function getIdentifier();

    public function getText(): string;
}
