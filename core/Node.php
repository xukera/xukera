<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Nodo base di XUKERA.
 *
 * Rappresenta una entità minima
 * della conoscenza.
 */
final class Node
{
    private string $id;

    private string $type;

    private string $title;

    private array $metadata = [];

    public function __construct(
        string $id,
        string $type,
        string $title,
        array $metadata = []
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
        $this->metadata = $metadata;
    }

    /**
     * Restituisce l'identificatore del nodo.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Restituisce il tipo del nodo.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Restituisce il titolo del nodo.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Restituisce i metadati del nodo.
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }
}