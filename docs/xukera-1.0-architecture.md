# Xukera 1.0 Architecture

## 1. Visione

Xukera è un framework universale per la gestione della conoscenza.

Non è un CMS.  
Non è un plugin WordPress.  
Non è un database grafico completo.  
Non è un'applicazione verticale.

Xukera è un motore modulare capace di rappresentare entità, relazioni, metadati, percorsi, interrogazioni e, in futuro, inferenze.

## 2. Principio fondamentale

Xukera deve rimanere indipendente da qualunque dominio applicativo.

Tutto ciò che riguarda un progetto specifico deve vivere fuori dal Core.

Esempi:

- Custodi Archivio
- applicazioni museali
- archivi storici
- sistemi documentali
- IoT
- CubeSat
- domotica
- applicazioni aziendali

Xukera fornisce il motore.  
Le applicazioni forniscono il significato specifico.

## 3. Distinzione tra Core e Applicazioni

### Xukera Core risponde a domande come:

- Quali nodi sono collegati a questo nodo?
- Quali relazioni esistono tra due entità?
- Esiste un percorso tra due nodi?
- Quali nodi hanno un certo tipo?
- Quali nodi hanno un certo metadato?

### Le applicazioni rispondono a domande come:

- Apri il dossier DOSS-RDB-001.
- Mostra la cartella investigativa.
- Visualizza la timeline di un caso.
- Pubblica un contenuto su WordPress.
- Gestisci utenti e permessi.

## 4. Moduli principali

### Core

Contiene le astrazioni fondamentali:

- Node
- Relation
- Graph
- Query
- Storage

### Query Engine

Gestisce l'interrogazione del grafo:

- filtri
- attraversamento
- incoming
- outgoing
- neighbors
- path finding
- future espressioni avanzate

### Storage

Gestisce persistenza e recupero:

- memoria
- JSON
- file system
- database
- adapter esterni

### Serializer

Converte il grafo in formati esportabili:

- JSON
- YAML
- XML
- array PHP

### Validator

Verifica coerenza e integrità:

- nodi duplicati
- relazioni orfane
- metadati obbligatori
- tipi non validi

### Events

Permette di reagire agli eventi del sistema:

- node.created
- relation.created
- graph.loaded
- query.executed

### Plugin System

Permette di estendere Xukera senza modificare il Core.

### API

Espone Xukera verso applicazioni esterne.

### CLI

Permette di usare Xukera da terminale.

### AI Layer

In futuro permetterà interrogazioni semantiche, suggerimenti e inferenze sul grafo.

## 5. Regole architetturali

### 5.1 Nessun dominio applicativo nel Core

Il Core non deve contenere riferimenti a:

- Custodi del Doge
- dossier
- WordPress
- ville specifiche
- personaggi storici specifici
- interfacce grafiche
- temi o template

### 5.2 Ogni classe deve avere una responsabilità chiara

Una classe deve fare una cosa sola e farla bene.

### 5.3 Le API pubbliche devono essere semplici

Il codice utente deve essere leggibile.

Esempio:

```php
Query::create($graph)
    ->whereType('luogo')
    ->whereMetadata('comune', 'Mira')
    ->get();
