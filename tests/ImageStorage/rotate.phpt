<?php

namespace Rostenkowski\ImageStore\Tests;


use Nette\Utils\Finder;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

// test: rotate
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);

Assert::equal(2, Finder::findDirectories('*')->in(STORE_DIR)->count());
Assert::true($storage->contains($meta));

$info = getimagesize($storage->file($meta));
Assert::equal(1920, $info[0]);
Assert::equal(1279, $info[1]);

$storage->rotate($meta);

Assert::equal(3, Finder::findDirectories('*')->in(STORE_DIR)->count());
Assert::true($storage->contains($meta));

$info = getimagesize($storage->file($meta));
Assert::equal(1279, $info[0]);
Assert::equal(1920, $info[1]);
