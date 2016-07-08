<?php

namespace Rostenkowski\ImageStore\Tests;

use Tester\Environment;

require_once __DIR__ . '/../vendor/autoload.php';

// reset testing directories
$storeDir = __DIR__ . '/store';
$cacheDir = __DIR__ . '/cache';
exec(sprintf('rm -rf %s', escapeshellarg($storeDir)));
exec(sprintf('rm -rf %s', escapeshellarg($cacheDir)));

Environment::setup();
