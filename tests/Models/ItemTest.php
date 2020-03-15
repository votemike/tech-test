<?php

namespace Tests\Models;

use App\Models\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testGetters()
    {
        $item = new Item('name', 'allergies', 42);
        $this->assertEquals('allergies', $item->getAllergies());
        $this->assertEquals('name', $item->getName());
    }

    public function testItemIsAvailableInTime()
    {
        $item = new Item('name', 'allergies', 42);
        $this->assertTrue($item->isAvailable(43));
        $this->assertTrue($item->isAvailable(42));
    }

    public function testItemIsNotAvailableInTime()
    {
        $item = new Item('name', 'allergies', 42);
        $this->assertFalse($item->isAvailable(41));
        $this->assertFalse($item->isAvailable(40));
    }
}
