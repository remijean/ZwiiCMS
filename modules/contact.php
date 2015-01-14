<?php

/**
 * This file is part of ZwiiCMS.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi-jean@outlook.com>
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
			$mail = $this->getData($this->getUrl(0), 'mail');
			$n = preg_match("#@(hotmail|live|msn|outlook).[a-z]{2,4}$#", $mail) ? "\n" : "\r\n";
			$boundary = '-----=' . md5(rand());
			$html = '<html><head></head><body>' . $this->getPost('message', helpers::STRING) . '</body></html>';
			$txt = strip_tags($html);
			$header = 'From: ' . $this->getPost('mail', helpers::EMAIL) . $n;
			$header .= 'Reply-To: ' . $mail . $n;
			$header .= 'MIME-Version: 1.0' . $n;
			$header .= 'Content-Type: multipart/alternative;' . $n . ' boundary="' . $boundary . '"' . $n;
			$message = $n . $boundary . $n;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . $n;
			$message .= 'Content-Transfer-Encoding: 8bit' . $n;
			$message .= $n . $txt . $n;
			$message .= $n . '--' . $boundary . $n;
			$message .= 'Content-Type: text/html; charset="utf-8"' . $n;
			$message .= 'Content-Transfer-Encoding: 8bit' . $n;
			$message .= $n . $html . $n;
			$message .= $n . '--' . $boundary . '--' . $n;
			$message .= $n . '--' . $boundary . '--' . $n;
			if($mail AND @mail($mail, $this->getPost('subject', helpers::STRING), $message, $header)) {
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
				'col' => 6
			]) .
			template::closeRow() .
			template::openRow() .
			template::text('subject', [
				'label' => 'Sujet',
				'col' => 6
			]) .
			template::closeRow() .
			template::openRow() .
			template::textarea('message', [
				'label' => 'Sujet',
				'col' => 7
			]) .
			template::closeRow() .
			template::openRow() .
			template::submit('submit', [
				'col' => 2
			]) .
			template::closeRow() .
			template::closeForm();
	}
}