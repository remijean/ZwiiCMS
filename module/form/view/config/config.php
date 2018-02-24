<div id="formConfigCopy" class="displayNone">
	<div class="formConfigInput">
		<?php echo template::hidden('formConfigPosition[]', [
			'class' => 'formConfigPosition'
		]); ?>
		<div class="row">
			<div class="col1">
				<?php echo template::button('formConfigMove[]', [
					'value' => template::ico('sort'),
					'class' => 'formConfigMove'
				]); ?>
			</div>
			<div class="col5">
				<?php echo template::text('formConfigName[]', [
					'placeholder' => 'Intitulé'
				]); ?>
			</div>
			<div class="col4">
				<?php echo template::select('formConfigType[]', $module::$types, [
					'class' => 'formConfigType'
				]); ?>
			</div>
			<div class="col1">
				<?php echo template::button('formConfigMoreToggle[]', [
					'value' => template::ico('gear'),
					'class' => 'formConfigMoreToggle'
				]); ?>
			</div>
			<div class="col1">
				<?php echo template::button('formConfigDelete[]', [
					'value' => template::ico('minus'),
					'class' => 'formConfigDelete'
				]); ?>
			</div>
		</div>
		<div class="formConfigMore displayNone">
			<?php echo template::text('formConfigValues[]', [
				'placeholder' => 'Liste des valeurs séparées par des virgules (valeur1,valeur2,...)',
				'class' => 'formConfigValues',
				'classWrapper' => 'displayNone formConfigValuesWrapper'
			]); ?>
			<?php echo template::checkbox('formConfigRequired[]', true, 'Champ obligatoire'); ?>
		</div>
	</div>
</div>
<?php echo template::formOpen('formConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('formConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col3 offset5">
			<?php echo template::button('formConfigData', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/data',
				'value' => 'Gérer les données'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('formConfigSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Configuration</h4>
				<?php echo template::text('formConfigButton', [
					'help' => 'Laissez vide afin de conserver le texte par défaut.',
					'label' => 'Texte du bouton de soumission',
					'value' => $this->getData(['module', $this->getUrl(0), 'config', 'button'])
				]); ?>
				<?php echo template::checkbox('formConfigMailOptionsToggle', true, 'Envoyer par mail les données saisies aux utilisateurs d\'un groupe', [
					'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'group'])
				]); ?>
				<div id="formConfigMailOptions" class="displayNone">
					<div class="row">
						<div class="col6">
							<?php echo template::select('formConfigGroup', self::$groupNews, [
								'label' => 'Groupe',
								'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'group'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::text('formConfigSubject', [
								'help' => 'Laissez vide afin de conserver le texte par défaut.',
								'label' => 'Sujet du mail',
								'value' => $this->getData(['module', $this->getUrl(0), 'config', 'subject'])
							]); ?>
						</div>
					</div>
				</div>
				<?php echo template::checkbox('formConfigPageIdToggle', true, 'Rediriger vers une page du site après soumission du formulaire', [
					'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'pageId'])
				]); ?>
				<?php echo template::select('formConfigPageId', $module::$pages, [
					'classWrapper' => 'displayNone',
					'label' => 'Page',
					'selected' => $this->getData(['module', $this->getUrl(0), 'config', 'pageId'])
				]); ?>
				<?php echo template::checkbox('formConfigCapcha', true, 'Capcha à remplir pour soumettre le formulaire', [
					'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'capcha'])
				]); ?>
			</div>
			<div class="block">
				<h4>Liste des champs</h4>
				<div id="formConfigNoInput">
					<?php echo template::speech('Le formulaire ne contient aucun champ.'); ?>
				</div>
				<div id="formConfigInputs"></div>
				<div class="row">
					<div class="col1 offset11">
						<?php echo template::button('formConfigAdd', [
							'value' => template::ico('plus')
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>