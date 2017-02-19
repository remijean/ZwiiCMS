<?php echo template::table([3, 4, 3, 1, 1], $module::$users, ['Identifiant', 'Nom', 'Groupe', '', '']); ?>
<div class="row">
	<div class="col2 offset10">
		<?php echo template::button('userAdd[]', [
			'href' => helper::baseUrl() . 'user/add',
			'value' => 'Ajouter'
		]); ?>
	</div>
</div>