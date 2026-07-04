# XUKERA Core API

## Xukera

### graph()

Restituisce il Graph principale del Knowledge Engine.

---

## Graph

### addNode(Node $node): void

Aggiunge un Node al grafo.

### getNode(string $id): ?Node

Restituisce un Node tramite il suo identificativo.

### addRelation(Relation $relation): void

Aggiunge una Relation al grafo.

### getRelations(): array

Restituisce tutte le Relation.

### neighbors(Node $node): array

Restituisce tutti i Node collegati al Node indicato.

### findByType(string $type): array

Restituisce tutti i Node appartenenti al tipo indicato.

Esempi:

findByType('villa')

findByType('persona')

findByType('documento')

### findByMetadata(string $key, mixed $value): array

Restituisce tutti i Node che possiedono un metadato con la chiave e il valore indicati.

Esempi:

findByMetadata('comune', 'Stra')

findByMetadata('provincia', 'Venezia')

---

## Node

### getId(): string

### getType(): string

### getTitle(): string

### getMetadata(): array

---

## Relation

### getId(): string

### getSource(): Node

### getTarget(): Node

### getType(): string

### getMetadata(): array

### search(string $query): array

Cerca Node nel grafo usando titolo, tipo e metadati.

Esempi:

search('Napoleone')

search('Villa')

search('Stra')