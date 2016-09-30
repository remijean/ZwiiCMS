<?php $layout = new layout(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $this->getData(['config', 'name']); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="core/vendor/normalize/normalize.min.css">
	<link rel="stylesheet" href="core/vendor/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" href="core/vendor/zwiico/css/zwiico.css">
	<link rel="stylesheet" href="core/vendor/zwiico/css/animation.css">
	<link rel="stylesheet" href="core/main.css">
	<link rel="stylesheet" href="data/theme.css">
</head>
<body>
<div id="site" class="container">
	<header>
		<h1><?php echo $this->getData(['config', 'name']); ?></h1>
	</header>
	<nav>
		<div class="toggle"><?php echo helper::ico('menu'); ?></div>
		<div class="menu"><?php echo $layout->menu(); ?></div>
	</nav>
	<section id="content"></section>
	<footer>
		Motorisé par <a href="http://zwiicms.com/" target="_blank">ZwiiCMS</a> |
		<a href="#sitemap">Plan du site</a>
		<span id="loginLink"> | <a href="">Connexion</a></span>
	</footer>
</div>
<script>
	var homePageId = "<?php echo $this->getData(['config', 'homePageId']); ?>";
</script>
<script src="core/vendor/jquery/jquery.min.js"></script>
<script src="core/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="core/core.js"></script>
</body>
</html>