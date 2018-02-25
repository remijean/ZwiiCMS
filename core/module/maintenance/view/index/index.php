<p>Notre site est actuellement en maintenance. Nous sommes désolés pour la gêne occasionnée et faisons notre possible pour être rapidement de retour.</p>
<div class="row">
	<div class="col4 offset8 textAlignCenter">
		<?php echo template::button('maintenanceLogin', [
			'value' => 'Administration',
			'href' => helper::baseUrl() . 'user/login',
			'ico' => 'lock'
		]); ?>
	</div>
</div>