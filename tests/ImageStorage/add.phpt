<?php

namespace Rostenkowski\Resize;


use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Exceptions\ImageFileException;
use Rostenkowski\Resize\Exceptions\ImageTypeException;
use Rostenkowski\Resize\Files\ImageFile;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

// test: jpeg
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);

// test: unsupported image
Assert::exception(function () use ($storage) {
	$storage->add(new ImageFile(SAMPLE_DIR . "/bender.bmp"), new ImageEntity());
}, ImageTypeException::class);

// test: non-image file
Assert::exception(function () use ($storage) {
	$storage->add(new ImageFile(__DIR__ . "this-is-not-image.jpg"), new ImageEntity());
}, ImageFileException::class);

Assert::true($storage->contains($meta));

// test: download image from URL
$url = 'https://avatars2.githubusercontent.com/u/168612?v=3&s=64';
$storage->add(new ImageFile($url), $meta);
Assert::true($storage->contains($meta));
