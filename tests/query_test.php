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

$results = Query::create($graph)
    ->whereType('luogo')
    ->whereMetadata('comune', 'Mira')
    ->get();

echo "Risultati trovati: " . count($results) . PHP_EOL;

foreach ($results as $node) {
    echo "- " . $node->getId() . " / " . $node->getType() . " / " . $node->getTitle() . PHP_EOL;
}
