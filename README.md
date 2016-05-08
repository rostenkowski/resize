
# ImageStore 

[![Build Status](https://travis-ci.org/rostenkowski/imagestore.svg?branch=master)](https://travis-ci.org/rostenkowski/imagestore) 
[![Latest Stable Version](https://poser.pugx.org/rostenkowski/imagestore/v/stable)](https://github.com/rostenkowski/imagestore/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/rostenkowski/imagestore/blob/master/LICENSE)

High Performance Image Storage for PHP 

## Installation

Download the latest [package](https://github.com/rostenkowski/imagestore/releases) manually
or better use the [composer](https://getcomposer.org/doc/00-intro.md#globally)

```bash
composer require rostenkowski/imagestore
```

## Usage
```yml
extensions:
	imageStore: Rostenkowski\ImageStoreExtension

imageStore:
	storageDir: %baseDir%/storage/images
	cacheDir:   %baseDir%/www/cache/images
	basePath:   /cache/images/
```

## Minimal requirements
- PHP 5.5+
- Nette 2.2+

## API
For the API docs see the `docs/api/` directory and open `index.html` file.

## Technical overview
- The images are stored in regular files in the given directory.
- The files are organized in 2-level directory structure with maximum of 256² directories.
- The directory tree is well balanced thanks to image hashes used for the directory path creation.
- The storage stores only one file even if the same image is stored multiple times.
- The image thumbnails are created on demand and cached in the cache directory.

## Compatibility
The library is tested against PHP **5.5**, **5.6** and **7.0** and Nette **2.3** but it should be compatible with previous stable Nette **2.2** and the latest Nette **2.4-dev** as well.

For the full list of dependencies see the [`composer.json`](https://github.com/rostenkowski/imagestore/blob/master/composer.json) file.

The source code of the library is fully covered by [Nette Tester](https://tester.nette.org/) tests.

To run the tests simply install the dependencies
using [composer](https://getcomposer.org/doc/00-intro.md#globally) and then run the [`bin/run-tests.sh`](bin/run-tests.sh) script on linux. On windows u can run in eg. git bash: `bin/run-tests-win.sh`.

```
bin/run-tests.sh
 _____ ___  ___ _____ ___  ___
|_   _/ __)( __/_   _/ __)| _ )
  |_| \___ /___) |_| \___ |_|_\  v2.0.x

PHP 5.6.5 (cgi-fcgi) | php-cgi -n -c tests/php.ini | 1 thread

.............

OK (13 tests, 2.7 seconds)
```

To check the code coverage see the `docs/coverage.html` file.

## Example usage
This simple example demonstrates how to use this library in a [Nette](https://doc.nette.org/cs/2.3/quickstart) application using the [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html).

It assumes that you have the Doctrine EntityManager available trough the application DI container.

If you aren't using the DI extension the image macros should be registered to the [Latte](https://latte.nette.org/) engine as described in the [docs](https://doc.nette.org/en/2.2/configuring#toc-latte)

```yaml
nette:
    latte:
        macros:
            - Rostenkowski\ImageStore\Macro\ImageMacro::install
```

### Entity

```php
<?php

namespace MyApp\Entities;

use Rostenkowski\ImageStore\Entity\ImageEntity;

/** @ORM\Entity */
class MyImageEntity extends ImageEntity
{
	/** @ORM\Id */
	private $id;

	public function getId()
	{
		return $this->id;
	}

}
```

### Presenter

```php
<?php

namespace MyApp\Presenters;

use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;
use Rostenkowski\ImageStore\ImageStorage;

class MyPresenter extends Presenter
{
	/** @var ImageStorage */
	private $images;

	/** @inject @var EntityManager */
    private $em;

    /** @persistent @var integer */
    private $avatar;

	protected function startup()
	{
		$this->images = new ImageStorage(__DIR__ . '/images', __DIR__ . '/cache');
		$this->template->__imageStore = $this->images; // this is important for the image macros
	}

	public function createComponentProfile()
	{
		$form = new Form();
		$form->addUpload('avatar');
		$form->addSubmit('save', 'Save changes');
		$form->onSuccess[] = function($form, $values) {
			$image = new MyImageEntity();
			$this->images->upload($values->avatar, $image);
			$this->em->persist($image);
			$this->avatar = $image->getId();
		};

		return $form;
	}

	public function renderDefault()
	{
		$this->template->avatar = $this->em->find(MyImageEntity::class, $this->avatar);
	}
}
```

### Latte template

```html
<div>
	...
	<img n:crop="$avatar, '64x64'">
	...
</div>
```

[![Downloads this Month](https://img.shields.io/packagist/dm/rostenkowski/imagestore.svg)](https://packagist.org/packages/rostenkowski/imagestore)
