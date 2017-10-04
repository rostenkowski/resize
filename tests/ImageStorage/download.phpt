<?php

namespace Rostenkowski\Resize;


use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Files\ImageFile;
use Rostenkowski\Resize\ImageStorage;
use Rostenkowski\Resize\Requests\ImageRequest;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

/**
 * TEST: create download response
 */
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);
$response = $storage->download(new ImageRequest($meta));

Assert::equal('e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $response->getName());
Assert::equal(CACHE_DIR . '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $response->getFile());
Assert::equal('2', $response->getContentType());
