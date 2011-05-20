<?php
/*
Plugin Name: Ninja Announcements
Plugin URI: http://plugins.wpninjas.net?p=9
Description: A plugin that displays annoucements on pages and posts. They can be scheduled so that they are only displayed between specified dates/times. Additionally, all annoucements are edited via the built-in WordPress RTE. You can also include images and videos from your WordPress media library or YouTube. Each of your announcements has it's own location setting, allowing you to place the announcement exactly where you want it, even display it as a widget!
Author: Kevin Stover
Version: 1.2.3
Author URI: http://wpninjas.net
*/

/*
Table of Contents:

I) Output Section 
II) Options Menu
	A)Load Scripts and Styles 
	B)HTML Output
		1)Submit Handler
		2)Edit Announcement HTML output
		3)New Announcement HTML output 
		4)Announcement Table HTML output 
III) Widget Section
IV) Activation Code 


 
----- Begin Output section:

We need to do a few things:
	1)Pull every active announcement from the database.
	2)Check to see if that announcement is scheduled to happen today
	3)Update the database to deactivate past-due announcements.
*/
session_start();
function ninja_annc_display_css(){
	wp_enqueue_style( 'ninja-annc-css', WP_PLUGIN_URL.'/ninja-announcements/css/ninja_annc_display.css' );
}

function ninja_annc_display($ninja_annc_id){
	global $wpdb;
	//$wpdb->show_errors();
	if($ninja_annc_id['id']){
		$ninja_annc_id = $ninja_annc_id['id'];
	}
	//Figure out our tablename. We grab the WordPress prefix and attach our plugin's suffix.
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	//Include our plugin css file.

	//Grab all the active announcements in the database.
	$ninja_annc_row = $wpdb->get_row( "SELECT * FROM ".$ninja_annc_table_name." WHERE active = 1 AND id = ".$ninja_annc_id, ARRAY_A);

	//We need to compare dates, so let's figure out what today is.
	$ninja_annc_today = current_time("timestamp");
	
	//Assign php variables to each of our database values.
	$ninja_annc_id = $ninja_annc_row['id'];
	$ninja_annc_message = $ninja_annc_row['message'];
	$ninja_annc_active = $ninja_annc_row['active'];
	$ninja_annc_begindate = $ninja_annc_row['begindate'];
	$ninja_annc_enddate = $ninja_annc_row['enddate'];
	
	if($ninja_annc_active == 1){
		if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){ //We only want to continue if our enddate hasn't happened yet OR our enddate is 0. An enddate of 0 indicates that this is an unscheduled announcement.
			if($ninja_annc_begindate <= $ninja_annc_today || $ninja_annc_begindate == 0){ //Only continue if we have passed the begindate OR the begindate is 0.
				if($_SESSION['ninja_annc_'.$ninja_annc_id] != 'closed'){
					echo "<div id='ninja_annc_container_".$ninja_annc_id."' class='ninja_annc_container'><div id='ninja_annc_".$ninja_annc_id."' class='ninja_annc'>".$ninja_annc_message."</div><span class='ninja_annc_close' id='close_ninja_annc_container_".$ninja_annc_id."'><a href='#'>[close]</a></span></div>"; //Our actual output line.
				}
			}
		}else{ //Today is past the enddate of our scheduled announcement, let's deactivate it.
			//Update our database to deactivate this announcement.
			$wpdb->update( $ninja_annc_table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
		}
	}
}

function ninja_annc_default_display(){
	global $wpdb;
	//$wpdb->show_errors();
	
	//Figure out our tablename. We grab the WordPress prefix and attach our plugin's suffix.
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	//Include our plugin css file.

	//Grab all the active announcements in the database.
	$ninja_annc_rows = $wpdb->get_results( "SELECT * FROM ".$ninja_annc_table_name." WHERE location = 0 AND active = 1", ARRAY_A);
	//We need to compare dates, so let's figure out what today is.
	$ninja_annc_today = current_time("timestamp");
	
	foreach($ninja_annc_rows as $row){ //Steps through each of our row results.
		
		//Assign php variables to each of our database values.
		$ninja_annc_id = $row['id'];
		$ninja_annc_message = $row['message'];
		$ninja_annc_active = $row['active'];
		$ninja_annc_begindate = $row['begindate'];
		$ninja_annc_enddate = $row['enddate'];
		
		if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){ //We only want to continue if our enddate hasn't happened yet OR our enddate is 0. An enddate of 0 indicates that this is an unscheduled announcement.
			if($ninja_annc_begindate <= $ninja_annc_today || $ninja_annc_begindate == 0){ //Only continue if we have passed the begindate OR the begindate is 0.
				if($_SESSION['ninja_annc_'.$ninja_annc_id] != 'closed'){
					echo "<div id='ninja_annc_container_".$ninja_annc_id."' class='ninja_annc_container'><div id='ninja_annc_".$ninja_annc_id."' class='ninja_annc'>".$ninja_annc_message."</div><span class='ninja_annc_close' id='close_ninja_annc_container_".$ninja_annc_id."'><a href='#'>[close]</a></span></div>"; //Our actual output line.
				}
			}
		}else{ //Today is past the enddate of our scheduled announcement, let's deactivate it.
			//Update our database to deactivate this announcement.
			$wpdb->update( $ninja_annc_table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
		}
	}
}

function ninja_annc_display_all(){
	global $wpdb;
	//$wpdb->show_errors();
	
	//Figure out our tablename. We grab the WordPress prefix and attach our plugin's suffix.
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	//Include our plugin css file.

	//Grab all the active announcements in the database.
	$ninja_annc_rows = $wpdb->get_results( "SELECT * FROM ".$ninja_annc_table_name." WHERE active = 1", ARRAY_A);
	//We need to compare dates, so let's figure out what today is.
	$ninja_annc_today = current_time("timestamp");
	
	foreach($ninja_annc_rows as $row){ //Steps through each of our row results.
		
		//Assign php variables to each of our database values.
		$ninja_annc_id = $row['id'];
		$ninja_annc_message = $row['message'];
		$ninja_annc_active = $row['active'];
		$ninja_annc_begindate = $row['begindate'];
		$ninja_annc_enddate = $row['enddate'];
		
		if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){ //We only want to continue if our enddate hasn't happened yet OR our enddate is 0. An enddate of 0 indicates that this is an unscheduled announcement.
			if($ninja_annc_begindate <= $ninja_annc_today || $ninja_annc_begindate == 0){ //Only continue if we have passed the begindate OR the begindate is 0.
				if($_SESSION['ninja_annc_'.$ninja_annc_id] != 'closed'){
					echo "<div id='ninja_annc_container_".$ninja_annc_id."' class='ninja_annc_container'><div id='ninja_annc_".$ninja_annc_id."' class='ninja_annc'>".$ninja_annc_message."</div><span class='ninja_annc_close' id='close_ninja_annc_container_".$ninja_annc_id."'><a href='#'>[close]</a></span></div>"; //Our actual output line.
				}
			}
		}else{ //Today is past the enddate of our scheduled announcement, let's deactivate it.
			//Update our database to deactivate this announcement.
			$wpdb->update( $ninja_annc_table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
		}
	}
}


add_action("get_header", "ninja_annc_display_css");
add_action("wp_head", "ninja_annc_default_display");

function ninja_display_js(){
	$plugin_url = WP_PLUGIN_URL.'/ninja-announcements';
	wp_enqueue_script('ninja-annc-display',
		WP_PLUGIN_URL . '/ninja-announcements/js/ninja-annc-display-js.php?plugin_url='.$plugin_url,
		array('jquery', 'jquery-ui-core'));
}
add_action("init", "ninja_display_js");

add_shortcode("ninja_annc", "ninja_annc_display");

/*
----- End Output Section
*/





/*
----- Create an options menu that will allow users to change announcements
*/

//Add our menu function to the loading of the admin menu.
add_action('admin_menu', 'ninja_annc_menu');
//BEGIN load scripts and styles
function ninja_annc_menu() { //Called when the WordPress admin page loads.
	$page = add_options_page('Ninja Announcements', 'Ninja Announcements', 'manage_options', 'ninja-annc-options', 'ninja_annc_options');
	//Load up our scripts and stylesheets.
	add_action( "admin_print_scripts-$page", "ninja_annc_scripts");
	add_action("admin_print_styles-$page", "ninja_annc_styles");
}

//Include all of our necessary Javascript files.
function ninja_annc_scripts() {

	wp_deregister_script( 'jquery-ui-core' );
	wp_register_script( 'jquery-ui-core', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js');

	//Plugin_url is passed on to our javascript file so that we can determine the plugin directory regardless of where it is.
	$plugin_url = WP_PLUGIN_URL.'/ninja-announcements';
	//Wonky work around because I couldn't figure out how to locate the wp-admin folder. Simply gets the content url and replaces wp-content with our full page url.
	//This should be changed as soon as I figure out how to actually point to the wp-admin directory.
	$wp_content_url = WP_CONTENT_URL;
	$admin_url = str_replace("wp-content", "wp-admin/options-general.php?page=ninja-annc-options", $wp_content_url);
	
	wp_enqueue_script('ninja-annc-js',
		WP_PLUGIN_URL . '/ninja-announcements/js/ninja-annc-js.php?plugin_url='.$plugin_url.'&admin_url='.$admin_url,
		array('jquery', 'jquery-ui-core'));

	/*
	//Load our javascripts for the tinyMCE editor.
	remove_all_filters('mce_external_plugins');
	wp_enqueue_script('common');
	wp_enqueue_script('jquery-color');
	wp_admin_css('thickbox');
	wp_print_scripts('post');
	wp_print_scripts('media-upload');
	wp_print_scripts('jquery');
	wp_print_scripts('jquery-ui-core');
	wp_print_scripts('jquery-ui-tabs');
	wp_print_scripts('tiny_mce');
	wp_print_scripts('editor');
	wp_print_scripts('editor-functions');
	add_thickbox();
	wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
	*/

}

//Include all of our necessary CSS files.
function ninja_annc_styles(){
	wp_enqueue_style( 'ninja-annc-css', WP_PLUGIN_URL.'/ninja-announcements/css/ninja_annc_admin.css' );
	wp_enqueue_style( 'jquery-ui-css', WP_PLUGIN_URL.'/ninja-announcements/css/flick/jquery-ui-1.7.3.custom.css' );
}
//END load scripts and styles

//BEGIN HTML output.
//This is the function that actually creates our options menu. It's a pretty long one.
function ninja_annc_options() {

	global $wpdb;

	$wp_content_url = WP_CONTENT_URL;
	$admin_url = str_replace("wp-content", "wp-admin/options-general.php?page=ninja-annc-options", $wp_content_url);

	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	$current_url = $_SERVER["REQUEST_URI"];

	//Test to see if the user has permission to set options.
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	//This if() statement handles user input from the edit section.
	if($_REQUEST['submitted'] == 'yes'){ // BEGIN submit handling if()

		$ninja_annc_id = $_REQUEST['ninja_annc_id'];
	
		$ninja_annc_begindate = $_REQUEST['begindate'];
		$ninja_annc_begintimehr = $_REQUEST['begintimehr'];
		$ninja_annc_begintimemin = $_REQUEST['begintimemin'];
		$ninja_annc_begintimeampm = $_REQUEST['begintimeampm'];
		
		$ninja_annc_enddate = $_REQUEST['enddate'];
		$ninja_annc_endtimehr = $_REQUEST['endtimehr'];
		$ninja_annc_endtimemin = $_REQUEST['endtimemin'];
		$ninja_annc_endtimeampm = $_REQUEST['endtimeampm'];
		
		$ninja_annc_begindate = $ninja_annc_begindate.' '.$ninja_annc_begintimehr.':'.$ninja_annc_begintimemin.$ninja_annc_begintimeampm;
		$ninja_annc_enddate = $ninja_annc_enddate.' '.$ninja_annc_endtimehr.':'.$ninja_annc_endtimemin.$ninja_annc_endtimeampm;
		
		//echo "begin before ".$ninja_annc_begindate;
		//echo "end before ".$ninja_annc_enddate;
		
		$ninja_annc_message = stripslashes($_REQUEST['content']);
		$ninja_annc_active = 1;
		$ninja_annc_location = $_REQUEST['ninja_annc_location'];
		
		$ninja_annc_begindate = strtotime($ninja_annc_begindate);
		$ninja_annc_enddate = strtotime($ninja_annc_enddate);
		
		//echo "begin after ".$ninja_annc_begindate;
		//echo "end after ".$ninja_annc_enddate;
		
		if($_REQUEST['ignoredates'] == "checked"){
			$ninja_annc_begindate = 0;
			$ninja_annc_enddate = 0;
		}
		
		if($_REQUEST['ninja_annc_id'] == 'new'){
			$rows_affected = $wpdb->insert( $ninja_annc_table_name, array( 'begindate' => $ninja_annc_begindate, 'enddate' => $ninja_annc_enddate, 'message' => $ninja_annc_message, 'active' => '0', 'location' => $ninja_annc_location ) );
		}else{
			$wpdb->update( $ninja_annc_table_name, array( 'begindate' => $ninja_annc_begindate, 'enddate' => $ninja_annc_enddate, 'message' => $ninja_annc_message, 'location' => $ninja_annc_location ), array( 'id' => $ninja_annc_id ));
		}
		
		echo "<script language='javascript'>window.location = '".$admin_url."'</script>";
	} // END submit handling if()
	
	//This if...else() statement handles the nuts and bolts of our html output. 
	//Eventually it will be replaced by a switch().
	//Flow goes: Edit Announcement? -> New Announcement? -> Table.
	//This part of our If...else statement creates the editing HTML
	if($_REQUEST['action'] == 'edit') { //BEGIN edit handling if()
		
		$ninja_annc_id = $_REQUEST['ninja_annc_id'];
		$ninja_annc_row = $wpdb->get_row("SELECT * FROM $ninja_annc_table_name WHERE id = $ninja_annc_id", ARRAY_A);

		$ninja_annc_id = $ninja_annc_row['id'];
		$ninja_annc_location = $ninja_annc_row['location'];
		$ninja_annc_message = stripslashes($ninja_annc_row['message']);
		$ninja_annc_begin = $ninja_annc_row['begindate'];
		$ninja_annc_end = $ninja_annc_row['enddate'];
		$rightnow = current_time("timestamp");
		
		if($ninja_annc_end != 0){
			$ninja_annc_begindate = date("m/d/Y", $ninja_annc_begin);
			$ninja_annc_begintimehr =  date("g", $ninja_annc_begin);
			$ninja_annc_begintimemin =  date("i", $ninja_annc_begin);
			$ninja_annc_begintimeampm =  date("a", $ninja_annc_begin);
			
			$ninja_annc_enddate = date("m/d/Y", $ninja_annc_end);
			$ninja_annc_endtimehr = date("g", $ninja_annc_end);
			$ninja_annc_endtimemin = date("i", $ninja_annc_end);
			$ninja_annc_endtimeampm = date("a", $ninja_annc_end);
			
		}else{
			$ninja_annc_ignore = 1;
			$ninja_annc_begindate = date("m/d/Y", $rightnow);
			$ninja_annc_enddate = date("m/d/Y", $rightnow);	
		}
		
		//$ninja_annc_begindate = $ninja_annc_begindate.' '.$ninja_annc_begintimehr.':'.$ninja_annc_begintimemin.$ninja_annc_begintimeampm;
		
		//echo $ninja_annc_begindate;
		wp_tiny_mce( false,  // true makes the editor "teeny"
		array(
			"theme_advanced_path" => false
		)
		);
		wp_tiny_mce_preload_dialogs();
		?>
        <div class="wrap">
	<div id="ninja_annc_options_edit" class="icon32"><br></div>
	<h2 id="opener">Edit Announcement - ID: <?php echo $ninja_annc_id;?></h2>
		<form name="" action="" method="post">
		<input type="hidden" name="submitted" value="yes">
		<input type="hidden" name="ninja_annc_id" value="<?php echo $ninja_annc_id;?>">
		Ignore Dates: <input type="checkbox" name="ignoredates" id="ignoredates" value="checked" <?php if($ninja_annc_ignore == 1){ echo "checked";}?>><br>
		Begin Date: <input type="text" class="date" name="begindate" id="begindate" value="<?php echo $ninja_annc_begindate;?>" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
		Time: 
		<select name="begintimehr" id="begintimehr" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<?php
				$x = 1;
				while($x <= 12){
					echo "<option";
					if($x <= 9){
						echo " value = '0$x'";
					}else{
						echo " value = '$x'";
					}
					if($ninja_annc_begintimehr == $x){
						echo " selected";
					}elseif($x == 12 && $ninja_annc_ignore == 1){
						echo " selected";
					}
					echo ">$x</option>";
					$x++;
				}
			
			?>
		</select> 
		: <select name="begintimemin" id="begintimemin" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<?php
				$x = 0;
				while($x <= 55){
					echo "<option";
					if($x <= 5){
						echo " value = '0$x'";					
					}else{
						echo " value = '$x'";
					}
					if($ninja_annc_begintimemin == $x){
						echo " selected";
					}elseif($x == 0 && $ninja_annc_ignore == 1){
						echo " selected";
					}
					echo ">";
					if($x <= 5){
						echo "0$x";
					}else{
						echo "$x";
					}
					echo "</option>";
					$x = $x + 5;
				}
			
			?>
		</select>
		<select name="begintimeampm" id="begintimeampm" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<option value = "am" <?php if($ninja_annc_begintimeampm == "am"){ echo "selected";}?>>am</option>
			<option value = "pm" <?php if($ninja_annc_begintimeampm == "pm"){ echo "selected";}?>>pm</option>
			</select>
		<br>
		End Date:  &nbsp;  <input type="text"  class="date" name="enddate" id="enddate" value="<?php echo $ninja_annc_enddate;?>" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
		Time: 
		<select name="endtimehr" id="endtimehr" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<?php
				$x = 1;
				while($x <= 12){
					echo "<option";
					if($x <= 9){
						echo " value = '0$x'";
					}else{
						echo " value = '$x'";
					}
					if($ninja_annc_endtimehr == $x){
						echo " selected";
					}elseif($x == 12 && $ninja_annc_ignore == 1){
						echo " selected";
					}
					echo ">$x</option>";
					$x++;
				}
			
			?>
		</select> 
		: <select name="endtimemin" id="endtimemin" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<?php
				$x = 0;
				while($x <= 55){
					echo "<option";
					if($x <= 5){
						echo " value = '0$x'";					
					}else{
						echo " value = '$x'";
					}
					if($ninja_annc_endtimemin == $x){
						echo " selected";
					}elseif($x == 0 && $ninja_annc_ignore == 1){
						echo " selected";
					}
					echo ">";
					if($x <= 5){
						echo "0$x";
					}else{
						echo "$x";
					}
					echo "</option>";
					$x = $x + 5;
				}
			
			?>
		</select>
		<select name="endtimeampm" id="endtimeampm" class="time" <?php if($ninja_annc_ignore == 1){ echo "style='background-color: gray' disabled";}?>>
			<option value = "am" <?php if($ninja_annc_endtimeampm == "am"){ echo "selected";}?>>am</option>
			<option value = "pm" <?php if($ninja_annc_endtimeampm == "pm"){ echo "selected";}?>>pm</option>
		</select><br>
		Location: <select name="ninja_annc_location" id="ninja_annc_location">
			<option value="0" <?php if($ninja_annc_location == 0){ echo "selected";}?>>Default (Header)</option>
			<option value="2" <?php if($ninja_annc_location == 2){ echo "selected";}?>>Sidebar (Widget)</option>
			<option value="1" <?php if($ninja_annc_location == 1){ echo "selected";}?>>Manual (Function)</option>
		</select> &nbsp; <span <?php if($ninja_annc_location != 1){ echo "style = 'display:none;'";}?> id="ninja_annc_function">Display Code: &nbsp;
		&#60;&#63;php
if (function_exists('ninja_annc_display')) {
	ninja_annc_display(<?php echo $ninja_annc_id;?>);
}
&#63;&#62; </span>
		
		<br>
		
		<div id="poststuff">
		<?php
		if ( current_user_can( 'upload_files' ) ) {
			?>
			<div id="media-buttons" class="hide-if-no-js">
				<?php do_action( 'media_buttons' ); ?>
			</div>
			<?php
		}
		?>
		<textarea rows="30" class="theEditor" cols="40" name="content" tabindex="2" id="content" style="border-color:#000000;"><?php echo $ninja_annc_message;?></textarea>
	
		</div>
		</div>
		
		<input type="submit" value="Submit" class="button-primary">
		<input type="button" id="ninja-annc-edit-cancel" value="Cancel" class="button-secondary">
		</form>
        </div>
         
	<?php
	//END edit handling if()
	//OUTPUT HTML for our new announcements page.
	}elseif($_REQUEST['action'] == 'new'){ //BEGIN new announcement handling if()
		
		$rightnow = current_time("timestamp");
		
		$ninja_annc_today = date("m/d/Y", $rightnow);
		
		?>
                <div class="wrap">
	<div id="ninja_annc_options_new" class="icon32"><br></div>
	<h2 id="opener">New Announcement</h2>
		<form name="" action="" method="post">
		<input type="hidden" name="submitted" value="yes">
		<input type="hidden" name="ninja_annc_id" value="new">
		Ignore Dates: <input type="checkbox" name="ignoredates" id="ignoredates" value="checked"><br>
		Begin Date: <input type="text" class="date" name="begindate" id="begindate" value="<?php echo $ninja_annc_today;?>">
		Time: 
		<select name="begintimehr" id="begintimehr" class="time">
			<?php
				$x = 1;
				while($x <= 12){
					echo "<option";
					if($x <= 9){
						echo " value = '0$x'";
					}else{
						echo " value = '$x'";
					}
					if($x == 12){
						echo " selected";
					}
					echo ">$x</option>";
					$x++;
				}
			
			?>
		</select> 
		: <select name="begintimemin" id="begintimemin" class="time">
			<?php
				$x = 0;
				while($x <= 55){
					echo "<option";
					if($x <= 5){
						echo " value = '0$x'";					
					}else{
						echo " value = '$x'";
					}
					if($x == 0){
						echo " selected";
					}
					echo ">";
					if($x <= 5){
						echo "0$x";
					}else{
						echo "$x";
					}
					echo "</option>";
					$x = $x + 5;
				}
			
			?>
		</select>
		<select name="begintimeampm" id="begintimeampm" class="time">
			<option value = "am">am</option>
			<option value = "pm">pm</option>
		</select>
		<br>
		End Date:  &nbsp;  <input type="text"  class="date" name="enddate" id="enddate" value="<?php echo $ninja_annc_today;?>">
		Time: 
		<select name="endtimehr" id="endtimehr" class="time">
						<?php
				$x = 1;
				while($x <= 12){
					echo "<option";
					if($x <= 9){
						echo " value = '0$x'";
					}else{
						echo " value = '$x'";
					}
					if($x == 12){
						echo " selected";
					}
					echo ">$x</option>";
					$x++;
				}
			
			?>
		</select> 
		: <select name="endtimemin" id="endtimemin" class="time">
			<?php
				$x = 0;
				while($x <= 55){
					echo "<option";
					if($x <= 5){
						echo " value = '0$x'";					
					}else{
						echo " value = '$x'";
					}
					if($x == 0){
						echo " selected";
					}
					echo ">";
					if($x <= 5){
						echo "0$x";
					}else{
						echo "$x";
					}
					echo "</option>";
					$x = $x + 5;
				}
			
			?>
		</select>
		<select name="endtimeampm" id="endtimeampm" class="time">
			<option value = "am">am</option>
			<option value = "pm">pm</option>
			</select><br>
		Location: <select name="ninja_annc_location" id="ninja_annc_location">
			<option value="0">Default (Header)</option>
			<option value="2">Sidebar (Widget)</option>
			<option value="1">Manual (Function)</option>	
		</select><br>
		<div id="poststuff">
		<?php
		if ( current_user_can( 'upload_files' ) ) {
			?>
			<div id="media-buttons" class="hide-if-no-js">
				<?php do_action( 'media_buttons' ); ?>
			</div>
			<?php
		}
		?>
		<textarea rows="30" class="theEditor" cols="40" name="content" tabindex="2" id="content" style="border-color:#000000;"></textarea>
	
		</div>
		</div>
		
		<input type="submit" value="Submit" class="button-primary">
		<input type="button" id="ninja-annc-edit-cancel" value="Cancel" class="button-secondary">
		</form>
        </div>
	<?php
	//END new announcement handling if()
	}else{ //BEGIN table handling if()
	//Our user is on the main page of the options menu. 
	//Display a table of existing announcements.
	$ninja_annc_rows = $wpdb->get_results( "SELECT * FROM $ninja_annc_table_name WHERE active=1", ARRAY_A);
	$ninja_annc_today = current_time("timestamp");
	
	
	foreach($ninja_annc_rows as $row){
	
		$ninja_annc_id = $row['id'];
		$ninja_annc_begindate = $row['begindate'];
		$ninja_annc_enddate = $row['enddate'];
		
		if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){
		}else{
			$wpdb->update( $ninja_annc_table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
		}
	}
	
	$ninja_annc_rows = $wpdb->get_results( "SELECT * FROM $ninja_annc_table_name", ARRAY_A);
	?>
	
	<div class="wrap">
	<div id="ninja_annc_options_general" class="icon32"><br></div>
	<h2 id="opener">Ninja Announcements<a class="button add-new-h2" href="<?php echo $current_url;?>&action=new">New Announcement</a></h2>

	<table class="widefat" cellspacing="0" id="all-plugins-table">
		<thead>
			<tr>
				<th class="mange-column">Actions</th>
				<th class="mange-column">Location</th>				
				<th class="mange-column">Begin Date</th>
				<th class="mange-column">End Date</th>
				<th class="mange-column">Message</h>
			</tr>
		</thead>
		<tbody class="plugins">
			
			<?php
				foreach($ninja_annc_rows as $row){
					
					$ninja_annc_id = $row['id'];
					$ninja_annc_message = $row['message'];
					$ninja_annc_begin = $row['begindate'];
					$ninja_annc_end = $row['enddate'];
					
					$ninja_annc_message = strip_tags($ninja_annc_message);
					$ninja_annc_message = substr($ninja_annc_message, 0, 100);
					$ninja_annc_message .= "...";
					
					$ninja_annc_location = $row['location'];
					if($ninja_annc_location == 0){
						$ninja_annc_location = "Default (Header)";
					}elseif($ninja_annc_location == 1){
						$ninja_annc_location = "Manual (See Edit Page For Function)";
					}else{
						$ninja_annc_location = "Sidebar (Widget)";
					}
					
					if($ninja_annc_begin != 0){
						$ninja_annc_begindate = date("m/d/Y", $ninja_annc_begin);
						$ninja_annc_begintime = date("g:i a", $ninja_annc_begin);
						
						$ninja_annc_enddate = date("m/d/Y", $ninja_annc_end);
						$ninja_annc_endtime = date("g:i a", $ninja_annc_end);
					}else{
						$ninja_annc_begindate = '--/--/----';
						$ninja_annc_enddate = '--/--/----';
						$ninja_annc_begintime ="";
						$ninja_annc_endtime = "";
					}
					
					$edit_url = $current_url.'&action=edit&ninja_annc_id='.$ninja_annc_id;
					
					if($row['active'] == 0){
						$ninja_annc_class = "inactive";
					}else{
						$ninja_annc_class = "active";
					}					
					
					echo '<tr class="'.$ninja_annc_class.'">';
					echo '<td>';
					if($ninja_annc_class == 'inactive'){
						echo '<span class="active"><a href="'.WP_PLUGIN_URL.'/ninja-announcements/include/process.php?action=activate&ninja_annc_id='.$ninja_annc_id.'" class="ninja-annc-activate" id="ninja-annc-activate-'.$ninja_annc_id.'">Activate</a></span>';
					}else{
						echo '<span class="deactivate"><a href="'.WP_PLUGIN_URL.'/ninja-announcements/include/process.php?action=deactivate&ninja_annc_id='.$ninja_annc_id.'" class="ninja-annc-deactivate" id="ninja-annc-deactivate-'.$ninja_annc_id.'">Deactivate</a></span>';
					}
					echo ' | <span class="edit"><a href="'.$edit_url.'" class="ninja-annc-edit" id="ninja-annc-edit-'.$ninja_annc_id.'">Edit</a></span>';
					echo ' | <span class="delete"><a href="#" class="ninja-annc-delete" id="ninja-annc-delete-'.$ninja_annc_id.'">Delete</a></span></td>';
					echo '<td>'.$ninja_annc_location.'</td>';
					echo '<td>'.$ninja_annc_begindate.' '.$ninja_annc_begintime.'</td>';
					echo '<td>'.$ninja_annc_enddate.' '.$ninja_annc_endtime.'</td>';
					echo '<td>'.$ninja_annc_message.'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
	
	<tfoot>
			<tr>
				<th class="mange-column">Actions</th>
				<th class="mange-column">Location</th>
				<th class="mange-column">Begin Date</th>
				<th class="mange-column">End Date</th>
				<th class="mange-column">Message</h>
			</tr>
		</tfoot>
	
	
	</table>
	</div>
	
	<?php
	}//END table handling if() AND overall output handling if()
}
//END HTML output.
/*
----- End Options Menu
*/

/*
------ Begin Widget Section
*/
function ninja_annc_widget($vars) {
//This is the text that shows up on the page that the widget is placed on.
	global $wpdb;
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	$ninja_annc_id = $vars['widget_id'];
	$ninja_annc_id = str_replace("ninja_annc_", "", $ninja_annc_id);
	$ninja_annc_row = $wpdb->get_row( "SELECT * FROM $ninja_annc_table_name WHERE active = 1 AND id = $ninja_annc_id", ARRAY_A);
	
	$ninja_annc_message = $ninja_annc_row['message'];
	$ninja_annc_active = $ninja_annc_row['active'];
	$ninja_annc_begindate = $ninja_annc_row['begindate'];
	$ninja_annc_enddate = $ninja_annc_row['enddate'];
	
	echo "<h2 class='widgettitle'></h2>";
	
	if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){ //We only want to continue if our enddate hasn't happened yet OR our enddate is 0. An enddate of 0 indicates that this is an unscheduled announcement.
		if($ninja_annc_begindate <= $ninja_annc_today || $ninja_annc_begindate == 0){ //Only continue if we have passed the begindate OR the begindate is 0.
			echo "<div id='ninja_annc_widget_container_".$ninja_annc_id."' class='ninja_annc_widget_container'><div id='ninja_annc_widget_".$ninja_annc_id."' class='ninja_annc_widget'>".$ninja_annc_message."</div><span class='ninja_annc_close' id='close_ninja_annc_widget_container_".$ninja_annc_id."'><a href='#'>[close]</a></span></div>"; //Our actual output line.
		}
	}else{ //Today is past the enddate of our scheduled announcement, let's deactivate it.
		//Update our database to deactivate this announcement.
		$wpdb->update( $ninja_annc_table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
	}
}
 
function ninja_annc_widget_init(){
//This registers our widget as a usable one.
	global $wpdb;
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";
	$ninja_annc_rows = $wpdb->get_results( "SELECT * FROM ".$ninja_annc_table_name." WHERE location = 2", ARRAY_A);
	//We need to compare dates, so let's figure out what today is.
	
	foreach($ninja_annc_rows as $row){ //Steps through each of our row results.
		$ninja_annc_id = $row['id'];
		$ninja_annc_active = $row['active'];
		if($ninja_annc_active == 0){
			$ninja_annc_status = " [Inactive]";
		}else{
			$ninja_annc_status = " [Active]";
		}
		wp_register_sidebar_widget('ninja_annc_'.$ninja_annc_id , 'Ninja Announcement Message '.$ninja_annc_id.$ninja_annc_status, 'ninja_annc_widget');
	}
}

//Load our widgets when the widget page is loaded.
add_action("plugins_loaded", "ninja_annc_widget_init");

// ----- END widget section


/*
We need to create the database when someone activates the plugin.
*/

register_activation_hook(__FILE__,'ninja_annc_install');

//Set our database version. (Useful for upgrades)
$ninja_annc_db_version = "0.1";

function ninja_annc_install () {
	global $wpdb;
	global $ninja_annc_db_version;
	
	//Get the tablename
	$ninja_annc_table_name = $wpdb->prefix . "ninja_annc";

	//Check to see if the table already exists. If it does, don't do anything.
	if($wpdb->get_var("SHOW TABLES LIKE '$ninja_annc_table_name'") != $ninja_annc_table_name) {
		$sql = "CREATE TABLE " . $ninja_annc_table_name . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		begindate bigint(11) DEFAULT '0' NOT NULL,
		enddate bigint(11) DEFAULT '0' NOT NULL,
		active smallint(1) DEFAULT '0' NOT NULL,
		location smallint(1) DEFAULT '0' NOT NULL,
		message longtext NOT NULL,
		UNIQUE KEY id (id)
		);";

		$begindate = 0;
		$enddate = 0;
		$message = "Howdy. This is your first announcement. It won't show up unless you activate it.";
		$active = 0;
		$location = 0;
			
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		$rows_affected = $wpdb->insert( $ninja_annc_table_name, array( 'begindate' => $begindate, 'enddate' => $enddate, 'message' => $message, 'active' => $active , 'location' => $location ) );
		
		add_option("ninja_annc_db_version", $ninja_annc_db_version);
	}
}

?>