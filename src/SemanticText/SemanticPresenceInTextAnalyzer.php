<?php

namespace Morphy\SemanticText;

use Morphy\FuzzyKeywordSearch\FuzzyKeywordSearcher;
use Morphy\FuzzyKeywordSearch\Word\Factory\WordCollectionFactory;
use Morphy\FuzzyKeywordSearch\Word\WordCollection;
use Psr\SimpleCache\CacheInterface;

class SemanticPresenceInTextAnalyzer
{
    public function __construct(
        private FuzzyKeywordSearcher $fuzzyKeywordSearchService,
        private WordCollectionFactory $wordCollectionFactory,
        private SemanticObjectRepositoryInterface $semanticObjectRepository,
        private CacheInterface $cache,
        private array $cacheSettings
    ) {
        if (!isset($cacheSettings['ttl']) || !isset($cacheSettings['key'])) {
            throw new \RuntimeException('Cache setting dont have key or ttl data');
        }
    }

    /**
     * @return SemanticMatch[]
     */
    public function analyzeText(string $text): array
    {
        $originalWords = $this->wordCollectionFactory->createFromString($text);

        $foundCombinationsWordsSemanticMatches = [];

        foreach ($this->cachedDataIterator() as $semanticModelCacheData) {
            [$semanticModel, $searchWords] = $semanticModelCacheData;

            $foundSimilarKeyword = $this->findSemanticWordInText($originalWords, $searchWords);

            if (empty($foundSimilarKeyword)) {
                continue;
            }

            if ($this->isHaveAdvancedSemanticObject($semanticModel, $foundCombinationsWordsSemanticMatches)) {
                continue;
            }

            $foundCombinationsWordsSemanticMatches[] = new SemanticMatch($semanticModel, $foundSimilarKeyword);
        }

        return $foundCombinationsWordsSemanticMatches;
    }

    private function cachedDataIterator()
    {
        if ($this->cache->has($this->cacheSettings['key'])) {
            return $this->cache->get($this->cacheSettings['key']);
        }

        $data = [];

        foreach ($this->semanticObjectRepository->findAllForSemanticAnalyze() as $semanticModel) {
            $data[$semanticModel->getIdentifier()] = [
                new CachedSemanticObject($semanticModel->getIdentifier(), $semanticModel->getText()),
                $this->wordCollectionFactory->createFromString($semanticModel->getText()),
            ];
        }

        $this->cache->set($this->cacheSettings['key'], $data, $this->cacheSettings['ttl']);

        return $data;
    }

    private function findSemanticWordInText(WordCollection $originalWords, WordCollection $searchWords): string
    {
        return $this->fuzzyKeywordSearchService->searchKeywordInSourceString(
            $originalWords,
            $searchWords
        );
    }

    /**
     * @param SemanticMatch[] $foundCombinationsWordsSemanticMatches
     */
    private function isHaveAdvancedSemanticObject(SemanticObjectInterface $semanticObject, iterable $foundCombinationsWordsSemanticMatches): bool
    {
        foreach ($foundCombinationsWordsSemanticMatches as $foundCombinationsWordsSemanticMatch) {
            if ($foundCombinationsWordsSemanticMatch->semanticObject->getIdentifier() === $semanticObject->getIdentifier()) {
                return true;
            }
        }

        return false;
    }
}
