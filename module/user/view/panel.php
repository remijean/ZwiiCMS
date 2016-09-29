<div class="container">
	<?php if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= self::RANK_MODERATOR): ?>
		<ul class="panelLeft">
			<li></li>
		</ul>
	<?php endif; ?>
	<ul class="panelRight">
		<?php if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= self::RANK_MODERATOR): ?>
			<li>
				<a href="#page/add" title="<?php echo helper::translate('Créer une page'); ?>">
					<?php echo helper::ico('plus'); ?>
				</a>
			</li>
			<li>
				<a href="" id="panelEdit" title="<?php echo helper::translate('Modifier la page courante'); ?>">
					<?php echo helper::ico('pencil'); ?>
				</a>
			</li>
			<li>
				<a href="#manager" title="<?php echo helper::translate('Gérer les fichiers'); ?>">
					<?php echo helper::ico('folder'); ?>
				</a>
			</li>
		<?php endif; ?>
		<?php if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= self::RANK_ADMIN): ?>
			<li>
				<a href="#config" title="<?php echo helper::translate('Configurer le site'); ?>">
					<?php echo helper::ico('gear'); ?>
				</a>
			</li>
			<li>
				<a href="#config/theme" title="<?php echo helper::translate('Personnaliser le site'); ?>">
					<?php echo helper::ico('palette'); ?>
				</a>
			</li>
		<?php endif; ?>
		<li>
			<a href="" id="panelLogout" title="<?php echo helper::translate('Se déconnecter'); ?>">
				<?php echo helper::ico('logout'); ?>
				<?php echo $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'name']); ?>
			</a>
		</li>
	</ul>
</div>
<script>
	// Confirmation avant déconnexion
	$("#panelLogout").on("click", function() {
		var logoutLink = $(this);
		return addConfirm("Êtes-vous sûr de vouloir vous déconnecter ?", function() {
			$(location).attr("href", logoutLink.attr("href"));
		});
	});
	// Change l'url des boutons au changement de hash
	$(window).on("hashchange", function() {
		var hash = $(location).attr("hash").substr(1);
		$("#panelEdit").attr("href", "#page/edit/" + hash);
		$("#panelLogout").attr("href", "#user/logout/" + hash);
	}).trigger("hashchange");
</script>