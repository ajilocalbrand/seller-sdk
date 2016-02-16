<?php
require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/default.php';

define('API_TOKEN', getenv('TEST_API_TOKEN'));
define('PROXY_HOST', getenv('TEST_PROXY_HOST'));
define('PROXY_PORT', getenv('TEST_PROXY_PORT'));
define('PROD_HOST', $config['prod']['host']);
