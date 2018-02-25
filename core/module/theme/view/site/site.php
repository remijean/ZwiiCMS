<?php echo template::formOpen('themeSiteForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('themeSiteBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('themeSiteSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Couleurs</h4>
				<div class="row">
					<div class="col4">
						<?php echo template::text('themeSiteBackgroundColor', [
							'class' => 'colorPicker',
							'label' => 'Fond',
							'value' => $this->getData(['theme', 'site', 'backgroundColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('themeTextTextColor', [
							'class' => 'colorPicker',
							'label' => 'Texte',
							'value' => $this->getData(['theme', 'text', 'textColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('themeTitleTextColor', [
							'class' => 'colorPicker',
							'label' => 'Titres',
							'value' => $this->getData(['theme', 'title', 'textColor'])
						]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col4">
						<?php echo template::text('themeButtonBackgroundColor', [
							'class' => 'colorPicker',
							'label' => 'Boutons',
							'value' => $this->getData(['theme', 'button', 'backgroundColor'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::text('themeLinkTextColor', [
							'class' => 'colorPicker',
							'label' => 'Liens',
							'value' => $this->getData(['theme', 'link', 'textColor'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Apparence</h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeSiteWidth', $module::$widths, [
							'label' => 'Largeur du site',
							'selected' => $this->getData(['theme', 'site', 'width'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteRadius', $module::$radius, [
							'label' => 'Arrondi des coins',
							'selected' => $this->getData(['theme', 'site', 'radius'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteShadow', $module::$shadows, [
							'label' => 'Ombre sur les bords du site',
							'selected' => $this->getData(['theme', 'site', 'shadow'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Mise en forme du texte</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeTextFontSize', $module::$siteFontSizes, [
							'label' => 'Taille',
							'selected' => $this->getData(['theme', 'text', 'fontSize'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeTextFont', $module::$fonts, [
							'label' => 'Police',
							'selected' => $this->getData(['theme', 'text', 'font'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4>Mise en forme des titres</h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeTitleTextTransform', $module::$textTransforms, [
							'label' => 'Caractères',
							'selected' => $this->getData(['theme', 'title', 'textTransform'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeTitleFontWeight', $module::$fontWeights, [
							'label' => 'Style',
							'selected' => $this->getData(['theme', 'title', 'fontWeight'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeTitleFont', $module::$fonts, [
							'label' => 'Police',
							'selected' => $this->getData(['theme', 'title', 'font'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>