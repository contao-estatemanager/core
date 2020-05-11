<?php

namespace ContaoEstateManager\EstateManager\Tests;

use ContaoEstateManager\EstateManager\EstateManager;
use PHPUnit\Framework\TestCase;

class ContaoSkeletonBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new EstateManager();

        $this->assertInstanceOf('ContaoEstateManager\EstateManager\EstateManager', $bundle);
    }
}
