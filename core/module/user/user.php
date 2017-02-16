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
		'add' => self::RANK_ADMIN,
		'delete' => self::RANK_ADMIN,
		'edit' => self::RANK_MEMBER,
		'index' => self::RANK_ADMIN,
		'login' => self::RANK_VISITOR,
		'logout' => self::RANK_MEMBER
	];
	public static $users = [];

	/**
	 * Ajout
	 */
	public function add() {
		// Soumission du formulaire
		if($this->isPost()) {
			// L'identifiant d'utilisateur est indisponible
			$userId = $this->getInput('userAddName', helper::FILTER_ID);
			if($this->getData(['user', $userId])) {
				self::$inputNotices['userAddId'] = 'Identifiant déjà utilisé';
			}
			// Double vérification pour le mot de passe
			$password = $this->getInput('userAddPassword', helper::FILTER_PASSWORD);
			if($password !== $this->getInput('userAddConfirmPassword', helper::FILTER_PASSWORD)) {
				self::$inputNotices['userAddConfirmPassword'] = 'La confirmation ne correspond pas au mot de passe';
			}
			// Crée l'utilisateur
			$this->setData([
				'user',
				$userId,
				[
					'email' => $this->getInput('userAddEmail', helper::FILTER_EMAIL),
					'name' => $this->getInput('userAddName'),
					'password' => $password,
					'rank' => $this->getInput('userAddRank', helper::FILTER_INT)
				]
			]);
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
			// Rang insuffisant
			AND ($this->getUrl('rank') < self::RANK_MODERATOR)
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
					AND $this->getUrl('rank') <= self::RANK_VISITOR
				)
				// Impossible d'éditer un autre utilisateur
				OR ($this->getUrl('rank') < self::RANK_MODERATOR)
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
				if($this->getInput('userEditNewPassword')) {
					$newPassword = $this->getInput('userEditNewPassword', helper::FILTER_PASSWORD);
					// Pas de changement de mot de passe en mode démo
					if(self::$demo) {
						$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
						self::$inputNotices['userEditNewPassword'] = 'Action impossible en mode démonstration !';
					}
					// La confirmation ne correspond pas au mot de passe
					elseif($newPassword !== $this->getInput('userEditConfirmPassword', helper::FILTER_PASSWORD)) {
						$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
						self::$inputNotices['userEditConfirmPassword'] = 'La confirmation ne correspond pas au mot de passe';
					}
				}
				// Sinon conserve le mot de passe d'origine
				else {
					$newPassword = $this->getData(['user', $this->getUrl(2), 'password']);
				}
				// Modification du rang
				if(
					$this->getUser('rank') === self::RANK_ADMIN
					AND $this->getUrl(2) !== $this->getUser('id')
				) {
					$newRank = $this->getInput('userEditRank', helper::FILTER_INT);
				}
				else {
					$newRank = $this->getData(['user', $this->getUrl(2), 'rank']);
				}
				// Modifie l'utilisateur
				$this->setData([
					'user',
					$this->getUrl(2),
					[
						'email' => $this->getInput('userEditEmail', helper::FILTER_EMAIL),
						'name' => $this->getInput('userEditName'),
						'password' => $newPassword,
						'rank' => $newRank
					]
				]);
				// Redirection spécifique si l'utilisateur change son mot de passe
				if($this->getUser('id') === $this->getUrl(2) AND $this->getInput('userEditNewPassword')) {
					helper::deleteCookie('ZWII_USER_ID');
					helper::deleteCookie('ZWII_USER_PASSWORD');
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
				'title' => $this->getData(['user', $this->getUrl(2), 'name']),
				'view' => 'edit'
			]);
		}
	}

	/**
	 * Liste des utilisateurs
	 */
	public function index() {
		$userIdsNames = helper::arrayCollumn($this->getData(['user']), 'name');
		ksort($userIdsNames);
		foreach($userIdsNames as $userId => $userName) {
			self::$users[] = [
				$userId,
				$userName,
				self::$ranks[$this->getData(['user', $userId, 'rank'])],
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
			// Connexion si les informations sont correctes
			if(
				$this->getData(['user', $this->getInput('userLoginId'), 'password']) === hash('sha256', $this->getInput('userLoginPassword'))
				AND $this->getData(['user', $this->getInput('userLoginId'), 'rank']) >= self::RANK_MEMBER
			) {
				$expire = $this->getInput('userLoginLongTime') ? strtotime("+1 year") : 0;
				setcookie('ZWII_USER_ID', $this->getInput('userLoginId'), $expire, helper::baseUrl(false, false));
				setcookie('ZWII_USER_PASSWORD', hash('sha256', $this->getInput('userLoginPassword')), $expire, helper::baseUrl(false, false));
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

}