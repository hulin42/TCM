<?php

// Add new post type for Homepage Promos
add_action('init', 'homepage_promos_init');
function homepage_promos_init() 
{
	$homepage_promos_labels = array(
		'name' => _x('Homepage Promos', 'post type general name'),
		'singular_name' => _x('Homepage Promo', 'post type singular name'),
		'all_items' => __('All Homepage Promos'),
		'add_new' => _x('Add new Homepage Promo', 'Homepage Promo'),
		'add_new_item' => __('Add new Homepage Promo'),
		'edit_item' => __('Edit Homepage Promo'),
		'new_item' => __('New Homepage Promo'),
		'view_item' => __('View Homepage Promo'),
		'search_items' => __('Search in Homepage Promos'),
		'not_found' =>  __('No Homepage Promo found'),
		'not_found_in_trash' => __('No Homepage Promo found in trash'), 
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $homepage_promos_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 5,
		'supports' => array('title','editor','author','thumbnail'),
		'has_archive' => false
	); 
	register_post_type('Homepage Promos',$args);
}

?>