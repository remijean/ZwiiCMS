<form id="blogAddForm" method="post">
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2 offset6">
			<?php echo template::button('blogAddDraft', [
				'ico' => 'check',
				'uniqueSubmission' => true,
				'value' => 'Brouillon'
			]); ?>
			<?php echo template::hidden('blogAddStatus', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('blogAddPublish', [
				'value' => 'Publier'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('blogAddTitle', [
							'label' => 'Titre',
							'required' => true
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::file('blogAddPicture', [
							'help' => helper::translate('Taille optimale de l\'image de couverture :') . ' ' . ((int) substr($this->getData(['theme', 'site', 'width']), 0, -2) - (20 * 2)) . ' x 350 pixels.',
							'label' => 'Image de couverture',
							'lang' => $this->getData(['config', 'language']),
							'type' => 1,
							'required' => true
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo template::textarea('blogAddContent', [
		'class' => 'editor'
	]); ?>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Options avancés'); ?></h4>
				<?php echo template::select('blogAddUserId', $module::$users, [
					'label' => 'Auteur',
					'selected' => $this->getUser('id')
				]); ?>
				<?php echo template::date('blogAddPublishedOn', [
					'help' => 'L\'article est consultable à partir du moment ou la date de publication est passée.',
					'label' => 'Date de publication',
					'value' => time()
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Options avancés'); ?></h4>
				<?php echo template::checkbox('blogAddCloseComment', true, 'Fermer les commentaires'); ?>
			</div>
		</div>
	</div>
</form>