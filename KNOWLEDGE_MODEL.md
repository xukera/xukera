# NODEX Knowledge Model

## Motto

La conoscenza non si archivia. Si collega.

## Principio centrale

NODEX rappresenta la conoscenza attraverso Nodi e Relazioni.

Un Nodo descrive una entità.
Una Relazione descrive un legame tra due entità.

## Node

Un Node è una entità della conoscenza.

Esempi di Node:

- Persona
- Luogo
- Villa
- Documento
- Libro
- Evento
- Reperto
- Fotografia
- Leggenda
- Dossier

Ogni Node possiede:

- id tecnico
- codice umano
- type
- title
- slug
- description
- metadata
- createdAt
- updatedAt

## Relation

Una Relation collega due Node.

Esempio:

Napoleone
ha soggiornato a
Villa Pisani

La Relation non è un semplice link.
È una informazione storica.

Ogni Relation possiede:

- id tecnico
- sourceNode
- targetNode
- type
- label
- metadata
- confidence
- source
- createdAt
- updatedAt

## Graph

Un Graph è l’insieme dei Node e delle Relation.

NODEX non costruisce pagine.
NODEX costruisce un grafo della conoscenza.

## Domain

Un Domain è un’area della conoscenza che usa il Core di NODEX.

Esempi:

- Dossier
- Ville
- Luoghi
- Personaggi
- Documenti
- Reperti
- Bibliografia
- Timeline
- Mappa
- Confraternita

Il Core non conosce i Domain.
I Domain usano il Core.

## Regola fondamentale

Il Node non deve contenere direttamente le Relation.

Le Relation vivono come entità indipendenti.

Questo permette di collegare qualsiasi Node a qualsiasi altro Node
senza duplicare informazioni.

## Esempio

Villa Pisani è un Node.

Napoleone è un Node.

Il soggiorno di Napoleone a Villa Pisani è una Relation.

## Visione

NODEX non è un archivio di pagine.

NODEX è una memoria digitale composta da conoscenze collegate.