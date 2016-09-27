<form>
	<?php echo template::input('pageName', [
		'label' => 'Nom de la page'
	]); ?>
	<?php echo template::input('pageContent'); ?>
	<?php echo template::button('pageAdd', [
		'type' => 'submit',
		'value' => 'Créer'
	]); ?>
</form>