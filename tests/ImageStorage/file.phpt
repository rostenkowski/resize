<?php

namespace Rostenkowski\Resize;


use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Files\ImageFile;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// create storage
$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

// test: file
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);

Assert::equal(STORE_DIR . '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.jpg', $storage->file($meta));
