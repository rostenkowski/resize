<?php

namespace Spot\ImageStore\Tests;


use Spot\ImageStore\Entity\ImageEntity;
use Spot\ImageStore\Files\ImageFile;
use Spot\ImageStore\ImageStorage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: file
$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);

Assert::equal(__DIR__ . '/store/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.jpg', $storage->file($meta));

$storage->destroy();
