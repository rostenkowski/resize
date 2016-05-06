<?php

namespace Rostenkowski\ImageStore\Entity;


use Nette\Utils\Image;
use Rostenkowski\ImageStore\Meta;

/**
 * "Image not found" entity
 */
class EmptyImage implements Meta
{

	public function getHash()
	{
		return '_empty';
	}


	public function getType()
	{
		return Image::PNG;
	}


	public function setHash($hash)
	{
		throw new \LogicException('Unavailable image hash cannot be changed.');
	}


	public function setType($type)
	{
		throw new \LogicException('Unavailable image hash cannot be changed.');
	}


	public function getHeight()
	{
		return 1080;
	}


	public function getWidth()
	{
		return 1920;
	}

}
