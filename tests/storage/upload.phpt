<?php

namespace Rostenkowski\ImageStore\Tests;


use Nette\Http\FileUpload;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Exceptions\UploaderException;
use Rostenkowski\ImageStore\ImageStorage;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// create storage
$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

// testing image
$sampleName = 'sample-landscape.jpg';
$sampleType = 'image/jpeg';
$sampleSize = 458933;
$sampleWidth = 1621;
$sampleHeight = 1080;

// create image entity
$meta = new ImageEntity();

// test: upload
$tmpDir = TEMP_DIR;
$tmpName = uniqid('upload');

copy(SAMPLE_DIR . "/$sampleName", "$tmpDir/$tmpName");

$uploadedFile = new FileUpload([
	'name'     => $sampleName,
	'type'     => $sampleType,
	'size'     => $sampleSize,
	'tmp_name' => "$tmpDir/$tmpName",
	'error'    => 0
]);

$storage->upload($uploadedFile, $meta);

$storedFilename = STORE_DIR . '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.jpg';
$info = getimagesize($storedFilename);

Assert::true($storage->contains($meta), 'storage contains image of given meta');
Assert::true(file_exists($storedFilename), 'stored image file truly exists');
Assert::equal($sampleType, $info['mime']);
Assert::equal($sampleWidth, $info[0]);
Assert::equal($sampleHeight, $info[1]);

// test: upload error
Assert::exception(function () use ($storage) {
	$storage->upload(new FileUpload([
		'name'     => '',
		'type'     => '',
		'size'     => '',
		'tmp_name' => '',
		'error'    => 4
	]), new ImageEntity());
}, UploaderException::class, 'No file was uploaded');
