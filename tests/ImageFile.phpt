<?php

namespace Rostenkowski\ImageStore\Tests;


use Nette\Utils\Image;
use Rostenkowski\ImageStore\Files\ImageFile;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// test: detect image type
$file = new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg');
Assert::equal(Image::JPEG, $file->getType());
