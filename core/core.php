<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class common {

	const DISPLAY_RAW = 0;
	const DISPLAY_JSON = 1;
	const DISPLAY_LAYOUT_BLANK = 2;
	const DISPLAY_LAYOUT_NORMAL = 3;
	const RANK_BANNED = -1;
	const RANK_VISITOR = 0;
	const RANK_MEMBER = 1;
	const RANK_MODERATOR = 2;
	const RANK_ADMIN = 3;
	const ZWII_VERSION = '8.0.0 bêta 0.2';

	public static $actions = [];
	public static $demo = false;
	public static $language = [];
	public static $coreModuleIds = [
		'config',
		'page',
		'sitemap',
		'theme',
		'user'
	];
	private $data = [];
	private $defaultData = [
		'config' => [
			'analyticsId' => '',
			'autoBackup' => false,
			'cookieConsent' => true,
			'favicon' => 'favicon.ico',
			'homePageId' => 'accueil',
			'language' => 'fr_FR',
			'metaDescription' => 'Zwii est un CMS sans base de données qui permet à ses utilisateurs de créer et gérer facilement un site web sans aucune connaissance en programmation.',
			'social' => [
				'facebookId' => 'ZwiiCMS',
				'googleplusId' => '',
				'instagramId' => '',
				'pinterestId' => '',
				'twitterId' => 'ZwiiCMS',
				'youtubeId' => ''
			],
			'title' => 'Zwii, votre site en quelques clics !'
		],
		'core' => [
			'lastBackup' => 0,
			'lastClearTmp' => 0
		],
		'page' => [
			'accueil' => [
				'content' => "<h3>Félicitations Zwii est 100% opérationnel !</h3>\r\n<p><strong>Vous utilisez une version bêta en cours de développement ! Certaines fonctionnalités sont absentes et des bugs peuvent surgir. Si vous avez des retours à faire, n'hésitez pas à vous inscrire sur le <a title='forum' href='http://forum.zwiicms.com/'>forum</a> de Zwii.</strong></p>\r\n<p>Ci-dessous les comptes utilisateurs par défaut au format identifiant / mot de passe :</p>\r\n<ul><li>administrator / password</li><li>moderator / password</li><li>member / password</li></ul>\r\n<h4>Suivez-nous sur <a href='https://twitter.com/ZwiiCMS/'>Twitter</a> et <a href='https://www.facebook.com/ZwiiCMS/'>Facebook</a> pour ne manquer aucune nouveauté !</h4>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => '',
				'position' => 1,
				'rank' => self::RANK_VISITOR,
				'targetBlank' => false,
				'title' => 'Accueil'
			],
			'enfant' => [
				'content' => "<p>Vous pouvez assigner des parents à vos pages afin de mieux organiser votre menu !</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => 'accueil',
				'position' => 1,
				'rank' => self::RANK_VISITOR,
				'targetBlank' => false,
				'title' => 'Enfant'
			],
			'cachee' => [
				'content' => "<p>Cette page n'est visible que par les membres de votre site !</p>",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => '',
				'position' => 2,
				'rank' => self::RANK_MEMBER,
				'targetBlank' => false,
				'title' => 'Cachée'
			],
			'site-de-zwii' => [
				'content' => "",
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => 'redirection',
				'parentPageId' => '',
				'position' => 3,
				'rank' => self::RANK_VISITOR,
				'targetBlank' => true,
				'title' => 'Site de Zwii'
			]
		],
		'module' => [
			'site-de-zwii' => [
				'url' => 'http://zwiicms.com/',
				'count' => 0
			]
		],
		'user' => [
			'administrator' => [
				'mail' => 'administrator@zwiicms.com',
				'name' => 'Administrateur',
				'password' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8',
				'rank' => 3
			],
			'moderator' => [
				'mail' => 'moderator@zwiicms.com',
				'name' => 'Modérateur',
				'password' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8',
				'rank' => 2
			],
			'member' => [
				'mail' => 'member@zwiicms.com',
				'name' => 'Membre',
				'password' => '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8',
				'rank' => 1
			]
		],
		'theme' => [
			'body' => [
				'backgroundColor' => 'rgba(235, 238, 242, 1)',
				'image' => '',
				'imageAttachment' => 'scroll',
				'imageRepeat' => 'no-repeat',
				'imagePosition' => 'top center',
				'imageSize' => 'auto'
			],
			'button' => [
				'backgroundColor' => 'rgba(48, 77, 102, 1)'
			],
			'footer' => [
				'backgroundColor' => 'rgba(33, 34, 35, 1)',
				'copyrightAlign' => 'right',
				'height' => '30px',
				'loginLink' => true,
				'position' => 'body',
				'socialsAlign' => 'left',
				'text' => '',
				'textAlign' => 'left'
			],
			'header' => [
				'backgroundColor' => 'rgba(60, 105, 148, 1)',
				'font' => 'Oswald',
				'fontWeight' => 'normal',
				'height' => '200px',
				'image' => '',
				'imagePosition' => 'center center',
				'imageRepeat' => 'no-repeat',
				'position' => 'body',
				'textAlign' => 'center',
				'textColor' => 'rgba(255, 255, 255, 1)',
				'textTransform' => 'none'
			],
			'link' => [
				'textColor' => 'rgba(48, 77, 102, 1)'
			],
			'menu' => [
				'backgroundColor' => 'rgba(48, 77, 102, 1)',
				'fontWeight' => 'normal',
				'height' => '15px 10px',
				'loginLink' => true,
				'position' => 'body-second',
				'textAlign' => 'left',
				'textTransform' => 'none'
			],
			'site' => [
				'width' => '960px'
			],
			'text' => [
				'font' => 'Open+Sans'
			],
			'title' => [
				'font' => 'Oswald',
				'fontWeight' => 'normal',
				'textColor' => 'rgba(60, 105, 148, 1)',
				'textTransform' => 'none'
			]
		]
	];
	private $hierarchy = [
		'all' => [],
		'visible' => []
	];
	private $input = [
		'_POST' => [],
		'_GET' => [],
		'_COOKIE' => []
	];
	public static $inputBefore = [];
	public static $inputNotices = [];
	public static $outputContent = '';
	public static $outputDisplay = self::DISPLAY_LAYOUT_NORMAL;
	public static $outputMetaDescription = '';
	public static $outputMetaTitle = '';
	public static $outputScript = '';
	public static $outputStyle = '';
	public static $outputTitle = '';
	// Librairies classées par odre d'exécution
	public static $outputVendor = [
		'jquery',
		// 'jquery-ui', Désactivé par défaut
		'normalize',
		'lity',
		'filemanager',
		// 'tinycolorpicker', Désactivé par défaut
		// 'tinymce', Désactivé par défaut
		'zwiico'
	];
	public static $ranks = [
		self::RANK_BANNED => 'Banni',
		self::RANK_VISITOR => 'Visiteur',
		self::RANK_MEMBER => 'Membre',
		self::RANK_MODERATOR => 'Modérateur',
		self::RANK_ADMIN => 'Administrateur'
	];
	public static $rankPublics = [
		self::RANK_VISITOR => 'Visiteur',
		self::RANK_MEMBER => 'Membre',
		self::RANK_MODERATOR => 'Modérateur',
		self::RANK_ADMIN => 'Administrateur'
	];
	public static $rankVisibles = [
		self::RANK_BANNED => 'Banni',
		self::RANK_MEMBER => 'Membre',
		self::RANK_MODERATOR => 'Modérateur',
		self::RANK_ADMIN => 'Administrateur'
	];
	private $url = '';
	private $user = [];

	/**
	 * Constructeur commun
	 */
	public function __construct() {
		// Extraction des données http
		if(isset($_POST)) {
			$this->input['_POST'] = $_POST;
		}
		if(isset($_GET)) {
			$this->input['_GET'] = $_GET;
		}
		if(isset($_COOKIE)) {
			$this->input['_COOKIE'] = $_COOKIE;
		}
		// Supprime les données en mode démo
		if(self::$demo AND file_exists('site/data/data.json') AND filemtime('site/data/data.json') + 600 < time()) {
			@unlink('site/data/data.json');
		}
		// Génère le fichier de donnée
		if(file_exists('site/data/data.json') === false) {
			$this->setData([$this->defaultData]);
			$this->saveData();
			chmod('site/data/data.json', 0644);
		}
		// Import des données
		if($this->data === []) {
			$this->setData([json_decode(file_get_contents('site/data/data.json'), true)]);
		}
		// Utilisateur connecté
		if($this->user === []) {
			$this->user = $this->getData(['user', $this->getInput('ZWII_USER_ID', helper::FILTER_STRING, '_COOKIE')]);
		}
		// Construit la liste des pages parents/enfants
		if($this->hierarchy['all'] === []) {
			$pages = helper::arrayCollumn($this->getData(['page']), 'position', 'SORT_ASC');
			// Parents
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$this->getData(['page', $pageId, 'parentPageId']) === ""
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						$this->getData(['page', $pageId, 'rank']) === self::RANK_VISITOR
						OR (
							$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
							AND $this->getUser('rank') >= $this->getData(['page', $pageId, 'rank'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$pageId] = [];
					}
					$this->hierarchy['all'][$pageId] = [];
				}
			}
			// Enfants
			foreach($pages as $pageId => $pagePosition) {
				if(
					// Page parent
					$parentId = $this->getData(['page', $pageId, 'parentPageId'])
					// Ignore les pages dont l'utilisateur n'a pas accès
					AND (
						$this->getData(['page', $pageId, 'rank']) === self::RANK_VISITOR
						OR (
							$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
							AND $this->getUser('rank') >= $this->getData(['page', $pageId, 'rank'])
						)
					)
				) {
					if($pagePosition !== 0) {
						$this->hierarchy['visible'][$parentId][] = $pageId;
					}
					$this->hierarchy['all'][$parentId][] = $pageId;
				}
			}
		}
		// Construit l'url
		if($this->url === '') {
			if($url = $_SERVER['QUERY_STRING']) {
				$this->url = $url;
			}
			else {
				$this->url = $this->getData(['config', 'homePageId']);
			}
		}
	}

	/**
	 * Supprime des données
	 * @param array $keys Clé(s) des données
	 */
	public function deleteData($keys) {
		switch(count($keys)) {
			case 1 :
				unset($this->data[$keys[0]]);
				break;
			case 2:
				unset($this->data[$keys[0]][$keys[1]]);
				break;
			case 3:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]]);
				break;
			case 4:
				unset($this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]]);
				break;
		}
	}

	/**
	 * Accède aux données
	 * @param array $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = null) {
		// Retourne l'ensemble des données
		if($keys === null) {
			return $this->data;
		}
		// Décent dans les niveaux de la variable $data
		$data = $this->data;
		foreach($keys as $key) {
			// Si aucune donnée n'existe retourne null
			if(isset($data[$key]) === false) {
				return null;
			}
			// Sinon décent dans les niveaux
			else {
				$data = $data[$key];
			}
		}
		// Retourne les données
		return $data;
	}

	/**
	 * Accède à la liste des pages parents et de leurs enfants ou aux enfants d'une page parent
	 * @param int $parentId Id de la page parent
	 * @param bool $onlyVisible Affiche seulement les pages visibles
	 * @return array
	 */
	public function getHierarchy($parentId = null, $onlyVisible = true) {
		$hierarchy = $onlyVisible ? $this->hierarchy['visible'] : $this->hierarchy['all'];
		// Enfants d'un parent
		if($parentId) {
			if(array_key_exists($parentId, $hierarchy)) {
				return $hierarchy[$parentId];
			}
			else {
				return [];
			}
		}
		// Parents et leurs enfants
		else {
			return $hierarchy;
		}
	}

	/**
	 * Accède à une valeur des variables http (ordre de recherche en l'absence de type : _POST, _GET, _COOKIE)
	 * @param mixed $key Clé de la valeur
	 * @param mixed $filter Filtre à appliquer à la valeur
	 * @param mixed $type Type de la valeur
	 * @return mixed
	 */
	public function getInput($key, $filter = helper::FILTER_STRING, $type = null) {
		// Cherche et retourne la valeur demandée dans un type précis
		if($type AND isset($this->input[$type][$key])) {
			// Champ obligatoire
			if(
				empty($this->input[$type][$key])
				AND isset($_SESSION['ZWII_INPUT_REQUIRED'])
				AND array_key_exists($key, $_SESSION['ZWII_INPUT_REQUIRED'])
			) {
				common::$inputNotices[$key] = 'Ce champ est requis';
			}
			// Retourne la valeur filtrée
			return helper::filter($this->input[$type][$key], $filter);
		}
		// Cherche et retourne la valeur demandée
		foreach($this->input as $type => $values) {
			if(array_key_exists($key, $values)) {
				// Champ obligatoire
				if(
					empty($this->input[$type][$key])
					AND isset($_SESSION['ZWII_INPUT_REQUIRED'])
					AND array_key_exists($key, $_SESSION['ZWII_INPUT_REQUIRED'])
				) {
					common::$inputNotices[$key] = 'Ce champ est requis';
				}
				// Retourne la valeur filtrée
				return helper::filter($this->input[$type][$key], $filter);
			}
		}
		// Sinon retourne null
		return helper::filter(null, $filter);
	}

	/**
	 * Accède à une partie l'url ou à l'url complète
	 * @param int $key Clé de l'url
	 * @return string|null
	 */
	public function getUrl($key = null) {
		// Url complète
		if($key === null) {
			return $this->url;
		}
		// Une partie de l'url
		else {
			$url = explode('/', $this->url);
			return array_key_exists($key, $url) ? $url[$key] : null;
		}
	}

	/**
	 * Accède à l'utilisateur connecté
	 * @param int $key Clé de la valeur
	 * @return string|null
	 */
	public function getUser($key) {
		if(is_array($this->user) === false) {
			return false;
		}
		elseif($key === 'id') {
			return $this->getInput('ZWII_USER_ID', helper::FILTER_STRING, '_COOKIE');
		}
		elseif(array_key_exists($key, $this->user)) {
			return $this->user[$key];
		}
		else {
			return false;
		}
	}

	/**
	 * Check qu'une valeur est transmise par la méthode _POST
	 * @return bool
	 */
	public function isPost() {
		return $this->input['_POST'] !== [];
	}

	/**
	 * Enregistre les données
	 */
	public function saveData() {
		if(common::$inputNotices === []) {
			file_put_contents('site/data/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Scan le contenu d'un dossier et de ses sous-dossiers
	 * @param string $dir Dossier à scanner
	 * @param array $ignore Élément à ignorer
	 * @return array
	 */
	public static function scanDir($dir, $ignore = ['.', '..']) {
		$dirContent = [];
		$iterator = new DirectoryIterator($dir);
		foreach($iterator as $fileInfos) {
			if(in_array($fileInfos->getFilename(), $ignore)) {
				continue;
			}
			elseif($fileInfos->isDir()) {
				$dirContent = array_merge($dirContent, self::scanDir($fileInfos->getPathname()));
			}
			else {
				$dirContent[] = $fileInfos->getPathname();
			}
		}
		return $dirContent;
	}

	/**
	 * Insert des données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys) {
		switch(count($keys)) {
			case 1:
				$this->data = $keys[0];
				break;
			case 2:
				$this->data[$keys[0]] = $keys[1];
				break;
			case 3:
				$this->data[$keys[0]][$keys[1]] = $keys[2];
				break;
			case 4:
				$this->data[$keys[0]][$keys[1]][$keys[2]] = $keys[3];
				break;
			case 5:
				$this->data[$keys[0]][$keys[1]][$keys[2]][$keys[3]] = $keys[4];
				break;
		}
	}

	/**
	 * Enregistre un champ comme obligatoire
	 * @param array $attributes Transmet les attributs à la méthode
	 */
	public static function setInputRequired($attributes) {
		if(
			$attributes['required']
			AND (
				empty($_SESSION['ZWII_INPUT_REQUIRED'])
				OR array_key_exists($attributes['id'], $_SESSION['ZWII_INPUT_REQUIRED']) === false
			)
		) {
			$_SESSION['ZWII_INPUT_REQUIRED'][$attributes['id']] = true;
		}
	}

}

class core extends common {

	/**
	 * Constructeur du coeur
	 */
	public function __construct() {
		parent::__construct();
		// Supprime les fichiers temporaires
		$lastClearTmp = mktime(0, 0, 0);
		if($lastClearTmp > $this->getData(['core', 'lastClearTmp']) + 86400) {
			$iterator = new DirectoryIterator('core/tmp/');
			foreach($iterator as $fileInfos) {
				if($fileInfos->isFile() AND $fileInfos->getBasename() !== '.gitkeep') {
					@unlink($fileInfos->getPathname());
				}
			}
			// Date de la dernière suppression
			$this->setData(['core', 'lastClearTmp', $lastClearTmp]);
		}
		// Backup automatique des données
		$lastBackup = mktime(0, 0, 0);
		if($this->getData(['config', 'autoBackup']) AND $lastBackup > $this->getData(['core', 'lastBackup']) + 86400) {
			// Creation du ZIP
			$fileName = date('Y-m-d', $lastBackup) . '.zip';
			$zip = new ZipArchive();
			if($zip->open('site/backup/' . $fileName, ZipArchive::CREATE) === TRUE){
				foreach(self::scanDir('site/', ['.', '..', 'backup']) as $file) {
					$zip->addFile($file);
				}
			}
			$zip->close();
			// Date du dernier backup
			$this->setData(['core', 'lastBackup', $lastBackup]);
		}
		// Crée le fichier de personnalisation
		if(file_exists('site/data/theme.css') === false) {
			file_put_contents('site/data/theme.css', '');
			chmod('site/data/theme.css', 0644);
		}
		// Check la version
		$cssVersion = preg_split('/\*+/', file_get_contents('site/data/theme.css'));
		if(empty($cssVersion[1]) OR $cssVersion[1] !== md5(json_encode($this->getData(['theme'])))) {
			// Version
			$css = '/*' . md5(json_encode($this->getData(['theme']))) . '*/';
			// Import des polices de caractères
			$css .= '@import url("https://fonts.googleapis.com/css?family=' . $this->getData(['theme', 'text', 'font']) . '|' . $this->getData(['theme', 'title', 'font']) . '|' . $this->getData(['theme', 'header', 'font']) . '");';
			// Fond du site
			$colors = helper::colorVariants($this->getData(['theme', 'body', 'backgroundColor']));
			$css .= 'body{background-color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'text', 'font'])) . '",sans-serif}';
			if($themeBodyImage = $this->getData(['theme', 'body', 'image'])) {
				$css .= 'body{background-image:url("../file/source/' . $themeBodyImage . '");background-position:' . $this->getData(['theme', 'body', 'imagePosition']) . ';background-attachment:' . $this->getData(['theme', 'body', 'imageAttachment']) . ';background-size:' . $this->getData(['theme', 'body', 'imageSize']) . ';background-repeat:' . $this->getData(['theme', 'body', 'imageRepeat']) . '}';
			}
			// Site
			$css .= '.container{max-width:' . $this->getData(['theme', 'site', 'width']) . '}';
			$css .= '#site{border-radius:' . $this->getData(['theme', 'site', 'radius']) . ';box-shadow:' . $this->getData(['theme', 'site', 'shadow']) . ' #212223}';
			$colors = helper::colorVariants($this->getData(['theme', 'button', 'backgroundColor']));
			$css .= '.speechBubble,.button,input[type=\'submit\'],pagination a,input[type=\'checkbox\']:checked + label:before,input[type=\'radio\']:checked + label:before,.helpContent{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '!important}';
			$css .= '.tabTitle.current,.helpButton span{color:' . $colors['normal'] . '}';
			$css .= 'input[type=\'text\']:hover,input[type=\'password\']:hover,.inputFile:hover,select:hover,textarea:hover{border-color:' . $colors['normal'] . '}';
			$css .= '.speechBubble:before{border-color:' . $colors['normal'] . ' transparent transparent transparent}';
			$css .= '.button:hover,input[type=\'submit\']:hover,.pagination a:hover,input[type=\'checkbox\']:not(:active):checked:hover + label:before,input[type=\'checkbox\']:active + label:before,input[type=\'radio\']:checked:hover + label:before,input[type=\'radio\']:not(:checked):active + label:before{background-color:' . $colors['darken'] . '}';
			$css .= '.helpButton span:hover{color:' . $colors['darken'] . '}';
			$css .= '.button:active,input[type=\'submit\']:active,.pagination a:active{background-color:' . $colors['veryDarken'] . '}';
			$colors = helper::colorVariants($this->getData(['theme', 'link', 'textColor']));
			$css .= 'a{color:' . $colors['normal'] . '}';
			$css .= 'a:hover{color:' . $colors['darken'] . '}';
			$css .= 'a:active{color:' . $colors['veryDarken'] . '}';
			$colors = helper::colorVariants($this->getData(['theme', 'title', 'textColor']));
			$css .= 'h1,h2,h3,h4,h5,h6{color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'title', 'font'])) . '",sans-serif;font-weight:' . $this->getData(['theme', 'title', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'title', 'textTransform']) . '}';
			// Bannière
			$colors = helper::colorVariants($this->getData(['theme', 'header', 'backgroundColor']));
			$css .= 'header{background-color:' . $colors['normal'] . ';height:' . $this->getData(['theme', 'header', 'height']) . ';line-height:' . $this->getData(['theme', 'header', 'height']) . ';text-align:' . $this->getData(['theme', 'header', 'textAlign']) . '}';
			if($themeHeaderImage = $this->getData(['theme', 'header', 'image'])) {
				$css .= 'header{background-image:url("../file/source/' . $themeHeaderImage . '");background-position:' . $this->getData(['theme', 'header', 'imagePosition']) . ';background-repeat:' . $this->getData(['theme', 'header', 'imageRepeat']) . '}';
			}
			$colors = helper::colorVariants($this->getData(['theme', 'header', 'textColor']));
			$css .= 'header h1{color:' . $colors['normal'] . ';font-family:"' . str_replace('+', ' ', $this->getData(['theme', 'header', 'font'])) . '",sans-serif;font-weight:' . $this->getData(['theme', 'header', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'header', 'textTransform']) . '}';
			// Menu
			$colors = helper::colorVariants($this->getData(['theme', 'menu', 'backgroundColor']));
			$css .= 'nav, nav li > a{background-color:' . $colors['normal'] . '}';
			$css .= 'nav a,#toggle span{color:' . $colors['text'] . '!important}';
			$css .= 'nav a:hover{background-color:' . $colors['darken'] . '}';
			$css .= 'nav a.target,nav a.active{background-color:' . $colors['veryDarken'] . '}';
			$css .= '#menu{text-align:' . $this->getData(['theme', 'menu', 'textAlign']) . '}';
			$css .= '#toggle span,#menu a{padding:' . $this->getData(['theme', 'menu', 'height']) . ';font-weight:' . $this->getData(['theme', 'menu', 'fontWeight']) . ';text-transform:' . $this->getData(['theme', 'menu', 'textTransform']) . '}';
			// Pied de page
			$colors = helper::colorVariants($this->getData(['theme', 'footer', 'backgroundColor']));
			$css .= 'footer{background-color:' . $colors['normal'] . ';color:' . $colors['text'] . '}';
			$css .= 'footer a{color:' . $colors['text'] . '!important}';
			$css .= 'footer .container > div{margin:' . $this->getData(['theme', 'footer', 'height']) . ' 0}';
			$css .= '#footerSocials{text-align:' . $this->getData(['theme', 'footer', 'socialsAlign']) . '}';
			$css .= '#footerText{text-align:' . $this->getData(['theme', 'footer', 'textAlign']) . '}';
			$css .= '#footerCopyright{text-align:' . $this->getData(['theme', 'footer', 'copyrightAlign']) . '}';
			// Enregistre la personnalisation
			file_put_contents('site/data/theme.css', $css);
		}
		// Importe les fichiers de langue
		// Coeur
		$language = 'core/lang/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = json_decode(file_get_contents($language), true);
		}
		// Module
		$language = 'module/' . $this->getData(['page', $this->getUrl(0), 'module']) . '/lang/' . $this->getData(['config', 'language']);
		if(
			in_array($this->getData(['page', $this->getUrl(0), 'module']), self::$coreModuleIds) === false
			AND is_file($language)
		) {
			self::$language = array_merge(self::$language, json_decode(file_get_contents($language), true));
		}
		// Enregistrement des données (utile pour les fichiers temporaire et le css)
		$this->saveData();
	}

	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className) {
		$classPath = 'module/' . $className . '/' . $className . '.php';
		// Module du coeur
		if(is_readable('core/' . $classPath)) {
			require 'core/' . $classPath;
		}
		// Module
		elseif(is_readable($classPath)) {
			require $classPath;
		}
	}

	/**
	 * Routage des modules
	 */
	public function router() {
		// Check l'accès à la page
		$access = null;
		if($this->getData(['page', $this->getUrl(0)]) !== null) {
			if(
				$this->getData(['page', $this->getUrl(0), 'rank']) === self::RANK_VISITOR
				OR (
					$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
					AND $this->getUser('rank') >= $this->getData(['page', $this->getUrl(0), 'rank'])
				)
			) {
				$access = true;
			}
			else {
				$access = false;
			}
		}
		// Importe la page
		if(
			$this->getData(['page', $this->getUrl(0)]) !== null
			AND $this->getData(['page', $this->getUrl(0), 'moduleId']) === ''
			AND $access
		) {
			self::$outputTitle = $this->getData(['page', $this->getUrl(0), 'title']);
			self::$outputContent = $this->getData(['page', $this->getUrl(0), 'content']);
			self::$outputMetaTitle = $this->getData(['page', $this->getUrl(0), 'metaTitle']);
			self::$outputMetaDescription = $this->getData(['page', $this->getUrl(0), 'metaDescription']);
		}
		// Importe le module
		else {
			// Id du module en fonction du type de contenu demandé
			if($access AND $this->getData(['page', $this->getUrl(0), 'moduleId'])) {
				$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
			}
			else {
				$moduleId = $this->getUrl(0);
			}
			// Check l'existence du module
			if(class_exists($moduleId)) {
				/** @var common $module */
				$module = new $moduleId;
				// Check l'existence de l'action
				$action = array_key_exists($this->getUrl(1), $module::$actions) ? $this->getUrl(1) : 'index';
				if(array_key_exists($action, $module::$actions)) {
					$output = $module->$action();
					// Check le rang de l'utilisateur
					if(
						$module::$actions[$action] === 0
						OR (
							$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
							AND $this->getUser('rank') >= $module::$actions[$action]
						)
						AND (
							array_key_exists('access', $output) === false
							OR $output['access'] === true
						)
					) {
						// Enregistrement des données
						if(array_key_exists('state', $output) AND $output['state'] === true) {
							$this->setData([$module->getData()]);
							$this->saveData();
						}
						// Sauvegarde des données en méthode POST si une notice existe
						if(common::$inputNotices) {
							foreach($_POST as $postId => $postValue) {
								self::$inputBefore[$postId] = $postValue;
							}
						}
						// Sinon traitement des données de sorties
						else {
							// Notification
							if(array_key_exists('notification', $output)) {
								$state = array_key_exists('state', $output) ? (bool) $output['state'] : false;
								$_SESSION[$state ? 'ZWII_NOTIFICATION_SUCCESS' : 'ZWII_NOTIFICATION_ERROR'] = $output['notification'];
							}
							// Redirection
							if(array_key_exists('redirect', $output)) {
								http_response_code(301);
								header('Location:' . $output['redirect']);
								exit();
							}
						}
						// Affichage
						if(array_key_exists('display', $output)) {
							self::$outputDisplay = $output['display'];
						}
						// Contenu du module
						if(self::$outputDisplay === self::DISPLAY_JSON) {
							self::$outputContent = $output['state'];
						}
						elseif(array_key_exists('view', $output) OR common::$inputNotices) {
							// Chemin en fonction d'un module du coeur ou d'un module
							$modulePath = in_array($moduleId, self::$coreModuleIds) ? 'core/' : '';
							// CSS
							$stylePath = $modulePath . 'module/' . $moduleId . '/view/' . $action . '/' . $action . '.css';
							if(file_exists($stylePath)) {
								self::$outputStyle = file_get_contents($stylePath);
							}
							// JS
							$scriptPath = $modulePath . 'module/' . $moduleId . '/view/' . $action . '/' . $action . '.js.php';
							if(file_exists($scriptPath)) {
								ob_start();
								include $scriptPath;
								self::$outputScript .= ob_get_clean();
							}
							// Vue
							$viewPath = $modulePath . 'module/' . $moduleId . '/view/' . $action . '/' . $action . '.php';
							if(file_exists($viewPath)) {
								ob_start();
								include $viewPath;
								self::$outputContent .= ob_get_clean();
							}
						}
						// Librairies
						if(array_key_exists('vendor', $output)) {
							self::$outputVendor = array_merge(self::$outputVendor, $output['vendor']);
						}
						// Titre
						if(array_key_exists('title', $output)) {
							self::$outputTitle = helper::translate($output['title']);
						}
					}
					// Erreur 403
					else {
						$access = false;
					}
				}
			}
		}
		// Erreurs
		if($access === false) {
			http_response_code(403);
			self::$outputTitle = helper::translate('Erreur 403');
			self::$outputContent = template::speech('vous n\'êtes pas autorisé à accéder à cette page...');
		}
		elseif(self::$outputContent === '') {
			http_response_code(404);
			self::$outputTitle = helper::translate('Erreur 404');
			self::$outputContent = template::speech('Oups ! La page demandée est introuvable...');
		}
		// Mise en forme des métas
		if(self::$outputMetaTitle === '') {
			if(self::$outputTitle) {
				self::$outputMetaTitle = self::$outputTitle . ' - ' . $this->getData(['config', 'title']);
			}
			else {
				self::$outputMetaTitle = $this->getData(['config', 'title']);
			}
		}
		if(self::$outputMetaDescription === '') {
			self::$outputMetaDescription = $this->getData(['config', 'metaDescription']);
		}
		// Choix du type d'affichage
		switch(self::$outputDisplay) {
			// Layout vide
			case self::DISPLAY_LAYOUT_BLANK:
				require 'core/layout/blank.php';
				break;
			// Layout normal
			case self::DISPLAY_LAYOUT_NORMAL:
				require 'core/layout/normal.php';
				break;
			// JSON
			case self::DISPLAY_JSON:
				header('Content-Type: application/json');
				echo json_encode(self::$outputContent);
				break;
			// BLANK
			case self::DISPLAY_RAW:
				echo self::$outputContent;
				break;
		}
	}

}

class helper {

	/** Statut de l'URL rewriting (pour éviter de lire le contenu du fichier .htaccess à chaque self::baseUrl()) */
	private static $rewriteStatus = null;

	/** Filtres personnalisés */
	const FILTER_BOOLEAN = 1;
	const FILTER_EMAIL = 2;
	const FILTER_FLOAT = 3;
	const FILTER_ID = 4;
	const FILTER_INT = 5;
	const FILTER_PASSWORD = 6;
	const FILTER_STRING = 7;
	const FILTER_URL = 8;

	/**
	 * Retourne les valeurs d'une colonne du tableau de données
	 * @param array $array Tableau cible
	 * @param string $column Colonne à extraire
	 * @param string $sort Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, ou null)
	 * @return array
	 */
	public static function arrayCollumn($array, $column, $sort = null) {
		$newArray = array_map(function($element) use($column) {
			return $element[$column];
		}, $array);
		switch($sort) {
			case 'SORT_ASC':
				asort($newArray);
				break;
			case 'SORT_DESC':
				arsort($newArray);
				break;
		}
		return $newArray;
	}

	/**
	 * Retourne l'URL de base du site
	 * @param bool $queryString Affiche ou non le point d'interrogation
	 * @param bool $host Affiche ou non l'host
	 * @return string
	 */
	public static function baseUrl($queryString = true, $host = true) {
		$pathInfo = pathinfo($_SERVER['PHP_SELF']);
		$hostName = $_SERVER['HTTP_HOST'];
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
		return ($host ? $protocol . $hostName : '') . rtrim($pathInfo['dirname'], ' /') . '/' . (($queryString AND helper::checkRewrite() === false) ? '?' : '');
	}

	/**
	 * Check le statut de l'URL rewriting
	 * @return bool
	 */
	public static function checkRewrite() {
		if(self::$rewriteStatus === null) {
			// Ouvre et scinde le fichier .htaccess
			$htaccess = explode('# URL rewriting', file_get_contents('.htaccess'));
			// Retourne un boolean en fonction du contenu de la partie réservée à l'URL rewriting
			self::$rewriteStatus = empty($htaccess[1]) === false;
		}
		return self::$rewriteStatus;
	}

	/** Check la version de Zwii */
	public static function checkZwiiVersion() {
		return trim(@file_get_contents('http://zwiicms.com/version')) === common::ZWII_VERSION;
	}

	/**
	 * Génère des variations d'une couleur
	 * @param string $rgba Code rgba de la couleur
	 * @return array
	 */
	public static function colorVariants($rgba) {
		preg_match('#\(+(.*)\)+#', $rgba, $matches);
		$rgba = explode(', ', $matches[1]);
		return [
			'normal' => 'rgba(' . $rgba[0] . ',' . $rgba[1] . ',' . $rgba[2] . ',' . $rgba[3] . ')',
			'darken' => 'rgba(' . max(0, $rgba[0] - 15) . ',' . max(0, $rgba[1] - 15) . ',' . max(0, $rgba[2] - 15) . ',' . $rgba[3] . ')',
			'veryDarken' => 'rgba(' . max(0, $rgba[0] - 20) . ',' . max(0, $rgba[1] - 20) . ',' . max(0, $rgba[2] - 20) . ',' . $rgba[3] . ')',
			'text' => self::relativeLuminanceW3C($rgba) > .22 ? "inherit" : "white"
		];
	}

	/**
	 * Supprime un cookie
	 * @param string $cookieKey Clé du cookie à supprimer
	 */
	public static function deleteCookie($cookieKey) {
		unset($_COOKIE[$cookieKey]);
		setcookie($cookieKey, '', time() - 3600, helper::baseUrl(false, false));
	}

	/**
	 * Filtre une chaîne en fonction d'un tableau de données
	 * @param string $text Chaîne à filtrer
	 * @param int $filter Type de filtre à appliquer
	 * @return string
	 */
	public static function filter($text, $filter) {
		$search = 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ,\',", ';
		$replace = 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-,-,-';
		$text = trim($text);
		switch($filter) {
			case self::FILTER_BOOLEAN:
				$text = (bool) $text;
				break;
			case self::FILTER_EMAIL:
				$text = filter_var($text, FILTER_SANITIZE_EMAIL);
				break;
			case self::FILTER_FLOAT:
				$text = filter_var($text, FILTER_SANITIZE_NUMBER_FLOAT);
				$text = (float) $text;
				break;
			case self::FILTER_ID:
				$text = preg_replace('/([^a-z0-9!#$%&\'*+-=?^_`{|}~@.\[\]])/', '', str_replace(explode(',', $search), explode(',', $replace), mb_strtolower($text, 'UTF-8')));
				break;
			case self::FILTER_INT:
				$text = filter_var($text, FILTER_SANITIZE_NUMBER_INT);
				$text = (int) $text;
				break;
			case self::FILTER_PASSWORD:
				$text = hash('sha256', $text);
				break;
			case self::FILTER_STRING:
				$text = filter_var($text, FILTER_SANITIZE_STRING);
				break;
			case self::FILTER_URL:
				$text = filter_var(str_replace(explode(',', $search), explode(',', $replace), $text), FILTER_SANITIZE_URL);
				break;
		}
		return get_magic_quotes_gpc() ? stripslashes($text) : $text;
	}

	/**
	 * Incrémente une clé en fonction des clés ou des valeurs d'un tableau
	 * @param mixed $key Clé à incrémenter
	 * @param array $array Tableau à vérifier
	 * @return string
	 */
	public static function increment($key, $array = []) {
		// Pas besoin d'incrémenter si la clef n'existe pas
		if($array === []) {
			return $key;
		}
		// Incrémente la clef
		else {
			// Si la clef est numérique elle est incrémentée
			if(is_numeric($key)) {
				$newKey = $key;
				while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
					$newKey++;
				}
			}
			// Sinon l'incrémentation est ajoutée après la clef
			else {
				$i = 2;
				$newKey = $key;
				while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
					$newKey = $key . '-' . $i;
					$i++;
				}
			}
			return $newKey;
		}
	}

	/**
	 * Envoi un mail
	 * @param string $from Expéditeur
	 * @param string $to Destinataire
	 * @param string $subject Sujet
	 * @param string $message Message
	 * @return bool
	 */
	public static function mail($from, $to, $subject, $message) {
		// Retour chariot différent pour les adresses Microsoft
		$n = preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|outlook).[a-z]{2,4}$#", $to) ? "\n" : "\r\n";
		// Définition du séparateur
		$boundary = '-----=' . md5(rand());
		// Création du template
		$html = '<html><head></head><body>' . nl2br($message) . '</body></html>';
		$txt = strip_tags($html);
		// Définition du header
		$header = 'Reply-To: ' . $to . $n;
		if($from) {
			$header .= 'From: ' . $from . $n;
		}
		else {
			$header .= 'From: ' . helper::translate('Votre site Zwii') . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>' . $n;
		}
		$header .= 'MIME-Version: 1.0' . $n;
		$header .= 'Content-Type: multipart/alternative;' . $n . ' boundary="' . $boundary . '"' . $n;
		// Message au format texte
		$message .= $n . '--' . $boundary . $n;
		$message .= 'Content-Type: text/plain; charset="utf-8"' . $n;
		$message .= 'Content-Transfer-Encoding: 8bit' . $n;
		$message .= $n . $txt . $n;
		// Message au format HTML
		$message .= $n . '--' . $boundary . $n;
		$message .= 'Content-Type: text/html; charset="utf-8"' . $n;
		$message .= 'Content-Transfer-Encoding: 8bit' . $n;
		$message .= $n . $html . $n;
		// Fermeture des séparateurs
		$message .= $n . '--' . $boundary . '--' . $n;
		$message .= $n . '--' . $boundary . '--' . $n;
		// Accents dans le sujet d'un mail
		$subject = mb_encode_mimeheader($subject,'UTF-8', 'Q', $n);
		// Envoi du mail
		return @mail($to, $subject, $message, $header);
	}

	/**
	 * Minimise du css
	 * @param string $css Css à minimiser
	 * @return string
	 */
	public static function minifyCss($css) {
		// Supprime les commentaires
		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$css = str_replace(["\r\n", "\r", "\n" ,"\t", '  ', '    ', '     '], '', $css);
		$css = preg_replace(['(( )+{)', '({( )+)'], '{', $css);
		$css = preg_replace(['(( )+})', '(}( )+)', '(;( )*})'], '}', $css);
		$css = preg_replace(['(;( )+)', '(( )+;)'], ';', $css);
		// Retourne le css minifié
		return $css;
	}

	/**
	 * Minimise du js
	 * @param string $js Js à minimiser
	 * @return string
	 */
	public static function minifyJs($js) {
		// Supprime les commentaires
		$js = preg_replace('/\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\/|\s*(?<![\:\=])\/\/.*/', '', $js);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$js = str_replace(["\r\n", "\r", "\t", "\n", '  ', '    ', '     '], '', $js);
		$js = preg_replace(['(( )+\))', '(\)( )+)'], ')', $js);
		// Retourne le js minifié
		return $js;
	}

	/**
	 * Crée un système de pagination (retourne un tableau contenant les informations sur la pagination (first, last, pages))
	 * @param array $array Tableau de donnée à utiliser
	 * @param string $url URL à utiliser, la dernière partie doit correspondre au numéro de page, par défaut utiliser $this->getUrl()
	 * @param null|int $tab ID d'un onglet
	 * @return array
	 */
	public static function pagination($array, $url, $tab = null) {
		// Scinde l'url
		$url = explode('/', $url);
		// Url de pagination
		$urlPagination = is_numeric(end($url)) ? array_pop($url) : 1;
		// Url de la page courante
		$urlCurrent = implode('/', $url);
		// Nombre d'éléments à afficher
		$nbElements = count($array);
		// Nombre de page
		$nbPage = ceil($nbElements / 10);
		// Page courante
		$currentPage = is_numeric($urlPagination) ? self::filter($urlPagination, self::FILTER_INT) : 1;
		// Premier élément de la page
		$firstElement = ($currentPage - 1) * 10;
		// Dernier élément de la page
		$lastElement = $firstElement + 10;
		$lastElement = ($lastElement > $nbElements) ? $nbElements : $lastElement;
		// Mise en forme de la liste des pages
		$pages = false;
		for($i = 1; $i <= $nbPage; $i++)
		{
			$disabled = ($i === $currentPage) ? ' class="disabled"' : false;
			$pages .= '<a href="' . helper::baseUrl() . $urlCurrent . '/' . $i . $tab . '"' . $disabled . '>' . $i . '</a>';
		}
		// Retourne un tableau contenant les informations sur la pagination
		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'page' => '<div class="pagination">' . $pages . '</div>'
		];
	}

	/**
	 * Calcul de la luminance relative d'une couleur
	 */
	public static function relativeLuminanceW3C($rgba) {
		// Conversion en sRGB
		$RsRGB = $rgba[0] / 255;
		$GsRGB = $rgba[1] / 255;
		$BsRGB = $rgba[2] / 255;
		// Ajout de la transparence
		$RsRGBA = $rgba[3] * $RsRGB + (1 - $rgba[3]);
		$GsRGBA = $rgba[3] * $GsRGB + (1 - $rgba[3]);
		$BsRGBA = $rgba[3] * $BsRGB + (1 - $rgba[3]);
		// Calcul de la luminance
		$R = ($RsRGBA <= .03928) ? $RsRGBA / 12.92 : pow(($RsRGBA + .055) / 1.055, 2.4);
		$G = ($GsRGBA <= .03928) ? $GsRGBA / 12.92 : pow(($GsRGBA + .055) / 1.055, 2.4);
		$B = ($BsRGBA <= .03928) ? $BsRGBA / 12.92 : pow(($BsRGBA + .055) / 1.055, 2.4);
		return .2126 * $R + .7152 * $G + .0722 * $B;
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param array $array Liste des attributs ($key => $value)
	 * @param array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	public static function sprintAttributes(array $array = [], array $exclude = []) {
		// Required est exclu pour privilégier le système de champs requis du système
		$exclude = array_merge(
			['before',
				'classWrapper',
				'help',
				'label',
				'required',
				'selected'
			],
			$exclude
		);
		$attributes = [];
		foreach($array as $key => $value) {
			if(($value OR $value === 0) AND in_array($key, $exclude) === false) {
				// Champs à traduire
				if(in_array($key, ['placeholder'])) {
					$attributes[] = sprintf('%s="%s"', $key, helper::translate($value));
				}
				// Disabled
				elseif($key === 'disabled') {
					$attributes[] = sprintf('%s', $key);
				}
				else {
					$attributes[] = sprintf('%s="%s"', $key, $value);
				}
			}
		}
		return implode(' ', $attributes);
	}
	
	/**
	 * Traduit les textes
	 * @param string $text Texte à traduire
	 * @return string
	 */
	public static function translate($text) {
		// Traduit le texte en cherchant dans le tableau de langue (ajout d'un filtre au cas ou un $key est vide)
		if(array_key_exists(helper::filter($text, helper::FILTER_STRING), core::$language)) {
			$text = core::$language[$text];
		}
		return $text;
	}

}

class layout extends common {

	/**
	 * Affiche le script Google Analytics
	 */
	public function showAnalytics() {
		if($code = $this->getData(['config', 'analyticsId'])) {
			echo '<script>
				(function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,"script","https://www.google-analytics.com/analytics.js","ga");
				ga("create", "' . $code . '", "auto");
				ga("send", "pageview");
			</script>';
		}
	}

	/**
	 * Affiche le contenu
	 */
	public function showContent() {
		if(
			self::$outputTitle
			AND (
				$this->getData(['page', $this->getUrl(0)]) === null
				OR $this->getData(['page', $this->getUrl(0), 'hideTitle']) === false
			)
		) {
			echo '<h2 id="pageTitle">' . self::$outputTitle . '</h2>';
		}
		echo self::$outputContent;
	}

	/**
	 * Affiche le coyright
	 */
	public function showCopyright() {
		$items = '<div id="footerCopyright">';
		$items .= helper::translate('Motorisé par') . ' <a href="http://zwiicms.com/" target="_blank">Zwii</a>';
		$items .= ' | <a href="' . helper::baseUrl() . 'sitemap">' . helper::translate('Plan du site') . '</a>';
		if(
			(
				$this->getData(['theme', 'footer', 'loginLink'])
				AND $this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
			)
			OR $this->getUrl(0) === 'theme'
		) {
			$items .= '<span id="footerLoginLink" ' . ($this->getUrl(0) === 'theme' ? 'class="displayNone"' : '') . '> | <a href="' . helper::baseUrl() . 'user/login">' . helper::translate('Connexion') . '</a></span>';
		}
		$items .= '</div>';
		echo $items;
	}

	/**
	 * Affiche le favicon
	 */
	public function showFavicon() {
		if($favicon = $this->getData(['config', 'favicon'])) {
			echo '<link rel="shortcut icon" href="' . helper::baseUrl(false) . 'site/file/source/' . $favicon . '">';
		}
	}

	/**
	 * Affiche le texte du footer
	 */
	public function showFooterText() {
		if($footerText = $this->getData(['theme', 'footer', 'text']) OR $this->getUrl(0) === 'theme') {
			echo '<div id="footerText">' . nl2br($footerText) . '</div>';
		}
	}

	/**
	 * Affiche le menu
	 */
	public function showMenu() {
		// Met en forme les items du menu
		$items = '';
		foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
			// Propriétés de l'item
			$active = ($parentPageId === $this->getUrl(0) OR in_array($this->getUrl(0), $childrenPageIds)) ? ' class="active"' : '';
			$targetBlank = $this->getData(['page', $parentPageId, 'targetBlank']) ? ' target="_blank"' : '';
			// Mise en page de l'item
			$items .= '<li>';
			$items .= '<a href="' . helper::baseUrl() . $parentPageId . '"' . $active . $targetBlank . '>' . $this->getData(['page', $parentPageId, 'title']) . '</a>';
			$items .= '<ul>';
			foreach($childrenPageIds as $childKey) {
				// Propriétés de l'item
				$active = ($childKey === $this->getUrl(0)) ? ' class="active"' : '';
				$targetBlank = $this->getData(['page', $childKey, 'targetBlank']) ? ' target="_blank"' : '';
				// Mise en page du sous-item
				$items .= '<li><a href="' . helper::baseUrl() . $childKey . '"' . $active . $targetBlank . '>' . $this->getData(['page', $childKey, 'title']) . '</a></li>';
			}
			$items .= '</ul>';
			$items .= '</li>';
		}
		// Lien de connexion
		if(
			(
				$this->getData(['theme', 'menu', 'loginLink'])
				AND $this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
			)
			OR $this->getUrl(0) === 'theme'
		) {
			$items .= '<li id="menuLoginLink" ' . ($this->getUrl(0) === 'theme' ? 'class="displayNone"' : '') . '><a href="' . helper::baseUrl() . 'user/login">' . helper::translate('Connexion') . '</a>';
		}
		// Retourne les items du menu
		echo '<ul>' . $items . '</ul>';
	}

	/**
	 * Affiche le meta titre
	 */
	public function showMetaTitle() {
		echo '<title>' . self::$outputMetaTitle . '</title>';
	}

	/**
	 * Affiche la meta description
	 */
	public function showMetaDescription() {
		echo '<meta name="description" content="' . self::$outputMetaDescription . '">';
	}

	/**
	 * Affiche la notification
	 */
	public function showNotification() {
		if(common::$inputNotices) {
			echo '<div id="notification" class="notificationError">' . helper::translate('Impossible de soumettre le formulaire, car il contient des erreurs !') . '</div>';
		}
		elseif(empty($_SESSION['ZWII_NOTIFICATION_SUCCESS']) === false) {
			echo '<div id="notification" class="notificationSuccess">' . $_SESSION['ZWII_NOTIFICATION_SUCCESS'] . '</div>';
			unset($_SESSION['ZWII_NOTIFICATION_SUCCESS']);
		}
		elseif(empty($_SESSION['ZWII_NOTIFICATION_ERROR']) === false) {
			echo '<div id="notification" class="notificationError">' . $_SESSION['ZWII_NOTIFICATION_ERROR'] . '</div>';
			unset($_SESSION['ZWII_NOTIFICATION_ERROR']);
		}
	}

	/**
	 * Affiche le panneau d'administration
	 */
	public function showPanel() {
		if($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')) {
			// Items de gauche
			$leftItems = '';
			if($this->getUser('rank') >= self::RANK_MODERATOR) {
				$leftItems .= '<li><select id="panelSelectPage">';
				$leftItems .= '<option value="">' . helper::translate('Choisissez une page') . '</option>';
				$currentPageId = $this->getData(['page', $this->getUrl(0)]) ? $this->getUrl(0) : $this->getUrl(2);
				foreach($this->getHierarchy(null, false) as $parentPageId => $childrenPageIds) {
					$leftItems .= '<option value="' . helper::baseUrl() . $parentPageId . '"' . ($parentPageId === $currentPageId ? ' selected' : false) . '>' . $this->getData(['page', $parentPageId, 'title']) . '</option>';
					foreach($childrenPageIds as $childKey) {
						$leftItems .= '<option value="' . helper::baseUrl() . $childKey . '"' . ($childKey === $currentPageId ? ' selected' : false) . '>&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getData(['page', $childKey, 'title']) . '</option>';
					}
				}
				$leftItems .= '</select></li>';
			}
			// Items de droite
			$rightItems = '';
			if($this->getUser('rank') >= self::RANK_MODERATOR) {
				if(
					$this->getData(['page', $this->getUrl(0)])
					OR $this->getUrl(0) === "" // Lorsqu'un utilisateur arrive sur la racine du site
				) {
					$rightItems .= '<li><a href="' . helper::baseUrl() . 'page/edit/' . $this->getUrl(0) . '" title="' . helper::translate('Modifier la page') . '">' . template::ico('pencil') . '</a></li>';
				}
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'page/add" title="' . helper::translate('Créer une page') . '">' . template::ico('plus') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php?type=0&akey=' . md5_file('site/data/data.json') .'&lang=' . $this->getData(['config', 'language']) . '" title="' . helper::translate('Gérer les fichiers') . '" data-lity>' . template::ico('folder') . '</a></li>';
			}
			if($this->getUser('rank') >= self::RANK_ADMIN) {
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'user" title="' . helper::translate('Configurer les utilisateurs') . '">' . template::ico('users') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'theme" title="' . helper::translate('Personnaliser le thème') . '">' . template::ico('brush') . '</a></li>';
				$rightItems .= '<li><a href="' . helper::baseUrl() . 'config" title="' . helper::translate('Configurer le site') . '">' . template::ico('gear') . '</a></li>';
			}
			$rightItems .= '<li><a href="' . helper::baseUrl() . 'user/edit/' . $this->getUser('id') . '" title="' . helper::translate('Configurer mon compte') . '">' . template::ico('user', 'right') . $this->getUser('name') . '</a></li>';
			$rightItems .= '<li><a id="panelLogout" href="' . helper::baseUrl() . 'user/logout" title="' . helper::translate('Se déconnecter') . '">' . template::ico('logout') . '</a></li>';
			// Panneau
			echo '<div id="panel"><div class="container"><ul id="panelLeft">' . $leftItems . '</ul><ul id="panelRight">' . $rightItems . '</ul></div></div>';
		}
	}

	/**
	 * Affiche le script
	 */
	public function showScript() {
		ob_start();
		require 'core/core.js.php';
		$coreScript = ob_get_clean();
		echo '<script>' . helper::minifyJs($coreScript . self::$outputScript) . '</script>';
	}

	/**
	 * Affiche le style
	 */
	public function showStyle() {
		if(self::$outputStyle) {
			echo '<style>' . helper::minifyCss(self::$outputStyle) . '</style>';
		}
	}

	/**
	 * Affiche les réseaux sociaux
	 */
	public function showSocials() {
		$socials = '';
		foreach($this->getData(['config', 'social']) as $socialName => $socialId) {
			switch($socialName) {
				case 'facebookId':
					$socialUrl = 'https://www.facebook.com/';
					break;
				case 'googleplusId':
					$socialUrl = 'https://plus.google.com/';
					break;
				case 'instagramId':
					$socialUrl = 'https://www.instagram.com/';
					break;
				case 'pinterestId':
					$socialUrl = 'https://pinterest.com/';
					break;
				case 'twitterId':
					$socialUrl = 'https://twitter.com/';
					break;
				case 'youtubeId':
					$socialUrl = 'https://www.youtube.com/channel/';
					break;
				default:
					$socialUrl = '';
			}
			if($socialId !== '') {
				$socials .= '<a href="' . $socialUrl . $socialId . '" target="_blank">' . template::ico(substr($socialName, 0, -2)) . '</a>';
			}
		}
		if($socials !== '') {
			echo '<div id="footerSocials">' . $socials . '</div>';
		}
	}

	/**
	 * Affiche l'import des librairies
	 */
	public function showVendor() {
		// Variables partagées
		$vars = 'var baseUrl = ' . json_encode(helper::baseUrl(false)) . ';';
		$vars .= 'var baseUrlQs = ' . json_encode(helper::baseUrl()) . ';';
		$vars .= 'var language = ' . json_encode($this->getData(['config', 'language'])) . ';';
		if(
			$this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD', helper::FILTER_STRING, '_COOKIE')
			AND $this->getUser('rank') >= self::RANK_MODERATOR
		) {
			$vars .= 'var privateKey = ' . json_encode(md5_file('site/data/data.json')) . ';';
		}
		echo '<script>' . helper::minifyJs($vars) . '</script>';
		// Librairies
		foreach(self::$outputVendor as $vendorName) {
			// Coeur
			if(file_exists('core/vendor/' . $vendorName . '/inc.json')) {
				$vendorPath = 'core/vendor/' . $vendorName . '/';
			}
			// Module
			elseif(
				in_array($this->getUrl(0), self::$coreModuleIds) === false
				AND file_exists('module/' . $this->getUrl(0) . '/vendor/' . $vendorName . '/inc.json')
			) {
				$vendorPath = 'module/' . $this->getUrl(0) . '/vendor/' . $vendorName . '/';
			}
			// Sinon continue
			else {
				continue;
			}
			// Détermine le type d'import en fonction de l'extension de la librairie
			$vendorFiles = json_decode(file_get_contents($vendorPath . 'inc.json'));
			foreach($vendorFiles as $vendorFile) {
				switch(pathinfo($vendorFile, PATHINFO_EXTENSION)) {
					case 'css':
						echo '<link rel="stylesheet" href="' . helper::baseUrl(false) . $vendorPath . $vendorFile . '">';
						break;
					case 'js':
						echo '<script src="' . helper::baseUrl(false) . $vendorPath . $vendorFile . '"></script>';
						break;
				}
			}
		}
	}

}

class template {

	/**
	 * Crée un bouton
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function button($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'disabled' => false,
			'href' => 'javascript:void(0);',
			'id' => $nameId,
			'name' => $nameId,
			'target' => '',
			'value' => 'Bouton'
		], $attributes);
		// Retourne le html
		return sprintf(
			'<a %s class="button %s %s">%s</a>',
			helper::sprintAttributes($attributes, ['value', 'class', 'disabled']),
			$attributes['disabled'] ? 'disabled' : '',
			$attributes['class'],
			helper::translate($attributes['value'])
		);
	}

	/**
	 * Crée un champ capcha
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function capcha($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'help' => '',
			'id' => $nameId,
			'name' => $nameId,
			'required' => true,
			'value' => ''
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Génère deux nombres pour le capcha
		$firstNumber = mt_rand(1, 15);
		$secondNumber = mt_rand(1, 15);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		$html .= self::label($attributes['id'], helper::translate('Quelle est la somme de') . ' ' . $firstNumber . ' + ' . $secondNumber . ' ?', [
			'help' => $attributes['help']
		]);
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Capcha
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Champs cachés contenant les nombres
		$html .= self::hidden($attributes['id'] . 'FirstNumber', [
			'value' => $firstNumber,
			'before' => false
		]);
		$html .= self::hidden($attributes['id'] . 'SecondNumber', [
			'value' => $secondNumber,
			'before' => false
		]);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une case à cocher à sélection multiple
	 * @param string $nameId Nom et id du champ
	 * @param string $value Valeur de la case à cocher
	 * @param string $label Label de la case à cocher
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function checkbox($nameId, $value, $label, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'checked' => '',
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'name' => $nameId,
			'required' => false
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['checked'] = (bool) common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="checkbox" value="%s" %s>',
			$value,
			helper::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($attributes['id'], '<span>' . $label . '</span>', [
			'help' => $attributes['help']
		]);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ d'upload de fichier
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function file($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'extensions' => '',
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'lang' => 'fr_FR',
			'name' => $nameId,
			'required' => false,
			'type' => 2,
			'value' => ''
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Champ caché contenant l'url de la page
		$html .= self::hidden($attributes['id'], [
			'value' => $attributes['value'],
			'disabled' => $attributes['disabled'],
			'class' => 'inputFileHidden'
		]);
		// Champ d'upload
		$html .= sprintf(
			'<a
				href="' .
					helper::baseUrl(false) . 'core/vendor/filemanager/dialog.php' .
					'?relative_url=1' .
					'&field_id=' . $attributes['id'] .
					'&type=' . $attributes['type'] .
					'&lang=' . $attributes['lang'] .
					'&akey=' . md5_file('site/data/data.json') .
					($attributes['extensions'] ? '&extensions=' . $attributes['extensions'] : '')
				. '"
				class="inputFile %s %s"
				%s
				data-lity
			>
				' . self::ico('download', 'right') . '
				<span class="inputFileLabel"></span>
			</a>',
			$attributes['class'],
			$attributes['disabled'] ? 'disabled' : '',
			helper::sprintAttributes($attributes, ['class', 'extensions', 'type'])
		);
		// Bouton de suppression
		$html .= self::button($attributes['id'] . 'Delete', [
			'class' => 'inputFileDelete',
			'value' => self::ico('cancel')
		]);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une notice
	 * @param string $id Id du champ
	 * @return string
	 */
	public static function notice($id) {
		return '<div class="notice">' . helper::translate(common::$inputNotices[$id]) . '</div>';
	}

	/**
	 * Crée une aide qui s'affiche au survole
	 * @param string $text Texte de l'aide
	 * @return string
	 */
	public static function help($text) {
		return '<span class="helpButton">' . self::ico('help') . '<div class="helpContent">' . helper::translate($text) . '</div></span>';
	}

	/**
	 * Crée un champ caché
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function hidden($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'id' => $nameId,
			'name' => $nameId,
			'value' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Texte
		$html = sprintf('<input type="hidden" %s>', helper::sprintAttributes($attributes, ['before']));
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un icône
	 * @param string $ico Classe de l'icône
	 * @param string $margin Ajoute un margin autour de l'icône (choix : left, right, all)
	 * @param bool $animate Ajoute une animation à l'icône
	 * @param string $fontSize Taille de la police
	 * @return string
	 */
	public static function ico($ico, $margin = '', $animate = false, $fontSize = '1em') {
		return '<span class="zwiico-' . $ico . ($margin ? ' zwiico-margin-' . $margin : '') . ($animate ? ' animate-spin' : '') . '" style="font-size:' . $fontSize . '"></span>';
	}

	/**
	 * Crée un label
	 * @param string $for For du label
	 * @param array $attributes Attributs ($key => $value)
	 * @param string $text Texte du label
	 * @return string
	 */
	public static function label($for, $text, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'for' => $for,
			'help' => ''
		], $attributes);
		// Traduit le text
		$text = helper::translate($text);
		// Ajout d'une aide
		if($attributes['help'] !== '') {
			$text = $text . self::help($attributes['help']);
		}
		// Retourne le html
		return sprintf(
			'<label %s>%s</label>',
			helper::sprintAttributes($attributes),
			$text
		);
	}

	/**
	 * Crée un champ mot de passe
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function password($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'autocomplete' => 'on',
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => '',
			'required' => false
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Mot de passe
		$html .= sprintf(
			'<input type="password" %s>',
			helper::sprintAttributes($attributes)
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ sélection
	 * @param string $nameId Nom et id du champ
	 * @param array $options Liste des options du champ de sélection ($value => $text)
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function select($nameId, array $options, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'required' => false,
			'selected' => ''
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['selected'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Début sélection
		$html .= sprintf('<select %s>',
			helper::sprintAttributes($attributes)
		);
		// Options
		foreach($options as $value => $text) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				$value,
				$attributes['selected'] == $value ? ' selected' : '', // Double == pour ignorer le type de variable car $_POST change les types en string
				helper::translate($text)
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une bulle de dialogue
	 * @param string $text Texte de la bulle
	 * @return string
	 */
	public static function speech($text) {
		return '<div class="speech"><div class="speechBubble">' . helper::translate($text) . '</div>' . template::ico('mimi speechMimi', '', false, '7em') . '</div>';
	}

	/**
	 * Crée un bouton validation
	 * @param string $nameId Nom & id du bouton validation
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function submit($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'disabled' => false,
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Enregistrer'
		], $attributes);
		// Retourne le html
		return sprintf(
			'<input type="submit" value="%s" %s>',
			helper::translate($attributes['value']),
			helper::sprintAttributes($attributes, ['value'])
		);
	}

	/**
	 * Crée un tableau
	 * @param array $cols Cols des colonnes (format: [col colonne1, col colonne2, etc])
	 * @param array $body Contenu (format: [[contenu1, contenu2, etc], [contenu1, contenu2, etc]])
	 * @param array $head Entêtes (format : [[titre colonne1, titre colonne2, etc])
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function table(array $cols = [], array $body = [], array $head = [], array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'id' => ''
		], $attributes);
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="tableWrapper ' . $attributes['classWrapper']. '">';
		// Début tableau
		$html .= '<table id="' . $attributes['id'] . '" class="' . $attributes['class']. '">';
		// Entêtes
		if($head) {
			// Début des entêtes
			$html .= '<thead>';
			$html .= '<tr>';
			$i = 0;
			foreach($head as $th) {
				$html .= '<th class="col' . $cols[$i++] . '">' . helper::translate($th) . '</th>';
			}
			// Fin des entêtes
			$html .= '</tr>';
			$html .= '</thead>';
		}
		// Début contenu
		$html .= '<tbody>';
		foreach($body as $tr) {
			$html .= '<tr>';
			$i = 0;
			foreach($tr as $td) {
				$html .= '<td class="col' . $cols[$i++] . '">' . $td . '</td>';
			}
			$html .= '</tr>';
		}
		// Fin contenu
		$html .= '</tbody>';
		// Fin tableau
		$html .= '</table>';
		// Fin container
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte court
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function text($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'placeholder' => '',
			'readonly' => '',
			'required' => false,
			'value' => ''
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte long
	 * @param string $nameId Nom et id du champ
	 * @param array $attributes Attributs ($key => $value)
	 * @return string
	 */
	public static function textarea($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'before' => true,
			'class' => '',
			'classWrapper' => '',
			'disabled' => false,
			'help' => '',
			'id' => $nameId,
			'label' => '',
			'name' => $nameId,
			'readonly' => '',
			'required' => false,
			'value' => ''
		], $attributes);
		// Champ requis
		common::setInputRequired($attributes);
		// Sauvegarde des données en cas d'erreur
		if($attributes['before'] AND array_key_exists($attributes['id'], common::$inputBefore)) {
			$attributes['value'] = common::$inputBefore[$attributes['id']];
		}
		// Début du wrapper
		$html = '<div id="' . $attributes['id'] . 'Wrapper" class="inputWrapper ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(array_key_exists($attributes['id'], common::$inputNotices)) {
			$html .= self::notice($attributes['id']);
			$attributes['class'] .= ' notice';
		}
		// Texte long
		$html .= sprintf(
			'<textarea %s>%s</textarea>',
			helper::sprintAttributes($attributes, ['value']),
			$attributes['value']
		);
		// Fin du wrapper
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

}