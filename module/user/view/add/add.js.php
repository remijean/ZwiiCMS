// Affichage de l'id en simulant FILTER_ID
$("#userAddName").on("keyup keydown change", function() {
	var searchReplace = {"á": "a", "à": "a", "â": "a", "ä": "a", "ã": "a", "å": "a", "ç": "c", "é": "e", "è": "e", "ê": "e", "ë": "e", "í": "i", "ì": "i", "î": "i", "ï": "i", "ñ": "n", "ó": "o", "ò": "o", "ô": "o", "ö": "o", "õ": "o", "ú": "u", "ù": "u", "û": "u", "ü": "u", "ý": "y", "ÿ": "y", "'": "-", "\"": "-", " ": "-"};
	var userId = $(this).val().toLowerCase();
	userId = userId.replace(/[áàâäãåçéèêëíìîïñóòôöõúùûüýÿ'" ]/g, function(match) {
		return searchReplace[match];
	});
	userId = userId.replace(/[^a-z0-9!#$%&'*+-=?^_`{|}~@.\[\]]/g, "");
	$("#userAddId").val(userId);
});