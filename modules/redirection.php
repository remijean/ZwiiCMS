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

class redirectionAdm extends core
{
	public static $name = 'URL de redirection';

	/**
	 * MODULE : Configuration de la redirection
	 */
	public function index()
	{
		if($this->getPost('submit')) {
			$this->setData($this->getUrl(1), 'url', $this->getPost('url', helpers::URL));
			$this->saveData();
			$this->setNotification('Configuration du module enregistrée avec succès !');
			helpers::redirect($this->getUrl());
		}
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('url', [
				'label' => 'URL de redirection',
				'value' => $this->getData($this->getUrl(1), 'url')
			]) .
			template::newRow() .
			template::button('back', [
				'value' => 'Retour',
				'href' => '?edit/' . $this->getUrl(1),
				'col' => 2
			]) .
			template::submit('submit', [
				'col' => 2,
				'offset' => 8
			]) .
			template::closeRow() .
			template::closeForm();
	}
}

class redirectionMod extends core
{
	/**
	 * MODULE : Redirection
	 */
	public function index()
	{
		$url = $this->getData($this->getUrl(0), 'url');
		if($url) {
			helpers::redirect($url, false);
		}
	}
}