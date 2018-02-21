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

class form extends common {

	public static $actions = [
		'config' => self::GROUP_MODERATOR,
		'data' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR
	];

	public static $data = [];

	public static $pages = [];
	
	public static $pagination;

	const TYPE_MAIL = 'mail';
	const TYPE_SELECT = 'select';
	const TYPE_TEXT = 'text';
	const TYPE_TEXTAREA = 'textarea';

	public static $types = [
		self::TYPE_TEXT => 'Champ texte',
		self::TYPE_TEXTAREA => 'Grand champ texte',
		self::TYPE_MAIL => 'Champ mail',
		self::TYPE_SELECT => 'Sélection'
	];

	/**
	 * Configuration
	 */
	public function config() {
		// Soumission du formulaire
		if($this->isPost()) {
			// Configuration
			$this->setData([
				'module',
				$this->getUrl(0),
				'config',
				[
					'button' => $this->getInput('formConfigButton'),
					'capcha' => $this->getInput('formConfigCapcha', helper::FILTER_BOOLEAN),
					'group' => $this->getInput('formConfigGroup', helper::FILTER_INT),
					'pageId' => $this->getInput('formConfigPageId', helper::FILTER_ID),
					'subject' => $this->getInput('formConfigSubject')
				]
			]);
			// Génération des champs
			$inputs = [];
			foreach($this->getInput('formConfigPosition', null) as $index => $position) {
				$inputs[] = [
					'name' => $this->getInput('formConfigName[' . $index . ']'),
					'position' => helper::filter($position, helper::FILTER_INT),
					'required' => $this->getInput('formConfigRequired[' . $index . ']', helper::FILTER_BOOLEAN),
					'type' => $this->getInput('formConfigType[' . $index . ']'),
					'values' => $this->getInput('formConfigValues[' . $index . ']')
				];
			}
			$this->setData(['module', $this->getUrl(0), 'input', $inputs]);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => 'Modifications enregistrées',
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'state' => true
			]);
		}
		// Liste des pages
		foreach($this->getHierarchy(null, false) as $parentPageId => $childrenPageIds) {
			self::$pages[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
			foreach($childrenPageIds as $childKey) {
				self::$pages[$childKey] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->getData(['page', $childKey, 'title']);
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration du module',
			'vendor' => [
				'html-sortable'
			],
			'view' => 'config'
		]);
	}

	/**
	 * Données enregistrées
	 */
	public function data() {
		$data = $this->getData(['module', $this->getUrl(0), 'data']);
		if($data) {
			// Pagination
			$pagination = helper::pagination($data, $this->getUrl());
			// Liste des pages
			self::$pagination = $pagination['pages'];
			// Inverse l'ordre du tableau
			$dataIds = array_reverse(array_keys($data));
			$data = array_reverse($data);
			// Données en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$content = '';
				foreach($data[$i] as $input => $value) {
					$content .= $input . ' : ' . $value . '<br>';
				}
				self::$data[] = [
					$content,
					template::button('formDataDelete' . $dataIds[$i], [
						'class' => 'formDataDelete buttonRed',
						'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $dataIds[$i],
						'value' => template::ico('cancel')
					])
				];
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Données enregistrées',
			'view' => 'data'
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La donnée n'existe pas
		if($this->getData(['module', $this->getUrl(0), 'data', $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), 'data', $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/data',
				'notification' => 'Donnée supprimée',
				'state' => true
			]);
		}
	}

	/**
	 * Accueil
	 */
	public function index() {
		// Soumission du formulaire
		if($this->isPost()) {
			// Check la capcha
			if(
				$this->getData(['module', $this->getUrl(0), 'config', 'capcha'])
				AND $this->getInput('formCapcha', helper::FILTER_INT) !== $this->getInput('formCapchaFirstNumber', helper::FILTER_INT) + $this->getInput('formCapchaSecondNumber', helper::FILTER_INT))
			{
				self::$inputNotices['formCapcha'] = 'Incorrect';
			}
			// Préparation le contenu du mail
			$data = [];
			$content = '';
			foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input) {
				// Filtre la valeur
				switch($input['type']) {
					case self::TYPE_MAIL:
						$filter = helper::FILTER_MAIL;
						break;
					case self::TYPE_TEXTAREA:
						$filter = helper::FILTER_STRING_LONG;
						break;
					default:
						$filter = helper::FILTER_STRING_SHORT;
				}
				$value = $this->getInput('formInput[' . $index . ']', $filter, $input['required']);
				// Préparation des données pour la création dans la base
				$data[$this->getData(['module', $this->getUrl(0), 'input', $index, 'name'])] = $value;
				// Préparation des données pour le mail
				$content .= '<strong>' . $this->getData(['module', $this->getUrl(0), 'input', $index, 'name']) . ' :</strong> ' . $value . '<br>';
			}
			// Crée les données
			$this->setData(['module', $this->getUrl(0), 'data', helper::increment(1, $this->getData(['module', $this->getUrl(0), 'data'])), $data]);
			// Envoi du mail
			$sent = true;
			if(
				self::$inputNotices === []
				AND $group = $this->getData(['module', $this->getUrl(0), 'config', 'group'])
			) {
				// Utilisateurs dans le groupe
				$to = [];
				foreach($this->getData(['user']) as $userId => $user) {
					if($user['group'] === $group) {
						$to[] = $user['mail'];
					}
				}
				if($to) {
					// Sujet du mail
					$subject = $this->getData(['module', $this->getUrl(0), 'config', 'subject']);
					if($subject === '') {
						$subject = 'Nouveau message en provenance de votre site';
					}
					// Envoi le mail
					$sent = $this->sendMail(
						$to,
						$subject,
						'Nouveau message en provenance de la page "' . $this->getData(['page', $this->getUrl(0), 'title']) . '" :<br><br>' .
						$content
					);
				}
			}
			// Redirection
			$redirect = $this->getData(['module', $this->getUrl(0), 'config', 'pageId']);
			// Valeurs en sortie
			$this->addOutput([
				'notification' => ($sent === true ? 'Formulaire soumis' : $sent),
				'redirect' => $redirect ? helper::baseUrl() . $redirect : '',
				'state' => ($sent === true ? true : null)
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'showBarEditButton' => true,
			'showPageContent' => true,
			'view' => 'index'
		]);
	}

}