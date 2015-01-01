/**
 * Cache la notification après 4 secondes
 */
setTimeout(function() {
	$('div#notification').slideUp();
}, 4000);

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
 * Affiche/cache le menu en mode responsive
 */
var menu = $('ul#menu');

$('div#toggle').click(function() {
	menu.slideToggle();
});
$(window).on('resize', function() {
	if($(window).width() > 768) {
		menu.css('display','');
	}
});