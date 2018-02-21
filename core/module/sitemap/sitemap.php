<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class sitemap extends common {

	public static $actions = [
		'index' => self::GROUP_VISITOR
	];

	/**
	 * Plan du site
	 */
	public function index() {
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Plan du site',
			'view' => 'index'
		]);
	}

}