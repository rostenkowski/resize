<?php

namespace Rostenkowski\ImageStore\Requests;


use Nette\Utils\Image;
use Rostenkowski\ImageStore\Entity\EmptyImage;
use Rostenkowski\ImageStore\Meta;
use Rostenkowski\ImageStore\Request;

/**
 * Image request encapsulation
 */
class ImageRequest implements Request
{

	/**
	 * The requested image meta information.
	 *
	 * @var Meta
	 */
	private $meta;

	/**
	 * The requested image thumbnail dimensions
	 *
	 * @var string
	 */
	private $dimensions;

	/**
	 * The requested image thumbnail flags.
	 *
	 * @var integer
	 */
	private $flags;

	/**
	 * The requested image thumbnail cropping flag.
	 *
	 * @var boolean
	 */
	private $crop = false;


	/**
	 * Constructs the image request from the given meta information, requested dimensions and flags.
	 *
	 * @param Meta    $meta
	 * @param integer $dimensions
	 * @param integer $flags
	 * @param boolean $crop
	 */
	public function __construct(Meta $meta, $dimensions = Request::ORIGINAL, $flags = Request::ORIGINAL, $crop = false)
	{
		$this->meta = $meta;
		$this->dimensions = $dimensions;
		$this->flags = $flags;
		$this->crop = $crop;
	}


	/**
	 * Creates the image request from the crop macro arguments.
	 *
	 * @param Meta  $image
	 * @param array $args
	 * @return ImageRequest
	 */
	public static function crop(Meta $image = NULL, $args = array())
	{
		if ($image === NULL) {
			$image = new EmptyImage();
		}

		$dimensions = isset($args[0]) ? $args[0] : Request::ORIGINAL;
		$flags = Image::FIT;

		$request = new ImageRequest($image, $dimensions, $flags, true);

		return $request;
	}


	/**
	 * Creates the image request from the image macro arguments.
	 *
	 * @param Meta  $image
	 * @param array $args
	 * @return ImageRequest
	 */
	public static function fromMacro(Meta $image = NULL, $args = array())
	{
		if ($image === NULL) {
			$image = new EmptyImage();
		}

		return new ImageRequest($image, isset($args[0]) ? $args[0] : Request::ORIGINAL, isset($args[1]) ? $args[1] : Request::ORIGINAL);
	}


	/**
	 * @return boolean
	 */
	public function getCrop()
	{
		return $this->crop;
	}


	/**
	 * @return Meta
	 */
	public function getMeta()
	{
		return $this->meta;
	}


	/**
	 * @param Meta $meta
	 * @return Request
	 */
	public function setMeta(Meta $meta)
	{
		$this->meta = $meta;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDimensions()
	{
		return $this->dimensions;
	}


	/**
	 * @return integer
	 */
	public function getFlags()
	{
		return $this->flags;
	}

}
