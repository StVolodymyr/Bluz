<?php
// Environment
define('APPLICATION_ENV', 'testing');
define('DEBUG', true);

// Paths
define('PATH_ROOT', realpath(dirname(__FILE__). '/../'));
define('PATH_APPLICATION', PATH_ROOT . '/application');
define('PATH_DATA', PATH_ROOT . '/data');
define('PATH_LIBRARY', PATH_ROOT . '/library');
define('PATH_PUBLIC', PATH_ROOT . '/public');
define('PATH_THEME', PATH_ROOT . '/themes');

// init loader
require_once PATH_LIBRARY . '/Bluz/_loader.php';
require_once 'application/BootstrapTest.php';
require_once 'application/TestCase.php';
require_once 'application/TestListener.php';


$app = \Application\BootstrapTest::getInstance();
$app->init(APPLICATION_ENV);
