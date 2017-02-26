<p><?php echo helper::translate('Veuillez saisir les champs ci-dessous afin de terminer l\'installation.'); ?></p>
<form method="post">
	<?php echo template::text('installConfigId', [
		'autocomplete' => 'off',
		'label' => 'Identifiant',
		'required' => true
	]); ?>
	<div class="row">
		<div class="col6">
			<?php echo template::password('installConfigPassword', [
				'autocomplete' => 'off',
				'label' => 'Mot de passe',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('installConfigConfirmPassword', [
				'autocomplete' => 'off',
				'label' => 'Confirmation',
				'required' => true
			]); ?>
		</div>
	</div>
	<?php echo template::mail('installConfigMail', [
		'autocomplete' => 'off',
		'label' => 'Adresse mail',
		'required' => true
	]); ?>
	<div class="row">
		<div class="col6">
			<?php echo template::text('installConfigFirstname', [
				'autocomplete' => 'off',
				'label' => 'Prénom',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::text('installConfigLastname', [
				'autocomplete' => 'off',
				'label' => 'Nom',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col3 offset6">
			<?php echo template::button('installConfigBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . 'install',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3">
			<?php echo template::submit('installConfigSubmit', [
				'value' => 'Installer'
			]); ?>
		</div>
	</div>
</form>