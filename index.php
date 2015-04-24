<?php

/**
 * Vérification de la version de PHP
 */
if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	die('PHP 5.4+ requis !');
}

/**
 * Initialisation de ZwiiCMS
 */
require 'core/core.php';
$core = new core;
spl_autoload_register('core::autoload');
$core->router();
echo $core->cache();