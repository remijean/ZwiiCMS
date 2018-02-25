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
	// Couleurs du menu
	var colors = core.colorVariants($("#themeMenuBackgroundColor").val());
	var css = "nav,nav a{background-color:" + colors.normal + "}";
	css += "nav a,#toggle span{color:" + $("#themeMenuTextColor").val() + "}";
	css += "nav a:hover{background-color:" + colors.darken + "}";
	css += "nav a.active{background-color:" + colors.veryDarken + "}";
	// Taille, hauteur, épaisseur et capitalisation de caractères du menu
	css += "#toggle span,#menu a{padding:" + $("#themeMenuHeight").val() + ";font-weight:" + $("#themeMenuFontWeight").val() + ";font-size:" + $("#themeMenuFontSize").val() + ";text-transform:" + $("#themeMenuTextTransform").val() + "}";
	// Alignement du menu
	css += "#menu{text-align:" + $("#themeMenuTextAlign").val() + "}";
	// Marge
	if($("#themeMenuMargin").is(":checked")) {
		if(
			<?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'site-first'); ?>
			|| <?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?>
		) {
			css += 'nav{margin:20px 20px 0 20px}';
		}
		else {
			css += 'nav{margin:0 20px}';
		}
	}
	else {
		css += 'nav{margin:0}';
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
			$("nav").show().insertAfter("#bar");
			break;
		case 'body-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().insertAfter("#bar");
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