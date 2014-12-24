<?php

class config extends core
{
	/**
	 * Colonnes du fichier de données
	 */
	private $title			= 'Mon site ZwiiCMS';
	private $description	= '';
	private $password		= '';
	private $index			= false;
	private $footer			= '';
	private $content		= '';

	/**
	 * PAGE : Configuration
	 * @return bool Retourne false en cas d'erreur, sinon true
	 */
	public function index()
	{
		self::$private = true;

		// Formulaire validé
		if($this->getPost('submit')) {
			$this->newPluginsSettings();
			$this->setData('settings', $this->newSettings());
			helpers::jsonPutContents($this->config, $this->getData('config'));
			$this->setNotification('Paramètres enregistrés avec succès !');

			return helpers::redirect($this->getUrl());

		}
		// Page de configuration
		else {
			$this->setTitle('Paramètres');
			$this->setContent(
				template::openForm() .
					template::openRow() .
						template::text('title', [
							'label' => 'Titre du site',
							'value' => $this->getData('config', 'title'),
						]) .
					template::closeRow() .
					template::openRow() .
						template::text('description', [
							'label' => 'Description du site',
							'value' => $this->getData('config', 'description'),
						]) .
					template::closeRow() .
					template::openRow() .
						template::text('password', [
							'label' => 'Nouveau mot de passe',
							'col' => 6
						]) .
						template::text('confirm', [
							'label' => 'Confirmation du mot de passe',
							'col' => 6
						]) .
					template::closeRow() .
					template::openRow() .
						template::submit('submit', [
							'col' => 2,
							'offset' => 10
						]) .
					template::closeRow() .
				template::closeForm()
			);

			return true;
		}
	}

	private function newSettings()
	{
		foreach($this->getData('config') as $key => $value) {
			if($key == 'password') {
				$array[$key] = $this->getPost($key) ? sha1($this->getPost($key)) : $this->getSetting($key);
			} else {
				$array[$key] = $this->getPost($key);
			}
		}
		return $array;
	}

	private function newPluginsSettings()
	{
		foreach($this->getPlugins() as $key => $value) {
			if(!empty($value['__construct'])) {
				foreach($value['__construct'] as $sub_key => $sub_value) {
					$array[$key][$sub_key] = $this->isPost($key . $sub_key) ? $this->getPost($key . $sub_key) : $sub_value;
				}
				$this->setPlugin($key, '__construct', $array[$key]);
				$this->jsonPutContents($this->getPluginsPath() . $key . '/plugin.json', $this->getPlugin($key));
			}
		}
	}

	private function selectTemplate()
	{
		foreach($this->getTemplates() as $value) {
			$selected = ($this->getSetting('template') == $value) ? ' selected' : false;
			@$options .= '<option value="' . $value . '"' . $selected . '>' . $value . '</option>';
		}
		return $options;
	}

	private function selectHome()
	{
		foreach($this->getData('pages') as $key => $value) {
			$selected = ($this->getSetting('index') == $key) ? ' selected' : false;
			@$options .= '<option value="' . $key . '"' . $selected . '>' . $value['title'] . '</option>';
		}
		return $options;
	}

	private function pluginsSettings()
	{
		foreach($this->getPlugins() as $key => $value) {
			if(!empty($value['__construct'])
				&& count($value['__construct']) > 1
			) {
				foreach($value['__construct'] as $sub_key => $sub_value) {
					@$settings .= ($sub_key == 'name') ? '<h4>' . $this->_($sub_value) . '</h4>' : '<p><label>' . $this->_($sub_key) . '</label><input type="text" name="' . $key . $sub_key . '" value="' . $sub_value . '"></p>';
				}
			}
		}
		return empty($settings) ? '<p>' . $this->_('Aucun plugin.') . '</p>' : $settings;
	}
}