<?php

/**
 * Copyright (C) 2008-2015, Rémi Jean (remi-jean@outlook.com)
 * <http://remijean.github.io/ZwiiCMS/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General License for more details.
 *
 * You should have received a copy of the GNU General License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class newsConfig extends core
{
	public static $name = 'Gestionnaire de news';
	public static $views = ['delete', 'edit'];

	/**
	 * MODULE : Liste des news
	 */
	public function index()
	{
		if($this->getPost('submit')) {
			$title = $this->getPost('title', helpers::STRING);
			$key = helpers::increment($title, $this->getData('modules', $this->getUrl(1)));
			$this->setData('modules', $this->getUrl(1), $key, [
				'title' => $title,
				'date' => time(),
				'content' => $this->getPost('content'),
			]);
			$this->saveData();
			$this->setNotification('Nouvelle news créée avec succès !');
			helpers::redirect('module/' . $this->getUrl(1));
		}
		else {
			if($this->getData('modules', $this->getUrl(1))) {
				self::$content = '<h3>Liste des news</h3>';
				foreach($this->getData('modules', $this->getUrl(1)) as $key => $value) {
					self::$content .=
						template::openRow() .
						template::text('news[]', [
							'value' => $value['title'],
							'readonly' => true,
							'col' => 8
						]) .
						template::button('edit[]', [
							'value' => 'Modifier',
							'href' => '?' . $this->getUrl() . '/edit/' . $key,
							'col' => 2
						]) .
						template::button('delete[]', [
							'value' => 'Supprimer',
							'href' => '?' . $this->getUrl() . '/delete/' . $key,
							'onclick' => 'return confirm(\'Êtes-vous certain de vouloir supprimer cette news ?\');',
							'col' => 2
						]) .
						template::closeRow();
				}
			}
			self::$content =
				'<h3>Nouvelle news</h3>' .
				template::openForm() .
				template::openRow() .
				template::text('title', [
					'label' => 'Titre de la news'
				]) .
				template::closeRow() .
				template::openRow() .
				template::textarea('content', [
					'class' => 'editor'
				]) .
				template::closeRow() .
				template::openRow() .
				template::submit('submit', [
					'value' => 'Créer',
					'col' => 2,
					'offset' => 10
				]) .
				template::closeRow() .
				template::closeForm() .
				self::$content .
				template::openRow() .
				template::button('back', [
					'value' => 'Retour',
					'href' => '?edit/' . $this->getUrl(1),
					'col' => 2
				]) .
				template::closeRow();
		}
	}

	/**
	 * MODULE : Édition d'une news
	 */
	public function edit()
	{
		if(!$this->getData('modules', $this->getUrl(1), $this->getUrl(3))) {
			return false;
		}
		elseif($this->getPost('submit')) {
			$title = $this->getPost('title', helpers::STRING);
			$key = helpers::increment($title, $this->getData('modules', $this->getUrl(1)));
			$this->setData('modules', $this->getUrl(1), $key, [
				'title' => $title,
				'date' => time(),
				'content' => $this->getPost('content'),
			]);
			$this->saveData();
			$this->setNotification('Nouvelle news créée avec succès !');
			helpers::redirect('module/' . $this->getUrl(1));
		}
		else {
			self::$content =
				template::openForm() .
				template::openRow() .
				template::text('title', [
					'label' => 'Titre de la news',
					'value' => $this->getData('modules', $this->getUrl(1), $this->getUrl(3), 'title')
				]) .
				template::closeRow() .
				template::openRow() .
				template::textarea('content', [
					'class' => 'editor',
					'value' => $this->getData('modules', $this->getUrl(1), $this->getUrl(3), 'content')
				]) .
				template::closeRow() .
				template::openRow() .
				template::button('back', [
					'value' => 'Retour',
					'href' => '?module/' . $this->getUrl(1),
					'col' => 2
				]) .
				template::submit('submit', [
					'col' => 2,
					'offset' => 8
				]) .
				template::closeRow();
				template::closeForm();
		}
	}

	/**
	 * MODULE : Suppression d'une news
	 */
	public function delete()
	{
		// Erreur 404
		if(!$this->getData('modules', $this->getUrl(1), $this->getUrl(3))) {
			return false;
		}
		// Suppression
		else {
			$this->removeData('modules', $this->getUrl(1), $this->getUrl(3));
			$this->saveData();
			$this->setNotification('News supprimée avec succès !');
		}
		helpers::redirect('module/' . $this->getUrl(1));
	}
}

class newsPublic extends core
{
	public function index()
	{
		if($this->getData('modules', $this->getUrl(0))) {
			foreach($this->getData('modules', $this->getUrl(0)) as $key => $value) {
				self::$content .= '<h3>' . $value['title'] . '</h3><h4>' . date('d/m/Y - H:i', $value['date']) .'</h4>' . $value['content'];
			}
		}
	}
}