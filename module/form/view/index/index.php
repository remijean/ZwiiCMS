<?php if($this->getData(['module', $this->getUrl(0), 'input'])): ?>
	<form method="post">
		<?php foreach($this->getData(['module', $this->getUrl(0), 'input']) as $index => $input): ?>
			<?php if($input['type'] === $module::TYPE_MAIL): ?>
				<?php echo template::mail('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_SELECT): ?>
				<?php
				$values = array_flip(explode(',', $input['values']));
				foreach($values as $value => $key) {
					$values[$value] = trim($value);
				}
				?>
				<?php echo template::select('formInput[' . $index . ']', $values, [
					'id' => 'formInput_' . $index,
					'label' => $input['name']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_TEXT): ?>
				<?php echo template::text('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name']
				]); ?>
			<?php elseif($input['type'] === $module::TYPE_TEXTAREA): ?>
				<?php echo template::textarea('formInput[' . $index . ']', [
					'id' => 'formInput_' . $index,
					'label' => $input['name']
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
					'ico' => '',
					'value' => $this->getData(['module', $this->getUrl(0), 'config', 'button']) ? $this->getData(['module', $this->getUrl(0), 'config', 'button']) : 'Envoyer'
				]); ?>
			</div>
		</div>
	</form>
<?php else: ?>
	<p><?php echo helper::translate('Le formulaire ne contient aucun champ.'); ?></p>
<?php endif; ?>