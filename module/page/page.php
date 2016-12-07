<?php

class page extends common {

	public static $actions = [
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
	 * Édition de page
	 */
	public function edit() {
		// Soumission du formulaire
		if($this->isPost()) {
			$pageId = $this->getInput('title') ? $this->getInput('title', helper::FILTER_URL_STRICT) : $this->getUrl(2);
			// Si l'id a changée²
			if($pageId !== $this->getUrl(2)) {
				// Incrémente la nouvelle clef de la page pour éviter les doublons
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
			$position = $this->getInput('position', helper::FILTER_INT);
			$parentPageId = $this->getInput('parentPageId');
			if(
				// Si la position à changée
				$position !== $this->getData(['page', $this->getUrl(0), 'position'])
				// Ou le l'id du parent à changée
				OR $parentPageId !== $this->getData(['page', $this->getUrl(0), 'parentPageId'])
			) {
				// Supérieur ou égale à 2 pour ignorer les options "Ne pas afficher" et "Au début"
				// Sinon incrémente de +1 lorsque la nouvelle position est supérieure à la position actuelle afin de prendre en compte la page courante qui n'appraît pas dans la liste
				if($position >= 2 AND $position >= $this->getData(['page', $this->getUrl(0), 'position'])) {
					$position++;
				}
				// Actualise les positions des pages enfant
				foreach($this->getHierarchy($parentPageId) as $index => $childPageId) {
					// Commence à 1 et non 0
					$index++;
					// Incrémente de +1 la position des pages suivantes
					if($index >= $position) {
						$index++;
					}
					// Change les positions
					$this->setData(['page', $childPageId, 'position', $index]);
				}
				// Si la page n'a pas de parent, actualise les positions des pages sans parents
				if(empty($parentPageId)) {
					foreach(array_keys($this->getHierarchy()) as $index => $parentPageId) {
						// Commence à 1 et non 0
						$index++;
						// Incrémente de +1 la position des pages suivants la page modifiée
						if($index >= $position AND $position !== 0) {
							$index++;
						}
						// Change les positions
						$this->setData(['page', $parentPageId, 'position', $index]);
					}
				}
			}
			// Modifie la page ou en crée une nouvelle si la clef à changée
			$this->setData([
				'page',
				$pageId,
				[

					'content' => $this->getInput('pageEditContent'),
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
			if($pageId !== $this->getUrl(0)) {
				$this->deleteData(['page', $this->getUrl(0)]);
			}
			// Enregistre les données
			$this->saveData();
			return [
				'redirect' => $pageId,
				'notification' => 'Page modifiée',
				'state' => true
			];
		}
		// Affichage du template
		else {
			// Pages sans parent
			foreach($this->getHierarchy() as $parentPageId => $childrenPageIds) {
				if($parentPageId !== $this->getUrl(0)) {
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