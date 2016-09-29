<style>
	.themeRelative #panel,
	.themeRelative #site,
	.themeRelative header,
	.themeRelative nav,
	.themeRelative section,
	.themeRelative footer {
		position: relative;
	}
	.themeRelative #panel,
	.themeRelative #site {
		z-index: 20;
	}
	.themeOverlay {
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 10;
		cursor: pointer;
	}
	.themeOverlay:hover {
		background: rgba(103, 198, 114, .7);
	}
	.themeOptions {
		display: none;
	}
</style>
<h1>Personnalisation</h1>
<p id="themeHome">Déplacez votre curseur au dessus d'une zone, puis cliquez dessus afin de d'accéder à ses options de personnalisation.</p>
<div class="themeOptions" data-zone="section">
	<form>
		<h2>Options du site</h2>
		<div class="row">
			<div class="col4">
				<div class="block">
					<h4>Couleurs et image</h4>
					<div class="row">
						<div class="col6">
							<?php echo template::colorPicker('themeBackgroundColor', [
								'label' => 'Couleur du fond',
								'value' => $this->getData(['theme', 'background', 'color'])
							]); ?>
						</div>
						<div class="col6">
							<?php echo template::colorPicker('themeTitleColor', [
								'label' => 'Couleur des titres',
								'value' => $this->getData(['theme', 'title', 'color'])
							]); ?>
						</div>
					</div>
					<?php echo template::select('themeBackgroundImage', [], [
						'label' => 'Image du fond',
						'help' => 'Seule une image de format .png, .gif, .jpg ou .jpeg du gestionnaire de fichiers est acceptée.',
						'selected' => $this->getData(['theme', 'background', 'image'])
					]); ?>
					<div id="backgroundImageOptions">
						<div class="row">
							<div class="col6">
								<?php echo template::select('themeBackgroundRepeat', $module::$repeats, [
									'label' => 'Répétition',
									'selected' => $this->getData(['theme', 'background', 'repeat'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::select('themeBackgroundPosition', $module::$positions, [
									'label' => 'Alignement',
									'selected' => $this->getData(['theme', 'background', 'position'])
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6">
								<?php echo template::select('themeBackgroundAttachment', $module::$attachments, [
									'label' => 'Position',
									'selected' => $this->getData(['theme', 'background', 'attachment'])
								]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col4">
				<div class="block">
					<h4>Polices</h4>
					<?php echo template::select('themeTitleFont', $this->fonts, [
						'label' => 'Police des titres',
						'selected' => $this->getData(['theme', 'title', 'font'])
					]); ?>
					<?php echo template::select('themeTextFont', $this->fonts, [
						'label' => 'Police du texte',
						'selected' => $this->getData(['theme', 'text', 'font'])
					]); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col2 offset8">
				<?php echo template::button('themeBack', [
					'value' => 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'type' => 'submit',
					'value' => 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<script>
	// Ajout des overlays
	$("<div>").addClass("themeOverlay").data("zone", "body").appendTo("body");
	$("<div>").addClass("themeOverlay").data("zone", "header").appendTo("header");
	$("<div>").addClass("themeOverlay").data("zone", "nav").appendTo("nav");
	$("<div>").addClass("themeOverlay").data("zone", "section").appendTo("section");
	$("<div>").addClass("themeOverlay").data("zone", "footer").appendTo("footer");
	// Ajout des positions relatives pour empêcher les overlays de passer au dessus des éléments
	$("body").addClass("themeRelative");
	// Affiche les options d'éditions
	$(".themeOverlay").on("click", function() {
		// Cache les overlays et supprime les positions relatives (sinon les palettes de couleurs ne fonctionnent pas)
		$(".themeOverlay").fadeOut(function() {
			$("body").removeClass("themeRelative");
		});
		var themeOverlay = $(this);
		$("#themeHome").fadeOut(function() {
			$(".themeOptions[data-zone=" + themeOverlay.data("zone") + "]").fadeIn();
		});
	});
//	// Affiche / Cache les options de l'image du fond
//	$("#backgroundImage").on("change", function() {
//		$("#backgroundImageOptions").slideToggle($(this).val() === "");
//	}).trigger("change");
//	// Aperçu en direct
//	$("themeForm").on("change", function() {
//		// Supprime l'ancien css
//		$("#themePreview").remove();
//		// Polices de caractères
//		var fontTitle = $("#themeFontTitle").val();
//		var fontText = $("#themeFontText").val();
//		var css = "@import url('https://fonts.googleapis.com/css?family=" + fontTitle + "|" + fontText + "');";
//		// Couleurs
//		$(".colorPicker").each(function() {
//			var colorPicker = $(this);
//			var rgba = colorPicker.val().split(',');
//			var colorNormal = "rgba(" + rgba[0] + "," + rgba[1] + "," + rgba[2] + "," + rgba[3] + ")";
//			var colorDark = "rgba(" + (rgba[0] - 20) + "," + (rgba[1] - 20) + "," + (rgba[2] - 20) + "," + rgba[3] + ")";
//			var colorVeryDark = "rgba(" + (rgba[0] - 25) + "," + (rgba[1] - 25) + "," + (rgba[2] - 25) + "," + rgba[3] + ")";
//			var textVariant = "rgba(" + (.213 * rgba[1] + .715 * rgba[2] + .072 * rgba[3] > 127.5) ? "inherit" : "white" + ")";
//			switch(colorPicker.attr("id")) {
//				case "themeColorBody":
//					css += "body{background-color:" + colorNormal + "}";
//					break;
//				case "themeColorElement":
//					css += ""; // TODO ajouter après refonte du template
//					break;
//				case "themeColorHeader":
//					css += "header{background-color:" + colorNormal + "}";
//					css += "header h1{color:" + textVariant + "}";
//					break;
//				case "themeColorMenu":
//					css += "nav{background-color:" + colorNormal + "}";
//					css += "nav a{color:" + textVariant + "}";
//					css += "nav a:hover{background-color:" + colorDark + "}";
//					css += "nav a:target{background-color:" + colorVeryDark + "}";
//					break;
//			}
//			// Polices
//			var font = <?php //echo json_encode($this->fonts); ?>//;
//			css += "body{font-family:'" + fonts[fontTitle] + "',sans-serif}";
//			css += "h1,h2,h3,h4,h5,h6{font-family:'" + fonts[fontText] + "',sans-serif}";
//			// Images
//			css += "body{background-image:url('" + $("#themeImageBody").val() + "')}";
//			css += "header{background-image:url('" + $("#themeImageHeader").val() + "')}";
//
//		});
//		// Applique le nouveau css
//		$("<style>").attr("id", "themePreview").text(css).appendTo("head");
//	}).trigger("change");
</script>