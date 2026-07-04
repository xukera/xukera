<?php

declare(strict_types=1);

namespace Xukera\Core;

/**
 * Relazione tra due Node.
 *
 * Una Relation non è un semplice link:
 * rappresenta un fatto, un legame o un'azione
 * tra due entità della conoscenza.
 */
final class Relation
{
    private string $id;

    private Node $source;

    private Node $target;

    private string $type;

    private array $metadata = [];

    public function __construct(
        string $id,
        Node $source,
        string $type,
        Node $target,
        array $metadata = []
    ) {
        $this->id = $id;
        $this->source = $source;
        $this->type = $type;
        $this->target = $target;
        $this->metadata = $metadata;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSource(): Node
    {
        return $this->source;
    }

    public function getTarget(): Node
    {
        return $this->target;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }
}