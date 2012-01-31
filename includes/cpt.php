<?php
add_action('init', 'ninja_annc_cpt');
function ninja_annc_cpt() {
	register_post_type( 'ninja_annc',
		array(
			'labels' => array(
				'name' => __( 'Ninja Announcements' )." ".NINJA_ANNC_TYPE,
				'singular_name' => __( 'Announcement' ),
				'not_found' => __('No Announcements Found'),
				'new_item' => __('New Announcement'),
				'add_new_item' => __('New Announcement'),
				'edit_item' => __('Edit Announcement'),
			),
		'public' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'menu_icon' => plugins_url( 'images/ninja_announc_icon.png' , dirname(__FILE__) ),
		'menu_position' => 25,
		)
	);
}