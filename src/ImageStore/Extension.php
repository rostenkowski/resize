<?php

namespace Rostenkowski\ImageStore;


use Nette\DI\CompilerExtension;
use Nette\Utils\Validators;

/**
 * The Image Extension
 */
class Extension extends CompilerExtension
{

	protected $options = [
		'imageEntity'  => 'Rostenkowski\ImageStore\Entity\ImageEntity',
		'storageClass' => 'Rostenkowski\ImageStore\ImageStorage',
		'basePath'     => '/cache/images/',
		'cacheDir'     => '%baseDir%/www/cache/images',
		'storageDir'   => '%baseDir%/storage/images',
		'macros'       => [
			'Rostenkowski\ImageStore\Macro\ImageMacro',
		],
	];


	public function loadConfiguration()
	{
		$this->options = $this->getConfig($this->options, TRUE);
		$builder = $this->getContainerBuilder();

		// Image storage
		$builder->addDefinition($this->prefix('storage'))
			->setClass($this->options['storageClass'], [$this->options['storageDir'], $this->options['cacheDir'], $this->options['basePath']]);

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
