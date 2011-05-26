	jQuery(document).ready(function($) {

	$(".ninja-annc-delete").live('click', function(event){
		//alert('hi');
		event.preventDefault();
		var ninja_annc_id = this.id.replace('ninja-annc-delete-', '');
		var really_delete= confirm("Delete this announcement? This is irreversible!");
		if (really_delete== true){
			$.post(ajaxurl, {ninja_annc_id:ninja_annc_id, action:"wpnj_delete_annc"}, function(data){
				$("#tr_" + ninja_annc_id).remove();
			});
		}		
	});	
	$(".ninja-annc-activate").live('click', function(event){
		//alert('hi');
		event.preventDefault();
		var ninja_annc_id = this.id.replace('ninja-annc-activate-', '');
		$.post(ajaxurl, {ninja_annc_id:ninja_annc_id, action:"wpnj_activate_annc"}, function(data){
			//alert('activated');
			$("#ninja-annc-activate-" + ninja_annc_id).removeClass('ninja-annc-activate');
			$("#ninja-annc-activate-" + ninja_annc_id).addClass('ninja-annc-deactivate');
			$("#ninja-annc-activate-" + ninja_annc_id).attr('id', 'ninja-annc-deactivate-' + ninja_annc_id);
			$("#tr_" + ninja_annc_id).removeClass('inactive');
			$("#tr_" + ninja_annc_id).addClass('active');
			$("#active_" + ninja_annc_id).attr("innerHTML", "Deactivate");
		});
	});	
	$(".ninja-annc-deactivate").live('click', function(event){
		event.preventDefault();
		var ninja_annc_id = this.id.replace('ninja-annc-deactivate-', '');
		$.post(ajaxurl, {ninja_annc_id:ninja_annc_id, action:"wpnj_deactivate_annc"}, function(data){
			//alert('deactivated');
			$("#ninja-annc-deactivate-" + ninja_annc_id).removeClass('ninja-annc-deactivate');
			$("#ninja-annc-deactivate-" + ninja_annc_id).addClass('ninja-annc-activate');
			$("#ninja-annc-deactivate-" + ninja_annc_id).attr('id', 'ninja-annc-activate-' + ninja_annc_id);
			$("#tr_" + ninja_annc_id).removeClass('active');
			$("#tr_" + ninja_annc_id).addClass('inactive');
			$("#active_" + ninja_annc_id).attr("innerHTML", "Activate");
		});
	});
	
	
	$("#ninja-annc-edit-cancel").click(function(){
		history.go(-1);
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
