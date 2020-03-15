<?php

declare(strict_types=1);

namespace Tests;

use App\App;
use App\DateTimeHelper;
use App\Factories\VendorFactory;
use App\Models\Item;
use App\Models\Vendor;
use DateTime;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testMenuItemsArePrinted(): void
    {
        $vendorMock = $this->createVendorMock(true, true, [$this->createItemMock()]);
        $dateTimeStub = $this->createStub(DateTime::class);
        $dateTimeHelperMock = $this->createDateTimeHelperMock();
        $vendorFactoryMock = $this->createVendorFactoryMock([['Some info']], [$vendorMock]);

        $this->expectOutputString("Item Name;Item Allergies\n");
        $app = new App($dateTimeStub, $dateTimeHelperMock, $vendorFactoryMock);
        $app->main('Some info', 'NW11AA', '42', '15/03/20', '09:50');
    }

    public function testMenuItemsArePrintedForVendorsThatCanCover(): void
    {
        $validVendorMock = $this->createVendorMock(true, true, [$this->createItemMock()]);
        $invalidVendorMock = $this->createVendorMock(true, false, [$this->createItemMock()]);
        $dateTimeStub = $this->createStub(DateTime::class);
        $dateTimeHelperMock = $this->createDateTimeHelperMock();
        $vendorFactoryMock = $this->createVendorFactoryMock([['Some info'], ['More info']], [$validVendorMock, $invalidVendorMock]);

        $this->expectOutputString("Item Name;Item Allergies\n");
        $app = new App($dateTimeStub, $dateTimeHelperMock, $vendorFactoryMock);
        $app->main("Some info\n\nMore info", 'NW11AA', '42', '15/03/20', '09:50');
    }

    public function testMenuItemsArePrintedForVendorsThatCanDeliver(): void
    {
        $validVendorMock = $this->createVendorMock(true, true, [$this->createItemMock()]);
        $invalidVendorMock = $this->createVendorMock(false, true, [$this->createItemMock()]);
        $dateTimeStub = $this->createStub(DateTime::class);
        $dateTimeHelperMock = $this->createDateTimeHelperMock();
        $vendorFactoryMock = $this->createVendorFactoryMock([['Some info'], ['More info']], [$validVendorMock, $invalidVendorMock]);

        $this->expectOutputString("Item Name;Item Allergies\n");
        $app = new App($dateTimeStub, $dateTimeHelperMock, $vendorFactoryMock);
        $app->main("Some info\n\nMore info", 'NW11AA', '42', '15/03/20', '09:50');
    }

    public function testMenuItemsArePrintedForItemsThatCanBeDelivered(): void
    {

        $vendorWithAvailableItemMock = $this->createVendorMock(true, true, [$this->createItemMock()]);
        $vendorWithoutAvailableItemMock = $this->createVendorMock(true, true, [$this->createItemMock(false)]);
        $dateTimeStub = $this->createStub(DateTime::class);
        $dateTimeHelperMock = $this->createDateTimeHelperMock();
        $vendorFactoryMock = $this->createVendorFactoryMock([['Some info'], ['More info']], [$vendorWithAvailableItemMock, $vendorWithoutAvailableItemMock]);

        $this->expectOutputString("Item Name;Item Allergies\n");
        $app = new App($dateTimeStub, $dateTimeHelperMock, $vendorFactoryMock);
        $app->main("Some info\n\nMore info", 'NW11AA', '42', '15/03/20', '09:50');
    }

    private function createDateTimeHelperMock()
    {
        $dateTimeHelperMock = $this->createMock(DateTimeHelper::class);
        $dateTimeHelperMock->expects($this->once())
            ->method('createDateTimeFromDateAndTime')
            ->with($this->equalTo('15/03/20'), $this->equalTo('09:50'))
            ->willReturn(DateTime::createFromFormat('Y/m/d H:i', '2020/03/15 09:50'));
        $dateTimeHelperMock->expects($this->once())
            ->method('getDiffInHours')
            ->willReturn(42);

        return $dateTimeHelperMock;
    }

    private function createItemMock(bool $isAvailable = true)
    {
        $itemMock = $this->createMock(Item::class);
        $itemMock->method('getName')
            ->willReturn('Item Name');
        $itemMock->method('getAllergies')
            ->willReturn('Item Allergies');
        $itemMock->method('isAvailable')
            ->willReturn($isAvailable);

        return $itemMock;
    }

    private function createVendorFactoryMock(array $args, array $vendors)
    {
        $vendorFactoryMock = $this->createMock(VendorFactory::class);
        $vendorFactoryMock->expects($this->exactly(count($vendors)))
            ->method('createVendor')
            ->withConsecutive(...$args)
            ->willReturnOnConsecutiveCalls(...$vendors);

        return $vendorFactoryMock;
    }

    private function createVendorMock(bool $canDeliver, bool $canCover, array $items)
    {
        $vendorMock = $this->createMock(Vendor::class);
        $vendorMock->method('canDeliverToPostcode')
            ->willReturn($canDeliver);
        $vendorMock->method('canCover')
            ->willReturn($canCover);
        $vendorMock->method('getItems')
            ->willReturn($items);

        return $vendorMock;
    }

//    public function testMenuItemsArePrinted(): void
//    {
//        $vendorStub = $this->createStub(Vendor::class);
//        $dateTimeStub = $this->createStub(DateTime::class);
//        $dateTimeHelperMock = $this->createMock(DateTimeHelper::class);
//        $dateTimeHelperMock->expects($this->once())
//            ->method('createDateTimeFromDateAndTime')
//            ->with($this->equalTo('15/03/20'), $this->equalTo('09:50'))
//            ->willReturn(DateTime::createFromFormat('Y/m/d H:i', '2020/03/15 09:50'));
//        $dateTimeHelperMock->expects($this->once())
//            ->method('getDiffInHours')
//            ->willReturn('42');
//        $vendorFactoryMock = $this->createMock(VendorFactory::class);
//        $vendorFactoryMock->expects($this->once())
//            ->method('createVendor')
//            ->with($this->equalTo('Some info'))
//            ->willReturn($vendorStub);
//
//        $this->expectOutputString('');
//        $calc = new App($dateTimeStub, $dateTimeHelperStub, $vendorFactoryMock);
//        $calc->main('Some info', 'NW11AA', '42', '15/03/20', '09:50');
//    }
}
