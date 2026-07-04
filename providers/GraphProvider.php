<?php

declare(strict_types=1);

namespace Xukera\Providers;

use Xukera\Contracts\KnowledgeProvider;
use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Query\QueryBuilder;
use Xukera\Query\QueryResult;

/**
 * Provider della conoscenza basato sul Graph.
 */
final class GraphProvider implements KnowledgeProvider
{
    public function __construct(
        private Graph $graph
    ) {
    }

    /**
     * @return Node[]
     */
    public function all(): array
    {
        return $this->graph->nodes();
    }

    public function query(QueryBuilder $builder): QueryResult
    {
        $nodes = $this->graph->nodes();

        if ($builder->getId() !== null) {
            $node = $this->graph->getNode($builder->getId());
            $nodes = $node !== null ? [$node] : [];
        }

        if ($builder->getRelatedTo() !== null) {
            $relatedIds = array_map(
                fn (Node $node): string => $node->getId(),
                $this->graph->neighbors($builder->getRelatedTo())
            );

            $nodes = array_filter(
                $nodes,
                fn (Node $node): bool => in_array($node->getId(), $relatedIds, true)
            );
        }

        if ($builder->getType() !== null) {
            $nodes = array_filter(
                $nodes,
                fn (Node $node): bool => $node->getType() === $builder->getType()
            );
        }

        foreach ($builder->getFilters() as $filter) {
            $nodes = array_filter(
                $nodes,
                fn (Node $node): bool => $this->matchesFilter($node, $filter)
            );
        }

        if ($builder->getLimit() !== null) {
            $nodes = array_slice($nodes, 0, $builder->getLimit());
        }

        return new QueryResult(array_values($nodes));
    }

    private function matchesFilter(Node $node, array $filter): bool
    {
        $metadata = $node->getMetadata();

        $key = $filter['key'];
        $operator = $filter['operator'];
        $value = $filter['value'];

        $actual = $metadata[$key] ?? null;

        return match ($operator) {
            '=' => $actual === $value,
            '!=' => $actual !== $value,
            default => false,
        };
    }
}