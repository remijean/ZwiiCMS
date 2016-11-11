<h3>Options du site</h3>
<form id="themeSiteForm">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Couleurs</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('themeTitleTextColor', [
							'class' => 'colorPicker',
							'label' => 'Couleur des titres',
							'readonly' => true,
							'value' => $this->getData(['theme', 'title', 'textColor'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('themeButtonBackgroundColor', [
							'class' => 'colorPicker',
							'label' => 'Couleur des boutons',
							'readonly' => true,
							'value' => $this->getData(['theme', 'button', 'backgroundColor'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4>Polices</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeTitleFont', self::$fonts, [
							'label' => 'Police des titres',
							'selected' => $this->getData(['theme', 'title', 'font'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeTextFont', self::$fonts, [
							'label' => 'Police du texte',
							'selected' => $this->getData(['theme', 'text', 'font'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Divers</h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeSiteWidth', [], [
							'label' => 'Largeur du site',
							'value' => $this->getData(['theme', 'site', 'widh'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteRadius', [], [
							'label' => 'Coins du site arrondis',
							'value' => $this->getData(['theme', 'site', 'radius'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeSiteShadow', [], [
							'label' => 'Ombre sur les bords du site',
							'value' => $this->getData(['theme', 'site', 'shadow'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('themeSiteBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeSiteSave'); ?>
		</div>
	</div>
</form>