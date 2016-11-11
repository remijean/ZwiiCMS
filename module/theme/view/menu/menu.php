<h1>Personnalisation</h1>
<h2>Options du menu</h2>
<form>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('menuBack', [
				'value' => 'Annuler',
				'href' => '#theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('menuSave', [
				'type' => 'submit'
			]); ?>
		</div>
	</div>
</form>