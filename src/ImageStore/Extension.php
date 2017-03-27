<?php

namespace Rostenkowski\ImageStore;


use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;
use Tracy\Debugger;

/**
 * The Image Extension
 */
class Extension extends CompilerExtension
{

	protected $options = [
		'imageEntity'  => 'Rostenkowski\ImageStore\Entity\ImageEntity',
		'storageClass' => 'Rostenkowski\ImageStore\ImageStorage',
		'basePath'     => '/cache/images/',
		'cacheDir'     => '%wwwDir%/cache/images',
		'storageDir'   => '%baseDir%/storage/images',
		'macros'       => [
			'Rostenkowski\ImageStore\Macro\ImageMacro',
		],
	];


	/**
	 * todo: this method may be removed (changed) when the load configuration api is stabilized
	 */
	private function LOAD_VALIDATE_AND_EXPAND_CONFIGURATION()
	{
		$this->options = Helpers::expand($this->validateConfig($this->options, $this->getConfig()), $this->getContainerBuilder()->parameters);

		Debugger::barDump($this->options, $this->name . ' options');
	}


	public function loadConfiguration()
	{
		$this->LOAD_VALIDATE_AND_EXPAND_CONFIGURATION();

		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('storage'))
			->setClass($this->options['storageClass'], [
				$this->options['storageDir'],
				$this->options['cacheDir'],
				$this->options['basePath'],
			]);

		// Latte macros
		$this->addMacros($this->options);
	}


	/**
	 * Adds macros (found in $options) to latte factory definition.
	 *
	 * @param array
	 */
	private function addMacros($options)
	{
		$builder = $this->getContainerBuilder();

		if (array_key_exists('macros', $options) && is_array($options['macros'])) {
			$factory = $builder->getDefinition('nette.latteFactory');
			foreach ($options['macros'] as $macro) {
				if (strpos($macro, '::') === FALSE && class_exists($macro)) {
					$macro .= '::install';
				} else {
					Validators::assert($macro, 'callable');
				}
				$factory->addSetup($macro . '(?->getCompiler())', array('@self'));
			}
		}
	}
}
