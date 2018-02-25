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
$("#themeAdvancedCss").on("change keydown keyup", function() {
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text($(this).val())
		.appendTo("head");
});

/**
 * Confirmation de réinitialisation
 */
$("#themeAdvancedReset").on("click", function() {
	var _this = $(this);
	return core.confirm("Êtes-vous sûr de vouloir réinitialiser à son état d'origine la personnalisation avancée ?", function() {
		$(location).attr("href", _this.attr("href"));
	});
});