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

namespace
{
	class core
	{
		/**
		 * Fichier de données global contenant la configuration du site et des plugins
		 */
		public static $config = 'core/data/config.json';

		/**
		 * Enregistre le niveau d'accès des plugins
		 */
		public static $private = false;

		private $data;
		private $plugins;
		private $url;
		private $popup;
		private $title;
		private $content;

		const VERSION = '0.1.0';

		public function __construct()
		{
			$this->data = $this->listFiles('core/data/', '.json');
			$this->plugins = $this->listFiles('plugins/', '.php');
			$this->url = empty($_SERVER['QUERY_STRING']) ? 'page/' . $this->getData('settings', 'index') : $_SERVER['QUERY_STRING'];
			$this->url = filter_var($this->url, FILTER_SANITIZE_URL);
			$this->url = explode('/', $this->url);
		}

		/**
		 * Accède au contenu d'un tableau de données
		 * @param $file string Nom du tableau cible (correspond au nom du fichier)
		 * @param mixed $key Clé du tableau
		 * @param mixed $subKey Sous clé du tableau
		 * @return mixed
		 */
		public function getData($file, $key = false, $subKey = false)
		{
			if($subKey) {
				return isset($this->data[$file][$key][$subKey]) ? $this->data[$file][$key][$subKey] : false;
			}
			if($key) {
				return isset($this->data[$file][$key]) ? $this->data[$file][$key] : false;
			}
			else {
				return isset($this->data[$file]) ? $this->data[$file] : false;
			}
		}

		/**
		 * Insert une ligne dans un tableau de données
		 * @param string $file Nom du tableau cible (correspond au nom du fichier)
		 * @param mixed $key Clé du tableau
		 * @param mixed $value Valeur de la clé du tableau
		 */
		public function setData($file, $key, $value = false)
		{
			if($value) {
				$this->data[$file][$key] = $value;
			}
			else {
				$this->data[$file] = $key;
			}
		}

		public function removeData($file, $key)
		{
			unset($this->data[$file][$key]);
		}

		public function getPlugins()
		{
			return isset($this->plugins) ? $this->plugins : false;
		}

		public function setPlugins($plugin, $key, $value)
		{
			$this->plugins[$plugin][$key] = $value;
		}

		public function getUrl($value = false)
		{
			if(is_numeric($value)) {
				return isset($this->url[$value]) ? $this->url[$value] : false;
			}
			else {
				return '?' . implode('/', $this->url);
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

		private function getPopup()
		{
			if(!isset($this->popup)) {
				unset($_SESSION['POPUP']);
				return '<div id="popup">' . $this->popup . '</div>';
			}
			else {
				return false;
			}
		}

		public function setPopup($str)
		{
			$_SESSION['POPUP'] = $str;
		}

		public function getPost($key)
		{
			return empty($_POST[$key]) ? false : stripslashes($_POST[$key]);
		}

		public function isPost($key)
		{
			return isset($_POST[$key]) ? true : false;
		}

		/**
		 * Liste les fichiers d'un dossier
		 * @param $dir string Dossier cible
		 * @param $extension string Extension des fichiers à lister
		 * @return array Liste des fichiers
		 */
		private function listFiles($dir, $extension)
		{
			$files = [];
			$it = new FilesystemIterator($dir);
			foreach($it as $file) {
				if($file->isFile() AND $file->getExtension() == substr($extension, 1)) {
					if($this->jsonGetContents($file->getPathname())) {
						$files[$file->getBasename($extension)] = $this->jsonGetContents($file->getPathname());
					}
					else {
						$files[] = $file->getBasename($extension);
					}
				}
			}

			return $files;
		}

		/**
		 * Lit un fichier .json
		 * @param $file string Le fichier à lire
		 * @return mixed Contenu du fichier ou false en cas d'erreur
		 */
		public function jsonGetContents($file)
		{
			return json_decode(file_get_contents($file), true);
		}

		/**
		 * Enregistre un tableau dans un fichier .json
		 * @param $file string Le fichier à enregistrer
		 * @param $data array Tableau à enregistrer
		 * @return mixed Nombre de bytes du fichier ou false en cas d'erreur
		 */
		public function jsonPutContents($file, array $data = [])
		{
			if(file_exists($file)) {
				unlink($file);
			}

			return file_put_contents($file, json_encode($data));
		}

		/**
		 * Crée la connexion entre les plugins et le système afin d'afficher le contenu de la page
		 * @return string Contenu de la page à afficher
		 */
		public function router()
		{
			$plugin = $this->getUrl(0);
			if(in_array($plugin, $this->getPlugins()) AND file_exists('plugins/' . $plugin . '.php')) {
				require 'plugins/' . $plugin . '.php';
				$plugin = new $plugin;
				if($plugin::$private AND $this->getCookie() !== $this->getData('settings', 'password')) {
					$plugin = new user;
					$plugin->login();
				}
				else {
					$method = method_exists($plugin, $this->getUrl(1)) ? $this->getUrl(1) : 'index';
					$plugin->$method();
				}
				$this->setTitle($plugin->getTitle());
				$this->setContent($plugin->getContent());
			}
			// Page d'erreur
			$this->setContent('<h2>' . $this->getTitle() . '</h2>' . $this->getContent());
		}

		/**
		 * Redirige vers un page du site ou uen page externe
		 * @param $url string Url de destination
		 * @param string|bool $suffix Ajoute ou non un suffixe à l'url
		 */
		public function redirect($url, $suffix = '?')
		{
			header('location:' . $suffix . $url);
			exit;
		}
	}
}

namespace helpers
{
	class tools {
		public static function filter($key, $data)
		{
			$search = explode(',', 'á,à,â,ä,ã,å,ç,é,è,ê,ë,í,ì,î,ï,ñ,ó,ò,ô,ö,õ,ú,ù,û,ü,ý,ÿ, ');
			$replace = explode(',', 'a,a,a,a,a,a,c,e,e,e,e,i,i,i,i,n,o,o,o,o,o,u,u,u,u,y,y,-');
			$key = str_replace($search, $replace, strtolower($key));
			$key = preg_replace('#[^a-z0-9-]#', '', $key);
			$i = 2;
			$newKey = $key;
			while(in_array($newKey, $data)) {
				$newKey = $key . '-' . $i;
				$i++;
			}
			return $key;
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
		public static function sprintAttributes(array $array = [], array $exclude = [])
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
		 * @param array $attributes Liste des attributs en fonction des attributs disponibles dans la méthode ($key => $value)
		 * @param array $options Liste des options du champ de sélection ($value => $str)
		 * @return string La balise et ses attributs au bon format
		 */
		public static function select($nameId, $options, array $attributes = [])
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
		public static function submit($nameId = 'submit', array $attributes = [])
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
}