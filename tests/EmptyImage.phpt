<?php

namespace Spot\ImageStore\Tests;


use Nette\Utils\Image;
use Spot\ImageStore\Entity\EmptyImage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// test: empty image is immutable
$empty = new EmptyImage();
Assert::exception(function () use ($empty) {
	$empty->setHash('foo');
}, \LogicException::class);
Assert::exception(function () use ($empty) {
	$empty->setType(Image::GIF);
}, \LogicException::class);

