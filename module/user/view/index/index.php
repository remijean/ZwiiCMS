<?php echo template::table([10, 1, 1], $module::$users); ?>
<div class="row">
	<div class="col2 offset10">
		<?php echo template::button('userAdd[]', [
			'href' => helper::baseUrl() . 'user/add',
			'value' => 'Ajouter'
		]); ?>
	</div>
</div>