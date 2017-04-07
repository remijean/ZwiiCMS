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

class blog extends common {

	public static $actions = [
		'add' => self::GROUP_MODERATOR,
		'config' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_MODERATOR,
		'index' => self::GROUP_VISITOR
	];

	public static $articles = [];

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
			// Crée l'article
			$articleId = helper::increment($this->getInput('blogAddTitle', helper::FILTER_ID), (array) $this->getData(['module', $this->getUrl(0)]));
			$this->setData(['module', $this->getUrl(0), $articleId, [
				'closeComment' => $this->getInput('blogAddCloseComment', helper::FILTER_BOOLEAN),
				'comment' => [],
				'content' => $this->getInput('blogAddContent', helper::FILTER_STRING_LONG),
				'picture' => $this->getInput('blogAddPicture', helper::FILTER_STRING_SHORT, true),
				'publishedOn' => $this->getInput('blogAddPublishedOn', helper::FILTER_DATETIME, true),
				'status' => $this->getInput('blogAddStatus', helper::FILTER_BOOLEAN),
				'tag' => [],
				'title' => $this->getInput('blogAddTitle', helper::FILTER_STRING_SHORT, true),
				'userId' => $this->getInput('blogAddUserId', helper::FILTER_ID, true)
			]]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'notification' => 'Nouvel article créé',
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
			'title' => 'Nouvel article',
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
		// Ids des articles par ordre de publication
		$articleIds = array_keys(helper::arrayCollumn($this->getData(['module', $this->getUrl(0)]), 'publishedOn', 'SORT_DESC'));
		// Pagination
		$pagination = helper::pagination($articleIds, $this->getUrl());
		// Liste des pages
		self::$pages = $pagination['pages'];
		// Articles en fonction de la pagination
		for($i = $pagination['first']; $i < $pagination['last']; $i++) {
			// Met en forme le tableau
			self::$articles[] = [
				$this->getData(['module', $this->getUrl(0), $articleIds[$i], 'title']),
				date('d/m/Y H:i', $this->getData(['module', $this->getUrl(0), $articleIds[$i], 'publishedOn'])),
				helper::translate(self::$statuss[$this->getData(['module', $this->getUrl(0), $articleIds[$i], 'status'])]),
				template::button('blogConfigEdit' . $articleIds[$i], [
					'href' => helper::baseUrl() . $this->getUrl(0) . '/edit/' . $articleIds[$i],
					'value' => template::ico('pencil')
				]),
				template::button('blogConfigDelete' . $articleIds[$i], [
					'class' => 'blogConfigDelete buttonRed',
					'href' => helper::baseUrl() . $this->getUrl(0) . '/delete/' . $articleIds[$i],
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
		// L'article n'existe pas
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
				'notification' => 'Article supprimé',
				'state' => true
			]);
		}
	}

	/**
	 * Liste des dossiers
	 */
	public function dirs() {
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_JSON,
			'content' => galleriesHelper::scanDir('site/file/source')
		]);
	}

	/**
	 * Édition
	 */
	public function edit() {
		// L'article n'existe pas
		if($this->getData(['module', $this->getUrl(0), $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// L'article existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Si l'id a changée
				$id = $this->getInput('blogEditTitle', helper::FILTER_ID, true);
				if($id !== $this->getUrl(2)) {
					// Incrémente la nouvelle id de l'article pour éviter les doublons
					$articleId = helper::increment($id, $this->getData(['module', $this->getUrl(0)]));
					// Supprime l'ancien article
					$this->deleteData(['module', $this->getUrl(0), $this->getUrl(2)]);
				}
				$this->setData(['module', $this->getUrl(0), $id, [
					'closeComment' => $this->getInput('blogEditCloseComment'),
					'comment' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'comment']),
					'content' => $this->getInput('blogEditContent', helper::FILTER_STRING_LONG),
					'picture' => $this->getInput('blogEditPicture', helper::FILTER_STRING_SHORT, true),
					'publishedOn' => $this->getInput('blogEditPublishedOn', helper::FILTER_DATETIME, true),
					'status' => $this->getInput('blogEditStatus', helper::FILTER_BOOLEAN),
					'tag' => [],
					'title' => $this->getInput('blogEditTitle', helper::FILTER_STRING_SHORT, true),
					'userId' => $this->getInput('blogEditUserId', helper::FILTER_ID, true)
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
	 * Accueil (deux affichages en un pour éviter une url à rallonge)
	 */
	public function index() {
		// Affichage d'un article
		if($this->getUrl(1)) {
			// L'article n'existe pas
			if($this->getData(['module', $this->getUrl(0), $this->getUrl(1)]) === null) {
				// Valeurs en sortie
				$this->addOutput([
					'access' => false
				]);
			}
			// L'article existe
			else {
				// Soumission du formulaire
				if($this->isPost()) {
					// Check la capcha
					if(
						$this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD')
						AND $this->getInput('blogArticleCapcha', helper::FILTER_INT) !== $this->getInput('blogArticleCapchaFirstNumber', helper::FILTER_INT) + $this->getInput('blogArticleCapchaSecondNumber', helper::FILTER_INT))
					{
						self::$inputNotices['blogArticleCapcha'] = 'Incorrect';
					}
					// Crée le commentaire
					$commentId = helper::increment(uniqid(), $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'comment']));
					$this->setData(['module', $this->getUrl(0), $this->getUrl(1), 'comment', $commentId, [
						'author' => $this->getInput('blogArticleAuthor', helper::FILTER_STRING_SHORT, true),
						'content' =>  $this->getInput('blogArticleContent', helper::FILTER_STRING_SHORT, true),
						'createdOn' => time(),
						'userId' => $this->getInput('blogArticleUserId'),
					]]);
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $this->getUrl() . '#comment',
						'notification' => 'Commentaire ajouté',
						'state' => true
					]);
				}
				// Ids des commentaires par ordre de publication
				$commentIds = array_keys(helper::arrayCollumn($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'comment']), 'createdOn', 'SORT_DESC'));
				// Pagination
				$pagination = helper::pagination($commentIds, $this->getUrl(), '#comment');
				// Liste des pages
				self::$pages = $pagination['pages'];
				// Commentaires en fonction de la pagination
				for($i = $pagination['first']; $i < $pagination['last']; $i++) {
					self::$comments[$commentIds[$i]] = $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'comment', $commentIds[$i]]);
				}
				// Valeurs en sortie
				$this->addOutput([
					'editButton' => true,
					'title' => $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'title']),
					'view' => 'article'
				]);
			}

		}
		// Liste des articles
		else {
			// Ids des articles par ordre de publication
			$articleIdsPublishedOns = helper::arrayCollumn($this->getData(['module', $this->getUrl(0)]), 'publishedOn', 'SORT_DESC');
			$articleIds = [];
			foreach($articleIdsPublishedOns as $articleId => $articlePublishedOn) {
				if($articlePublishedOn <= time()) {
					$articleIds[] = $articleId;
				}
			}
			// Pagination
			$pagination = helper::pagination($articleIds, $this->getUrl());
			// Liste des pages
			self::$pages = $pagination['pages'];
			// Articles en fonction de la pagination
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$articles[$articleIds[$i]] = $this->getData(['module', $this->getUrl(0), $articleIds[$i]]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'editButton' => true,
				'pageContent' => true,
				'view' => 'index'
			]);
		}
	}

}