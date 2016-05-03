<?php

namespace Spot\ImageStore\Entity\Exceptions;


use Exception;

/**
 * Invalid hash exception
 */
class HashException extends Exception
{

	/**
	 * @param string $hash
	 */
	public function __construct($hash)
	{
		$message = sprintf('The image hash is invalid. It is required to be a SHA1 hash but %s given.', var_export($hash, TRUE));

		parent::__construct($message);
	}

}
