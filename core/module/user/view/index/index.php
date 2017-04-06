<div class="row">
	<div class="col2">
		<?php echo template::button('userAddBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl(false),
			'ico' => 'home',
			'value' => 'Accueil'
		]); ?>
	</div>
	<div class="col2 offset8">
		<?php echo template::button('userAdd', [
			'href' => helper::baseUrl() . 'user/add',
			'ico' => 'plus',
			'value' => 'Utilisateur'
		]); ?>
	</div>
</div>
<?php echo template::table([3, 4, 3, 1, 1], $module::$users, ['Identifiant', 'Nom', 'Groupe', '', '']); ?>