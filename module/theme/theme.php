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
		'left' => 'À gauche',
		'center' => 'Au centre',
		'right' => 'À droite'
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
	public static $fontWeights = [
		'normal' => 'Normal',
		'bold' => 'Gras'
	];
	public static $footerHeights = [
		'5px' => 'Très petite',
		'10px' => 'Petite',
		'20px' => 'Moyenne',
		'30px' => 'Grande',
		'40px' => 'Très grande'
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
		'5px 10px' => 'Très petite',
		'10px' => 'Petite',
		'15px 10px' => 'Moyenne',
		'20px 15px' => 'Grande',
		'25px 15px' => 'Très grande'
	];
	public static $menuPositions = [
		'hide' => 'Caché',
		'site-first' => 'Dans le site avant la bannière',
		'site-second' => 'Dans le site après la bannière',
		'body-first' => 'Au dessus du site avant la bannière',
		'body-second' => 'Au dessus du site après la bannière'
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
	public static $textTransforms = [
		'none' => 'Normaux',
		'uppercase' => 'Majuscules'
	];
	public static $widths = [
		'750px' => 'Petite (750px)',
		'960px' => 'Moyenne (960px)',
		'1170px' => 'Grande (1170px)',
		'100%' => 'Fluide (100%)'
	];

	/**
	 * Options de l'arrière plan
	 */
	public function body() {
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['theme', 'body', [
				'backgroundColor' => $this->getInput('themeBodyBackgroundColor'),
				'image' => $this->getInput('themeBodyImage'),
				'imageAttachment' => $this->getInput('themeBodyImageAttachment'),
				'imagePosition' => $this->getInput('themeBodyImagePosition'),
				'imageRepeat' => $this->getInput('themeBodyImageRepeat'),
				'imageSize' => $this->getInput('themeBodyImageSize')
			]]);
			return [
				'notification' => 'Modifications enregistrées',
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
	 * Options du pied de page
	 */
	public function footer() {
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['theme', 'footer', [
				'backgroundColor' => $this->getInput('themeFooterBackgroundColor'),
				'copyrightAlign' => $this->getInput('themeFooterCopyrightAlign'),
				'height' => $this->getInput('themeFooterHeight'),
				'loginLink' => $this->getInput('themeFooterLoginLink'),
				'position' => $this->getInput('themeFooterPosition'),
				'socialsAlign' => $this->getInput('themeFooterSocialsAlign'),
				'text' => $this->getInput('themeFooterText'),
				'textAlign' => $this->getInput('themeFooterTextAlign')
			]]);
			return [
				'notification' => 'Modifications enregistrées',
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
			$this->setData(['theme', 'header', [
				'backgroundColor' => $this->getInput('themeHeaderBackgroundColor'),
				'font' => $this->getInput('themeHeaderFont'),
				'fontWeight' => $this->getInput('themeHeaderFontWeight'),
				'height' => $this->getInput('themeHeaderHeight'),
				'image' => $this->getInput('themeHeaderImage'),
				'imagePosition' => $this->getInput('themeHeaderImagePosition'),
				'imageRepeat' => $this->getInput('themeHeaderImageRepeat'),
				'position' => $this->getInput('themeHeaderPosition'),
				'textAlign' => $this->getInput('themeHeaderTextAlign'),
				'textColor' => $this->getInput('themeHeaderTextColor'),
				'textTransform' => $this->getInput('themeHeaderTextTransform')
			]]);
			return [
				'notification' => 'Modifications enregistrées',
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
			$this->setData(['theme', 'menu', [
				'backgroundColor' => $this->getInput('themeMenuBackgroundColor'),
				'fontWeight' => $this->getInput('themeMenuFontWeight'),
				'height' => $this->getInput('themeMenuHeight'),
				'loginLink' => $this->getInput('themeMenuLoginLink'),
				'position' => $this->getInput('themeMenuPosition'),
				'textAlign' => $this->getInput('themeMenuTextAlign'),
				'textTransform' => $this->getInput('themeMenuTextTransform')
			]]);
			return [
				'notification' => 'Modifications enregistrées',
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
			$this->setData(['theme', 'title', [
				'font' => $this->getInput('themeTitleFont'),
				'textColor' => $this->getInput('themeTitleTextColor'),
				'fontWeight' => $this->getInput('themeTitleFontWeight'),
				'textTransform' => $this->getInput('themeTitleTextTransform')
			]]);
			$this->setData(['theme', 'button', 'backgroundColor', $this->getInput('themeButtonBackgroundColor')]);
			$this->setData(['theme', 'link', 'textColor', $this->getInput('themeLinkTextColor')]);
			$this->setData(['theme', 'text', 'font', $this->getInput('themeTextFont')]);
			$this->setData(['theme', 'site', [
				'radius' => $this->getInput('themeSiteRadius'),
				'shadow' => $this->getInput('themeSiteShadow'),
				'width' => $this->getInput('themeSiteWidth')
			]]);
			return [
				'notification' => 'Modifications enregistrées',
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