/**
 * Cache la notification après 4 secondes
 */
setTimeout(function() {
	$('#notification').slideUp();
}, 4000);

/**
 * Modifications non enregistrées du formulaire
 */
var form = $('form');

form.data('serialize', form.serialize());
$(window).on('beforeunload', function() {
	if(form.length && form.serialize() !== form.data('serialize')) {
		return 'Attention, si vous continuez, vous allez perdre les modifications non enregistrées !';
	}
});
form.submit(function() {
	$(window).off('beforeunload');
});

/**
 * Affiche/cache le menu en mode responsive
 */
var menu = $('#menu');

$('#toggle').on('click', function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display', '');
	}
});

/**
 * Verrouille l'administration de module après un changement
 */
var module = $('#module');
var oldModule = module.val();

module.on('change', function() {
	var newModule = module.val();
	var config = $('#config');

	if(newModule != '' && newModule == oldModule) {
		config.removeClass('disabled');
	}
	else {
		if(newModule != '') {
			alert('Pour accéder à l\'administration du nouveau module vous devez enregistrer les modifications de la page !');
		}
		config.addClass('disabled');
	}
});