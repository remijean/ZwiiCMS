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
		'config' => self::GROUP_VISITOR,
		'index' => self::GROUP_VISITOR
	];

	public static $languages = [
		'fr_FR' => 'fr_FR'
	];

	/**
	 * Configuration
	 */
	public function config() {
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
				if($this->getInput('installConfigPassword') !== $this->getInput('installConfigConfirmPassword')) {
					self::$inputNotices['installConfigConfirmPassword'] = 'Incorrect';
				}
				// Crée l'utilisateur
				$userId = $this->getInput('installConfigId', helper::FILTER_ID);
				$firstname = $this->getInput('installConfigFirstname');
				$lastname = $this->getInput('installConfigLastname');
				$mail = $this->getInput('installConfigMail', helper::FILTER_MAIL);
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $firstname,
						'forgot' => 0,
						'group' => self::GROUP_ADMIN,
						'lastname' => $lastname,
						'mail' => $mail,
						'password' => $this->getInput('installConfigPassword', helper::FILTER_PASSWORD)
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
				'view' => 'config'
			]);
		}
	}

	/**
	 * Choix de la langue
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
				$this->setData(['config', 'language', $this->getInput('installLanguage')]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'install/config',
					'state' => true
				]);
			}
			// Liste des langues
			$iterator = new DirectoryIterator('core/lang/');
			foreach($iterator as $fileInfos) {
				if($fileInfos->isFile()) {
					self::$languages[$fileInfos->getBasename('.json')] = $fileInfos->getBasename('.json');
				}
			}
			asort(self::$languages);
			// Valeurs en sortie
			$this->addOutput([
				'display' => self::DISPLAY_LAYOUT_LIGHT,
				'title' => 'Installation',
				'view' => 'index'
			]);
		}
	}

}