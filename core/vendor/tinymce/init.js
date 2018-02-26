/**
 * Initialisation de TinyMCE
 */
tinymce.init({
	selector: ".editorWysiwyg",
	language: "fr_FR",
	menubar: false,
	statusbar: false,
	plugins: "advlist anchor autolink autoresize autosave code colorpicker contextmenu fullscreen hr image imagetools legacyoutput link lists media paste searchreplace tabfocus table template textcolor",
	toolbar: "restoredraft | undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | insert | code searchreplace fullscreen",
	insert_button_items: 'image link media template inserttable | hr | anchor',
	body_class: "editorWysiwyg",
	style_formats: [
		{title: 'Headers', items: [
			{title: 'Header 1', format: 'h1'},
			{title: 'Header 2', format: 'h2'},
			{title: 'Header 3', format: 'h3'},
			{title: 'Header 4', format: 'h4'}
		]},
		{title: 'Inline', items: [
			{title: 'Bold', icon: 'bold', format: 'bold'},
			{title: 'Italic', icon: 'italic', format: 'italic'},
			{title: 'Underline', icon: 'underline', format: 'underline'},
			{title: 'Strikethrough', icon: 'strikethrough', format: 'strikethrough'},
			{title: 'Superscript', icon: 'superscript', format: 'superscript'},
			{title: 'Subscript', icon: 'subscript', format: 'subscript'},
			{title: 'Code', icon: 'code', format: 'code'}
		]},
		{title: 'Blocks', items: [
			{title: 'Paragraph', format: 'p'},
			{title: 'Blockquote', format: 'blockquote'},
			{title: 'Div', format: 'div'},
			{title: 'Pre', format: 'pre'}
		]},
		{title: 'Alignment', items: [
			{title: 'Left', icon: 'alignleft', format: 'alignleft'},
			{title: 'Center', icon: 'aligncenter', format: 'aligncenter'},
			{title: 'Right', icon: 'alignright', format: 'alignright'},
			{title: 'Justify', icon: 'alignjustify', format: 'alignjustify'}
		]}
	],
	extended_valid_elements: "script[language|type|src]",
	content_css: [
		baseUrl + "core/layout/common.css",
		baseUrl + "core/vendor/tinymce/content.css",
		baseUrl + "site/data/theme.css",
		baseUrl + "site/data/custom.css"
	],
	media_dimensions: false,
	image_advtab: true,
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
	]
});