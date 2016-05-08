<?php

namespace Rostenkowski\ImageStore\Tests;


use Latte\Engine;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Rostenkowski\ImageStore\ImageStorage;
use Rostenkowski\ImageStore\Macro\ImageMacro;
use Tester\Assert;

require_once __DIR__ . '/bootstrap.php';

// create storage
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
$storage = new ImageStorage($storeDir, $cacheDir);

// install "not found" image
$sampleDir = __DIR__ . '/sample-images';
mkdir("$storeDir/_empty", 0755, TRUE);
copy("$sampleDir/_empty.png", "$storeDir/_empty/_empty.png");

// test: image macros
$meta = new ImageEntity();
$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);

$engine = new Engine();
ImageMacro::install($engine->getCompiler());
$s = $engine->renderToString(__DIR__ . '/macros.latte', [
	'__imagestore' => $storage,
	'avatar'       => $meta,
	'none'         => NULL
]);
$url = '/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.1.jpg';
$expected = <<<HTML
<img src="/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg">
<img src="/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.1.jpg">
<div style="background-image: url('$url');"></div>
/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg
/cache/_empty/_empty.0.0.0.png
/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.1.jpg
/cache/_empty/_empty.0.0.1.png
<a href="/cache/e9/7c/e97c1cb54b3312f503825474cea49589e4cc3b5d.0.0.0.jpg"></a>

HTML;

Assert::equal($expected, $s);

// wipeout testing directories
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));
