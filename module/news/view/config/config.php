<div class="row">
	<div class="col2">
		<?php echo template::button('newsConfigBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
			'ico' => 'left',
			'value' => 'Retour'
		]); ?>
	</div>
	<div class="col2 offset8">
		<?php echo template::button('newsConfigAdd', [
			'href' => helper::baseUrl() . $this->getUrl(0) . '/add',
			'ico' => 'plus',
			'value' => 'News'
		]); ?>
	</div>
</div>
<?php if($module::$news): ?>
	<?php echo template::table([4, 4, 2, 1, 1], $module::$news, ['Titre', 'Date de publication', 'État', '', '']); ?>
	<?php echo $module::$pages; ?>
<?php else: ?>
	<?php echo template::speech('Aucune news.'); ?>
<?php endif; ?>