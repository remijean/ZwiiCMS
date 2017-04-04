<?php if($module::$articles): ?>
	<div class="row">
		<div class="col12">
			<?php foreach($module::$articles as $articleId => $article): ?>
				<div class="block">
					<h4>
						Par <?php echo $this->getData(['user', $article['userId'], 'firstname']) . ' ' . $this->getData(['user', $article['userId'], 'lastname']); ?>
						le <?php echo date('d/m/Y H:i', $article['publishedOn']); ?>
						<div class="blogComment">
							<a href="<?php echo helper::baseUrl() . $this->getUrl() . '/' . $articleId; ?>#comment">
								<?php echo count($article['comment']); ?>
							</a>
							<?php echo template::ico('comment', 'left'); ?>
						</div>
					</h4>
					<a href="<?php echo helper::baseUrl() . $this->getUrl() . '/' . $articleId; ?>" class="blogPicture">
						<img src="<?php echo helper::baseUrl(false) . 'site/file/thumb/' . $article['picture']; ?>">
					</a>
					<h2>
						<a href="<?php echo helper::baseUrl() . $this->getUrl() . '/' . $articleId; ?>">
							<?php echo $article['title']; ?>
						</a>
					</h2>
					<p class="blogContent">
						<?php echo helper::subword(strip_tags($article['content']), 0, 150); ?>...
						<a href="<?php echo helper::baseUrl() . $this->getUrl() . '/' . $articleId; ?>"><?php echo helper::translate('Lire la suite'); ?></a>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Aucun article.'); ?>
<?php endif; ?>