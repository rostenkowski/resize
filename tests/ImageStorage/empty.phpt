<?php

namespace Rostenkowski\Resize;


use Nette\Utils\Image;
use Rostenkowski\Resize\Entity\EmptyImage;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// test: empty image is immutable
$empty = new EmptyImage();
Assert::exception(function () use ($empty) {
	$empty->setHash('foo');
}, \LogicException::class);
Assert::exception(function () use ($empty) {
	$empty->setType(Image::GIF);
}, \LogicException::class);

