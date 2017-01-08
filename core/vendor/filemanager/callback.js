/**
 * Callback de RFM
 */
function responsive_filemanager_callback(fieldId) {
	$("#" + fieldId).trigger("change");
	$(".lity-close").trigger("click");
}