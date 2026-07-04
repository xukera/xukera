# XUKERA Query Engine

## Obiettivo

Il Query Engine permette di interrogare la conoscenza senza conoscere il modo in cui i dati sono memorizzati.

Una query deve descrivere una richiesta.

Non deve sapere se i dati arrivano da:

- Graph in memoria
- Database
- JSON
- WordPress
- API esterne
- Motore AI

---

## Principio fondamentale

Il QueryBuilder costruisce la richiesta.

Il Query Engine la interpreta.

Il Knowledge Provider recupera i dati.

Il QueryResult restituisce i risultati.

---

## Flusso

Xukera
↓
QueryBuilder
↓
Query Engine
↓
Knowledge Provider
↓
Graph / Storage / API
↓
QueryResult

---

## Componenti

### QueryBuilder

Responsabilità:

- raccogliere i filtri
- definire il tipo richiesto
- definire il limite
- descrivere la query

Non deve recuperare dati.

---

### Query

Responsabilità:

- eseguire una query costruita dal QueryBuilder
- interrogare il provider
- restituire un QueryResult

---

### QueryResult

Responsabilità:

- contenere i Node trovati
- offrire metodi di accesso semplici
- evitare array grezzi nell'API pubblica

---

### Knowledge Provider

Responsabilità:

- fornire dati al Query Engine
- nascondere la sorgente reale dei dati

Esempi futuri:

- GraphProvider
- WordPressProvider
- JsonProvider
- DatabaseProvider
- AiProvider

---

## Esempio desiderato

```php
$result = $xukera
    ->query()
    ->type('villa')
    ->where('comune', '=', 'Stra')
    ->limit(10)
    ->get();