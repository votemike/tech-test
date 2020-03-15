<?php

declare(strict_types=1);

namespace App;

use App\Factories\ItemFactory;
use App\Factories\VendorFactory;
use DateTime;

require __DIR__ . './../vendor/autoload.php';

$options = getopt('', ['filename:', 'day:', 'time:', 'location:', 'covers:']);
$vendorInformation = file_get_contents($options['filename']);

$app = new App(new DateTime(), new DateTimeHelper(), new VendorFactory(new ItemFactory()));
$app->main($vendorInformation, $options['location'], $options['covers'], $options['day'], $options['time']);
