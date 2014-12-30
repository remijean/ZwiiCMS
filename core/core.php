<?php

/**
 * Copyright (C) 2008-2015, Rémi Jean (remi-jean@outlook.com)
 * <http://remijean.github.io/ZwiiCMS/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General License for more details.
 *
 * You should have received a copy of the GNU General License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

session_start();

class core
{
	private $data;
	private $url;
	private $notification;
	private $title;
	private $content;

	public $views = [];
	public static $modules = ['add', 'edit', 'delete', 'mode', 'config', 'logout'];

	const VERSION = '0.4.5';

	public function __construct()
	{
		$this->data = json_decode(file_get_contents('core/data.json'), true);
		ksort($this->data['pages']);
		asort($this->data['menu']);
		$this->url = empty($_SERVER['QUERY_STRING']) ? $this->getData('config', 'index') : $_SERVER['QUERY_STRING'];
		$this->url = helpers::filter($this->url, helpers::URL);
		$this->url = explode('/', $this->url);
		$this->notification = empty($_SESSION['NOTIFICATION']) ? false : $_SESSION['NOTIFICATION'];
	}

	/**
	 * Accède au contenu d'un tableau de données
	 * @param mixed $array Tableau cible
	 * @param mixed $key Clé du tableau
	 * @param mixed $subKey Sous clé du tableau
	 * @return mixed Contenu du tableau de données
	 */
	public function getData($array = null, $key = null, $subKey = null)
	{
		if($subKey !== null) {
			return empty($this->data[$array][$key][$subKey]) ? false : $this->data[$array][$key][$subKey];
		}
		elseif($key !== null) {
			return empty($this->data[$array][$key]) ? false : $this->data[$array][$key];
		}
		elseif($array !== null) {
			return empty($this->data[$array]) ? false : $this->data[$array];
		}
		else {
			return $this->data;
		}
	}

	/**
	 * Insert une ligne dans un tableau de données
	 * @param string $array Tableau cible
	 * @param mixed $key Clé du tableau
	 * @param mixed $value Valeur de la clé du tableau
	 */
	public function setData($array, $key, $value = null)
	{
		if($value !== null) {
			$this->data[$array][$key] = $value;
		}
		else {
			$this->data[$array] = $key;
		}
	}

	/**
	 * Supprime une ligne dans un tableau de données
	 * @param string $array Tableau cible
	 * @param mixed $key Clé du tableau
	 */
	public function removeData($array, $key)
	{
		unset($this->data[$array][$key]);
	}

	/**
	 * Enregistre les données
	 * @return mixed Nombre de bytes du fichier ou false en cas d'erreur
	 */
	public function saveData()
	{
		return file_put_contents('core/data.json', json_encode($this->getData()));
	}

	/**
	 * Accède à une valeur de l'URL ou à l'URL complète sous forme de chaîne
	 * @param int $key Clé de l'URL
	 * @return bool|string Valeur de l'URL|URL complète
	 */
	public function getUrl($key = null)
	{
		if($key !== null) {
			return empty($this->url[$key]) ? false : $this->url[$key];
		}
		else {
			return implode('/', $this->url);
		}
	}

	/**
	 * Accède au titre de la page
	 * @return string Titre de la page
	 */
	public function getTitle()
	{
		return isset($this->title) ? $this->title : 'Erreur 404';
	}

	/**
	 * Modifie le titre de la page
	 * @param string $value Titre de la page
	 */
	public function setTitle($value)
	{
		$this->title = $value;
	}

	/**
	 * Accède au contenu de la page
	 * @return string Contenu de la page
	 */
	public function getContent()
	{
		$content = isset($this->content) ? $this->content : '<p>Page introuvable</p>';
		return '<h2>' . $this->getTitle() . '</h2>' . $content;
	}

	/**
	 * Modifie le contenu de la page
	 * @param string $value Contenu de la page
	 */
	public function setContent($value)
	{
		$this->content = $value;
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
	 * @return bool|string Retourne notification mise en forme si elle existe, sinon false
	 */
	public function getNotification()
	{
		if($this->notification) {
			unset($_SESSION['NOTIFICATION']);

			return '<div id="notification">' . $this->notification . '</div>';
		}
		else {
			return false;
		}
	}

	/**
	 * Modifie la notification
	 * @param string $notification Notification
	 */
	public function setNotification($notification)
	{
		$_SESSION['NOTIFICATION'] = $notification;
	}

	/**
	 * Accède au mode d'affichage
	 * @return string|bool Retourne "edit/" si mode édition, false si mode public
	 */
	public function getMode()
	{
		return empty($_SESSION['MODE']) ? false : 'edit/';
	}

	/**
	 * Modifie le mode d'affichage
	 * @param bool $mode True mode édition, false mode public
	 */
	public function setMode($mode)
	{
		$_SESSION['MODE'] = $mode;
	}

	/**
	 * Accède à une valeur de la variable HTTP POST et applique un filtre
	 * @param string $key Clé de la valeur
	 * @param string $filter Filtre à appliquer
	 * @return bool|string Retourne la valeur POST si la clé existe, sinon false
	 */
	public function getPost($key, $filter = null)
	{
		if(empty($_POST[$key])) {
			return false;
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
		// Module
		elseif($this->getData('pages', $this->getUrl(0), 'module')) {
			$module = $this->getData('pages', $this->getUrl(0), 'module');
			$module = new $module;
			$method = in_array($this->getUrl(1), $module->views) ? $this->getUrl(1) : 'index';
			$module->$method();
		}
		// Redirection
		elseif($this->getData('pages', $this->getUrl(0), 'link')) {
			helpers::redirect($this->getData('pages', $this->getUrl(0), 'link'), false);
		}
		// Page
		elseif($this->getData('pages', $this->getUrl(0))) {
			$this->setMode(false);
			$this->setTitle($this->getData('pages', $this->getUrl(0), 'title'));
			$this->setContent($this->getData('pages', $this->getUrl(0), 'content'));
		}
	}

	/**
	 * Met en forme le panneau d'administration
	 * @return bool|string Retourne le panneau d'administration si l'utilisateur est connecté, sinon false
	 */
	public function panel()
	{
		// N'affiche rien si l'utilisateur n'est pas connecté
		if($this->getCookie() !== $this->getData('config', 'password')) {
			return false;
		}
		// Sinon affiche le panneau d'administration
		else {
			$panel = '<ul id="panel">';
			$panel .= '<li><select>';
			$panel .= ($this->getUrl(0) === 'config') ? '<option value="">Choisissez une page</option>' : false;
			foreach($this->getData('pages') as $key => $value) {
				$current = ($key === $this->getUrl(0) OR $key === $this->getUrl(1)) ? ' selected' : false;
				$panel .= '<option value="?' . $this->getMode() . $key . '"' . $current . '>' . $value['title'] . '</option>';
			}
			$panel .= '</select></li>';
			$panel .= '<li><a href="?add">Créer une page</a></li>';
			$panel .= '<li><a href="?mode/' . $this->getUrl() . '">Mode ' . ($this->getMode() ? 'public' : 'édition') . '</a></li>';
			$panel .= '<li><a href="?config">Configuration</a></li>';
			$panel .= '<li><a href="?logout" onclick="return confirm(\'Êtes-vous certain de vouloir vous déconnecter ?\');">Déconnexion</a></li>';
			$panel .= '</ul>';

			return $panel;
		}
	}

	/**
	 * Met en forme le menu
	 * @return string Retourne le menu
	 */
	public function nav()
	{
		$edit = ($this->getCookie() === $this->getData('config', 'password')) ? $this->getMode() : false;
		$pages = false;
		foreach($this->getData('menu') as $key => $value) {
			if($value) {
				$current = ($key === $this->getUrl(0) OR $key === $this->getUrl(1)) ? ' class="current"' : false;
				$pages .= '<li><a href="?' . $edit . $key . '"' . $current . '>' . $this->getData('pages', $key, 'title') . '</a></li>';
			}
		}

		return $pages;
	}

	/**
	 * Ajout de page
	 */
	public function add()
	{
		$key = helpers::increment('nouvelle-page', $this->getData('pages'));
		$this->setData('pages', $key, [
			'title' => 'Nouvelle page',
			'position' => '0',
			'blank' => false,
			'module' => '',
			'link' => '',
			'content' => 'Contenu de la page.'
		]);
		$this->setData('menu', $key, '0');
		$this->saveData();
		$this->setNotification('Nouvelle page créée avec succès !');
		helpers::redirect('edit/' . $key);
	}

	/**
	 * Édition de page
	 */
	public function edit()
	{
		// Erreur 404
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		// Enregistre la page
		elseif($this->getPost('submit')) {
			if($this->getPost('title', helpers::URL) === $this->getUrl(1)) {
				$title = $this->getPost('title', helpers::STRING);
				$key = helpers::filter($title, helpers::URL);
			}
			else {
				$title = $this->getPost('title', helpers::STRING) ? $this->getPost('title', helpers::STRING) : 'Sans titre';
				$key = helpers::filter($title, helpers::URL);
				$key = helpers::increment($key, $this->getData('pages'));
				$key = helpers::increment($key, self::$modules);
				$this->removeData('pages', $this->getUrl(1));
				$this->removeData('menu', $this->getUrl(1));
				if($this->getData('config', 'index') === $this->getUrl(1)) {
					$this->setData('settings', 'index', $key);
				}
			}
			$this->setData('pages', $key, [
				'title' => $title,
				'blank' => $this->getPost('blank', helpers::BOOLEAN),
				'module' => $this->getPost('module', helpers::STRING),
				'link' => $this->getPost('link', helpers::URL),
				'content' => $this->getPost('content')
			]);
			$this->setData('menu', $key, $this->getPost('position', helpers::NUMBER_INT));
			$this->saveData();
			$this->setNotification('Page modifiée avec succès !');
			helpers::redirect('edit/' . $key);
		}
		// Interface d'édition
		else {
			$modules[''] = 'Aucun module';
			$it = new DirectoryIterator('modules/');
			foreach($it as $file) {
				if($file->isFile()) {
					$module = $file->getBasename('.php');
					$module = new $module;
					$modules[$file->getBasename()] = $module::$title;
				}
			}
			$this->setMode(true);
			$this->setTitle($this->getData('pages', $this->getUrl(1), 'title'));
			$this->setContent(
				template::openForm() .
				template::openRow() .
				template::text('title', [
					'label' => 'Titre de la page',
					'value' => $this->getData('pages', $this->getUrl(1), 'title')
				]) .
				template::closeRow() .
				template::openRow() .
				template::textarea('content', [
					'value' => $this->getData('pages', $this->getUrl(1), 'content'),
					'class' => 'editor'
				]) .
				template::closeRow() .
				template::openRow() .
				template::checkbox('blank', true, 'Ouvrir la page dans un nouvel onglet', [
					'checked' => $this->getData('pages', $this->getUrl(1), 'blank')
				]) .
				template::closeRow() .
				template::openRow() .
				template::text('position', [
					'label' => 'Position de la page dans le menu',
					'value' => $this->getData('menu', $this->getUrl(1))
				]) .
				template::closeRow() .
				template::openRow() .
				template::select('module', $modules, [
					'label' => 'Inclure un module à la page',
					'selected' => $this->getData('pages', $this->getUrl(1), 'module')
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
				template::closeForm()
			);
		}
	}

	/**
	 * Suppression de page
	 */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		// Erreur page d'accueil
		elseif($this->getUrl(1) === $this->getData('config', 'index')) {
			$this->setNotification('Impossible de supprimer la page d\'accueil !');
		}
		// Suppression
		else {
			$this->removeData('pages', $this->getUrl(1));
			$this->removeData('menu', $this->getUrl(1));
			$this->saveData();
			$this->setNotification('Page supprimée avec succès !');
		}
		helpers::redirect('edit/' . $this->getData('config', 'index'));
	}

	/**
	 * Change le mode d'administration
	 */
	public function mode()
	{
		// Redirection vers mode édition dans le module page
		if($this->getData('pages', $this->getUrl(1))) {
			$url = 'edit/' . $this->getUrl(1);
		}
		// Redirection vers mode public dans le module d'édition
		elseif($this->getUrl(1) === 'edit') {
			$url = $this->getUrl(2);
		}
		// Switch mode public/édition sans redirection pour les autres modules
		else {
			$switch = $this->getMode() ? false : true;
			$this->setMode($switch);
			$url = $this->getUrl(1);
		}
		helpers::redirect($url);
	}

	/**
	 * Configuration
	 */
	public function config()
	{
		// Enregistre la configuration
		if($this->getPost('submit')) {
			$inputs = ['title', 'description', 'keywords', 'password', 'index', 'theme'];
			foreach($inputs as $value) {
				if($value === 'password') {
					if($this->getPost($value) AND $this->getPost($value) === $this->getPost('confirm')) {
						$this->setData('config', $value, $this->getPost($value, helpers::STRING));
					}
				}
				else {
					$this->setData('config', $value, $this->getPost($value, helpers::STRING));
				}
			}
			$this->saveData();
			$this->setNotification('Configuration enregistrée avec succès !');
			helpers::redirect($this->getUrl());
		}
		// Interface de configuration
		else {
			$pages = [];
			foreach($this->getData('pages') as $key => $value) {
				$pages[$key] = $value['title'];
			}
			$themes = [];
			$it = new DirectoryIterator('themes/');
			foreach($it as $file) {
				if($file->isFile()) {
					$themes[$file->getBasename()] = $file->getBasename('.css');
				}
			}
			$this->setTitle('Configuration');
			$this->setContent(
				template::openForm() .
				template::openRow() .
				template::text('title', [
					'label' => 'Titre du site',
					'value' => $this->getData('config', 'title'),
				]) .
				template::closeRow() .
				template::openRow() .
				template::textarea('description', [
					'label' => 'Description du site',
					'value' => $this->getData('config', 'description'),
				]) .
				template::closeRow() .
				template::openRow() .
				template::text('keywords', [
					'label' => 'Mots clés du site',
					'value' => $this->getData('config', 'keywords'),
				]) .
				template::closeRow() .
				template::openRow() .
				template::text('password', [
					'label' => 'Nouveau mot de passe',
					'col' => 6
				]) .
				template::text('confirm', [
					'label' => 'Confirmation du mot de passe',
					'col' => 6
				]) .
				template::closeRow() .
				template::openRow() .
				template::select('index', $pages, [
					'label' => 'Page d\'accueil',
					'selected' => $this->getData('config', 'index')
				]) .
				template::closeRow() .
				template::openRow() .
				template::select('theme', $themes, [
					'label' => 'Thème par défaut',
					'selected' => $this->getData('config', 'theme')
				]) .
				template::closeRow() .
				template::openRow() .
				template::submit('submit', [
					'col' => 2,
					'offset' => 10
				]) .
				template::closeRow() .
				template::closeForm()
			);
		}
	}

	/**
	 * Connexion
	 */
	public function login()
	{
		// Connexion
		if($this->getPost('submit')) {
			// Bon mot de passe
			if($this->getPost('password', helpers::PASSWORD) === $this->getData('config', 'password')) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setCookie($this->getPost('password'), $time);
				helpers::redirect($this->getUrl());
			}
			// Mot de passe incorrect
			else {
				$this->setNotification('Mot de passe incorrect !');
				helpers::redirect($this->getUrl());
			}
		}
		// Interface de connexion
		else {
			$this->setTitle('Connexion');
			$this->setContent(
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
				template::closeForm()
			);
		}
	}

	/**
	 * Déconnexion
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
	const EMAIL = FILTER_SANITIZE_EMAIL;
	const MAGIC_QUOTES = FILTER_SANITIZE_MAGIC_QUOTES;
	const NUMBER_FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const NUMBER_INT = FILTER_SANITIZE_NUMBER_INT;
	const SPECIAL_CHARS = FILTER_SANITIZE_SPECIAL_CHARS;
	const STRING = FILTER_SANITIZE_STRING;
	const URL = FILTER_SANITIZE_URL;

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
				$search = explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ');
				$replace = explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-');
				$str = str_replace($search, $replace, strtolower($str));
				$str = filter_var($str, self::URL);
				break;
			default:
				$str = filter_var($str, $filter);
		}

		return $str;
	}

	/**
	 * Incrément une clé en fonction des clés ou des valeurs d'un tableau
	 * @param string $key Clé à incrémenter
	 * @param array $array Tableau à vérifier
	 * @return string Clé incrémentée
	 */
	public static function increment($key, $array)
	{
		$i = 2;
		$newKey = $key;
		while(array_key_exists($newKey, $array) OR in_array($newKey, $array)) {
			$newKey = $key . '-' . $i;
			$i++;
		}

		return $newKey;
	}

	/**
	 * Redirige vers une page du site ou une page externe
	 * @param string $url Url de destination
	 * @param string $prefix Ajoute ou non un préfixe à l'url
	 */
	public static function redirect($url, $prefix = '?')
	{
		header('location:' . $prefix . $url);
		exit();
	}
}

class template
{
	/**
	 * Retourne les attributs d'une balise au bon format
	 * @param array $array Liste des attributs ($key => $value)
	 * @param array $exclude Clés à ignorer ($key)
	 * @return string Les attributs au bon format
	 */
	private static function sprintAttributes(array $array = [], array $exclude = [])
	{
		$exclude = array_merge(['col', 'label'], $exclude);
		$attributes = [];
		foreach($array as $key => $value) {
			if($value AND !in_array($key, $exclude)) {
				$attributes[] = sprintf('%s="%s"', $key, $value);
			}
		}

		return implode(' ', $attributes);
	}

	/**
	 * Ouvre une nouvelle ligne
	 * @return string La balise
	 */
	public static function openRow()
	{
		return '<div class="row">';
	}

	/**
	 * Ferme la ligne ouverte
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

		return sprintf('<label %s>%s</label>',
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<input type="text" %s>', self::sprintAttributes($attributes));
		// </div>
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<textarea %s>%s</textarea>',
			self::sprintAttributes($attributes, ['value']),
			$attributes['value']
		);
		// </div>
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<input type="password" %s>', self::sprintAttributes($attributes));
		// </div>
		$html .= '</div>';

		return $html;
	}

	/**
	 * Crée un champ mot de passe
	 * @param string $nameId Nom & id du champ mot de passe
	 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
	 * @return string La balise et ses attributs au bon format
	 */
	public static function integer($nameId, array $attributes = [])
	{
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'placeholder' => '',
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<input type="text" class="integer %s" %s>', $attributes['class'], self::sprintAttributes($attributes, ['class']));
		// </div>
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <select>
		$html .= sprintf('<select %s>', self::sprintAttributes($attributes, ['selected']));
		// <option>
		foreach($options as $value => $str) {
			$html .= sprintf('<option value="%s"%s>%s</option>',
				$value,
				$attributes['selected'] === $value ? ' selected' : false,
				$str
			);
		}
		// </select>
		$html .= '</select>';
		// </div>
		$html .= '</div>';

		return $html;
	}

	/**
	 * Crée une case à cocher à sélection multiple
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
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <input>
		$html .= sprintf('<input type="checkbox" id="%s" name="%s" value="%s" %s%s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes, ['checked']),
			$attributes['checked'] ? ' checked' : false
		);
		// <label>
		$html .= self::label($nameId . '_' . $value, $label);
		// </div>
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
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <input>
		$html .= sprintf('<input type="radio" id="%s" name="%s" value="%s" %s%s>',
			$nameId . '_' . $value,
			$nameId . '[]',
			$value,
			self::sprintAttributes($attributes, ['checked']),
			$attributes['checked'] ? ' checked' : false
		);
		// <label>
		$html .= self::label($nameId . '_' . $value, $label);
		// </div>
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<input type="submit" %s>', self::sprintAttributes($attributes));
		// </div>
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
			'label' => '',
			'class' => '',
			'col' => 12,
			'offset' => 0
		], $attributes);

		// <div>
		$html = '<div class="col' . $attributes['col'] . ' offset' . $attributes['offset'] . '">';
		// <label>
		if($attributes['label']) {
			$html .= self::label($nameId, $attributes['label']);
		}
		// <input>
		$html .= sprintf('<a %s class="button %s">%s</a>', self::sprintAttributes($attributes, ['value', 'class']), $attributes['class'], $attributes['value']);
		// </div>
		$html .= '</div>';

		return $html;
	}
}