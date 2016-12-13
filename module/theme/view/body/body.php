<h3><?php echo helper::translate('Options de l\'arrière plan'); ?></h3>
<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Couleur'); ?></h4>
				<?php echo template::text('themeBodyBackgroundColor', [
					'class' => 'colorPicker',
					'label' => 'Fond',
					'value' => $this->getData(['theme', 'body', 'backgroundColor'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Image'); ?></h4>
				<?php echo template::file('themeBodyImage', [
					'label' => 'Fond',
					'value' => $this->getData(['theme', 'body', 'image'])
				]); ?>
				<div id="themeBodyImageOptions" class="displayNone">
					<div class="row">
						<div class="col6">
							<?php echo template::select('themeBodyImageRepeat', $module::$repeats, [
								'label' => 'Répétition',
								'selected' => $this->getData(['theme', 'body', 'imageRepeat'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::select('themeBodyImagePosition', $module::$imagePositions, [
								'label' => 'Position',
								'selected' => $this->getData(['theme', 'body', 'imagePosition'])
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col6">
							<?php echo template::select('themeBodyImageAttachment', $module::$attachments, [
								'label' => 'Fixation',
								'selected' => $this->getData(['theme', 'body', 'imageAttachment'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::select('themeBodyImageSize', $module::$sizes, [
								'label' => 'Taille',
								'selected' => $this->getData(['theme', 'body', 'imageSize'])
							]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('themeBodyBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeBodySave'); ?>
		</div>
	</div>
</form>