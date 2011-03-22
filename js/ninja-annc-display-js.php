<?php
$plugin_url = $_REQUEST['plugin_url'];
$plugin_url = htmlentities($plugin_url);

?>

jQuery(document).ready(function($) {
	$(".ninja_annc_close").click(function(event){
		var plugin_url = "<?php echo $plugin_url;?>";
		event.preventDefault();
		var cont_id = this.id.replace("close_", "");
		var annc_id = this.id.replace("close_ninja_annc_container_", "");
		$.post( plugin_url + "/include/process.php", { action: "close", annc_id: annc_id },
			function(data){
				
			}
		);
		$("#" + cont_id).hide("explode");
	});

});