<?php

namespace Spot\ImageStore;


/**
 * Image request interface
 */
interface Request
{

	const ORIGINAL = 0;


	/**
	 * Returns the requested image thumbnail cropping flag.
	 *
	 * @return integer
	 */
	public function getCrop();


	/**
	 * Returns the requested image thumbnail dimensions.
	 *
	 * @return string
	 */
	public function getDimensions();


	/**
	 * Returns the requested image thumbnail flags.
	 *
	 * @return integer
	 */
	public function getFlags();


	/**
	 * Returns the requested image meta information.
	 *
	 * @return Meta
	 */
	public function getMeta();


	/**
	 * Sets the requested image meta information.
	 *
	 * @param Meta $meta
	 * @return Request
	 */
	public function setMeta(Meta $meta);


}
