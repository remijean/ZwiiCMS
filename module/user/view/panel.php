<ul class="container">
	<?php if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= self::RANK_MODERATOR): ?>
		<li>
			<a href="" id="panelEdit" data-tooltip="<?php echo helper::translate('Modifier la page'); ?>">
				<?php echo helper::ico('pencil'); ?>
			</a>
		</li>
		<li>
			<a href="#page/list" data-tooltip="<?php echo helper::translate('Gérer les pages'); ?>">
				<?php echo helper::ico('page'); ?>
			</a>
		</li>
		<li>
			<a href="#file" data-tooltip="<?php echo helper::translate('Gérer les fichiers'); ?>">
				<?php echo helper::ico('folder'); ?>
			</a>
		</li>
	<?php endif; ?>
	<?php if($this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'rank']) >= self::RANK_ADMIN): ?>
		<li>
			<a href="#config/theme" data-tooltip="<?php echo helper::translate('Personnaliser le site'); ?>">
				<?php echo helper::ico('brush'); ?>
			</a>
		</li>
		<li>
			<a href="#config" data-tooltip="<?php echo helper::translate('Configurer le site'); ?>">
				<?php echo helper::ico('gear'); ?>
			</a>
		</li>
	<?php endif; ?>
	<li>
		<a href="" id="panelLogout" data-tooltip="<?php echo helper::translate('Se déconnecter'); ?>">
			<?php echo helper::ico('logout'); ?>
			<span id="panelUserName"><?php echo $this->getData(['user', $this->getInput('ZWII_USER_ID', '_COOKIE'), 'name']); ?></span>
		</a>
	</li>
</ul>
<script>
	// Change l'url des boutons au changement de hash
	$(window).on("hashchange", function() {
		var hash = $(location).attr("hash").substr(1);
		$("#panelEdit").attr("href", "#page/edit/" + hash);
		$("#panelLogout").attr("href", "#user/logout/" + hash);
	}).trigger("hashchange");
	// Confirmation avant déconnexion
	$("#panelLogout").on("click", function() {
		var logoutLink = $(this);
		return confirm("Êtes-vous sûr de vouloir vous déconnecter ?", function() {
			$(location).attr("href", logoutLink.attr("href"));
		});
	});
</script>