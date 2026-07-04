<?php

declare(strict_types=1);

namespace Xukera\Core;

use Xukera\Providers\GraphProvider;
use Xukera\Query\QueryBuilder;
use Xukera\Query\QueryEngine;

/**
 * XUKERA Knowledge Operating System.
 *
 * La conoscenza non si archivia.
 * Si collega.
 */
final class Xukera
{
    public const VERSION = '0.1.0';

    private Kernel $kernel;

    private Graph $graph;

    public function __construct(string $basePath)
    {
        $this->kernel = new Kernel($basePath);
        $this->graph = new Graph();
    }

    public function kernel(): Kernel
    {
        return $this->kernel;
    }

    public function registry(): Registry
    {
        return $this->kernel->registry();
    }

    public function graph(): Graph
    {
        return $this->graph;
    }

    public function version(): string
    {
        return self::VERSION;
    }

    public function query(): QueryBuilder
    {
        $provider = new GraphProvider($this->graph);
        $engine = new QueryEngine($provider);

        return new QueryBuilder($engine);
    }

    public function boot(): void
    {
        $this->kernel->boot();

        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('XUKERA ' . self::VERSION . ' avviato.');
        }
    }
}