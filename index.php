<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <moi@remijean.fr>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Vérification de la version de PHP
 */
if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	exit('PHP 5.4+ requis !');
}

/**
 * Initialisation de Zwii
 */
session_start();
require 'core/core.php';
$core = new core;
spl_autoload_register('core::autoload');
echo $core->router();