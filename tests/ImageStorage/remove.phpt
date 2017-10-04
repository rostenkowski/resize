<?php

namespace Rostenkowski\ImageStore\Tests;


use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

// test: remove
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);
Assert::true($storage->contains($meta));
$storage->remove($meta);
Assert::false($storage->contains($meta));
