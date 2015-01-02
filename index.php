<?php

if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('PHP 5.4+ requis !');
}

function autoloader($className)
{
	$className = substr($className, 0, -3);
	$classPath = 'modules/' . $className . '.php';
	if(is_readable($classPath)) {
		require $classPath;
	}
}
spl_autoload_register('autoloader', true, true);

require 'core/core.php';

$core = new core;
$core->router();

require 'core/layout.html';