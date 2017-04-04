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
		'index' => self::GROUP_VISITOR
	];

	public static $data = [];

	public static $pages = [];
	
	public static $pagination;

	public static $types = [
		'mail' => 'Champ mail',
		'text' => 'Champ texte',
		'textarea' => 'Grand champ texte',
		'select' => 'Sélection'
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
			// Vide les champs obligatoires
			unset($_SESSION['ZWII_INPUT_REQUIRED']);
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
			$data = array_reverse($data);
			// Données en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$content = '';
				foreach($data[$i] as $input => $value) {
					$content .= $input . ' : ' . $value . '<br>';
				}
				self::$data[] = [$content];
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Données enregistrées',
			'view' => 'data'
		]);
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
			foreach($this->getInput('formInput', null) as $index => $value) {
				// Filtre la valeur
				$value = helper::filter($value, helper::FILTER_STRING_LONG);
				// Erreur champ obligatoire
				$this->addRequiredInputNotices('formInput[' . $index . ']');
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
						$subject = helper::translate('Nouveau message en provenance de votre site');
					}
					// Envoi le mail
					$sent = $this->sendMail(
						$to,
						$subject,
						helper::translate('Nouveau message en provenance de la page') . ' "' . $this->getData(['page', $this->getUrl(0), 'title']) . '" :<br><br>' .
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
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'editButton' => true,
			'pageContent' => true,
			'view' => 'index'
		]);
	}

}