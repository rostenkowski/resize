<?php

namespace Rostenkowski\ImageStore;


use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Exceptions\HashException;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

/**
 * TEST: invalid hash
 */
Assert::exception(function () {
	$meta = new ImageEntity();
	$meta->setHash('not-a-sha1-hash');
}, HashException::class);

Assert::exception(function () {
	$meta = new ImageEntity();
	$meta->setHash(false);
}, HashException::class);
