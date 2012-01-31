<?php
function ninja_annc_add_menu() {
    add_submenu_page( 'edit.php?post_type=ninja_annc', __('Plugin Settings'), __('Plugin Settings'), 'edit_users', 'plugin_settings', 'ninja_annc_show_menu' );
}

add_action( 'admin_menu', 'ninja_annc_add_menu' );

function ninja_annc_show_menu(){
	if(!empty($_POST) && check_admin_referer('ninja_save_plugin_settings','ninja_plugin_settings')){
		$current_settings = get_option("ninja_annc_settings");
		
		foreach($_POST as $key => $val){
			if($key != 'submitted' && $key != 'submit'){
				$current_settings[$key] = $val;
			}
		}
		update_option("ninja_annc_settings", $current_settings);
	}
	
	$plugin_settings = get_option("ninja_annc_settings");
	if(isset($plugin_settings['default_title_wrapper'])){
		$title_wrapper = $plugin_settings['default_title_wrapper'];
	}else{
		$title_wrapper = '';
	}	
	if(isset($plugin_settings['default_content_wrapper'])){
		$content_wrapper = $plugin_settings['default_content_wrapper'];
	}else{
		$content_wrapper = '';
	}
?>
	<div class="wrap">
		<div id="icon-ninja-annc" class="icon32"><img src="<?php echo NINJA_ANNC_URL;?>/images/head-ico.png"></div>
		<h2><?php echo 'Ninja Announcements '.NINJA_ANNC_TYPE.' - ';
		_e('Plugin Settings'); 
		?></h2>
		<div class="wrap-left">
		<h3><?php _e('Version');?> <?php echo NINJA_ANNC_VERSION;?></h3>
		<form id="" name="" action="" method="post">
		<?php wp_nonce_field('ninja_save_plugin_settings','ninja_plugin_settings'); ?>
		<input type="hidden" name="submitted" value="yes">
		<input type="hidden" name="default_style" value="unchecked"><input type="checkbox" name="default_style" id="default_style" value="checked" <?php echo $plugin_settings['default_style'];?>><label for="default_style"> <?php _e('Use Ninja Announcements default stylesheet');?></label><br />
		<?php
			if(NINJA_ANNC_TYPE == 'Pro'){
				require_once(NINJA_ANNC_DIR."/includes/pro/plugin-settings-extra.php");
			}
		?>
		
		<br><br>
		<input class="button-primary ninja_save_data" type="submit" value="<?php _e('Save Changes');?>" />
		</form>	
		</div>
	</div>
<?php
}