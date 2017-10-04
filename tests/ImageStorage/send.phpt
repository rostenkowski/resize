<?php

use Rostenkowski\Resize\Tests;


use Nette\Utils\Image;
use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Files\ImageFile;
use Rostenkowski\Resize\ImageStorage;
use Rostenkowski\Resize\Requests\ImageRequest;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR, '/');

// test: send
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);
$request = new ImageRequest($meta, '150x100', Image::FILL, true);
ob_start();
$storage->send($request);
$output = ob_get_clean();

$string = file_get_contents(CACHE_DIR . $storage->link($request));

Assert::equal($string, $output);
