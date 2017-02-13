<form method="post">
	<div class="block">
		<h4><?php echo helper::translate('Informations générales'); ?></h4>
		<div class="row">
			<div class="col6">
				<?php echo template::text('galleriesEditName', [
					'label' => 'Nom',
					'required' => true,
					'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name'])
				]); ?>
			</div>
			<div class="col6">
				<?php echo template::hidden('galleriesEditDirectoryOld', [
					'value' => $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'directory'])
				]); ?>
				<?php echo template::select('galleriesEditDirectory', [], [
					'label' => 'Dossier cible',
					'required' => true
				]); ?>
			</div>
		</div>
	</div>
	<?php if($module::$pictures): ?>
		<?php echo template::table([4, 8], $module::$pictures, ['Image', 'Légende']); ?>
	<?php endif; ?>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('galleriesEditBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . $this->getUrl(0) . '/config',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('galleriesEditSubmit'); ?>
		</div>
	</div>
</form>