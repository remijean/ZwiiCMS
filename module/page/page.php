<?php

class page extends common {

	public $actions = [
		'add' => self::RANK_MODERATOR,
		'delete' => self::RANK_MODERATOR,
		'edit' => self::RANK_MODERATOR
	];

	/**
	 * Création
	 */
	public function add() {
		// Soumission du formulaire
		if($this->isPost()) {
			$pageId = helper::incrementId('nouvelle-page', $this->getData(['page']));
			$this->setData([
				'page',
				$pageId,
				[
					'content' => $this->getInput('pageContent'),
					'name' => $this->getInput('pageName')
				]
			]);
			return [
				'hash' => '#' . $pageId,
				'notification' => 'Page créée avec succès'
			];
		}
		// Affichage du template
		else {
			return [
				'view' => true
			];
		}
	}

	/**
	 * Suppression
	 */
	public function delete() {
		if($this->getData(['page', $this->getUrl(2)])) {
			$this->deleteData(['page', $this->getUrl(2)]);
			return [
				'hash' => '#',
				'notification' => 'Page supprimée avec succès'
			];
		}
		else {
			return [
				'notification' => 'Page introuvable',
				'state' => false
			];
		}
	}

	/**
	 * Edition
	 */
	public function edit() {
		if($this->getData(['page', $this->getUrl(2)])) {
			// Soumission du formulaire
			if($this->isPost()) {
				if($this->getData(['page', $this->getUrl(2), 'name']) !== $this->getInput('pageName')) {
					$newId = helper::incrementId($this->getUrl(2), $this->getData(['page']));
				}
				else {
					$newId = $this->getUrl(2);
				}
				$this->setData([
					'page',
					$newId,
					[
						'content' => $this->getInput('pageContent'),
						'name' => $this->getInput('pageName')
					]
				]);
				return [
					'hash' => '#' . $newId,
					'notification' => 'Page modifiée avec succès'
				];
			}
			// Affichage du template
			else {
				return [
					'view' => true
				];
			}
		}
		else {
			return [
				'notification' => 'Page introuvable',
				'state' => false
			];
		}
	}

}