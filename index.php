<?php

function autoloader($className)
{
	$classPath = 'plugins/' . $className . '.php';
	if(is_readable($classPath)) {
		require $classPath;
	}
}
spl_autoload_register('autoloader', true, true);

require 'core/core.php';

$core = new core;
$core->router();

require 'template/index.php';