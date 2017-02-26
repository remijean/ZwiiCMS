<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('userAddFirstname', [
							'autocomplete' => 'off',
							'label' => 'Prénom',
							'required' => true
						]); ?>
					</div>
					<div class="col6">
						<?php echo template::text('userAddLastname', [
							'autocomplete' => 'off',
							'label' => 'Nom',
							'required' => true
						]); ?>
					</div>
				</div>
				<?php echo template::mail('userAddMail', [
					'autocomplete' => 'off',
					'label' => 'Adresse mail',
					'required' => true
				]); ?>
				<?php echo template::select('userAddGroup', self::$groupNews, [
					'label' => 'Groupe',
					'required' => true,
					'selected' => self::GROUP_MEMBER
				]); ?>
				<?php echo helper::translate('Autorisations :'); ?>
				<ul id="userAddGroupDescription<?php echo self::GROUP_MEMBER; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo helper::translate('Accès aux pages privées membres'); ?></li>
				</ul>
				<ul id="userAddGroupDescription<?php echo self::GROUP_MODERATOR; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo helper::translate('Accès aux pages privées membres et modérateurs'); ?></li>
					<li><?php echo helper::translate('Ajout / Édition / Suppression de pages'); ?></li>
					<li><?php echo helper::translate('Ajout / Édition / Suppression de fichiers'); ?></li>
				</ul>
				<ul id="userAddGroupDescription<?php echo self::GROUP_ADMIN; ?>" class="userAddGroupDescription displayNone">
					<li><?php echo helper::translate('Accès à toutes les pages privées'); ?></li>
					<li><?php echo helper::translate('Ajout / Édition / Suppression de pages'); ?></li>
					<li><?php echo helper::translate('Ajout / Édition / Suppression de fichiers'); ?></li>
					<li><?php echo helper::translate('Ajout / Édition / Suppression d\'utilisateurs'); ?></li>
					<li><?php echo helper::translate('Configuration du site'); ?></li>
					<li><?php echo helper::translate('Personnalisation du thème'); ?></li>
				</ul>
				<?php echo template::checkbox('userAddSendMail', true, 'Prévenir l\'utilisateur par mail'); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Authentification'); ?></h4>
				<?php echo template::text('userAddId', [
					'autocomplete' => 'off',
					'label' => 'Identifiant',
					'required' => true
				]); ?>
				<?php echo template::password('userAddPassword', [
					'autocomplete' => 'off',
					'label' => 'Mot de passe',
					'required' => true
				]); ?>
				<?php echo template::password('userAddConfirmPassword', [
					'autocomplete' => 'off',
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