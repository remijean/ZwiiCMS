<?php $form = new form('pageForm'); ?>
	<?php $form->input('pageName', [
		'label' => 'Nom de la page'
	]); ?>
	<?php $form->input('pageContent'); ?>
	<?php $form->button('pageAdd', [
		'type' => 'submit',
		'value' => 'Créer'
	]); ?>
<?php $form->close(); ?>
