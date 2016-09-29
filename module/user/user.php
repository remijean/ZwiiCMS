<?php

class user extends common {

	public $actions = [
		'login' => self::RANK_VISITOR,
		'logout' => self::RANK_MEMBER,
		'panel' => self::RANK_VISITOR
	];

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
					'event' => true,
					'hash' => implode('/', array_slice(explode('/', $this->getUrl()), 2)),
					'notification' => 'Connexion réussie'
				];
			}
			// Sinon notification d'échec
			else {
				return [
					'notification' => 'Identifiant ou mot de passe incorrect',
					'state' => false
				];
			}
		}
		// Affichage du template
		else {
			return [
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
			'event' => true,
			'hash' => implode('/', array_slice(explode('/', $this->getUrl()), 2)),
			'notification' => 'Déconnexion réussie'
		];
	}

	/**
	 * panneau
	 */
	public function panel() {
		if(
			$this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE')])
			AND $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'password']) === $this->getInput('ZWII_USER_PASSWORD', '_COOKIE')
		) {
			return [
				'callable' => false,
				'view' => true
			];
		}
		else {
			return [
				'callable' => false
			];
		}
	}

}