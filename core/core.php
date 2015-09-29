<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2015, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

session_start();

class core
{
	/** @var array Liste des vues pour les modules */
	public static $views = [];

	/** @var bool Autorise ou non la mise en cache pour les modules */
	public static $cache = true;

	/** @var string Titre de la page */
	public static $title = '';

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

	/** @var array Url du site coupée à chaque "/" */
	private $url;

	/** @var string Message d'erreur */
	private $error;

	/** @var string Message de succès */
	private $success;

	/** @var array Liste des modules */
	private static $modules = ['create', 'edit', 'ajax', 'module', 'delete', 'clean', 'export', 'mode', 'config', 'logout'];

	/** Version de ZwiiCMS*/
	private static $version = '7.1.6';

	/** Constructeur de la classe */
	public function __construct()
	{
		$this->data = json_decode(file_get_contents('core/data.json'), true);
		$this->url = empty($_SERVER['QUERY_STRING']) ? $this->getData(['config', 'index']) : $_SERVER['QUERY_STRING'];
		$this->url = helper::filter($this->url, helper::URL);
		$this->url = explode('/', $this->url);
		$this->error = empty($_SESSION['ERROR']) ? '' : $_SESSION['ERROR'];
		$this->success = empty($_SESSION['SUCCESS']) ? '' : $_SESSION['SUCCESS'];
	}

	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className)
	{
		$className = substr($className, 0, -3);
		$classPath = 'modules/' . $className . '/' . $className . '.php';
		if(is_readable($classPath)) {
			require $classPath;
		}
	}

	/** Importe les fichiers de langue du site */
	public function language()
	{
		// Importe le fichier langue système
		$language = 'core/langs/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = json_decode(file_get_contents($language), true);
		}
		// Importe le fichier langue pour le module de la page
		$language = 'modules/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '/langs/' . $this->getData(['config', 'language']);
		if(is_file($language)) {
			self::$language = array_merge(self::$language, json_decode(file_get_contents($language), true));
		}
	}

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
				if($file->isFile()) {
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
			file_put_contents('core/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète (la clef 0 est toujours égale à la page sauf si splice est à false)
	 * @param  int    $key    Clé de l'URL
	 * @param  bool   $splice Supprime la première clef si elle correspond à un module système
	 * @return string
	 */
	public function getUrl($key = null, $splice = true)
	{
		// Variable temporaire pour ne pas impacter les autres $this->getUrl() avec le array_splice()
		$url = $this->url;
		// Retourne l'URL complète
		if($key === null) {
			return implode('/', $url);
		}
		// Retourne une partie de l'URL
		else {
			// Supprime les modules système de $this->url[0] si ils sont présents
			if($splice AND (in_array($url[0], self::$modules))) {
				array_splice($url, 0, 1);
			}
			// Retourne l'URL filtrée
			return empty($url[$key]) ? '' : helper::filter($url[$key], helper::URL);
		}

	}

	/**
	 * Accède au cookie contenant le mot de passe
	 * @return string Cookie contenant le mot de passe
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
	 * Accède à la notification
	 * @return string Notification mise en forme
	 */
	public function getNotification()
	{
		// Si une notice existe affiche un message pour prévenir l'utilisateur
		if(template::$notices) {
			return template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => 'Impossible de soumettre le formulaire, car il contient des erreurs !'
			]);
		}
		// Affiche un message d'erreur si il en existe un
		elseif($this->error) {
			unset($_SESSION['ERROR']);
			return template::div([
				'id' => 'notification',
				'class' => 'error',
				'text' => $this->error
			]);
		}
		// Affiche un message de succès si il en existe un
		elseif($this->success) {
			unset($_SESSION['SUCCESS']);
			return template::div([
				'id' => 'notification',
				'class' => 'success',
				'text' => $this->success
			]);
		}
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
	 * @return string Retourne "edit/" si le mode édition
	 */
	public function getMode()
	{
		return empty($_SESSION['MODE']) ? '' : 'edit/';
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
				return template::getRequired($keys);
			}
			// Transforme la clé en tableau
			$keys = [$keys];
		}
		// Décent dans les niveaux de la variable HTTP POST
		$post = $_POST;
		foreach($keys as $key) {
			if(array_key_exists($key, $post)) {
				$post = $post[$key];
			}
		}
		// Applique le filtre et retourne la valeur
		return ($filter !== null) ? helper::filter($post, $filter) : $post;
	}

	/**
	 * Crée la connexion entre les modules et le système afin d'afficher le contenu de la page
	 */
	public function router()
	{
		// Crée le dossier de cache si il n'existe pas
		if(!file_exists('core/cache/')) {
			mkdir('core/cache/');
		}
		// Module système
		if(in_array($this->getUrl(0, false), self::$modules)) {
			// Si l'utilisateur est connecté le module système est retournée
			if($this->getData(['config', 'password']) === $this->getCookie()) {
				$method = $this->getUrl(0, false);
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
			// Désactive le mode édition si il est actif
			$this->setMode(false);
			// Titre, contenu et description de la page
			self::$title = $this->getData(['pages', $this->getUrl(0, false), 'title']);
			self::$description = $this->getData(['pages', $this->getUrl(0, false), 'description']);
			self::$content = $this->getData(['pages', $this->getUrl(0, false), 'content']) . self::$content;
		}
		// Erreur 404
		if(!self::$content) {
			header("HTTP/1.0 404 Not Found");
			self::$title = helper::translate('Erreur 404');
			self::$content = '<p>' . helper::translate('Page introuvable !') . '</p>';
		}
		// Choix du thème à afficher
		$theme = $this->getData(['pages', $this->getUrl(0), 'theme']);
		if($theme) {
			$this->setData(['config', 'theme', $theme]);
		}
		// Choix du type de données à afficher
		switch(self::$layout) {
			// Affiche le layout
			case 'LAYOUT':
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

	/**
	 * Génère le fichier de cache et retourne la valeur tampon pour les pages publics (appelé après l'affichage du site dans index.php)
	 * @return string
	 */
	public function cache()
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

	/**
	 * Met en forme le panneau d'administration
	 * @return string
	 */
	public function panel()
	{
		// Crée le panneau seulement si l'utilisateur est connecté
		if($this->getCookie() === $this->getData(['config', 'password'])) {
			$li = '<li>';
			$li .= '<select onchange="$(location).attr(\'href\', $(this).val());">';
			// Affiche l'option "Choisissez une page" seulement pour la page de configuration
			if($this->getUrl(0, false) === 'config') {
				$li .= '<option value="">' . helper::translate('Choisissez une page') . '</option>';
			}
			// Crée des options pour les pages en les triant par titre
			$pages = helper::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true);
			foreach($pages as $pageKey => $pageTitle) {
				$current = ($pageKey === $this->getUrl(0)) ? ' selected' : false;
				$li .= '<option value="' . helper::baseUrl() . $this->getMode() . $pageKey . '"' . $current . '>' . $pageTitle . '</option>';
			}
			$li .= '</select>';
			$li .= '</li>';
			$li .= '<li>';
			$li .= '<a href="' . helper::baseUrl() . 'create">' . helper::translate('Créer une page') . '</a>';
			$li .= '</li>';
			// Affiche le switch de mode pour toutes les pages sauf configuration
			if($this->getUrl(0, false) !== 'config') {
				$li .= '<li>';
				$li .= '<a href="' . helper::baseUrl() . 'mode/' . $this->getUrl(null, false) . '">';
				$li .= $this->getMode() ? helper::translate('Mode public') : helper::translate('Mode édition');
				$li .= '</a>';
				$li .= '</li>';
			};
			$li .= '<li>';
			$li .= '<a href="' . helper::baseUrl() . 'config">' . helper::translate('Configuration') . '</a>';
			$li .= '</li>';
			$li .= '<li>';
			$li .= '<a href="' . helper::baseUrl() . 'logout" onclick="return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir vous déconnecter ?') . '\');">';
			$li .= helper::translate('Déconnexion');
			$li .= '</a>';
			$li .= '</li>';
			return '<ul id="panel">' . $li . '</ul>';
		}
	}

	/**
	 * Met en forme le menu
	 * @return string
	 */
	public function menu()
	{
		// Ajout edit/ à l'URL si l'utilisateur est en mode édition
		$edit = ($this->getCookie() === $this->getData(['config', 'password'])) ? $this->getMode() : false;
		// Liste les items du menu en classant les pages par position en ordre croissant
		$pageKeys = helper::arrayCollumn($this->getData('pages'), 'position', 'SORT_ASC');
		// Génère les items du menu en fonction des pages
		$items = false;
		foreach($pageKeys as $pageKey) {
			$current = ($pageKey === $this->getUrl(0)) ? ' class="current"' : false;
			$blank = ($this->getData(['pages', $pageKey, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : false;
			$items .= '<li><a href="' . helper::baseUrl() . $edit . $pageKey . '"' . $current . $blank . '>' . $this->getData(['pages', $pageKey, 'title']) . '</a></li>';
		}
		// Retourne les items du menu
		return $items;
	}

	/**
	 * Importe le js du module
	 * @return string
	 */
	public function js()
	{
		// Check l'existance d'un fichier js pour le module de la page et l'import
		$module = 'modules/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '.js';
		if(is_file($module)) {
			return '<script src="' . $module . '"></script>';
		}
	}

	/**
	 * Importe le css du module
	 * @return string
	 */
	public function css()
	{
		// Check l'existance d'un fichier css pour le module de la page et l'import
		$module = 'modules/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '.css';
		if(is_file($module)) {
			return '<link rel="stylesheet" href="' . $module . '.css">';
		}
	}


	/** MODULE : Création d'une page */
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
				'title' => $title,
				'description' => false,
				'position' => '0',
				'blank' => false,
				'theme' => false,
				'module' => false,
				'content' => '<p>' . helper::translate('Contenu de la page.') . '</p>'
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Notification de création
		$this->setNotification('Nouvelle page créée avec succès !');
		// Redirection vers l'édition de la page
		helper::redirect('edit/' . $key);
	}

	/** MODULE : Édition de page */
	public function edit()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0)])) {
			return false;
		}
		// Traitement du formulaire
		elseif($this->getPost('submit')) {
			// Modifie la clef de la page si le titre a été modifié
			$key = $this->getPost('title') ? $this->getPost('title', helper::URL) : $this->getUrl(0);
			// Sauvegarde le module de la page
			$module = $this->getData(['pages', $this->getUrl(0), 'module']);
			// Si la clef à changée
			if($key !== $this->getUrl(0)) {
				// Incrémente la nouvelle clef de la page pour éviter les doublons
				$key = helper::increment($key, $this->getData('pages'));
				$key = helper::increment($key, self::$modules); // Evite à une page d'avoir la même clef qu'un module système
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
			// Change la positions des pages suivantes si la position de la page à changée
			$position = $this->getPost('position', helper::INT);
			if($position AND $position !== $this->getData(['pages', $this->getUrl(0), 'position'])) {
				// Nouvelle position des pages
				$newPosition = $position;
				// Liste les pages en les triant par position en ordre croissant
				$pages = array_flip(helper::arrayCollumn($this->getData('pages'), 'position', 'SORT_ASC', true));
				// Incrémente la position des pages suivante
				foreach($pages as $pagePosition => $pageKey) {
					if($pagePosition >= $position) {
						$newPosition++;
						$this->setData(['pages', $pageKey, 'position', $newPosition]);
					}
				}
			}
			// Modifie la page ou en crée une nouvelle si la clef à changée
			$this->setData([
				'pages',
				$key,
				[
					'title' => $this->getPost('title', helper::STRING),
					'description' => $this->getPost('description', helper::STRING),
					'position' => $position,
					'blank' => $this->getPost('blank', helper::BOOLEAN),
					'theme' => $this->getPost('theme', helper::STRING),
					'module' => $module,
					'content' => $this->getPost('content')
				]
			]);
			// Supprime l'ancienne page si la clef à changée
			if($key !== $this->getUrl(0)) {
				$this->removeData(['pages', $this->getUrl(0)]);
			}
			// Enregistre les données
			$this->saveData($key);
			// Notification de modification
			$this->setNotification('Page modifiée avec succès !');
			// Redirige vers la l'édition de la nouvelle page si la clef à changée ou sinon vers l'ancienne
			helper::redirect('edit/' . $key);
		}
		// Liste les pages en les triant par position
		$listPages = ['Ne pas afficher', 'Au début'];
		$selected = 0;
		$pagePositionPrevious = 1;
		$pages = array_flip(helper::arrayCollumn($this->getData('pages'), 'position', 'SORT_ASC', true));
		foreach($pages as $pagePosition => $pageKey) {
			// Si la page est la page courante on ne l'affiche pas et on selection l'élément précédent (pas de - 1 à $pagePosition car + 1 dans $listPages)
			if($pageKey === $this->getUrl(0)) {
				$selected = $pagePositionPrevious;
			}
			// Sinon ajoute la page à la liste
			else {
				// Ajoute à la liste
				$listPages[$pagePosition + 1] = helper::translate('Après') . ' "' . $this->getData(['pages', $pageKey, 'title']) . '"';
				// Enregistre la position de cette page afin de la sélectionner si la prochaine page de la liste est la page en train d'être éditée
				$pagePositionPrevious = $pagePosition + 1;
			}
		}
		// Contenu de la page
		$this->setMode(true);
		self::$title = $this->getData(['pages', $this->getUrl(0), 'title']);
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre de la page',
				'value' => $this->getData(['pages', $this->getUrl(0), 'title']),
				'required' => true
			]) .
			template::newRow() .
			template::select('position', $listPages, [
				'label' => 'Position dans le menu',
				'selected' => $selected
			]) .
			template::newRow() .
			template::textarea('content', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'content']),
				'class' => 'editor'
			]) .
			template::newRow() .
			template::textarea('description', [
				'label' => 'Description de la page',
				'help' => 'Si le champ est vide, la description du site est utilisée.',
				'value' => $this->getData(['pages', $this->getUrl(0), 'description'])
			]) .
			template::newRow() .
			template::hidden('key', [
				'value' => $this->getUrl(0)
			]) .
			template::hidden('oldModule', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'module'])
			]) .
			template::select('module', helper::listModules('Aucun module'), [
				'label' => 'Inclure le module',
				'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
				'selected' => $this->getData(['pages', $this->getUrl(0), 'module']),
				'col' => 10
			]) .
			template::button('admin', [
				'value' => 'Administrer',
				'href' => helper::baseUrl() . 'module/' . $this->getUrl(0),
				'disabled' => $this->getData(['pages', $this->getUrl(0), 'module']) ? '' : 'disabled',
				'col' => 2
			]) .
			template::newRow() .
			template::hidden('defaultTheme', [
				'value' => $this->getData(['config', 'theme'])
			]) .
			template::hidden('oldTheme', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'theme']) ? $this->getData(['pages', $this->getUrl(0), 'theme']) : $this->getData(['config', 'theme'])
			]) .
			template::select('theme', helper::listThemes('Thème par défaut'), [
				'label' => 'Thème de la page',
				'selected' => $this->getData(['pages', $this->getUrl(0), 'theme'])
			]) .
			template::newRow() .
			template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet en mode public', [
				'checked' => $this->getData(['pages', $this->getUrl(0), 'blank'])
			]) .
			template::newRow() .
			template::button('delete', [
				'value' => 'Supprimer',
				'href' => helper::baseUrl() . 'delete/' . $this->getUrl(0),
				'onclick' => 'return confirm(\'' . helper::translate('Êtes-vous sûr de vouloir supprimer cette page ?') . '\');',
				'col' => 2,
				'offset' => 8
			]) .
			template::submit('submit', [
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}

	/** MODULE : Enregistrement du module en ajax */
	public function ajax()
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
				'title' => $this->getData(['pages', $this->getUrl(0), 'title']),
				'description' => $this->getData(['pages', $this->getUrl(0), 'description']),
				'position' => $this->getData(['pages', $this->getUrl(0), 'position']),
				'blank' => $this->getData(['pages', $this->getUrl(0), 'blank']),
				'theme' => $this->getData(['pages', $this->getUrl(0), 'theme']),
				'module' => $this->getPost('module', helper::STRING),
				'content' => $this->getData(['pages', $this->getUrl(0), 'content'])
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Utilise le layout JSON
		self::$layout = 'JSON';
		self::$content = true;
	}

	/** MODULE : Configuration du module */
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

	/** MODULE : Suppression de page */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData(['pages', $this->getUrl(0)])) {
			return false;
		}
		// La page est utilisée comme page d'accueil et ne peut être supprimée
		elseif($this->getUrl(0) === $this->getData(['config', 'index'])) {
			$this->setNotification('Impossible de supprimer la page d\'accueil !', true);
		}
		else {
			// Supprime la page et les données du module ratachées à la page
			$this->removeData(['pages', $this->getUrl(0)]);
			$this->removeData($this->getUrl(0));
			// Enregistre les données
			$this->saveData();
			// Notification de suppression
			$this->setNotification('Page supprimée avec succès !');
		}
		// Redirige vers l'édition de la page d'accueil du site
		helper::redirect('edit/' . $this->getData(['config', 'index']));
	}

	/** MODULE : Vide le cache des pages publiques */
	public function clean()
	{
		// Sauvegarde les données en supprimant le cache
		$this->saveData(true);
		// Redirige vers la page de configuration
		helper::redirect('config');
	}

	/** MODULE : Exporte le fichier de données */
	public function export()
	{
		// Force le téléchargement du fichier core/data.json
		header('Content-disposition: attachment; filename=data.json');
		header('Content-type: application/json');
		self::$content = $this->getData();
		// Utilise le layout JSON
		self::$layout = 'JSON';
	}

	/** MODULE : Change le mode d'administration */
	public function mode()
	{
		// Redirection vers mode édition si page en mode public
		if($this->getData(['pages', $this->getUrl(0)])) {
			$url = 'edit/' . $this->getUrl(0);
		}
		// Redirection vers mode public si page en mode édition (utilisation de 0 pour détecter un module système car $this->getUrl() détecte déjà le module système "mode" en 0 et le supprime)
		elseif(in_array($this->getUrl(0), ['edit', 'module'])) {
			$url = $this->getUrl(1);
		}
		// Sinon redirection vers URL courante
		else {
			$url = $this->getUrl();
		}
		// Applique la redirection
		helper::redirect($url);
	}

	/** MODULE : Configuration */
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
			// Active l'URL rewriting
			if($this->getPost('rewriting')) {
				// Check que l'URL rewriting fonctionne sur le serveur
				if(get_headers(helper::baseUrl(false) . 'core/rewrite/test')[0] === 'HTTP/1.1 200 OK') {
					rename('.htaccess', '.simple');
					rename('.rewriting', '.htaccess');
				}
			}
			// Désactive l'URL rewriting
			else {
				rename('.htaccess', '.rewriting');
				rename('.simple', '.htaccess');
			}
			// Modifie la configuration
			$this->setData([
				'config',
				[
					'title' => $this->getPost('title', helper::STRING),
					'description' => $this->getPost('description', helper::STRING),
					'password' => $password,
					'index' => $this->getPost('index', helper::STRING),
					'theme' => $this->getPost('theme', helper::STRING),
					'language' => $this->getPost('language', helper::STRING)
				]
			]);
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
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre du site',
				'required' => 'required',
				'value' => $this->getData(['config', 'title'])
			]) .
			template::newRow() .
			template::textarea('description', [
				'label' => 'Description du site',
				'required' => 'required',
				'value' => $this->getData(['config', 'description'])
			]) .
			template::newRow() .
			template::password('password', [
				'label' => 'Nouveau mot de passe',
				'col' => 6
			]) .
			template::password('confirm', [
				'label' => 'Confirmation du mot de passe',
				'col' => 6
			]) .
			template::newRow() .
			template::select('index', helper::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true), [
				'label' => 'Page d\'accueil',
				'required' => 'required',
				'selected' => $this->getData(['config', 'index'])
			]) .
			template::newRow() .
			template::hidden('oldTheme', [
				'value' => $this->getData(['config', 'theme'])
			]) .
			template::select('theme', helper::listThemes(), [
				'label' => 'Thème par défaut',
				'required' => 'required',
				'selected' => $this->getData(['config', 'theme'])
			]) .
			template::newRow() .
			template::select('language', helper::listLanguages('Ne pas traduire'), [
				'label' => 'Traduire le site',
				'selected' => $this->getData(['config', 'language'])
			]) .
			template::newRow() .
			template::checkbox('rewriting', true, 'Activer la réécriture d\'URL', [
				'checked' => file_exists('.simple'),
				'help' => 'Supprime le point d\'interrogation de l\'URL (si vous n\'arrivez pas à cocher la case, vérifiez que le module d\'URL rewriting de votre serveur soit bien activé).',
				'disabled' => (get_headers(helper::baseUrl(false) . 'core/rewrite/test')[0] !== 'HTTP/1.1 200 OK') ? 'disabled' : '' // Check que l'URL rewriting fonctionne sur le serveur
			]) .
			template::newRow() .
			template::text('version', [
				'label' => 'Version de ZwiiCMS',
				'value' => self::$version,
				'disabled' => 'disabled'
			]) .
			template::newRow() .
			template::button('clean', [
				'value' => 'Vider le cache',
				'href' => helper::baseUrl() . 'clean',
				'col' => 3,
				'offset' => 4
			]) .
			template::button('export', [
				'value' => 'Exporter les données',
				'href' => helper::baseUrl() . 'export',
				'col' => 3
			]) .
			template::submit('submit', [
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}

	/** MODULE : Connexion */
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
				$this->setNotification('Mot de passe incorrect !');
			}
			// Passe en mode édition
			$this->setMode(true);
			// Redirection vers l'URL courante
			helper::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$title = helper::translate('Connexion');
		self::$content =
			template::openForm() .
			template::openRow() .
			template::password('password', [
				'col' => 4
			]) .
			template::newRow() .
			template::checkbox('time', true, 'Me connecter automatiquement à chaque visite') .
			template::newRow() .
			template::submit('submit', [
				'value' => 'Me connecter',
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}

	/** MODULE : Déconnexion */
	public function logout()
	{
		// Supprime le cookie de connexion
		$this->removeCookie();
		// Redirige vers la page d'accueil du site
		helper::redirect('./', false);
	}

}

class helper
{
	/** Filtres personnalisés */
	const PASSWORD = 'FILTER_SANITIZE_PASSWORD';
	const BOOLEAN = 'FILTER_SANITIZE_BOOLEAN';
	const URL = 'FILTER_SANITIZE_URL';
	const STRING = FILTER_SANITIZE_STRING;
	const EMAIL = FILTER_SANITIZE_EMAIL;
	const FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const INT = FILTER_SANITIZE_NUMBER_INT;

	/**
	 * Retourne l'URL de base du site avec ou sans le point d'interrogation
	 * @param  bool   $queryString Affiche ou non le point d'interrogation
	 * @return string
	 */
	public static function baseUrl($queryString = true) {
		$currentPath = $_SERVER['PHP_SELF'];
		$pathInfo = pathinfo($currentPath);
		$hostName = $_SERVER['HTTP_HOST'];
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
		return $protocol . $hostName . rtrim($pathInfo['dirname'], ' \/') . '/' . (($queryString AND file_exists('.rewriting')) ? '?' : '');
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
		switch($filter) {
			case self::PASSWORD:
				$text = sha1($text);
				break;
			case self::BOOLEAN:
				$text = empty($text) ? false : true;
				break;
			case self::URL:
				$search = explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ');
				$replace = explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-');
				$text = str_replace($search, $replace, mb_strtolower($text, 'UTF-8'));
				break;
			default:
				$text = filter_var($text, $filter);
		}
		return get_magic_quotes_gpc() ? stripslashes($text) : $text;
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
			'pages' => '<div class="pagination">' . $pages . '</div>'
		];
	}

	/**
	 * Crée une liste des thèmes (format : fichier.css => fichier)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listThemes($default = false)
	{
		$themes = [];
		if($default) {
			$themes[''] = self::translate($default);
		}
		$it = new DirectoryIterator('themes/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() === 'css' AND $file->getBasename() !== '_empty.css') {
				$themes[$file->getBasename()] = $file->getBasename('.css');
			}
		}
		return $themes;
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
		$it = new DirectoryIterator('modules/');
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
	 * Crée une liste des langues (format : fichier.json => fichier)
	 * @param  mixed $default Valeur par défaut
	 * @return array
	 */
	public static function listLanguages($default = false)
	{
		$languages = [];
		if($default) {
			$languages[''] = self::translate($default);
		}
		$it = new DirectoryIterator('core/langs/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() === 'json') {
				$languages[$file->getBasename()] = $file->getBasename('.json');
			}
		}
		return $languages;
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
			header('Status: 301 Moved Permanently', false, 301);
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
		// Envoi du mail
		return @mail($to, $subject, $message, $header);
	}
}

class template
{
	/** @var array Notices rattachées à des champs ($input => $notice) */
	static $notices = [];

	/** @var array Valeur des champs avant validation et erreur dans le formulaire */
	static $before = [];

	/**
	 * Retourne une notice pour les champs obligatoires (à appeler après avoir vérifié que le champ est vide, retourne false car cette fonction intervient quand un champ est vide)
	 * @param  string|int $key
	 * @return bool
	 */
	public static function getRequired($key)
	{
		if(!empty($_SESSION['REQUIRED']) AND array_key_exists($key . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			self::$notices[$key] = 'Ce champ est requis';
		}
		return false;
	}

	/**
	 * Enregistre un champ comme obligatoire
	 * @param string $id        Id du champ
	 * @param array $attributes Transmet l'attribut "required" à la méthode
	 */
	private static function setRequired($id, $attributes)
	{
		if(!empty($attributes['required']) AND (empty($_SESSION['REQUIRED']) OR !array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED']))) {
			$_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])] = true;
		}
		elseif(!empty($_SESSION['REQUIRED']) AND array_key_exists($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			unset($_SESSION['REQUIRED'][$id . '.' . md5($_SERVER['QUERY_STRING'])]);
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
	 * @return string
	 */
	private static function getBefore($nameId) {
		return empty(self::$before[$nameId]) ? '' : self::$before[$nameId];
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param  array $array   Liste des attributs ($key => $value)
	 * @param  array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	private static function sprintAttributes(array $array = [], array $exclude = [])
	{
		$exclude = array_merge(['col', 'offset', 'label', 'help', 'selected'], $exclude);
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
			'target' => '',
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
		if($value = self::getBefore($nameId)) {
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if($value = self::getBefore($nameId)) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Sauvegarde des données en cas d'erreur
		if($value = self::getBefore($nameId)) {
			$attributes['value'] = $value;
		}
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			self::sprintAttributes($attributes, ['value']),
			$attributes['value']
		);
		// Fin col
		$html .= '</div>';
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Champ requis
		self::setRequired($nameId, $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'col' => 12,
			'offset' => 0
		], $attributes);

		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
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
		return '<span class="helpButton">?<span class="helpContent">' . helper::translate($text) . '</span></span>';
	}
}