<?php

namespace Rostenkowski\Resize\Entity;


use Rostenkowski\Resize\Meta;

/**
 * Basic implementation of the image meta information as Doctrine entity.
 *
 * @MappedSuperClass
 */
class ImageEntity implements Meta
{

	use MetaTrait;
}
