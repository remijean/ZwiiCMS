<h3><?php echo helper::translate('Options du bas de page'); ?></h3>
<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Couleur'); ?></h4>
				<?php echo template::text('themeFooterBackgroundColor', [
					'class' => 'colorPicker',
					'label' => 'Fond',
					'value' => $this->getData(['theme', 'footer', 'backgroundColor'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Disposition'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('themeFooterPosition', $module::$footerPositions, [
							'label' => 'Position',
							'selected' => $this->getData(['theme', 'footer', 'position'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::select('themeFooterHeight', $module::$footerHeights, [
							'label' => 'Hauteur',
							'selected' => $this->getData(['theme', 'footer', 'height'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Disposition du contenu'); ?></h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeFooterSocialsAlign', $module::$aligns, [
							'label' => 'Alignement des réseaux sociaux',
							'selected' => $this->getData(['theme', 'footer', 'socialsAlign'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeFooterTextAlign', $module::$aligns, [
							'label' => 'Alignement du texte',
							'selected' => $this->getData(['theme', 'footer', 'textAlign'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeFooterCopyrightAlign', $module::$aligns, [
							'label' => 'Alignement du copyright',
							'selected' => $this->getData(['theme', 'footer', 'copyrightAlign'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('themeFooterBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeFooterSave'); ?>
		</div>
	</div>
</form>