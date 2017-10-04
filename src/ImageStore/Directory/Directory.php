<?php

namespace Rostenkowski\ImageStore\Directory;


use Rostenkowski\ImageStore\Exceptions\DirectoryException;

/**
 * Directory wrapper
 */
class Directory
{

	/**
	 * @var string
	 */
	private $name;


	/**
	 * @param string  $name
	 * @param boolean $tryCreateDirectories
	 */
	public function __construct($name, $tryCreateDirectories = true)
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
	private function check($name, $tryCreateDirectories = true)
	{
		$exists = true;
		$isWritable = true;

		if (!file_exists($name)) {
			$exists = false;
			if ($tryCreateDirectories) {
				umask(0002);
				$exists = @mkdir($name, 0775, true); // @: will be escalated to exception on failure
			}
		}
		if (!is_writable($name)) {
			$isWritable = false;
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
	 * Returns TRUE if the compared directory is the same as this, FALSE otherwise.
	 *
	 * @param Directory $to
	 * @return boolean
	 */
	public function is(Directory $to)
	{
		return realpath($this->name) === realpath($to->name);
	}


}
