<?php
$plugin_url = $_REQUEST['plugin_url'];
$admin_url = $_REQUEST['admin_url'];
$plugin_url = $plugin_url.'/include';
?>	

	jQuery(document).ready(function($) {

	$(".ninja-annc-delete").live('click', function(event){
		//alert('hi');
		event.preventDefault();
		var ninja_annc_id = this.id.replace('ninja-annc-delete-', '');
		var really_delete= confirm("Delete this announcement? This is irreversible!");
		if (really_delete== true){
			window.location = "<?php echo $plugin_url;?>/process.php?action=delete&ninja_annc_id=" + ninja_annc_id;	
		}		
	});
	
	$("#ninja-annc-edit-cancel").click(function(){
		window.location = "<?php echo $admin_url;?>";	
	});
	

	$(".date").datepicker();
	
	$("#ignoredates").click(function(){
		var state = this.checked;
		if(state){
			$("#begindate").attr('disabled', 'disabled');
			$("#begintimehr").attr('disabled', 'disabled');
			$("#begintimemin").attr('disabled', 'disabled');
			$("#begintimeampm").attr('disabled', 'disabled');
			
			$("#enddate").attr('disabled', 'disabled');
			$("#endtimehr").attr('disabled', 'disabled');
			$("#endtimemin").attr('disabled', 'disabled');
			$("#endtimeampm").attr('disabled', 'disabled');

			$("#begindate").css({"background-color": "gray"});
			$("#begintimehr").css({"background-color": "gray"});
			$("#begintimemin").css({"background-color": "gray"});
			$("#begintimeampm").css({"background-color": "gray"});
			
			$("#enddate").css({"background-color": "gray"});
			$("#endtimehr").css({"background-color": "gray"});
			$("#endtimemin").css({"background-color": "gray"});
			$("#endtimeampm").css({"background-color": "gray"});
		}else{
			$("#begindate").removeAttr('disabled');
			$("#begintimehr").removeAttr('disabled');
			$("#begintimemin").removeAttr('disabled');
			$("#begintimeampm").removeAttr('disabled');
			
			$("#enddate").removeAttr('disabled');
			$("#endtimehr").removeAttr('disabled');
			$("#endtimemin").removeAttr('disabled');
			$("#endtimeampm").removeAttr('disabled');
			
			$("#begindate").css({"background-color": "white"});
			$("#begintimehr").css({"background-color": "white"});
			$("#begintimemin").css({"background-color": "white"});
			$("#begintimeampm").css({"background-color": "white"});
			
			$("#enddate").css({"background-color": "white"});	
			$("#endtimehr").css({"background-color": "white"});
			$("#endtimemin").css({"background-color": "white"});
			$("#endtimeampm").css({"background-color": "white"});
			
		}
	});	
});
