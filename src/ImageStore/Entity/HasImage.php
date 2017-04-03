<?php

namespace Rostenkowski\ImageStore\Entity;


use Nette\Utils\Image;
use Nette\Utils\Strings;
use Rostenkowski\ImageStore\Exceptions\HashException;
use Rostenkowski\ImageStore\Exceptions\ImageTypeException;

trait HasImage
{

	/**
	 * SHA1 hash of the original image
	 * @Column(length=40, nullable=true)
	 *
	 * @var string
	 */
	private $imageHash;

	/**
	 * Original image type as defined in the `Image` class constants `JPEG`, `GIF` and `PNG`.
	 * @Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $imageType;

	/**
	 * @Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $imageWidth;

	/**
	 * @Column(type="integer", nullable=true)
	 *
	 * @var integer
	 */
	private $imageHeight;


	/**
	 * @return string
	 */
	public function getImageHash()
	{
		return $this->imageHash;
	}


	/**
	 * @param  string $imageHash
	 * @return ImageEntity
	 */
	public function setImageHash($imageHash)
	{
		$this->imageHash = $this->checkHash($imageHash);

		return $this;
	}


	/**
	 * @return integer
	 */
	public function getImageType()
	{
		return $this->imageType;
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
	 * @param  integer $imageType
	 * @return ImageEntity
	 */
	public function setImageType($imageType)
	{
		$this->imageType = $this->checkType($imageType);

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
	public function getImageHeight()
	{
		return $this->imageHeight;
	}


	/**
	 * @param integer $imageHeight
	 */
	public function setImageHeight($imageHeight)
	{
		$this->imageHeight = $imageHeight;
	}


	/**
	 * @return integer
	 */
	public function getImageWidth()
	{
		return $this->imageWidth;
	}


	/**
	 * @param integer $imageWidth
	 */
	public function setImageWidth($imageWidth)
	{
		$this->imageWidth = $imageWidth;
	}
}
