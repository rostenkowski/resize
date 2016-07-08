<?php

namespace Rostenkowski\ImageStore;


use Latte\Engine;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Configurator;
use Rostenkowski\ImageStore\Entity\ImageEntity;
use Rostenkowski\ImageStore\Files\ImageFile;
use Tester\Assert;

$dir = dirname(__DIR__);

require "$dir/vendor/autoload.php";

@mkdir("$dir/tests/temp", 0755);

$configurator = new Configurator();
$configurator->setTempDirectory("$dir/tests/temp");
$configurator->addParameters(['baseDir' => "$dir/tests"]);
$configurator->addConfig("$dir/tests/extension.neon");

$container = $configurator->createContainer();

Assert::noError(function () use ($container) {

	$storage = $container->getService('imageStore.storage');

	Assert::type(ImageStorage::class, $storage);
	$latteFactory = $container->getByType(ILatteFactory::class);

	$latte = $latteFactory->create();
	Assert::type(Engine::class, $latte);

	$storeDir = __DIR__ . '/storage/images';

	// install "not found" image
	$sampleDir = __DIR__ . '/sample-images';
	@mkdir("$storeDir/_empty", 0755, TRUE);
	copy("$sampleDir/_empty.png", "$storeDir/_empty/_empty.png");

	$meta = new ImageEntity();
	$storage->add(new ImageFile(__DIR__ . '/sample-images/sample-landscape.jpg'), $meta);
	$latte->renderToString(__DIR__ . '/macros.latte', [
		'__imagestore' => $storage,
		'avatar'       => $meta,
		'none'         => NULL
	]);

});

exec("rm -rf $dir/tests/storage");
exec("rm -rf $dir/tests/www");
exec("rm -rf $dir/tests/temp");
