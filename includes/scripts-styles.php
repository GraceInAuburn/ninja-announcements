<?php
add_action('admin_head', 'ninja_annc_edit_js');

function ninja_annc_edit_js(){
	global $post;
	$wp_version = get_bloginfo('version');
	if(isset($_REQUEST['taxonomy'])){
		$taxonomy = $_REQUEST['taxonomy'];
	}else{
		$taxonomy = '';
	}
	if((isset($post) AND $post->post_type == 'ninja_annc') OR $taxonomy == 'ninja_annc_groups'){
		wp_enqueue_script('jquery-tokeninput-js',
			NINJA_ANNC_URL .'/js/min/jquery.tokeninput.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog'), '', false);
			
		if(version_compare( $wp_version, '3.2-Beta1' , '>')){	
			//wp_enqueue_script('ninja_annc_admin_js',
				//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin.js',
				//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
				
			wp_enqueue_script('ninja_annc_admin_js',
			NINJA_ANNC_URL .'/js/min/ninja_annc_admin.min.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
		}else{
			//wp_enqueue_script('ninja_annc_admin_js',
					//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin_3.1.js',
					//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
					
			wp_enqueue_script('ninja_annc_admin_js',
			NINJA_ANNC_URL .'/js/min/ninja_annc_admin_3.1.min.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
		}
		
		if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
			wp_enqueue_script( 'jquery-ui-datepicker', 
			NINJA_FORMS_URL .'/js/min/jquery.ui.datepicker.min.js',
			array('jquery', 'jquery-ui-core'));	
		}
			
		if(isset($post)){
			wp_localize_script( 'ninja_annc_admin_js', 'settings', array( 'plugin_url' => NINJA_ANNC_URL,  'post_status' => $post->post_status) );
		}
		wp_enqueue_style( 'jquery-smoothness', NINJA_ANNC_URL .'/css/smoothness/jquery-smoothness.css');
		wp_enqueue_style( 'token-input', NINJA_ANNC_URL .'/css/token-input.css');		
		wp_enqueue_style( 'token-input-facebook-css', NINJA_ANNC_URL .'/css/token-input-facebook.css');
		wp_enqueue_style( 'ninja-annc-admin', NINJA_ANNC_URL .'/css/ninja-annc-admin.css');
		if(!isset($_REQUEST['taxonomy'])){
			add_filter( 'gettext', 'change_publish_button', 10, 2 );
		}
	}
}

add_action('load-widgets.php', 'ninja_annc_widget_js');

function ninja_annc_widget_js(){
	$wp_version = get_bloginfo('version');

	if(version_compare( $wp_version, '3.2-Beta1' , '>')){	
		//wp_enqueue_script('ninja_annc_admin_js',
			//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin.js',
			//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
			
		wp_enqueue_script('ninja_annc_admin_js',
		NINJA_ANNC_URL .'/js/min/ninja_annc_admin.min.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
	}else{
		//wp_enqueue_script('ninja_annc_admin_js',
				//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin_3.1.js',
				//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
				
		wp_enqueue_script('ninja_annc_admin_js',
		NINJA_ANNC_URL .'/js/min/ninja_annc_admin_3.1.min.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
	}
	
	if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
		wp_enqueue_script( 'jquery-ui-datepicker', 
		NINJA_FORMS_URL .'/js/min/jquery.ui.datepicker.min.js',
		array('jquery', 'jquery-ui-core'));	
	}
		
	wp_localize_script( 'ninja_annc_admin_js', 'settings', array( 'plugin_url' => NINJA_ANNC_URL) );
	wp_enqueue_style( 'jquery-smoothness-css', NINJA_ANNC_URL .'/css/smoothness/jquery-smoothness.css');
}

add_action('load-edit-tags.php', 'ninja_annc_tax_js');

function ninja_annc_tax_js(){
	$wp_version = get_bloginfo('version');
	if($_REQUEST['taxonomy'] == 'ninja_annc_groups'){
		wp_enqueue_script('jquery-tokeninput-js',
			NINJA_ANNC_URL .'/js/min/jquery.tokeninput.js',
			array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog'), '', false);
					
		if(version_compare( $wp_version, '3.2-Beta1' , '>')){	
			//wp_enqueue_script('ninja_annc_admin_js',
				//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin.js',
				//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
				
				wp_enqueue_script('ninja_annc_admin_js',
				NINJA_ANNC_URL .'/js/min/ninja_annc_admin.min.js',
				array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
		}else{
			//wp_enqueue_script('ninja_annc_admin_js',
					//NINJA_ANNC_URL .'/js/dev/ninja_annc_admin_3.1.js',
					//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
					
					wp_enqueue_script('ninja_annc_admin_js',
					NINJA_ANNC_URL .'/js/min/ninja_annc_admin_3.1.min.js',
					array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);	
		}
			
		if(version_compare( $wp_version, '3.3-beta3-19254' , '<')){
			wp_enqueue_script( 'jquery-ui-datepicker', 
			NINJA_FORMS_URL .'/js/min/jquery.ui.datepicker.min.js',
			array('jquery', 'jquery-ui-core'));	
		}	
			
		wp_localize_script( 'ninja_annc_admin_js', 'settings', array( 'plugin_url' => NINJA_ANNC_URL) );
		wp_enqueue_style( 'jquery-smoothness-css', NINJA_ANNC_URL .'/css/smoothness/jquery-smoothness.css');
		wp_enqueue_style( 'token-input', NINJA_ANNC_URL .'/css/token-input.css');		
	}
}

function ninja_annc_display_js(){
	if(!is_admin()){
		$wp_version = get_bloginfo('version');
		$plugin_settings = get_option("ninja_annc_settings");
		$default_style = $plugin_settings['default_style'];

		//wp_enqueue_script('ninja_annc_display_js',
			//NINJA_ANNC_URL .'/js/dev/ninja_annc_display.js',
			//array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);					
			
		wp_enqueue_script('ninja_annc_display_js',
		NINJA_ANNC_URL .'/js/min/ninja_annc_display.min.js',
		array('jquery', 'jquery-ui-core', 'jquery-ui-sortable', 'jquery-ui-dialog', 'jquery-ui-datepicker'), '', false);			

		wp_localize_script( 'ninja_annc_display_js', 'ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );			
		if($default_style == 'checked'){
			wp_enqueue_style( 'ninja-annc-display', NINJA_ANNC_URL .'/css/ninja-annc-display.css');
		}
	}
}