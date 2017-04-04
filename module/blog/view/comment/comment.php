<?php if($module::$comments): ?>
	<?php echo template::table([6, 4, 1, 1], $module::$comments, ['Auteur', 'Date de création', '', '']); ?>
	<?php echo $module::$pages; ?>
<?php else: ?>
	<?php echo template::speech('Aucun commentaire.'); ?>
<?php endif; ?>