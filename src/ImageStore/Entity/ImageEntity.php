<?php

namespace Spot\ImageStore\Entity;


use Nette\Utils\Image;
use Nette\Utils\Strings;
use Spot\ImageStore\Entity\Exceptions\HashException;
use Spot\ImageStore\Entity\Exceptions\ImageTypeException;
use Spot\ImageStore\Meta;

/**
 * Basic implementation of the image meta information as Doctrine entity.
 *
 * @ORM\MappedSuperClass
 */
class ImageEntity implements Meta
{

	/**
	 * SHA1 hash of the original image
	 * @ORM\Column(length=40, nullable=true)
	 *
	 * @var string
	 */
	private $hash;

	/**
	 * Original image type as defined in the `Image` class constants `JPEG`, `GIF` and `PNG`.
	 * @ORM\Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $type;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $width;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $height;


	/**
	 * @return string
	 */
	public function getHash()
	{
		return $this->hash;
	}


	/**
	 * @param  string $hash
	 * @return ImageEntity
	 */
	public function setHash($hash)
	{
		$this->hash = $this->checkHash($hash);

		return $this;
	}


	/**
	 * @return integer
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * Checks that the given string is valid SHA1 hash and normalizes it to lower case.
	 *
	 * @param  string $hash Image hash to validate
	 * @throws HashException If the hash is not valid image hash
	 * @return string        The valid image hash
	 */
	private function checkHash($hash)
	{
		if (!is_string($hash)) {
			throw new HashException($hash);
		}
		$hash = Strings::lower($hash);
		if (!preg_match('/^[0-9a-f]{40}$/', $hash)) {
			throw new HashException($hash);
		}

		return $hash;
	}


	/**
	 * @param  integer $type
	 * @return ImageEntity
	 */
	public function setType($type)
	{
		$this->type = $this->checkType($type);

		return $this;
	}


	/**
	 * Checks the given image type to be one of the supported types.
	 *
	 * @param  integer $type
	 * @return integer
	 * @throws ImageTypeException
	 */
	private function checkType($type)
	{
		if (!in_array($type, array(Image::JPEG, Image::PNG, Image::GIF), TRUE)) {
			throw new ImageTypeException($type);
		}

		return $type;
	}


	/**
	 * @return integer
	 */
	public function getHeight()
	{
		return $this->height;
	}


	/**
	 * @param integer $height
	 */
	public function setHeight($height)
	{
		$this->height = $height;
	}


	/**
	 * @return integer
	 */
	public function getWidth()
	{
		return $this->width;
	}


	/**
	 * @param integer $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
	}
}
