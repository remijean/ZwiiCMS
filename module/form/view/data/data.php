<div class="row">
	<div class="col2">
		<?php echo template::button('formDataBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'ico' => 'left',
			'value' => 'Retour'
		]); ?>
	</div>
</div>
<?php echo template::table([12], $module::$data); ?>
<?php echo $module::$pagination; ?>