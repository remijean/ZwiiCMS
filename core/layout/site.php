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
<!-- Menu dans le fond du site en première position -->
<?php if($this->getData(['theme', 'menu', 'position']) === 'body-first'): ?>
	<nav>
		<div id="toggle"><?php echo template::ico('menu'); ?></div>
		<div id="menu" class="container">
			<ul><?php $layout->showMenu(); ?></ul>
		</div>
	</nav>
<?php endif; ?>
<!-- Bannière dans le fond du site -->
<?php if($this->getData(['theme', 'header', 'position']) === 'body'): ?>
	<header>
		<div class="container">
			<h1><?php echo $this->getData(['config', 'title']); ?></h1>
		</div>
	</header>
<?php endif; ?>
<!-- Menu dans le fond du site en seconde position -->
<?php if($this->getData(['theme', 'menu', 'position']) === 'body-second'): ?>
	<nav>
		<div id="toggle"><?php echo template::ico('menu'); ?></div>
		<div id="menu" class="container">
			<ul><?php $layout->showMenu(); ?></ul>
		</div>
	</nav>
<?php endif; ?>
<!-- Site -->
<div id="site" class="container">
	<!-- Bannière dans le site -->
	<?php if($this->getData(['theme', 'header', 'position']) === 'site'): ?>
		<header>
			<div class="container">
				<h1><?php echo $this->getData(['config', 'title']); ?></h1>
			</div>
		</header>
	<?php endif; ?>
	<!-- Menu dans le site -->
	<?php if($this->getData(['theme', 'menu', 'position']) === 'site'): ?>
		<nav>
			<div id="toggle"><?php echo template::ico('menu'); ?></div>
			<div id="menu" class="container">
				<ul><?php $layout->showMenu(); ?></ul>
			</div>
		</nav>
	<?php endif; ?>
	<!-- Corps -->
	<section><?php $layout->showContent(); ?></section>
	<!-- Bas du site dans le site -->
	<?php if($this->getData(['theme', 'footer', 'position']) === 'site'): ?>
		<footer>
			<div class="container">
				<?php $layout->showSocials(); ?>
				<?php $layout->showFooterText(); ?>
				<?php $layout->showCopyright(); ?>
			</div>
		</footer>
	<?php endif; ?>
</div>
<!-- Bas du site dans le fond du site -->
<?php if($this->getData(['theme', 'footer', 'position']) === 'body'): ?>
	<footer>
		<div class="container">
			<?php $layout->showSocials(); ?>
			<?php $layout->showFooterText(); ?>
			<?php $layout->showCopyright(); ?>
		</div>
	</footer>
<?php endif; ?>
<!-- Lien remonter en haut -->
<div id="backToTop"><?php echo template::ico('up'); ?></div>
<?php $layout->showAnalytics(); ?>
<?php $layout->showScript(); ?>
</body>
</html>