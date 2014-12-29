<?php

function autoloader($className)
{
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