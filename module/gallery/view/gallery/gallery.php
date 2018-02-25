<div class="row">
	<div class="col2">
		<?php echo template::button('galleryGalleryBack', [
			'class' => 'buttonGrey',
			'href' => helper::baseUrl() . $this->getUrl(0),
			'ico' => 'left',
			'value' => 'Retour'
		]); ?>
	</div>
</div>
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
				data-caption="<?php echo $legend; ?>"
			>
				<div class="galleryGalleryName"><?php echo $legend; ?></div>
			</a>
		</div>
	<?php if($i % 4 === 0 OR $i === $picturesNb): ?>
		</div>
	<?php endif; ?>
	<?php $i++; ?>
<?php endforeach; ?>
