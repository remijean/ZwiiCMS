<div id="blogArticlePicture" style="background-image:url('<?php echo helper::baseUrl(false) . 'site/file/source/' . $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'picture']); ?>');"></div>
<h4 class="textAlignRight">
	Par
	<?php echo $this->getData(['user', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'userId']), 'firstname']); ?>
	<?php echo $this->getData(['user', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'userId']), 'lastname']); ?>
	le <?php echo date('d/m/Y H:i', $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'publishedOn'])); ?>
</h4>
<?php echo $this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'content']); ?>
<h2 id="comment">
	<?php $commentsNb = count($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'comment'])); ?>
	<?php echo $commentsNb . ' ' . helper::translate($commentsNb > 1 ? 'commentaires' : 'commentaire'); ?>
</h2>
<?php if($this->getData(['module', $this->getUrl(0), $this->getUrl(1), 'closeComment'])): ?>
	<p><?php echo helper::translate('Les commentaires sont fermés pour cet article.'); ?></p>
<?php else: ?>
	<form id="blogArticleForm" method="post">
		<?php echo template::text('blogArticleCommentShow', [
			'placeholder' => 'Rédiger un commentaire...',
			'readonly' => true
		]); ?>
		<div id="blogArticleCommentWrapper" class="displayNone">
			<?php if($this->getUser('password') === $this->getInput('ZWII_USER_PASSWORD')): ?>
				<?php echo template::text('blogArticleUserName', [
					'label' => 'Nom',
					'readonly' => true,
					'value' => $this->getUser('firstname') . ' ' . $this->getUser('lastname')
				]); ?>
				<?php echo template::hidden('blogArticleUserId', [
					'value' => $this->getUser('id')
				]); ?>
			<?php else: ?>
				<div class="row">
					<div class="col9">
						<?php echo template::text('blogArticleAuthor', [
							'label' => 'Nom',
							'required' => true
						]); ?>
					</div>
					<div class="col1 textAlignCenter verticalAlignBottom">
						<div id="blogArticleOr">Ou</div>
					</div>
					<div class="col2 verticalAlignBottom">
						<?php echo template::button('blogArticleLogin', [
							'href' => helper::baseUrl() . 'user/login/' . str_replace('/', '_', $this->getUrl()) . '__comment',
							'value' => 'Connexion'
						]); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php echo template::textarea('blogArticleContent', [
				'label' => 'Commentaire',
				'maxlength' => '500',
				'required' => true
			]); ?>
			<?php if($this->getUser('password') !== $this->getInput('ZWII_USER_PASSWORD')): ?>
				<div class="row">
					<div class="col4">
						<?php echo template::capcha('blogArticleCapcha'); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="row">
				<div class="col2 offset8">
					<?php echo template::button('blogArticleCommentHide', [
						'class' => 'buttonGrey',
						'value' => 'Annuler'
					]); ?>
				</div>
				<div class="col2">
					<?php echo template::submit('blogArticleSubmit', [
						'ico' => '',
						'value' => 'Envoyer'
					]); ?>
				</div>
			</div>
		</div>
	</form>
<?php endif;?>
<div class="row">
	<div class="col12">
		<?php foreach($module::$comments as $commentId => $comment): ?>
			<div class="block">
				<h4>
					<?php if($comment['userId']): ?>
						<?php echo $this->getData(['user', $comment['userId'], 'firstname']) . ' ' . $this->getData(['user', $comment['userId'], 'lastname']); ?>
					<?php else: ?>
						<?php echo $comment['author']; ?>
					<?php endif; ?>
					le <?php echo date('d/m/Y - H:i', $comment['createdOn']); ?>
				</h4>
				<?php echo $comment['content']; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?php echo $module::$pages; ?>