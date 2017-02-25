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
 * Affichage de l'id en simulant FILTER_ID
 */
$("#installConfigId").on("change", function() {
	var searchReplace = {"á": "a", "à": "a", "â": "a", "ä": "a", "ã": "a", "å": "a", "ç": "c", "é": "e", "è": "e", "ê": "e", "ë": "e", "í": "i", "ì": "i", "î": "i", "ï": "i", "ñ": "n", "ó": "o", "ò": "o", "ô": "o", "ö": "o", "õ": "o", "ú": "u", "ù": "u", "û": "u", "ü": "u", "ý": "y", "ÿ": "y", "'": "-", "\"": "-", " ": "-"};
	var userId = $(this).val().toLowerCase();
	userId = userId.replace(/[áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'" ]/g, function(match) {
		return searchReplace[match];
	});
	userId = userId.replace(/[^a-z0-9!#$%&'*+-=?^_`{|}~@.\[\]]/g, "");
	$(this).val(userId);
});