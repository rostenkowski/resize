<?php

namespace Rostenkowski\ImageStore\Tests;


use Rostenkowski\ImageStore\Exceptions\ImageTypeException;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Exceptions\ImageFileException;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
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

// test: download image from URL
$url = 'https://avatars2.githubusercontent.com/u/168612?v=3&s=64';
$storage->add(new ImageFile($url), $meta);
Assert::true($storage->contains($meta));

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
