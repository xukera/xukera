<?php

declare(strict_types=1);

namespace Xukera\Tests;

use PHPUnit\Framework\TestCase;
use Xukera\Core\Graph;
use Xukera\Core\Node;
use Xukera\Core\Validator;

final class ValidatorTest extends TestCase
{
    public function testValidGraphHasNoErrors(): void
    {
        $graph = new Graph();
        $graph->addNode(new Node('villa_widmann', 'luogo', 'Villa Widmann'));

        $validator = new Validator();

        $errors = $validator->validate($graph);

        $this->assertSame([], $errors);
    }
}
