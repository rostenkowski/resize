<?php

namespace Spot\ImageStore\Files\Exceptions;


use InvalidArgumentException;

/**
 * Invalid image type exception
 */
class ImageFileException extends InvalidArgumentException
{

	/**
	 * @param string $filename
	 */
	public function __construct($filename)
	{
		parent::__construct(sprintf('File %s does not exist or it is not an image.', var_export($filename, TRUE)));
	}

}
