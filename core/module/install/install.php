<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class install extends common {

	public static $actions = [
		'index' => self::GROUP_VISITOR
	];
	
	/**
	 * Installation
	 */
	public function index() {
		// Accès refusé
		if($this->getData(['user']) !== []) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Accès autorisé
		else {
			// Soumission du formulaire
			if($this->isPost()) {
				// Double vérification pour le mot de passe
				$password = $this->getInput('installPassword', helper::FILTER_PASSWORD);
				if($password !== $this->getInput('installConfirmPassword', helper::FILTER_PASSWORD)) {
					self::$inputNotices['installConfirmPassword'] = 'Ne correspond pas au mot de passe';
				}
				// Crée l'utilisateur
				$userId = $this->getInput('installId', helper::FILTER_ID);
				$firstname = $this->getInput('installFirstname');
				$lastname = $this->getInput('installLastname');
				$mail = $this->getInput('installMail', helper::FILTER_MAIL);
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $firstname,
						'group' => self::GROUP_ADMIN,
						'lastname' => $lastname,
						'mail' => $mail,
						'password' => $password
					]
				]);
				// Envoi le mail
				$this->sendMail(
					$mail,
					helper::translate('Installation de votre site'),
					helper::translate('Bonjour') . ' <strong>' . $firstname . ' ' . $lastname . '</strong>,<br><br>' .
					helper::translate('Vous trouverez ci-dessous les détails de votre installation.') . '<br><br>' .
					'<strong>' . helper::translate('URL du site :') . '</strong> <a href="' . helper::baseUrl(false) . '" target="_blank">' . helper::baseUrl(false) . '</a><br>' .
					'<strong>' . helper::translate('Identifiant du compte :') . '</strong> ' . $userId . '<br>'
				);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl(false),
					'notification' => 'Installation terminée',
					'state' => true
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => 'Installation',
				'view' => 'index'
			]);
		}
	}

}