/**
 * Cache la notification après 4 secondes
 */
setTimeout(function() {
	$('div#notification').slideUp();
}, 4000);

/**
 * Redirection du champ de sélection
 */
$('ul#panel > li > select').change(function() {
	$(location).attr('href', $(this).val());
});

/**
 * Modifications non enregistrées du formulaire
 */
var form = $('form');

form.data('serialize', form.serialize());
$(window).on('beforeunload', function() {
	if(form.length && form.serialize() !== form.data('serialize')) {
		return 'Vous avez effectué des modifications sans les enregistrer !';
	}
});
form.submit(function() {
	$(window).unbind('beforeunload');
});
