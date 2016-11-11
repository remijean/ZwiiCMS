<?php

class page extends common {

	public $actions = [
		'index' => self::RANK_MODERATOR
	];

	/**
	 * Gestionnaire de pages
	 */
	public function index() {
		// Affichage du template
		return [
			'title' => 'Gestionnaire de pages',
			'view' => true
		];
	}

}