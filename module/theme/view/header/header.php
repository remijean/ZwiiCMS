<h1>Personnalisation</h1>
<h2>Options de la bannière</h2>
<form>
	<div class="row">
		<div class="col2 offset8">
			<?php echo template::button('headerBack', [
				'value' => 'Annuler',
				'href' => '#theme'
			]); ?>
		</div>
		<div class="col2">
			<?php echo template::button('headerSave', [
				'type' => 'submit'
			]); ?>
		</div>
	</div>
</form>