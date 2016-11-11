<?php

class theme extends common {

	public $actions = [
		'body' => self::RANK_ADMIN,
		'footer' => self::RANK_ADMIN,
		'header' => self::RANK_ADMIN,
		'index' => self::RANK_ADMIN,
		'menu' => self::RANK_ADMIN,
		'site' => self::RANK_ADMIN
	];
	public static $repeats = [
		'none' => 'Ne pas répéter',
		'x' => 'Sur l\'axe horizontal',
		'y' => 'Sur l\'axe vertical',
		'all' => 'Sur les deux axes'
	];
	public static $positions = [
		'cover' => 'Remplir le fond',
		'topLeft' => 'En haut à gauche',
		'topCenter' => 'En haut au centre',
		'topRight' => 'En haut à droite',
		'centerLeft' => 'Au milieu à gauche',
		'centerCenter' => 'Au milieu au centre',
		'centerRight' => 'Au milieu à droite',
		'bottomLeft' => 'En bas à gauche',
		'bottomCenter' => 'En bas au centre',
		'bottomRight' => 'En bas à droite'
	];
	public static $attachments = [
		'scroll' => 'Normale',
		'fixed' => 'Fixe'
	];
	public static $widths = [
		'100%' => 'Normale',
		'1170px' => 'Normale',
		'960px' => 'Normale',
		'fixed' => 'Fixe'
	];

	/**
	 * Options de l'arrière plan
	 */
	public function body() {
		return [
			'title' => 'Personnalisation',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => true
		];
	}

	/**
	 * Options du bas de page
	 */
	public function footer() {
		return [
			'title' => 'Personnalisation',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => true
		];
	}

	/**
	 * Options de la bannière
	 */
	public function header() {
		return [
			'title' => 'Personnalisation',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => true
		];
	}

	/**
	 * Accueil de la personnalisation
	 */
	public function index() {
		return [
			'title' => 'Personnalisation',
			'view' => true
		];
	}

	/**
	 * Options du menu
	 */
	public function menu() {
		return [
			'title' => 'Personnalisation',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => true
		];
	}

	/**
	 * Options du site
	 */
	public function site() {
		return [
			'title' => 'Personnalisation',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => true
		];
	}

}