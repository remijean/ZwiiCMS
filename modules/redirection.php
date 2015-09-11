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
	/** @var string Nom du module */
	public static $name = 'URL de redirection';

	/** MODULE : Configuration de la redirection*/
	public function index()
	{
		// Traitement du formulaire
		if($this->getPost('submit')) {
			// Modifie l'URL de redirection
			$this->setData([$this->getUrl(0), 'url', $this->getPost('url', helpers::URL)]);
			// Enregistre les données
			$this->saveData();
			// Notification de succès
			$this->setNotification('Configuration du module enregistrée avec succès !');
			// Redirige vers l'URL courante
			helpers::redirect($this->getUrl());
		}
		// Contenu de la page
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('url', [
				'label' => 'URL de redirection',
				'value' => $this->getData([$this->getUrl(0), 'url'])
			]) .
			template::newRow() .
			template::button('back', [
				'value' => 'Retour',
				'href' => '?edit/' . $this->getUrl(0),
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
	/** MODULE : Redirection */
	public function index()
	{
		// Redirection vers l'URL saisie
		$url = $this->getData([$this->getUrl(0), 'url']);
		if($url) {
			helpers::redirect($url, false);
		}
	}
}