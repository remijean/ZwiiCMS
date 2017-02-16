<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userEditName', [
							'label' => 'Nom',
							'required' => true,
							'value' => $this->getData(['user', $this->getUrl(2), 'name'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userEditId', [
							'help' => 'L\'identifiant est défini lors de la création du compte, il ne peut pas être modifié.',
							'label' => 'Identifiant',
							'readonly' => true,
							'value' => $this->getUrl(2)
						]); ?>
					</div>
				</div>
				<?php if($this->getUser('rank') === self::RANK_ADMIN): ?>
					<?php echo template::select('userEditRank', self::$rankEdits, [
						'disabled' => ($this->getUrl(2) === $this->getUser('id')),
						'help' => ($this->getUrl(2) === $this->getUser('id') ? 'Impossible de modifier votre propre rang.' : ''),
						'label' => 'Rang',
						'required' => true,
						'selected' => $this->getData(['user', $this->getUrl(2), 'rank'])
					]); ?>
				<?php endif; ?>
				<?php echo template::text('userEditEmail', [
					'label' => 'Adresse email',
					'required' => true,
					'value' => $this->getData(['user', $this->getUrl(2), 'email'])
				]); ?>
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
		<?php if($this->getUrl(3)): ?>
			<div class="col2 offset8">
				<?php echo template::button('userEditBack', [
					'class' => 'grey',
					'href' => helper::baseUrl() . 'user',
					'value' => 'Retour'

				]); ?>
			</div>
			<div class="col2">
		<?php else: ?>
			<div class="col2 offset10">
		<?php endif; ?>
			<?php echo template::submit('userEditSubmit'); ?>
		</div>
	</div>
</form>