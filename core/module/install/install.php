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
				if($this->getInput('installConfigPassword', helper::FILTER_STRING_SHORT, true) !== $this->getInput('installConfigConfirmPassword', helper::FILTER_STRING_SHORT, true)) {
					self::$inputNotices['installConfigConfirmPassword'] = 'Incorrect';
				}
				// Crée l'utilisateur
				$userFirstname = $this->getInput('installConfigFirstname', helper::FILTER_STRING_SHORT, true);
				$userLastname = $this->getInput('installConfigLastname', helper::FILTER_STRING_SHORT, true);
				$userMail = $this->getInput('installConfigMail', helper::FILTER_MAIL, true);
				$userId = $this->getInput('installConfigId', helper::FILTER_ID, true);
				$this->setData([
					'user',
					$userId,
					[
						'firstname' => $userFirstname,
						'forgot' => 0,
						'group' => self::GROUP_ADMIN,
						'lastname' => $userLastname,
						'mail' => $userMail,
						'password' => $this->getInput('installConfigPassword', helper::FILTER_PASSWORD, true)
					]
				]);
				// Configure certaines données par défaut
				$this->setData(['module', 'blog', 'mon-premier-article', 'userId', $userId]);
				$this->setData(['module', 'blog', 'mon-deuxieme-article', 'userId', $userId]);
				$this->setData(['module', 'blog', 'mon-troisieme-article', 'userId', $userId]);
				// Envoi le mail
				$sent = $this->sendMail(
					$userMail,
					helper::i18n('Installation de votre site'),
					helper::i18n('Bonjour') . ' <strong>' . $userFirstname . ' ' . $userLastname . '</strong>,<br><br>' .
					helper::i18n('Vous trouverez ci-dessous les détails de votre installation.') . '<br><br>' .
					'<strong>' . helper::i18n('URL du site :') . '</strong> <a href="' . helper::baseUrl(false) . '" target="_blank">' . helper::baseUrl(false) . '</a><br>' .
					'<strong>' . helper::i18n('Identifiant du compte :') . '</strong> ' . $this->getInput('installConfigId') . '<br>' .
					'<strong>' . helper::i18n('Mot de passe du compte :') . '</strong> ' . $this->getInput('installConfigPassword')
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
				$this->setData(['config', 'language', $this->getInput('installLanguage', helper::FILTER_STRING_SHORT, true)]);
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => helper::baseUrl() . 'install/config',
					'state' => true
				]);
			}
			// Liste des langues
			$iterator = new DirectoryIterator('i18n/');
			foreach($iterator as $fileInfos) {
				if($fileInfos->isFile() AND $fileInfos->getBasename() !== 'template.json') {
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