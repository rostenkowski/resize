<?php

namespace Rostenkowski\Resize;


use Nette\Http\FileUpload;

/**
 * Image Storage Interface
 */
interface Storage
{


	/**
	 * Returns TRUE if the storage contains the given image.
	 *
	 * @param Meta $meta
	 * @return boolean
	 */
	public function contains(Meta $meta);


	/**
	 * Returns the requested image encapsulated in a HTTP response object.
	 *
	 * @param  Request $request
	 * @return IResponse
	 */
	public function download(Request $request);


	/**
	 * Returns the requested image object.
	 *
	 * @param Request $request
	 * @return mixed
	 */
	public function fetch(Request $request);


	/**
	 * Creates the URL of the requested image thumbnail.
	 *
	 * @param  Request $request
	 * @return string
	 */
	public function link(Request $request);


	/**
	 * Fetches the original stored image.
	 *
	 * @param Meta $meta
	 * @return Image
	 */
	public function original(Meta $meta);


	/**
	 * Removes the requested image from the storage.
	 *
	 * @param Meta $meta
	 * @return void
	 */
	public function remove(Meta $meta);


	public function rotate(Meta $meta, $deg = 90);


	/**
	 * Renders the requested image to the standard output.
	 *
	 * @param  Request $request
	 * @return void
	 */
	public function send(Request $request);


	/**
	 * Uploads an image to the storage and store it's meta information in the given image entity.
	 *
	 * @param FileUpload $file
	 * @param Meta       $meta
	 * @return void
	 */
	public function upload(FileUpload $file, Meta $meta);


}
