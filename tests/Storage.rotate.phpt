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

Assert::equal(1, Finder::findDirectories('*')->in($storeDir)->count());
Assert::equal('e97c1cb54b3312f503825474cea49589e4cc3b5d', $meta->getHash());
Assert::true($storage->contains($meta));

$info = getimagesize($storage->file($meta));
Assert::equal(1920, $info[0]);
Assert::equal(1279, $info[1]);

$storage->rotate($meta);

Assert::equal('b4d8d1e46333e42b4ede050da2d12552eb78335a', $meta->getHash());
Assert::equal(2, Finder::findDirectories('*')->in($storeDir)->count());
Assert::true($storage->contains($meta));

$info = getimagesize($storage->file($meta));
Assert::equal(1279, $info[0]);
Assert::equal(1920, $info[1]);

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
