<?php

class file extends common {

	public static $actions = [
		'index' => self::RANK_MODERATOR
	];

	/**
	 * Connexion
	 */
	public function index() {
		return [
			'display' => self::DISPLAY_BLANK,
			'view' => true
		];
	}

}