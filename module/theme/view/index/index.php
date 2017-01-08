<?php if(
	$this->getData(['theme', 'header', 'position']) === 'hide'
	OR $this->getData(['theme', 'menu', 'position']) === 'hide'
	OR $this->getData(['theme', 'footer', 'position']) === 'hide'
): ?>
	<?php echo template::speech('Cliquez sur une zone afin d\'accéder à ses options de personnalisation. Vous pouvez également afficher les zones cachées à l\'aide du bouton ci-dessous.'); ?>
	<div class="row">
		<div class="col4 offset4">
			<?php echo template::button('themeShowAll', [
				'value' => 'Afficher les zones cachées'
			]); ?>
		</div>
	</div>
<?php else: ?>
	<?php echo template::speech('Cliquez sur une zone afin d\'accéder à ses options de personnalisation.'); ?>
<?php endif; ?>