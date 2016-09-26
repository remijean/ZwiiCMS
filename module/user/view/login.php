<?php $form = new form('userForm'); ?>
	<?php $form->input('userId', [
		'label' => 'Identifiant'
	]); ?>
	<?php $form->input('userPassword', [
		'type' => 'password',
		'label' => 'Mot de passe'
	]); ?>
	<?php $form->button('userLogin', [
		'type' => 'submit',
		'value' => 'Se connecter'
	]); ?>
<?php $form->close(); ?>
