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
		'config' => self::RANK_MODERATOR,
		'data' => self::RANK_MODERATOR,
		'index' => self::RANK_VISITOR
	];

	public static $data = [];

	public static $pages;

	public static $types = [
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
					'mail' => $this->getInput('formConfigMail', helper::FILTER_EMAIL),
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
				'redirect' => helper::baseUrl() . $this->getUrl(),
				'notification' => 'Modifications enregistrées',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration du module',
			'vendor' => [
				'jquery-ui'
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
			// Crée une pagination (retourne la première news et dernière news de la page et la liste des pages
			$pagination = helper::pagination($data, $this->getUrl());
			// Pages
			self::$pages = $pagination['pages'];
			// Inverse l'ordre du tableau pour afficher les données en ordre décroissant
			$inputs = array_reverse($data);
			// Crée l'affichage des données en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				$content = '';
				foreach($inputs[$i] as $input => $value) {
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
			// Préparation des données
			$data = [];
			$mail = '';
			foreach($this->getInput('formInput', null) as $index => $value) {
				// Erreur champ obligatoire
				$this->addRequiredInputNotices('formInput[' . $index . ']');
				// Préparation des données pour la création dans la base
				$data[$this->getData(['module', $this->getUrl(0), 'input', $index, 'name'])] = $value;
				// Préparation des données pour le mail
				$mail .= '<li>' . $this->getData(['module', $this->getUrl(0), 'input', $index, 'name']) . ' : ' . $value . '</li>';
			}
			// Crée les données
			$this->setData(['module', $this->getUrl(0), 'data', helper::increment(1, $this->getData(['module', $this->getUrl(0), 'data'])), $data]);
			// Envoi du mail
			if(self::$inputNotices === []) {
				if($this->getData(['module', $this->getUrl(0), 'config', 'mail'])) {
					if($this->getData(['module', $this->getUrl(0), 'config', 'subject'])) {
						$subject = $this->getData(['module', $this->getUrl(0), 'config', 'subject']);
					}
					else {
						$subject = helper::translate('Mail en provenance de votre site');
					}
					$sent = helper::mail(
						false,
						$this->getData(['module', $this->getUrl(0), 'config', 'mail']),
						$subject,
						'<h3>' . $subject . ' ' . helper::baseUrl() . $this->getUrl() . '</h3><ul>' . $mail . '</ul>'
					);
				}
			}
			// Notification en fonction du résultat
			if(isset($sent)) {
				$notification = 'Formulaire soumis';
			}
			else {
				$notification = 'Formulaire soumis, mais impossible d\'envoyer le mail';
			}
			// Valeurs en sortie
			$this->addOutput([
				'notification' => $notification,
				'redirect' => helper::baseUrl() . $this->getUrl(),
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