// Aperçu en direct
$("input, select").on("change", function() {
	// Couleur du fond
	var css = "body{background-color:" + $("#themeBodyBackgroundColor").val() + "}";
	// Image du fond
	var themeBodyImage = $("#themeBodyImage").val();
	if(themeBodyImage) {
		css += "body{background-image:url('site/file/" + themeBodyImage + "');background-repeat:" + $("#themeBodyImageRepeat").val() + ";background-position:" + $("#themeBodyImagePosition").val() + ";background-attachment:" + $("#themeBodyImageAttachment").val() + ";background-size:" + $("#themeBodyImageSize").val() + "]";
	}
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
});
// Affiche / Cache les options de l'image du fond
$("#themeBodyImage").on("change", function() {
	if($(this).val()) {
		$("#themeBodyImageOptions").slideDown();
	}
	else {
		$("#themeBodyImageOptions").slideUp();
	}
}).trigger("change");