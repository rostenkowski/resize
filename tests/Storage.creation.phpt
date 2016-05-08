<?php

namespace Rostenkowski\ImageStore\Tests;


use Rostenkowski\ImageStore\Exceptions\DirectoryException;
use Rostenkowski\ImageStore\Exceptions\InvalidCacheDirectoryException;
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

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));

// test: cache dir cannot be the same dir as the storage dir
Assert::exception(function () {
	$storeDir = __DIR__ . '/store';
	new ImageStorage($storeDir, $storeDir);

	// wipeout testing directories
	exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));

}, InvalidCacheDirectoryException::class);

