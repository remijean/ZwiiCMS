<?php

require 'core/core.php';

$core = new core;
$core->router();

function autoloader($className)
{
	$classPath = 'plugins/' . $className . '.php';
	if(is_readable($classPath)) {
		require $classPath;
	}
}
spl_autoload_register('autoloader', true, true);

require 'template/index.php';