<h3><?php echo helper::translate('Options de la bannière'); ?></h3>
<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Couleurs'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('themeHeaderBackgroundColor', [
							'class' => 'colorPicker',
							'label' => 'Fond',
							'value' => $this->getData(['theme', 'header', 'backgroundColor'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('themeHeaderTextColor', [
							'class' => 'colorPicker',
							'label' => 'Texte',
							'value' => $this->getData(['theme', 'header', 'textColor'])
						]); ?>
					</div>
				</div>
			</div>
			<div class="block">
				<h4><?php echo helper::translate('Mise en forme du texte'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeHeaderTextTransform', $module::$textTransforms, [
							'label' => 'Capitalisation',
							'selected' => $this->getData(['theme', 'header', 'textTransform'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeHeaderFontWeight', $module::$fontWeights, [
							'label' => 'Épaisseur',
							'selected' => $this->getData(['theme', 'header', 'fontWeight'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Image'); ?></h4>
				<?php echo template::file('themeHeaderImage', [
					'label' => 'Fond',
					'value' => $this->getData(['theme', 'header', 'image'])
				]); ?>
				<div id="themeHeaderImageOptions" class="displayNone">
					<div class="row">
						<div class="col6">
							<?php echo template::select('themeHeaderImageRepeat', $module::$repeats, [
								'label' => 'Répétition',
								'selected' => $this->getData(['theme', 'header', 'imageRepeat'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::select('themeHeaderImagePosition', $module::$imagePositions, [
								'label' => 'Position',
								'selected' => $this->getData(['theme', 'header', 'imagePosition'])
							]); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="block">
				<h4><?php echo helper::translate('Police de caractères'); ?></h4>
				<?php echo template::select('themeHeaderFont', $module::$fonts, [
					'label' => 'Titre',
					'selected' => $this->getData(['theme', 'header', 'font'])
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Disposition'); ?></h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeHeaderPosition', $module::$headerPositions, [
							'label' => 'Position',
							'selected' => $this->getData(['theme', 'header', 'position'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeHeaderHeight', $module::$headerHeights, [
							'label' => 'Hauteur',
							'selected' => $this->getData(['theme', 'header', 'height'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeHeaderTextAlign', $module::$aligns, [
							'label' => 'Alignement du contenu',
							'selected' => $this->getData(['theme', 'header', 'textAlign'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('themeHeaderBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeHeaderSubmit'); ?>
		</div>
	</div>
</form>