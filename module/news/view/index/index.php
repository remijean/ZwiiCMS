<?php if($module::$news): ?>
	<div class="row">
		<div class="col12">
			<?php foreach($module::$news as $newsId => $news): ?>
				<div class="block">
					<h4>
						<?php echo $this->getData(['user', $news['userId'], 'firstname']) . ' ' . $this->getData(['user', $news['userId'], 'lastname']); ?>
						<?php echo helper::i18n('le'); ?> <?php echo date('d/m/Y H:i', $news['publishedOn']); ?>
					</h4>
					<h2><?php echo $news['title']; ?></h2>
					<?php echo $news['content']; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Aucune news.'); ?>
<?php endif; ?>