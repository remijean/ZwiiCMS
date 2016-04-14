<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class core
{
	/** @var array Liste des vues pour les modules */
	public static $views = [];

	/** @var bool Autorise ou non la mise en cache pour les modules */
	public static $cache = true;

	/** @var string Titre de la page */
	public static $title = '';

	/** @var string Meta title du site */
	public static $metaTitle = '';

	/** @var string Description de la page */
	public static $description = '';

	/** @var string Contenu de la page */
	public static $content = '';

	/** @var string Type de layout à afficher (LAYOUT : layout et mise cache - JSON : tableau JSON - BLANK : page vide) */
	public static $layout = 'LAYOUT';

	/** @var array Langue du site */
	public static $language = [];

	/** @var array Base de données */
	private $data;

	/** @var array Liste des pages parentes et de leurs enfants */
	private $hierarchy;

	/** @var array Url du site coupée à chaque "/" */
	private $url;

	/** @var array Liste des modules du système */
	private static $system = [
		'clean',
		'config',
		'create',
		'delete',
		// 'edit', faux module système
		'export',
		// 'login', faux module système
		'logout',
		'manager',
		'mode',
		'module',
		'phpinfo',
		'save',
		'upload'
	];

	/** @var array Liste des librairies à charger */
	public static $vendor = [
		'jquery' => true,
		'jquery-ui' => false,
		'jscolor' => false,
		'normalize' => true,
		'tinymce' => false,
		'zwiico' => true
	];

	/** Version de ZwiiCMS */
	private static $version = '7.5.1';

	/** Récupère les données */
	public function __construct()
	{
		if(empty($this->data)) {
			$this->data = json_decode(file_get_contents('data/data.json'), true);
		}
	}

	############################################################
	# GETTERS/SETTERS

	/**
	 * Accède aux données du tableau de données
	 * @param  mixed $keys Clé(s) des données
	 * @return mixed
	 */
	public function getData($keys = null)
	{
		// Retourne l'ensemble des données
		if($keys === null) {
			return $this->data;
		}
		// Transforme la clé en tableau
		elseif(!is_array($keys)) {
			$keys = [$keys];
		}
		// Décent dans les niveaux de la variable $data
		$data = $this->data;
		foreach($keys as $key) {
			// Si aucune donnée n'existe retourne false
			if(empty($data[$key])) {
				return false;
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
	 * Insert des données dans le tableau de données
	 * @param array $keys Clé(s) des données
	 */
	public function setData($keys)
	{
		// Modifie les données si aucune notice n'existe
		if(!template::$notices) {
			// Insert les données en fonction du niveau
			switch(count($keys)) {
				case 2 :
					$this->data[$keys[0]] = $keys[1];
					break;
				case 3:
					$this->data[$keys[0]][$keys[1]] = $keys[2];
					break;
				case 4:
					$this->data[$keys[0]][$keys[1]][$keys[2]] = $keys[3];
					break;
			}
		}
	}

	/**
	 * Supprime des données dans le tableau de données
	 * @param mixed $keys Clé(s) des données
	 */
	public function removeData($keys)
	{
		// Supprime les données si aucune notice n'existe
		if(!template::$notices) {
			// Transforme la clé en tableau
			if(!is_array($keys)) {
				$keys = [$keys];
			}
			// Supprime la clef en fonction du niveau
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
	}

	/**
	 * Enregistre le tableau de données et supprime les fichiers de cache
	 * @param bool $removeAllCache Supprime l'ensemble des fichiers cache, sinon supprime juste les fichiers cache en rapport avec le module courant
	 */
	public function saveData($removeAllCache = false)
	{
		// Enregistre les données si aucune notice n'existe
		if(!template::$notices) {
			// Liste les les fichiers de cache
			$it = new DirectoryIterator('core/cache/');
			foreach($it as $file) {
				// Check que la cible est un fichier
				if($file->isFile() AND $file->getBasename() !== '.gitkeep') {
					// Supprime automatiquement le fichier si l'argument $removeAllCache est à true
					if($removeAllCache === true) {
						unlink($file->getPathname());
					}
					// Supprime le cache de la page si elle vient d'être modifiée
					elseif($this->getUrl(0) === explode('_', $file->getBasename('.html'))[0]) {
						unlink($file->getPathname());
					}
				}
			}
			file_put_contents('data/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Génère la liste des pages parentes et de leurs enfants
	 * @return array
	 */
	public function getHierarchy() {
		if(empty($this->hierarchy)) {
			$children = [];
			// Liste les pages par position en ordre croissant
			$pages = helper::arrayCollumn($this->getData('pages'), 'position', 'SORT_ASC', true);
			// Passe en revue les pages
			foreach($pages as $pageKey => $pagePosition) {
				// Si la page n'a pas de parent = page parente
				if(!$this->getData(['pages', $pageKey, 'parent'])) {
					$this->hierarchy[$pageKey] = [];
				}
				// Si la page a un parent = page enfant
				else {
					$children[$this->getData(['pages', $pageKey, 'parent'])][] = $pageKey;
				}
			}
			// Ajoute les enfants au parents
			foreach($this->hierarchy as $parentKey => $childrenKeys) {
				if(isset($children[$parentKey])) {
					$this->hierarchy[$parentKey] = $children[$parentKey];
				}
			}
		}
		return $this->hierarchy;
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète (la clef 0 est toujours égale à la page sauf si splice est à false)
	 * @param  int    $key    Clé de l'URL
	 * @param  bool   $splice Supprime la première clef si elle correspond à un module système
	 * @return string
	 */
	public function getUrl($key = null, $splice = true)
	{
		// Construit l'URL
		if(empty($this->url)) {
			$this->url = empty($_SERVER['QUERY_STRING']) ? $this->getData(['config', 'index']) : $_SERVER['QUERY_STRING'];
			$this->url = helper::filter($this->url, helper::URL);
			$this->url = explode('/', $this->url);
		}
		// Retourne l'URL complète
		if($key === null) {
			return implode('/', $this->url);
		}
		// Retourne une partie de l'URL
		else {
			// Variable temporaire pour ne pas impacter la propriété $this->url avec le array_splice()
			$url = $this->url;
			// Supprime les modules système de $this->url[0] si ils sont présents
			if($splice AND (in_array($url[0], self::$system))) {
				array_splice($url, 0, 1);
			}
			// Retourne l'URL filtrée
			return empty($url[$key]) ? '' : helper::filter($url[$key], helper::URL);
		}

	}

	/**
	 * Accède au cookie contenant le mot de passe
	 * @return string
	 */
	public function getCookie()
	{
		return isset($_COOKIE['PASSWORD']) ? $_COOKIE['PASSWORD'] : '';
	}

	/**
	 * Modifie le mot de passe contenu dans le cookie
	 * @param string $password Mot de passe
	 * @param int    $time     Temps de vie du cookie
	 */
	public function setCookie($password, $time)
	{
		setcookie('PASSWORD', helper::filter($password, helper::PASSWORD), $time);
	}

	/** Supprime le cookie contenant le mot de passe */
	public function removeCookie()
	{
		setcookie('PASSWORD');
	}

	/**
	 * Accède à la notification et supprime les sessions rattachées
	 * @return array
	 */
	public function getNotification()
	{
		$notification = [
			'notice' => template::$notices,
			'success' => (isset($_SESSION['SUCCESS']) ? $_SESSION['SUCCESS'] : ''),
			'error' => (isset($_SESSION['ERROR']) ? $_SESSION['ERROR'] : '')
		];
		unset($_SESSION['SUCCESS']);
		unset($_SESSION['ERROR']);
		return $notification;
	}

	/**
	 * Modifie la notification
	 * @param string $notification Notification
	 * @param bool   $error        Message d'erreur ou non
	 */
	public function setNotification($notification, $error = false)
	{
		if(!template::$notices) {
			$_SESSION[$error ? 'ERROR' : 'SUCCESS'] = $notification;
		}
	}

	/**
	 * Accède au mode d'affichage
	 * @return string
	 */
	public function getMode()
	{
		return !empty($_SESSION['MODE']);
	}

	/**
	 * Modifie le mode d'affichage
	 * @param bool $mode True pour activer le mode édition ou false pour le désactiver
	 */
	public function setMode($mode)
	{
		$_SESSION['MODE'] = $mode;
	}

	/**
	 * Accède à une valeur de la variable HTTP POST et lui applique un filtre
	 * @param  mixed  $keys   Clé(s) de la valeur
	 * @param  string $filter Filtre à appliquer
	 * @return mixed
	 */
	public function getPost($keys, $filter = null)
	{
		// Si la clef n'est pas un tableau
		if(!is_array($keys)) {
			// Erreur champ obligatoire
			if(empty($_POST[$keys])) {
				template::getRequired($keys);
			}
			// Transforme la clé en tableau
			$keys = [$keys];
		}
		// Décent dans les niveaux de la variable HTTP POST
		$post = $_POST;
		foreach($keys as $key) {
			// Retourne une valeur si la clef n'existe pas (sinon bug avec les cases à cocher non cochées)
			if(isset($post[$key])) {
				$post = $post[$key];
			}
			else {
				$post = '';
				break;
			}
		}
		// Applique le filtre et retourne la valeur
		return ($filter !== null) ? helper::filter($post, $filter) : $post;
	}

	############################################################
	# SYSTÈME

	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className)
	{
		$className = substr($className, 0, -3);
		$classPath = 'module/' . $className . '/' . $className . '.php';
		if(is_readable($classPath)) {
			require $classPath;
		}
	}

	/** Crée la connexion entre les modules et le système afin d'afficher le contenu de la page */
	public function router()
	{
		// Module système
		if(
			// Si un module système est demandé et qu'il existe
			in_array($this->getUrl(0, false), self::$system)
			// Si le mode édition est activé et qu'une page est demandée
			OR ($this->getMode() AND $page = $this->getData(['pages', $this->getUrl(0, false)]))
		) {
			// Retourne le module édition pour le cas "Si le mode édition est activé et qu'une page est demandée"
			$module = isset($page) ? 'edit' : $this->getUrl(0, false);
			// Si l'utilisateur est connecté le module système est retournée
			if($this->getData(['config', 'password']) === $this->getCookie()) {
				$method = $module;
				$this->$method();
			}
			// Sinon il doit s'identifier
			else {
				$this->login();
			}
		}
		// Page et module de page
		elseif($this->getData(['pages', $this->getUrl(0, false)])) {
			// Utilisateur non connecté et layout LAYOUT utilisé
			if(!$this->getCookie() AND self::$layout === 'LAYOUT') {
				// Remplace les / de l'URL par des _
				$url = str_replace('/', '_', $this->getUrl());
				// Importe le fichier si il existe
				if(file_exists('core/cache/' . $url . '.html')) {
					require 'core/cache/' . $url . '.html';
					exit;
				}
				// Sinon ouvre la mémoire tampon pour la future mise en cache
				else {
					ob_start();
				}
			}
			// Importe le module de la page
			if($this->getData(['pages', $this->getUrl(0), 'module'])) {
				$module = $this->getData(['pages', $this->getUrl(0), 'module']) . 'Mod';
				$module = new $module;
				$method = in_array($this->getUrl(1), $module::$views) ? $this->getUrl(1) : 'index';
				$module->$method();
				// Mise en cache en fonction du module
				self::$cache = $module::$cache;
			}
			// Titre, description et contenu de la page
			self::$title = $this->getData(['pages', $this->getUrl(0, false), 'title']);
			self::$metaTitle = $this->getData(['pages', $this->getUrl(0, false), 'metaTitle']);
			self::$description = $this->getData(['pages', $this->getUrl(0, false), 'description']);
			self::$content = $this->getData(['pages', $this->getUrl(0, false), 'content']) . self::$content;
		}
		// Erreur 404
		if(!self::$content) {
			http_response_code(404);
			self::$title = helper::translate('Erreur 404');
			self::$content = '<p>' . helper::translate('Page introuvable !') . '</p>';
		}
		// Choix du type de données à afficher
		switch(self::$layout) {
			// Affiche le layout
			case 'LAYOUT':
				// Méta titre par défaut
				if(!self::$metaTitle) {
					self::$metaTitle = self::$title . ' - ' . $this->getData(['config', 'title']);
				}
				// Description par défaut
				if(!self::$description) {
					self::$description = $this->getData(['config', 'description']);
				}
				// Importe le layout
				require 'core/layout.html';
				break;
			// Affiche un tableau JSON
			case 'JSON':
				echo json_encode(self::$content);
				break;
			// Affiche une page vide
			case 'BLANK':
				echo self::$content;
				break;
		}
	}

	/** Supprime les fichiers temporaires lorsqu'ils datent de plus d'un jour */
	public function cleanTmpFiles()
	{
		$it = new DirectoryIterator('core/tmp/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getBasename() !== '.gitkeep' AND $file->getMTime() + 86400 < time()) {
				unlink($file->getPathname());
			}
		}
	}

	/** Génération dynamique du css des couleurs */
	public function generateColorCss()
	{
		$md5Colors = md5(json_encode($this->getData('colors')));
		if(!file_exists('core/cache/' . $md5Colors . '.css')) {
			// Couleur du header
			list($r, $g, $b) = helper::hexToRgb($this->getData(['colors', 'header']));
			$headerColor = $r . ',' . $g . ',' . $b;
			$headerTextVariant = ($r + $g + $b / 3) < 350 ? '#FFF' : 'inherit';
			// Couleurs du menu
			list($r, $g, $b) = helper::hexToRgb($this->getData(['colors', 'menu']));
			$menuColor = $r . ',' . $g . ',' . $b;
			$menuColorDark = ($r - 20) . ',' . ($g - 20) . ',' . ($b - 20);
			$menuColorVeryDark = ($r - 25) . ',' . ($g - 25) . ',' . ($b - 25);
			$menuTextVariant = intval($r + $g + $b / 3) < 350 ? '#FFF' : 'inherit';
			// Couleurs des éléments
			list($r, $g, $b) = helper::hexToRgb($this->getData(['colors', 'element']));
			$elementColor = $r . ',' . $g . ',' . $b;
			$elementColorDark = ($r - 20) . ',' . ($g - 20) . ',' . ($b - 20);
			$elementColorVeryDark = ($r - 25) . ',' . ($g - 25) . ',' . ($b - 25);
			$elementTextVariant = intval($r + $g + $b / 3) < 350 ? '#FFF' : 'inherit';
			// Couleur de fond
			list($r, $g, $b) = helper::hexToRgb($this->getData(['colors', 'background']));
			$backgroundColor = $r . ',' . $g . ',' . $b;
			// Mise en forme du css
			$css = '
				/* Couleur normale */
				/* Bannière */
				header {
					background-color: rgb(' . $headerColor . ');
				}
				header h1 {
					color: ' . $headerTextVariant . ';
				}
				/* Menu */
				.toggle,
				nav,
				nav ul {
					background-color: rgb(' . $menuColor . ');
				}
				.toggle span,
				nav a {
					color: ' . $menuTextVariant . ';
				}
				/* Eléments */
				input[type=\'submit\'],
				.button,
				.pagination a,
				input[type=\'checkbox\']:checked + label:before,
				input[type=\'radio\']:checked + label:before,
				.helpContent {
					background-color: rgb(' . $elementColor . ');
					color: ' . $elementTextVariant . ';
				}
				h2,
				h4,
				h6,
				a,
				.tabTitle.current,
				.helpButton {
					color: rgb(' . $elementColor . ');
				}
				input[type=\'text\']:hover,
				input[type=\'password\']:hover,
				input[type=\'file\']:hover,
				select:hover,
				textarea:hover {
					border: 1px solid rgb(' . $elementColor . ');
				}
				/* Fond */
				body {
					background-color: rgb(' . $backgroundColor . ');
				}
				
				/* Couleur foncée */
				/* Menu */
				.toggle:hover,
				nav a:hover {
					background-color: rgb(' . $menuColorDark . ');
				}
				/* Eléments */
				input[type=\'submit\']:hover,
				.button:hover,
				.pagination a:hover,
				input[type=\'checkbox\']:not(:active):checked:hover + label:before,
				input[type=\'checkbox\']:active + label:before,
				input[type=\'radio\']:checked:hover + label:before,
				input[type=\'radio\']:not(:checked):active + label:before {
					background-color: rgb(' . $elementColorDark . ');
				}
				.helpButton:hover {
					color: rgb(' . $elementColorDark . ');
				}
				
				/* Couleur très foncée */
				/* Menu */
				.toggle:active,
				nav a:active,
				nav a.current {
					background-color: rgb(' . $menuColorVeryDark . ');
				}
				/* Eléments */
				input[type=\'submit\']:active,
				.button:active,
				.pagination a:active {
					background-color: rgb(' . $elementColorVeryDark . ');
				}
			';
			file_put_contents('core/cache/' . $md5Colors . '.css', helper::minifyCss($css));
		}
	}

	/**
	 * Génère le fichier de cache et retourne la valeur tampon pour les pages publics (appelé après l'affichage du site dans index.php)
	 * @return string
	 */
	public function putGetCache()
	{
		// Remplace les / de l'URL par des _
		$url = str_replace('/', '_', $this->getUrl());
		// Crée le cache si :
		// - l'utilisateur est sur une page
		// - le module ne bloque pas la mise en cache
		// - l'utilisateur n'est pas connecté
		// - le fichier de cache n'existe pas
		// - le layout utilisé est LAYOUT
		if(
			$this->getData(['pages', $this->getUrl(0)])
			AND self::$cache
			AND !$this->getCookie()
			AND !file_exists('core/cache/' . $url . '.html')
			AND self::$layout === 'LAYOUT'
		) {
			// Récupère le contenu de la page mis en cache dans la méthode $this->router()
			$cache = ob_get_clean();
			// Crée le fichier et colle le contenu du cache
			file_put_contents('core/cache/' . $url . '.html', $cache);
			// Affiche la page
			return $cache;
		}
	}

	/** Importe les fichiers de langue du site */
	public function importLanguage()
	{
		// Importe le fichier langue système
		$language = 'core/lang/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = json_decode(file_get_contents($language), true);
		}
		// Importe le fichier langue pour le module de la page
		$language = 'module/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '/langs/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = array_merge(self::$language, json_decode(file_get_contents($language), true));
		}
	}

	/**
	 * Importe les librairies
	 * @return string
	 */
	public function vendor()
	{
		$vendor = '';
		foreach(self::$vendor as $vendorName => $vendorStatus) {
			if($vendorStatus) {
				switch($vendorName) {
					case 'jquery':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery/jquery.min.js"></script>';
						break;
					case 'jquery-ui':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.min.js"></script>';
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.touch-punch.min.js"></script>';
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/jquery-ui/jquery-ui.min.css">';
						break;
					case 'jscolor':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/jscolor/jscolor.min.js"></script>';
						break;
					case 'tinymce':
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/tinymce.min.js"></script>';
						$vendor .= '<script src="' . helper::baseUrl(false) . 'core/vendor/tinymce/jquery.tinymce.min.js"></script>';
						break;
					case 'normalize':
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/normalize/normalize.min.css">';
						break;
					case 'zwiico':
						$vendor .= '<link rel="stylesheet" href="' . helper::baseUrl(false) . 'core/vendor/zwiico/css/zwiico.min.css">';
						break;
				}
			}
		}
		return $vendor;
	}

	/**
	 * Met en forme le panneau d'administration
	 * @return string
	 */
	public function panel()
	{
		// Crée le panneau seulement si l'utilisateur est connecté
		if($this->getCookie() === $this->getData(['config', 'password'])) {
			// Items de gauche
			$left = '<li><select onchange="$(location).attr(\'href\', $(this).val());">';
			// Affiche l'option "Choisissez une page" seulement pour le module de configuration et le gestionnaire de fichier
			if(in_array($this->getUrl(0, false), ['config', 'manager'])) {
				$left .= '<option value="">' . helper::translate('Choisissez une page') . '</option>';
			}
			// Crée des options pour les pages en les triant par titre
			$pages = helper::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true);
			foreach($pages as $pageKey => $pageTitle) {
				$current = ($pageKey === $this->getUrl(0)) ? ' selected' : false;
				$left .= '<option value="' . helper::baseUrl() . $this->getMode() . $pageKey . '"' . $current . '>' . $pageTitle . '</option>';
			}
			$left .= '</select></li>';
			// Items de droite
			$right = '<li><a href="' . helper::baseUrl() . 'create" title="' . helper::translate('Créer une page') . '">' . template::ico('plus') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'mode/' . $this->getUrl(null, false) . '"' . ($this->getMode() ? ' class="edit"' : '') . ' title="' . helper::translate('Activer/désactiver le mode édition') . '">' . template::ico('pencil') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'manager" title="' . helper::translate('Gérer les fichiers') . '">' . template::ico('folder') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'config" title="' . helper::translate('Configurer le site') . '">' . template::ico('gear') . '</a></li>';
			$right .= '<li><a href="' . helper::baseUrl() . 'logout" onclick="return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir vous déconnecter ?') . '\');" title="' . helper::translate('Se déconnecter') . '">' . template::ico('logout') . '</a></li>';
			// Retourne le panneau
			return '<div id="panel"><div class="container"><ul class="left">' . $left . '</ul><ul class="right">' . $right . '</ul></div></div>';
		}
	}

	/**
	 * Met en forme la notification
	 * @return string
	 */
	public function notification()
	{
		$notification = $this->getNotification();
		// Si une notice existe, affiche un message pour prévenir l'utilisateur
		if(!empty($notification['notice'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => 'Impossible de soumettre le formulaire, car il contient des erreurs !'
			]);
		}
		// Si besoin, affiche une notification d'erreur
		elseif(!empty($notification['error'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => $notification['error']
			]);
		}
		// Si besoin, affiche une notification de succès
		elseif(!empty($notification['success'])) {
			$notification = template::div([
				'id' => 'notification',
				'class' => 'success',
				'text' => $notification['success']
			]);
		}
		// Si une notification existe elle est retournée
		if(is_string($notification)) {
			return $notification.
			template::script('
				// Cache la notification après 4 secondes
				setTimeout(function() {
					$("#notification").slideUp();
				}, 4000);
			');
		}
	}

	/**
	 * Met en forme la liste des classes du thème
	 * @return string
	 */
	public function theme()
	{
		// Liste des classes
		$class = [];
		foreach($this->getData(['theme']) as $key => $value) {
			// Cas spécifique pour l'image de la bannière
			if($key === 'headerImage' AND !empty($value)) {
				$class[] = 'themeHeaderImage';
			}
			// Cas spécifique pour l'image de fond
			if($key === 'backgroundImage' AND !empty($value)) {
				// Rien
			}
			// Pour les booleans
			elseif($value === true) {
				$class[] = 'theme' . ucfirst($key);
			}
			// Pour les autres
			elseif($value) {
				$class[] = $value;
			}
		}
		return implode($class, ' ');
	}
	
	/**
	 * Met en forme le menu
	 * @return string
	 */
	public function menu()
	{
		// Met en forme les items du menu
		$items = '';
		foreach($this->getHierarchy() as $parentKey => $childrenKeys) {
			// Propriétés de l'item
			$current = '';
			if($parentKey === $this->getUrl(0) OR in_array($this->getUrl(0), $childrenKeys)) {
				$current = ' class="current"';
			}
			$blank = ($this->getData(['pages', $parentKey, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : '';
			// Mise en page de l'item
			$items .= '<li>';
			$items .= '<a href="' . helper::baseUrl() . $parentKey . '"' . $current . $blank . '>' . $this->getData(['pages', $parentKey, 'title']) . '</a>';
			$items .= '<ul>';
			foreach($childrenKeys as $childKey) {
				// Propriétés de l'item
				$current = ($childKey === $this->getUrl(0)) ? ' class="current"' : '';
				$blank = ($this->getData(['pages', $childKey, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : '';
				// Mise en page du sous-item
				$items .= '<li><a href="' . helper::baseUrl() . $childKey . '"' . $current . $blank . '>' . $this->getData(['pages', $childKey, 'title']) . '</a></li>';
			}
			$items .= '</ul>';
			$items .= '</li>';
		}
		// Retourne les items du menu
		return $items;
	}

	/**
	 * Met en forme le contenu
	 * @return string
	 */
	public function content()
	{
		// Affiche ou non le titre
		$title = '';
		if(!$this->getData(['pages', $this->getUrl(0, false)]) OR !$this->getData(['pages', $this->getUrl(0, false), 'hideTitle'])) {
			$title = '<h2>' . self::$title . '</h2>';
		}
		// Retourne le contenu de la page
		return $title . self::$content;
	}

	/**
	 * Script Google Analytics
	 * @return string
	 */
	public function analytics()
	{
		$code = $this->getData(['config', 'analytics']);
		// Check si ce n'est pas l'administrateur
		if(!$this->getCookie() AND !empty($code) ) {
			$ga = '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
			$ga .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
			$ga .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
			$ga .= '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
			$ga .= 'ga(\'create\', \'' . $code . '\', \'auto\');';
			$ga .= 'ga(\'send\', \'pageview\');';
			return '<script>' . $ga . '</script>';
		}
	}

	/**
	 * Scripts communs
	 * @return string
	 */
	public function scripts()
	{
		$scripts = template::script('
			// Modifications non enregistrées du formulaire
			var form = $("form");
			form.data("serialize", form.serialize());
			$(window).on("beforeunload", function() {
				if(form.length && form.serialize() !== form.data("serialize")) {
					return "' . helper::translate('Attention, si vous continuez, vous allez perdre les modifications non enregistrées !') . '";
				}
			});
			form.submit(function() {
				$(window).off("beforeunload");
			});
			
			// Affiche/cache le menu en mode responsive
			var nav = $("nav");
			$(".toggle").on("click", function() {
				nav.slideToggle();
			});
			$(window).on("resize", function() {
				if($(window).width() > 768) {
					nav.css("display", "");
				}
			});
			
			// Affiche/cache le bouton pour remonter en haut
			var backToTop = $("#backToTop");
			$(window).on("scroll", function() {
				if($(this).scrollTop() > 200) {
					backToTop.fadeIn();
				}
				else {
					backToTop.fadeOut();
				}
			});
			
			// Remonter en haut au clic sur le bouton
			backToTop.on("click", function() {
				$("body, html").animate({scrollTop: 0}, "400");
			});
			
			// Convertit un code hexadecimal en rgb
			function hexToRgb(hex) {
				var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
				return result ? {
					r: parseInt(result[1], 16),
					g: parseInt(result[2], 16),
					b: parseInt(result[3], 16)
				} : null;
			}
		');
		if(self::$vendor['tinymce']) {
			$scripts .= template::script('
				// Ajoute le formulaire d\'upload de TinyMCE si il n\'existe pas
				if(!$("#editorFileForm").length) {
					body.append(
						$("<form>").attr({
							id: "editorForm",
							enctype: "multipart/form-data",
							method: "post"
						}).append(
							$("<input>").addClass("hide").attr({
								id: "editorFile",
								type: "file"
							}),
							$("<input>").attr({
								id: "editorField",
								type: "hidden"
							})
						)
					);
				}
				
				// Upload de tinyMCE
				$("#editorFile").on("change", function() {
					var editorField = $("#editorField").val();
					var editorFieldShort = editorField.substring(0, editorField.length - 3);
					// Affiche le statut de l\'upload
					function uploadStatus(color) {
						$("#" + editorField).val("").css("border-color", color);
						$("#" + editorFieldShort + "l").css("color", color);
						$("#" + editorFieldShort + "action").css({
							backgroundColor: color,
							borderColor: color
						});
					}
					// Upload d\'image
					var file = this.files[0];
					if(file !== undefined && file.type.substring(0, 5) === "image") {
						var formData = new FormData();
						formData.append("file", file);
						$.ajax({
							type: "POST",
							url: "' . helper::baseUrl() . 'upload",
							data: formData,
							dataType: "json",
							cache: false,
							contentType: false,
							processData: false,
							success: function(data) {
								if(data.error) {
									uploadStatus("#E74C3C");
								}
								else {
									uploadStatus("#1ABC9C");
									$("#" + editorField).val(data.link);
								}
							},
							error: function() {
								uploadStatus("#E74C3C");
							}
						});
					}
					else {
						uploadStatus("#E74C3C");
					}
				});
			');
		}
		return $scripts;
	}

	############################################################
	# MODULES
	
	/** Création d'une page */
	public function create()
	{
		// Titre de la nouvelle page
		$title = helper::translate('Nouvelle page');
		// Incrémente la clef de la page pour éviter les doublons
		$key = helper::increment(helper::filter($title, helper::URL), $this->getData('pages'));
		// Crée la page
		$this->setData([
			'pages',
			$key,
			[
				// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
				'blank' => false,
				'content' => '<p>' . helper::translate('Contenu de la page.') . '</p>',
				'description' => '',
				'hideTitle' => $this->getPost('hideTitle', helper::BOOLEAN),
				'metaTitle' => '',
				'module' => '',
				'parent' => '',
				'position' => 0,
				'title' => $title
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Notification de création
		$this->setNotification('Nouvelle page créée avec succès !');
		// Redirection vers la page
		helper::redirect($key);
	}

	/** Édition de page (faux module système) */
	public function edit()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0)])) {
			return false;
		}
		// Traitement du formulaire
		elseif($this->getPost('submit')) {
			// Modifie la clef de la page si le titre a été modifié
			$key = $this->getPost('title') ? $this->getPost('title', helper::URL_STRICT) : $this->getUrl(0);
			// Sauvegarde le module de la page
			$module = $this->getData(['pages', $this->getUrl(0), 'module']);
			// Si la clef à changée
			if($key !== $this->getUrl(0)) {
				// Incrémente la nouvelle clef de la page pour éviter les doublons
				$key = helper::increment($key, $this->getData('pages'));
				$key = helper::increment($key, self::$system); // Evite à une page d'avoir la même clef qu'un module système
				// Supprime l'ancienne page
				$this->removeData(['pages', $this->getUrl(0)]);
				// Crée les nouvelles données du module de la page (avec la nouvelle clef) en copiant les anciennes
				$this->setData([$key, $this->getData($this->getUrl(0))]);
				// Supprime les données du module de l'ancienne page
				$this->removeData($this->getUrl(0));
				// Si la page est la page d'accueil, modification la clef dans la configuration du site
				if($this->getData(['config', 'index']) === $this->getUrl(0)) {
					$this->setData(['config', 'index', $key]);
				}
			}
			// Check si il faut supprimer l'ensemble du cache
			// - si la position de la page a changée
			// - ou si le parent de la page a changé
			// - ou si le nom de la page a changé
			$position = $this->getPost('position', helper::INT);
			$parent = $this->getPost('parent', helper::STRING);
			$title = $this->getPost('title', helper::STRING);
			if(
				$position !== $this->getData(['pages', $this->getUrl(0), 'position'])
				OR $parent !== $this->getData(['pages', $this->getUrl(0), 'parent'])
				OR $title !== $this->getData(['pages', $this->getUrl(0), 'title'])
			) {
				$removeAllCache = true;
			}
			else {
				$removeAllCache = false;
			}
			// Actualise la positions des pages suivantes de même parent si la position ou le parent de la page à changée
			if(
				$position !== $this->getData(['pages', $this->getUrl(0), 'position'])
				OR $parent !== $this->getData(['pages', $this->getUrl(0), 'parent'])
			) {
				$hierarchy = $this->getHierarchy();
				// Supérieur à 1 pour ignorer les options ne pas afficher et au début
				// Sinon incrémente de +1 si la nouvelle position est supérieure à la position actuelle afin de prendre en compte la page courante qui n'appraît pas dans la liste
				if($position > 1 AND $position >= $this->getData(['pages', $this->getUrl(0), 'position'])) {
					$position++;
				}
				// Modifie les positions des pages dans parents
				if(empty($parent)) {
					foreach(array_keys($hierarchy) as $index => $parentKey) {
						// Commence à 1 et non 0
						$index++;
						// Incrémente de +1 la position des pages suivantes
						if($index >= $position AND $position !== 0) {
							$index++;
						}
						// Change les positions
						$this->setData(['pages', $parentKey, 'position', $index]);
					}
				}
				// Modifie les positions des pages avec le même parent
				elseif(!empty($hierarchy[$parent])) {
					foreach($hierarchy[$parent] as $index => $childKey) {
						// Commence à 1 et non 0
						$index++;
						// Incrémente de +1 la position des pages suivantes
						if($index >= $position) {
							$index++;
						}
						// Change les positions
						$this->setData(['pages', $childKey, 'position', $index]);
					}
				}
			}
			// Modifie la page ou en crée une nouvelle si la clef à changée
			$this->setData([
				'pages',
				$key,
				[
					// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
					'blank' => $this->getPost('blank', helper::BOOLEAN),
					'content' => $this->getPost('content'),
					'description' => $this->getPost('description', helper::STRING),
					'hideTitle' => $this->getPost('hideTitle', helper::BOOLEAN),
					'metaTitle' => $this->getPost('metaTitle', helper::STRING),
					'module' => $module,
					'parent' => $parent,
					'position' => $position,
					'title' => $title
				]
			]);
			// Supprime l'ancienne page si la clef à changée
			if($key !== $this->getUrl(0)) {
				$this->removeData(['pages', $this->getUrl(0)]);
			}
			// Enregistre les données
			$this->saveData($removeAllCache);
			// Notification de modification
			$this->setNotification('Page modifiée avec succès !');
			// Redirige vers la nouvelle page si la clef à changée ou sinon vers l'ancienne
			helper::redirect($key);
		}
		// Liste des pages sans parent
		$pagesNoParent = ['' => 'Aucune'];
		$selected = '';
		$hierarchy = $this->getHierarchy();
		foreach($hierarchy as $parentKey => $childrenKeys) {
			// Sélectionne le parent de la page courante
			if($parentKey === $this->getData(['pages', $this->getUrl(0), 'parent'])) {
				$selected = $parentKey;
			}
			// Ajoute la page à la liste des pages parentes si elle ne correspond pas à la page courante
			if($parentKey !== $this->getUrl(0)) {
				$pagesNoParent[$parentKey] = $this->getData(['pages', $parentKey, 'title']);
			}
		}
		// Template de la page
		self::$title = $this->getData(['pages', $this->getUrl(0), 'title']);
		self::$content =
			template::openForm().
			template::tabs([
				'Options principaux' =>
					template::openRow().
					template::text('title', [
						'label' => 'Titre de la page',
						'value' => $this->getData(['pages', $this->getUrl(0), 'title']),
						'required' => true
					]).
					template::newRow().
					template::select('parent', $pagesNoParent, [
						'label' => 'Page parente',
						'selected' => $selected,
						'col' => 6,
						'classWrapper' => (empty($hierarchy[$this->getUrl(0)]) ?: 'hide')
					]).
					template::select('position', [], [
						'label' => 'Position dans le menu',
						'col' => (empty($hierarchy[$this->getUrl(0)]) ? 6 : 12)
					]).
					template::script('
						// Affiche les bonnes pages dans le select des positions en fonction de la page parente
						var hierarchy = ' . json_encode($this->getHierarchy()) . ';
						var pages = ' . json_encode($this->getData(['pages'])) . ';
						$("#parent").on("change", function() {
							var positionDOM = $("#position");
							var positionLabelDOM = $("label[form=position]");
							positionDOM.empty().append(
								$("<option>").val(0).text("' . helper::translate('Ne pas afficher') . '"),
								$("<option>").val(1).text("' . helper::translate('Au début') . '")
							);
							var parentSelected = $(this).find("option:selected").val();
							var positionSelected = 0;
							var positionPrevious = 1;
							// Aucune page parente selectionnée
							if(parentSelected === "") {
								// Liste des pages sans parents
								for(var key in hierarchy) {
									// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
									if(key === "' . $this->getUrl(0) . '") {
										positionSelected = positionPrevious;
									}
									// Sinon ajoute la page à la liste
									else {
										// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
										positionPrevious++;
										// Ajout à la liste
										positionDOM.append(
											$("<option>").val(positionPrevious).text("' . helper::translate('Après') . ' \"" + pages[key].title + "\"")
										);
									}
								}
							}
							// Un page parente est selectionnée
							else {
								// Liste des pages enfants de la page parente
								for(var i = 0; i < hierarchy[parentSelected].length; i++) {
									// Pour page courante sélectionne la page précédente (pas de - 1 à positionSelected à cause des options par défaut)
									if(hierarchy[parentSelected][i] === "' . $this->getUrl(0) . '") {
										positionSelected = positionPrevious;
									}
									// Sinon ajoute la page à la liste
									else {
										// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page courante
										positionPrevious++;
										// Ajout à la liste
										positionDOM.append(
											$("<option>").val(positionPrevious).text("' . helper::translate('Après') . ' \"" + pages[hierarchy[parentSelected][i]].title + "\"")
										);
									}
								}
							}
							// Sélectionne la bonne position
							positionDOM.find("option[value=" + positionSelected + "]").prop("selected", true);
						}).trigger("change");
					').
					template::newRow().
					template::textarea('content', [
						'value' => $this->getData(['pages', $this->getUrl(0), 'content']),
						'editor' => true
					]).
					template::newRow().
					template::hidden('key', [
						'value' => $this->getUrl(0)
					]).
					template::hidden('oldModule', [
						'value' => $this->getData(['pages', $this->getUrl(0), 'module'])
					]).
					template::select('module', helper::listModules('Aucun module'), [
						'label' => 'Inclure le module',
						'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
						'selected' => $this->getData(['pages', $this->getUrl(0), 'module']),
						'col' => 11
					]).
					template::button('admin', [
						'value' => template::ico('gear'),
						'href' => helper::baseUrl() . 'module/' . $this->getUrl(0),
						'disabled' => $this->getData(['pages', $this->getUrl(0), 'module']) ? '' : 'disabled',
						'col' => 1
					]).
					template::script('
							// Enregistre le module de la page en AJAX
							$("#module").on("change", function() {
								var newModule = $("#module").val();
								var admin = $("#admin");
								var ok = true;
								if($("#oldModule").val() != "") {
									ok = confirm("' . helper::translate('Si vous confirmez, les données du module précédent seront supprimées !') . '");
								}
								if(ok) {
									$.ajax({
										type: "POST",
										url: "' . helper::baseUrl() . 'save/" + $("#key").val(),
										data: {module: newModule},
										success: function() {
											$("#oldModule").val(newModule);
											if(newModule == "") {
												admin.addClass("disabled");
											}
											else {
												admin.removeClass("disabled");
												admin.attr("target", "_blank")
											}
										},
										error: function() {
											alert("' . helper::translate('Impossible d\"enregistrer le module !') . '");
											admin.addClass("disabled");
										}
									});
								}
							});
						').
					template::closeRow(),
				'Options avancés' =>
					template::openRow().
					template::text('metaTitle', [
						'label' => 'Méta titre de la page',
						'help' => 'Si le champ est vide, la description du site est utilisée.',
						'value' => $this->getData(['pages', $this->getUrl(0), 'metaTitle'])
					]).
					template::newRow().
					template::textarea('description', [
						'label' => 'Méta description de la page',
						'help' => 'Si le champ est vide, la description du site est utilisée.',
						'value' => $this->getData(['pages', $this->getUrl(0), 'description'])
					]).
					template::newRow().
					template::checkbox('hideTitle', true, 'Ne pas afficher le titre en mode public', [
						'checked' => $this->getData(['pages', $this->getUrl(0), 'hideTitle'])
					]).
					template::newRow().
					template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet en mode public', [
						'checked' => $this->getData(['pages', $this->getUrl(0), 'blank'])
					]).
					template::closeRow()
			]).
			template::openRow().
			template::button('delete', [
				'value' => 'Supprimer',
				'href' => helper::baseUrl() . 'delete/' . $this->getUrl(0),
				'onclick' => 'return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir supprimer cette page ?') . '\');',
				'col' => 2,
				'offset' => 8
			]).
			template::submit('submit', [
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Suppression de page et de fichier */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0)]) AND !is_file('data/upload/' . $this->getUrl(0))) {
			return false;
		}
		// Pour les pages
		elseif($this->getData(['pages', $this->getUrl(0)])) {
			// La page est utilisée comme page d'accueil et ne peut être supprimée
			if($this->getUrl(0) === $this->getData(['config', 'index'])) {
				$this->setNotification('Impossible de supprimer la page d\'accueil !', true);
			}
			// Impossible de supprimer une page contenant des enfants
			elseif(!empty($this->getHierarchy()[$this->getUrl(0)])) {
				$this->setNotification('Impossible de supprimer une page contenant des enfants !', true);
			}
			// Supprime la page
			elseif($this->getData(['pages', $this->getUrl(0)])) {
				// Supprime la page et les données du module rattachées à la page
				$this->removeData(['pages', $this->getUrl(0)]);
				$this->removeData($this->getUrl(0));
				// Enregistre les données
				$this->saveData();
				// Notification de suppression
				$this->setNotification('Page supprimée avec succès !');
			}
			// Redirige vers la page d'accueil du site
			helper::redirect($this->getData(['config', 'index']));
		}
		// Pour les fichiers
		else {
			// Tente de supprimer le fichier
			if(@unlink('data/upload/' . $this->getUrl(0))) {
				// Notification de suppression
				$this->setNotification('Fichier supprimé avec succès !');
			}
			else {
				// Notification de suppression
				$this->setNotification('Impossible de supprimer le fichier demandé !', true);
			}
			// Redirige vers le gestionnaire de fichiers
			helper::redirect('manager');
		}
	}

	/** Enregistrement du module en AJAX */
	public function save()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0)])) {
			return false;
		}
		// Supprime les données du module de la page si le module à changé
		if($this->getPost('module') !== $this->getData(['pages', $this->getUrl(0), 'module'])) {
			$this->removeData($this->getUrl(0));
		}
		// Modifie le module de la page
		$this->setData([
			'pages',
			$this->getUrl(0),
			[
				// Si cette partie est modifiée il faut modifier : la création, l'édition, et l'enregistrement ajax de la page
				'blank' => $this->getData(['pages', $this->getUrl(0), 'blank']),
				'content' => $this->getData(['pages', $this->getUrl(0), 'content']),
				'description' => $this->getData(['pages', $this->getUrl(0), 'description']),
				'hideTitle' => $this->getData(['pages', $this->getUrl(0), 'hideTitle']),
				'metaTitle' => $this->getData(['pages', $this->getUrl(0), 'metaTitle']),
				'module' => $this->getPost('module', helper::STRING),
				'parent' => $this->getData(['pages', $this->getUrl(0), 'parent']),
				'position' => $this->getData(['pages', $this->getUrl(0), 'position']),
				'title' => $this->getData(['pages', $this->getUrl(0), 'title'])
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Utilise le layout JSON
		self::$layout = 'JSON';
		self::$content = true;
	}

	/** Configuration du module d'une page */
	public function module()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0), 'module'])) {
			return false;
		}
		// Contenu de la page
		$module = $this->getData(['pages', $this->getUrl(0), 'module']) . 'Adm';
		$module = new $module;
		$method = in_array($this->getUrl(1), $module::$views) ? $this->getUrl(1) : 'index';
		$module->$method(); // Retourne la variable self::content
		self::$title = $this->getData(['pages', $this->getUrl(0), 'title']);
	}

	/** Redirection vers le bon mode (édition ou public) */
	public function mode()
	{
		// Switch de mode
		$this->setMode(!$this->getMode());
		// Redirection (utilisation de 0 pour détecter un module système car $this->getUrl() détecte déjà le module système "mode" en 0 et le supprime)
		helper::redirect($this->getUrl(0));
	}

	/** Gestionnaire de fichiers */
	public function manager()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			$this->upload(['png', 'gif', 'jpg', 'jpeg', 'txt', 'pdf', 'zip', 'rar', '7z', 'css', 'html', 'xml']);
		}
		// Met en forme les fichiers pour les afficher dans un tableau
		$filesTable = [];
		foreach(helper::listUploads() as $path => $file) {
			$filesTable[] = [
				$file,
				template::button('preview[]', [
					'value' => template::ico('eye'),
					'href' => $path,
					'target' => '_blank'
				]),
				template::button('delete[]', [
					'value' => template::ico('cancel'),
					'href' => helper::baseUrl() . 'delete/' . $file,
					'onclick' => 'return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir supprimer ce fichier ?') . '\');'
				])
			];
		}
		if($filesTable) {
			self::$content =
				template::openRow() .
				template::table([10, 1, 1], $filesTable) .
				template::closeRow();
		}
		// Contenu de la page
		self::$title = helper::translate('Gestionnaire de fichiers');
		self::$content =
			template::title('Envoyer un fichier').
			template::openForm('form', [
				'enctype' => 'multipart/form-data'
			]).
			template::openRow().
			template::file('file', [
				'label' => 'Parcourir mes fichiers',
				'help' => 'Envoyez vos fichier sur votre site (formats autorisés : png, gif, jpg, jpeg, txt, pdf, zip, rar, 7z, css, html, xml).',
				'col' => '10'
			]).
			template::submit('submit', [
				'value' => 'Envoyer',
				'col' => '2'
			]).
			template::closeRow().
			template::closeForm().
			template::title('Liste des fichiers').
			(self::$content ? self::$content : template::subTitle('Aucun fichier...'));
	}

	/**
	 * Upload d'un fichier en POST et en AJAX
	 * A importer entre un if($this->getPost()) en POST ; A appeler depuis un fichier JS en AJAX
	 * @param array $extensions Extensions autorisées, par défaut seule les fichiers images sont autorisés
	 * @return bool
	 */
	public function upload(array $extensions = ['png', 'gif', 'jpg', 'jpeg'])
	{
		// Erreur 404
		if(!isset($_FILES['file'])) {
			return false;
		}
		$target = 'data/upload/' . helper::filter(basename($_FILES['file']['name']), helper::URL);
		// Check la taille du fichier (limité à environs 100 mo)
		if($_FILES['file']['size'] > 100000000) {
			$data['error'] = 'Fichier trop volumineux !';
		}
		// Check le type de fichier
		elseif(!in_array(strtolower(pathinfo($target, PATHINFO_EXTENSION)), $extensions)) {
			$data['error'] = 'Format du fichier non autorisé !';
		}
		// Check les erreurs au chargement du fichier
		elseif($_FILES['file']['error']) {
			$data['error'] = 'Erreur au chargement du fichier !';
		}
		// Check qu'il n'existe aucune notice
		if(empty($data['error'])) {
			// Tente de déplacer le fichier dans le bon dossier
			if(@move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
				$data['success'] = 'Fichier envoyé avec succès !';
				$data['link'] = helper::baseUrl(false) . $target;
			}
			else {
				$data['error'] = 'Impossible de communiquer avec le serveur !';
			}
		}
		// Pour une requête en AJAX
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
			// En cas de succès retourne les données
			if(isset($data['success'])) {
				self::$layout = 'JSON';
				self::$content = $data;
			}
			// Sinon statut de requête incorrecte
			else {
				http_response_code(400);
			}
		}
		// Pour une requête en POST
		else {
			// En cas de succès
			if(isset($data['success'])) {
				// Notification d'upload
				$this->setNotification($data['success']);
				// Redirige vers la page courante
				helper::redirect($this->getUrl());
			}
			// Sinon crée une notice en cas d'erreur
			else {
				template::$notices['file'] = $data['error'];
			}
		}
	}

	/** Configuration */
	public function config()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Double vérification pour le mot de passe si il a changé
			if($this->getPost('password')) {
				// Change le mot de passe si la confirmation correspond au mot de passe
				if($this->getPost('password') === $this->getPost('confirm')) {
					$password = $this->getPost('password', helper::PASSWORD);
				}
				// Ne change pas le mot de passe et crée une notice si la confirmation ne correspond pas au mot de passe
				else {
					$password = $this->getData(['config', 'password']);
					template::$notices['confirm'] = 'La confirmation du mot de passe ne correspond pas au mot de passe';
				}
			}
			// Sinon conserve le mot de passe d'origine
			else {
				$password = $this->getData(['config', 'password']);
			}
			// Modifie la configuration
			$this->setData([
				'config',
				[
					'title' => $this->getPost('title', helper::STRING),
					'description' => $this->getPost('description', helper::STRING),
					'password' => $password,
					'index' => $this->getPost('index', helper::STRING),
					'language' => $this->getPost('language', helper::STRING),
					'analytics' => $this->getPost('analytics', helper::STRING),
					'footer' => $this->getPost('footer', helper::STRING)
				]
			]);
			// Modifie les couleurs
			$this->setData([
				'colors',
				[
					'background' => $this->getPost('colorBackground', helper::STRING),
					'element' => $this->getPost('colorElement', helper::STRING),
					'header' => $this->getPost('colorHeader', helper::STRING),
					'menu' => $this->getPost('colorMenu', helper::STRING)
				]
			]);
			// Modifie le theme
			$this->setData([
				'theme',
				[
					'backgroundImage' => $this->getPost('themeBackgroundImage', helper::URL),
					'backgroundImageRepeat' => $this->getPost('themeBackgroundImageRepeat', helper::STRING),
					'backgroundImagePosition' => $this->getPost('themeBackgroundImagePosition', helper::STRING),
					'backgroundImageAttachment' => $this->getPost('themeBackgroundImageAttachment', helper::STRING),
					'headerHeight' => $this->getPost('themeHeaderHeight', helper::STRING),
					'headerImage' => $this->getPost('themeHeaderImage', helper::URL),
					'headerPosition' => $this->getPost('themeHeaderPosition', helper::STRING),
					'headerTextAlign' => $this->getPost('themeHeaderTextAlign', helper::STRING),
					'menuHeight' => $this->getPost('themeMenuHeight', helper::STRING),
					'menuPosition' => $this->getPost('themeMenuPosition', helper::STRING),
					'menuTextAlign' => $this->getPost('themeMenuTextAlign', helper::STRING),
					'siteMargin' => $this->getPost('themeSiteMargin', helper::BOOLEAN),
					'siteRadius' => $this->getPost('themeSiteRadius', helper::BOOLEAN),
					'siteShadow' => $this->getPost('themeSiteShadow', helper::BOOLEAN),
					'siteWidth' => $this->getPost('themeSiteWidth', helper::STRING)
				]
			]);
			// Active/désactive l'URL rewriting
			if(!template::$notices) {
				// URL rewriting
				$htaccess = file_get_contents('.htaccess');
				$rewriteRule = explode('# URL rewriting', $htaccess);
				// Active l'URL rewriting
				if($this->getPost('rewrite', helper::BOOLEAN)) {
					if(empty($rewriteRule[1])) {
						file_put_contents('.htaccess',
							$htaccess . PHP_EOL .
							'RewriteEngine on' . PHP_EOL .
							'RewriteBase ' . helper::baseUrl(false, false) . PHP_EOL .
							'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL .
							'RewriteRule ^(.*)$ index.php?$1 [L]'
						);
					}
				}
				// Désactive l'URL rewriting
				else {
					if(!empty($rewriteRule[1])) {
						file_put_contents('.htaccess', $rewriteRule[0] . '# URL rewriting');
					}
				}
			}
			// Enregistre les données et supprime le cache
			$this->saveData(true);
			// Notification de modification
			$this->setNotification('Configuration enregistrée avec succès !');
			// Redirige vers l'URL courante
			helper::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$title = helper::translate('Configuration');
		self::$content =
			template::openForm().
			template::tabs([
				'Configuration générale' =>
					template::openRow().
					template::text('title', [
						'label' => 'Titre du site',
						'required' => 'required',
						'value' => $this->getData(['config', 'title'])
					]).
					template::newRow().
					template::textarea('description', [
						'label' => 'Description du site',
						'required' => 'required',
						'value' => $this->getData(['config', 'description'])
					]).
					template::newRow().
					template::password('password', [
						'label' => 'Nouveau mot de passe',
						'col' => 6
					]).
					template::password('confirm', [
						'label' => 'Confirmation du mot de passe',
						'col' => 6
					]).
					template::newRow().
					template::select('index', helper::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true), [
						'label' => 'Page d\'accueil',
						'required' => 'required',
						'selected' => $this->getData(['config', 'index'])
					]).
					template::newRow().
					template::select('language', helper::listLanguages('Ne pas traduire'), [
						'label' => 'Traduire le site',
						'selected' => $this->getData(['config', 'language'])
					]).
					template::closeRow(),
				'Configuration avancée' =>
					template::openRow().
					template::textarea('footer', [
						'label' => 'Texte du bas de page',
						'value' => $this->getData(['config', 'footer'])
					]).
					template::newRow().
					template::text('analytics', [
						'label' => 'Google Analytics',
						'value' => $this->getData(['config', 'analytics']),
						'help' => 'Saisissez l\'ID de suivi de votre propriété Google Analytics.',
						'placeholder' => 'UA-XXXXXXXX-X',
					]).
					template::newRow().
					template::checkbox('rewrite', true, 'Activer la réécriture d\'URL', [
						'checked' => helper::rewriteCheck(),
						'help' => 'Supprime le point d\'interrogation de l\'URL (si vous n\'arrivez pas à cocher la case, vérifiez que le module d\'URL rewriting de votre serveur est bien activé).',
						'disabled' => helper::modRewriteCheck() ? '' : 'disabled' // Check que l'URL rewriting fonctionne sur le serveur
					]).
					template::newRow().
					template::text('version', [
						'label' => 'Version de ZwiiCMS',
						'value' => self::$version,
						'disabled' => 'disabled'
					]).
					template::closeRow(),
				'Personnalisation du thème' =>
					template::subTitle('Fond de la page').
					template::openRow().
					template::colorPicker('colorBackground', [
						'label' => 'Couleur',
						'value' => $this->getData(['colors', 'background']),
						'col' => 6
					]).
					template::select('themeBackgroundImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
						'label' => 'Image',
						'help' => 'Seules les images png, gif, jpg ou jpeg du gestionnaire de fichiers sont acceptées.',
						'selected' => $this->getData(['theme', 'backgroundImage']),
						'col' => 6
					]).
					template::newRow().
					template::div([
						'id' => 'themeBackgroundImageOptions',
						'class' => 'hide',
						'text' =>
							template::select('themeBackgroundImageRepeat', [
								'themeBackgroundImageRepeatNo' => 'Ne pas répéter',
								'themeBackgroundImageRepeatX' => 'Sur l\'axe horizontal',
								'themeBackgroundImageRepeatY' => 'Sur l\'axe vertical',
								'themeBackgroundImageRepeatAll' => 'Sur les deux axes'
							], [
								'label' => 'Répétition',
								'selected' => $this->getData(['theme', 'backgroundImageRepeat']),
								'col' => 4
							]).
							template::select('themeBackgroundImagePosition', [
								'themeBackgroundImagePositionTopLeft' => 'En haut à gauche',
								'themeBackgroundImagePositionTopCenter' => 'En haut au centre',
								'themeBackgroundImagePositionTopRight' => 'En haut à droite',
								'themeBackgroundImagePositionCenterLeft' => 'Au milieu à gauche',
								'themeBackgroundImagePositionCenterCenter' => 'Au milieu au centre',
								'themeBackgroundImagePositionCenterRight' => 'Au milieu à droite',
								'themeBackgroundImagePositionBottomLeft' => 'En bas à gauche',
								'themeBackgroundImagePositionBottomCenter' => 'En bas au centre',
								'themeBackgroundImagePositionBottomRight' => 'En bas à droite',
							], [
								'label' => 'Alignement',
								'selected' => $this->getData(['theme', 'backgroundImagePosition']),
								'col' => 4
							]).
							template::select('themeBackgroundImageAttachment', [
								'themeBackgroundImageAttachmentScroll' => 'Normale',
								'themeBackgroundImageAttachmentFixed' => 'Fixe'
							], [
								'label' => 'Position',
								'selected' => $this->getData(['theme', 'backgroundImageAttachment']),
								'col' => 4
							])
					]).
					template::script('
						// Affiche/cache les options de l\'image du fond
						$("#themeBackgroundImage").on("change", function() {
							var themeBackgroundImageOptions = $("#themeBackgroundImageOptions");
							if($(this).val() !== "") {
								themeBackgroundImageOptions.slideDown();
							}
							else {
								themeBackgroundImageOptions.slideUp();
							}
						}).trigger("change");
					').
					template::closeRow().
					template::subTitle('Site').
					template::openRow().
					template::colorPicker('colorElement', [
						'label' => 'Couleur des éléments',
						'value' => $this->getData(['colors', 'element']),
						'col' => 6
					]).
					template::select('themeSiteWidth', [
						'themeSiteWidthSmall' => 'Petit',
						'themeSiteWidthMedium' => 'Moyen',
						'themeSiteWidthLarge' => 'Large'
					], [
						'label' => 'Largeur',
						'selected' => $this->getData(['theme', 'siteWidth']),
						'col' => 6
					]).
					template::newRow().
					template::checkbox('themeSiteRadius', true, 'Arrondir les coins du site', [
						'checked' => $this->getData(['theme', 'siteRadius'])
					]).
					template::newRow().
					template::checkbox('themeSiteShadow', true, 'Ajouter une ombre autour du site', [
						'checked' => $this->getData(['theme', 'siteShadow'])
					]).
					template::closeRow().
					template::subTitle('Bannière').
					template::openRow().
					template::colorPicker('colorHeader', [
						'label' => 'Couleur',
						'value' => $this->getData(['colors', 'header']),
						'col' => 6
					]).
					template::select('themeHeaderImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
						'label' => 'Remplacer le texte par une image',
						'help' => 'Seules les images png, gif, jpg ou jpeg du gestionnaire de fichiers sont acceptées.',
						'selected' => $this->getData(['theme', 'headerImage']),
						'col' => 6
					]).
					template::newRow().
					template::select('themeHeaderPosition', [
						'themeHeaderPositionHide' => 'Invisible',
						'themeHeaderPositionTop' => 'Dans le haut de la page',
						'themeHeaderPositionSite' => 'Dans le site'
					], [
						'label' => 'Emplacement',
						'selected' => $this->getData(['theme', 'headerPosition']),
						'col' => 4
					]).
					template::select('themeHeaderHeight', [
						'themeHeaderHeightSmall' => 'Petit',
						'themeHeaderHeightMedium' => 'Moyen',
						'themeHeaderHeightLarge' => 'Grand',
						'themeHeaderHeightAuto' => 'Automatique'
					], [
						'label' => 'Hauteur',
						'selected' => $this->getData(['theme', 'headerHeight']),
						'col' => 4
					]).
					template::select('themeHeaderTextAlign', [
						'themeHeaderTextAlignLeft' => 'Gauche',
						'themeHeaderTextAlignCenter' => 'Centre',
						'themeHeaderTextAlignRight' => 'Droite'
					], [
						'label' => 'Alignement du contenu',
						'selected' => $this->getData(['theme', 'headerTextAlign']),
						'col' => 4
					]).
					template::closeRow().
					template::subTitle('Menu').
					template::openRow().
					template::colorPicker('colorMenu', [
						'label' => 'Couleur',
						'value' => $this->getData(['colors', 'menu'])
					]).
					template::newRow().
					template::select('themeMenuPosition', [
						'themeMenuPositionTop' => 'Dans le haut de la page',
						'themeMenuPositionSite' => 'Dans le site'
					], [
						'label' => 'Emplacement',
						'selected' => $this->getData(['theme', 'menuPosition']),
						'col' => 4
					]).
					template::select('themeMenuHeight', [
						'themeMenuHeightSmall' => 'Petit',
						'themeMenuHeightMedium' => 'Moyen',
						'themeMenuHeightLarge' => 'Grand'
					], [
						'label' => 'Hauteur',
						'selected' => $this->getData(['theme', 'menuHeight']),
						'col' => 4
					]).
					template::select('themeMenuTextAlign', [
						'themeMenuTextAlignLeft' => 'Gauche',
						'themeMenuTextAlignCenter' => 'Centre',
						'themeMenuTextAlignRight' => 'Droite'
					], [
						'label' => 'Alignement du contenu',
						'selected' => $this->getData(['theme', 'menuTextAlign']),
						'col' => 4
					]).
					template::closeRow().
					template::subTitle('Autres').
					template::openRow().
					template::checkbox('themeSiteMargin', true, 'Aligne la bannière et le menu avec le contenu du site', [
						'help' => 'Ajoute une marge à la bannière et au menu si l\'un des deux éléments est placé dans le site.',
						'checked' => $this->getData(['theme', 'siteMargin'])
					]).
					template::closeRow()
			]).
			template::script('
				// Aperçu de la personnalisation en direct
				$(".tabContent[data-1=3]").on("change", function() {
					var tabContentDOM = $(this);
					var bodyDOM = $("body");
					// Supprime les anciennes classes
					bodyDOM.removeClass();
					// Ajoute les nouvelles classes
					// Pour les selects
					tabContentDOM.find("select").each(function() {
						var selectDOM = $(this);
						var option = selectDOM.find("option:selected").val();
						// Pour le select d\'ajout d\'image dans la bannière
						if(selectDOM.attr("id") === "themeHeaderImage") {
							var headerDOM = $("header");
							if(option === "") {
								bodyDOM.removeClass("themeHeaderImage");
							}
							else {
								bodyDOM.addClass("themeHeaderImage");
							}
							headerDOM.find("img").attr("src", "' . helper::baseUrl(false) . '" + option);
						}
						// Pour le select d\'ajout d\'image de fond
						else if(selectDOM.attr("id") === "themeBackgroundImage") {
							bodyDOM.css("background-image", "url(\'' . helper::baseUrl(false) . '" + option + "\')");
						}
						// Pour les autres
						else {
							if(option) {
								bodyDOM.addClass(option);
							}
						}
					});
					// Pour les inputs
					tabContentDOM.find("input").each(function() {
						var inputDOM = $(this);
						// Cas spécifique pour les checkbox
						if(inputDOM.is(":checkbox")) {
							if(inputDOM.is(":checked")) {
								bodyDOM.addClass(inputDOM.attr("name").replace("[]", ""));
							}
						}
						// Cas simple (ignore les colorPickers)
						else if(!inputDOM.hasClass(".jscolor")) {
							bodyDOM.addClass(inputDOM.val());
						}
					});
					// Pour les colorPickers
					var style = "";
					$(this).find(".jscolor").each(function() {
						var jscolorDOM = $(this);
						var rgb = hexToRgb(jscolorDOM.val());
						var color = rgb.r + "," + rgb.g + "," + rgb.b;
						var colorDark = (rgb.r - 20) + "," + (rgb.g - 20) + "," + (rgb.b - 20);
						var colorVeryDark = (rgb.r - 25) + "," + (rgb.g - 25) + "," + (rgb.b - 25);
						var textVariant = (rgb.r + rgb.g + rgb.b / 3) < 350 ? "#FFF" : "inherit";
						// Couleur du header
						if(jscolorDOM.attr("id") === "colorHeader") {
							style += "
								/* Couleur normale */
								header {
									background-color: rgb(" + color + ");
								}
								header h1 {
									color: " + textVariant + ";
								}
							";
						}
						// Couleurs du menu
						else if(jscolorDOM.attr("id") === "colorMenu") {
							style += "
								/* Couleur normale */
								.toggle,
								nav,
								nav ul {
									background-color: rgb(" + color + ");
								}
								.toggle span,
								nav a {
									color: " + textVariant + ";
								}
								/* Couleur foncée */
								.toggle:hover,
								nav a:hover {
									background-color: rgb(" + colorDark + ");
								}
								/* Couleur très foncée */
								.toggle:active,
								nav a:active,
								nav a.current {
									background-color: rgb(" + colorVeryDark + ");
								}
							";
						}
						// Couleurs des éléments
						else if(jscolorDOM.attr("id") === "colorElement") {
							style += "
								/* Couleur normale */
								input[type=\'submit\'],
								.button,
								.pagination a,
								input[type=\'checkbox\']:checked + label:before,
								input[type=\'radio\']:checked + label:before,
								.helpContent {
									background-color: rgb(" + color + ");
									color: " + textVariant + ";
								}
								h2,
								h4,
								h6,
								a,
								.tabTitle.current,
								.helpButton {
									color: rgb(" + color + ");
								}
								input[type=\'text\']:hover,
								input[type=\'password\']:hover,
								input[type=\'file\']:hover,
								select:hover,
								textarea:hover {
									border: 1px solid rgb(" + color + ");
								}
								/* Couleur foncée */
								input[type=\'submit\']:hover,
								.button:hover,
								.pagination a:hover,
								input[type=\'checkbox\']:not(:active):checked:hover + label:before,
								input[type=\'checkbox\']:active + label:before,
								input[type=\'radio\']:checked:hover + label:before,
								input[type=\'radio\']:not(:checked):active + label:before {
									background-color: rgb(" + colorDark + ");
								}
								.helpButton:hover {
									color: rgb(" + colorDark + ");
								}
								/* Couleur très foncée */
								input[type=\'submit\']:active,
								.button:active,
								.pagination a:active {
									background-color: rgb(" + colorVeryDark + ");
								}
							";
						}
						// Couleur du fond
						else if(jscolorDOM.attr("id") === "colorBackground") {
							style += "
								/* Couleur normale */
								body {
									background-color: rgb(" + color + ");
								}
							";
						}
						// Supprime le css déjà ajouté
						var headDOM = $("head");
						headDOM.find("style").remove();
						// Retourne le nouveau css
						$("<style>").text(style).appendTo(headDOM);
					});
				});
			').
			template::openRow().
			template::button('clean', [
				'value' => 'Vider le cache',
				'href' => helper::baseUrl() . 'clean',
				'col' => 3,
			]).
			template::button('export', [
				'value' => 'Exporter le contenu',
				'href' => helper::baseUrl() . 'export',
				'col' => 3
			]).
			template::submit('submit', [
				'col' => 2,
				'offset' => 4
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Suppression du cache */
	public function clean()
	{
		// Sauvegarde les données en supprimant le cache
		$this->saveData(true);
		// Notification de suppression
		$this->setNotification('Cache vidé avec succès !');
		// Redirige vers la page de configuration
		helper::redirect('config');
	}

	/** Exporte le fichier de données */
	public function export()
	{
		// Force le téléchargement du fichier data/data.json
		header('Content-disposition: attachment; filename=data.json');
		header('Content-type: application/json');
		self::$content = $this->getData();
		// Utilise le layout JSON
		self::$layout = 'JSON';
	}

	/** Connexion (faux module système) */
	public function login()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Crée un cookie (de durée infinie si la case est cochée) si le mot de passe est correct
			if($this->getPost('password', helper::PASSWORD) === $this->getData(['config', 'password'])) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setCookie($this->getPost('password'), $time);
			}
			// Notification d'échec si le mot de passe incorrect
			else {
				$this->setNotification('Mot de passe incorrect !', true);
			}
			// Redirection vers l'URL courante
			helper::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$title = helper::translate('Connexion');
		self::$content =
			template::openForm().
			template::openRow().
			template::password('password', [
				'required' => 'required',
				'col' => 4
			]).
			template::newRow().
			template::checkbox('time', true, 'Me connecter automatiquement à chaque visite').
			template::newRow().
			template::submit('submit', [
				'value' => 'Me connecter',
				'col' => 2
			]).
			template::closeRow().
			template::closeForm();
	}

	/** Déconnexion */
	public function logout()
	{
		// Supprime le cookie de connexion
		$this->removeCookie();
		// Redirige vers la page d'accueil du site
		helper::redirect('./', false);
	}

	/** PHPInfo */
	public function phpinfo()
	{
		self::$layout = 'BLANK';
		self::$content = phpinfo();
	}
}

class helper
{
	/** Statut de l'URL rewriting (pour éviter de lire le contenu du fichier .htaccess à chaque self::baseUrl()) */
	private static $rewriteStatus = null;

	/** Filtres personnalisés */
	const PASSWORD = 'FILTER_SANITIZE_PASSWORD';
	const BOOLEAN = 'FILTER_SANITIZE_BOOLEAN';
	const URL = 'FILTER_SANITIZE_URL'; // N'utilise pas FILTER_SANITIZE_URL de PHP qui est trop efficace
	const URL_STRICT = 'FILTER_SANITIZE_URL_STRICT'; // Supprime les "&", "?" et "/" (utile pour filtrer une partie d'URL, ne pas utiliser pour filtrer une URL complète)
	const STRING = FILTER_SANITIZE_STRING;
	const EMAIL = FILTER_SANITIZE_EMAIL;
	const FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const INT = FILTER_SANITIZE_NUMBER_INT;

	/**
	 * Retourne l'URL de base du site
	 * @param  bool   $queryString Affiche ou non le point d'interrogation
	 * @param  bool   $host        Affiche ou non l'host
	 * @return string
	 */
	public static function baseUrl($queryString = true, $host = true) {
		$currentPath = $_SERVER['PHP_SELF'];
		$pathInfo = pathinfo($currentPath);
		$hostName = $_SERVER['HTTP_HOST'];
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
		return ($host ? $protocol . $hostName  : '') . rtrim($pathInfo['dirname'], ' \/') . '/' . (($queryString AND !helper::rewriteCheck()) ? '?' : '');
	}

	/**
	 * Traduit les textes
	 * @param  string $text Texte à traduire
	 * @return string
	 */
	public static function translate($text) {
		// Traduit le texte en cherchant dans le tableau de langue (ajout d'un (string) au cas ou un $key est vide)
		if(array_key_exists((string) $text, core::$language)) {
			$text = core::$language[$text];
		}
		return $text;
	}

	/**
	 * Filtre et incrémente une chaîne en fonction d'un tableau de données
	 * @param  string     $text   Chaîne à filtrer
	 * @param  int|string $filter Type de filtre à appliquer
	 * @return string
	 */
	public static function filter($text, $filter)
	{
		$search = '€,$,£,á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ,¨,\',",’,;';
		$replace = 'e,s,l,a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-,-,-,-,-,-';
		switch($filter) {
			case self::PASSWORD:
				$text = sha1($text);
				break;
			case self::BOOLEAN:
				$text = (bool)$text;
				break;
			case self::URL:
				$text = str_replace(explode(',', $search), explode(',', $replace), mb_strtolower($text, 'UTF-8'));
				break;
			case self::URL_STRICT:
				$text = str_replace(explode(',', $search . ',?,&,/'), explode(',', $replace . ',-,-,-'), mb_strtolower($text, 'UTF-8'));
				break;
			case self::INT:
				$text = filter_var($text, $filter);
				$text = (int)$text;
				break;
			case self::FLOAT:
				$text = filter_var($text, $filter);
				$text = (float)$text;
				break;
			default:
				$text = filter_var($text, $filter);
		}
		return get_magic_quotes_gpc() ? stripslashes($text) : $text;
	}

	/**
	 * Convertit un code hexadecimal en rgb
	 * @param  mixed  $hex Code hexadecimal à convertir
	 * @return string
	 */
	public static function hexToRgb($hex)
	{
		$hex = $hex ? $hex : 'FFFFFF'; // Compatibilité anciennes versions
    	list($r, $g, $b) = str_split($hex, 2);
		return array(hexdec($r), hexdec($g), hexdec($b));
	}

	/**
	 * Minimise du js
	 * @param string  $js Js à minimiser
	 * @return string
	 */
	public static function minifyJs($js) {
		// Supprime les commentaires
		$js =  preg_replace('/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|\s*(?<![\:\=])\/\/.*)/', '', $js);
		// Supprime les tabulations, espaces, nouvelles lignes, etc...
		$js = str_replace(["\r\n", "\r", "\t", "\n", '  ', '    ', '     '], '', $js);
		$js = preg_replace(['(( )+\))', '(\)( )+)'], ')', $js);
		// Retourne le js minifié
		return $js;
	}

	/**
	 * Minimise du css
	 * @param string  $css Css à minimiser
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
	 * Incrémente une clé en fonction des clés ou des valeurs d'un tableau
	 * @param  mixed  $key   Clé à incrémenter
	 * @param  array  $array Tableau à vérifier
	 * @return string
	 */
	public static function increment($key, $array)
	{
		// Pas besoin d'incrémenter Si la clef n'existe pas
		if(empty($array)) {
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
	 * Retourne les valeurs d'une colonne du tableau de données
	 * @param  array   $array     Tableau cible
	 * @param  string  $columnKey Clé à extraire
	 * @param  string  $sort      Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, ou vide)
	 * @param  bool    $keep      Conserve le format clés => valeurs
	 * @return array
	 */
	public static function arrayCollumn($array, $columnKey, $sort = '', $keep = false)
	{
		$row = [];
		if(!empty($array)) {
			foreach($array as $key => $value) {
				if($value[$columnKey]) {
					$row[$key] = $value[$columnKey];
				}
			}
			switch($sort) {
				case 'SORT_ASC':
					asort($row);
					break;
				case 'SORT_DESC':
					arsort($row);
					break;
			}
			$row = $keep ? $row : array_keys($row);
		}
		return $row;
	}

	/**
	 * Crée un système de pagination (retourne un tableau contenant les informations sur la pagination (first, last, pages))
	 * @param  array  $array Tableau de donnée à utiliser
	 * @param  string $url   URL à utiliser, la dernière partie doit correspondre au numéro de page, par défaut utiliser $this->getUrl()
	 * @return array
	 */
	public static function pagination($array, $url)
	{
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
		$currentPage = is_numeric($urlPagination) ? (int) $urlPagination : 1;
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
			$pages .= '<a href="' . helper::baseUrl() . $urlCurrent . '/' . $i . '"' . $disabled . '>' . $i . '</a>';
		}
		// Retourne un tableau contenant les informations sur la pagination
		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'pages' => template::div([
				'text' => $pages,
				'class' => 'pagination'
			])
		];
	}

	/**
	 * Crée une liste des modules (format : fichier => nom du module)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listModules($default = false)
	{
		$modules = [];
		if($default) {
			$modules[''] = self::translate($default);
		}
		$it = new DirectoryIterator('module/');
		foreach($it as $dir) {
			if($dir->isDir() AND $dir->getBasename() !== '.' AND $dir->getBasename() !== '..') {
				$module = $dir->getBasename() . 'Adm';
				$module = new $module;
				$modules[$dir->getBasename()] = $module::$name;
			}
		}
		return $modules;
	}

	/**
	 * Crée une liste des langues (format : fichier et extension => fichier)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listLanguages($default = false)
	{
		$languages = [];
		if($default) {
			$languages[''] = self::translate($default);
		}
		$it = new DirectoryIterator('core/lang/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() === 'json') {
				$languages[$file->getBasename()] = $file->getBasename('.json');
			}
		}
		return $languages;
	}

	/**
	 * Crée une liste des fichiers uploadés (format : chemin du fichier => fichier)
	 * @param  mixed $default    Valeur par défaut
	 * @param  mixed $extensions N'autorise que certains extensions
	 * @return array
	 */
	public static function listUploads($default = false, array $extensions = [])
	{
		$uploads = [];
		if($default) {
			$uploads[''] = self::translate($default);
		}
		$it = new DirectoryIterator('data/upload/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getBasename() !== '.gitkeep' AND (empty($extensions) OR in_array(strtolower($file->getExtension()), $extensions))) {
				$uploads['data/upload/' . $file->getBasename()] = $file->getBasename();
			}
		}
		return $uploads;
	}

	/**
	 * Redirige vers une page du site ou une page externe et sauvegarde les données du formulaire si il existe des notices
	 * @param string  $url     Url de destination
	 * @param bool    $baseUrl Ajoute ou non l'URL de base à la redirection
	 */
	public static function redirect($url, $baseUrl = true)
	{
		// Sauvegarde des données en méthode POST si une notice existe
		if(template::$notices) {
			template::$before = $_POST;
		}
		// Sinon redirection
		else {
			http_response_code(301);
			header('Location: ' . ($baseUrl ? self::baseUrl() : false) . $url);
			exit();
		}
	}

	/**
	 * Envoi un mail
	 * @param  string $from    Expéditeur
	 * @param  string $to      Destinataire
	 * @param  string $subject Sujet
	 * @param  string $message Message
	 * @return bool
	 */
	public static function mail($from, $to, $subject, $message)
	{
		// Retour chariot différent pour les adresses Microsoft
		$n = preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|outlook).[a-z]{2,4}$#", $to) ? "\n" : "\r\n";
		// Définition du séparateur
		$boundary = '-----=' . md5(rand());
		// Création du template
		$html = '<html><head></head><body>' . $message . '</body></html>';
		$txt = strip_tags($html);
		// Définition du header
		$header = 'Reply-To: ' . $to . $n;
		if($from) {
			$header .= 'From: ' . $from . $n;
		}
		else {
			$header .= 'From: ' . helper::translate('Votre site ZwiiCMS') . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>' . $n;
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
	 * Vérifie l'état de l'URL rewriting
	 * @return bool
	 */
	public static function rewriteCheck()
	{
		if(self::$rewriteStatus === null) {
			// Ouvre et scinde le fichier .htaccess
			$htaccess = explode('# URL rewriting', file_get_contents('.htaccess'));
			// Retourne un boolean en fonction du contenu de la partie réservée à l'URL rewriting
			self::$rewriteStatus = !empty($htaccess[1]);
		}
		return self::$rewriteStatus;
	}

	/**
	 * Vérifie que le module d'URL rewriting est activé sur le serveur
	 * @return bool
	 */
	public static function modRewriteCheck()
	{
		// Check si l'URL rewriting est activée
		if(function_exists('apache_get_modules')) {
			if(in_array('mod_rewrite', apache_get_modules())) {
				return true;
			}
		}
		// Check si l'URL rewriting est activée (si la fonction apache_get_modules() n'existe pas)
		if(function_exists('phpinfo') AND strpos(ini_get('disable_functions'), 'phpinfo') === false) {
			ob_start();
			phpinfo(8);
			$phpinfo = ob_get_clean();
			if(strpos($phpinfo, 'mod_rewrite') !== false) {
				return true;
			}
		}
		// Check si l'URL rewriting est activée (si PHP est installé en FastCGI)
		$htaccess =
			'RewriteEngine on' . PHP_EOL .
			'RewriteBase ' . helper::baseUrl(false, false) . 'core/tmp/' . PHP_EOL .
			'RewriteRule test check';
		if(
			!file_exists('core/tmp/.htaccess')
			OR !file_exists('core/tmp/check')
			OR md5_file('core/tmp/.htaccess') !== md5($htaccess)
		) {
			file_put_contents('core/tmp/.htaccess', $htaccess);
			file_put_contents('core/tmp/check', 'ok');
		}
		if(get_headers(helper::baseUrl(false) . 'core/tmp/test')[0] === 'HTTP/1.1 200 OK') {
			return true;
		}
		// l'URL rewriting n'est pas prise en charge
		return false;
	}
}

class template
{
	/** @var array Notices rattachées à des champs ($input => $notice) */
	public static $notices = [];

	/** @var array Valeur des champs avant validation et erreur dans le formulaire */
	public static $before = [];

	/**
	 * Retourne une notice pour les champs obligatoires
	 * @param  string|int $key
	 */
	public static function getRequired($key)
	{
		if(!empty($_SESSION['REQUIRED']) AND array_key_exists($key . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			self::$notices[$key] = 'Ce champ est requis';
		}
	}

	/**
	 * Enregistre un champ comme obligatoire
	 * @param string $id         Id du champ
	 * @param array  $attributes Transmet l'attribut "required" à la méthode
	 */
	private static function setRequired($id, $attributes)
	{
		// Supprime l'id du champs si il existe déjà (au cas ou un champ devient non obligatoire)
		if(!empty($_SESSION['REQUIRED']) AND array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			unset($_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])]);
		}
		// Enregistre l'id du champ comme obligatoire
		if(!empty($attributes['required']) AND (empty($_SESSION['REQUIRED']) OR !array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED']))) {
			$_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])] = true;
		}
	}

	/**
	 * Retourne et met en forme une notice depuis une $id
	 * @param  string $id Id du champ
	 * @return string
	 */
	private static function getNotice($id) {
		return '<div class="notice">' . helper::translate(self::$notices[$id]) . '</div>';
	}

	/**
	 * Valeur du champ avant validation et erreur dans le formulaire
	 * @param  string $nameId Nom ou id du champ
	 * @return mixed
	 */
	private static function getBefore($nameId) {
		return array_key_exists($nameId, self::$before) ? self::$before[$nameId] : null;
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param  array $array   Liste des attributs ($key => $value)
	 * @param  array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	private static function sprintAttributes(array $array = [], array $exclude = [])
	{
		// Required est exclu pour privilégier le système de champs requis du système
		$exclude = array_merge(['col', 'offset', 'label', 'help', 'selected', 'required'], $exclude);
		$attributes = [];
		foreach($array as $key => $value) {
			if($value AND !in_array($key, $exclude)) {
				$attributes[] = sprintf('%s="%s"', $key, $value);
			}
		}
		return implode(' ', $attributes);
	}

	/**
	 * Ouvre une ligne
	 * @return string
	 */
	public static function openRow()
	{
		return '<div class="row">';
	}

	/**
	 * Ferme la ligne courante et ouvre une ligne
	 * @return string
	 */
	public static function newRow()
	{
		return '</div><div class="row">';
	}

	/**
	 * Ferme une ligne
	 * @return string
	 */
	public static function closeRow()
	{
		return '</div>';
	}

	/**
	 * Crée un formulaire
	 * @param  string $nameId     Nom & id du formulaire
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function openForm($nameId = 'form', $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'action' => '',
			'method' => 'post',
			'enctype' => '',
			'class' => ''
		], $attributes);
		// Retourne le html
		return sprintf('<form %s>', self::sprintAttributes($attributes));
	}

	/**
	 * Ferme le formulaire
	 * @return string
	 */
	public static function closeForm()
	{
		return '</form>';
	}

	/**
	 * Crée un titre
	 * @param  string $text Texte du titre
	 * @return string
	 */
	public static function title($text)
	{
		return '<h3>' . helper::translate($text) . '</h3>';
	}

	/**
	 * Crée un sous-titre
	 * @param  string $text Texte du sous-titre
	 * @return string
	 */
	public static function subTitle($text)
	{
		return '<h4>' . helper::translate($text) . '</h4>';
	}

	/**
	 * Crée une div
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string
	 */
	public static function div($attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => '',
			'text' => '',
			'class' => '',
			'data-1' => '',
			'data-2' => '',
			'data-3' => '',
			'col' => 0,
			'offset' => 0
		], $attributes);
		// Retourne le html
		return sprintf(
			'<div class="col%s offset%s %s" %s>%s</div>',
			$attributes['col'],
			$attributes['offset'],
			$attributes['class'],
			self::sprintAttributes($attributes, ['class', 'text']),
			helper::translate($attributes['text'])
		);
	}

	/**
	 * Crée un label
	 * @param  string $for        For du label
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @param  string $text       Texte du label
	 * @return string
	 */
	public static function label($for, $text, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'for' => $for,
			'help' => '',
			'class' => ''
		], $attributes);
		// Traduit le text
		$text = helper::translate($text);
		// Ajout d'une aide
		if(!empty($attributes['help'])) {
			$text = $text . self::help($attributes['help']);
		}
		// Retourne le html
		return sprintf(
			'<label %s>%s</label>',
			self::sprintAttributes($attributes),
			$text
		);
	}

	/**
	 * Crée un champ caché
	 * @param  string $nameId     Nom & id du champ caché
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function hidden($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'class' => ''
		], $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($nameId)) !== null) {
			$attributes['value'] = $value;
		}
		// Texte
		$html = sprintf('<input type="hidden" %s>', self::sprintAttributes($attributes));
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte court
	 * @param  string $nameId     Nom & id du champ texte court
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function text($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($nameId)) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper']. '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" %s>',
			self::sprintAttributes($attributes)
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ texte long
	 * @param  string $nameId     Nom & id du champ texte long
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function textarea($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'editor' => false,
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($nameId)) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Texte long
		$html .= sprintf(
			'<textarea %s>%s</textarea>',
			self::sprintAttributes($attributes, ['value', 'editor']),
			$attributes['value']
		);
		// Fin col
		$html .= '</div>';
		// Charge la librairie TinyMCE
		if($attributes['editor']) {
			core::$vendor['tinymce'] = true;
			$html .= self::script('
				// Charge tinyMCE
				var language = navigator.languages ? navigator.languages[0] : (navigator.language || navigator.userLanguage);
				var body = $("body");
				tinymce.init({
					selector: "#' . $nameId . '",
					language: language.split("-")[0],
					plugins: "advlist anchor autolink autoresize charmap code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media nonbreaking noneditable paste preview print searchreplace tabfocus table textcolor textpattern visualchars wordcount",
					toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
					body_class: body.attr("class") + " editor",
					content_css: ["core/theme.css"],
					relative_urls: false,
					file_browser_callback: function(fieldName) {
						$("#editorField").val(fieldName);
						$("#editorFile").trigger("click");
					},
					file_browser_callback_types: "image"
				});
			');
		}
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ mot de passe
	 * @param  string $nameId     Nom & id du champ mot de passe
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function password($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Mot de passe
		$html .= sprintf(
			'<input type="password" %s>',
			self::sprintAttributes($attributes)
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ d'upload de fichier
	 * @param  string $nameId     Nom & id du champ d'upload de fichier
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function file($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($nameId)) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="file" %s>',
			self::sprintAttributes($attributes)
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un champ sélection
	 * @param  string $nameId     Nom & id du champ de sélection
	 * @param  array  $options    Liste des options du champ de sélection ($value => $text)
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function select($nameId, array $options, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'selected' => '',
			'disabled' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if($selected = self::getBefore($nameId)) {
			$attributes['selected'] = $selected;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Début sélection
		$html .= sprintf('<select %s>',
			self::sprintAttributes($attributes)
		);
		// Options
		foreach($options as $value => $text) {
			$html .= sprintf(
				'<option value="%s"%s>%s</option>',
				$value,
				$attributes['selected'] === $value ? ' selected' : '',
				helper::translate($text)
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un sélecteur de couleur
	 * @param  string $nameId     Nom & id du sélecteur de couleur
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function colorPicker($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'placeholder' => '',
			'disabled' => '',
			'readonly' => '',
			'required' => '',
			'label' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if(($value = self::getBefore($nameId)) !== null) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper']. '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" class="jscolor {shadow:false, borderRadius:false} %s" %s>',
			$attributes['class'],
			self::sprintAttributes($attributes, ['class'])
		);
		// Fin col
		$html .= '</div>';
		// Charge la librairie jsColor
		core::$vendor['jscolor'] = true;
		// Retourne le html
		return $html;
	}

	/**
	 * Crée case à cocher à sélection multiple
	 * @param  string $nameId     Nom & id de la case à cocher à sélection multiple
	 * @param  string $value      Valeur de la case à cocher à sélection multiple
	 * @param  string $label      Label de la case à cocher à sélection multiple
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function checkbox($nameId, $value, $label, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'checked' => '',
			'disabled' => '',
			'required' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="checkbox" id="%s" name="%s" value="%s" %s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($nameId . '_' . $value, $label, [
			'help' => $attributes['help']
		]);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une case à cocher à sélection unique
	 * @param  string $nameId     Nom & id de la case à cocher à sélection unique
	 * @param  string $value      Valeur de la case à cocher à sélection unique
	 * @param  string $label      Label de la case à cocher à sélection unique
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function radio($nameId, $value, $label, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'checked' => '',
			'disabled' => '',
			'required' => '',
			'help' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= self::getNotice($nameId);
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="radio" id="%s" name="%s" value="%s" %s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($nameId . '_' . $value, $label, [
			'help' => $attributes['help']
		]);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un bouton validation
	 * @param  string $nameId     Nom & id du bouton validation
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function submit($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Enregistrer',
			'disabled' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Bouton
		$html .= sprintf(
			'<input type="submit" value="%s" %s>',
			helper::translate($attributes['value']),
			self::sprintAttributes($attributes, ['value'])
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un bouton
	 * @param  string $nameId     Nom & id du bouton
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function button($nameId, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Bouton',
			'href' => 'javascript:void(0);',
			'target' => '',
			'onclick' => '',
			'disabled' => '',
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Bouton
		$html .= sprintf(
			'<a %s class="button %s %s">%s</a>',
			self::sprintAttributes($attributes, ['value', 'class', 'disabled']),
			$attributes['disabled'] ? 'disabled' : '',
			$attributes['class'],
			helper::translate($attributes['value'])
		);
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée un background
	 * @param  array  $text       Test à afficher dans le background
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function background($text, array $attributes = [])
	{
		// Attributs possibles
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Background
		$html .= '<div class="background ' . $attributes['class']. '">' . helper::translate($text) . '</div>';
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée une aide qui s'affiche au survole
	 * @param  string $text Texte de l'aide
	 * @return string
	 */
	public static function help($text)
	{
		return '<span class="helpButton">' . self::ico('help') . '<span class="helpContent">' . helper::translate($text) . '</span></span>';
	}

	/**
	 * Crée un tableau
	 * @param  array  $cols       Cols des colonnes du tableau (format: [col colonne1, col colonne2, col colonne3, etc])
	 * @param  array  $body       Contenu du tableau (format: [[contenu1, contenu2, contenu3, etc], [contenu1, contenu2, contenu3, etc]])
	 * @param  array  $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string
	 */
	public static function table(array $cols = [], array $body = [], array $attributes = []) {
		// Attributs possibles
		$attributes = array_merge([
			'class' => '',
			'classWrapper' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . ' ' . $attributes['classWrapper'] . '">';
		// Début tableau
		$html .= '<table class="' . $attributes['class']. '">';
		// Début contenu
		$html .= '<tbody>';
		foreach($body as $tr) {
			$html .= '<tr>';
			$i = 0;
			foreach($tr as $td) {
				$html .= '<td class="col' . $cols[$i] . '">' . $td . '</td>';
				$i++;
			}
			$html .= '</tr>';
		}
		// Fin contenu
		$html .= '</tbody>';
		// Début tableau
		$html .= '<table class="' . $attributes['class']. '">';
		// Fin tableau
		$html .= '</table>';
		// Fin col
		$html .= '</div>';
		// Retourne le html
		return $html;
	}

	/**
	 * Crée des onglets
	 * @param  array $tabs Onglets à créer (format: ['titre onglet 1' => 'contenu onglet 1', 'titre onglet 2' => 'contenu onglet 2', etc])
	 * @return string
	 */
	public static function tabs(array $tabs = [])
	{
		$id = uniqid();
		$titles = '';
		$contents = '';
		$i = 1;
		// Met en forme les onglets
		foreach($tabs as $title => $content) {
			$titles .= self::div([
				'class' => 'tabTitle ' . $id . ($i === 1 ? ' current' : ''),
				'data-1' => $i,
				'text' => $title
			]);
			$contents .= self::div([
				'class' => 'tabContent ' . $id . ($i === 1 ? '' : ' hide'),
				'data-1' => $i,
				'text' => $content
			]);
			$i++;
		}
		return
			self::div([
				'class' => 'tabTitles',
				'text' => $titles
			]).
			$contents.
			self::script('
				// Affiche/cache les onglets
				var tabTitles = $("#' . $id . '");
				$(".' . $id . '.tabTitle").on("click", function() {
					var tabTitle = $(this);
					// Si le titre cliqué n\'est pas celui de l\'onglet courant
					if(tabTitle.hasClass("current") === false) {
						// Sélectionne le titre de l\'onglet courant
						$(".' . $id . '.tabTitle.current").removeClass("current");
						tabTitle.addClass("current");
						// Affiche le contenu de l\'onglet courant
						$(".' . $id . '.tabContent:visible").hide();
						$(".' . $id . '.tabContent[data-1=" + tabTitle.attr("data-1") + "]").show();
					}
					// Ajoute le hash dans l\'URL
					window.location.hash = tabTitle.attr("data-1");
				});
				// Affiche le bon onglet si un hash est présent dans l"URL
				var hash = window.location.hash.substr(1);
				if(hash) {
					var tabTitle = $(".' . $id . '.tabTitle[data-1=\'" + hash + "\']");
					if(tabTitle.length) {
						tabTitle.trigger("click");
					}
				}
			');
	}

	/**
	 * Crée un script et le minimise
	 * @param  string $script Script à intégrer
	 * @return string
	 */
	public static function script($script)
	{
		return '<script>' . helper::minifyJs($script) . '</script>';
	}

	/**
	 * Crée un icône
	 * @param  string $ico    Nom de l'icône à ajouter
	 * @param  bool   $margin Ajoute un margin à droite de l'icône
	 * @return string
	 */
	public static function ico($ico, $margin = false)
	{
		return '<span class="zwiico-' . $ico . ($margin ? ' zwiico-margin' : '') . '"></span>';
	}
}