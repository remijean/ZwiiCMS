<p><?php echo helper::translate('Veuillez saisir les champs ci-dessous afin de terminer l\'installation de Zwii.'); ?></p>
<form method="post">
	<div class="row">
		<div class="col6">
			<?php echo template::text('installConfigId', [
				'label' => 'Identifiant',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::mail('installConfigMail', [
				'label' => 'Adresse mail',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<?php echo template::text('installConfigFirstname', [
				'label' => 'Prénom',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::text('installConfigLastname', [
				'label' => 'Nom',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<?php echo template::password('installConfigPassword', [
				'label' => 'Mot de passe',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('installConfigConfirmPassword', [
				'label' => 'Confirmation',
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