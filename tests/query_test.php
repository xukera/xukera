<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/Node.php';
require_once __DIR__ . '/../core/Relation.php';
require_once __DIR__ . '/../core/Graph.php';
require_once __DIR__ . '/../core/Query.php';

use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Query;

$graph = new Graph();

$villa = new Node('villa_widmann', 'luogo', 'Villa Widmann', [
    'comune' => 'Mira',
]);

$persona = new Node('dario', 'persona', 'Dario', [
    'ruolo' => 'custode',
]);

$graph->addNode($villa);
$graph->addNode($persona);

$relation = new \Xukera\Core\Relation(
    'rel_001',
    $persona,
    'visita',
    $villa
);

$graph->addRelation($relation);

$path = Query::create($graph)
    ->findPath('dario', 'villa_widmann');

echo "Percorso trovato: " . count($path) . " nodi" . PHP_EOL;

foreach ($path as $node) {
    echo "- " . $node->getTitle() . PHP_EOL;
}
