<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $system->getTitle(); ?> - <?= $system->getData('settings', 'title'); ?></title>
	<meta name="description" content="<?= $system->getData('settings', 'description'); ?>">
	<meta name="keywords" content="<?= $system->getData('settings', 'keywords'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald">
	<link rel="stylesheet" href="core/libs/normalize.min.css">
	<link rel="stylesheet" href="core/libs/trumbowyg/ui/trumbowyg.min.css">
	<link rel="stylesheet" href="core/core.css">
	<link rel="stylesheet" href="template/main.css">
</head>
<body>
<div id="container">
	<header>
		<h1><?= $system->getData('settings', 'title'); ?></h1>
	</header>
	<nav>
	</nav>
	<article>
		<?= $system->getContent(); ?>
	</article>
	<footer>
		<?= $system->getData('settings', 'footer'); ?>
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