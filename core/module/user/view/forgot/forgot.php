<?php echo template::formOpen('userForgotForm'); ?>
	<?php echo template::text('userForgotId', [
		'label' => 'Identifiant'
	]); ?>
	<div class="row">
		<div class="col3 offset6">
			<?php echo template::button('userForgotBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'user/login/' . $this->getUrl(2),
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3">
			<?php echo template::submit('userForgotSubmit', [
				'value' => 'Valider'
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>