<?php

namespace Rostenkowski\ImageStore\Entity;


use Rostenkowski\ImageStore\Meta;

/**
 * Basic implementation of the image meta information as Doctrine entity.
 *
 * @MappedSuperClass
 */
class ImageEntity implements Meta
{

	use MetaTrait;
}
