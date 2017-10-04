# Resize

*High Performance Image Storage Library for PHP 7*

[![release](http://github-release-version.herokuapp.com/github/rostenkowski/resize/release.svg?style=flat)](https://github.com/rostenkowski/imagestore/releases/latest)
[![Build Status](https://travis-ci.org/rostenkowski/resize.svg?branch=master)](https://travis-ci.org/rostenkowski/imagestore)
[![Coverage Status](https://coveralls.io/repos/github/rostenkowski/resize/badge.svg)](https://coveralls.io/github/rostenkowski/imagestore)
[![Code Climate](https://codeclimate.com/github/rostenkowski/resize/badges/gpa.svg)](https://codeclimate.com/github/rostenkowski/imagestore)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/rostenkowski/resize/blob/master/LICENSE)



## Installation

Download the latest [package](https://github.com/rostenkowski/resize/releases) manually
or better use the [composer](https://getcomposer.org/doc/00-intro.md#globally)

```bash
composer require rostenkowski/resize
```

## Configuration

The best way is to use the built-in Nette DI container extension in application configuration, usually located in `app/config.neon`. You can place the `imageStore` part of the configuration to your [local configuration](https://github.com/nette/sandbox/tree/master/app/config) file. 
```neon
extensions:
    imageStore: Rostenkowski\Resize\Extension

imageStore:
    storageDir: %baseDir%/data/images
    cacheDir:   %baseDir%/www/images
    basePath:   /images/
```

**Manual configuration**

If you aren't using the the DI extension the image macros should be registered to the [Latte](https://latte.nette.org/) engine as described in the [docs](https://doc.nette.org/en/2.2/configuring#toc-latte):
```yml
nette:
    latte:
        macros:
            - Rostenkowski\Resize\Macro\ImageMacro::install
```
The storage can be created manually in presenter or registered as service this way:
```yaml
services:
    - images: Rostenkowski\ImageStore\ImageStorage("%baseDir%/data/images", "%baseDir%/www/images", "/images/")
```   

## Requirements 
- **PHP** Suggested **5.6**, Minimal 5.5
- **Nette** Suggested **2.3**, Minimal 2.2

The library is tested against PHP **5.5**, **5.6** and **7.0** and Nette **2.3** but it should be compatible with previous stable Nette **2.2** and the latest Nette **2.4-dev** as well.

For the full list of dependencies see the [`composer.json`](https://github.com/rostenkowski/resize/blob/master/composer.json) file.

## API 

For the full API documentation navigate to the `docs/api/` directory and open `index.html` file.

### Storage

```php
<?php

use Rostenkowski\Resize\Meta;
use Rostenkowski\Resize\File;
use Rostenkowski\Resize\Request;
use Rostenkowski\Resize\ImageStorage;
use Nette\Application\Responses\FileResponse;
use Nette\Http\FileUpload;
use Nette\Utils\Image;

// create storage
$storage = new ImageStorage('/data/images', '/www/images', '/images/');

// add an image from file
$storage->add(File $image, Meta $meta);

// add a HTTP uploaded file
$storage->upload(FileUpload $file, Meta $meta);

// check that an image already exists in the storage
$storage->contains(Meta $meta);

// fetch original
$storage->original(Meta $meta);

// rotate image
$storage->rotate(Meta $meta, 90); // Meta

// downloaded requested thumbnail
$storage->download(Request $request); // Nette\Application\Responses\FileResponse

// fetch requested thumbnail
$storage->fetch(Request $request);

// link requested thumbnail
$storage->link(Request $request);

// output requested thumbnail to stdout
$storage->send(Request $request);
```

## Technical overview
- The images are stored in regular files in the given directory.
- The files are organized in a directory tree with maximum of 256² directories in two level structure so with ~1K files in a directory the storage is able to store ~6.5M of images without performance impact.
- The directory tree is well balanced thanks to image hashes used for the directory path creation.
- The storage stores only one file even if the same image is stored multiple times.
- The image thumbnails are created on demand and cached in the cache directory.

## Contribution

Feel free to open an [Issue](https://github.com/rostenkowski/resize/issues) or [Pull Request](https://github.com/rostenkowski/imagestore/pulls).

The source code of the library is fully covered by [Nette Tester](https://tester.nette.org/) tests.

To run the test suite simply install the dependencies
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

## Example code 

Please see the [**Usage**](https://github.com/rostenkowski/resize/wiki/usage) wiki page.

