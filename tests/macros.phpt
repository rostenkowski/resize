<?php

use Rostenkowski\Resize\Tests;


use Latte\Engine;
use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Files\ImageFile;
use Rostenkowski\Resize\ImageStorage;
use Rostenkowski\Resize\Macro\ImageMacro;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$storage = new ImageStorage(STORE_DIR, CACHE_DIR);

/**
 * TEST: image macros
 */
$meta = new ImageEntity();
$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);

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
