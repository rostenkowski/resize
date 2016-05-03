<?php

namespace Spot\ImageStore\Tests;


use Spot\ImageStore\Entity\Exceptions\HashException;
use Spot\ImageStore\Entity\ImageEntity;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// test: invalid hash
Assert::exception(function () {
	$meta = new ImageEntity();
	$meta->setHash('not-a-sha1-hash');
}, HashException::class);

Assert::exception(function () {
	$meta = new ImageEntity();
	$meta->setHash(FALSE);
}, HashException::class);
