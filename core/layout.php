<?php $layout = new layout(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="core/vendor/normalize/normalize.min.css">
	<link rel="stylesheet" href="core/theme.css">
</head>
<body>
<div id="container">
	<nav>
		<div class="toggle"><?php //echo template::ico('menu'); ?></div>
		<div class="menu"><?php echo $layout->menu(); ?></div>
	</nav>
	<section id="content"></section>
	<footer>
		<?php echo $layout->loginLink(); ?>
		<?php echo $layout->logoutLink(); ?>
	</footer>
</div>
<div id="notifications"></div>
<script>
	var homePageId = "<?php echo $this->getData(['config', 'homePageId']); ?>";
</script>
<script src="core/vendor/jquery/jquery.min.js"></script>
<script src="core/core.js"></script>
</body>
</html>