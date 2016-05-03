<?php

namespace Spot\ImageStore\Files;


use Spot\ImageStore\File;

/**
 * Simple image file wrapper
 */
class ImageFile implements File
{

	/**
	 * The file name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The image type
	 *
	 * @var integer
	 */
	private $type;


	public function __construct($filename)
	{
		$info = @getimagesize($filename); // @: will be escalated to exception on failure

		if ($info === FALSE) {
			throw new Exceptions\ImageFileException($filename);
		}
		$this->setName($filename);
		$this->setType($info[2]);
	}


	public function getType()
	{
		return $this->type;
	}


	public function setType($type)
	{
		$this->type = $type;
	}


	public function getName()
	{
		return $this->name;
	}


	public function setName($name)
	{
		$this->name = $name;
	}

}
