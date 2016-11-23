<?php $layout = new layout(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $layout->showMetaTitle(); ?>
	<?php $layout->showMetaDescription(); ?>
	<?php $layout->showFavicon(); ?>
	<?php $layout->showVendor(); ?>
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>core/core.css">
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>site/data/<?php echo md5(json_encode($this->getData(['theme']))); ?>.css">
</head>
<body>
<?php $layout->showStyle(); ?>
<?php $layout->showPanel(); ?>
<?php $layout->showNotification(); ?>
<!-- Corps -->
<div id="popup" class="container">
	<section><?php $layout->showContent(); ?></section>
</div>
<?php $layout->showAnalytics(); ?>
<?php $layout->showScript(); ?>
</body>
</html>