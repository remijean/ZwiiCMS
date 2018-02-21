<?php echo template::formOpen('newsAddForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('newsAddBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('newsAddDraft', [
				'uniqueSubmission' => true,
				'value' => 'Enregistrer en brouillon'
			]); ?>
			<?php echo template::hidden('newsAddState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('newsAddPublish', [
				'value' => 'Publier'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Informations générales</h4>
				<?php echo template::text('newsAddTitle', [
					'label' => 'Titre'
				]); ?>
			</div>
		</div>
	</div>
	<?php echo template::textarea('newsAddContent', [
		'class' => 'editorWysiwyg'
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Options de publication</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('newsAddUserId', $module::$users, [
							'label' => 'Auteur',
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::date('newsAddPublishedOn', [
							'help' => 'La news est consultable à partir du moment ou la date de publication est passée.',
							'label' => 'Date de publication',
							'value' => time()
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>