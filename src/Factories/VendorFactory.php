<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\Vendor;

class VendorFactory
{
    /* @var ItemFactory */
    private $itemFactory;

    public function __construct(ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    public function createVendor(string $vendorLine): Vendor
    {
        $lines = explode("\n", $vendorLine);
        $vendorInfo = array_shift($lines);
        list($name, $postcode, $maxCovers) = explode(";", $vendorInfo);
        $items = [];
        foreach($lines as $line) {
            if (!empty($line)) {
                $items[] = $this->itemFactory->createItem($line);
            }
        }

        return new Vendor($name, $postcode, intval($maxCovers), $items);
    }
}
