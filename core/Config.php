<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Gestione della configurazione di Xukera.
 *
 * Questa classe rappresenta il punto centrale
 * per leggere e scrivere le impostazioni
 * del framework.
 */
final class Config
{
    /**
     * Tutte le configurazioni del framework.
     */
    private array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }
}