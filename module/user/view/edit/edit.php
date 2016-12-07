<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('userEditName', [
					'label' => 'Nom',
					'value' => $this->getData(['user', $this->getUrl(2), 'name'])
				]); ?>
				<?php echo template::select('userEditRank', $module::$ranks, [
					'label' => 'Rang',
					'selected' => $this->getData(['user', $this->getUrl(2), 'rank'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Sécurité'); ?></h4>
				<?php echo template::password('userEditName', [
					'label' => 'Nouveau mot de passe'
				]); ?>
				<?php echo template::password('userEditName', [
					'label' => 'Confirmation'
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('userEditBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . 'user/all'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('userEditSave'); ?>
		</div>
	</div>
</form>