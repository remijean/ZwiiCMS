<!-- TODO Démo -->
<p><strong>L'identifiant de démonstration est "Admin" et le mot de passe est "password".</strong></p>
<p>Pour les besoins de la démonstration, les données ne sont pas enregistrées et le gestionnaire de fichiers n'est pas disponible.</p>
<?php echo template::formOpen('userLoginForm'); ?>
	<div class="row">
		<div class="col6">
			<?php echo template::text('userLoginId', [
				'label' => 'Identifiant'
			]); ?>
		</div>
		<div class="col6">
			<?php echo template::password('userLoginPassword', [
				'label' => 'Mot de passe'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<?php echo template::checkbox('userLoginLongTime', true, 'Se souvenir de moi'); ?>

		</div>
		<div class="col6 textAlignRight">
			<a href="<?php echo helper::baseUrl(); ?>user/forgot/<?php echo $this->getUrl(2); ?>">Mot de passe perdu ?</a>
		</div>
	</div>
	<div class="row">
		<div class="col3 offset6">
			<?php echo template::button('userLoginBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . str_replace('_', '/', str_replace('__', '#', $this->getUrl(2))),
				'ico' => 'left',
				'value' => 'Annuler'
			]); ?>
		</div>
		<div class="col3">
			<?php echo template::submit('userLoginSubmit', [
				'value' => 'Connexion',
				'ico' => 'lock'
			]); ?>
		</div>
	</div>
<?php echo template::formClose(); ?>