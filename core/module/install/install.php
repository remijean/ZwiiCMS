<?php

/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

class install extends common {

	public static $actions = [
		'index' => self::GROUP_VISITOR,
		'steps' => self::GROUP_ADMIN,
		'update' => self::GROUP_ADMIN
	];

	public static $newVersion;

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
				if($this->getInput('installPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('installConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
					self::$inputNotices['installConfirmPassword'] = 'Incorrect';
				}
				// Crée l'utilisateur
				$userFirstname = $this->getInput('installFirstname', helper::FILTER_STRING_SHORT, true);
				$userLastname = $this->getInput('installLastname', helper::FILTER_STRING_SHORT, true);
				$userMail = $this->getInput('installMail', helper::FILTER_MAIL, true);
				$userId = $this->getInput('installId', helper::FILTER_ID, true);
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'forgot' => 0,
						'group' => self::GROUP_ADMIN,
						'lastname' => $userLastname,
						'mail' => $userMail,
						'password' => $this->getInput('installPassword', helper::FILTER_PASSWORD, true)
					]
				]);
				// Configure certaines données par défaut
				$this->setData(['module', 'blog', 'mon-premier-article', 'userId', $userId]);
				$this->setData(['module', 'blog', 'mon-deuxieme-article', 'userId', $userId]);
				$this->setData(['module', 'blog', 'mon-troisieme-article', 'userId', $userId]);
				// Envoi le mail
				$sent = $this->sendMail(
					$userMail,
					'Installation de votre site',
					'Bonjour' . ' <strong>' . $userFirstname . ' ' . $userLastname . '</strong>,<br><br>' .
					'Vous trouverez ci-dessous les détails de votre installation.<br><br>' .
					'<strong>URL du site :</strong> <a href="' . helper::baseUrl(false) . '" target="_blank">' . helper::baseUrl(false) . '</a><br>' .
					'<strong>Identifiant du compte :</strong> ' . $this->getInput('installId') . '<br>' .
					'<strong>Mot de passe du compte :</strong> ' . $this->getInput('installPassword')
				);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl(false),
					'notification' => ($sent === true ? 'Installation terminée' : $sent),
					'state' => ($sent === true ? true : null)
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

	/**
	 * Étapes de mise à jour
	 */
	public function steps() {
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_JSON,
			'content' => [
				'success' => true,
				'data' => null
			]
		]);
	}

	/**
	 * Mise à jour
	 */
	public function update() {
		// Nouvelle version
		self::$newVersion = file_get_contents('http://zwiicms.com/version');
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => 'Mise à jour',
			'view' => 'update'
		]);
	}

}