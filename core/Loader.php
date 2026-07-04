<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Loader di Xukera.
 *
 * Ha il compito di caricare i componenti
 * e i moduli del framework.
 */
final class Loader
{
    /**
     * Percorso base del plugin.
     */
    private string $basePath;

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Carica i moduli attivi.
     */
    public function load(): void
    {
        // Qui caricheremo progressivamente:
        // Dashboard
        // Dossier
        // Assets
        // API
    }

    /**
     * Restituisce il percorso assoluto del plugin.
     */
    public function basePath(): string
    {
        return $this->basePath;
    }
}
