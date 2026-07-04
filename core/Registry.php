<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Registry dei servizi di XUKERA.
 *
 * Conserva e rende disponibili
 * gli oggetti condivisi del framework.
 */
final class Registry
{
    /**
     * Servizi registrati.
     */
    private array $items = [];

    /**
     * Registra un servizio.
     */
    public function set(string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * Restituisce un servizio registrato.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    /**
     * Verifica se un servizio esiste.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Rimuove un servizio registrato.
     */
    public function remove(string $key): void
    {
        unset($this->items[$key]);
    }
}