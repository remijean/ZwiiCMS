<?php

class user extends common {

	public static $actions = [
		'all' => self::RANK_ADMIN,
		'edit' => self::RANK_ADMIN,
		'login' => self::RANK_VISITOR,
		'logout' => self::RANK_MEMBER
	];
	public static $ranks = [
		self::RANK_MEMBER => 'Membre',
		self::RANK_MODERATOR => 'Modérateur',
		self::RANK_ADMIN => 'Admin'
	];
	public static $users = [];

	/**
	 * Tout les utilisateurs
	 */
	public function all() {
		foreach($this->getData(['user']) as $userId => $user) {
			self::$users[] = [
				$user['name'],
				template::button('edit[]', [
					'value' => template::ico('pencil'),
					'href' => helper::baseUrl() . 'user/edit/' . $userId
				]),
				template::button('delete[]', [
					'value' => template::ico('cancel'),
					'href' => helper::baseUrl() . 'user/delete/' . $userId
				])
			];
		}
		return [
			'title' => 'Utilisateurs',
			'view' => true
		];
	}

	/**
	 * Édition
	 */
	public function edit() {
		// Soumission du formulaire
		if($this->isPost()) {

		}
		// Affichage du template
		else {
			return [
				'title' => $this->getData(['user', $this->getUrl(2), 'name']),
				'view' => true
			];
		}
	}

	/**
	 * Connexion
	 */
	public function login() {
		// Soumission du formulaire
		if($this->isPost()) {
			// Connexion si les informations sont correctes
			if(
				$this->getData(['user', $this->getInput('userId')])
				AND $this->getData(['user', $this->getInput('userId'), 'password']) === hash('sha256', $this->getInput('userPassword'))
			) {
				$expire = $this->getInput('userLongTime') ? strtotime("+1 year") : 0;
				setcookie('ZWII_USER_ID', $this->getInput('userId'), $expire);
				setcookie('ZWII_USER_PASSWORD', hash('sha256', $this->getInput('userPassword')), $expire);
				return [
					'notification' => 'Connexion réussie',
					'redirect' => implode('/', array_slice(explode('/', $this->getUrl()), 2)),
					'state' => true
				];
			}
			// Sinon notification d'échec
			else {
				return [
					'notification' => 'Identifiant ou mot de passe incorrect',
					'title' => 'Connexion',
					'view' => true
				];
			}
		}
		// Affichage du template
		else {
			return [
				'title' => 'Connexion',
				'view' => true
			];
		}
	}

	/**
	 * Déconnexion
	 */
	public function logout() {
		helper::deleteCookie('ZWII_USER_ID');
		helper::deleteCookie('ZWII_USER_PASSWORD');
		return [
			'notification' => 'Déconnexion réussie',
			'redirect' => implode('/', array_slice(explode('/', $this->getUrl()), 2)),
			'state' => true
		];
	}

}