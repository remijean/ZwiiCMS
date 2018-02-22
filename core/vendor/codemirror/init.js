/**
 * Initialisation de CodeMirror
 */
$(function() {
	$(".editorCss").each(function() {
		var _this = this;
		// Initialisation de CodeMirror
		var codeMirror = CodeMirror.fromTextArea(_this, {
			lineNumbers: true,
		});
		// Mise à jour de la textarea
		codeMirror.on("change", function() {
			$(_this)
				.val(codeMirror.getValue())
				.trigger("change");
		});
	});
});