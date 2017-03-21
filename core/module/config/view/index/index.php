<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('configTitle', [
					'label' => 'Titre du site',
					'required' => true,
					'value' => $this->getData(['config', 'title'])
				]); ?>
				<?php echo template::textarea('configMetaDescription', [
					'label' => 'Description du site',
					'required' => true,
					'value' => $this->getData(['config', 'metaDescription'])
				]); ?>
				<?php echo template::select('configHomePageId', helper::arrayCollumn($this->getData(['page']), 'title', 'SORT_ASC'), [
					'label' => 'Page d\'accueil',
					'required' => true,
					'selected' => $this->getData(['config', 'homePageId'])
				]); ?>
			</div>
			<div class="block">
				<h4><?php echo helper::translate('Options avancées'); ?></h4>
				<?php echo template::file('configFavicon', [
					'extensions' => 'ico',
					'help' => 'Seule une image de format .ico est acceptée. Pensez à supprimer le cache de votre navigateur si la favicon ne change pas.',
					'label' => 'Favicon',
					'lang' => $this->getData(['config', 'language']),
					'value' => $this->getData(['config', 'favicon'])
				]); ?>
				<?php echo template::text('configAnalyticsId', [
					'help' => 'Saisissez l\'ID de suivi de votre propriété Google Analytics.',
					'label' => 'Google Analytics',
					'placeholder' => 'UA-XXXXXXXX-X',
					'value' => $this->getData(['config', 'analyticsId'])
				]); ?>
				<?php echo template::checkbox('configCookieConsent', true, 'Message de consentement pour l\'utilisation des cookies', [
					'checked' => $this->getData(['config', 'cookieConsent'])
				]); ?>
				<?php echo template::checkbox('rewrite', true, 'Réécriture des URLs', [
					'checked' => helper::checkRewrite(),
					'help' => 'Afin d\'éviter de bloquer votre site pensez à vérifier que le module de réécriture d\'URL est bien actif sur votre serveur avant d\'activer cette fonctionnalité.'
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Réseaux sociaux'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialFacebookId', [
							'help' => 'Saisissez votre ID Facebook : https://www.facebook.com/[CETTE PARTIE].',
							'label' => 'Facebook',
							'value' => $this->getData(['config', 'social', 'facebookId'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialGoogleplusId', [
							'help' => 'Saisissez votre ID Google+ : https://plus.google.com/[CETTE PARTIE].',
							'label' => 'Google+',
							'value' => $this->getData(['config', 'social', 'googleplusId'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialInstagramId', [
							'help' => 'Saisissez votre ID Instagram : https://www.instagram.com/[CETTE PARTIE].',
							'label' => 'Instagram',
							'value' => $this->getData(['config', 'social', 'instagramId'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialPinterestId', [
							'help' => 'Saisissez votre ID Pinterest : https://pinterest.com/[CETTE PARTIE].',
							'label' => 'Pinterest',
							'value' => $this->getData(['config', 'social', 'pinterestId'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialTwitterId', [
							'help' => 'Saisissez votre ID Twitter : https://twitter.com/[CETTE PARTIE].',
							'label' => 'Twitter',
							'value' => $this->getData(['config', 'social', 'twitterId'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialYoutubeId', [
							'help' => 'Saisissez votre ID Youtube : https://www.youtube.com/channel/[CETTE PARTIE].',
							'label' => 'Youtube',
							'value' => $this->getData(['config', 'social', 'youtubeId'])
						]); ?>
					</div>
				</div>
			</div>
			<div class="block">
				<h4><?php echo helper::translate('Système'); ?></h4>
				<?php echo template::text('configVersion', [
					'label' => 'Version de Zwii',
					'readonly' => true,
					'value' => self::ZWII_VERSION
				]); ?>
				<?php echo template::select('configLanguage', $module::$languages, [
					'label' => 'Langue de l\'interface',
					'required' => true,
					'selected' => $this->getData(['config', 'language'])
				]); ?>
				<?php echo template::checkbox('configAutoBackup', true, 'Sauvegarder automatique des données', [
					'checked' => $this->getData(['config', 'autoBackup']),
					'help' => 'Sauvegarde une fois par jour le fichier de données dans le dossier site/backup/. La sauvegarde est conservée 30 jours.'
				]); ?>
				<div class="row">
					<div class="col6">
						<?php echo template::button('configExport', [
							'href' => helper::baseUrl() . 'config/backup',
							'value' => 'Exporter les données'
						]); ?>
					</div>
					<?php if(helper::checkNewVersion()): ?>
						<div class="col6">
							<?php echo template::button('configNewVersion', [
								'href' => 'http://zwiicms.com/',
								'value' => 'Mise à jour disponible'
							]); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset10">
			<?php echo template::submit('configSubmit'); ?>
		</div>
	</div>
</form>