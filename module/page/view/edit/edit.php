<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Options principaux'); ?></h4>
				<?php echo template::text('pageTitle', [
					'label' => 'Titre de la page',
					'required' => true,
					'value' => $this->getData(['page', $this->getUrl(2), 'title'])
				]); ?>
				<div class="row">
					<div class="col10">
						<?php echo template::hidden('pageModuleIdOld', [
							'value' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
						]); ?>
						<?php echo template::select('pageModuleId', helper::arrayCollumn($this->getData(['page']), 'title', 'SORT_ASC'), [
							'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
							'label' => 'Module de la page',
							'required' => true,
							'value' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
						]); ?>
					</div>
					<div class="col2 verticalAlignBottom">
						<?php echo template::button('pageModuleConfig', [
							'disabled' => (bool) $this->getData(['page', $this->getUrl(2), 'moduleId']),
							'href' => helper::baseUrl() . 'module/' . $this->getUrl(2),
							'value' => template::ico('gear')
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('pageContent', [
				'class' => 'editor',
				'required' => true,
				'value' => $this->getData(['page', $this->getUrl(2), 'content'])
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset10">
			<?php echo template::submit('configSubmit'); ?>
		</div>
	</div>
</form>