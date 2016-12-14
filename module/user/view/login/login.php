<form method="post">
	<div class="row">
		<div class="col4">
			<?php echo template::text('userId', [
				'label' => 'Identifiant',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col4">
			<?php echo template::password('userPassword', [
				'label' => 'Mot de passe',
				'required' => true
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::checkbox('userLongTime', true, 'Me connecter automatiquement à chaque visite'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2">
			<?php echo template::submit('userLogin', [
				'value' => 'Valider'
			]); ?>
		</div>
	</div>
</form>