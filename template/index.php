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
	<h1 id="header"><?= $core->getData('config', 'title'); ?></h1>
	<label for="toggle" class="toggle"><img src="template/menu.png"></label>
	<input type="checkbox" id="toggle">
	<ul id="nav">
		<li><a href="">Demo</a></li>
		<li><a href="">Demo</a></li>
		<li><a href="">Demo</a></li>
	</ul>
	<div id="content">
		<?= $core->getContent(); ?>
	</div>
	<div id="footer">Thème Flat | <?= $core->getData('config', 'footer'); ?></div>
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