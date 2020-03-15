<?php

namespace Tests\Factories;

use App\Factories\ItemFactory;
use PHPUnit\Framework\TestCase;

class ItemFactoryTest extends TestCase
{
    public function testItemCreation()
    {
        $factory = new ItemFactory();
        $item = $factory->createItem('name;allergies;42h');
        $this->assertEquals('allergies', $item->getAllergies());
        $this->assertEquals('name', $item->getName());
        $this->assertFalse($item->isAvailable(41));
        $this->assertTrue($item->isAvailable(42));
    }
}
