<form>
	<?php echo template::input('pageName', [
		'label' => 'Nom de la page'
	]); ?>
	<?php echo template::textarea('pageContent'); ?>
	<?php echo template::button('pageAdd', [
		'type' => 'submit',
		'value' => 'Créer'
	]); ?>
</form>