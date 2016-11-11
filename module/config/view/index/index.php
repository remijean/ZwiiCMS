<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Informations principales</h4>
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
				<h4>Options avancés</h4>
				<?php echo template::file('configFavicon', [
					'label' => 'Favicon',
					'selected' => $this->getData(['config', 'favicon'])
				]); ?>
				<?php echo template::text('configAnalyticsId', [
					'label' => 'Google Analytics',
					'value' => $this->getData(['config', 'analyticsId']),
					'help' => 'Saisissez l\'ID de suivi de votre propriété Google Analytics.',
					'placeholder' => 'UA-XXXXXXXX-X'
				]); ?>
				<?php echo template::checkbox('configCookieConsent', true, 'Message de consentement pour l\'utilisation des cookies', [
					'checked' => $this->getData(['config', 'cookieConsent'])
				]); ?>
				<?php echo template::checkbox('rewrite', true, 'Activer la réécriture d\'URL', [
					'checked' => helper::checkRewrite(),
					'help' => 'Supprime le point d\'interrogation de l\'URL (si vous n\'arrivez pas à cocher la case, vérifiez que le module d\'URL rewriting de votre serveur est bien activé).',
					'disabled' => helper::checkServerModRewrite() === false
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4>Réseaux sociaux</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialFacebookId', [
							'label' => 'Facebook',
							'value' => $this->getData(['config', 'social', 'facebookId']),
							'help' => 'Saisissez votre ID Facebook : https://www.facebook.com/[CETTE PARTIE].'
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialGoogleplusId', [
							'label' => 'Google+',
							'value' => $this->getData(['config', 'social', 'googleplusId']),
							'help' => 'Saisissez votre ID Google+ : https://plus.google.com/[CETTE PARTIE].'
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialInstagramId', [
							'label' => 'Instagram',
							'value' => $this->getData(['config', 'social', 'instagramId']),
							'help' => 'Saisissez votre ID Instagram : https://www.instagram.com/[CETTE PARTIE].'
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialPinterestId', [
							'label' => 'Pinterest',
							'value' => $this->getData(['config', 'social', 'pinterestId']),
							'help' => 'Saisissez votre ID Pinterest : https://pinterest.com/[CETTE PARTIE].'
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col6">
						<?php echo template::text('configSocialTwitterId', [
							'label' => 'Twitter',
							'value' => $this->getData(['config', 'social', 'twitterId']),
							'help' => 'Saisissez votre ID Twitter : https://twitter.com/[CETTE PARTIE].'
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('configSocialYoutubeId', [
							'label' => 'Youtube',
							'value' => $this->getData(['config', 'social', 'youtubeId']),
							'help' => 'Saisissez votre ID Youtube : https://www.youtube.com/channel/[CETTE PARTIE].'
						]); ?>
					</div>
				</div>
			</div>
			<div class="block">
				<h4>Système</h4>
				<?php echo template::text('configVersion', [
					'label' => 'Version de Zwii',
					'value' => self::ZWII_VERSION,
					'disabled' => true
				]); ?>
				<?php if(helper::checkZwiiVersion()): ?>
					<?php echo template::button('configNewVersion', [
						'href' => 'http://zwiicms.com/',
						'value' => 'Nouvelle version disponible !'
					]); ?>
				<?php endif; ?>
				<?php echo template::button('configExport', [
					'value' => 'Exporter le contenu',
					'href' => helper::baseUrl() . 'export'
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset10">
			<?php echo template::submit('configSubmit'); ?>
		</div>
	</div>
</form>