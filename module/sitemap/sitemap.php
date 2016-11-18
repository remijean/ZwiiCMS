<?php

class sitemap extends common {

	public static $actions = [
		'index' => self::RANK_VISITOR
	];

	/**
	 * Plan du site
	 */
	public function index() {
		// Affichage du template
		return [
			'title' => 'Plan du site',
			'view' => true
		];
	}

}