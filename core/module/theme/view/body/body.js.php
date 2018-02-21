/**
 * This file is part of Zwii.
 *
 * For full copyright and license information, please see the LICENSE
 * file that was distributed with this source code.
 *
 * @author Rémi Jean <remi.jean@outlook.com>
 * @copyright Copyright (C) 2008-2018, Rémi Jean
 * @license GNU General Public License, version 3
 * @link http://zwiicms.com/
 */

/**
 * Aperçu en direct
 */
$("input, select").on("change", function() {
	// Couleur du fond
	var css = "body{background-color:" + $("#themeBodyBackgroundColor").val() + "}";
	// Image du fond
	var themeBodyImage = $("#themeBodyImage").val();
	if(themeBodyImage) {
		css += "body{background-image:url('<?php echo helper::baseUrl(false); ?>site/file/source/" + themeBodyImage + "');background-repeat:" + $("#themeBodyImageRepeat").val() + ";background-position:" + $("#themeBodyImagePosition").val() + ";background-attachment:" + $("#themeBodyImageAttachment").val() + ";background-size:" + $("#themeBodyImageSize").val() + "]";
	}
	else {
		css += "body{background-image:none}";
	}
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});
// Affiche / Cache les options de l'image du fond
$("#themeBodyImage").on("change", function() {
	if($(this).val()) {
		$("#themeBodyImageOptions").slideDown();
	}
	else {
		$("#themeBodyImageOptions").slideUp();
	}
}).trigger("change");