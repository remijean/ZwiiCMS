<h3><?php echo $this->getData(['module', $this->getUrl(0), $this->getUrl(2), 'config', 'name']); ?></h3>
<?php $i = 1; ?>
<?php $picturesNb = count($module::$pictures); ?>
<?php foreach($module::$pictures as $picture => $legend): ?>
	<?php if($i % 4 === 1): ?>
		<div class="row">
	<?php endif; ?>
		<div class="col3">
			<a
				href="<?php echo helper::baseUrl(false) . $picture; ?>"
				class="galleryGalleryPicture"
				style="background-image:url('<?php echo helper::baseUrl(false) . $picture; ?>')"
				title="<?php echo $legend; ?>"
			>
				<div class="galleryGalleryName"><?php echo $legend; ?></div>
			</a>
		</div>
	<?php if($i % 4 === 0 OR $i === $picturesNb): ?>
		</div>
	<?php endif; ?>
	<?php $i++; ?>
<?php endforeach; ?>
<div class="row">
	<div class="col2 offset10">
		<?php echo template::button('galleryGalleryBack', [
			'class' => 'grey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'value' => 'Retour'

		]); ?>
	</div>
</div>
