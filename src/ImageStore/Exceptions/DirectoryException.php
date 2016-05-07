<?php

namespace Rostenkowski\ImageStore\Exceptions;


use InvalidArgumentException;

/**
 * Directory exception
 */
class DirectoryException extends InvalidArgumentException
{


	/**
	 * @param string $directory
	 */
	public function __construct($directory)
	{
		parent::__construct(sprintf('Directory "%s" does not exist and cannot be created or it is not writable.', var_export($directory, TRUE)));
	}

}
