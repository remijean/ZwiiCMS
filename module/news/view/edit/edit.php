<?php echo template::formOpen('newsEditForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('newsEditBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('newsEditDraft', [
				'uniqueSubmission' => true,
				'value' => 'Enregistrer en brouillon'
			]); ?>
			<?php echo template::hidden('newsEditState', [
				'value' => true
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('newsEditSubmit', [
				'value' => 'Publier'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Informations générales</h4>
				<?php echo template::text('newsEditTitle', [
					'label' => 'Titre',
					'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'title'])
				]); ?>
			</div>
		</div>
	</div>
	<?php echo template::textarea('newsEditContent', [
		'class' => 'editorWysiwyg',
		'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'content'])
	]); ?>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Options de publication</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::select('newsEditUserId', $module::$users, [
							'label' => 'Auteur',
							'selected' => $this->getUser('id')
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::date('newsEditPublishedOn', [
							'help' => 'La news est consultable à partir du moment ou la date de publication est passée.',
							'label' => 'Date de publication',
							'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'publishedOn'])
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>