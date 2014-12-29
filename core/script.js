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

/**
 * Prévisualisation de la page
 */
$('#preview').click(function() {
	$('.preview-frame').html('<h2>' + $('#title').val() + '</h2>' + $('#content').val());
});

//var module = $('#module');
//var link = $('#link');
//
//module.change(function() {
//	if($(this).val()) {
//		link.prop('disabled', true);
//	}
//	else {
//		link.prop('disabled', false);
//	}
//}).trigger('change');
//
//link.keyup(function() {
//	if($(this).val()) {
//		module.prop('disabled', true);
//	}
//	else {
//		module.prop('disabled', false);
//	}
//}).trigger('keyup');