<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class page extends common {

	public static $actions = [
		'add' => self::GROUP_MODERATOR,
		'delete' => self::GROUP_MODERATOR,
		'edit' => self::GROUP_MODERATOR
	];
	public static $pagesNoParentId = [
		'' => 'Aucune'
	];
	public static $moduleIds = [];

	/**
	 * Création
	 */
	public function add() {
		$pageTitle = 'Nouvelle page';
		$pageId = helper::increment(helper::filter($pageTitle, helper::FILTER_ID), $this->getData(['page']));
		$this->setData([
			'page',
			$pageId,
			[
				'content' => 'Contenu de votre nouvelle page.',
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'parentPageId' => '',
				'position' => 0,
				'group' => self::GROUP_VISITOR,
				'targetBlank' => false,
				'title' => $pageTitle
			]
		]);
		// Valeurs en sortie
		$this->addOutput([
			'redirect' => helper::baseUrl() . $pageId,
			'notification' => 'Nouvelle page créée',
			'state' => true
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La page n'existe pas
		if($this->getData(['page', $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Impossible de supprimer la page d'accueil
		elseif($this->getUrl(2) === $this->getData(['config', 'homePageId'])) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'page/edit/' . $this->getUrl(2),
				'notification' => 'Impossible de supprimer la page d\'accueil'
			]);
		}
		// Impossible de supprimer une page contenant des enfants
		elseif($this->getHierarchy($this->getUrl(2))) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'page/edit/' . $this->getUrl(2),
				'notification' => 'Impossible de supprimer une page contenant des enfants'
			]);
		}
		// Suppression
		else {
			$this->deleteData(['page', $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl(false),
				'notification' => 'Page supprimée',
				'state' => true
			]);
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// La page n'existe pas
		if($this->getData(['page', $this->getUrl(2)]) === null) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// La page existe
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				$pageId = $this->getInput('pageEditTitle', helper::FILTER_ID, true);
				// Si l'id a changée
				if($pageId !== $this->getUrl(2)) {
					// Incrémente le nouvel id de la page
					$pageId = helper::increment($pageId, $this->getData(['page']));
					$pageId = helper::increment($pageId, self::$coreModuleIds);
					$pageId = helper::increment($pageId, self::$moduleIds);
					// Met à jour les enfants
					foreach($this->getHierarchy($this->getUrl(2)) as $childrenPageId) {
						$this->setData(['page', $childrenPageId, 'parentPageId', $pageId]);
					}
					// Change l'id de page dans les données des modules
					$this->setData(['module', $pageId, $this->getData(['module', $this->getUrl(2)])]);
					$this->deleteData(['module', $this->getUrl(2)]);
					// Si la page correspond à la page d'accueil, change l'id dans la configuration du site
					if($this->getData(['config', 'homePageId']) === $this->getUrl(2)) {
						$this->setData(['config', 'homePageId', $pageId]);
					}
				}
				// Supprime les données du module en cas de changement de module
				if($this->getInput('pageEditModuleId') !== $this->getData(['page', $this->getUrl(2), 'moduleId'])) {
					$this->deleteData(['module', $pageId]);
				}
				// Supprime l'ancienne page si l'id a changée
				if($pageId !== $this->getUrl(2)) {
					$this->deleteData(['page', $this->getUrl(2)]);
				}
				// Si la page est une page enfant, actualise les positions des autres enfants du parent, sinon actualise les pages sans parents
				$lastPosition = 1;
				$hierarchy = $this->getInput('pageEditParentPageId') ? $this->getHierarchy($this->getInput('pageEditParentPageId')) : array_keys($this->getHierarchy());
				$position = $this->getInput('pageEditPosition', helper::FILTER_INT);
				foreach($hierarchy as $hierarchyPageId) {
					// Ignore la page en cours de modification
					if($hierarchyPageId === $this->getUrl(2)) {
						continue;
					}
					// Incrémente de +1 pour laisser la place à la position de la page en cours de modification
					if($lastPosition === $position) {
						$lastPosition++;
					}
					// Change la position
					$this->setData(['page', $hierarchyPageId, 'position', $lastPosition]);
					// Incrémente pour la prochaine position
					$lastPosition++;
				}
				// Modifie la page ou en crée une nouvelle si l'id à changée
				$this->setData([
					'page',
					$pageId,
					[
						'content' => $this->getInput('pageEditContent', null),
						'hideTitle' => $this->getInput('pageEditHideTitle', helper::FILTER_BOOLEAN),
						'metaDescription' => $this->getInput('pageEditMetaDescription', helper::FILTER_STRING_LONG),
						'metaTitle' => $this->getInput('pageEditMetaTitle'),
						'moduleId' => $this->getInput('pageEditModuleId'),
						'parentPageId' => $this->getInput('pageEditParentPageId'),
						'position' => $position,
						'group' => $this->getInput('pageEditGroup', helper::FILTER_INT),
						'targetBlank' => $this->getInput('pageEditTargetBlank', helper::FILTER_BOOLEAN),
						'title' => $this->getInput('pageEditTitle', helper::FILTER_STRING_SHORT, true)
					]
				]);
				// Redirection vers la configuration
				if($this->getInput('pageEditModuleRedirect', helper::FILTER_BOOLEAN)) {
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $pageId . '/config',
						'state' => true
					]);
				}
				// Redirection vers la page
				else {
					// Valeurs en sortie
					$this->addOutput([
						'redirect' => helper::baseUrl() . $pageId,
						'notification' => 'Modifications enregistrées',
						'state' => true
					]);
				}
			}
			// Liste des modules
			$moduleIds = [
				'' => 'Aucun'
			];
			$iterator = new DirectoryIterator('module/');
			foreach($iterator as $fileInfos) {
				if(is_file($fileInfos->getPathname() . '/' . $fileInfos->getFilename() . '.php')) {
					$moduleIds[$fileInfos->getBasename()] = ucfirst($fileInfos->getBasename());
				}
			}
			self::$moduleIds = $moduleIds;
			// Pages sans parent
			foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
				if($parentPageId !== $this->getUrl(2)) {
					self::$pagesNoParentId[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['page', $this->getUrl(2), 'title']),
				'vendor' => [
					'tinymce'
				],
				'view' => 'edit'
			]);
		}
	}

}