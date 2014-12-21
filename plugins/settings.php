<?php

class setting extends system
{
	/**
	 * Colonnes du fichier de données
	 */
	private $title			= 'Mon site';
	private $password		= '';
	private $index			= false;
	private $footer			= '';
	private $content		= '';

	public function __construct()
	{
		parent::__construct();
		$this->_settingsPath = $this->getDataPath() . 'settings.json';
	}

	public function home()
	{
		if($this->getPost('submit')) {
			$this->newPluginsSettings();
			$this->setData('settings', $this->newSettings());
			$this->jsonPutContents($this->_settingsPath, $this->getData('settings'));
			$_SESSION['POPUP'] = 'Paramètres enregistrés avec succès !';
			return $this->redirect($this->getUrl());

		} else {
			$this->setTitle('Paramètres');
			$this->setContent
			('
				' < h3>Paramètres généraux </h3 >
			'<form name="form" method="post">' .
			'<p>' .
			'<label>Titre du site</label>' .
			'<input type="text" name="title" value="' . htmlentities($this->getSetting('title'), ENT_COMPAT, 'UTF-8') . '">' .
			'<div class="tip">Le titre du site englobe également la balise méta titre.</div>' .
			'</p>' .
			'<p>' .
			'<label>Nouveau mot de passe</label>' .
			'<input type="text" name="password" value="">' .
			'<div class="tip">Laisser vide pour ne pas changer le mot de passe d\'administration.</div>' .
			'</p>' .
			'<p>' .
			'<label>Page d\'accueil</label>' .
			'<select name="index">' .
			$this->selectHome() .
			'</select>' .
			'</p>' .
			'<p>' .
			'<label>Template par défaut</label>' .
			'<select name="template">' .
			$this->selectTemplate() .
			'</select>' .
			'</p>' .
			'<p>' .
			'<label>' . $this->_('Bas de page') . '</label>' .
			'<input type="text" name="footer" value="' . htmlentities($this->getSetting('footer'), ENT_COMPAT, 'UTF-8') . '">' .
			'<div class="tip">' . $this->_('Texte en bas de page (merci de laisser une petite trace de Zwii).') . '</div>' .
			'</p>' .
			'<p>' .
			'<label>' . $this->_('Balise méta description') . '</label>' .
			'<input type="text" name="description" value="' . htmlentities($this->getSetting('description'), ENT_COMPAT, 'UTF-8') . '">' .
			'<div class="tip">' . $this->_('Description de 150 caractères maximum.') . '</div>' .
			'</p>' .
			'<p>' .
			'<label>' . $this->_('Balise méta mots clés') . '</label>' .
			'<input type="text" name="keywords" value="' . htmlentities($this->getSetting('keywords'), ENT_COMPAT, 'UTF-8') . '">' .
			'<div class="tip">' . $this->_('Mots clés séparés par des virgules.') . '</div>' .
			'</p>' .
			'<p>' .
			'<label>' . $this->_('Version de Zwii') . '</label>' .
			'<input type="text" name="version" value="' . self::VERSION . '" readonly>' .
			'</p>' .
			'<div id="plugins" class="hide">' .
			'<h3>' . $this->_('Paramètres des plugins') . '</h3>' .
			$this->pluginsSettings() .
			'</div>' .
			'<p>' .
			'<input type="submit" name="submit" value="' . $this->_('Enregistrer') . '"> ' .
			'<input type="button" value="' . $this->_('Paramètres des plugins') . '" onclick="showHide(\'plugins\');">' .
			'</p>' .
			'</form>'
			);
		}
	}

	private function newSettings()
	{
		foreach($this->getData('settings') as $key => $value) {
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