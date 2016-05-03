<?php

namespace Spot\ImageStore\Directory;


use Nette\Object;
use Spot\ImageStore\Directory\Exceptions\DirectoryException;

/**
 * Directory wrapper
 */
class Directory extends Object
{

	/**
	 * @var string
	 */
	private $name;


	/**
	 * @param string  $name
	 * @param boolean $tryCreateDirectories
	 */
	public function __construct($name, $tryCreateDirectories = TRUE)
	{
		$this->name = $this->check($name, $tryCreateDirectories);
	}


	/**
	 * Checks a directory to be existing and writable.
	 * Tries to create it if it does not exist.
	 *
	 * @param string  $name Directory name
	 * @param boolean $tryCreateDirectories
	 * @return string Existing and writable directory name
	 */
	private function check($name, $tryCreateDirectories = TRUE)
	{
		$exists = TRUE;
		$isWritable = TRUE;

		if (!file_exists($name)) {
			$exists = FALSE;
			if ($tryCreateDirectories) {
				umask(0002);
				$exists = @mkdir($name, 0750, TRUE); // @: will be escalated to exception on failure
			}
		}
		if (!is_writable($name)) {
			$isWritable = FALSE;
		}

		if (!$exists || !$isWritable) {
			throw new DirectoryException($name);
		}

		return $name;
	}


	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->name;
	}


	/**
	 * Erases the directory.
	 *
	 * @return Directory Fluent interface.
	 */
	public function erase()
	{
		exec(sprintf("rm -rf %s", escapeshellarg($this->name) . "/*"));

		return $this;
	}


	/**
	 * Removes the directory.
	 *
	 * @return Directory Fluent interface.
	 */
	public function remove()
	{
		exec(sprintf("rm -rf %s", escapeshellarg($this->name)));

		return $this;
	}

}
