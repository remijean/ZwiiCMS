// Aperçu en direct
$("input, select").on("change", function() {
	// Import des polices de caractères
	var headerFont = $("#themeHeaderFont").val();
	var css = "@import url('https://fonts.googleapis.com/css?family=" + headerFont + "');";
	// Couleurs, image, alignement et hauteur de la bannière
	css += "header{background-color:" + $("#themeHeaderBackgroundColor").val() + ";text-align:" + $("#themeHeaderTextAlign").val() + ";height:" + $("#themeHeaderHeight").val() + ";line-height:" + $("#themeHeaderHeight").val() + "}";
	var themeHeaderImage = $("#themeHeaderImage").val();
	if(themeHeaderImage) {
		css += "header{background-image:url('site/file/" + themeHeaderImage + "');background-repeat:" + $("#themeHeaderImageRepeat").val() + ";background-position:" + $("#themeHeaderImagePosition").val() + "}";
	}
	// Couleur du titre de la bannière
	css += "header h1{color:" + $("#themeHeaderTextColor").val() + ";font-family:'" + headerFont.replace("+", " ") + "',sans-serif}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
	// Position de la bannière
	switch($("#themeHeaderPosition").val()) {
		case 'hide':
			$("header").hide();
			break;
		case 'site':
			$("header").show().prependTo("#site");
			break;
		case 'body':
			if(<?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'body-first'); ?>) {
				$("header").show().insertAfter("nav");
			}
			else {
				$("header").show().insertAfter("#panel");
			}
			break;
	}
});
// Affiche / Cache les options de l'image du fond
$("#themeHeaderImage").on("change", function() {
	if($(this).val()) {
		$("#themeHeaderImageOptions").slideDown();
	}
	else {
		$("#themeHeaderImageOptions").slideUp();
	}
}).trigger("change");