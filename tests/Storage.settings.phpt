<?php

namespace Rostenkowski\ImageStore\Tests;


use Rostenkowski\ImageStore\Directory\Exceptions\DirectoryException;
use Rostenkowski\ImageStore\ImageStorage;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir, 'https://storage.green');

// test: add trailing slash to base URL
Assert::equal('https://storage.green/', $storage->getBaseUrl());

// test: non-existing directories
Assert::exception(function () {
	new ImageStorage('non-existing-dir', 'non-existing-dir', '/non-existing-dir/', FALSE); // FALSE: do not try to create directories
}, DirectoryException::class);

$storage->destroy();
