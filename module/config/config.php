<?php

class config extends common {

	public static $actions = [
		'backup' => self::RANK_ADMIN,
		'index' => self::RANK_ADMIN
	];

	/**
	 * Sauvegarde des données
	 */
	public function backup() {
		// Creation du ZIP
		$fileName = date('Y-m-d-h-i-s', time()) . '.zip';
		$zip = new ZipArchive();
		if($zip->open('core/tmp/' . $fileName, ZipArchive::CREATE) === TRUE){
			foreach(self::scanDir('site/', ['.', '..', 'backup']) as $file) {
				$zip->addFile($file);
			}
		}
		$zip->close();
		// Téléchargement du ZIP
		header('Content-Transfer-Encoding: binary');
		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		header('Content-Length: ' . filesize('core/tmp/' . $fileName));
		readfile('core/tmp/' . $fileName);
		// Affichage du template
		return [
			'display' => self::DISPLAY_BLANK
		];
	}

	/**
	 * Connexion
	 */
	public function index() {
		// Soumission du formulaire
		if($this->isPost()) {
			$this->setData([
				'config',
				[
					'analyticsId' => $this->getInput('configAnalyticsId'),
					'autoBackup' => $this->getInput('configAutoBackup', helper::FILTER_BOOLEAN),
					'cookieConsent' => $this->getInput('configCookieConsent', helper::FILTER_BOOLEAN),
					'favicon' => $this->getInput('configFavicon'),
					'homePageId' => $this->getInput('configHomePageId', helper::FILTER_ID),
					'language' => $this->getInput('configLanguage'),
					'metaDescription' => $this->getInput('configMetaDescription'),
					'social' => [
						'facebookId' => $this->getInput('configSocialFacebookId'),
						'googleplusId' => $this->getInput('configSocialGoogleplusId'),
						'instagramId' => $this->getInput('configSocialInstagramId'),
						'pinterestId' => $this->getInput('configSocialPinterestId'),
						'twitterId' => $this->getInput('configSocialTwitterId'),
						'youtubeId' => $this->getInput('configSocialYoutubeId')
					],
					'title' => $this->getInput('configTitle')
				]
			]);
			if(empty(template::$notices)) {
				// Active l'URL rewriting
				$htaccess = file_get_contents('.htaccess');
				$rewriteRule = explode('# URL rewriting', $htaccess);
				if($this->getInput('rewrite', helper::FILTER_BOOLEAN)) {
					if(empty($rewriteRule[1])) {
						file_put_contents('.htaccess',
							$htaccess . PHP_EOL .
							'RewriteEngine on' . PHP_EOL .
							'RewriteBase ' . helper::baseUrl(false, false) . PHP_EOL .
							'RewriteCond %{REQUEST_FILENAME} !-f' . PHP_EOL .
							'RewriteCond %{REQUEST_FILENAME} !-d' . PHP_EOL .
							'RewriteRule ^(.*)$ index.php?$1 [L]'
						);
					}
				}
				// Désactive l'URL rewriting
				else if(empty($rewriteRule[1]) === false) {
					file_put_contents('.htaccess', $rewriteRule[0] . '# URL rewriting');
				}
			}
			return [
				'redirect' => $this->getUrl(),
				'notification' => 'Configuration enregistrée',
				'state' => true
			];
		}
		// Affichage du template
		else {
			return [
				'title' => 'Configuration',
				'view' => true
			];
		}
	}

}