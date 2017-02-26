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

class user extends common {

	public static $actions = [
		'add' => self::GROUP_ADMIN,
		'delete' => self::GROUP_ADMIN,
		'edit' => self::GROUP_MEMBER,
		'forgot' => self::GROUP_VISITOR,
		'index' => self::GROUP_ADMIN,
		'login' => self::GROUP_VISITOR,
		'logout' => self::GROUP_MEMBER,
		'reset' => self::GROUP_VISITOR
	];
	public static $users = [];

	/**
	 * Ajout
	 */
	public function add() {
		// Soumission du formulaire
		if($this->isPost()) {
			// L'identifiant d'utilisateur est indisponible
			$userId = $this->getInput('userAddId', helper::FILTER_ID);
			if($this->getData(['user', $userId])) {
				self::$inputNotices['userAddId'] = 'Identifiant déjà utilisé';
			}
			// Double vérification pour le mot de passe
			if($this->getInput('userAddPassword') !== $this->getInput('userAddConfirmPassword')) {
				self::$inputNotices['userAddConfirmPassword'] = 'Incorrect';
			}
			// Crée l'utilisateur
			$firstname = $this->getInput('userAddFirstname');
			$lastname = $this->getInput('userAddLastname');
			$mail = $this->getInput('userAddMail', helper::FILTER_MAIL);
			$this->setData([
				'user',
				$userId,
				[
					'firstname' => $firstname,
					'forgot' => 0,
					'group' => $this->getInput('userAddGroup', helper::FILTER_INT),
					'lastname' => $lastname,
					'mail' => $mail,
					'password' => $this->getInput('userAddPassword', helper::FILTER_PASSWORD)
				]
			]);
			// Envoi le mail
			if($this->getInput('userAddSendMail', helper::FILTER_BOOLEAN)) {
				$this->sendMail(
					$mail,
					helper::translate('Compte créé sur') . ' ' . $this->getData(['config', 'title']),
					helper::translate('Bonjour') . ' <strong>' . $firstname . ' ' . $lastname . '</strong>,<br><br>' .
					helper::translate('Un administrateur vous a créé un compte sur le site') . $this->getData(['config', 'title']) . '. ' . helper::translate('Vous trouverez ci-dessous les détails de votre compte.') . '<br><br>' .
					'<strong>' . helper::translate('Identifiant du compte :') . '</strong> ' . $userId . '<br>' .
					'<strong>' . helper::translate('Mot de passe du compte :') . '</strong> ' . $this->getInput('addUserPassword') . '<br><br>' .
					'<small>' . helper::translate('Nous ne conservons pas les mots de passe, par conséquence nous vous conseillons de garder ce mail tant que vous ne vous êtes pas connecté. Vous pourrez modifier votre mot de passe après votre première connexion.') . '</small>'
				);
			}
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'user',
				'notification' => 'Utilisateur créé',
				'state' => true
			]);
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Nouvel utilisateur',
			'view' => 'add'
		]);
	}

	/**
	 * Suppression
	 */
	public function delete() {
		// Accès refusé
		if(
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Groupe insuffisant
			AND ($this->getUrl('group') < self::GROUP_MODERATOR)
		) {
			// Valeurs en sortie
			$this->addOutput([
				'access' => false
			]);
		}
		// Bloque la suppression de son propre compte
		elseif($this->getUser('id') === $this->getUrl(2)) {
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'user',
				'notification' => 'Impossible de supprimer votre propre compte'
			]);
		}
		// Suppression
		else {
			$this->deleteData(['user', $this->getUrl(2)]);
			// Valeurs en sortie
			$this->addOutput([
				'redirect' => helper::baseUrl() . 'user',
				'notification' => 'Utilisateur supprimé',
				'state' => true
			]);
		}
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Accès refusé
		if(
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Droit d'édition
			AND (
				// Impossible de s'auto-éditer
				(
					$this->getUser('id') === $this->getUrl(2)
					AND $this->getUrl('group') <= self::GROUP_VISITOR
				)
				// Impossible d'éditer un autre utilisateur
				OR ($this->getUrl('group') < self::GROUP_MODERATOR)
			)
		) {
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
				$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
				if($this->getInput('userEditNewPassword')) {
					// L'ancien mot de passe est correct
					if(password_verify($this->getInput('userEditOldPassword'), $this->getData(['user', $this->getUrl(2), 'password']))) {
						// La confirmation correspond au mot de passe
						if($this->getInput('userEditNewPassword') === $this->getInput('userEditConfirmPassword')) {
							$newPassword = $this->getInput('userEditNewPassword', helper::FILTER_PASSWORD);
							// Déconnexion de l'utilisateur si il change le mot de passe de son propre compte
							if($this->getUser('id') === $this->getUrl(2)) {
								helper::deleteCookie('ZWII_USER_ID');
								helper::deleteCookie('ZWII_USER_PASSWORD');
							}
						}
						else {
							self::$inputNotices['userEditConfirmPassword'] = 'Incorrect';
						}
					}
					else {
						self::$inputNotices['userEditOldPassword'] = 'Incorrect';
					}
				}
				// Modification du groupe
				if(
					$this->getUser('group') === self::GROUP_ADMIN
					AND $this->getUrl(2) !== $this->getUser('id')
				) {
					$newGroup = $this->getInput('userEditGroup', helper::FILTER_INT);
				}
				else {
					$newGroup = $this->getData(['user', $this->getUrl(2), 'group']);
				}
				// Modifie l'utilisateur
				$this->setData([
					'user',
					$this->getUrl(2),
					[
						'firstname' => $this->getInput('userEditFirstname'),
						'forgot' => 0,
						'group' => $newGroup,
						'lastname' => $this->getInput('userEditLastname'),
						'mail' => $this->getInput('userEditMail', helper::FILTER_MAIL),
						'password' => $newPassword
					]
				]);
				// Redirection spécifique si l'utilisateur change son mot de passe
				if($this->getUser('id') === $this->getUrl(2) AND $this->getInput('userEditNewPassword')) {
					$redirect = helper::baseUrl() . 'user/login';
				}
				// Redirection si retour en arrière possible
				elseif($this->getUrl(3)) {
					$redirect = helper::baseUrl() . 'user';
				}
				// Redirection normale
				else {
					$redirect = helper::baseUrl() . $this->getUrl();
				}
				// Valeurs en sortie
				$this->addOutput([
					'redirect' => $redirect,
					'notification' => 'Modifications enregistrées',
					'state' => true
				]);
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => $this->getData(['user', $this->getUrl(2), 'firstname']) . ' ' . $this->getData(['user', $this->getUrl(2), 'lastname']),
				'view' => 'edit'
			]);
		}
	}

	/**
	 * Mot de passe perdu
	 */
	public function forgot() {
		// Soumission du formulaire
		if($this->isPost()) {
			$userId = $this->getInput('userForgotId', helper::FILTER_ID);
			if($this->getData(['user', $userId])) {
				// Enregistre la date de la demande dans le compte utilisateur
				$this->setData(['user', $userId, 'forgot', time()]);
				// Crée un id unique pour la réinitialisation
				$uniqId = md5(json_encode($this->getData(['user', $userId])));
				// Envoi le mail
				$this->sendMail(
					$this->getData(['user', $userId, 'mail']),
					helper::translate('Réinitialisation de votre mot de passe'),
					helper::translate('Bonjour') . ' <strong>' . $this->getData(['user', $userId, 'firstname']) . ' ' . $this->getData(['user', $userId, 'lastname']) . '</strong>,<br><br>' .
					helper::translate('Vous avez demandé à changer le mot de passe lié à votre compte. Vous trouverez ci-dessous un lien vous permettant de modifier celui-ci.') . '<br><br>' .
					'<a href="' . helper::baseUrl() . 'user/reset/' . $userId . '/' . $uniqId . '" target="_blank">' . helper::baseUrl() . 'user/reset/' . $userId . '/' . $uniqId . '</a><br><br>' .
					'<small>' . helper::translate('Si nous n\'avez pas demandé à réinitialiser votre mot de passe, veuillez ignorer ce mail.') . '</small>'
				);
				// Valeurs en sortie
				$this->addOutput([
					'notification' => 'Un mail vous a été envoyé afin de continuer la réinitialisation',
					'state' => true
				]);
			}
			// L'utilisateur n'existe pas
			else {
				// Valeurs en sortie
				$this->addOutput([
					'notification' => 'Cet utilisateur n\'existe pas'
				]);
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => 'Mot de passe oublié',
			'view' => 'forgot'
		]);
	}

	/**
	 * Liste des utilisateurs
	 */
	public function index() {
		$userIdsFirstnames = helper::arrayCollumn($this->getData(['user']), 'firstname');
		ksort($userIdsFirstnames);
		foreach($userIdsFirstnames as $userId => $userFirstname) {
			self::$users[] = [
				$userId,
				$userFirstname . ' ' . $this->getData(['user', $userId, 'lastname']),
				self::$groups[$this->getData(['user', $userId, 'group'])],
				template::button('userEdit' . $userId, [
					'value' => template::ico('pencil'),
					'href' => helper::baseUrl() . 'user/edit/' . $userId . '/back'
				]),
				template::button('userDelete' . $userId, [
					'value' => template::ico('cancel'),
					'href' => helper::baseUrl() . 'user/delete/' . $userId,
					'class' => 'userDelete'
				])
			];
		}
		// Valeurs en sortie
		$this->addOutput([
			'title' => 'Liste des utilisateurs',
			'view' => 'index'
		]);
	}

	/**
	 * Connexion
	 */
	public function login() {
		// Soumission du formulaire
		if($this->isPost()) {
			$userId = $this->getInput('userLoginId', helper::FILTER_ID);
			// Connexion si les informations sont correctes
			if(
				password_verify($this->getInput('userLoginPassword'), $this->getData(['user', $userId, 'password']))
				AND $this->getData(['user', $userId, 'group']) >= self::GROUP_MEMBER
			) {
				$expire = $this->getInput('userLoginLongTime') ? strtotime("+1 year") : 0;
				setcookie('ZWII_USER_ID', $userId, $expire, helper::baseUrl(false, false));
				setcookie('ZWII_USER_PASSWORD', $this->getData(['user', $userId, 'password']), $expire, helper::baseUrl(false, false));
				// Valeurs en sortie
				$this->addOutput([
					'notification' => 'Connexion réussie',
					'redirect' => helper::baseUrl(false),
					'state' => true
				]);
			}
			// Sinon notification d'échec
			else {
				// Valeurs en sortie
				$this->addOutput([
					'notification' => 'Identifiant ou mot de passe incorrect'
				]);
			}
		}
		// Valeurs en sortie
		$this->addOutput([
			'display' => self::DISPLAY_LAYOUT_LIGHT,
			'title' => 'Connexion',
			'view' => 'login'
		]);
	}

	/**
	 * Déconnexion
	 */
	public function logout() {
		helper::deleteCookie('ZWII_USER_ID');
		helper::deleteCookie('ZWII_USER_PASSWORD');
		// Valeurs en sortie
		$this->addOutput([
			'notification' => 'Déconnexion réussie',
			'redirect' => helper::baseUrl(false),
			'state' => true
		]);
	}

	/**
	 * Réinitialisation du mot de passe
	 */
	public function reset() {
		// Accès refusé
		if(
			// L'utilisateur n'existe pas
			$this->getData(['user', $this->getUrl(2)]) === null
			// Lien de réinitialisation trop vieux
			OR $this->getData(['user', $this->getUrl(2), 'forgot']) + 86400 < time()
			// Id unique incorrecte
			OR $this->getUrl(3) !== md5(json_encode($this->getData(['user', $this->getUrl(2)])))
		) {
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
				if($this->getInput('userResetNewPassword')) {
					$newPassword = $this->getInput('userResetNewPassword', helper::FILTER_PASSWORD);
					// La confirmation ne correspond pas au mot de passe
					if($this->getInput('userResetNewPassword') !== $this->getInput('userResetConfirmPassword')) {
						$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
						self::$inputNotices['userResetConfirmPassword'] = 'Incorrect';
					}
					// Modifie le mot de passe
					$this->setData(['user', $this->getUrl(2), 'password', $newPassword]);
					// Réinitialise la date de la demande
					$this->setData(['user', $this->getUrl(2), 'forgot', 0]);
					// Valeurs en sortie
					$this->addOutput([
						'notification' => 'Nouveau mot de passe enregistré',
						'redirect' => helper::baseUrl() . 'user/login',
						'state' => true
					]);
				}
			}
			// Valeurs en sortie
			$this->addOutput([
				'title' => 'Réinitialisation du mot de passe',
				'view' => 'reset'
			]);
		}
	}

}