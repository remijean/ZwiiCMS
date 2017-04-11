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

class news extends common {

	public static $actions = [
		'add' => self::GROUP_MODERATOR,
		'config' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR
	];

	public static $news = [];

	public static $comments = [];

	public static $pages;

	public static $statuss = [
		false => 'Brouillon',
		true => 'Publié'
	];

	public static $users = [];

	/**
	 * Édition
	 */
	public function add() {
		// Soumission du formulaire
		if($this->isPost()) {
			// Crée la news
			$newsId = helper::increment($this->getInput('newsAddTitle', helper::FILTER_ID), (array) $this->getData(['module', $this->getUrl(0)]));
			$this->setData(['module', $this->getUrl(0), $newsId, [
				'content' => $this->getInput('newsAddContent', helper::FILTER_STRING_LONG),
				'publishedOn' => $this->getInput('newsAddPublishedOn', helper::FILTER_DATETIME, true),
				'status' => $this->getInput('newsEditStatus', helper::FILTER_BOOLEAN),
				'title' => $this->getInput('newsAddTitle', helper::FILTER_STRING_SHORT, true),
				'userId' => $this->getInput('newsAddUserId', helper::FILTER_ID, true)
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Nouvelle news créée',
				'state' => true
			]);
		}
		// Liste des utilisateurs
		self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
		ksort(self::$users);
		foreach(self::$users as $userId => &$userFirstname) {
			$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']);
		}
		unset($userFirstname);
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Nouvel news',
			'vendor' => [
				'flatpickr',
				'tinymce'
			],
			'view' => 'add'
		]);
	}

	/**
	 * Configuration
	 */
	public function config() {
		// Ids des news par ordre de publication
		$newsIds = array_keys(helper::arrayCollumn($this->getData(['module', $this->getUrl(0)]), 'publishedOn', 'SORT_DESC'));
		// Pagination
		$pagination = helper::pagination($newsIds, $this->getUrl());
		// Liste des pages
		self::$pages = $pagination['pages'];
		// News en fonction de la pagination
		for($i = $pagination['first']; $i < $pagination['last']; $i++) {
			// Met en forme le tableau
			self::$news[] = [
				$this->getData(['module', $this->getUrl(0), $newsIds[$i], 'title']),
				date('d/m/Y H:i', $this->getData(['module', $this->getUrl(0), $newsIds[$i], 'publishedOn'])),
				helper::translate(self::$statuss[$this->getData(['module', $this->getUrl(0), $newsIds[$i], 'status'])]),
				template::button('newsConfigEdit' . $newsIds[$i], [
					'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $newsIds[$i],
					'value' => template::ico('pencil')
				]),
				template::button('newsConfigDelete' . $newsIds[$i], [
					'class' => 'newsConfigDelete buttonRed',
					'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $newsIds[$i],
					'value' => template::ico('cancel')
				])
			];
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Configuration du module',
			'view' => 'config'
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La news n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Suppression
		else {
			$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'News supprimée',
				'state' => true
			]);
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// La news n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// La news existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Si l'id a changée
				$newsId = $this->getInput('newsEditTitle', helper::FILTER_ID, true);
				if($newsId !== $this->getUrl(2)) {
					// Incrémente la nouvelle id de la news pour éviter les doublons
					$newsId = helper::increment($newsId, $this->getData(['module', $this->getUrl(0)]));
					// Supprime l'ancien news
					$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
				}
				$this->setData(['module', $this->getUrl(0), $newsId, [
					'content' => $this->getInput('newsEditContent', helper::FILTER_STRING_LONG),
					'publishedOn' => $this->getInput('newsEditPublishedOn', helper::FILTER_DATETIME, true),
					'status' => $this->getInput('newsEditStatus', helper::FILTER_BOOLEAN),
					'title' => $this->getInput('newsEditTitle', helper::FILTER_STRING_SHORT, true),
					'userId' => $this->getInput('newsEditUserId', helper::FILTER_ID, true)
				]]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
					'notification' => 'Modifications enregistrées',
					'state' => true
				]);
			}
			// Liste des utilisateurs
			self::$users = helper::arrayCollumn($this->getData(['user']), 'firstname');
			ksort(self::$users);
			foreach(self::$users as $userId => &$userFirstname) {
				$userFirstname = $userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']);
			}
			unset($userFirstname);
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'title']),
				'vendor' => [
					'flatpickr',
					'tinymce'
				],
				'view' => 'edit'
			]);
		}
	}

	/**
	 * Accueil
	 */
	public function index() {
		// Ids des news par ordre de publication
		$newsIdsPublishedOns = helper::arrayCollumn($this->getData(['module', $this->getUrl(0)]), 'publishedOn', 'SORT_DESC');
		$newsIds = [];
		foreach($newsIdsPublishedOns as $newsId => $newsPublishedOn) {
			if($newsPublishedOn <= time()) {
				$newsIds[] = $newsId;
			}
		}
		// Pagination
		$pagination = helper::pagination($newsIds, $this->getUrl());
		// Liste des pages
		self::$pages = $pagination['pages'];
		// News en fonction de la pagination
		for($i = $pagination['first']; $i < $pagination['last']; $i++) {
			self::$news[$newsIds[$i]] = $this->getData(['module', $this->getUrl(0), $newsIds[$i]]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'editButton' => true,
			'pageContent' => true,
			'view' => 'index'
		]);
	}

}