<?php echo template::formOpen('blogAddForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('blogAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('blogAddDraft', [
				'uniqueSubmission' => true,
				'value' => 'Enregistrer en brouillon'
			]); ?>
			<?php echo template::hidden('blogAddState', [
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
				<h4>Informations générales</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('blogAddTitle', [
							'label' => 'Titre'
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::file('blogAddPicture', [
							'help' => 'Taille optimale de l\'image de couverture : ' . ((int) substr($this->getData(['theme', 'site', 'width']), 0, -2) - (20 * 2)) . ' x 350 pixels.',
							'label' => 'Image de couverture',
							'type' => 1
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo template::textarea('blogAddContent', [
		'class' => 'editorWysiwyg'
	]); ?>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Options de publication</h4>
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
				<h4>Options avancés</h4>
				<?php echo template::checkbox('blogAddCloseComment', true, 'Fermer les commentaires'); ?>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>