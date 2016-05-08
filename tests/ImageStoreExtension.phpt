<?php

namespace Rostenkowski\ImageStore;


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

$class = get_class($storage);

Assert::true($storage instanceof $class, $storage);

exec("rm -rf $dir/tests/storage");
exec("rm -rf $dir/tests/www");
exec("rm -rf $dir/tests/temp");
