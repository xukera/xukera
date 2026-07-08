<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/Node.php';
require_once __DIR__ . '/../core/Relation.php';
require_once __DIR__ . '/../core/Graph.php';

use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Relation;

$graph = new Graph();

$angelo = new Node('angelo', 'person', 'Angelo');
$villa = new Node('villa-pisani', 'place', 'Villa Pisani');

$graph->addNode($angelo);
$graph->addNode($villa);

$graph->addRelation(
    new Relation('r1', $angelo, 'visited', $villa)
);

echo "Nodes: " . $graph->countNodes() . PHP_EOL;
echo "Relations: " . $graph->countRelations() . PHP_EOL;

foreach ($graph->neighbors($angelo) as $neighbor) {
    echo "Neighbor of Angelo: " . $neighbor->getTitle() . PHP_EOL;
}
