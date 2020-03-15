<?php

namespace Tests\Models;

use App\Models\Item;
use App\Models\Vendor;
use PHPUnit\Framework\TestCase;

class VendorTest extends TestCase
{
    public function testGetters()
    {
        $item = new Item('name', 'allergies', 42);
        $vendor = new Vendor('name', 'postcode', 42, [$item, $item]);
        $this->assertIsArray($vendor->getItems());
        $this->assertContainsOnlyInstancesOf(Item::class, $vendor->getItems());
        $this->assertCount(2, $vendor->getItems());
    }

    public function testVendorCanCover()
    {
        $vendor = new Vendor('name', 'postcode', 42, []);
        $this->assertTrue($vendor->canCover(41));
        $this->assertTrue($vendor->canCover(42));
    }

    public function testVendorCannotCover()
    {
        $vendor = new Vendor('name', 'postcode', 42, []);
        $this->assertFalse($vendor->canCover(43));
        $this->assertFalse($vendor->canCover(44));
    }

    public function testVendorCanDeliverToPostcode()
    {
        $vendor = new Vendor('name', 'NW11AA', 42, []);
        $this->assertTrue($vendor->canDeliverToPostcode('NW22BB'));

        $vendor = new Vendor('name', 'W91AA', 42, []);
        $this->assertTrue($vendor->canDeliverToPostcode('W92BB'));
    }

    public function testVendorCannotDeliverToPostcode()
    {
        $vendor = new Vendor('name', 'SW11AA', 42, []);
        $this->assertFalse($vendor->canDeliverToPostcode('NW22BB'));

        $vendor = new Vendor('name', 'E91AA', 42, []);
        $this->assertFalse($vendor->canDeliverToPostcode('W92BB'));
    }
}
