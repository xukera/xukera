<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Kernel di XUKERA.
 *
 * Coordina l'avvio dell'intero framework.
 */
final class Kernel
{
    private string $basePath;

    private Registry $registry;

    private Loader $loader;

    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '/');

        $this->registry = new Registry();

        $this->loader = new Loader($this->basePath);

        $this->registry->set(Registry::class, $this->registry);
        $this->registry->set(Loader::class, $this->loader);
    }

    /**
     * Restituisce il registry dei servizi.
     */
    public function registry(): Registry
    {
        return $this->registry;
    }

    /**
     * Avvia XUKERA.
     */
    public function boot(): void
    {
        $this->loader->load();
    }
}