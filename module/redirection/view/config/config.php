<form method="post">
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Redirection'); ?></h4>
				<?php echo template::text('redirectionConfigUrl', [
					'label' => 'Lien de redirection',
					'placeholder' => 'http://',
					'required' => true,
					'value' => $this->getData(['module', $this->getUrl(0), 'url'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4><?php echo helper::translate('Statistiques'); ?></h4>
				<?php echo template::text('redirectionConfigCount', [
					'disabled' => true,
					'label' => 'Nombre de redirection',
					'value' => helper::filter($this->getData(['module', $this->getUrl(0), 'count']), helper::FILTER_INT)
				]); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('redirectionConfigBack', [
				'class' => 'grey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'value' => 'Annuler'

			]); ?>
		</div>
		<div class="col2">
			<?php echo template::submit('redirectionConfigSubmit'); ?>
		</div>
	</div>
</form>