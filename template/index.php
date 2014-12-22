<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $core->getTitle(); ?> - <?= $core->getData('config', 'title'); ?></title>
	<meta name="description" content="<?= $core->getData('config', 'description'); ?>">
	<meta name="keywords" content="<?= $core->getData('config', 'keywords'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald">
	<link rel="stylesheet" href="core/libs/normalize.min.css">
	<link rel="stylesheet" href="core/libs/trumbowyg/ui/trumbowyg.min.css">
	<link rel="stylesheet" href="core/core.css">
	<link rel="stylesheet" href="template/main.css">
</head>
<body>
<?= $core->adminPanel(); ?>
<div id="container">
	<header>
		<h1><?= $core->getData('config', 'title'); ?></h1>
	</header>
	<nav>
	</nav>
	<article>
		<?= $core->getContent(); ?>
	</article>
	<footer>
		<?= $core->getData('config', 'footer'); ?>
		<div id="scroll"><a href="#">Haut de page</a></div>
	</footer>
</div>
<script src="core/libs/jquery.min.js"></script>
<script src="core/libs/trumbowyg/trumbowyg.min.js"></script>
<script src="core/libs/trumbowyg/langs/fr.min.js"></script>
<script src="core/core.js"></script>
<script>
	$('.editor').trumbowyg({
		lang: "fr"
	});
</script>
</body>
</html>