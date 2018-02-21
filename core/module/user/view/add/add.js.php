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
 * Affichage de l'id en simulant FILTER_ID
 */
$("#userAddId").on("change keydown keyup", function(event) {
	var userId = $(this).val();
	if(
		event.keyCode !== 8 // BACKSPACE
		&& event.keyCode !== 37 // LEFT
		&& event.keyCode !== 39 // RIGHT
		&& event.keyCode !== 46 // DELETE
		&& window.getSelection().toString() !== userId // Texte sélectionné
	) {
		var searchReplace = {
			"á": "a", "à": "a", "â": "a", "ä": "a", "ã": "a", "å": "a", "ç": "c", "é": "e", "è": "e", "ê": "e", "ë": "e", "í": "i", "ì": "i", "î": "i", "ï": "i", "ñ": "n", "ó": "o", "ò": "o", "ô": "o", "ö": "o", "õ": "o", "ú": "u", "ù": "u", "û": "u", "ü": "u", "ý": "y", "ÿ": "y",
			"Á": "A", "À": "A", "Â": "A", "Ä": "A", "Ã": "A", "Å": "A", "Ç": "C", "É": "E", "È": "E", "Ê": "E", "Ë": "E", "Í": "I", "Ì": "I", "Î": "I", "Ï": "I", "Ñ": "N", "Ó": "O", "Ò": "O", "Ô": "O", "Ö": "O", "Õ": "O", "Ú": "U", "Ù": "U", "Û": "U", "Ü": "U", "Ý": "Y", "Ÿ": "Y",
			"'": "-", "\"": "-", " ": "-"
		};
		userId = userId.replace(/[áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'" ]/ig, function(match) {
			return searchReplace[match];
		});
		userId = userId.replace(/[^a-z0-9-]/ig, "");
		$(this).val(userId);
	}
});

/**
 * Droits des groupes
 */
$("#userAddGroup").on("change", function() {
	$(".userAddGroupDescription").hide();
	$("#userAddGroupDescription" + $(this).val()).show();
}).trigger("change");