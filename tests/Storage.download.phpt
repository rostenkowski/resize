<?php

namespace Rostenkowski\ImageStore\Tests;


use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Rostenkowski\ImageStore\Requests\ImageRequest;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// test: download
$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);
$response = $storage->download(new ImageRequest($meta));

Assert::equal('e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $response->getName());
Assert::equal(__DIR__ . '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $response->getFile());
Assert::equal('2', $response->getContentType());

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
