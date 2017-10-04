<?php

namespace Rostenkowski\Resize;


use Nette\DI\CompilerExtension;
use Nette\DI\Helpers;
use Rostenkowski\Resize\Entity\ImageEntity;
use Rostenkowski\Resize\Macro\ImageMacro;

class Extension extends CompilerExtension
{

	protected $defaults = [
		'imageEntity'  => ImageEntity::class,
		'storageClass' => ImageStorage::class,
		'storageDir'   => '%appDir%/../storage/images',
		'cacheDir'     => '%wwwDir%/cache/images',
		'basePath'     => '/cache/images/',
		'macros'       => [
			ImageMacro::class . '::install'
		]
	];


	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = Helpers::expand($this->validateConfig($this->defaults), $this->getContainerBuilder()->parameters);

		$builder
			->addDefinition($this->prefix('storage'))
			->setFactory($config['storageClass'], [
				$config['storageDir'],
				$config['cacheDir'],
				$config['basePath'],
			]);

		$builder = $this->getContainerBuilder();
		$definition = $builder->getDefinition('latte.latteFactory');
		$setup = '?->onCompile[] = function ($engine) { ' . ImageMacro::class . '::install($engine->getCompiler()); }';
		$definition->addSetup($setup, ['@self']);
	}

}
