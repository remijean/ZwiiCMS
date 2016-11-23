<h3><?php echo helper::translate('Options du menu'); ?></h3>
<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Couleur'); ?></h4>
				<?php echo template::text('themeMenuBackgroundColor', [
					'class' => 'colorPicker',
					'label' => 'Couleur de fond',
					'value' => $this->getData(['theme', 'menu', 'backgroundColor'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Mise en forme'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeMenuTextTransform', $module::$textTransforms, [
							'label' => 'Capitalisation du texte',
							'selected' => $this->getData(['theme', 'menu', 'textTransform'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeMenuFontWeight', $module::$fontWeights, [
							'label' => 'Épaisseur du texte',
							'selected' => $this->getData(['theme', 'menu', 'fontWeight'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Disposition'); ?></h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeMenuPosition', $module::$menuPositions, [
							'label' => 'Position',
							'selected' => $this->getData(['theme', 'menu', 'position'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeMenuHeight', $module::$menuHeights, [
							'label' => 'Hauteur',
							'selected' => $this->getData(['theme', 'menu', 'height'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeMenuTextAlign', $module::$aligns, [
							'label' => 'Alignement du contenu',
							'selected' => $this->getData(['theme', 'menu', 'textAlign'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('themeMenuBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeMenuSave'); ?>
		</div>
	</div>
</form>