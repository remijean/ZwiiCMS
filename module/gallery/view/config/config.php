<?php echo template::formOpen('galleryConfigForm'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('galleryConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4>Nouvelle galerie</h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('galleryConfigName', [
							'label' => 'Nom'
						]); ?>
					</div>
					<div class="col5">
						<?php echo template::hidden('galleryConfigDirectoryOld', [
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
						<?php echo template::select('galleryConfigDirectory', [], [
							'label' => 'Dossier cible',
							'noDirty' => true // Désactivé à cause des modifications en ajax
						]); ?>
					</div>
					<div class="col1 verticalAlignBottom">
						<?php echo template::submit('galleryConfigSubmit', [
							'ico' => '',
							'value' => template::ico('plus')
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if($module::$galleries): ?>
		<?php echo template::table([4, 6, 1, 1], $module::$galleries, ['Nom', 'Dossier cible', '', '']); ?>
	<?php else: ?>
		<?php echo template::speech('Aucune galerie.'); ?>
	<?php endif; ?>
<?php echo template::formClose(); ?>