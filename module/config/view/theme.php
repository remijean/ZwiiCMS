<style>
	.themeRelative #panel,
	.themeRelative #site,
	.themeRelative header,
	.themeRelative nav,
	.themeRelative section,
	.themeRelative footer {
		position: relative;
	}
	.themeRelative #panel {
		z-index: 11; /* +1 à cause des tooltips */
	}
	.themeRelative #site {
		z-index: 10;
	}
	.themeOverlay {
		-webkit-transition: background .3s;
		transition: background .3s;
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 5;
		cursor: pointer;
	}
	.themeOverlay:hover {
		background: rgba(103, 198, 114, .7);
	}
	.themeOptions,
	#themeBodyBackgroundImageOptions {
		display: none;
	}
</style>
<h1>Personnalisation</h1>
<p id="themeHome">Déplacez votre curseur au dessus d'une zone, puis cliquez dessus afin de d'accéder à ses options de personnalisation.</p>
<div class="themeOptions" data-zone="body">
	<h2>Options de l'arrière plan</h2>
	<form>
		<?php echo template::input('action', [
			'id' => 'actionBody',
			'type' => 'hidden',
			'value' => 'body'
		]); ?>
		<div class="row">
			<div class="col6">
				<div class="block">
					<h4>Couleur</h4>
					<?php echo template::input('themeBodyBackgroundColor', [
						'class' => 'colorPicker',
						'label' => 'Couleur du fond',
						'readonly' => true,
						'value' => $this->getData(['theme', 'body', 'backgroundColor'])
					]); ?>
				</div>
			</div>
			<div class="col6">
				<div class="block">
					<h4>Image</h4>
					<div class="row">
						<div class="col12">
							<?php echo template::file('themeBodyBackgroundImage', [
								'label' => 'Image du fond',
								'value' => $this->getData(['theme', 'body', 'backgroundImage'])
							]); ?>
						</div>
					</div>
					<div id="themeBodyBackgroundImageOptions">
						<div class="row">
							<div class="col6">
								<?php echo template::select('themeBackgroundRepeat', $module::$repeats, [
									'label' => 'Répétition',
									'selected' => $this->getData(['theme', 'body', 'repeat'])
								]); ?>
							</div>
							<div class="col6">
								<?php echo template::select('themeBackgroundPosition', $module::$positions, [
									'label' => 'Alignement',
									'selected' => $this->getData(['theme', 'body', 'position'])
								]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col6">
								<?php echo template::select('themeBackgroundAttachment', $module::$attachments, [
									'label' => 'Position',
									'selected' => $this->getData(['theme', 'body', 'attachment'])
								]); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col2 offset8">
				<?php echo template::button('themeBack', [
					'id' => 'themeBackBody',
					'value' => helper::ico('left', 'right') . 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'id' => 'themeSaveBody',
					'type' => 'submit',
					'value' => helper::ico('check', 'right') . 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<div class="themeOptions" data-zone="header">
	<h2>Options de la bannière</h2>
	<form>
		<?php echo template::input('action', [
			'id' => 'actionHeader',
			'type' => 'hidden',
			'value' => 'header'
		]); ?>
		<div class="row">
			<div class="col2 offset8">
				<?php echo template::button('themeBack', [
					'id' => 'themeBackHeader',
					'value' => helper::ico('left', 'right') . 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'id' => 'themeSaveHeader',
					'type' => 'submit',
					'value' => helper::ico('check', 'right') . 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<div class="themeOptions" data-zone="menu">
	<h2>Options du menu</h2>
	<form>
		<?php echo template::input('action', [
			'id' => 'actionMenu',
			'type' => 'hidden',
			'value' => 'menu'
		]); ?>
		<div class="row">
			<div class="col2 offset8">
				<?php echo template::button('themeBack', [
					'id' => 'themeBackFooter',
					'value' => helper::ico('left', 'right') . 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'id' => 'themeSaveFooter',
					'type' => 'submit',
					'value' => helper::ico('check', 'right') . 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<div class="themeOptions" data-zone="site">
	<form>
		<?php echo template::input('action', [
			'id' => 'actionSite',
			'type' => 'hidden',
			'value' => 'site'
		]); ?>
		<h2>Options du site</h2>
		<div class="row">
			<div class="col4">
				<div class="block">
					<h4>Couleurs et image</h4>
					<div class="row">
						<div class="col6">
							<?php echo template::input('themeTitleColor', [
								'class' => 'colorPicker',
								'label' => 'Couleur des titres',
								'readonly' => true,
								'value' => $this->getData(['theme', 'title', 'color'])
							]); ?>
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
					'id' => 'themeBackFooter',
					'value' => helper::ico('left', 'right') . 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'id' => 'themeSaveFooter',
					'type' => 'submit',
					'value' => helper::ico('check', 'right') . 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<div class="themeOptions" data-zone="footer">
	<h2>Options du bas de page</h2>
	<form>
		<?php echo template::input('action', [
			'id' => 'actionFooter',
			'type' => 'hidden',
			'value' => 'footer'
		]); ?>
		<div class="row">
			<div class="col2 offset8">
				<?php echo template::button('themeBack', [
					'id' => 'themeBackFooter',
					'value' => helper::ico('left', 'right') . 'Annuler'
				]); ?>
			</div>
			<div class="col2">
				<?php echo template::button('themeSave', [
					'id' => 'themeSaveFooter',
					'type' => 'submit',
					'value' => helper::ico('check', 'right') . 'Enregistrer'
				]); ?>
			</div>
		</div>
	</form>
</div>
<script>
	// Active les palettes de couleurs
	$(function() {
		$(".colorPicker").colorPicker();
	});
	// Ajout des overlays
	$("<div>").addClass("themeOverlay").data("zone", "body").appendTo("body");
	$("<div>").addClass("themeOverlay").data("zone", "header").appendTo("header");
	$("<div>").addClass("themeOverlay").data("zone", "menu").appendTo("nav");
	$("<div>").addClass("themeOverlay").data("zone", "site").appendTo("section");
	$("<div>").addClass("themeOverlay").data("zone", "footer").appendTo("footer");
	// Ajout d'une position relative aux éléments pour empêcher l'overlay du body de recouvrir le reste du site
	$("body").addClass("themeRelative");
	// Affiche le choix de la zone
	$("button[name=themeBack]").on("click", function() {
		$(".themeOptions:visible").fadeOut(function() {
			$("#themeHome").fadeIn(function() {
				$(".themeOverlay").show();
				$("body").addClass("themeRelative");
			});
		});
	});
	// Affiche les options d'éditions
	$(".themeOverlay").on("click", function() {
		$(".themeOverlay:visible").fadeOut(function() {
			$("body").removeClass("themeRelative"); // Supprime la position relative sinon le colorPicker ne fonctionne pas
		});
		var themeOverlay = $(this);
		$("#themeHome").fadeOut(function() {
			console.log(3);
			$(".themeOptions[data-zone=" + themeOverlay.data("zone") + "]").fadeIn();
		});
	});
	// Affiche / Cache les options de l'image du fond
	$("#themeBodyBackgroundImage").on("change", function() {
		if($(this).val()) {
			$("#themeBodyBackgroundImageOptions").fadeIn();
		}
		else {
			$("#themeBodyBackgroundImageOptions").fadeOut();
		}
	}).trigger("change");

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