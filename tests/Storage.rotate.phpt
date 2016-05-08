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
Assert::equal('e97c1cb54b3312f503825474cea49589e4cc3b5d', $meta->getHash());

$storage->rotate($meta);
Assert::true($storage->contains($meta));
Assert::equal(2, Finder::findDirectories('*')->in($storeDir)->count());
$rotatedImageHash = 'b4d8d1e46333e42b4ede050da2d12552eb78335a';
Assert::equal($rotatedImageHash, $meta->getHash());

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
