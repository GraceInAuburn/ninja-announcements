<?php
session_start();
include_once('../../../../wp-config.php');
include_once('../../../../wp-load.php');
include_once('../../../../wp-includes/wp-db.php');
global $wpdb;
$wpdb->show_errors();

$ninja_annc_id = $_REQUEST['ninja_annc_id'];
$table_name = $wpdb->prefix . "ninja_annc";


if($_REQUEST['action'] == 'activate'){
	$ninja_annc_row = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $ninja_annc_id", ARRAY_A);
	$ninja_annc_begindate = $ninja_annc_row['begindate'];
	$ninja_annc_enddate = $ninja_annc_row['enddate'];
	$ninja_annc_today = current_time("timestamp");

	
	if($ninja_annc_enddate >= $ninja_annc_today || $ninja_annc_enddate == 0){
		$wpdb->update( $table_name, array( 'active' => 1), array( 'id' => $ninja_annc_id ));
	}
	$previous_page = $_SERVER['HTTP_REFERER'];
	header('Location: '.$previous_page);
}

if($_REQUEST['action'] == 'deactivate'){
	$wpdb->update( $table_name, array( 'active' => 0), array( 'id' => $ninja_annc_id ));
	$previous_page = $_SERVER['HTTP_REFERER'];
	header('Location: '.$previous_page);
}

if($_REQUEST['action'] == 'delete'){
	$sql = "DELETE FROM $table_name WHERE id = $ninja_annc_id";
	$wpdb->query($sql);
	$previous_page = $_SERVER['HTTP_REFERER'];
	header('Location: '.$previous_page);
}

if($_REQUEST['action'] == 'close'){
	$annc_id = $_REQUEST['annc_id'];
	$_SESSION['ninja_annc_'.$annc_id] = 'closed';
	echo $_SESSION['ninja_annc_'.$annc_id];
}

?>