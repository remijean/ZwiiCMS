<form method="post">
	<div class="row">
		<div class="col2">
			<?php if($this->getUrl(3)): ?>
				<?php echo template::button('userEditBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl() . 'user',
					'ico' => 'left',
					'value' => 'Retour'
				]); ?>
			<?php else: ?>
				<?php echo template::button('userEditBack', [
					'class' => 'buttonGrey',
					'href' => helper::baseUrl(false),
					'ico' => 'home',
					'value' => 'Accueil'
				]); ?>
			<?php endif; ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('userEditSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userEditFirstname', [
							'autocomplete' => 'off',
							'label' => 'Prénom',
							'value' => $this->getData(['user', $this->getUrl(2), 'firstname'])
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userEditLastname', [
							'autocomplete' => 'off',
							'label' => 'Nom',
							'value' => $this->getData(['user', $this->getUrl(2), 'lastname'])
						]); ?>
					</div>
				</div>
				<?php echo template::mail('userEditMail', [
					'autocomplete' => 'off',
					'label' => 'Adresse mail',
					'value' => $this->getData(['user', $this->getUrl(2), 'mail'])
				]); ?>
				<?php if($this->getUser('group') === self::GROUP_ADMIN): ?>
					<?php echo template::select('userEditGroup', self::$groupEdits, [
						'disabled' => ($this->getUrl(2) === $this->getUser('id')),
						'help' => ($this->getUrl(2) === $this->getUser('id') ? 'Impossible de modifier votre propre groupe.' : ''),
						'label' => 'Groupe',
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
				<h4><?php echo helper::translate('Authentification'); ?></h4>
				<?php echo template::text('userEditId', [
					'autocomplete' => 'off',
					'help' => 'L\'identifiant est défini lors de la création du compte, il ne peut pas être modifié.',
					'label' => 'Identifiant',
					'readonly' => true,
					'value' => $this->getUrl(2)
				]); ?>
				<?php echo template::password('userEditOldPassword', [
					'autocomplete' => 'off',
					'label' => 'Ancien mot de passe'
				]); ?>
				<?php echo template::password('userEditNewPassword', [
					'autocomplete' => 'off',
					'label' => 'Nouveau mot de passe'
				]); ?>
				<?php echo template::password('userEditConfirmPassword', [
					'autocomplete' => 'off',
					'label' => 'Confirmation'
				]); ?>
			</div>
		</div>
	</div>
</form>