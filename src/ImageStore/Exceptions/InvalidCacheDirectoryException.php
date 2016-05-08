<?php

namespace Rostenkowski\ImageStore\Exceptions;


use InvalidArgumentException;

/**
 * Invalid cache directory exception
 *
 * It's thrown when user attempts to use the same directory for the storage AND the cache.
 */
class InvalidCacheDirectoryException extends InvalidArgumentException
{


	/**
	 * @param string $directory
	 */
	public function __construct($directory)
	{
		parent::__construct(sprintf('You cannot use the same directory for the image cache as for the storage. Path: (%s)', var_export($directory, TRUE)));
	}

}
