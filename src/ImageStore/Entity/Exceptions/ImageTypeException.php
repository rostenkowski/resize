<?php

namespace Rostenkowski\ImageStore\Entity\Exceptions;


use InvalidArgumentException;

/**
 * Invalid image type exception
 */
class ImageTypeException extends InvalidArgumentException
{

	/**
	 * @param integer $type
	 */
	public function __construct($type)
	{
		$message = 'The image type %s is not supported, it must be one of Image::JPEG, Image::PNG or Image::GIF.';
		parent::__construct(sprintf($message, var_export($type, TRUE)));
	}

}
