// Aperçu en direct
$("input, select").on("change", function() {
	// Couleurs du menu
	var colors = colorVariants($("#themeMenuBackgroundColor").val());
	var css = "nav{background-color:" + colors.normal + "}";
	css += "nav a{color:" + colors.text + "}";
	css += "nav a:hover{color:" + colors.text + ";background-color:" + colors.darken + "}";
	css += "nav a.target, nav a:active{color:" + colors.text + ";background-color:" + colors.veryDarken + "}";
	// Hauteur du menu
	css += "#toggle,#menu a{padding:" + $("#themeMenuHeight").val() + "}";
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
				$("nav").show().appendTo("#site");
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