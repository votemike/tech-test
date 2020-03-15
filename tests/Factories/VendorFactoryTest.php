<?php

namespace Tests\Factories;

use App\Factories\ItemFactory;
use App\Factories\VendorFactory;
use App\Models\Item;
use PHPUnit\Framework\TestCase;

class VendorFactoryTest extends TestCase
{
    public function testVendorCreation()
    {
        $factory = new VendorFactory(new ItemFactory());
        $vendor = $factory->createVendor("name;postcode;42\nname;allergies;42h\nname;allergies;42h");
        $this->assertIsArray($vendor->getItems());
        $this->assertContainsOnlyInstancesOf(Item::class, $vendor->getItems());
        $this->assertCount(2, $vendor->getItems());
    }
}
