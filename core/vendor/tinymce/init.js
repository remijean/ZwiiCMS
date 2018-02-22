/**
 * Initialisation de TinyMCE
 */
tinymce.init({
	selector: ".editorWysiwyg",
	language: "fr_FR",
	plugins: "advlist anchor autolink autoresize code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media paste preview searchreplace tabfocus table template textcolor textpattern wordcount",
	toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media template",
	body_class: "editorWysiwyg",
	extended_valid_elements: "script[language|type|src]",
	content_css: [
		baseUrl + "core/layout/common.css",
		baseUrl + "core/vendor/tinymce/init.css",
		baseUrl + "site/data/theme.css",
		baseUrl + "site/data/custom.css"
	],
	relative_urls: false,
	document_base_url: baseUrl,
	filemanager_access_key: privateKey,
	external_filemanager_path: baseUrl + "core/vendor/filemanager/",
	external_plugins: {
		"filemanager": baseUrl + "core/vendor/filemanager/plugin.min.js"
	},
	// Templates
	templates: [
		{
			title: "Bloc de texte",
			url: baseUrl + "core/vendor/tinymce/templates/block.html",
			description: "Bloc de texte avec un titre."
		},
		{
			title: "Colonnes symétriques : 6 - 6",
			url: baseUrl + "core/vendor/tinymce/templates/col6.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes symétriques : 4 - 4 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col4.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes symétriques : 3 - 3 - 3 - 3",
			url: baseUrl + "core/vendor/tinymce/templates/col3.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes asymétriques : 4 - 8",
			url: baseUrl + "core/vendor/tinymce/templates/col4-8.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes asymétriques : 8 - 4",
			url: baseUrl + "core/vendor/tinymce/templates/col8-4.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes asymétriques : 2 - 10",
			url: baseUrl + "core/vendor/tinymce/templates/col2-10.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		},
		{
			title: "Colonnes asymétriques : 10 - 2",
			url: baseUrl + "core/vendor/tinymce/templates/col10-2.html",
			description: "Grille adaptative sur 12 colonnes, sur mobile elles passent les unes en dessous des autres."
		}
	],
	// Permet de détecter un changement dans la textearea, utile pour le message des modifications non enregistrées du formulaire
	setup: function(editor) {
		editor.on("keydown", function() {
			$(editor.targetElm).trigger("keydown");
		});
	}
});