<?php

namespace Rostenkowski\ImageStore;


use Latte\Engine;
use Nette\Configurator;
use Tester\Assert;

$dir = dirname(__DIR__);

require "$dir/vendor/autoload.php";

mkdir("$dir/tests/temp", 0755);

$configurator = new Configurator();
$configurator->setTempDirectory("$dir/tests/temp");
$configurator->addParameters(['baseDir' => "$dir/tests"]);
$configurator->addConfig("$dir/tests/extension.neon");

$container = $configurator->createContainer();

$storage = $container->getService('imageStore.storage');

Assert::type(ImageStorage::class, $storage);

$latte = $container->getService('nette.latte');

Assert::type(Engine::class, $latte);

exec("rm -rf $dir/tests/storage");
exec("rm -rf $dir/tests/www");
exec("rm -rf $dir/tests/temp");
