<?php

/*
	Copyright (C) 2008-2015, Rémi Jean (remi-jean@outlook.com)
	<http://zwiicms.com/>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General License for more details.

	You should have received a copy of the GNU General License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

session_start();

class core
{
	/**
	 * Fichier de données global contenant la configuration du site et des plugins
	 */
	public $config = 'core/data/config.json';

	/**
	 * Contient les vues des plugins
	 */
	public $views = [];

	/**
	 * Contient le niveau d'accès des plugins
	 */
	public static $private = false;

	private $data;
	private $plugins;
	private $url;
	private $notification;
	private $title;
	private $content;

	/**
	 * Version du Zwii
	 */
	const VERSION = '0.3.0';

	public function __construct()
	{
		$this->data = $this->listFiles('core/data/', '.json');
		$this->plugins = array_merge($this->listFiles('plugins/', '.php'), ['config', 'page', 'user']);
		$this->url = empty($_SERVER['QUERY_STRING']) ? 'page/' . $this->getData('config', 'index') : $_SERVER['QUERY_STRING'];
		$this->url = helpers::filter($this->url, helpers::URL);
		$this->url = explode('/', $this->url);
		$this->notification = isset($_SESSION['NOTIFICATION']) ? $_SESSION['NOTIFICATION'] : false;
	}

	/**
	 * Accède au contenu d'un tableau de données
	 * @param string $file Nom du tableau cible (correspond au nom du fichier)
	 * @param mixed $key Clé du tableau
	 * @param mixed $subKey Sous clé du tableau
	 * @return mixed
	 */
	public function getData($file, $key = null, $subKey = null)
	{
		if($subKey !== null) {
			return empty($this->data[$file][$key][$subKey]) ? false : $this->data[$file][$key][$subKey];
		}
		if($key !== null) {
			return empty($this->data[$file][$key]) ? false : $this->data[$file][$key];
		}
		else {
			return empty($this->data[$file]) ? false : $this->data[$file];
		}
	}

	/**
	 * Insert une ligne dans un tableau de données
	 * @param string $file Nom du tableau cible (correspond au nom du fichier)
	 * @param mixed $key Clé du tableau
	 * @param mixed $value Valeur de la clé du tableau
	 */
	public function setData($file, $key, $value = null)
	{
		if($value !== null) {
			$this->data[$file][$key] = $value;
		}
		else {
			$this->data[$file] = $key;
		}
	}

	/**
	 * Supprime une ligne dans un tableau de données
	 * @param string $file Nom du tableau cible (correspond au nom du fichier)
	 * @param mixed $key Clé du tableau
	 */
	public function removeData($file, $key)
	{
		unset($this->data[$file][$key]);
	}

	/**
	 * Liste les plugins disponibles|Vérifie l'existence d'un plugin
	 * @param string $plugin Nom du plugin à vérifier
	 * @return array|bool Liste des plugins|true si plugin existe, sinon false
	 */
	public function getPlugins($plugin = null)
	{
		if($plugin !== null) {
			return in_array($plugin, $this->plugins);
		}
		else {
			return empty($this->plugins) ? false : $this->plugins;
		}
	}

	public function setPlugins($plugin, $key, $value)
	{
		$this->plugins[$plugin][$key] = $value;
	}

	public function getUrl($value = null)
	{
		if($value !== null) {
			return empty($this->url[$value]) ? false : $this->url[$value];
		}
		else {
			return implode('/', $this->url);
		}
	}

	public function getTitle()
	{
		return isset($this->title) ? $this->title : 'Erreur 404';
	}

	public function setTitle($value)
	{
		$this->title = $value;
	}

	public function getContent()
	{
		return isset($this->content) ? $this->content : '<p>Page introuvable</p>';
	}

	public function setContent($value)
	{
		$this->content = $value;
	}

	public function getCookie()
	{
		return isset($_COOKIE['PASSWORD']) ? $_COOKIE['PASSWORD'] : false;
	}

	public function setCookie($password, $time)
	{
		setcookie('PASSWORD', helpers::filter($password, helpers::PASSWORD), $time);
	}

	public function removeCookie()
	{
		setcookie('PASSWORD');
	}

	private function getNotification()
	{
		if($this->notification) {
			unset($_SESSION['NOTIFICATION']);

			return '<div id="notification">' . $this->notification . '</div>';
		}
		else {
			return false;
		}
	}

	public function setNotification($notification)
	{
		$_SESSION['NOTIFICATION'] = $notification;
	}

	public function getPost($key, $filter = null)
	{
		if(isset($_POST[$key])) {
			return ($filter !== null) ? helpers::filter($_POST[$key], $filter) : $_POST[$key];
		}
		else {
			return false;
		}
	}

	/**
	 * Crée la connexion entre les plugins et le système afin d'afficher le contenu de la page
	 * @return string Contenu de la page à afficher
	 */
	public function router()
	{
		$plugin = $this->getUrl(0);
		if($this->getPlugins($plugin)) {
			$plugin = new $plugin;
			$method = in_array($this->getUrl(1), $plugin->views) ? $this->getUrl(1) : 'index';
			$plugin->$method();
			if($plugin::$private AND $this->getData('config', 'password') !== $this->getCookie()) {
				$plugin = new user;
				$plugin->index();
			}
			$this->setTitle($plugin->getTitle());
			$this->setContent($plugin->getContent());
		}
		// Page d'erreur
		$this->setContent('<h2>' . $this->getTitle() . '</h2>' . $this->getContent());
	}

	/**
	 * Liste les fichiers d'un dossier
	 * @param string $dir Dossier cible
	 * @param string $extension Extension des fichiers à lister
	 * @return array Liste des fichiers
	 */
	private function listFiles($dir, $extension)
	{
		$files = [];
		$it = new FilesystemIterator($dir);
		foreach($it as $file) {
			if($file->isFile() AND $file->getExtension() == substr($extension, 1)) {
				if(helpers::jsonGetContents($file->getPathname())) {
					$files[$file->getBasename($extension)] = helpers::jsonGetContents($file->getPathname());
					ksort($files[$file->getBasename($extension)]);
				}
				else {
					$files[] = $file->getBasename($extension);
				}
			}
		}

		return $files;
	}

	public function adminPanel()
	{
		if($this->getCookie() === $this->getData('config', 'password')) {
			$panel = '<ul id="panel">';
			$panel .= '<li>';
			$panel .= '<select>';
			foreach($this->getData('pages') as $key => $value) {
				$current = ($key === $this->getUrl(1) OR $key === $this->getUrl(2)) ? ' selected' : false;
				$panel .= '<option value="?page/edit/' . $key . '"' . $current . '>' . $value['title'] . '</option>';
			}
			$panel .= '</select>';
			$panel .= '</li>';
			if($this->getUrl(0) === 'page') {
				$panel .= '<li><a href="?page/add">Créer</a></li>';
				$panel .= '<li>';
				if(!$this->getData('pages', $this->getUrl(2), 'link')) {
					if($this->getUrl(1) === 'edit') {
						$panel .= '<a href="?page/' . $this->getUrl(2) . '">Visualiser</a>';
					}
					else {
						$panel .= '<a href="?page/edit/' . $this->getUrl(1) . '">Éditer</a>';
					}
				}
				$panel .= '</li>';
				$panel .= '<li><a href="?page/delete/' . $this->getUrl(2) . '">Supprimer</a></li>';
			}
			$panel .= '<li><a href="?plugins">Plugins</a></li>';
			$panel .= '<li><a href="?user/logout">Déconnexion</a></li>';
			$panel .= '</ul>';

			return $panel . $this->getNotification();
		}
		else {
			return false;
		}
	}
}

class page extends core
{
	/**
	 * Fichier de données
	 */
	private $data = 'core/data/pages.json';

	/**
	 * Liste des vues
	 */
	public $views = ['add', 'edit', 'delete'];

	/**
	 * Colonnes du fichier de données
	 */
	private $title = 'Nouvelle page';
	private $position = 0;
	private $blank = false;
	private $link = '';
	private $content = '';

	/**
	 * PAGE : Page
	 * @return bool Retourne false en cas d'erreur, sinon true
	 */
	public function index()
	{
		// Erreur
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		// Page externe
		elseif($this->getData('pages', $this->getUrl(1), 'link')) {
			return helpers::redirect($this->getData('pages', $this->getUrl(1), 'link'), false);
		}
		// Page
		else {
			$this->setTitle($this->getData('pages', $this->getUrl(1), 'title'));
			if($this->getData('config', 'password') === $this->getCookie()) {
				$this->setContent($this->getData('pages', $this->getUrl(1), 'content'));
			}

			return true;
		}
	}

	/**
	 * PAGE : Ajout de page
	 * @return bool Retourne true
	 */
	public function add()
	{
		self::$private = true;

		$key = helpers::increment(helpers::filter($this->title, helpers::URL), $this->getData('pages'));
		$this->setData('pages', $key, [
			'title' => $this->title,
			'position' => $this->position,
			'blank' => $this->blank,
			'link' => $this->link,
			'content' => $this->content
		]);
		helpers::jsonPutContents($this->data, $this->getData('pages'));
		$this->setNotification('Nouvelle page créée avec succès !');

		return helpers::redirect('page/' . $key);
	}

	/**
	 * PAGE : Édition de page
	 * @return bool Retourne false en cas d'erreur, sinon true
	 */
	public function edit()
	{
		self::$private = true;

		// Erreur
		if(!$this->getData('pages', $this->getUrl(2))) {
			return false;
		}
		// Formulaire validé
		elseif($this->getPost('submit')) {
			if($this->getPost('title', helpers::URL) === $this->getUrl(2)) {
				$key = $this->getUrl(2);
			}
			else {
				$key = helpers::increment($this->getPost('title', helpers::URL), $this->getData('pages'));
				$this->removeData('pages', $this->getUrl(2));
			}
			$this->setData('pages', $key, [
				'title' => $this->getPost('title', helpers::STRING),
				'position' => $this->getPost('position', helpers::NUMBER_INT),
				'blank' => $this->getPost('blank', helpers::BOOLEAN),
				'link' => $this->getPost('link', helpers::URL),
				'content' => $this->getPost('content')
			]);
			helpers::jsonPutContents($this->data, $this->getData('pages'));
			if($this->getData('config', 'index') === $this->getUrl(2)) {
				$this->setData('settings', 'index', $key);
				helpers::jsonPutContents($this->config, $this->getData('config'));
			}
			$this->setNotification('Page modifiée avec succès !');

			return helpers::redirect('page/edit/' . $key);
		}
		// Page d'édition
		else {
			$this->setTitle($this->getData('pages', $this->getUrl(2), 'title'));
			$this->setContent(
				template::openForm() .
					template::openRow() .
						template::text('title', [
							'label' => 'Titre de la page',
							'value' => $this->getData('pages', $this->getUrl(2), 'title'),
						]) .
					template::closeRow() .
					template::openRow() .
						template::textarea('content', [
							'value' => $this->getData('pages', $this->getUrl(2), 'content'),
							'class' => 'editor'
						]) .
					template::closeRow() .
					template::openRow() .
						template::text('position', [
							'label' => 'Position dans le menu',
							'value' => $this->getData('pages', $this->getUrl(2), 'position'),
							'col' => 6
						]) .
						template::text('link', [
							'label' => 'Lien de redirection',
							'value' => $this->getData('pages', $this->getUrl(2), 'link'),
							'col' => 6
						]) .
					template::closeRow() .
					template::openRow() .
						template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet', [
							'checked' => $this->getData('pages', $this->getUrl(2), 'blank')
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

			return true;
		}
	}

	/**
	 * PAGE : Page
	 * @return bool Retourne false en cas d'erreur, sinon true
	 */
	public function delete()
	{
		self::$private = true;

		// Erreur
		if(!$this->getData('pages', $this->getUrl(2))) {
			return false;
		}
		// Supprime la page
		else {
			if($this->getUrl(2) === $this->getData('config', 'index')) {
				$this->setNotification('Impossible de supprimer la page d\'accueil !');
			}
			else {
				$this->removeData('pages', $this->getUrl(2));
				helpers::jsonPutContents($this->data, $this->getData('pages'));
				$this->setNotification('Page supprimée avec succès !');
			}

			return helpers::redirect('page/' . $this->getData('config', 'index'));
		}
	}

	public static function menu()
	{

	}
}

class user extends core
{
	/**
	 * Liste des vues
	 */
	public $views = ['logout'];

	/**
	 * PAGE : Connexion
	 * @return bool Retourne false en cas d'erreur, sinon true
	 */
	public function index()
	{
		if($this->getPost('submit')) {
			if($this->getPost('password', helpers::PASSWORD) === $this->getData('config', 'password')) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				$this->setcookie($this->getPost('password'), $time);

				return helpers::redirect($this->getUrl());
			}
			else {
				$this->setNotification('Mot de passe incorrect !');

				return helpers::redirect($this->getUrl());
			}
		}
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

			return true;
		}
	}

	/**
	 * PAGE : Déconnexion
	 * @return bool Retourne true
	 */
	public function logout()
	{
		self::$private = true;

		$this->removeCookie();

		return helpers::redirect('./');
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
	const ENCODED = FILTER_SANITIZE_ENCODED;
	const MAGIC_QUOTES = FILTER_SANITIZE_MAGIC_QUOTES;
	const NUMBER_FLOAT = FILTER_SANITIZE_NUMBER_FLOAT;
	const NUMBER_INT = FILTER_SANITIZE_NUMBER_INT;
	const SPECIAL_CHARS = FILTER_SANITIZE_SPECIAL_CHARS;
	const STRING = FILTER_SANITIZE_STRING;
	const URL = FILTER_SANITIZE_URL;
	const UNSAFE_RAW = FILTER_UNSAFE_RAW;

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
			case self::URL:
				$search = explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ');
				$replace = explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-');
				$str = str_replace($search, $replace, strtolower($str));
				$str = filter_var($str, self::URL);
				break;
			case self::BOOLEAN:
				$str = empty($str) ? false : true;
				break;
			default:
				$str = filter_var($str, $filter);
		}

		return $str;
	}

	/**
	 * Incrément une clé en fonction des clés d'un tableau de données
	 * @param string $key Clé à incrémenter
	 * @param array $data Tableau de données
	 * @return string Clé incrémentée
	 */
	public static function increment($key, $data)
	{
		$i = 2;
		$newKay = $key;
		while(array_key_exists($newKay, $data)) {
			$newKay = $key . '-' . $i;
			$i++;
		}

		return $newKay;
	}

	/**
	 * Lit un fichier .json
	 * @param string $file Le fichier à lire
	 * @return mixed Contenu du fichier ou false en cas d'erreur
	 */
	public static function jsonGetContents($file)
	{
		return json_decode(file_get_contents($file), true);
	}

	/**
	 * Enregistre un tableau dans un fichier .json
	 * @param string $file Le fichier à enregistrer
	 * @param array $data Tableau à enregistrer
	 * @return mixed Nombre de bytes du fichier ou false en cas d'erreur
	 */
	public static function jsonPutContents($file, array $data = [])
	{
		if(file_exists($file)) {
			unlink($file);
		}

		return file_put_contents($file, json_encode($data));
	}

	/**
	 * Redirige vers une page du site ou une page externe
	 * @param string $url Url de destination
	 * @param string $suffix Ajoute ou non un suffixe à l'url
	 * @return bool Retourne true
	 */
	public static function redirect($url, $suffix = '?')
	{
		header('location:' . $suffix . $url);

		return true;
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
	public static function select($nameId, array $options = [], array $attributes = [])
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