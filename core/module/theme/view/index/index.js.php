/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2017, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Ajout des overlays
 */
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr({
		"id": "themeOverlayBody",
		"href": "<?php echo helper::baseUrl(); ?>theme/body"
	})
	.appendTo("body");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr({
		"id": "themeOverlayHeader",
		"href": "<?php echo helper::baseUrl(); ?>theme/header"
	})
	.appendTo("header");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr({
		"id": "themeOverlayMenu",
		"href": "<?php echo helper::baseUrl(); ?>theme/menu"
	})
	.appendTo("nav");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr({
		"id": "themeOverlaySite",
		"href": "<?php echo helper::baseUrl(); ?>theme/site"
	})
	.appendTo("section");
$("<a>")
	.addClass("themeOverlay displayNone")
	.attr({
		"id": "themeOverlayFooter",
		"href": "<?php echo helper::baseUrl(); ?>theme/footer"
	})
	.appendTo("footer");

/**
 * Affiche les zones cachées
 */
$("#themeShowAll").on("click", function() {
	$("header.displayNone, nav.displayNone, footer.displayNone").slideDown();
	$(this)
		.addClass("disabled")
		.css("z-index", 0);
});