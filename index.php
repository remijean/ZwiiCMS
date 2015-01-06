<?php

/**
 * Vérification de la version de PHP
 */
if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('PHP 5.4+ requis !');
}

/**
 * Auto-chargement des classes
 */
spl_autoload_register(function($className)
{
	$classPath = 'modules/' . substr($className, 0, -3) . '.php';
	if(is_readable($classPath)) {
		require $classPath;
	}
}, true, true);

/**
 * Initialise ZwiiCMS
 */
require 'core/core.php';
$core = new core;
$core->router();
require 'core/layout.html';