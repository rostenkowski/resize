<?php

namespace Spot\ImageStore\Tests;


use Nette\Utils\Image;
use Spot\ImageStore\Entity\ImageEntity;
use Spot\ImageStore\Files\ImageFile;
use Spot\ImageStore\ImageStorage;
use Spot\ImageStore\Requests\ImageRequest;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: send
$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);
$request = new ImageRequest($meta, '150x100', Image::FILL, TRUE);
ob_start();
$storage->send($request);
$output = ob_get_clean();

Assert::equal(file_get_contents(__DIR__ . $storage->link($request)), $output);

// wipeout testing directories
$storage->destroy();
