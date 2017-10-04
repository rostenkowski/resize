<?php

namespace Rostenkowski\ImageStore\Tests;


use Nette\Utils\Image;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Rostenkowski\ImageStore\Requests\ImageRequest;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR, '/');

/**
 * TEST: image link
 */

// test: image not found
$landscape = new ImageEntity();
$landscape->setHash('eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
$landscape->setType(Image::JPEG);
$link = $storage->link(new ImageRequest($landscape, '60x40', Image::FILL, true));
Assert::equal('/_empty/_empty.60x40.4.1.png', $link);

$landscape = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $landscape);
$portrait = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-portrait.jpg'), $portrait);

// test: link
$request = new ImageRequest($landscape);
$link = $storage->link($request);
Assert::equal('/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg', $link);

$request = new ImageRequest($landscape, '32x32', Image::FIT, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.32x32.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($portrait, '32x32', Image::FIT, true);
$link = '/5f/88/5f88864ba05312992a967739e50e8a36f779deee.32x32.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '150x100', Image::FILL, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '150x100', Image::SHRINK_ONLY, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.1.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '150x100', Image::EXACT, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.150x100.8.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '2000x1000', Image::FIT, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.2000x1000.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '200', Image::FIT, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.200.0.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '200', Image::FIT);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.200.0.0.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($portrait, '150x100', Image::FILL, true);
$link = '/5f/88/5f88864ba05312992a967739e50e8a36f779deee.150x100.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($landscape, '60x200', Image::FILL, true);
$link = '/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.60x200.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));

$request = new ImageRequest($portrait, '60x200', Image::FILL, true);
$link = '/5f/88/5f88864ba05312992a967739e50e8a36f779deee.60x200.4.1.jpg';
Assert::equal($link, $storage->link($request));
Assert::true(file_exists(CACHE_DIR . $link));
Assert::truthy(getimagesize(CACHE_DIR . $link));
