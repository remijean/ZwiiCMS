<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userAddName', [
							'label' => 'Nom',
							'required' => true,
							'value' => $this->getData(['user', $this->getUrl(2), 'name'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userAddId', [
							'help' => 'L\'identifiant est généré automatiquement en fonction du nom de l\'utilisateur et ne peut pas être modifié par la suite.',
							'label' => 'Identifiant',
							'readonly' => true
						]); ?>
					</div>
				</div>
				<?php echo template::select('userAddGroup', self::$groupNews, [
					'label' => 'Groupe',
					'required' => true,
					'selected' => self::GROUP_MEMBER
				]); ?>
				<?php echo template::text('userAddMail', [
					'label' => 'Adresse mail',
					'required' => true
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
				'class' => 'grey',
				'href' => helper::baseUrl() . 'user',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('userAddSubmit'); ?>
		</div>
	</div>
</form>