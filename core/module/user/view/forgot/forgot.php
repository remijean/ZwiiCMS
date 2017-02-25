<form method="post">
	<?php echo template::text('userForgotId', [
		'label' => 'Identifiant',
		'required' => true
	]); ?>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('userForgotBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . 'user/login',
				'value' => 'Retour'

			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('userForgotSubmit', [
				'value' => 'Valider'
			]); ?>
		</div>
	</div>
</form>