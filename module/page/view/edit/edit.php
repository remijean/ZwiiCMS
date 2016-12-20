<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<?php echo template::text('pageEditTitle', [
					'label' => 'Titre de la page',
					'required' => true,
					'value' => $this->getData(['page', $this->getUrl(2), 'title'])
				]); ?>
				<div class="row">
					<?php if(empty($this->getHierarchy($this->getUrl(2)))): ?>
						<div class="col6">
							<?php echo template::select('pageEditParentPageId', $module::$pagesNoParentId, [
								'label' => 'Page parent',
								'selected' => $this->getData(['page', $this->getUrl(2), 'parentPageId'])
							]); ?>
						</div>
						<div class="col6">
					<?php else: ?>
						<div class="col12">
					<?php endif; ?>
						<?php echo template::select('pageEditPosition', [], [
							'label' => 'Position dans le menu'
						]); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Module'); ?></h4>
				<div class="row">
					<div class="col10">
						<?php echo template::hidden('pageEditModuleIdOld', [
							'value' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
						]); ?>
						<?php echo template::select('pageEditModuleId', [], [
							'disabled' => true, // TODO : en attendant le dev des modules
							'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
							'label' => 'Module de la page',
							'required' => true,
							'value' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
						]); ?>
					</div>
					<div class="col2 verticalAlignBottom">
						<?php echo template::button('pageEditModuleConfig', [
							'disabled' => (bool) $this->getData(['page', $this->getUrl(2), 'moduleId']) === false,
							'href' => helper::baseUrl() . 'module/' . $this->getUrl(2),
							'value' => template::ico('gear')
						]); ?>
					</div>
				</div>
				<?php echo template::select('pageEditModulePosition', $module::$modulePositions, [
					'label' => 'Position du module dans la page',
					'selected' => $this->getData(['page', $this->getUrl(2), 'modulePosition']),
					'help' => 'En position libre vous devez ajouter manuellement le module en plaçant la balise [MODULE] dans votre page.'
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col12">
			<?php echo template::textarea('pageEditContent', [
				'class' => 'editor',
				'required' => true,
				'value' => $this->getData(['page', $this->getUrl(2), 'content'])
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset6">
			<?php echo template::button('pageEditBack', [
				'value' => 'Annuler',
				'href' => helper::baseUrl() . $this->getUrl(2)
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('pageEditDelete', [
				'value' => 'Supprimer',
				'href' => helper::baseUrl() . 'page/delete/' . $this->getUrl(2)
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('pageEditSubmit'); ?>
		</div>
	</div>
</form>