<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('userEditName', [
					'label' => 'Nom',
					'required' => true,
					'value' => $this->getData(['user', $this->getUrl(2), 'name'])
				]); ?>
				<?php if($this->getUser('rank') === self::RANK_ADMIN): ?>
					<?php echo template::select('userEditRank', $module::$ranks, [
						'label' => 'Rang',
						'required' => true,
						'selected' => $this->getData(['user', $this->getUrl(2), 'rank'])
					]); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Sécurité'); ?></h4>
				<?php echo template::password('userEditNewPassword', [
					'label' => 'Nouveau mot de passe'
				]); ?>
				<?php echo template::password('userEditConfirmPassword', [
					'label' => 'Confirmation'
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<?php if($this->getUser('rank') === self::RANK_ADMIN): ?>
			<div class="col2 offset8">
				<?php echo template::button('userEditBack', [
					'value' => 'Annuler',
					'href' => helper::baseUrl() . 'user'
				]); ?>
			</div>
			<div class="col2">
		<?php else: ?>
			<div class="col2 offset10">
		<?php endif; ?>
			<?php echo template::submit('userEditSave'); ?>
		</div>
	</div>
</form>