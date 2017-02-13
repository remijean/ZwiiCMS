<?php if($module::$galleries): ?>
	<?php $i = 1; ?>
	<?php $galleriesNb = count($module::$galleries); ?>
	<?php foreach($module::$galleries as $galleryId => $gallery): ?>
		<?php if($i % 2 === 1): ?>
			<div class="row">
		<?php endif; ?>
			<div class="col6">
				<a
					href="<?php echo helper::baseUrl() . $this->getUrl(0); ?>/gallery/<?php echo $galleryId; ?>"
					class="galleriesPicture"
					style="background-image:url('<?php echo helper::baseUrl(false) . $module::$firstPictures[$galleryId]; ?>')"
				>
					<div class="galleriesName"><?php echo $gallery['config']['name']; ?></div>
				</a>
			</div>
		<?php if($i % 2 === 0 OR $i === $galleriesNb): ?>
			</div>
		<?php endif; ?>
		<?php $i++; ?>
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo helper::translate('Aucune galerie.'); ?></p>
<?php endif; ?>