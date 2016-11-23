<?php

class file extends common {

	public static $actions = [
		'index' => self::RANK_MODERATOR
	];

	/**
	 * Gestionnaire de fichiers
	 */
	public function index() {
		// Affichage du template
		return [
			'display' => self::DISPLAY_BLANK,
			'view' => true
		];
	}

}