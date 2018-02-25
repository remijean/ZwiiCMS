<?php echo template::formOpen('themeAdvancedForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('themeAdvancedBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'theme',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::button('themeAdvancedReset', [
				'href' => helper::baseUrl() . 'theme/reset',
				'class' => 'buttonRed',
				'ico' => 'cancel',
				'value' => 'Réinitialiser'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('themeAdvancedSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('themeAdvancedCss', [
				'value' => file_get_contents('site/data/custom.css'),
				'class' => 'editorCss'
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>