<?php

declare(strict_types=1);

namespace App\Models;

class Vendor
{
    /* @var string */
    private $name;

    /* @var string */
    private $postcode;

    /* @var int */
    private $maxCovers;

    /* @var Item[] */
    private $items;

    public function __construct(string $name, string $postcode, int $maxCovers, array $items)
    {
        $this->name = $name;
        $this->postcode = $postcode;
        $this->maxCovers = $maxCovers;
        $this->items = $items;
    }

    public function canCover(int $covers): bool
    {
        return $covers <= $this->maxCovers;
    }

    public function canDeliverToPostcode(string $postcode): bool
    {
        return substr($postcode, 0, 2) === substr($this->postcode, 0, 2);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
