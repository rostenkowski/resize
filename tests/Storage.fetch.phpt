<?php

namespace Spot\ImageStore\Tests;


use Nette\Utils\Image;
use Spot\ImageStore\Entity\Exceptions\ImageTypeException;
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

$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);
$request = new ImageRequest($meta);

// test: fetch image
Assert::type(Image::class, $storage->fetch($request));

// test: fetch invalid image type
Assert::exception(function () use ($storage) {
	$meta = new ImageEntity();
	$meta->setHash('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
	$meta->setType(99);
	$storage->fetch(new ImageRequest($meta));
}, ImageTypeException::class);

$storage->destroy();
