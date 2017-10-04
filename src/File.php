<?php

namespace Rostenkowski\Resize;


/**
 * Image file interface
 */
interface File
{


	/**
	 * Returns the image filename.
	 *
	 * @return string
	 */
	public function getName();


	/**
	 * Returns the image type.
	 *
	 * @return integer
	 */
	public function getType();


	/**
	 * Sets the image filename.
	 *
	 * @param string $name
	 */
	public function setName($name);


	/**
	 * Sets the image type.
	 *
	 * @param integer $type
	 */
	public function setType($type);


}
