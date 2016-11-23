<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
	<link rel="stylesheet" type="text/css" href="<?php echo helper::baseUrl(false); ?>module/file/vendor/elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo helper::baseUrl(false); ?>core/vendor/jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo helper::baseUrl(false); ?>module/file/vendor/elfinder/css/theme.css">
	<link rel="stylesheet" type="text/css" href="<?php echo helper::baseUrl(false); ?>module/file/vendor/elfinder/theme/material/theme.css">
	<script src="<?php echo helper::baseUrl(false); ?>core/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo helper::baseUrl(false); ?>core/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo helper::baseUrl(false); ?>core/vendor/jquery-ui/jquery-ui.touch-punch.min.js"></script>
	<script src="<?php echo helper::baseUrl(false); ?>module/file/vendor/elfinder/js/elfinder.min.js"></script>
	<script src="<?php echo helper::baseUrl(false); ?>module/file/vendor/elfinder/js/i18n/elfinder.fr.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#elfinder").elfinder({
				url : "<?php helper::baseUrl(false); ?>/module/file/vendor/elfinder/php/connector.minimal.php",
				lang: "fr",
				height: 500
			});
		});
	</script>
</head>
<body>
<div id="elfinder"></div>
</body>
</html>