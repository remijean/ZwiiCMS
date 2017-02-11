<div id="formConfigCopy" class="displayNone">
	<div class="formConfigInput">
		<?php echo template::hidden('formConfigPosition[]', [
			'class' => 'formConfigPosition'
		]); ?>
		<div class="row">
			<div class="col1">
				<?php echo template::button('formConfigMove[]', [
					'value' => template::ico('up-down'),
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
<form method="post">
	<div class="block">
		<h4><?php echo helper::translate('Configuration'); ?></h4>
		<?php echo template::text('formConfigButton', [
			'label' => 'Personnaliser le texte du bouton de soumission',
			'value' => $this->getData(['module', $this->getUrl(0), 'config', 'button'])
		]); ?>
		<?php echo template::checkbox('formConfigMailOptionsToggle', true, 'Recevoir les données saisies par mail', [
			'checked' => (bool) $this->getData(['module', $this->getUrl(0), 'config', 'mail'])
		]); ?>
		<div id="formConfigMailOptions" class="displayNone">
			<?php echo template::text('formConfigMail', [
				'label' => 'Adresse mail',
				'value' => $this->getData(['module', $this->getUrl(0), 'config', 'mail'])
			]); ?>
		</div>
		<?php echo template::checkbox('formConfigCapcha', true, 'Ajouter un capcha à remplir pour soumettre le formulaire', [
			'checked' => $this->getData(['module', $this->getUrl(0), 'config', 'capcha'])
		]); ?>
	</div>
	<div class="block">
		<h4><?php echo helper::translate('Liste des champs'); ?></h4>
		<p id="formConfigNoInput"><?php echo helper::translate('Le formulaire ne contient aucun champ.'); ?></p>
		<div id="formConfigInputs"></div>
		<div class="row">
			<div class="col1 offset11">
				<?php echo template::button('formConfigAdd', [
					'value' => template::ico('plus')
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col3">
			<?php echo template::button('formConfigData', [
				'href' => helper::baseUrl() . $this->getUrl(0) . '/data',
				'value' => 'Données enregistrées'

			]); ?>
		</div>
		<div class="col2 offset5">
			<?php echo template::button('formConfigBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'value' => 'Retour'

			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('formConfigSubmit'); ?>
		</div>
	</div>
</form>