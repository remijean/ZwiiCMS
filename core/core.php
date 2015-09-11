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

	/** @var string Titre de la page */
	public static $title = '';

	/** @var string Description de la page */
	public static $description = '';

	/** @var string Contenu de la page */
	public static $content = '';

	/** @var string Type de layout à afficher (LAYOUT : layout et mise cache - JSON : tableau JSON - BLANK : page vide) */
	public static $layout = 'LAYOUT';

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
		$this->url = helpers::filter($this->url, helpers::URL);
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
		$classPath = 'modules/' . substr($className, 0, -3) . '.php';
		if(is_readable($classPath)) {
			require $classPath;
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
	 * @param boolean $removeAllCache Supprime l'ensemble des fichiers cache, sinon supprime juste les fichiers cache en rapport avec le module courant
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
			//die();
			file_put_contents('core/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète (la clef 0 est toujours égale à la page sauf si splice est à false)
	 * @param  int     $key    Clé de l'URL
	 * @param  boolean $splice Supprime la première clef si elle correspond à un module système
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
			return empty($url[$key]) ? '' : helpers::filter($url[$key], helpers::URL);
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
		setcookie('PASSWORD', helpers::filter($password, helpers::PASSWORD), $time);
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
			return '<div id="notification" class="error">Impossible d\'enregistrer les données, le formulaire contient des erreurs !</div>';
		}
		// Affiche un message d'erreur si il en existe un
		elseif($this->error) {
			unset($_SESSION['ERROR']);
			return '<div id="notification" class="error">' . $this->error . '</div>';
		}
		// Affiche un message de succès si il en existe un
		elseif($this->success) {
			unset($_SESSION['SUCCESS']);
			return '<div id="notification" class="success">' . $this->success . '</div>';
		}
	}

	/**
	 * Modifie la notification
	 * @param string  $notification Notification
	 * @param boolean $error        Message d'erreur ou non
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
	 * @param boolean $mode True pour activer le mode édition ou false pour le désactiver
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
		// Transforme la clé en tableau
		if(!is_array($keys)) {
			$keys = [$keys];
		}
		// Erreur champ obligatoire
		if(empty($_POST[$keys[0]])) {
			return template::getRequired($keys[0]);
		}
		// Décent dans les niveaux de la variable HTTP POST
		$post = $_POST;
		foreach($keys as $key) {
			if(array_key_exists($key, $post)) {
				$post = $post[$key];
			}
		}
		// Applique le filtre et retourne la valeur
		return ($filter !== null) ? helpers::filter($post, $filter) : $post;
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
			self::$title = 'Erreur 404';
			self::$content = '<p>Page introuvable !</p>';
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
		// Crée le cache si l'utilisateur est sur une page, qu'il n'est pas connecté, que le fichier de cache n'existe toujours et layout LAYOUT utilisé
		if($this->getData(['pages', $this->getUrl(0)]) AND !$this->getCookie() AND !file_exists('core/cache/' . $url . '.html') AND self::$layout === 'LAYOUT') {
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
			$li = '<li><select onchange="$(location).attr(\'href\', $(this).val());">';
			$li .= ($this->getUrl(0, false) === 'config') ? '<option value="">Choisissez une page</option>' : false;
			$pages = helpers::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true);
			foreach($pages as $key => $page) {
				$current = ($key === $this->getUrl(0)) ? ' selected' : false;
				$li .= '<option value="?' . $this->getMode() . $key . '"' . $current . '>' . $page . '</option>';
			}
			$li .= '</select></li>';
			$li .= '<li><a href="?create">Créer une page</a></li>';
			$li .= ($this->getUrl(0, false) !== 'config') ? '<li><a href="?mode/' . $this->getUrl(null, false) . '">Mode ' . ($this->getMode() ? 'public' : 'édition') . '</a></li>' : false;
			$li .= '<li><a href="?config">Configuration</a></li>';
			$li .= '<li><a href="?logout" onclick="return confirm(\'Êtes-vous certain de vouloir vous déconnecter ?\');">Déconnexion</a></li>';
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
		$pages = helpers::arrayCollumn($this->getData('pages'), 'position', 'SORT_ASC');
		// Génère les items du menu en fonction des pages
		$items = false;
		foreach($pages as $page) {
			$current = ($page === $this->getUrl(0)) ? ' class="current"' : false;
			$blank = ($this->getData(['pages', $page, 'blank']) AND !$this->getMode()) ? ' target="_blank"' : false;
			$items .= '<li><a href="?' . $edit . $page . '"' . $current . $blank . '>' . $this->getData(['pages', $page, 'title']) . '</a></li>';
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
		$module = 'modules/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '.js';
		if(file_exists($module)) {
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
		$module = 'modules/' . $this->getData(['pages', $this->getUrl(0), 'module']) . '.css';
		if(file_exists($module)) {
			return '<link rel="stylesheet" href="' . $module . '.css">';
		}
	}

	/** MODULE : Création d'une page */
	public function create()
	{
		// Incrémente la clef de la page pour éviter les doublons
		$key = helpers::increment('nouvelle-page', $this->getData('pages'));
		// Crée la page
		$this->setData([
			'pages',
			$key,
			[
				'title' => 'Nouvelle page',
				'description' => false,
				'position' => '0',
				'blank' => false,
				'theme' => false,
				'module' => false,
				'content' => '<p>Contenu de la page.</p>'
			]
		]);
		// Enregistre les données
		$this->saveData();
		// Notification de création
		$this->setNotification('Nouvelle page créée avec succès !');
		// Redirection vers l'édition de la page
		helpers::redirect('edit/' . $key);
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
			$key = $this->getPost('title') ? $this->getPost('title', helpers::URL) : $this->getUrl(0);
			// Sauvegarde le module de la page
			$module = $this->getData(['pages', $this->getUrl(0), 'module']);
			// Si la clef à changée
			if($key !== $this->getUrl(0)) {
				// Incrémente la nouvelle clef de la page pour éviter les doublons
				$key = helpers::increment($key, $this->getData('pages'));
				$key = helpers::increment($key, self::$modules); // Evite à une page d'avoir la même clef qu'un module système
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
			// Modifie la page ou en crée une nouvelle si la clef à changée
			$this->setData([
				'pages',
				$key,
				[
					'title' => $this->getPost('title', helpers::STRING),
					'description' => $this->getPost('description', helpers::STRING),
					'position' => $this->getPost('position', helpers::INT),
					'blank' => $this->getPost('blank', helpers::BOOLEAN),
					'theme' => $this->getPost('theme', helpers::STRING),
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
			helpers::redirect('edit/' . $key);
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
			template::text('position', [
				'label' => 'Position dans le menu' . template::help('Le classement se fait par ordre croissant. Si le champ est vide, la page ne s\'affiche pas dans le menu.'),
				'value' => $this->getData(['pages', $this->getUrl(0), 'position'])
			]) .
			template::newRow() .
			template::textarea('content', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'content']),
				'class' => 'editor'
			]) .
			template::newRow() .
			template::textarea('description', [
				'label' => 'Description de la page' . template::help('Si le champ est vide, la description du site est utilisée.'),
				'value' => $this->getData(['pages', $this->getUrl(0), 'description'])
			]) .
			template::newRow() .
			template::hidden('key', [
				'value' => $this->getUrl(0)
			]) .
			template::hidden('oldModule', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'module'])
			]) .
			template::select('module', helpers::listModules('Aucun module'), [
				'label' => 'Inclure un module' . template::help('En cas de changement de module, les données rattachées au module précédent seront supprimées.'),
				'selected' => $this->getData(['pages', $this->getUrl(0), 'module']),
				'col' => 10
			]) .
			template::button('config', [
				'value' => 'Administrer',
				'href' => '?module/' . $this->getUrl(0),
				'target' => '_blank',
				'disabled' => $this->getData(['pages', $this->getUrl(0), 'module']) ? false : true,
				'col' => 2
			]) .
			template::newRow() .
			template::hidden('oldTheme', [
				'value' => $this->getData(['pages', $this->getUrl(0), 'theme']) ? $this->getData(['pages', $this->getUrl(0), 'theme']) : $this->getData(['config', 'theme'])
			]) .
			template::select('theme', helpers::listThemes('Thème par défaut'), [
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
				'href' => '?delete/' . $this->getUrl(0),
				'onclick' => 'return confirm(\'Êtes-vous certain de vouloir supprimer cette page ?\');',
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
				'module' => $this->getPost('module', helpers::STRING),
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
		// Supprime la page et les données du module ratachées à la page
		$this->removeData(['pages', $this->getUrl(0)]);
		$this->removeData($this->getUrl(0));
		// Enregistre les données
		$this->saveData();
		// Notification de suppression
		$this->setNotification('Page supprimée avec succès !');
		// Redirige vers l'édition de la page d'accueil du site
		helpers::redirect('edit/' . $this->getData(['config', 'index']));
	}

	/** MODULE : Vide le cache des pages publiques */
	public function clean()
	{
		// Sauvegarde les données en supprimant le cache
		$this->saveData(true);
		// Redirige vers la page de configuration
		helpers::redirect('config');
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
		helpers::redirect($url);
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
					$password = $this->getPost('password', helpers::PASSWORD);
				}
				// Ne change pas le mot de passe et crée une notice si la confirmation ne correspond pas au mot de passe
				else {
					$password = $this->getData(['config', 'password']);
					template::$notices['confirm'] = 'La confirmation ne correspond pas au nouveau mot de passe';
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
					'title' => $this->getPost('title', helpers::STRING),
					'description' => $this->getPost('description', helpers::STRING),
					'password' => $password,
					'index' => $this->getPost('index', helpers::STRING),
					'theme' => $this->getPost('theme', helpers::STRING)
				]
			]);
			// Enregistre les données et supprime le cache
			$this->saveData(true);
			// Notification de modification
			$this->setNotification('Configuration enregistrée avec succès !');
			// Redirige vers l'URL courante
			helpers::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$title = 'Configuration';
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre du site',
				'required' => true,
				'value' => $this->getData(['config', 'title'])
			]) .
			template::newRow() .
			template::textarea('description', [
				'label' => 'Description du site',
				'required' => true,
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
			template::select('index', helpers::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true), [
				'label' => 'Page d\'accueil',
				'required' => true,
				'selected' => $this->getData(['config', 'index'])
			]) .
			template::newRow() .
			template::hidden('oldTheme', [
				'value' => $this->getData(['config', 'theme'])
			]) .
			template::select('theme', helpers::listThemes(), [
				'label' => 'Thème par défaut',
				'required' => true,
				'selected' => $this->getData(['config', 'theme'])
			]) .
			template::newRow() .
			template::text('version', [
				'label' => 'Version de ZwiiCMS',
				'value' => self::$version,
				'disabled' => true
			]) .
			template::newRow() .
			template::button('clean', [
				'value' => 'Vider le cache',
				'href' => '?clean',
				'col' => 3,
				'offset' => 4
			]) .
			template::button('export', [
				'value' => 'Exporter les données',
				'href' => '?export',
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
			if($this->getPost('password', helpers::PASSWORD) === $this->getData(['config', 'password'])) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setCookie($this->getPost('password'), $time);
			}
			// Notification d'échec si le mot de passe incorrect
			else {
				$this->setNotification('Mot de passe incorrect !');
			}
			// Redirection vers l'URL courante
			helpers::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$title = 'Connexion';
		self::$content =
			template::openForm() .
			template::openRow() .
			template::password('password', [
				'col' => 4
			]) .
			template::newRow() .
			template::checkbox('time', true, 'Me connecter automatiquement lors de mes prochaines visites.').
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
		helpers::redirect('./', false);
	}

}

class helpers
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
	 * Incrément une clé en fonction des clés ou des valeurs d'un tableau
	 * @param  string $key   Clé à incrémenter
	 * @param  array  $array Tableau à vérifier
	 * @return string
	 */
	public static function increment($key, $array)
	{
		if(empty($array)) {
			return $key;
		}
		else {
			$i = 2;
			$newKey = $key;
			while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
				$newKey = $key . '-' . $i;
				$i++;
			}
			return $newKey;
		}
	}

	/**
	 * Retourne les valeurs d'une colonne du tableau de données
	 * @param  array   $array     Tableau cible
	 * @param  string  $columnKey Clé à extraire
	 * @param  string  $sort      Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, ou vide)
	 * @param  boolean $keep      Conserve le format clés => valeurs
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
			$pages .= ($i === $currentPage) ? ' ' . $i . ' ' : ' <a href="?' . $urlCurrent . '/' . $i . '">' . $i . '</a> ';
		}
		// Retourne un tableau contenant les informations sur la pagination
		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'pages' => '<p>Pages : ' . $pages . '</p>'
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
			$themes[''] = $default;
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
			$modules[''] = $default;
		}
		$it = new DirectoryIterator('modules/');
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() === 'php') {
				$module = $file->getBasename('.php') . 'Adm';
				$module = new $module;
				$modules[$file->getBasename('.php')] = $module::$name;
			}
		}
		return $modules;
	}

	/**
	 * Redirige vers une page du site ou une page externe et sauvegarde les données du formulaire si il existe des notices
	 * @param string $url    Url de destination
	 * @param string $prefix Ajoute ou non un préfixe à l'url
	 */
	public static function redirect($url, $prefix = '?')
	{
		// Sauvegarde des données en méthode POST si une notice existe
		if(template::$notices) {
			template::$before = $_POST;
		}
		// Sinon redirection
		else {
			header('Status: 301 Moved Permanently', false, 301);
			header('Location: ' . $prefix . $url);
			exit();
		}
	}

	/**
	 * Envoi un mail
	 * @param  string $from    Expéditeur
	 * @param  string $to      Destinataire
	 * @param  string $subject Sujet
	 * @param  string $message Message
	 * @return boolean
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
	 * @return boolean
	 */
	public static function getRequired($key)
	{
		if(!empty($_SESSION['REQUIRED']) AND in_array($key . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
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
		if($attributes['required'] AND (empty($_SESSION['REQUIRED']) OR !in_array($id . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED']))) {
			$_SESSION['REQUIRED'][] = $id . '.' . md5($_SERVER['QUERY_STRING']);
		}
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
		$exclude = array_merge(['col', 'offset', 'label', 'readonly', 'disabled', 'required'], $exclude);
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
		return '<h3>' . $text . '</h3>';
	}

	/**
	 * Crée un sous-titre
	 * @param  string $text Texte du sous-titre
	 * @return string
	 */
	public static function subTitle($text)
	{
		return '<h4>' . $text . '</h4>';
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
			'col' => '',
			'offset' => ''
		], $attributes);
		// Retourne le html
		return sprintf(
			'<div class="col%s offset%s %s" %s>%s</div>',
			$attributes['col'],
			$attributes['offset'],
			$attributes['class'],
			self::sprintAttributes($attributes, ['class', 'text']),
			$attributes['text']
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
			'class' => ''
		], $attributes);
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
			'disabled' => false,
			'readonly' => false,
			'required' => false,
			'label' => '',
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
			$html .= self::label($nameId, $attributes['label']);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Texte
		$html .= sprintf(
			'<input type="text" %s%s%s%s>',
			self::sprintAttributes($attributes),
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['readonly'] ? ' readonly' : false,
			$attributes['required'] ? ' required' : false
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
			'disabled' => false,
			'readonly' => false,
			'required' => false,
			'label' => '',
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
			$html .= self::label($nameId, $attributes['label']);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Texte long
		$html .= sprintf(
			'<textarea %s%s%s%s>%s</textarea>',
			self::sprintAttributes($attributes, ['value']),
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['readonly'] ? ' readonly' : false,
			$attributes['required'] ? ' required' : false,
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
			'disabled' => false,
			'readonly' => false,
			'required' => false,
			'label' => '',
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
			$html .= self::label($nameId, $attributes['label']);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Mot de passe
		$html .= sprintf(
			'<input type="password" %s%s%s%s>',
			self::sprintAttributes($attributes),
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['readonly'] ? ' readonly' : false,
			$attributes['required'] ? ' required' : false
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
			'disabled' => false,
			'required' => false,
			'label' => '',
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
			$html .= self::label($nameId, $attributes['label']);
		}
		// Notice
		if(!empty(self::$notices[$nameId])) {
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Début sélection
		$html .= sprintf('<select %s>', self::sprintAttributes($attributes, ['selected']));
		// Options
		foreach($options as $value => $text) {
			$html .= sprintf(
				'<option value="%s"%s%s%s>%s</option>',
				$value,
				$attributes['selected'] === $value ? ' selected' : false,
				$attributes['disabled'] ? ' disabled' : false,
				$attributes['required'] ? ' required' : false,
				$text
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
			'checked' => false,
			'disabled' => false,
			'required' => false,
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
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="checkbox" id="%s" name="%s" value="%s" %s%s%s%s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes, ['checked']),
			$attributes['checked'] ? ' checked' : false,
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['required'] ? ' required' : false
		);
		// Label
		$html .= self::label($nameId . '_' . $value, $label);
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
			'checked' => false,
			'disabled' => false,
			'required' => false,
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
			$html .= '<div class="notice">' . self::$notices[$nameId] . '</div>';
			$attributes['class'] .= ' notice';
		}
		// Case à cocher
		$html .= sprintf(
			'<input type="radio" id="%s" name="%s" value="%s" %s%s%s%s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes, ['checked']),
			$attributes['checked'] ? ' checked' : false,
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['required'] ? ' required' : false
		);
		// Label
		$html .= self::label($nameId . '_' . $value, $label);
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
			'disabled' => false,
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);
		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// Bouton
		$html .= sprintf(
			'<input type="submit" %s%s>',
			self::sprintAttributes($attributes),
			$attributes['disabled'] ? ' disabled' : false
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
			'disabled' => false,
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// Début col
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// Label
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// Bouton
		$html .= sprintf(
			'<a %s class="button %s%s">%s</a>',
			self::sprintAttributes($attributes, ['value', 'class']),
			$attributes['class'],
			$attributes['disabled'] ? ' disabled' : false,
			$attributes['value']
		);
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
		return '<span class="helpButton">?<span class="helpContent">' . $text . '</span></span>';
	}
}