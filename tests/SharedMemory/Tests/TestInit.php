<?php
/*
* This file bootstraps the test environment.
*/
namespace SharedMemory\Tests;

error_reporting(E_ALL | E_STRICT);

// Add your class dir to include path
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../../../lib');

// You can use this trick to make autoloader look for commonly used "My.class.php" type filenames
spl_autoload_extensions('.php');

// Use default autoload implementation
spl_autoload_register();

spl_autoload_register('spl_autoload');

//spl_autoload_register(function($class) {
//	$class = str_replace('\\', '/', $class);
//	require_once(__DIR__ . '/../../../lib/' . $class . ".php");
//});

//
//require_once('../../../lib/SharedMemory/Segment.php');
//
//require_once __DIR__ . '/../../../lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';
//
//$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', __DIR__ . '/../../../lib/vendor/doctrine-common/lib');
//$classLoader->register();
//
//$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', __DIR__ . '/../../../lib');
//$classLoader->register();
//
//$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Tests', __DIR__ . '/../../');
//$classLoader->register();
//
//$classLoader = new \Doctrine\Common\ClassLoader('Symfony', __DIR__ . "/../../../lib/vendor");
//$classLoader->register();
