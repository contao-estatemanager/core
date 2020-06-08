<?php

namespace ContaoEstateManager\EstateManager\Tests;

use ContaoEstateManager\EstateManager\EstateManager;
use PHPUnit\Framework\TestCase;

class EstateManagerTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new EstateManager();

        $this->assertInstanceOf('ContaoEstateManager\EstateManager\EstateManager', $bundle);
    }
}
