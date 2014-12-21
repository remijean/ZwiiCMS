<?php

class user extends core
{

	public function __construct()
	{
		parent::__construct();
	}

	public function logout()
	{
		setcookie('PASSWORD');
		session_destroy();
		return $this->redirect('./');
	}

	public function login()
	{
		if($this->getPost('submit')) {
			if(sha1($this->getPost('password')) == $this->getSetting('password')) {
				$time = $this->getPost('time') ? 0 : time() + 10 * 365 * 24 * 60 * 60;
				setcookie('PASSWORD', sha1($this->getPost('password')), $time);
				return $this->redirect($this->getUrl());
			} else {
				$_SESSION['POPUP'] = $this->_('Mot de passe incorrect !');
				return $this->redirect($this->getUrl());
			}
		} else {
			$this->setTitle('Connexion');
			$this->setContent
			(
				Helpers\Form::open().
				Helpers\Form::password('password').
				Helpers\Form::checkbox('time', true, 'Cacher le titre de la page', [
					'checked' => $this->getPage($this->getUrl(1), 'hide')
				]).
				Helpers\Form::submit().
				Helpers\Form::close()
			);
		}
	}
}