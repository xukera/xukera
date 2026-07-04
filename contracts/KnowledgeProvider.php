<?php

declare(strict_types=1);

namespace Xukera\Contracts;

use Xukera\Core\Node;
use Xukera\Query\QueryBuilder;
use Xukera\Query\QueryResult;

/**
 * Contratto per i provider di conoscenza.
 *
 * Un provider è responsabile di recuperare
 * Node da una sorgente dati.
 */
interface KnowledgeProvider
{
    /**
     * Esegue una query e restituisce un risultato.
     */
    public function query(QueryBuilder $builder): QueryResult;

    /**
     * Restituisce tutti i Node disponibili.
     *
     * @return Node[]
     */
    public function all(): array;
}