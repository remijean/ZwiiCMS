<h1>Personnalisation</h1>
<h2>Options du bas de page</h2>
<form>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('footerBack', [
				'value' => 'Annuler',
				'href' => '#theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('footerSave', [
				'type' => 'submit'
			]); ?>
		</div>
	</div>
</form>