// Aperçu en direct
$("input, select").on("change", function() {
	// Couleurs du menu
	var colors = colorVariants($("#themeMenuBackgroundColor").val());
	var css = "nav{background-color:" + colors.normal + "}";
	css += "nav a{color:" + colors.text + "!important}";
	css += "nav a:hover{color:" + colors.text + "}";
	css += "nav a.target, nav a:active{background-color:" + colors.veryDarken + "}";
	// Hauteur, épaisseur et capitalisation de caractères du menu
	css += "#toggle span,#menu a{padding:" + $("#themeMenuHeight").val() + ";font-weight:" + $("#themeMenuFontWeight").val() + ";text-transform:" + $("#themeMenuTextTransform").val() + "}";
	// Alignement du menu
	css += "#menu{text-align:" + $("#themeMenuTextAlign").val() + "}";
	// Ajout du css au DOM
	$("#themePreview").remove();
	$("<style>")
		.attr("type", "text/css")
		.attr("id", "themePreview")
		.text(css)
		.appendTo("head");
	// Position du menu
	switch($("#themeMenuPosition").val()) {
		case 'hide':
			$("nav").hide();
			break;
		case 'site':
			if(<?php echo json_encode($this->getData(['theme', 'menu', 'position']) === 'site'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().prependTo("#site");
			}
			break;
		case 'body-first':
			$("nav").show().insertAfter("#panel");
			break;
		case 'body-second':
			if(<?php echo json_encode($this->getData(['theme', 'header', 'position']) === 'body'); ?>) {
				$("nav").show().insertAfter("header");
			}
			else {
				$("nav").show().insertAfter("#panel");
			}
			break;
	}
});
// Lien de connexion
$("#themeMenuLoginLink").on("click", function() {
	if($(this).is(":checked")) {
		$("<li>").append(
			$("<a>")
				.attr({
					"id": "menuLoginLink",
					"href": "<?php echo helper::baseUrl(true); ?>config"
				})
				.text("<?php echo helper::translate("Connexion"); ?>")
		).appendTo("#menu > ul")
	}
	else {
		$("#menuLoginLink").remove();
	}
});