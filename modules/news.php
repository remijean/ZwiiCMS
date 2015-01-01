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

	public function index()
	{
		if($this->getData('modules', $this->getUrl(1))) {
			foreach($this->getData('modules', $this->getUrl(1)) as $value) {
				self::$content =
					template::openDiv() .
					template::openDiv('col8') .
					$value['newsTitle'] .
					template::closeDiv() .
					template::button('newsToggle[]', [
						'value' => 'Modifier',
						'col' => 2
					]) .
					template::checkbox('newsDelete[' . $value . ']', true, 'supprimer', [
						'col' => 2
					]) .
					template::closeDiv();
			}
		}
		else {
			self::$content = '<p>Aucune news</p>';
		}
		self::$content =
			template::openDiv() .
			template::button('newsCreate[]', [
				'value' => '+',
				'onclick' => '$(\'div.create\').slideToggle();',
				'col' => 1,
				'offset' => 11
			]) .
			template::closeDiv() .
			template::openDiv('create none') .
			template::openDiv() .
			template::text('newsTitle', [
				'label' => 'Titre de la news'
			]) .
			template::closeDiv() .
			template::openDiv() .
			template::textarea('newsContent', [
				'class' => 'editor'
			]) .
			template::closeDiv() .
			template::closeDiv() .
			'<h3>Liste des news</h3>' .
			self::$content;
	}

	public function create() {
		$module = $this->getData('modules', $this->getUrl(1)) ? $this->getData('modules', $this->getUrl(1)) : [];
		$key = helpers::increment($this->getPost('newsTitle'), $module);
		$this->saveData();
		echo $key;
	}
}

class newsPublic extends core
{
	public function index()
	{
		// Envoi du mail
		if($this->getPost('submit')) {
			$mail = $this->getData('modules', $this->getUrl(0), 'contact_mail');
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
		else {
			self::$content =
				template::openForm() .
				template::openDiv() .
				template::text('mail', [
					'label' => 'Adresse mail',
					'col' => 6
				]) .
				template::closeDiv() .
				template::openDiv() .
				template::text('subject', [
					'label' => 'Sujet',
					'col' => 6
				]) .
				template::closeDiv() .
				template::openDiv() .
				template::textarea('message', [
					'label' => 'Sujet',
					'col' => 7
				]) .
				template::closeDiv() .
				template::openDiv() .
				template::submit('submit', [
					'col' => 2
				]) .
				template::closeDiv() .
				template::closeForm();
		}
	}
}