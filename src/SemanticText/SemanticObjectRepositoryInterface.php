<?php

namespace Morphy\SemanticText;

interface SemanticObjectRepositoryInterface
{
    /**
     * @return SemanticObjectInterface[]
     */
    public function findAllForSemanticAnalyze(): iterable;
}
