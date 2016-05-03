<?php

namespace Spot\ImageStore\Tests;


use Spot\ImageStore\Entity\Exceptions\ImageTypeException;
use Spot\ImageStore\Entity\ImageEntity;
use Spot\ImageStore\Files\Exceptions\ImageFileException;
use Spot\ImageStore\Files\ImageFile;
use Spot\ImageStore\ImageStorage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: jpeg
$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);

// test: unsupported image
Assert::exception(function () use ($storage) {
	$storage->add(new ImageFile(__DIR__ . "/sample-images/bender.bmp"), new ImageEntity());
}, ImageTypeException::class);

// test: non-image file
Assert::exception(function () use ($storage) {
	$storage->add(new ImageFile(__DIR__ . "sample-images/this-is-not-image.jpg"), new ImageEntity());
}, ImageFileException::class);

Assert::true($storage->contains($meta));

$storage->destroy();
