<h3>Options de l'arrière plan</h3>
<form>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Couleur</h4>
				<?php echo template::text('themeBodyBackgroundColor', [
					'class' => 'colorPicker',
					'label' => 'Couleur du fond',
					'readonly' => true,
					'value' => $this->getData(['theme', 'body', 'backgroundColor'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4>Image</h4>
				<div class="row">
					<div class="col12">
						<?php echo template::file('themeBodyBackgroundImage', [
							'label' => 'Image du fond',
							'value' => $this->getData(['theme', 'body', 'backgroundImage'])
						]); ?>
					</div>
				</div>
				<div id="themeBodyBackgroundImageOptions" class="displayNone">
					<div class="row">
						<div class="col6">
							<?php echo template::select('themeBackgroundRepeat', $module::$repeats, [
								'label' => 'Répétition',
								'selected' => $this->getData(['theme', 'body', 'repeat'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::select('themeBackgroundPosition', $module::$positions, [
								'label' => 'Alignement',
								'selected' => $this->getData(['theme', 'body', 'position'])
							]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col6">
							<?php echo template::select('themeBackgroundAttachment', $module::$attachments, [
								'label' => 'Position',
								'selected' => $this->getData(['theme', 'body', 'attachment'])
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