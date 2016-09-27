<?php

class user extends common {

	public $actions = [
		'login' => self::RANK_VISITOR,
		'logout' => self::RANK_MEMBER
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
					'notification' => 'Connexion réussie',
					'state' => true
				];
			}
			// Sinon notification d'échec
			else {
				return [
					'notification' => 'Identifiant ou mot de passe incorrect'
				];
			}
		}
		// Affichage du template
		else {
			return [
				'view' => true,
				'state' => true
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
			'notification' => 'Déconnexion réussie',
			'state' => true
		];
	}

}