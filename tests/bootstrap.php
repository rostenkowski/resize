<?php

namespace Rostenkowski\Resize;


use Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';

define('TEMP_DIR', __DIR__ . '/temp/' . (string) lcg_value());
define('STORE_DIR', TEMP_DIR . '/store');
define('CACHE_DIR', TEMP_DIR . '/cache');
define('SAMPLE_DIR', __DIR__ . '/samples');

@mkdir(TEMP_DIR, 0755, true);
@mkdir(STORE_DIR);
@mkdir(CACHE_DIR);
@mkdir(STORE_DIR . '/_empty');

copy(SAMPLE_DIR . '/_empty.png', STORE_DIR . '/_empty/_empty.png');

Environment::setup();
