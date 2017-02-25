<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('userEditId', [
					'help' => 'L\'identifiant est défini lors de la création du compte, il ne peut pas être modifié.',
					'label' => 'Identifiant',
					'readonly' => true,
					'value' => $this->getUrl(2)
				]); ?>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userEditFirstname', [
							'label' => 'Prénom',
							'required' => true,
							'value' => $this->getData(['user', $this->getUrl(2), 'firstname'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userEditLastname', [
							'label' => 'Nom',
							'required' => true,
							'value' => $this->getData(['user', $this->getUrl(2), 'lastname'])
						]); ?>
					</div>
				</div>
				<?php echo template::mail('userEditMail', [
					'label' => 'Adresse mail',
					'required' => true,
					'value' => $this->getData(['user', $this->getUrl(2), 'mail'])
				]); ?>
				<?php if($this->getUser('group') === self::GROUP_ADMIN): ?>
					<?php echo template::select('userEditGroup', self::$groupEdits, [
						'disabled' => ($this->getUrl(2) === $this->getUser('id')),
						'help' => ($this->getUrl(2) === $this->getUser('id') ? 'Impossible de modifier votre propre groupe.' : ''),
						'label' => 'Groupe',
						'required' => true,
						'selected' => $this->getData(['user', $this->getUrl(2), 'group'])
					]); ?>
					<?php echo helper::translate('Autorisations :'); ?>
					<ul id="userEditGroupDescription<?php echo self::GROUP_MEMBER; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo helper::translate('Accès aux pages privées membres'); ?></li>
					</ul>
					<ul id="userEditGroupDescription<?php echo self::GROUP_MODERATOR; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo helper::translate('Accès aux pages privées membres et modérateurs'); ?></li>
						<li><?php echo helper::translate('Ajout / Édition / Suppression de pages'); ?></li>
						<li><?php echo helper::translate('Ajout / Édition / Suppression de fichiers'); ?></li>
					</ul>
					<ul id="userEditGroupDescription<?php echo self::GROUP_ADMIN; ?>" class="userEditGroupDescription displayNone">
						<li><?php echo helper::translate('Accès à toutes les pages privées'); ?></li>
						<li><?php echo helper::translate('Ajout / Édition / Suppression de pages'); ?></li>
						<li><?php echo helper::translate('Ajout / Édition / Suppression de fichiers'); ?></li>
						<li><?php echo helper::translate('Ajout / Édition / Suppression d\'utilisateurs'); ?></li>
						<li><?php echo helper::translate('Configuration du site'); ?></li>
						<li><?php echo helper::translate('Personnalisation du thème'); ?></li>
					</ul>
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