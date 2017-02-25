<p><?php echo helper::translate('Veuillez saisir les champs ci-dessous afin de terminer l\'installation de Zwii.'); ?></p>
<form method="post">
	<div class="row">
		<div class="col6">
			<?php echo template::text('installId', [
				'label' => 'Identifiant',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::mail('installMail', [
				'label' => 'Adresse mail',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<?php echo template::text('installFirstname', [
				'label' => 'Prénom',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::text('installLastname', [
				'label' => 'Nom',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<?php echo template::password('installPassword', [
				'label' => 'Mot de passe',
				'required' => true
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('installConfirmPassword', [
				'label' => 'Confirmation',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset10">
			<?php echo template::submit('installSubmit', [
				'value' => 'Installer'
			]); ?>
		</div>
	</div>
</form>