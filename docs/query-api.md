# XUKERA Query API

## Obiettivo

Il Query Builder permette di interrogare il grafo della conoscenza in modo leggibile e concatenabile.

Esempio:

$xukera
    ->query()
    ->type('villa')
    ->where('comune', '=', 'Stra')
    ->get();

---

## Query

### query(): QueryBuilder

Restituisce un nuovo QueryBuilder collegato al grafo principale.

---

## QueryBuilder

### type(string $type): self

Filtra i Node per tipo.

Esempio:

type('villa')

---

### titleContains(string $text): self

Filtra i Node il cui titolo contiene il testo indicato.

Esempio:

titleContains('Pisani')

---

### where(string $key, string $operator, mixed $value): self

Filtra i Node in base ai metadati.

Operatori iniziali supportati:

- =
- !=

Esempio:

where('comune', '=', 'Stra')

---

### relatedTo(Node $node): self

Filtra i Node collegati al Node indicato.

Esempio:

relatedTo($villaPisani)

---

### limit(int $limit): self

Limita il numero di risultati.

---

### get(): QueryResult

Esegue la query e restituisce un QueryResult.

---

## QueryResult

### count(): int

Restituisce il numero di risultati.

---

### first(): ?Node

Restituisce il primo Node trovato.

---

### toArray(): array

Restituisce i risultati come array di Node.