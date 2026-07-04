<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * XUKERA Autoloader
 *
 * Carica automaticamente tutte le classi
 * appartenenti al namespace Xukera.
 *
 * Struttura prevista:
 *
 * Xukera\Core\Graph
 * -> core/Graph.php
 *
 * Xukera\Domains\Dashboard\DashboardDomain
 * -> domains/Dashboard/DashboardDomain.php
 *
 * Xukera\Storage\JsonStorage
 * -> storage/JsonStorage.php
 */
final class Autoloader
{
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Registra l'autoloader.
     */
    public function register(): void
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * Carica automaticamente una classe.
     */
    private function load(string $class): void
    {
        $prefix = 'Xukera\\';

        if (!str_starts_with($class, $prefix)) {
            return;
        }

        // Rimuove il namespace principale
        $relative = substr($class, strlen($prefix));

        $parts = explode('\\', $relative);

        if (count($parts) < 2) {
            return;
        }

        /*
         * Core      -> core/
         * Domains   -> domains/
         * Storage   -> storage/
         * AI        -> ai/
         */
        $parts[0] = strtolower($parts[0]);

        $path = $this->basePath . '/' . implode('/', $parts) . '.php';

        if (is_file($path)) {
            require_once $path;
        }
    }
}