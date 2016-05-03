<?php

namespace Spot\ImageStore\Tests;


use Nette\Utils\Image;
use Spot\ImageStore\Entity\ImageEntity;
use Spot\ImageStore\Files\ImageFile;
use Spot\ImageStore\ImageStorage;
use Spot\ImageStore\Requests\ImageRequest;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// install "not found" image
$sampleDir = __DIR__ . '/sample-images';
exec("mkdir -p $storeDir/_empty");
exec("cp $sampleDir/_empty.png $storeDir/_empty/_empty.png");

// test: image not found
$landscape = new ImageEntity();
$landscape->setHash('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
$landscape->setType(Image::JPEG);
$link = $storage->link(new ImageRequest($landscape, '60x40', Image::FILL, TRUE));
Assert::equal('/cache/_empty/_empty.60x40.4.1.png', $link);

$landscape = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $landscape);
$portrait = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-portrait.jpg'), $portrait);

// test: link
$request = new ImageRequest($landscape);
$link = $storage->link($request);
Assert::equal('/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $link);

$request = new ImageRequest($landscape, '32x32', Image::FIT, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.32x32.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($portrait, '32x32', Image::FIT, TRUE);
$link = '/cache/5f/88/5f88864ba05312992a967739e50e8a36f779deee.32x32.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '150x100', Image::FILL, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '150x100', Image::SHRINK_ONLY, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.1.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '150x100', Image::EXACT, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.8.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '2000x1000', Image::FIT, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.2000x1000.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '200', Image::FIT, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.200.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '200', Image::FIT);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.200.0.0.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($portrait, '150x100', Image::FILL, TRUE);
$link = '/cache/5f/88/5f88864ba05312992a967739e50e8a36f779deee.150x100.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($landscape, '60x200', Image::FILL, TRUE);
$link = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.60x200.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$request = new ImageRequest($portrait, '60x200', Image::FILL, TRUE);
$link = '/cache/5f/88/5f88864ba05312992a967739e50e8a36f779deee.60x200.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(__DIR__ . $link));
Assert::truthy(getimagesize(__DIR__ . $link));

$storage->destroy();
