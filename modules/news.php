<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2015, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class newsAdm extends core
{
	public static $name = 'Gestionnaire de news';
	public static $views = ['delete', 'edit'];

	/**
	 * MODULE : Ajout de news & liste des news
	 */
	public function index()
	{
		if($this->getPost('submit')) {
			$key = helpers::increment($this->getPost('title', helpers::URL), $this->getData($this->getUrl(1)));
			$this->setData($this->getUrl(1), $key, [
				'title' => $this->getPost('title', helpers::STRING),
				'date' => time(),
				'content' => $this->getPost('content'),
			]);
			$this->saveData();
			$this->setNotification('Nouvelle news créée avec succès !');
			helpers::redirect('module/' . $this->getUrl(1));
		}
		if($this->getData($this->getUrl(1))) {
			self::$content = '<h3>Liste des news</h3>';
			$pagination = helpers::pagination($this->getData($this->getUrl(1)), $this->getUrl());
			$news = helpers::arrayCollumn($this->getData($this->getUrl(1)), 'date', 'SORT_DESC');
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$content .=
					template::openRow() .
					template::text('news[]', [
						'value' => $this->getData($this->getUrl(1), $news[$i], 'title'),
						'readonly' => true,
						'col' => 8
					]) .
					template::button('edit[]', [
						'value' => 'Modifier',
						'href' => '?' . $this->getUrl(0) . '/' . $this->getUrl(1) . '/edit/' . $news[$i],
						'col' => 2
					]) .
					template::button('delete[]', [
						'value' => 'Supprimer',
						'href' => '?' . $this->getUrl(0) . '/' . $this->getUrl(1) . '/delete/' . $news[$i],
						'onclick' => 'return confirm(\'Êtes-vous certain de vouloir supprimer cette news ?\');',
						'col' => 2
					]) .
					template::closeRow();

			}
			self::$content .= $pagination['pages'];
		}
		self::$content =
			'<h3>Nouvelle news</h3>' .
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre de la news',
				'required' => true
			]) .
			template::newRow() .
			template::textarea('content', [
				'class' => 'editor'
			]) .
			template::newRow() .
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

	/**
	 * MODULE : Édition d'une news
	 */
	public function edit()
	{
		if(!$this->getData($this->getUrl(1), $this->getUrl(3))) {
			return false;
		}
		elseif($this->getPost('submit')) {
			$key = $this->getPost('title') ? $this->getPost('title', helpers::URL) : $this->getUrl(3);
			$date = $this->getData($this->getUrl(1), $this->getUrl(3), 'date');
			if($key !== $this->getUrl(3)) {
				$key = helpers::increment($key, $this->getData($this->getUrl(1)));
				$this->removeData($this->getUrl(1), $this->getUrl(3));
			}
			$this->setData($this->getUrl(1), $key, [
				'title' => $this->getPost('title', helpers::STRING),
				'date' => $date,
				'content' => $this->getPost('content')
			]);
			$this->saveData();
			$this->setNotification('News modifiée avec succès !');
			helpers::redirect('module/' . $this->getUrl(1) . '/' . $this->getUrl(2) . '/' . $key);
		}
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('title', [
				'label' => 'Titre de la news',
				'value' => $this->getData($this->getUrl(1), $this->getUrl(3), 'title'),
				'required' => true
			]) .
			template::newRow() .
			template::textarea('content', [
				'class' => 'editor',
				'value' => $this->getData($this->getUrl(1), $this->getUrl(3), 'content')
			]) .
			template::newRow() .
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

	/**
	 * MODULE : Suppression d'une news
	 */
	public function delete()
	{
		if(!$this->getData($this->getUrl(1), $this->getUrl(3))) {
			return false;
		}
		else {
			$this->removeData($this->getUrl(1), $this->getUrl(3));
			$this->saveData();
			$this->setNotification('News supprimée avec succès !');
		}
		helpers::redirect('module/' . $this->getUrl(1));
	}
}

class newsMod extends core
{
	/**
	 * MODULE : Liste des news
	 */
	public function index()
	{
		if($this->getData($this->getUrl(0))) {
  			$pagination = helpers::pagination($this->getData($this->getUrl(0)), $this->getUrl());
			$news = helpers::arrayCollumn($this->getData($this->getUrl(0)), 'date', 'SORT_DESC');
			for($i = $pagination['first']; $i < $pagination['last']; $i++) {
				self::$content .=
					'<h3>' . $this->getData($this->getUrl(0), $news[$i], 'title') . '</h3>' .
					'<h4>' . date('d/m/Y - H:i', $this->getData($this->getUrl(0), $news[$i], 'date')) . '</h4>' .
					$this->getData($this->getUrl(0), $news[$i], 'content');
			}
			self::$content .= $pagination['pages'];
		}
	}
}