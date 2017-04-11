<p><?php echo helper::translate('Veuillez choisir la langue de votre site, vous pourrez la changer plus tard.'); ?></p>
<form method="post">
	<?php echo template::select('installLanguage', $module::$languages, [
		'label' => 'Langue de l\'interface',
		'selected' => $this->getData(['config', 'language'])
	]); ?>
	<div class="row">
		<div class="col3 offset9">
			<?php echo template::submit('installSubmit', [
				'value' => 'Continuer'
			]); ?>
		</div>
	</div>
</form>