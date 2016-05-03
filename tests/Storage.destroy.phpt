<?php

namespace Spot\ImageStore\Tests;


use Spot\ImageStore\ImageStorage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: destroy
$storage->destroy();

Assert::false(file_exists($storeDir));
Assert::false(file_exists($cacheDir));
