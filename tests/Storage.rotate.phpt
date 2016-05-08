<?php

namespace Rostenkowski\ImageStore\Tests;


use Nette\Utils\Finder;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: rotate
$meta = new ImageEntity();

$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);

Assert::true($storage->contains($meta));
Assert::equal(1, Finder::findDirectories('*')->in($storeDir)->count());

$storage->rotate($meta);

Assert::true($storage->contains($meta));
Assert::equal(2, Finder::findDirectories('*')->in($storeDir)->count());

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
