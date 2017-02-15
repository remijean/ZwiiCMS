<form id="pageEditForm" method="post">
	<div class="row">
		<div class="col12">
			<div class="block">
				<h4><?php echo helper::translate('Informations générales'); ?></h4>
				<div class="row">
					<div class="col6">
						<?php echo template::text('pageEditTitle', [
							'label' => 'Titre',
							'required' => true,
							'value' => $this->getData(['page', $this->getUrl(2), 'title'])
						]); ?>
					</div>
					<div class="col6">
						<div class="row">
							<div class="col10">
								<?php echo template::hidden('pageEditModuleRedirect'); ?>
								<?php echo template::select('pageEditModuleId', $module::$moduleIds, [
									'help' => 'En cas de changement de module, les données du module précédent seront supprimées.',
									'label' => 'Module',
									'selected' => $this->getData(['page', $this->getUrl(2), 'moduleId'])
								]); ?>
							</div>
							<div class="col2 verticalAlignBottom">
								<?php echo template::button('pageEditModuleConfig', [
									'disabled' => (bool) $this->getData(['page', $this->getUrl(2), 'moduleId']) === false,
									'uniqueSubmission' => true,
									'value' => template::ico('gear')
								]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php echo template::textarea('pageEditContent', [
		'class' => 'editor',
		'value' => $this->getData(['page', $this->getUrl(2), 'content'])
	]); ?>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Menu'); ?></h4>
				<?php if($this->getHierarchy($this->getUrl(2), false)): ?>
					<?php echo template::hidden('pageEditParentPageId', [
						'value' => $this->getData(['page', $this->getUrl(2), 'parentPageId'])
					]); ?>
				<?php else: ?>
					<?php echo template::select('pageEditParentPageId', $module::$pagesNoParentId, [
						'label' => 'Page parent',
						'selected' => $this->getData(['page', $this->getUrl(2), 'parentPageId'])
					]); ?>
				<?php endif; ?>
				<?php echo template::select('pageEditPosition', [], [
					'label' => 'Position'
				]); ?>
				<?php echo template::checkbox('pageEditTargetBlank', true, 'Ouvrir dans un nouvel onglet', [
					'checked' => $this->getData(['page', $this->getUrl(2), 'targetBlank'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Options avancées'); ?></h4>
				<?php echo template::select('pageEditRank', self::$rankPublics, [
					'label' => 'Rang minimum d\'accès',
					'selected' => $this->getData(['page', $this->getUrl(2), 'rank'])
				]); ?>
				<?php echo template::checkbox('pageEditHideTitle', true, 'Cacher le titre', [
					'checked' => $this->getData(['page', $this->getUrl(2), 'hideTitle'])
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset6">
			<?php echo template::button('pageEditBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . $this->getUrl(2),
				'value' => 'Retour'
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