<?php

namespace Rostenkowski\ImageStore;


use Latte\Engine;
use Nette\Bridges\ApplicationDI\LatteExtension;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

/**
 * TEST: resize extension
 */
Assert::noError(function () {

	ECHO TEMP_DIR;

	$loader = new  ContainerLoader(TEMP_DIR, true);
	$class = $loader->load(function (Compiler $compiler) {
		$compiler->addExtension('latte', new LatteExtension(TEMP_DIR, false));
		$compiler->addExtension('images', new ImageStore());
		$compiler->addConfig([
			'images' => [
				'storageDir' => STORE_DIR,
				'cacheDir'   => CACHE_DIR,
				'basePath'   => '/',
			]
		]);
	});
	$container = new $class;

	$storage = $container->getByType(ImageStorage::class);
	Assert::type(ImageStorage::class, $storage);

	$f = $container->getByType(ILatteFactory::class);
	$engine = $f->create();
	Assert::type(Engine::class, $engine);

	$meta = new ImageEntity();
	$storage->add(new ImageFile(SAMPLE_DIR . '/sample-landscape.jpg'), $meta);
	$engine->renderToString(__DIR__ . '/macros.latte', [
		'__imagestore' => $storage,
		'avatar'       => $meta,
		'none'         => NULL
	]);
});

