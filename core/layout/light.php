<?php $layout = new layout($this); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $layout->showMetaTitle(); ?>
	<?php $layout->showMetaDescription(); ?>
	<?php $layout->showFavicon(); ?>
	<?php $layout->showVendor(); ?>
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>core/layout/common.css">
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>core/layout/light.css">
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>site/data/theme.css?<?php echo md5(json_encode($this->getData(['theme']))); ?>">
</head>
<body>
<?php $layout->showStyle(); ?>
<?php $layout->showNotification(); ?>
<div id="site" class="container">
	<section><?php $layout->showContent(); ?></section>
</div>
<?php $layout->showScript(); ?>
</body>
</html>