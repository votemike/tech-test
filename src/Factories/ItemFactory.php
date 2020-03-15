<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\Item;

class ItemFactory
{
    public function createItem(string $itemLine): Item
    {
        list($name, $allergies, $advanceTime) = explode(";", $itemLine);

        return new Item($name, $allergies, intval(str_replace('h', '', $advanceTime)));
    }
}
