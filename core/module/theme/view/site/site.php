<h3><?php echo helper::translate('Options du site'); ?></h3>
<form method="post">
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Couleurs'); ?></h4>
				<div class="row">
					<div class="col4">
						<?php echo template::text('themeTitleTextColor', [
							'class' => 'colorPicker',
							'label' => 'Titres',
							'value' => $this->getData(['theme', 'title', 'textColor'])
						]); ?>
					</div>
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
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Polices'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeTitleFont', $module::$fonts, [
							'label' => 'Titres',
							'selected' => $this->getData(['theme', 'title', 'font'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeTextFont', $module::$fonts, [
							'label' => 'Texte',
							'selected' => $this->getData(['theme', 'text', 'font'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Mise en forme des titres'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeTitleTextTransform', $module::$textTransforms, [
							'label' => 'Caractères',
							'selected' => $this->getData(['theme', 'title', 'textTransform'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeTitleFontWeight', $module::$fontWeights, [
							'label' => 'Style',
							'selected' => $this->getData(['theme', 'title', 'fontWeight'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Apparence'); ?></h4>
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
		<div class="col2 offset8">
			<?php echo template::button('themeSiteBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeSiteSubmit'); ?>
		</div>
	</div>
</form>