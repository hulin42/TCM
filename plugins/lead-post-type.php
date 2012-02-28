<?php
/**
* Adds Lead post type to site along with Lead Position taxonomy for specifying
* which loops a Lead belongs to.
*/

class Tw_Lead_Post_Type {

	const POST_TYPE = 'lead';

	function init() {

		register_post_type(self::POST_TYPE, array(
			'labels' => array(
				'name' => _x('Leads', 'post type general name'),
				'singular_name' => _x('Lead', 'post type singular name'),
				'add_new' => _x('Add New', 'lead'),
				'add_new_item' => __('Add New Lead'),
				'edit_item' => __('Edit Lead'),
				'new_item' => __('New Lead'),
				'view_item' => __('View Lead'),
				'search_items' => __('Search Leads'),
				'not_found' =>  __('No leads found'),
				'not_found_in_trash' => __('No leads found in Trash'),
				'parent_item_colon' => ''
			),
			'public' => true,
			'publicly_queryable' => false,
			'exclude_from_search' => true,
			'query_var' => 'lead',
			'rewrite' => false,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hiearachical' => false,
			'supports' => array(
					'title', 'excerpt', 'thumbnail',
					Tw_Clickthru_Meta_Handler::SUPPORTS,
					Tw_Feature_Location_Meta_Handler::SUPPORTS,
				),
		));

		// Set up the necessary image sizes and thumbnails
		add_image_size('lead-main', 864, 328); //main big image
		add_image_size('lead-side', 276, 170); //smaller feature box
	}

	static function get_lead_posts($posts_per_page = 1, $position = '') {
		$posts_query = NULL;

		if ($posts_per_page < 1) {
			$posts_per_page = 1;
		}

		//core arguments
		$args = array(
			'post_type' => self::POST_TYPE,
			'posts_per_page' => $posts_per_page,
			'no_found_rows' => true,
		);

		//get by position
		if (!empty($position) && array_key_exists($feature_location, Tw_Feature_Location_Meta_Handler::$positions)) {
			$args['meta_key'] = Tw_Feature_Location_Meta_Handler::SUPPORTS;
			$args['meta_value'] = $position;
		}

		$posts_query = new WP_Query($args);
		return $posts_query;
	}

}

add_action('init', array(new Tw_Lead_Post_Type, 'init'));
