jQuery(document).ready(function($) {
	$(".ninja_annc_close").click(function(event){
		event.preventDefault();
		var cont_id = this.id.replace("close_", "");
		var annc_id = this.id.replace("close_ninja_annc_container_", "");
		$("#" + cont_id).hide("explode");
	});

});