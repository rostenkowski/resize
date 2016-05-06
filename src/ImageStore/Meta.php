<?php

namespace Rostenkowski\ImageStore;


/**
 * Image meta information interface
 */
interface Meta
{

	/**
	 * Returns the image SHA1 hash.
	 *
	 * @return string
	 */
	public function getHash();


	/**
	 * Returns the image type.
	 *
	 * @return integer
	 */
	public function getType();


	/**
	 * Sets the image SHA1 hash.
	 *
	 * @param string $hash
	 */
	public function setHash($hash);


	/**
	 * Sets the image type.
	 *
	 * @param integer $type
	 */
	public function setType($type);
}
