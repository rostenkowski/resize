<?php

namespace Rostenkowski\Resize;


use Nette\Utils\Image;
use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Exceptions\ImageTypeException;
use Rostenkowski\Resize\Files\ImageFile;
use Rostenkowski\Resize\Requests\ImageRequest;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

/**
 * TEST: fetch image
 */
$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);
$request = new ImageRequest($meta);

// fetch image
Assert::type(Image::class, $storage->fetch($request));

// fetch invalid image type
Assert::exception(function () use ($storage) {
	$meta = new ImageEntity();
	$meta->setHash('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
	$meta->setType(99);
	$storage->fetch(new ImageRequest($meta));
}, ImageTypeException::class, 'The image type 99 is not supported, it must be one of Image::JPEG, Image::PNG or Image::GIF.');
