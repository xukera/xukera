# NODEX Decisions

## Decisione 001 — Separazione tra Core, Knowledge Engine e Modules

NODEX viene organizzato in tre livelli principali:

1. Core
   Contiene i servizi fondamentali del framework.

2. Knowledge Engine
   Contiene il modello della conoscenza: Node, Relation, Graph, NodeType e Metadata.

3. Modules
   Contiene le applicazioni costruite sopra il Knowledge Engine, come Dossier, Ville, Personaggi e Documenti.

Motivazione:

Il Core deve rimanere piccolo, stabile e indipendente.
Il Knowledge Engine rappresenta la vera identità di NODEX.
I Modules possono crescere senza modificare il Core.
## Decisione 002 — Il linguaggio della conoscenza

NODEX modella la conoscenza attraverso due elementi fondamentali:

* Node (sostantivi)
* Relation (verbi)

I Node rappresentano le entità della conoscenza.

Le Relation rappresentano le azioni o i legami tra le entità.

Il Graph rappresenta l'insieme delle connessioni.

I Domain estendono il vocabolario della conoscenza aggiungendo nuovi tipi di Node e nuovi tipi di Relation.

Principio fondamentale:

La conoscenza non è un insieme di record.

È un linguaggio composto da sostantivi e verbi.
## Decisione 003 — La Centrale Operativa usa solo NODEX

La Centrale Operativa dei Custodi del Doge non accede mai direttamente ai dati.

Ogni schermata, widget o funzione deve comunicare con il sistema attraverso NODEX Knowledge Engine.

Flusso previsto:

Dashboard
↓
Widget
↓
NODEX API
↓
Graph
↓
Node / Relation
↓
Storage

Motivazione:

La UI deve rimanere separata dal motore.
In questo modo NODEX potrà essere riutilizzato anche fuori da WordPress.
## Decisione 004 — Navigazione bidirezionale del Graph

Il metodo `neighbors()` considera le relazioni come navigabili in entrambe le direzioni.

Se esiste una Relation:

A
↓
tipo
↓
B

allora:

- A vede B come nodo collegato
- B vede A come nodo collegato

Il verso della Relation viene preservato nei dati, ma la navigazione del Graph è bidirezionale.

Motivazione:

Nella Centrale Operativa dei Custodi del Doge, quando un Custode apre una scheda, deve vedere tutti gli elementi collegati, indipendentemente dal verso tecnico della Relation.