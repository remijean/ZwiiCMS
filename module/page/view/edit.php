<form>
	<?php echo template::input('pageName', [
		'label' => 'Nom de la page',
		'value' => $this->getData(['page', $this->getUrl(2), 'name'])
	]); ?>
	<?php echo template::input('pageContent', [
		'value' => $this->getData(['page', $this->getUrl(2), 'content'])
	]); ?>
	<?php echo template::button('pageEdit', [
		'type' => 'submit',
		'value' => 'Modifier'
	]); ?>
</form>