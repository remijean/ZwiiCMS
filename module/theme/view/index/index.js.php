// Ajout des overlays
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr("href", "<?php echo helper::baseUrl(); ?>theme/body")
	.appendTo("body");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr("href", "<?php echo helper::baseUrl(); ?>theme/header")
	.appendTo("header");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr("href", "<?php echo helper::baseUrl(); ?>theme/menu")
	.appendTo("nav");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr("href", "<?php echo helper::baseUrl(); ?>theme/site")
	.appendTo("section");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr("href", "<?php echo helper::baseUrl(); ?>theme/footer")
	.appendTo("footer");