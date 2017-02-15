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
	// Import des polices de caractères
	var titleFont = $("#themeTitleFont").val();
	var textFont = $("#themeTextFont").val();
	var css = "@import url('https://fonts.googleapis.com/css?family=" + titleFont + "|" + textFont + "');";
	// Couleurs des boutons
	var colors = core.colorVariants($("#themeButtonBackgroundColor").val());
	css += ".speechBubble,.button,button[type='submit'],.pagination a,input[type='checkbox']:checked + label:before,input[type='radio']:checked + label:before,.helpContent{background-color:" + colors.normal + ";color:" + colors.text + "!important}";
	css += ".tabTitle.current,.helpButton span{color:" + colors.normal + "}";
	css += "input[type='text']:hover,input[type='password']:hover,.inputFile:hover,select:hover,textarea:hover{border-color:" + colors.normal + "}";
	css += ".speechBubble:before{border-color:" + colors.normal + " transparent transparent transparent}";
	css += ".button:hover,button[type='submit']:hover,.pagination a:hover,input[type='checkbox']:not(:active):checked:hover + label:before,input[type='checkbox']:active + label:before,input[type='radio']:checked:hover + label:before,input[type='radio']:not(:checked):active + label:before{background-color:" + colors.darken + "}";
	css += ".helpButton span:hover{color:" + colors.darken + "}";
	css += ".button:active,button[type='submit']:active,.pagination a:active{background-color:" + colors.veryDarken + "}";
	// Couleurs des liens
	colors = core.colorVariants($("#themeLinkTextColor").val());
	css += "a{color:" + colors.normal + "}";
	css += "a:hover{color:" + colors.darken + "}";
	css += "a:active{color:" + colors.veryDarken + "}";
	// Couleur, polices, épaisseur et capitalisation de caractères des titres
	css += "h1,h2,h3,h4,h5,h6{color:" + $("#themeTitleTextColor").val() + ";font-family:'" + titleFont.replace("+", " ") + "',sans-serif;font-weight:" + $("#themeTitleFontWeight").val() + ";text-transform:" + $("#themeTitleTextTransform").val() + "}";
	// Police de caractères du texte
	css += "body{font-family:'" + textFont.replace("+", " ") + "',sans-serif}";
	// Largeur du site
	css += ".container{max-width:" + $("#themeSiteWidth").val() + "}";
	// Arrondi sur les coins du site et ombre sur les bords du site
	css += "#site{border-radius:" + $("#themeSiteRadius").val() + ";box-shadow:" + $("#themeSiteShadow").val() + " #212223}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});