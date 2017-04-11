<div class="row">
	<div class="col2">
		<?php echo template::button('blogCommentBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
			'ico' => 'left',
			'value' => 'Retour'
		]); ?>
	</div>
</div>
<?php if($module::$comments): ?>
	<?php echo template::table([3, 6, 2, 1], $module::$comments, ['Date', 'Contenu', 'Auteur', '']); ?>
	<?php echo $module::$pages; ?>
<?php else: ?>
	<?php echo template::speech('Aucun commentaire.'); ?>
<?php endif; ?>