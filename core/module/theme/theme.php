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

class theme extends common {

	public static $actions = [
		'advanced' => self::GROUP_ADMIN,
		'body' => self::GROUP_ADMIN,
		'footer' => self::GROUP_ADMIN,
		'header' => self::GROUP_ADMIN,
		'index' => self::GROUP_ADMIN,
		'menu' => self::GROUP_ADMIN,
		'reset' => self::GROUP_ADMIN,
		'site' => self::GROUP_ADMIN
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
		'Arimo' => 'Arimo',
		'Arvo' => 'Arvo',
		'Berkshire+Swash' => 'Berkshire Swash',
		'Cabin' => 'Cabin',
		'Dancing+Script' => 'Dancing Script',
		'Droid+Sans' => 'Droid Sans',
		'Droid+Serif' => 'Droid Serif',
		'Fira+Sans' => 'Fira Sans',
		'Inconsolata' => 'Inconsolata',
		'Indie+Flower' => 'Indie Flower',
		'Josefin+Slab' => 'Josefin Slab',
		'Lobster' => 'Lobster',
		'Lora' => 'Lora',
		'Lato' => 'Lato',
		'Marvel' => 'Marvel',
		'Old+Standard+TT' => 'Old Standard TT',
		'Open+Sans' => 'Open Sans',
		'Oswald' => 'Oswald',
		'PT+Mono' => 'PT Mono',
		'PT+Serif' => 'PT Serif',
		'Raleway' => 'Raleway',
		'Rancho' => 'Rancho',
		'Roboto' => 'Roboto',
		'Signika' => 'Signika',
		'Ubuntu' => 'Ubuntu',
		'Vollkorn' => 'Vollkorn'
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
	public static $headerFontSizes = [
		'1.6em' => 'Très petite',
		'1.8em' => 'Petite',
		'2em' => 'Moyenne',
		'2.2em' => 'Grande',
		'2.4em' => 'Très grande'
	];
	public static $headerHeights = [
		'100px' => 'Très petite (100 pixels)',
		'150px' => 'Petite (150 pixels)',
		'200px' => 'Moyenne (200 pixels)',
		'300px' => 'Grande (300 pixels)',
		'400px' => 'Très grande (400 pixels)'
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
	public static $menuFontSizes = [
		'.8em' => 'Très petite',
		'.9em' => 'Petite',
		'1em' => 'Normale',
		'1.1em' => 'Moyenne',
		'1.2em' => 'Grande',
		'1.3em' => 'Très grande'
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
	public static $siteFontSizes = [
		'12px' => '12',
		'13px' => '13',
		'14px' => '14',
		'15px' => '15',
		'16px' => '16'
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
		'750px' => 'Petite (750 pixels)',
		'960px' => 'Moyenne (960 pixels)',
		'1170px' => 'Grande (1170 pixels)',
		'100%' => 'Fluide (100%)'
	];

	/**
	 * Mode avancé
	 */
	public function advanced() {
		// Soumission du formulaire
		if($this->isPost()) {
			// Enregistre le CSS
			// TODO Démo
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme/advanced',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation avancée',
			'vendor' => [
				'codemirror'
			],
			'view' => 'advanced'
		]);
	}

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
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation de l\'arrière plan',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => 'body'
		]);
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
				'margin' => $this->getInput('themeFooterMargin', helper::FILTER_BOOLEAN),
				'position' => $this->getInput('themeFooterPosition'),
				'socialsAlign' => $this->getInput('themeFooterSocialsAlign'),
				'text' => $this->getInput('themeFooterText', null),
				'textAlign' => $this->getInput('themeFooterTextAlign'),
				'textColor' => $this->getInput('themeFooterTextColor')
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation du pied de page',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => 'footer'
		]);
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
				'fontSize' => $this->getInput('themeHeaderFontSize'),
				'fontWeight' => $this->getInput('themeHeaderFontWeight'),
				'height' => $this->getInput('themeHeaderHeight'),
				'image' => $this->getInput('themeHeaderImage'),
				'imagePosition' => $this->getInput('themeHeaderImagePosition'),
				'imageRepeat' => $this->getInput('themeHeaderImageRepeat'),
				'margin' => $this->getInput('themeHeaderMargin', helper::FILTER_BOOLEAN),
				'position' => $this->getInput('themeHeaderPosition'),
				'textAlign' => $this->getInput('themeHeaderTextAlign'),
				'textColor' => $this->getInput('themeHeaderTextColor'),
				'textHide' => $this->getInput('themeHeaderTextHide', helper::FILTER_BOOLEAN),
				'textTransform' => $this->getInput('themeHeaderTextTransform')
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation de la bannière',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => 'header'
		]);
	}

	/**
	 * Accueil de la personnalisation
	 */
	public function index() {
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation du thème',
			'view' => 'index'
		]);
	}

	/**
	 * Options du menu
	 */
	public function menu() {
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData(['theme', 'menu', [
				'backgroundColor' => $this->getInput('themeMenuBackgroundColor'),
				'fontSize' => $this->getInput('themeMenuFontSize'),
				'fontWeight' => $this->getInput('themeMenuFontWeight'),
				'height' => $this->getInput('themeMenuHeight'),
				'loginLink' => $this->getInput('themeMenuLoginLink'),
				'margin' => $this->getInput('themeMenuMargin', helper::FILTER_BOOLEAN),
				'position' => $this->getInput('themeMenuPosition'),
				'textAlign' => $this->getInput('themeMenuTextAlign'),
				'textColor' => $this->getInput('themeMenuTextColor'),
				'textTransform' => $this->getInput('themeMenuTextTransform')
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation du menu',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => 'menu'
		]);
	}

	/**
	 * Réinitialisation de la personnalisation avancée
	 */
	public function reset() {
		// Supprime le fichier de personnalisation avancée
		unlink('site/data/custom.css');
		// Valeurs en sortie
		$this->addOutput([
			'notification' => 'Personnalisation avancée réinitialisée',
			'redirect' => helper::baseUrl() . 'theme/advanced',
			'state' => true
		]);
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
			$this->setData(['theme', 'text', [
				'font' => $this->getInput('themeTextFont'),
				'fontSize' => $this->getInput('themeTextFontSize'),
				'textColor' => $this->getInput('themeTextTextColor'),
			]]);
			$this->setData(['theme', 'site', [
				'backgroundColor' => $this->getInput('themeSiteBackgroundColor'),
				'radius' => $this->getInput('themeSiteRadius'),
				'shadow' => $this->getInput('themeSiteShadow'),
				'width' => $this->getInput('themeSiteWidth')
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . 'theme',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Personnalisation du site',
			'vendor' => [
				'tinycolorpicker'
			],
			'view' => 'site'
		]);
	}

}