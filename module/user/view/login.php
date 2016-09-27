<h1>Connexion</h1>
<form>
	<div class="row">
		<div class="col4">
			<?php echo template::input('userId', [
				'label' => 'Identifiant'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col4">
			<?php echo template::input('userPassword', [
				'type' => 'password',
				'label' => 'Mot de passe'
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
			<?php echo template::button('userLogin', [
				'type' => 'submit',
				'value' => 'Me connecter'
			]); ?>
		</div>
	</div>
</form>