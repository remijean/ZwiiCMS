<?php $form = new form('pageForm'); ?>
	<?php $form->input('pageName', [
		'label' => 'Nom de la page',
		'value' => $this->getData(['page', $this->getUrl(2), 'name'])
	]); ?>
	<?php $form->input('pageContent', [
		'value' => $this->getData(['page', $this->getUrl(2), 'content'])
	]); ?>
	<?php $form->button('pageEdit', [
		'type' => 'submit',
		'value' => 'Modifier'
	]); ?>
<?php $form->close(); ?>