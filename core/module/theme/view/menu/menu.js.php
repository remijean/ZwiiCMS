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
 * Aperçu en direct
 */
$("input, select").on("change", function() {
	// Couleurs du menu
	var colors = core.colorVariants($("#themeMenuBackgroundColor").val());
	var css = "nav, nav li > a{background-color:" + colors.normal + "}";
	css += "nav a,#toggle span{color:" + colors.text + "!important}";
	css += "nav a:hover{background-color:" + colors.darken + "}";
	css += "nav a.target, nav a.active{background-color:" + colors.veryDarken + "}";
	// Hauteur, épaisseur et capitalisation de caractères du menu
	css += "#toggle span,#menu a{padding:" + $("#themeMenuHeight").val() + ";font-weight:" + $("#themeMenuFontWeight").val() + ";text-transform:" + $("#themeMenuTextTransform").val() + "}";
	// Alignement du menu
	css += "#menu{text-align:" + $("#themeMenuTextAlign").val() + "}";
	// Marge
	if($("#themeMenuMargin").is(":checked")) {
		css += 'nav{margin:20px 20px 0 20px}';
	}
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
	// Position du menu
	switch($("#themeMenuPosition").val()) {
		case 'hide':
			$("nav").hide();
			break;
		case 'site-first':
			$("nav").show().prependTo("#site");
			break;
		case 'site-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'site'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().prependTo("#site");
			}
			break;
		case 'body-first':
			$("nav").show().insertAfter("#panel");
			break;
		case 'body-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().insertAfter("#panel");
			}
			break;
	}
});
// Lien de connexion (addClass() et removeClass() au lieu de hide() et show() car ils ne conservent pas le display-inline: block; de #themeMenuLoginLink)
$("#themeMenuLoginLink").on("change", function() {
	if($(this).is(":checked")) {
		$("#menuLoginLink").removeClass('displayNone');
	}
	else {
		$("#menuLoginLink").addClass('displayNone');
	}
}).trigger("change");
// Affiche / Cache les options de la position
$("#themeMenuPosition").on("change", function() {
	if($(this).val() === 'site-first' || $(this).val() === 'site-second') {
		$("#themeMenuPositionOptions").slideDown();
	}
	else {
		$("#themeMenuPositionOptions").slideUp(function() {
			$("#themeMenuMargin").prop("checked", false).trigger("change");
		});
	}
}).trigger("change");