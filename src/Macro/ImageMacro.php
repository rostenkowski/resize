<?php

namespace Rostenkowski\Resize\Macro;


use Latte\Compiler;
use Latte\MacroNode;
use Latte\Macros\MacroSet;
use Latte\PhpWriter;

/**
 * Latte template engine image macros
 */
class ImageMacro extends MacroSet
{


	/**
	 * Installs the macro set into the template compiler.
	 *
	 * @param Compiler $compiler
	 * @return void|static
	 */
	public static function install(Compiler $compiler)
	{
		$macroSet = new static($compiler);
		$macroSet->setup();
	}


	/**
	 * Sets the template macros up.
	 */
	public function setup()
	{
		$this->addMacro('src', NULL, NULL, [$this, 'macroSrc']);
		$this->addMacro('bg', NULL, NULL, [$this, 'macroBg']);
		$this->addMacro('image', [$this, 'macroImageBegin'], NULL, [$this, 'macroImage']);
		$this->addMacro('crop', [$this, 'macroCropBegin'], NULL, [$this, 'macroCrop']);
	}


	/**
	 * Renders the `n:src="$image"` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroBg(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write(' ?> style="background-image: url(\'<?php $imageRequest = Rostenkowski\Resize\Requests\ImageRequest::crop(%node.word, %node.array?); echo %escape($__imagestore->link($imageRequest)); ?>\');"<?php ');
	}


	/**
	 * Renders the `n:crop="$image"` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroCrop(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write(' ?> src="<?php $imageRequest = Rostenkowski\Resize\Requests\ImageRequest::crop(%node.word, %node.array?); echo %escape($__imagestore->link($imageRequest)); ?>"<?php ');
	}


	/**
	 * Renders the `{crop $image ...}` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroCropBegin(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$imageRequest = Rostenkowski\Resize\Requests\ImageRequest::crop(%node.word, %node.array?); echo %escape($__imagestore->link($imageRequest));');
	}


	/**
	 * Renders the `n:image="$image"` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroImage(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write(' ?> href="<?php $imageRequest = Rostenkowski\Resize\Requests\ImageRequest::fromMacro(%node.word, %node.array?); echo %escape($__imagestore->link($imageRequest)); ?>"<?php ');
	}


	/**
	 * Renders the `{image $image ...}` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroImageBegin(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$imageRequest = Rostenkowski\Resize\Requests\ImageRequest::fromMacro(%node.word, %node.array?); echo %escape($__imagestore->link($imageRequest));');
	}


	/**
	 * Renders the `n:src="$image"` macro.
	 *
	 * @param MacroNode $node
	 * @param PhpWriter $writer
	 * @return string
	 */
	public function macroSrc(MacroNode $node, PhpWriter $writer)
	{
		return $writer->write('$imageRequest = Rostenkowski\Resize\Requests\ImageRequest::fromMacro(%node.word, %node.array?); ?> src="<?php echo %escape($__imagestore->link($imageRequest)); ?>"<?php ');
	}

}
