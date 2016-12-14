<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('userAddName', [
					'label' => 'Nom',
					'required' => true,
					'value' => $this->getData(['user', $this->getUrl(2), 'name'])
				]); ?>
				<?php echo template::select('userAddRank', $module::$ranks, [
					'label' => 'Rang',
					'required' => true,
					'selected' => $this->getData(['user', $this->getUrl(2), 'rank'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Sécurité'); ?></h4>
				<?php echo template::password('userAddPassword', [
					'label' => 'Mot de passe',
					'required' => true
				]); ?>
				<?php echo template::password('userAddConfirmPassword', [
					'label' => 'Confirmation',
					'required' => true
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('userAddBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'user'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('userAddSave'); ?>
		</div>
	</div>
</form>