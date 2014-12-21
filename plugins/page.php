<?php

/*
	Copyright (C) 2008-2015, Rémi Jean (remi-jean@outlook.com)
	<http://zwiicms.com/>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General License for more details.

	You should have received a copy of the GNU General License
	along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

class page extends core
{
	/**
	 * Fichier de données
	 */
	private static $data = 'core/data/pages.json';

	/**
	 * Colonnes du fichier de données
	 */
	private $title = 'Nouvelle page';
	private $position = 0;
	private $blank = false;
	private $link = '';
	private $content = '';

	/**
	 * @return bool
	 */
	public function index()
	{
		// Erreur
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		// Page externe
		elseif($this->getData('pages', $this->getUrl(1), 'link')) {
			$this->redirect($this->getData('pages', $this->getUrl(1), 'link'));
		}
		// Page
		else {
			$this->setTitle($this->getData('pages', $this->getUrl(1), 'title'));
			$this->setContent($this->getData('pages', $this->getUrl(1), 'content'));
		}

		return true;
	}

	/**
	 * PAGE : Ajout de page
	 */
	public function add()
	{
		self::$private = true;

		$key = helpers\tools::filter($this->title, $this->getData('pages'));
		$this->setData('pages', $key, [
			'title' => $this->title,
			'position' => $this->position,
			'blank' => $this->blank,
			'link' => $this->link,
			'content' => $this->content
		]);
		$this->jsonPutContents(self::$data, $this->getData('pages'));
		$this->setPopup('Nouvelle page créée avec succès !');
		$this->redirect('page/' . $key);
	}

	/**
	 * PAGE : Édition de page
	 * @return bool Retour true en cas de réussite, false en cas d'échec
	 */
	public function edit()
	{
		self::$private = true;

		// Erreur
		if(!$this->getData('pages', $this->getUrl(2))) {
			return false;
		}
		// Formulaire validé
		elseif($this->getPost('submit')) {
			if($this->getPost('title') === $this->getData('pages', $this->getUrl(1), 'title')) {
				$key = $this->getUrl(1);
			}
			else {
				$key = helpers\tools::filter($this->getPost('title'), $this->getData('pages'));
				$this->removeData('pages', $this->getUrl(1));
			}
			$this->setData('pages', $key, [
				'title' => $this->getPost('title') ? $this->getPost('title') : $this->title,
				'position' => $this->getPost('position'),
				'blank' => $this->getPost('blank'),
				'link' => $this->getPost('link'),
				'content' => $this->getPost('content')
			]);
			$this->jsonPutContents(self::$data, $this->getData('pages'));
			if($this->getData('settings', 'index') === $this->getUrl(1)) {
				$this->setData('settings', 'index', $key);
				$this->jsonPutContents(self::$config, $this->getData('settings'));
			}
			$this->redirect('page/' . $key);
		}
		// Page d'édition
		else {
			$this->setTitle($this->getData('pages', $this->getUrl(1), 'title'));
			$this->setContent (
				helpers\template::openForm() .
					helpers\template::openRow() .
						helpers\template::text('title', [
							'label' => 'Titre de la page',
							'value' => $this->getData('pages', $this->getUrl(1), 'title'),
						]) .
					helpers\template::closeRow() .
					helpers\template::openRow() .
						helpers\template::textarea('content', [
							'value' => $this->getData('pages', $this->getUrl(1), 'content'),
							'class' => 'editor'
						]) .
					helpers\template::closeRow() .
					helpers\template::openRow() .
						helpers\template::text('position', [
							'label' => 'Position dans le menu',
							'value' => $this->getData('pages', $this->getUrl(1), 'position'),
							'col' => 6
						]) .
						helpers\template::text('link', [
							'label' => 'Lien de redirection',
							'value' => $this->getData('pages', $this->getUrl(1), 'link'),
							'col' => 6
						]) .
					helpers\template::closeRow() .
					helpers\template::openRow() .
						helpers\template::checkbox('blank', true, 'Ouvrir dans un nouvel onglet', [
							'checked' => $this->getData('pages', $this->getUrl(1), 'blank')
						]) .
					helpers\template::closeRow() .
					helpers\template::openRow() .
						helpers\template::submit('submit', [
							'col' => 2,
							'offset' => 10
						]) .
					helpers\template::closeRow() .
				helpers\template::closeForm()
			);
		}

		return true;
	}

	public function delete()
	{
		self::$private = true;

		// Erreur
		if(!$this->getData('pages', $this->getUrl(1))) {
			return false;
		}
		// Supprime la page
		else {
			if($this->getUrl(1) === $this->getData('settings', 'index')) {
				$this->setPopup('Impossible de supprimer la page d\'accueil !');
			}
			else {
				$this->removeData('pages', $this->getUrl(1));
				$this->jsonPutContents(self::$data, $this->getData('pages'));
				$this->setPopup('Page supprimée avec succès !');
			}
			$this->redirect('page/' . $this->getData('settings', 'index'));
		}
	}
}