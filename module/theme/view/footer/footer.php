<h3><?php echo helper::translate('Options du pied de page'); ?></h3>
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
				<h4><?php echo helper::translate('Alignement du contenu'); ?></h4>
				<div class="row">
					<div class="col4">
						<?php echo template::select('themeFooterSocialsAlign', $module::$aligns, [
							'label' => 'Réseaux sociaux',
							'selected' => $this->getData(['theme', 'footer', 'socialsAlign'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeFooterTextAlign', $module::$aligns, [
							'label' => 'Texte',
							'selected' => $this->getData(['theme', 'footer', 'textAlign'])
						]); ?>
					</div>
					<div class="col4">
						<?php echo template::select('themeFooterCopyrightAlign', $module::$aligns, [
							'label' => 'Copyright',
							'selected' => $this->getData(['theme', 'footer', 'copyrightAlign'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Contenu'); ?></h4>
				<?php echo template::textarea('themeFooterText', [
					'label' => 'Texte du pied de page',
					'value' => $this->getData(['theme', 'footer', 'text'])
				]); ?>
				<?php echo template::checkbox('themeFooterLoginLink', true, 'Lien de connexion', [
					'checked' => $this->getData(['theme', 'footer', 'loginLink']),
					'help' => 'Visible seulement sur cette page et lorsque vous n\'êtes pas connecté.'
				]); ?>
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
			<?php echo template::submit('themeFooterSubmit'); ?>
		</div>
	</div>
</form>