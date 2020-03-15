<?php

declare(strict_types=1);

namespace App\Models;

class Item
{
    /* @var string */
    private $name;

    /* @var string */
    private $allergies;

    /* @var int */
    private $advanceTime;

    public function __construct(string $name, string $allergies, int $advanceTime)
    {
        $this->name = $name;
        $this->allergies = $allergies;
        $this->advanceTime = $advanceTime;
    }

    public function getAllergies(): string
    {
        return $this->allergies;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isAvailable(int $hoursDifference): bool
    {
        return $hoursDifference >= $this->advanceTime;
    }
}
