<?php

class theme extends common {

	public static $actions = [
		'body' => self::RANK_ADMIN,
		'footer' => self::RANK_ADMIN,
		'header' => self::RANK_ADMIN,
		'index' => self::RANK_ADMIN,
		'menu' => self::RANK_ADMIN,
		'site' => self::RANK_ADMIN
	];
	public static $fonts = [
		'Abril+Fatface' => 'Abril Fatface',
		'Arvo' => 'Arvo',
		'Berkshire+Swash' => 'Berkshire Swash',
		'Dancing+Script' => 'Dancing Script',
		'Inconsolata' => 'Inconsolata',
		'Indie+Flower' => 'Indie Flower',
		'Josefin+Slab' => 'Josefin Slab',
		'Lato' => 'Lato',
		'Lobster' => 'Lobster',
		'Marvel' => 'Marvel',
		'Old+Standard+TT' => 'Old Standard TT',
		'Open+Sans' => 'Open Sans',
		'Oswald' => 'Oswald',
		'Raleway' => 'Raleway',
		'Rancho' => 'Rancho',
		'Ubuntu' => 'Ubuntu'
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
		'750px' => 'Petite',
		'960px' => 'Moyenne',
		'1170px' => 'Grande',
		'100%' => 'Fluide'
	];
	public static $radius = [
		'0' => 'Aucun',
		'5px' => 'Très léger',
		'10px' => 'Léger',
		'15px' => 'Moyen',
		'25px' => 'Important',
		'50px' => 'Très important'
	];
	public static $shadows = [
		'0' => 'Aucune',
		'1px 1px 5px' => 'Très légère',
		'1px 1px 10px' => 'Légère',
		'1px 1px 15px' => 'Moyenne',
		'1px 1px 25px' => 'Importante',
		'1px 1px 50px' => 'Très importante'
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
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['theme', 'title', [
				'textColor' => $this->getInput('themeTitleTextColor'),
				'font' => $this->getInput('themeTitleFont')
			]]);
			$this->setData(['theme', 'button', 'backgroundColor', $this->getInput('themeButtonBackgroundColor')]);
			$this->setData(['theme', 'link', 'textColor', $this->getInput('themeLinkTextColor')]);
			$this->setData(['theme', 'text', 'font', $this->getInput('themeTextFont')]);
			$this->setData(['theme', 'site', [
				'width' => $this->getInput('themeSiteWidth'),
				'radius' => $this->getInput('themeSiteRadius'),
				'shadow' => $this->getInput('themeSiteShadow')
			]]);
			$this->saveData();
			return [
				'redirect' => $this->getUrl(),
				'notification' => 'Options du site enregistrés',
				'state' => true
			];
		}
		// Affichage du template
		else {
			return [
				'title' => 'Personnalisation',
				'vendor' => [
					'tinycolorpicker'
				],
				'view' => true
			];
		}
	}

}