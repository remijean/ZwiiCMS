<?php echo template::table([12], $module::$data); ?>
<?php echo $module::$pages; ?>
<div class="row">
	<div class="col2 offset10">
		<?php echo template::button('formDataBack', [
			'class' => 'grey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'value' => 'Retour'
		]); ?>
	</div>
</div>