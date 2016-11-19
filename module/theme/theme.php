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
	public static $aligns = [
		'left' => 'Gauche',
		'center' => 'Centrer',
		'right' => 'Droite'
	];
	public static $attachments = [
		'scroll' => 'Normale',
		'fixed' => 'Fixe'
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
	public static $footerHeights = [
		'5px' => 'Très petit',
		'10px' => 'Petit',
		'20px' => 'Moyen',
		'30px' => 'Grand',
		'40px' => 'Très grand'
	];
	public static $footerPositions = [
		'hide' => 'Cachée',
		'site' => 'Dans le site',
		'body' => 'En dessous du site'
	];
	public static $headerHeights = [
		'100px' => 'Très petite (100px)',
		'150px' => 'Petite (150px)',
		'200px' => 'Moyenne (200px)',
		'300px' => 'Grande (300px)',
		'400px' => 'Très grande (400px)'
	];
	public static $headerPositions = [
		'hide' => 'Cachée',
		'site' => 'Dans le site',
		'body' => 'Au dessus du site'
	];
	public static $imagePositions = [
		'top left' => 'En haut à gauche',
		'top center' => 'En haut au centre',
		'top right' => 'En haut à droite',
		'center left' => 'Au milieu à gauche',
		'center center' => 'Au milieu au centre',
		'center right' => 'Au milieu à droite',
		'bottom left' => 'En bas à gauche',
		'bottom center' => 'En bas au centre',
		'bottom right' => 'En bas à droite'
	];
	public static $menuHeights = [
		'5px 10px' => 'Très petit',
		'10px' => 'Petit',
		'15px 10px' => 'Moyen',
		'20px 15px' => 'Grand',
		'25px 15px' => 'Très grand'
	];
	public static $menuPositions = [
		'hide' => 'Caché',
		'site' => 'Dans le site',
		'body-first' => 'Au dessus du site en première position',
		'body-second' => 'Au dessus du site en seconde position'
	];
	public static $radius = [
		'0' => 'Aucun',
		'5px' => 'Très léger',
		'10px' => 'Léger',
		'15px' => 'Moyen',
		'25px' => 'Important',
		'50px' => 'Très important'
	];
	public static $repeats = [
		'no-repeat' => 'Ne pas répéter',
		'repeat-x' => 'Sur l\'axe horizontal',
		'repeat-y' => 'Sur l\'axe vertical',
		'repeat' => 'Sur les deux axes'
	];
	public static $shadows = [
		'0' => 'Aucune',
		'1px 1px 5px' => 'Très légère',
		'1px 1px 10px' => 'Légère',
		'1px 1px 15px' => 'Moyenne',
		'1px 1px 25px' => 'Importante',
		'1px 1px 50px' => 'Très importante'
	];
	public static $sizes = [
		'auto' => 'Automatique',
		'cover' => 'Largeur adaptée au fond'
	];
	public static $widths = [
		'750px' => 'Petit (750px)',
		'960px' => 'Moyen (960px)',
		'1170px' => 'Grand (1170px)',
		'100%' => 'Fluide (100%)'
	];

	/**
	 * Options de l'arrière plan
	 */
	public function body() {
		// Soumission du formulaire
		if($this->isPost()) {
			@unlink('site/data/' . md5(json_encode($this->getData(['theme']))) . '.css');
			$this->setData(['theme', 'body', [
				'backgroundColor' => $this->getInput('themeBodyBackgroundColor'),
				'image' => $this->getInput('themeBodyImage'),
				'imageAttachment' => $this->getInput('themeBodyImageAttachment'),
				'imagePosition' => $this->getInput('themeBodyImagePosition'),
				'imageRepeat' => $this->getInput('themeBodyImageRepeat'),
				'imageSize' => $this->getInput('themeBodyImageSize')
			]]);
			$this->saveData();
			return [
				'notification' => 'Options de l\'arrière plan enregistrés',
				'redirect' => 'theme',
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

	/**
	 * Options du bas de page
	 */
	public function footer() {
		// Soumission du formulaire
		if($this->isPost()) {
			@unlink('site/data/' . md5(json_encode($this->getData(['theme']))) . '.css');
			$this->setData(['theme', 'footer', [
				'backgroundColor' => $this->getInput('themeFooterBackgroundColor'),
				'copyrightAlign' => $this->getInput('themeFooterCopyrightAlign'),
				'height' => $this->getInput('themeFooterHeight'),
				'position' => $this->getInput('themeFooterPosition'),
				'socialsAlign' => $this->getInput('themeFooterSocialsAlign'),
				'textAlign' => $this->getInput('themeFooterTextAlign')
			]]);
			$this->saveData();
			return [
				'notification' => 'Options du bas de page enregistrés',
				'redirect' => 'theme',
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

	/**
	 * Options de la bannière
	 */
	public function header() {
		// Soumission du formulaire
		if($this->isPost()) {
			@unlink('site/data/' . md5(json_encode($this->getData(['theme']))) . '.css');
			$this->setData(['theme', 'header', [
				'backgroundColor' => $this->getInput('themeHeaderBackgroundColor'),
				'font' => $this->getInput('themeHeaderFont'),
				'height' => $this->getInput('themeHeaderHeight'),
				'image' => $this->getInput('themeHeaderImage'),
				'imagePosition' => $this->getInput('themeHeaderImagePosition'),
				'imageRepeat' => $this->getInput('themeHeaderImageRepeat'),
				'position' => $this->getInput('themeHeaderPosition'),
				'textAlign' => $this->getInput('themeHeaderTextAlign'),
				'textColor' => $this->getInput('themeHeaderTextColor')
			]]);
			$this->saveData();
			return [
				'notification' => 'Options de la bannière enregistrés',
				'redirect' => 'theme',
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
		// Soumission du formulaire
		if($this->isPost()) {
			@unlink('site/data/' . md5(json_encode($this->getData(['theme']))) . '.css');
			$this->setData(['theme', 'menu', [
				'backgroundColor' => $this->getInput('themeMenuBackgroundColor'),
				'height' => $this->getInput('themeMenuHeight'),
				'position' => $this->getInput('themeMenuPosition'),
				'textAlign' => $this->getInput('themeMenuTextAlign')
			]]);
			$this->saveData();
			return [
				'notification' => 'Options du menu enregistrés',
				'redirect' => 'theme',
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

	/**
	 * Options du site
	 */
	public function site() {
		// Soumission du formulaire
		if($this->isPost()) {
			@unlink('site/data/' . md5(json_encode($this->getData(['theme']))) . '.css');
			$this->setData(['theme', 'title', [
				'font' => $this->getInput('themeTitleFont'),
				'textColor' => $this->getInput('themeTitleTextColor')
			]]);
			$this->setData(['theme', 'button', 'backgroundColor', $this->getInput('themeButtonBackgroundColor')]);
			$this->setData(['theme', 'link', 'textColor', $this->getInput('themeLinkTextColor')]);
			$this->setData(['theme', 'text', 'font', $this->getInput('themeTextFont')]);
			$this->setData(['theme', 'site', [
				'radius' => $this->getInput('themeSiteRadius'),
				'shadow' => $this->getInput('themeSiteShadow'),
				'width' => $this->getInput('themeSiteWidth')
			]]);
			$this->saveData();
			return [
				'notification' => 'Options du site enregistrés',
				'redirect' => 'theme',
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