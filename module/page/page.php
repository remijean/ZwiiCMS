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

class page extends common {

	public static $actions = [
		'add' => self::RANK_MODERATOR,
		'delete' => self::RANK_MODERATOR,
		'edit' => self::RANK_MODERATOR
	];
	public static $pagesNoParentId = [
		'' => 'Aucune'
	];
	public static $modulePositions = [
		'top' => 'Haut',
		'bottom' => 'Bas',
		'free' => 'Libre'
	];

	/**
	 * Création
	 */
	public function add() {
		$pageTitle = helper::translate('Nouvelle page');
		$pageId = helper::increment(helper::filter($pageTitle, helper::FILTER_ID), $this->getData(['page']));
		$this->setData([
			'page',
			$pageId,
			[
				'content' => helper::translate('Contenu de votre nouvelle page.'),
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'rank' => self::RANK_VISITOR,
				'targetBlank' => false,
				'title' => $pageTitle
			]
		]);
		return [
			'redirect' => $pageId,
			'notification' => 'Nouvelle page créée',
			'state' => true
		];
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// La page n'existe pas
		if($this->getData(['page', $this->getUrl(2)]) === null) {
			return [
				'access' => false
			];
		}
		// Impossible de supprimer la page d'accueil
		elseif($this->getUrl(2) === $this->getData(['config', 'homePageId'])) {
			return [
				'redirect' => 'page/edit/' . $this->getUrl(2),
				'notification' => 'Impossible de supprimer la page d\'accueil'
			];
		}
		// Impossible de supprimer une page contenant des enfants
		elseif(empty($this->getHierarchy($this->getUrl(2))) === false) {
			return [
				'redirect' => 'page/edit/' . $this->getUrl(2),
				'notification' => 'Impossible de supprimer une page contenant des enfants'
			];
		}
		// Suppression
		else {
			$this->deleteData(['page', $this->getUrl(2)]);
			return [
				'redirect' => '',
				'notification' => 'Page supprimée',
				'state' => true
			];
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// La page n'existe pas
		if($this->getData(['page', $this->getUrl(2)]) === null) {
			return [
				'access' => false
			];
		}
		// Soumission du formulaire
		elseif($this->isPost()) {
			$pageId = $this->getInput('pageEditTitle', helper::FILTER_ID) ? $this->getInput('pageEditTitle', helper::FILTER_ID) : $this->getUrl(2);
			// Si l'id a changée
			if($pageId !== $this->getUrl(2)) {
				// Incrémente la nouvelle id de la page pour éviter les doublons
				$pageId = helper::increment(helper::increment($pageId, $this->getData(['page'])), self::$coreModule);
				// Met à jour les enfants
				foreach($this->getHierarchy($this->getUrl(2)) as $childrenPageId) {
					$this->setData(['page', $childrenPageId, 'parentPageId', $pageId]);
				}
				// Supprime l'ancienne page
				$this->deleteData(['page', $this->getUrl(2)]);
				// Supprime les aciennes données du module et crée les nouvelles
				$this->setData(['module', $pageId, $this->getData([$this->getUrl(2)])]);
				$this->deleteData(['module', $this->getUrl(2)]);
				// Si la page correspond à la page d'accueil, change l'id dans la configuration du site
				if($this->getData(['config', 'homePageId']) === $this->getUrl(2)) {
					$this->setData(['config', 'homePageId', $pageId]);
				}
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
					'metaDescription' => $this->getInput('pageEditMetaDescription'),
					'metaTitle' => $this->getInput('pageEditMetaDescription'),
					'moduleId' => $this->getInput('pageEditModuleId'),
					'modulePosition' => $this->getInput('pageEditModulePosition'),
					'parentPageId' => $this->getInput('pageEditParentPageId'),
					'position' => $position,
					'rank' => $this->getInput('pageEditRank', helper::FILTER_INT),
					'targetBlank' => $this->getInput('pageEditTargetBlank', helper::FILTER_BOOLEAN),
					'title' => $this->getInput('pageEditTitle')
				]
			]);
			return [
				'redirect' => $pageId,
				'notification' => 'Modifications enregistrées',
				'state' => true
			];
		}
		// Affichage du template
		else {
			// Pages sans parent
			foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
				if($parentPageId !== $this->getUrl(2)) {
					self::$pagesNoParentId[$parentPageId] = $this->getData(['page', $parentPageId, 'title']);
				}
			}
			return [
				'title' => $this->getData(['page', $this->getUrl(2), 'title']),
				'vendor' => [
					'tinymce'
				],
				'view' => true
			];
		}
	}

}