<?php

declare(strict_types=1);

namespace Xukera\Query;

use Xukera\Contracts\KnowledgeProvider;

/**
 * Motore di esecuzione delle query.
 *
 * Riceve un QueryBuilder e delega
 * l'esecuzione al KnowledgeProvider.
 */
final class QueryEngine
{
    public function __construct(
        private KnowledgeProvider $provider
    ) {
    }

    /**
     * Esegue una query.
     */
    public function execute(
        QueryBuilder $builder
    ): QueryResult {
        return $this->provider->query($builder);
    }
}