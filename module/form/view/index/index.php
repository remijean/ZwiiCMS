<?php if($this->getData(['module', $this->getUrl(0), 'input'])): ?>
	<form method="post">
		<?php foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input): ?>
			<?php if($input['type'] === 'mail'): ?>
				<?php echo template::mail('formInput[' . $index . ']', [
					'label' => $input['name'],
					'required' => $input['required']
				]); ?>
			<?php elseif($input['type'] === 'text'): ?>
				<?php echo template::text('formInput[' . $index . ']', [
					'label' => $input['name'],
					'required' => $input['required']
				]); ?>
			<?php elseif($input['type'] === 'textarea'): ?>
				<?php echo template::textarea('formInput[' . $index . ']', [
					'label' => $input['name'],
					'required' => $input['required']
				]); ?>
			<?php elseif($input['type'] === 'select'): ?>
				<?php
				$values = array_flip(explode(',', $input['values']));
				foreach($values as $value => $key) {
					$values[$value] = trim($value);
				}
				?>
				<?php echo template::select('formInput[' . $index . ']', $values, [
					'label' => $input['name'],
					'required' => $input['required']
				]); ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if($this->getData(['module', $this->getUrl(0), 'config', 'capcha'])): ?>
			<div class="row">
				<div class="col4">
					<?php echo template::capcha('formCapcha'); ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col2 offset10">
				<?php echo template::submit('formSubmit', [
					'value' => $this->getData([$this->getUrl(0), 'config', 'button']) ? $this->getData([$this->getUrl(0), 'config', 'button']) : 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
<?php else: ?>
	<p><?php echo helper::translate('Le formulaire ne contient aucun champ.'); ?></p>
<?php endif; ?>