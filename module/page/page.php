<?php

class page extends common {

	public static $actions = [
		'edit' => self::RANK_MODERATOR,
		'index' => self::RANK_MODERATOR
	];

	/**
	 * Édition de page
	 */
	public function edit() {
		// Affichage du template
		return [
			'title' => $this->getData(['page', $this->getUrl(2), 'title']),
			'vendor' => [
				'tinymce'
			],
			'view' => true
		];
	}

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