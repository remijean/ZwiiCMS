<?php echo template::formOpen('redirectionConfig'); ?>
	<div class="row">
		<div class="col2">
			<?php echo template::button('redirectionConfigBack', [
				'class' => 'buttonGrey',
				'href' => helper::baseUrl() . 'page/edit/' . $this->getUrl(0),
				'ico' => 'left',
				'value' => 'Retour'
			]); ?>
		</div>
		<div class="col2 offset8">
			<?php echo template::submit('redirectionConfigSubmit'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col6">
			<div class="block">
				<h4>Redirection</h4>
				<?php echo template::text('redirectionConfigUrl', [
					'label' => 'Lien de redirection',
					'placeholder' => 'http://',
					'value' => $this->getData(['module', $this->getUrl(0), 'url'])
				]); ?>
			</div>
		</div>
		<div class="col6">
			<div class="block">
				<h4>Statistiques</h4>
				<?php echo template::text('redirectionConfigCount', [
					'disabled' => true,
					'label' => 'Nombre de redirection',
					'value' => helper::filter($this->getData(['module', $this->getUrl(0), 'count']), helper::FILTER_INT)
				]); ?>
			</div>
		</div>
	</div>
<?php echo template::formClose(); ?>