<p>Afin d'assurer le bon fonctionnement de Zwii, veuillez ne pas fermer cette page avant la fin de l'opération.</p>
<div class="row">
	<div class="col9 verticalAlignMiddle">
		<div id="installUpdateProgress">
			<?php echo template::ico('spin', '', true); ?>
			Téléchargement et installation de la mise à jour...
		</div>
		<div id="installUpdateError" class="colorRed displayNone">
			<?php echo template::ico('cancel', ''); ?>
			Impossible d'effectuer la mise à jour.
		</div>
		<div id="installUpdateSuccess" class="colorGreen displayNone">
			<?php echo template::ico('check', ''); ?>
			Mise à jour terminée avec succès.
		</div>
	</div>
	<div class="col3 verticalAlignMiddle">
		<?php echo template::button('installUpdateEnd', [
			'value' => 'Terminer',
			'href' => helper::baseUrl(false) . '?config', // Force le "?" car la réécriture d'URL est supprimée après une mise à jour
			'ico' => 'check',
			'class' => 'disabled'
		]); ?>
	</div>
</div>