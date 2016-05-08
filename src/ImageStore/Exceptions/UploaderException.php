<?php

namespace Rostenkowski\ImageStore\Exceptions;


use RuntimeException;

/**
 * Image upload error exception
 */
class UploaderException extends RuntimeException
{

	/**
	 * Upload error code -> error message map
	 *
	 * @var string[]
	 */
	private $messages = [
		0 => "There is no error, the file uploaded with success",
		1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
		2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
		3 => "The uploaded file was only partially uploaded",
		4 => "No file was uploaded",
		6 => "Missing a temporary folder",
	];


	/**
	 * Constructs the upload error exception using the given upload error code.
	 *
	 * @param string $code
	 */
	public function __construct($code)
	{
		parent::__construct($this->messages[$code], $code);
	}


}
