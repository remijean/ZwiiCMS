<p><?php echo helper::i18n('Veuillez saisir les champs ci-dessous afin de terminer l\'installation.'); ?></p>
<form method="post">
	<?php echo template::text('installConfigId', [
		'autocomplete' => 'off',
		'label' => 'Identifiant'
	]); ?>
	<div class="row">
		<div class="col6">
			<?php echo template::password('installConfigPassword', [
				'autocomplete' => 'off',
				'label' => 'Mot de passe'
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('installConfigConfirmPassword', [
				'autocomplete' => 'off',
				'label' => 'Confirmation'
			]); ?>
		</div>
	</div>
	<?php echo template::mail('installConfigMail', [
		'autocomplete' => 'off',
		'label' => 'Adresse mail'
	]); ?>
	<div class="row">
		<div class="col6">
			<?php echo template::text('installConfigFirstname', [
				'autocomplete' => 'off',
				'label' => 'Prénom'
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::text('installConfigLastname', [
				'autocomplete' => 'off',
				'label' => 'Nom'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col3 offset6">
			<?php echo template::button('installConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'install',
				'ico' => 'left',
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