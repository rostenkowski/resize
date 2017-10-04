<?php

namespace Rostenkowski\Resize;


use Rostenkowski\Resize\Exceptions\DirectoryException;
use Rostenkowski\Resize\Exceptions\InvalidCacheDirectoryException;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// create storage
$storage = new ImageStorage(STORE_DIR, CACHE_DIR, 'https://storage.green');

// test: add trailing slash to base URL
Assert::equal('https://storage.green/', $storage->getBaseUrl());

// test: non-existing directories
Assert::exception(function () {
	new ImageStorage('non-existing-dir', 'non-existing-dir', '/non-existing-dir/', false); // FALSE: do not try to create directories
}, DirectoryException::class);

// test: cache dir cannot be the same dir as the storage dir
Assert::exception(function () {
	new ImageStorage(STORE_DIR, STORE_DIR);
}, InvalidCacheDirectoryException::class);
