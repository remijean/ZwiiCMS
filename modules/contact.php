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

class contactAdm extends core
{
	public static $name = 'Formulaire de contact';

	/**
	 * MODULE : Configuration du formulaire
	 */
	public function index()
	{
		if($this->getPost('submit')) {
			$this->setData($this->getUrl(1), 'mail', $this->getPost('mail', helpers::EMAIL));
			$this->saveData();
			$this->setNotification('Configuration du module enregistrée avec succès !');
			helpers::redirect($this->getUrl());
		}
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('mail', [
				'label' => 'Adresse de réception des mails',
				'value' => $this->getData('modules', $this->getUrl(1), 'mail')
			]) .
			template::closeRow() .
			template::openRow() .
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

class contactMod extends core
{
	/**
	 * MODULE : Formulaire de contact
	 */
	public function index()
	{
		// Envoi du mail
		if($this->getPost('submit')) {
			$mail = helpers::mail(
				$this->getPost('subject', helpers::STRING),
				$this->getData($this->getUrl(0), 'mail'),
				$this->getPost('subject', helpers::STRING),
				$this->getPost('message', helpers::STRING)
			);
			if($mail) {
				$this->setNotification('Mail envoyé avec succès !');
			}
			else {
				$this->setNotification('Impossible d\'envoyer le mail !');
			}
			helpers::redirect($this->getUrl());
		}
		// Interface d'écriture de mail
		self::$content =
			template::openForm() .
			template::openRow() .
			template::text('mail', [
				'label' => 'Adresse mail',
				'required' => true,
				'col' => 6
			]) .
			template::newRow() .
			template::text('subject', [
				'label' => 'Sujet',
				'required' => true,
				'col' => 6
			]) .
			template::newRow() .
			template::textarea('message', [
				'label' => 'Sujet',
				'required' => true,
				'col' => 7
			]) .
			template::newRow() .
			template::submit('submit', [
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}
}