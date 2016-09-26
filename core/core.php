<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <moi@remijean.fr>
 * @copyright Copyright (C) 2008-2016, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class common {

	public $actions = [];
	private $data = [];
	private $hierarchy = [];
	private $input = [
		'_POST' => [],
		'_GET' => [],
		'_COOKIE' => []
	];
	private $url = '';

	const RANK_VISITOR = 0;
	const RANK_MEMBER = 1;
	const RANK_MODERATOR = 2;
	const RANK_ADMIN = 3;

	/**
	 * Constructeur en commun
	 */
	public function __construct() {
		// Import des données
		if(empty($this->data)) {
			$this->setData([json_decode(file_get_contents('data/data.json'), true)]);
		}
		// Construit la liste des pages parentes/enfants
		if(empty($this->hierarchy)) {
			$pages = helper::arrayCollumn($this->getData(['page']), 'position', 'SORT_ASC');
			foreach($pages as $pageId => $pagePosition) {
				// Page enfant
				if($parentId = $this->getData(['page', $pageId, 'parentId'])) {
					if(array_key_exists($pageId, $this->hierarchy) === false) {
						$this->hierarchy[$pageId] = [];
					}
					$this->hierarchy[$parentId][] = $pageId;
				}
				// Page parente (si pas déjà déclarée par une page enfant)
				elseif(array_key_exists($pageId, $this->hierarchy) === false){
					$this->hierarchy[$pageId] = [];
				}
			}
		}
		// Construit l'url
		if(empty($this->url)) {
			$this->url = $_SERVER['QUERY_STRING'];
		}
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
		$this->setData([json_decode(file_get_contents('data/data.json'), true)]);
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
			if(empty($data[$key])) {
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
	 * Accède à la liste des pages parentes et de leurs enfants ou aux enfants d'une page parente
	 * @param int $parentId Id de la page parente
	 * @return array
	 */
	public function getHierarchy($parentId = null) {
		// Enfants d'un parent
		if($parentId) {
			if(array_key_exists($parentId, $this->hierarchy)) {
				return $this->hierarchy[$parentId];
			}
			else {
				return [];
			}
		}
		// Parents et leurs enfants
		else {
			return $this->hierarchy;
		}
	}

	/**
	 * Accède à une valeur des variables http (ordre de recherche en l'absence de type : POST, GET, COOKIE)
	 * @param mixed $key Clé de la valeur
	 * @param mixed $type Type de la valeur
	 * @return mixed
	 */
	public function getInput($key, $type = null) {
		// Cherche et retourne la valeur demandée dans un type précis
		if($type AND isset($this->input[$type][$key])) {
			return $this->input[$type][$key];
		}
		// Cherche et retourne la valeur demandée
		foreach($this->input as $type => $values) {
			if(array_key_exists($key, $values)) {
				return $this->input[$type][$key];
			}
		}
		// Sinon retourne null
		return null;
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
			return isset($url[$key]) ? $url[$key] : null;
		}
	}

	/**
	 * Check qu'une valeur est transmise par la méthode _POST
	 * @return bool
	 */
	public function isPost() {
		return empty($this->input['_POST']) === false;
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

}

class core extends common {

	private static $coreModules = [
		'page',
		'user'
	];
	public static $language = [];
	public static $output = [
		'hash' => null,
		'notification' => '',
		'event' => false,
		'state' => false,
		'view' => ''
	];


	/**
	 * Auto-chargement des classes
	 * @param string $className Nom de la classe à charger
	 */
	public static function autoload($className) {
		$classPath = 'module/' . $className . '/' . $className . '.php';
		if(is_readable($classPath)) {
			require $classPath;
		}
	}

	/**
	 * Routage des modules
	 */
	public function router() {
		// Importe le layout au premier passage
		if($this->getUrl(0) === '') {
			require __DIR__ . '/layout.php';
			exit;
		}
		// Importe la page
		$pageView = '';
		$moduleId = $this->getUrl(0);
		if(array_key_exists($moduleId, $this->getData(['page']))) {
			// Contenu de la page
			$pageView =
				'<h1>' . $this->getData(['page', $this->getUrl(0), 'name']) . '</h1>' .
				$this->getData(['page', $this->getUrl(0), 'content']);
			// Module de la page
			$moduleId = $this->getData(['page', $this->getUrl(0), 'moduleId']);
		}
		// Importe le module
		$moduleView = '';
		$moduleEvent = '';
		if($moduleId) {
			$module = $moduleId;
			$module = new $module;
			// Éxecute l'action demandée en fonction du rang de l'utilisateur
			if(
				array_key_exists($this->getUrl(1), $module->actions)
				AND (
					$module->actions[$this->getUrl(1)] === 0
					OR (
						$this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE')])
						AND $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'password']) === $this->getInput('ZWII_USER_PASSWORD', '_COOKIE')
						AND $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= $module->actions[$this->getUrl(1)]
					)
				)
			) {
				// Fusionne les données de sortie du coeur avec celles de l'action demandée
				self::$output = $module->{$this->getUrl(1)}() + self::$output;
				// Importe la vue de l'action
				if(self::$output['view']) {
					$viewPath = __DIR__ . '/../module/' . $moduleId . '/view/' . $this->getUrl(1) . '.php';
					if(file_exists($viewPath)) {
						ob_start();
						include $viewPath;
						$moduleView = ob_get_clean();
					}
				}
				// Importe l'événement de l'action
				if(self::$output['event']) {
					$viewPath = __DIR__ . '/../module/' . $moduleId . '/event/' . $this->getUrl(1) . '.js';
					if(file_exists($viewPath)) {
						ob_start();
						include $viewPath;
						$moduleEvent = '<script>' . ob_get_clean() . '</script>';
					}
				}
			}
			// Si le rang est insuffisant, redirection sur l'interface de connexion
			else {
				self::$output['hash'] = '#user/login/' . $this->getUrl();
			}
		}
		// Met en forme la vue
		self::$output['view'] = $pageView . $moduleView . $moduleEvent;
		// Encode la sortie en JSON
		echo json_encode(self::$output);
	}

}

class helper {

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
	 * Supprime un cookie
	 * @param string $cookieKey Clé du cookie à supprimer
	 */
	public static function deleteCookie($cookieKey) {
		unset($_COOKIE[$cookieKey]);
		setcookie($cookieKey, '', time() - 3600);
	}

	/**
	 * Incrémente une id en fonction des clés d'un tableau
	 * @param mixed $id Id à incrémenter
	 * @param array $array Tableau à vérifier
	 * @return string
	 */
	public static function incrementId($id, $array) {
		// Si l'id est numérique elle est incrémentée
		if(is_numeric($id)) {
			$newId = $id;
			while(array_key_exists($newId, $array) OR in_array($newId, $array)) {
				$newId++;
			}
		}
		// Sinon l'incrémentation est ajoutée après l'id
		else {
			$i = 2;
			$newId = $id;
			while(array_key_exists($newId, $array) OR in_array($newId, $array)) {
				$newId = $id . '-' . $i;
				$i++;
			}
		}
		return $newId;
	}

	/**
	 * Retourne les attributs d'un champ au bon format
	 * @param array $array Liste des attributs ($key => $value)
	 * @param array $exclude Clés à ignorer ($key)
	 * @return string
	 */
	public static function sprintAttributes(array $array = [], array $exclude = []) {
		$exclude = array_merge(['label', 'help', 'selected'], $exclude);
		$attributes = [];
		foreach($array as $key => $value) {
			if($value AND in_array($key, $exclude) === false) {
				// Attributs à traduire
				if(in_array($key, ['placeholder'])) {
					$attributes[] = sprintf('%s="%s"', $key, self::translate($value));
				}
				// Attributs simples
				else {
					$attributes[] = sprintf('%s="%s"', $key, $value);
				}
			}
		}
		return implode(' ', $attributes);
	}

	/**
	 * Traduit du texte
	 * @param string $text Texte à traduire
	 * @return string
	 */
	public static function translate($text) {
		if(array_key_exists((string) $text, core::$language)) {
			$text = core::$language[$text];
		}
		return $text;
	}

}

class layout extends common {
	
	/**
	 * Génère le lien de connexion
	 * @return string
	 */
	public function loginLink() {
		$class = '';
		if(
			$this->getUrl(1) === 'login'
			OR $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE')])
		) {
			$class = 'displayNone';
		}
		return '<a id="loginLink" href="" class="' . $class . '">Connexion</a>';
	}

	/**
	 * Génère le lien de déconnexion
	 * @return string
	 */
	public function logoutLink() {
		$class = '';
		if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE')]) === null) {
			$class = 'displayNone';
		}
		return '<a id="logoutLink" href="" class="' . $class . '">Déconnexion</a>';
	}

	/**
	 * Génère le menu
	 * @return string
	 */
	public function menu() {
		$items = '';
		foreach($this->getHierarchy() as $parentId => $childIds) {
			$items .= '<li><a href="#' . $parentId . '">' . $this->getData(['page', $parentId, 'name']) . '</a><ul>';
			foreach($childIds as $childId) {
				$items .= '<li><a href="#' . $childId . '">' . $this->getData(['page', $childId, 'name']) . '</a></li>';
			}
			$items .= '</ul></li>';
		}
		return '<ul>' . $items . '</ul>';
	}

}

class form {

	############################################################
	# INITIALISATION DU FORMULAIRE

	/**
	 * Ouvre le formulaire
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function __construct($nameId, $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'action' => '',
			'method' => 'post',
			'enctype' => '',
			'class' => ''
		], $attributes);
		// Retourne le html
		echo sprintf('<form %s>', helper::sprintAttributes($attributes));
	}

	/**
	 * Ferme le formulaire
	 * @echo string
	 */
	public function close() {
		echo '</form>';
	}

	############################################################
	# CHAMPS DU FORMULAIRE

	/**
	 * Crée un bouton
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function button($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => 'Enregistrer',
			'disabled' => false,
			'class' => '',
			'type' => 'button'
		], $attributes);
		// Retourne le html
		echo sprintf(
			'<button %s>%s</button>',
			helper::sprintAttributes($attributes, ['value']),
			helper::translate($attributes['value'])
		);
	}

	/**
	 * Crée un champ capcha
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function capcha($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'required' => true,
			'help' => '',
			'class' => ''
		], $attributes);
		// Génère deux nombres pour le capcha
		$firstNumber = mt_rand(1, 15);
		$secondNumber = mt_rand(1, 15);
		// Label
		$html = self::label($attributes['id'], helper::translate('Quelle est la somme de') . ' ' . $firstNumber . ' + ' . $secondNumber . ' ?', [
			'help' => $attributes['help']
		]);
		// Capcha
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Champs cachés contenant les nombres
		$html .= self::input($nameId . 'FirstNumber', [
			'type' => 'hidden',
			'value' => $firstNumber,
			'before' => false
		]);
		$html .= self::input($nameId . 'SecondNumber', [
			'type' => 'hidden',
			'value' => $secondNumber,
			'before' => false
		]);
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée une case à cocher à sélection multiple
	 * @param string $nameId Nom et id
	 * @param string $value Valeur
	 * @param string $label Label
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function checkbox($nameId, $value, $label, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'checked' => '',
			'disabled' => false,
			'required' => false,
			'help' => '',
			'class' => ''
		], $attributes);
		// Case à cocher
		$html = sprintf(
			'<input type="checkbox" value="%s" %s>',
			$value,
			helper::sprintAttributes($attributes)
		);
		// Label
		$html .= self::label($attributes['id'], $label, [
			'help' => $attributes['help']
		]);
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée un champ d'upload de fichier
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function file($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => false,
			'required' => false,
			'label' => '',
			'help' => '',
			'class' => ''
		], $attributes);
		// Label
		$html = '';
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Texte
		$html .= sprintf(
			'<label class="inputFile %s">' . self::ico('download') . '<span class="inputFileLabel">' . helper::translate('Choisissez un fichier') . '</span><input type="file" %s></label>',
			$attributes['class'],
			helper::sprintAttributes($attributes, ['class'])
		);
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée une aide qui s'affiche au survole
	 * @param string $text Texte de l'aide
	 */
	public function help($text) {
		echo '<span class="helpButton">' . self::ico('help') . '<div class="helpContent">' . helper::translate($text) . '</div></span>';
	}

	/**
	 * Crée un icône
	 * @param string $ico Nom de l'icône à ajouter
	 * @param bool $margin Ajoute un margin à droite de l'icône
	 */
	public function ico($ico, $margin = false) {
		echo '<span class="zwiico-' . $ico . ($margin ? ' zwiico-margin' : '') . '"></span>';
	}

	/**
	 * Crée un label
	 * @param string $for For
	 * @param array $attributes Définition des attributs ($key => $value)
	 * @param string $text Texte
	 */
	public function label($for, $text, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'for' => $for,
			'help' => '',
			'class' => ''
		], $attributes);
		// Traduit le text
		$text = helper::translate($text);
		// Ajout d'une aide
		if(empty($attributes['help']) === false) {
			$text = $text . self::help($attributes['help']);
		}
		// Retourne le html
		echo sprintf(
			'<label %s>%s</label>',
			helper::sprintAttributes($attributes),
			$text
		);
	}

	/**
	 * Crée un champ sélection
	 * @param string $nameId Nom et id
	 * @param array $options Liste des options ($value => $text)
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function select($nameId, array $options, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'selected' => '',
			'disabled' => false,
			'required' => false,
			'label' => '',
			'help' => '',
			'class' => ''
		], $attributes);
		// Label
		$html = '';
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
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
				$attributes['selected'] === $value ? ' selected' : '',
				helper::translate($text)
			);
		}
		// Fin sélection
		$html .= '</select>';
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée un tableau
	 * @param array $cols Cols des colonnes (format: [col colonne1, col colonne2, col colonne3, etc])
	 * @param array $body Contenu des colonnes (format: [[contenu1, contenu2, contenu3, etc], [contenu1, contenu2, contenu3, etc]])
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function table(array $cols = [], array $body = [], array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'class' => ''
		], $attributes);
		// Début tableau
		$html = '<table class="' . $attributes['class']. '">';
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
		// Fin tableau
		$html .= '</table>';
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée un input
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function input($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'placeholder' => '',
			'disabled' => false,
			'readonly' => '',
			'required' => false,
			'label' => '',
			'help' => '',
			'class' => '',
			'type' => 'text'
		], $attributes);
		// Label
		$html = '';
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Texte
		$html .= sprintf(
			'<input type="text" %s>',
			helper::sprintAttributes($attributes)
		);
		// Retourne le html
		echo $html;
	}

	/**
	 * Crée un champ texte long
	 * @param string $nameId Nom et id
	 * @param array $attributes Définition des attributs ($key => $value)
	 */
	public function textarea($nameId, array $attributes = []) {
		// Attributs par défaut
		$attributes = array_merge([
			'id' => $nameId,
			'name' => $nameId,
			'value' => '',
			'disabled' => false,
			'readonly' => '',
			'required' => false,
			'label' => '',
			'help' => '',
			'editor' => false,
			'class' => ''
		], $attributes);
		// Label
		$html = '';
		if($attributes['label']) {
			$html .= self::label($attributes['id'], $attributes['label'], [
				'help' => $attributes['help']
			]);
		}
		// Texte long
		$html .= sprintf(
			'<textarea %s>%s</textarea>',
			helper::sprintAttributes($attributes, ['value', 'editor']),
			$attributes['value']
		);
		// Retourne le html
		echo $html;
	}

}