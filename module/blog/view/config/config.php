<div class="row">
	<div class="col2">
		<?php echo template::button('blogConfigBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
			'ico' => 'left',
			'value' => 'Retour'
		]); ?>
	</div>
	<div class="col2 offset6">
		<?php echo template::button('blogConfigComment', [
			'href' => helper::baseUrl() . $this->getUrl(0) . '/comment',
			'ico' => 'pencil',
			'value' => 'Commentaires'
		]); ?>
	</div>
	<div class="col2">
		<?php echo template::button('blogConfigAdd', [
			'href' => helper::baseUrl() . $this->getUrl(0) . '/add',
			'ico' => 'plus',
			'value' => 'Article'
		]); ?>
	</div>
</div>
<?php if($module::$articles): ?>
	<?php echo template::table([4, 4, 2, 1, 1], $module::$articles, ['Titre', 'Date de publication', 'Statut', '', '']); ?>
	<?php echo $module::$pages; ?>
<?php else: ?>
	<?php echo template::speech('Aucun article.'); ?>
<?php endif; ?>