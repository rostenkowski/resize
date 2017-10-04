<?php

namespace Rostenkowski\ImageStore;


use Nette\Utils\Image;
use Rostenkowski\ImageStore\Files\ImageFile;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

// test: detect image type
$file = new ImageFile(SAMPLE_DIR  . '/sample-landscape.jpg');
Assert::equal(Image::JPEG, $file->getType());
