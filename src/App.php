<?php

declare(strict_types=1);

namespace App;

use App\Factories\VendorFactory;
use DateTime;

class App
{
    /* @var DateTimeHelper */
    private $dateTimeHelper;

    /* @var DateTime */
    private $now;

    /* @var VendorFactory */
    private $vendorFactory;

    public function __construct(DateTime $now, DateTimeHelper $dateTimeHelper, VendorFactory $vendorFactory)
    {
        $this->dateTimeHelper = $dateTimeHelper;
        $this->now = $now;
        $this->vendorFactory = $vendorFactory;
    }

    public function main(string $vendorInformation, string $location, string $covers, string $day, string $time)
    {
        $vendors = $this->parseFileContents($vendorInformation);
        $menu = $this->filterItems($vendors, $location, $covers, $day, $time);
        $this->output($menu);
    }

    private function parseFileContents(string $fileContents): array
    {
        $vendorLines = explode("\n\n", $fileContents);
        $vendors = [];

        foreach($vendorLines as $vendorLine) {
            $vendors[] = $this->vendorFactory->createVendor($vendorLine);
        }

        return $vendors;
    }

    private function filterItems(array $vendors, string $location, string $covers, string $day, string $time): array
    {
        $menuItems = [];
        $deliveryDate = $this->dateTimeHelper->createDateTimeFromDateAndTime($day, $time);
        $hoursDifference = $this->dateTimeHelper->getDiffInHours($this->now, $deliveryDate);

        foreach($vendors as $vendor) {
            if ($vendor->canDeliverToPostcode($location) && $vendor->canCover(intval($covers))) {
                foreach($vendor->getItems() as $item) {
                    if ($item->isAvailable($hoursDifference)) {
                        $menuItems[] = $item;
                    }
                }
            }
        }

        return $menuItems;
    }

    private function output(array $menuItems)
    {
        foreach($menuItems as $menuItem) {
            echo $menuItem->getName() . ";" . ($menuItem->getAllergies() ?: ";") . "\n";
        }
    }
}
