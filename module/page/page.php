<?php

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
				'content' => helper::translate('Contenu de la page.'),
				'hideTitle' => false,
				'metaDescription' => '',
				'metaTitle' => '',
				'moduleId' => '',
				'modulePosition' => 'bottom',
				'parentPageId' => '',
				'position' => 0,
				'targetBlank' => false,
				'title' => $pageTitle
			]
		]);
		return [
			'redirect' => $pageId,
			'notification' => 'Page créée',
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
		// Soumission du formulaire
		if($this->isPost()) {
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
			// Actualise la positions des pages suivantes de même parent
			$position = $this->getInput('pageEditPosition', helper::FILTER_INT);
			$parentPageId = $this->getInput('pageEditParentPageId');
			if(
				// Si la position à changée
				$position !== $this->getData(['page', $this->getUrl(2), 'position'])
				// Ou le l'id du parent à changée
				OR $parentPageId !== $this->getData(['page', $this->getUrl(2), 'parentPageId'])
			) {
				// Si la page est une page enfant, actualise les positions des autres enfants du parent, sinon actualise les pages sans parents
				$lastPosition = 1;
				$hierarchy = $parentPageId ? $this->getHierarchy($parentPageId, false) : array_keys($this->getHierarchy(null, false));
				foreach($hierarchy as $hierarchyPageId) {
					// Ignore l'ancienne position de la page
					if($hierarchyPageId !== $this->getUrl(2)) {
						// Incrémente de +1 si la dernière position est égale à la nouvelle position de la page
						if($lastPosition === $position) {
							$lastPosition++;
						}
						// Change la position
						$this->setData(['page', $hierarchyPageId, 'position', $lastPosition]);
						// Incrémente pour la prochaine position
						$lastPosition++;
					}
				}
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
					'position' => $this->getInput('pageEditPosition', helper::FILTER_INT),
					'targetBlank' => $this->getInput('pageEditTargetBlank', helper::FILTER_BOOLEAN),
					'title' => $this->getInput('pageEditTitle')
				]
			]);
			// Supprime l'ancienne page lorsque l'id a changée
			if($pageId !== $this->getUrl(2)) {
				$this->deleteData(['page', $this->getUrl(2)]);
			}
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