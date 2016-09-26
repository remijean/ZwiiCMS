<form name="themeSite" id="themeSite" method="post">
	<h2>Options du site</h2>
	<div class="row">
		<div class="col4 block">
			<h3>Couleurs et image</h3>
			<div class="row">
				<div class="col6">
					<label for="themeBackgroundColor">Couleur du fond</label>
					<input type="text" name="themeBackgroundColor" id="themeBackgroundColor" value="<?php echo $this->getData(['theme', 'color', 'background']); ?>" required>
				</div>
				<div class="col6">
					<label for="themeElementColor">Couleur des titre</label>
					<input type="text" name="themeElementColor" id="themeElementColor" value="<?php echo $this->getData(['theme', 'color', 'element']); ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col6">
					<label for="themeBackgroundImage">Image du fond</label>
					<input type="text" name="themeBackgroundColor" id="themeBackgroundColor" value="<?php echo $this->getData(['theme', 'color', 'background']); ?>" required>
				</div>
				<div class="col6">
					<label for="themeElementColor">Couleur des titre</label>
					<input type="text" name="themeElementColor" id="themeElementColor" value="<?php echo $this->getData(['theme', 'color', 'element']); ?>" required>
				</div>
			</div>
		</div>
	</div>
	<button type="button" data-form="pageAdd">Créer</button>
</form>

template::newRow().
template::select('backgroundImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
'label' => 'Image du fond',
'help' => 'Seule une image de format .png, .gif, .jpg ou .jpeg du gestionnaire de fichiers est acceptée.',
'selected' => $this->getData(['theme', 'image', 'background'])
]).
template::script('
// Affiche/cache les options de l\'image du fond
$("#backgroundImage").on("change", function() {
var backgroundImageOptionsDOM = $("#backgroundImageOptions");
if($(this).val() === "") {
backgroundImageOptionsDOM.slideUp();
}
else {
backgroundImageOptionsDOM.slideDown();
}
}).trigger("change");
').
template::closeRow().
template::div([
'id' => 'backgroundImageOptions',
'class' => 'displayNone',
'text' =>
template::openRow().
template::select('backgroundImageRepeat', [
'themeBackgroundImageRepeatNo' => 'Ne pas répéter',
'themeBackgroundImageRepeatX' => 'Sur l\'axe horizontal',
'themeBackgroundImageRepeatY' => 'Sur l\'axe vertical',
'themeBackgroundImageRepeatAll' => 'Sur les deux axes'
], [
'label' => 'Répétition',
'selected' => $this->getData(['theme', 'class', 'backgroundImageRepeat']),
'col' => 6
]).
template::select('backgroundImagePosition', [
'themeBackgroundImagePositionCover' => 'Remplir le fond',
'themeBackgroundImagePositionTopLeft' => 'En haut à gauche',
'themeBackgroundImagePositionTopCenter' => 'En haut au centre',
'themeBackgroundImagePositionTopRight' => 'En haut à droite',
'themeBackgroundImagePositionCenterLeft' => 'Au milieu à gauche',
'themeBackgroundImagePositionCenterCenter' => 'Au milieu au centre',
'themeBackgroundImagePositionCenterRight' => 'Au milieu à droite',
'themeBackgroundImagePositionBottomLeft' => 'En bas à gauche',
'themeBackgroundImagePositionBottomCenter' => 'En bas au centre',
'themeBackgroundImagePositionBottomRight' => 'En bas à droite',
], [
'label' => 'Alignement',
'selected' => $this->getData(['theme', 'class', 'backgroundImagePosition']),
'col' => 6
]).
template::newRow().
template::select('backgroundImageAttachment', [
'themeBackgroundImageAttachmentScroll' => 'Normale',
'themeBackgroundImageAttachmentFixed' => 'Fixe'
], [
'label' => 'Position',
'selected' => $this->getData(['theme', 'class', 'backgroundImageAttachment']),
'col' => 6
]).
template::closeRow()
])
]).
template::block([
'col' => 4,
'title' => 'Polices',
'text' =>
template::openRow().
template::select('titleFont', self::$fonts, [
'label' => 'Police des titres',
'selected' => $this->getData(['theme', 'font', 'title'])
]).
template::newRow().
template::select('textFont', self::$fonts, [
'label' => 'Police du texte',
'selected' => $this->getData(['theme', 'font', 'text'])
]).
template::closeRow()
]).
template::block([
'col' => 4,
'title' => 'Disposition',
'text' =>
template::openRow().
template::select('siteWidth', [
'themeSiteWidthSmall' => 'Petit',
'themeSiteWidthMedium' => 'Moyen',
'themeSiteWidthLarge' => 'Large'
], [
'label' => 'Largeur du site',
'selected' => $this->getData(['theme', 'class', 'siteWidth'])
]).
template::newRow().
template::checkbox('siteRadius', true, 'Coins du site arrondis', [
'checked' => $this->getData(['theme', 'class', 'siteRadius'])
]).
template::newRow().
template::checkbox('siteShadow', true, 'Ombre autour du site', [
'checked' => $this->getData(['theme', 'class', 'siteShadow'])
]).
template::closeRow()
]).
template::closeRow(),
'Options de la bannière' =>
template::openRow().
template::block([
'col' => 4,
'title' => 'Couleur et image',
'text' =>
template::openRow().
template::colorPicker('headerColor', [
'label' => 'Couleur de la bannière',
'value' => $this->getData(['theme', 'color', 'header'])
]).
template::newRow().
template::select('headerImage', helper::listUploads('Aucune image', ['png', 'jpeg', 'jpg', 'gif']), [
'label' => 'Remplacer le titre par une image',
'help' => 'Seule une image de format .png, .gif, .jpg ou .jpeg du gestionnaire de fichiers est acceptée.',
'selected' => $this->getData(['theme', 'image', 'header'])
]).
template::closeRow()
]).
template::block([
'col' => 8,
'title' => 'Disposition',
'text' =>
template::openRow().
template::select('headerPosition', [
'themeHeaderPositionHide' => 'Invisible',
'themeHeaderPositionTop' => 'Dans le haut de la page',
'themeHeaderPositionSite' => 'Dans le site'
], [
'label' => 'Emplacement',
'selected' => $this->getData(['theme', 'class', 'headerPosition']),
'col' => 4
]).
template::select('headerHeight', [
'themeHeaderHeightSmall' => 'Petit',
'themeHeaderHeightMedium' => 'Moyen',
'themeHeaderHeightLarge' => 'Grand',
'themeHeaderHeightAuto' => 'Automatique'
], [
'label' => 'Hauteur',
'selected' => $this->getData(['theme', 'class', 'headerHeight']),
'col' => 4
]).
template::select('headerTextAlign', [
'themeHeaderTextAlignLeft' => 'Gauche',
'themeHeaderTextAlignCenter' => 'Centre',
'themeHeaderTextAlignRight' => 'Droite'
], [
'label' => 'Alignement du contenu',
'selected' => $this->getData(['theme', 'class', 'headerTextAlign']),
'col' => 4
]).
template::newRow().
template::checkbox('headerMargin', true, 'Aligner avec le contenu du site', [
'checked' => $this->getData(['theme', 'class', 'headerMargin']),
'class' => 'displayNone'
]).
template::closeRow().
template::script('
// Affiche/cache l\'alignement de la bannière avec le contenu du site
$("#headerPosition").on("change", function() {
var headerMarginWrapperDOM = $("#headerMarginWrapper");
if($(this).val() === "themeHeaderPositionSite") {
headerMarginWrapperDOM.slideDown();
}
else {
headerMarginWrapperDOM.slideUp(function() {
$("#headerMargin").prop("checked", false);
});
}
}).trigger("change");
')
]).
template::closeRow(),
'Options du menu' =>
template::openRow().
template::block([
'col' => 4,
'title' => 'Couleur',
'text' =>
template::openRow().
template::colorPicker('menuColor', [
'label' => 'Couleur du menu',
'value' => $this->getData(['theme', 'color', 'menu']),
'required' => true
]).
template::closeRow()
]).
template::block([
'col' => 8,
'title' => 'Disposition',
'text' =>
template::openRow().
template::select('menuPosition', [
'themeMenuPositionTop' => 'Dans le haut de la page',
'themeMenuPositionSite' => 'Dans le site',
'themeMenuPositionHeader' => 'En transparence au dessus de la bannière'
], [
'label' => 'Emplacement',
'selected' => $this->getData(['theme', 'class', 'menuPosition']),
'col' => 4
]).
template::select('menuHeight', [
'themeMenuHeightSmall' => 'Petit',
'themeMenuHeightMedium' => 'Moyen',
'themeMenuHeightLarge' => 'Grand'
], [
'label' => 'Hauteur',
'selected' => $this->getData(['theme', 'class', 'menuHeight']),
'col' => 4
]).
template::select('menuTextAlign', [
'themeMenuTextAlignLeft' => 'Gauche',
'themeMenuTextAlignCenter' => 'Centre',
'themeMenuTextAlignRight' => 'Droite'
], [
'label' => 'Alignement du contenu',
'selected' => $this->getData(['theme', 'class', 'menuTextAlign']),
'col' => 4
]).
template::newRow().
template::checkbox('menuMargin', true, 'Aligner avec le contenu du site', [
'checked' => $this->getData(['theme', 'class', 'menuMargin']),
'class' => 'displayNone'
]).
template::closeRow().
template::script('
// Affiche/cache l\'alignement du menu avec le contenu du site
$("#menuPosition").on("change", function() {
var menuMarginWrapperDOM = $("#menuMarginWrapper");
if($(this).val() === "themeMenuPositionSite") {
menuMarginWrapperDOM.slideDown();
}
else {
menuMarginWrapperDOM.slideUp(function() {
$("#menuMargin").prop("checked", false);
});
}
}).trigger("change");
')
]).
template::closeRow()
]).
template::script('
// Aperçu de la personnalisation en direct
$("section").on("change", function() {
var tabContentDOM = $(this);
var bodyDOM = $("body");
var fonts = ' . json_encode(self::$fonts) . ';
// Importe les polices de caractères
var css = "@import url(\'https://fonts.googleapis.com/css?family=" + $("#textFont option:selected").val() + "|" + $("#titleFont option:selected").val() + "\');";
// Supprime les anciennes classes
bodyDOM.removeClass();
// Ajoute les nouvelles classes
// Pour les selects
tabContentDOM.find("select").each(function() {
var selectDOM = $(this);
var option = selectDOM.find("option:selected").val();
// Pour le select d\'ajout d\'image dans la bannière
if(selectDOM.attr("id") === "headerImage") {
$("header img").remove();
if(option === "") {
bodyDOM.removeClass("themeHeaderImage");
}
else {
bodyDOM.addClass("themeHeaderImage");
$("header .inner").append(
$("<img>").attr("src", "' . helper::baseUrl(false) . '" + option)
);
}
}
// Pour le select d\'ajout d\'image de fond
else if(selectDOM.attr("id") === "backgroundImage") {
bodyDOM.css("background-image", "url(\'' . helper::baseUrl(false) . '" + option + "\')");
}
// Pour les select de choix de la police de caractères
else if(selectDOM.attr("id") === "textFont" || selectDOM.attr("id") === "titleFont") {
// Ajout du css pour le texte
if(selectDOM.attr("id") === "textFont") {
css += "
body {
font-family: \'" + fonts[option] + "\', sans-serif;
}
";
}
// Ajout du css pour les titres
else if(selectDOM.attr("id") === "titleFont") {
css += "
h1,
h2,
h3,
h4,
h5,
h6,
.tabTitles {
font-family: \'" + fonts[option] + "\', sans-serif;
}
";
}
}
// Pour les autres
else {
if(option) {
bodyDOM.addClass(option);
}
}
});
// Pour les inputs
tabContentDOM.find("input").each(function() {
var inputDOM = $(this);
// Cas spécifique pour les checkboxs
if(inputDOM.is(":checkbox")) {
if(inputDOM.is(":checked")) {
var name = inputDOM.attr("name").replace("[]", "");
bodyDOM.addClass("theme" + name.charAt(0).toUpperCase() + name.slice(1));
}
}
// Cas simple (ignore les colorPickers)
else if(!inputDOM.hasClass("jscolor")) {
bodyDOM.addClass(inputDOM.val());
}
});
// Pour les colorPickers
$(this).find(".jscolor").each(function() {
var jscolorDOM = $(this);
// Calcul des couleurs
var rgb = hexToRgb(jscolorDOM.val());
if(rgb) {
var color = rgb.r + "," + rgb.g + "," + rgb.b;
var colorDark = (rgb.r - 20) + "," + (rgb.g - 20) + "," + (rgb.b - 20);
var colorVeryDark = (rgb.r - 25) + "," + (rgb.g - 25) + "," + (rgb.b - 25);
var textVariant = (.213 * rgb.r + .715 * rgb.g + .072 * rgb.b > 127.5) ? "inherit" : "#FFF";
}
// Couleur du header
if(jscolorDOM.attr("id") === "headerColor") {
if(rgb) {
css += "
/* Couleur normale */
header {
background-color: rgb(" + color + ");
}
header h1 {
color: " + textVariant + ";
}
";
}
else {
css += "
/* Couleur normale */
header {
background-color: transparent;
}
";
}
}
// Couleurs du menu
else if(jscolorDOM.attr("id") === "menuColor") {
if($("#menuPosition").val() === "themeMenuPositionHeader") {
color = "background-color: rgba(" + color + ", .7);";
colorDark = "background-color: rgba(" + colorDark + ", .7);";
colorVeryDark = "background-color: rgba(" + colorVeryDark + ", .7);";
}
else {
color = "background-color: rgb(" + color + ");";
colorDark = "background-color: rgb(" + colorDark + ");";
colorDark = "background-color: rgb(" + colorVeryDark + ");";
}
css += "
/* Couleur normale */
nav {
" + color + "
}
@media (min-width: 768px) {
nav li ul {
" + color + "
}
}
nav .toggle span,
nav a {
color: " + textVariant + ";
}
/* Couleur foncée */
nav .toggle:hover,
nav a:hover {
" + colorDark + "
}
/* Couleur très foncée */
nav .toggle:active,
nav a:active,
nav a.current {
" + colorVeryDark + "
}
";
}
// Couleurs des éléments
else if(jscolorDOM.attr("id") === "elementColor") {
css += "
/* Couleur normale */
.alert,
input[type=\'submit\'],
.button,
.pagination a,
input[type=\'checkbox\']:checked + label:before,
input[type=\'radio\']:checked + label:before,
.helpContent {
background-color: rgb(" + color + ");
color: " + textVariant + ";
}
h2,
h4,
h6,
a,
.tabTitle.current,
.helpButton span {
color: rgb(" + color + ");
}
input[type=\'text\']:hover,
input[type=\'password\']:hover,
.inputFile:hover,
select:hover,
textarea:hover {
border: 1px solid rgb(" + color + ");
}
/* Couleur foncée */
input[type=\'submit\']:hover,
.button:hover,
.pagination a:hover,
input[type=\'checkbox\']:not(:active):checked:hover + label:before,
input[type=\'checkbox\']:active + label:before,
input[type=\'radio\']:checked:hover + label:before,
input[type=\'radio\']:not(:checked):active + label:before {
background-color: rgb(" + colorDark + ");
}
.helpButton span:hover {
color: rgb(" + colorDark + ");
}
/* Couleur très foncée */
input[type=\'submit\']:active,
.button:active,
.pagination a:active {
background-color: rgb(" + colorVeryDark + ");
}
";
}
// Couleur du fond
else if(jscolorDOM.attr("id") === "backgroundColor") {
css += "
/* Couleur normale */
body {
background-color: rgb(" + color + ");
}
";
}
});
// Supprime le css déjà ajouté
var headDOM = $("head");
headDOM.find("style").remove();
// Retourne le nouveau css
$("<style>").text(css).appendTo(headDOM);
	}).trigger("change");
	').
	template::openRow().
	template::submit('submit', [
				'col' => 2,
				'offset' => 10
			]).
	template::closeRow().
	template::closeForm();