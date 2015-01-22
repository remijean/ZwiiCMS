<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi-jean@outlook.com>
 * @copyright Copyright (C) 2008-2015, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

session_start();

class core
{
	private $data;
	private $url;
	private $error;
	private $success;

	private static $modules = ['create', 'edit', 'module', 'delete', 'clean', 'export', 'mode', 'config', 'logout'];
	public static $views = [];
	public static $title = false;
	public static $content = false;

	const VERSION = '7.1.0';

	public function __construct()
	{
		$this->data = json_decode(file_get_contents('core/data.json'), true);
		$this->url = empty($_SERVER['QUERY_STRING']) ? $this->getData('config', 'index') : $_SERVER['QUERY_STRING'];
		$this->url = helpers::filter($this->url, helpers::URL);
		$this->url = explode('/', $this->url);
		$this->error = empty($_SESSION['ERROR']) ? false : $_SESSION['ERROR'];
		$this->success = empty($_SESSION['SUCCESS']) ? false : $_SESSION['SUCCESS'];
	}

	/**
	 * Accède aux données du tableau de données
	 * @param mixed $key1 Clé de niveau 1
	 * @param mixed $key2 Clé de niveau 2
	 * @param mixed $key3 Clé de niveau 3
	 * @return mixed Données du tableau de données
	 */
	public function getData($key1 = null, $key2 = null, $key3 = null)
	{
		if($key3 !== null) {
			return empty($this->data[$key1][$key2][$key3]) ? false : $this->data[$key1][$key2][$key3];
		}
		elseif($key2 !== null) {
			return empty($this->data[$key1][$key2]) ? false : $this->data[$key1][$key2];
		}
		elseif($key1 !== null) {
			return empty($this->data[$key1]) ? false : $this->data[$key1];
		}
		else {
			return $this->data;
		}
	}

	/**
	 * Insert des données dans le tableau de données
	 * @param string $key1 Clé de niveau 1
	 * @param string $key2 Clé de niveau 2
	 * @param string $key3 Clé de niveau 3
	 */
	public function setData($key1, $key2, $key3 = null)
	{
		if($key3 !== null) {
			$this->data[$key1][$key2] = $key3;
		}
		else {
			$this->data[$key1] = $key2;
		}
	}

	/**
	 * Supprime des données dans le tableau de données
	 * @param string $key1 Clé de niveau 1
	 * @param string $key2 Clé de niveau 2
	 * @param string $key3 Clé de niveau 3
	 * @return bool False si une notice existe
	 */
	public function removeData($key1, $key2 = null, $key3 = null)
	{
		if(template::$notices) {
			return false;
		}
		elseif($key3 !== null) {
			unset($this->data[$key1][$key2][$key3]);
		}
		elseif($key2 !== null) {
			unset($this->data[$key1][$key2]);
		}
		else {
			unset($this->data[$key1]);
		}
	}

	/**
	 * Enregistre le tableau de données et supprime les fichiers de cache
	 * @param bool $removeAllCache Supprime l'ensemble des fichiers cache, sinon supprime juste les fichiers cache en rapport avec le module courant ($this->getUrl(1))
	 * @return mixed Nombre de bytes du tableau de données et false en cas d'erreur ou si une notice existe
	 */
	public function saveData($removeAllCache = false)
	{
		if(template::$notices) {
			return false;
		}
		elseif(file_exists('core/cache/')) {
			$it = new DirectoryIterator('core/cache/');
			foreach($it as $file) {
				if($file->isFile()) {
					if($removeAllCache === true) {
						unlink($file->getPathname());
					}
					elseif($this->getUrl(1) === explode('_', $file->getBasename('.html'))[0]) {
						unlink($file->getPathname());
					}
				}
			}

			return file_put_contents('core/data.json', json_encode($this->getData()));
		}
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète
	 * @param int $key Clé de l'URL
	 * @return bool|string Valeur de l'URL
	 */
	public function getUrl($key = null)
	{
		if($key !== null) {
			return empty($this->url[$key]) ? false : helpers::filter($this->url[$key], helpers::URL);
		}
		else {
			return implode('/', $this->url);
		}
	}

	/**
	 * Accès au cookie contenant le mot de passe
	 * @return string|bool Cookie contenant le mot de passe
	 */
	public function getCookie()
	{
		return isset($_COOKIE['PASSWORD']) ? $_COOKIE['PASSWORD'] : false;
	}

	/**
	 * Modifie le mot de passe contenu dans le cookie
	 * @param string $password Mot de passe
	 * @param int $time Temps de vie du cookie
	 */
	public function setCookie($password, $time)
	{
		setcookie('PASSWORD', helpers::filter($password, helpers::PASSWORD), $time);
	}

	/**
	 * Supprime le cookie contenant le mot de passe
	 */
	public function removeCookie()
	{
		setcookie('PASSWORD');
	}

	/**
	 * Accède à la notification
	 * @return bool|string Notification mise en forme ou false si elle n'existe pas
	 */
	public function getNotification()
	{
		if(template::$notices) {
			return '<div id="notification" class="error">Impossible d\'enregistrer les données, le formulaire contient des erreurs !</div>';
		}
		elseif($this->error) {
			unset($_SESSION['ERROR']);

			return '<div id="notification" class="error">' . $this->error . '</div>';
		}
		elseif($this->success) {
			unset($_SESSION['SUCCESS']);

			return '<div id="notification" class="success">' . $this->success . '</div>';
		}
		else {
			return false;
		}
	}

	/**
	 * Modifie la notification
	 * @param string $notification Notification
	 */
	public function setNotification($notification, $error = false)
	{
		if(!template::$notices) {
			$type = $error ? 'ERROR' : 'SUCCESS';
			$_SESSION[$type] = $notification;
		}
	}

	/**
	 * Accède au mode d'affichage
	 * @return string|bool Retourne "edit/" si le mode édition est activé, sinon retourne false
	 */
	public function getMode()
	{
		return empty($_SESSION['MODE']) ? false : 'edit/';
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
	 * @param string $key Clé de la valeur
	 * @param string $filter Filtre à appliquer
	 * @return bool|string Valeur POST ou false si elle n'existe pas
	 */
	public function getPost($key, $filter = null)
	{
		if(empty($_POST[$key])) {
			return template::getRequired($key);
		}
		else {
			return ($filter !== null) ? helpers::filter($_POST[$key], $filter) : $_POST[$key];
		}
	}

	/**
	 * Crée la connexion entre les modules et le système afin d'afficher le contenu de la page
	 * @return string Contenu de la page à afficher
	 */
	public function router()
	{
		// Module système
		if(in_array($this->getUrl(0), self::$modules)) {
			if($this->getData('config', 'password') === $this->getCookie()) {
				$method = $this->getUrl(0);
				$this->$method();
			}
			else {
				$this->login();
			}
		}
		// Page et module
		elseif($this->getData('pages', $this->getUrl(0))) {
			// Cache
			if(!$this->getCookie()) {
				$url = str_replace('/', '_', $this->getUrl());
				if(file_exists('core/cache/' . $url . '.html')) {
					require 'core/cache/' . $url . '.html';
					exit;
				}
				ob_start();
			}
			// Module
			if($this->getData('pages', $this->getUrl(0), 'module')) {
				$module = $this->getData('pages', $this->getUrl(0), 'module') . 'Mod';
				$module = new $module;
				$method = in_array($this->getUrl(1), $module::$views) ? $this->getUrl(1) : 'index';
				$module->$method();
			}
			// Thème
			$theme = $this->getData('pages', $this->getUrl(0), 'theme');
			if($theme) {
				$this->setData('config', 'theme', $theme);
			}
			// Mode d'affichage
			$this->setMode(false);
			// Page
			self::$title = $this->getData('pages', $this->getUrl(0), 'title');
			self::$content = $this->getData('pages', $this->getUrl(0), 'content') . self::$content;
		}
		// Erreur 404
		if(!self::$content) {
			self::$title = 'Erreur 404';
			self::$content = '<p>Page introuvable !</p>';
		}
		// Importe le layout
		require 'core/layout.html';
	}

	/**
	 * Génère le fichier de cache et retourne la valeur tampon pour les pages publics
	 * @return string
	 */
	public function cache()
	{
		$url = str_replace('/', '_', $this->getUrl());
		if($this->getData('pages', $this->getUrl(0)) AND !$this->getCookie() AND !file_exists('core/cache/' . $url . '.html')) {
			if(!file_exists('core/cache/')) {
				mkdir('core/cache/');
			}
			$cache = ob_get_clean();
			file_put_contents('core/cache/' . $url . '.html', $cache);

			return $cache;
		}
	}

	/**
	 * Met en forme le panneau d'administration
	 * @return bool|string Panneau d'administration ou false si l'utilisateur n'est pas connecté
	 */
	public function panel()
	{
		if($this->getCookie() !== $this->getData('config', 'password')) {
			return false;
		}
		else {
			$panel = '<ul id="panel">';
			$panel .= '<li><select onchange="$(location).attr(\'href\', $(this).val());">';
			$panel .= ($this->getUrl(0) === 'config') ? '<option value="">Choisissez une page</option>' : false;
			$pages = helpers::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true);
			foreach($pages as $key => $value) {
				$current = ($key === $this->getUrl(0) OR $key === $this->getUrl(1)) ? ' selected' : false;
				$panel .= '<option value="?' . $this->getMode() . $key . '"' . $current . '>' . $value . '</option>';
			}
			$panel .= '</select></li>';
			$panel .= '<li><a href="?create">Créer une page</a></li>';
			$panel .= '<li><a href="?mode/' . $this->getUrl() . '">Mode ' . ($this->getMode() ? 'public' : 'édition') . '</a></li>';
			$panel .= '<li><a href="?config">Configuration</a></li>';
			$panel .= '<li><a href="?logout" onclick="return confirm(\'Êtes-vous certain de vouloir vous déconnecter ?\');">Déconnexion</a></li>';
			$panel .= '</ul>';

			return $panel;
		}
	}

	/**
	 * Met en forme le menu
	 * @return string Menu
	 */
	public function menu()
	{
		$edit = ($this->getCookie() === $this->getData('config', 'password')) ? $this->getMode() : false;
		$pages = false;
		$menu = helpers::arrayCollumn($this->getData('pages'), 'menu', 'SORT_ASC');
		foreach($menu as $key) {
			$current = ($key === $this->getUrl(0) OR $key === $this->getUrl(1)) ? ' class="current"' : false;
			$blank = ($this->getData('pages', $key, 'blank') AND !$this->getMode()) ? ' target="_blank"' : false;
			$pages .= '<li><a href="?' . $edit . $key . '"' . $current . $blank . '>' . $this->getData('pages', $key, 'title') . '</a></li>';
		}

		return $pages;
	}

	/**
	 * MODULE : Création d'une page
	 */
	public function create()
	{
		$key = helpers::increment('nouvelle-page', $this->getData('pages'));
		$this->setData('pages', $key, [
			'title' => 'Nouvelle page',
			'menu' => '0',
			'position' => false,
			'blank' => false,
			'module' => false,
			'content' => '<p>Contenu de la page.</p>'
		]);
		$this->saveData();
		$this->setNotification('Nouvelle page créée avec succès !');
		helpers::redirect('edit/' . $key);
	}

	/**
	 * MODULE : Édition de page
	 */
	public function edit()
	{
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		elseif($this->getPost('submit')) {
			$key = $this->getPost('title') ? $this->getPost('title', helpers::URL) : $this->getUrl(1);
			if($key !== $this->getUrl(1)) {
				$key = helpers::increment($key, $this->getData('pages'));
				$key = helpers::increment($key, self::$modules);
				$this->removeData('pages', $this->getUrl(1));
				$this->setData($key, $this->getData($this->getUrl(1)));
				$this->removeData($this->getUrl(1));
				if($this->getData('config', 'index') === $this->getUrl(1)) {
					$this->setData('config', 'index', $key);
				}
			}
			if($this->getPost('module') !== $this->getData('pages', $key, 'module')) {
				$this->removeData($key);
			}
			$this->setData('pages', $key, [
				'title' => $this->getPost('title', helpers::STRING),
				'menu' => $this->getPost('menu', helpers::INT),
				'blank' => $this->getPost('blank', helpers::BOOLEAN),
				'theme' => $this->getPost('theme', helpers::STRING),
				'module' => $this->getPost('module', helpers::STRING),
				'content' => $this->getPost('content')
			]);
			$this->saveData($key);
			$this->setNotification('Page modifiée avec succès !');
			helpers::redirect('edit/' . $key);
		}
		$this->setMode(true);
		self::$title = $this->getData('pages', $this->getUrl(1), 'title');
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre de la page',
				'value' => $this->getData('pages', $this->getUrl(1), 'title'),
				'required' => true
			]) .
			template::closeRow() .
			template::openRow() .
			template::text('menu', [
				'label' => 'Position dans le menu',
				'value' => $this->getData('pages', $this->getUrl(1), 'menu')
			]) .
			template::closeRow() .
			template::openRow() .
			template::textarea('content', [
				'value' => $this->getData('pages', $this->getUrl(1), 'content'),
				'class' => 'editor'
			]) .
			template::closeRow() .
			template::openRow() .
			template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet en mode public', [
				'checked' => $this->getData('pages', $this->getUrl(1), 'blank')
			]) .
			template::closeRow() .
			template::openRow() .
			template::select('module', helpers::listModules('Aucun module'), [
				'label' => 'Inclure un module <small>(en cas de changement de module, les données rattachées au module précédant seront supprimées)</small>',
				'selected' => $this->getData('pages', $this->getUrl(1), 'module'),
				'col' => 10
			]) .
			template::button('config', [
				'value' => 'Administrer',
				'href' => '?module/' . $this->getUrl(1),
				'disabled' => $this->getData('pages', $this->getUrl(1), 'module') ? false : true,
				'col' => 2
			]) .
			template::closeRow() .
			template::openRow() .
			template::select('theme', helpers::listThemes('Thème par défaut'), [
				'label' => 'Thème en mode public',
				'selected' => $this->getData('pages', $this->getUrl(1), 'theme')
			]) .
			template::closeRow() .
			template::openRow() .
			template::button('delete', [
				'value' => 'Supprimer',
				'href' => '?delete/' . $this->getUrl(1),
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

	/**
	 * MODULE : Configuration du module
	 */
	public function module()
	{
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		else {
			$module = $this->getData('pages', $this->getUrl(1), 'module') . 'Adm';
			$module = new $module;
			$method = in_array($this->getUrl(2), $module::$views) ? $this->getUrl(2) : 'index';
			$module->$method();
			self::$title = $this->getData('pages', $this->getUrl(1), 'title');
		}
	}

	/**
	 * MODULE : Suppression de page
	 */
	public function delete()
	{
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		elseif($this->getUrl(1) === $this->getData('config', 'index')) {
			$this->setNotification('Impossible de supprimer la page d\'accueil !', true);
		}
		else {
			$this->removeData('pages', $this->getUrl(1));
			$this->removeData($this->getUrl(1));
			$this->saveData();
			$this->setNotification('Page supprimée avec succès !');
		}
		helpers::redirect('edit/' . $this->getData('config', 'index'));
	}

	/**
	 * MODULE : Vide le cache des pages publiques
	 */
	public function clean()
	{
		$this->saveData(true);
		helpers::redirect('config');
	}

	/**
	 * MODULE : Exporte le fichier de données
	 */
	public function export()
	{
		header('Content-disposition: attachment; filename=data.json');
		header('Content-type: application/json');
		echo json_encode($this->getData());
		exit;
	}

	/**
	 * MODULE : Change le mode d'administration
	 */
	public function mode()
	{
		if($this->getData('pages', $this->getUrl(1))) {
			$url = 'edit/' . $this->getUrl(1);
		}
		elseif(in_array($this->getUrl(1), ['edit', 'module'])) {
			$url = $this->getUrl(2);
		}
		else {
			$switch = $this->getMode() ? false : true;
			$this->setMode($switch);
			$url = $this->getUrl(1);
		}
		helpers::redirect($url);
	}

	/**
	 * MODULE : Configuration
	 */
	public function config()
	{
		if($this->getPost('submit')) {
			if($this->getPost('password')) {
				if($this->getPost('password') === $this->getPost('confirm')) {
					$password = $this->getPost('password', helpers::PASSWORD);
				}
				else {
					$password = $this->getData('config', 'password');
					template::$notices['confirm'] = 'La confirmation ne correspond pas au nouveau mot de passe';
				}
			}
			else {
				$password = $this->getData('config', 'password');
			}
			$this->setData('config', [
				'title' => $this->getPost('title', helpers::STRING),
				'description' => $this->getPost('description', helpers::STRING),
				'password' => $password,
				'index' => $this->getPost('index', helpers::STRING),
				'theme' => $this->getPost('theme', helpers::STRING),
				'keywords' =>$this->getPost('keywords', helpers::STRING)
			]);
			$this->saveData(true);
			$this->setNotification('Configuration enregistrée avec succès !');
			helpers::redirect($this->getUrl());
		}
		self::$title = 'Configuration';
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre du site',
				'required' => true,
				'value' => $this->getData('config', 'title')
			]) .
			template::closeRow() .
			template::openRow() .
			template::textarea('description', [
				'label' => 'Description du site',
				'required' => true,
				'value' => $this->getData('config', 'description')
			]) .
			template::closeRow() .
			template::openRow() .
			template::password('password', [
				'label' => 'Nouveau mot de passe',
				'col' => 6
			]) .
			template::password('confirm', [
				'label' => 'Confirmation du mot de passe',
				'col' => 6
			]) .
			template::closeRow() .
			template::openRow() .
			template::select('index', helpers::arrayCollumn($this->getData('pages'), 'title', 'SORT_ASC', true), [
				'label' => 'Page d\'accueil',
				'required' => true,
				'selected' => $this->getData('config', 'index')
			]) .
			template::closeRow() .
			template::openRow() .
			template::select('theme', helpers::listThemes(), [
				'label' => 'Thème par défaut',
				'required' => true,
				'selected' => $this->getData('config', 'theme')
			]) .
			template::closeRow() .
			template::openRow() .
			template::text('keywords', [
				'label' => 'Mots clés du site',
				'value' => $this->getData('config', 'keywords')
			]) .
			template::closeRow() .
			template::openRow() .
			template::text('version', [
				'label' => 'Version de ZwiiCMS',
				'value' => self::VERSION,
				'disabled' => true
			]) .
			template::closeRow() .
			template::openRow() .
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

	/**
	 * MODULE : Connexion
	 */
	public function login()
	{
		if($this->getPost('submit')) {
			if($this->getPost('password', helpers::PASSWORD) === $this->getData('config', 'password')) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setCookie($this->getPost('password'), $time);
				helpers::redirect($this->getUrl());
			}
			else {
				$this->setNotification('Mot de passe incorrect !');
				helpers::redirect($this->getUrl());
			}
		}
		self::$title = 'Connexion';
		self::$content =
			template::openForm() .
			template::openRow() .
			template::password('password', [
				'col' => 4
			]) .
			template::closeRow() .
			template::openRow() .
			template::checkbox('time', true, 'Me connecter automatiquement lors de mes prochaines visites.').
			template::closeRow() .
			template::openRow() .
			template::submit('submit', [
				'value' => 'Me connecter',
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}

	/**
	 * MODULE : Déconnexion
	 */
	public function logout()
	{
		$this->removeCookie();
		helpers::redirect('./', false);
	}

}

class helpers
{
	/**
	 * Filtres personnalisés
	 */
	const PASSWORD = 'FILTER_SANITIZE_PASSWORD';
	const BOOLEAN = 'FILTER_SANITIZE_BOOLEAN';
	const URL = 'FILTER_SANITIZE_URL';
	const STRING = FILTER_SANITIZE_STRING;
	const EMAIL = FILTER_SANITIZE_EMAIL;
	const FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const INT = FILTER_SANITIZE_NUMBER_INT;

	/**
	 * Filtre et incrémente une chaîne en fonction d'un tableau de données
	 * @param string $str Chaîne à filtrer
	 * @param int|string $filter Type de filtre à appliquer
	 * @return string Chaîne filtrée
	 */
	public static function filter($str, $filter)
	{
		switch($filter) {
			case self::PASSWORD:
				$str = sha1($str);
				break;
			case self::BOOLEAN:
				$str = empty($str) ? false : true;
				break;
			case self::URL:
				$search = explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ,_, ');
				$replace = explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-,-');
				$str = str_replace($search, $replace, mb_strtolower($str, 'UTF-8'));
				$str = preg_replace('#[^a-z0-9-/]#', '', $str);
				break;
			default:
				$str = filter_var($str, $filter);
		}

		return get_magic_quotes_gpc() ? stripslashes($str) : $str;
	}

	/**
	 * Incrément une clé en fonction des clés ou des valeurs d'un tableau
	 * @param string $key Clé à incrémenter
	 * @param array $array Tableau à vérifier
	 * @return string Clé incrémentée
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
	 * @param array $array Tableau cible
	 * @param string $columnKey Clé à extraire
	 * @param bool|string $sort Type de tri à appliquer au tableau (SORT_ASC, SORT_DESC, false)
	 * @param bool $keep Conserve le format clés => valeurs
	 * @return array Tableau contenant les colonnes
	 */
	public static function arrayCollumn($array, $columnKey, $sort = false, $keep = false)
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
	 * Crée un système de pagination
	 * @param array $array Tableau de donnée à utiliser
	 * @param string $url URL à utiliser, la dernière partie doit correspondre au numéro de page, par défaut utiliser $this->getUrl()
	 * @return array Tableau contenant les informations sur la pagination (first, last, pages)
	 */
	public static function pagination($array, $url)
	{
		$url = explode('/', $url);
		$urlPagination = is_numeric(end($url)) ? array_pop($url) : 1;
		$urlCurrent = implode('/', $url);
		$nbElements = count($array);
		$nbPage = ceil($nbElements / 10);
		$currentPage = is_numeric($urlPagination) ? (int) $urlPagination : 1;
		$firstElement = ($currentPage - 1) * 10;
		$lastElement = $firstElement + 10;
		$lastElement = ($lastElement > $nbElements) ? $nbElements : $lastElement;
		$pages = false;
		for($i = 1; $i <= $nbPage; $i++)
		{
			$pages .= ($i === $currentPage) ? ' ' . $i . ' ' : ' <a href="?' . $urlCurrent . '/' . $i . '">' . $i . '</a> ';
		}

		return [
			'first' => $firstElement,
			'last' => $lastElement,
			'pages' => '<p>Pages : ' . $pages . '</p>'
		];
	}

	/**
	 * Crée une liste des thèmes
	 * @param mixed $default Valeur par défaut
	 * @return array Liste (format : fichier.css => fichier)
	 */
	public static function listThemes($default = false)
	{
		$themes = [];
		if($default) {
			$themes[''] = $default;
		}
		$it = new DirectoryIterator('themes/');
		foreach($it as $file) {
			if($file->isFile()) {
				$themes[$file->getBasename()] = $file->getBasename('.css');
			}
		}

		return $themes;
	}

	/**
	 * Crée une liste des modules
	 * @param mixed $default Valeur par défaut
	 * @return array Liste (format : fichier => nom du module)
	 */
	public static function listModules($default = false)
	{
		$modules = [];
		if($default) {
			$modules[''] = $default;
		}
		$it = new DirectoryIterator('modules/');
		foreach($it as $file) {
			if($file->isFile()) {
				$module = $file->getBasename('.php') . 'Adm';
				$module = new $module;
				$modules[$file->getBasename('.php')] = $module::$name;
			}
		}

		return $modules;
	}

	/**
	 * Redirige vers une page du site ou une page externe
	 * @param string $url Url de destination
	 * @param string $prefix Ajoute ou non un préfixe à l'url
	 */
	public static function redirect($url, $prefix = '?')
	{
		if(!template::$notices) {
			header('location:' . $prefix . $url);
			exit();
		}
	}
}

class template
{
	static $notices = [];

	/**
	 * @param string|int $key
	 * @return bool Retourne false car cette fonction intervient quand un champ est vide
	 */
	public static function getRequired($key)
	{
		if(!empty($_SESSION['REQUIRED']) AND in_array($key . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED'])) {
			self::$notices[$key] = 'Ce champ est requis';
		}

		return false;
	}

	/**
	 * @param string $nameId
	 * @param array $attributes
	 */
	private static function setRequired($nameId, $attributes)
	{
		if($attributes['required'] AND (empty($_SESSION['REQUIRED']) OR !in_array($nameId . '.' . md5($_SERVER['QUERY_STRING']), $_SESSION['REQUIRED']))) {
			$_SESSION['REQUIRED'][] = $nameId . '.' . md5($_SERVER['QUERY_STRING']);
		}
	}

	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param array $array Liste des attributs ($key => $value)
	 * @param array $exclude Clés à ignorer ($key)
	 * @return string Les attributs au bon format
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
	 * @return string La balise
	 */
	public static function openRow()
	{
		return '<div class="row">';
	}

	/**
	 * Ferme une ligne
	 * @return string La balise
	 */
	public static function closeRow()
	{
		return '</div>';
	}

	/**
	 * Crée un formulaire
	 * @param string $nameId Nom & id du formulaire
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la fonction ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function openForm($nameId = 'form', $attributes = [])
	{
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'target' => '',
			'action' => '',
			'method' => 'post',
			'enctype' => '',
			'class' => ''
		], $attributes);

		return sprintf('<form %s>', self::sprintAttributes($attributes));
	}

	/**
	 * Ferme le formulaire
	 * @return string La balise
	 */
	public static function closeForm()
	{
		return '</form>';
	}

	/**
	 * Crée un label
	 * @param string $for For du label
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @param string $str Texte du label
	 * @return string La balise et ses attributs au bon format
	 */
	public static function label($for, $str, array $attributes = [])
	{
		$attributes = array_merge([
			'for' => $for,
			'class' => ''
		], $attributes);

		return sprintf(
			'<label %s>%s</label>',
			self::sprintAttributes($attributes),
			$str
		);
	}

	/**
	 * Crée un champ texte court
	 * @param string $nameId Nom & id du champ texte court
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function text($nameId, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée un champ texte long
	 * @param string $nameId Nom & id du champ texte long
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function textarea($nameId, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée un champ mot de passe
	 * @param string $nameId Nom & id du champ mot de passe
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function password($nameId, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée un champ sélection
	 * @param string $nameId Nom & id du champ de sélection
	 * @param array $options Liste des options du champ de sélection ($value => $str)
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function select($nameId, array $options, array $attributes = [])
	{
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
		foreach($options as $value => $str) {
			$html .= sprintf(
				'<option value="%s"%s%s%s>%s</option>',
				$value,
				$attributes['selected'] === $value ? ' selected' : false,
				$attributes['disabled'] ? ' disabled' : false,
				$attributes['required'] ? ' required' : false,
				$str
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Fin col
		$html .= '</div>';

		return $html;
	}

	/**
	 * Crée case à cocher à sélection multiple
	 * @param string $nameId Nom & id de la case à cocher à sélection multiple
	 * @param string $value Valeur de la case à cocher à sélection multiple
	 * @param string $label Label de la case à cocher à sélection multiple
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function checkbox($nameId, $value, $label, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée une case à cocher à sélection unique
	 * @param string $nameId Nom & id de la case à cocher à sélection unique
	 * @param string $value Valeur de la case à cocher à sélection unique
	 * @param string $label Label de la case à cocher à sélection unique
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function radio($nameId, $value, $label, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée un bouton validation
	 * @param string $nameId Nom & id du bouton validation
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function submit($nameId, array $attributes = [])
	{
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

		return $html;
	}

	/**
	 * Crée un bouton
	 * @param string $nameId Nom & id du bouton
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function button($nameId, array $attributes = [])
	{
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

		return $html;
	}
}