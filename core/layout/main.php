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
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>site/data/theme.css?<?php echo md5_file('site/data/theme.css'); ?>">
	<link rel="stylesheet" href="<?php echo helper::baseUrl(false); ?>site/data/custom.css?<?php echo md5_file('site/data/custom.css'); ?>">
</head>
<body>
<?php $layout->showStyle(); ?>
<?php $layout->showBar(); ?>
<?php $layout->showNotification(); ?>
<?php if($this->getData(['theme', 'menu', 'position']) === 'body-first'): ?>
	<!-- Menu dans le fond du site avant la bannière -->
	<nav>
		<div id="toggle"><?php echo template::ico('menu'); ?></div>
		<div id="menu" class="container">
			<?php $layout->showMenu(); ?>
		</div>
	</nav>
<?php endif; ?>
<?php if($this->getData(['theme', 'header', 'position']) === 'body'): ?>
	<!-- Bannière dans le fond du site -->
	<header>
		<?php if(
			$this->getData(['theme', 'header', 'textHide']) === false
			// Affiche toujours le titre de la bannière pour l'édition du thème
			OR ($this->getUrl(0) === 'theme' AND $this->getUrl(1) === 'header')
		): ?>
			<div class="container">
				<span><?php echo $this->getData(['config', 'title']); ?></span>
			</div>
		<?php endif; ?>
	</header>
<?php endif; ?>
<?php if($this->getData(['theme', 'menu', 'position']) === 'body-second'): ?>
	<!-- Menu dans le fond du site après la bannière -->
	<nav>
		<div id="toggle"><?php echo template::ico('menu'); ?></div>
		<div id="menu" class="container">
			<?php $layout->showMenu(); ?>
		</div>
	</nav>
<?php endif; ?>
<!-- Site -->
<div id="site" class="container">
	<?php if($this->getData(['theme', 'menu', 'position']) === 'site-first'): ?>
		<!-- Menu dans le site avant la bannière -->
		<nav>
			<div id="toggle"><?php echo template::ico('menu'); ?></div>
			<div id="menu" class="container">
				<?php $layout->showMenu(); ?>
			</div>
		</nav>
	<?php endif; ?>
	<?php if(
		$this->getData(['theme', 'header', 'position']) === 'site'
		// Affiche toujours la bannière pour l'édition du thème
		OR (
			$this->getData(['theme', 'header', 'position']) === 'hide'
			AND $this->getUrl(0) === 'theme'
		)
	): ?>
		<!-- Bannière dans le site -->
		<header <?php if($this->getData(['theme', 'header', 'position']) === 'hide'): ?>class="displayNone"<?php endif; ?>>
			<?php if(
				$this->getData(['theme', 'header', 'textHide']) === false
				// Affiche toujours le titre de la bannière pour l'édition du thème
				OR ($this->getUrl(0) === 'theme' AND $this->getUrl(1) === 'header')
			): ?>
				<div class="container">
					<span><?php echo $this->getData(['config', 'title']); ?></span>
				</div>
			<?php endif; ?>
		</header>
	<?php endif; ?>
	<?php if(
		$this->getData(['theme', 'menu', 'position']) === 'site-second'
		// Affiche toujours le menu pour l'édition du thème
		OR (
			$this->getData(['theme', 'menu', 'position']) === 'hide'
			AND $this->getUrl(0) === 'theme'
		)
	): ?>
		<!-- Menu dans le site après la bannière -->
		<nav <?php if($this->getData(['theme', 'menu', 'position']) === 'hide'): ?>class="displayNone"<?php endif; ?>>
			<div id="toggle"><?php echo template::ico('menu'); ?></div>
			<div id="menu" class="container">
				<?php $layout->showMenu(); ?>
			</div>
		</nav>
	<?php endif; ?>
	<!-- Corps -->
	<section><?php $layout->showContent(); ?></section>
	<?php if(
		$this->getData(['theme', 'footer', 'position']) === 'site'
		// Affiche toujours le pied de page pour l'édition du thème
		OR (
			$this->getData(['theme', 'footer', 'position']) === 'hide'
			AND $this->getUrl(0) === 'theme'
		)
	): ?>
		<!-- Pied de page dans le site -->
		<footer <?php if($this->getData(['theme', 'footer', 'position']) === 'hide'): ?>class="displayNone"<?php endif; ?>>
			<div class="container">
				<?php $layout->showSocials(); ?>
				<?php $layout->showFooterText(); ?>
				<?php $layout->showCopyright(); ?>
			</div>
		</footer>
	<?php endif; ?>
</div>
<?php if($this->getData(['theme', 'footer', 'position']) === 'body'): ?>
	<!-- Pied de page dans le fond du site -->
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