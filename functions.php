<?php

   //options
   add_theme_support('post-thumbnails');

   //plugin includes
   require_once ('plugins/clickthru-meta-handler.php');
   require_once ('plugins/feature-location-meta-handler.php');
   require_once ('plugins/lead-post-type.php');


	// Add RSS links to <head> section
	automatic_feed_links();

	// Include Custom Post Types
	// require_once ('posttypes.php');

	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');

	// Site menus
	if (function_exists('register_nav_menus')) {
		register_nav_menus(
			array(
				'main_nav' => 'Main Navigation Menu',
				'top_nav' => 'Top of the page Nav',
			)
		);
	}

	// Sidebar code from Andy... still figuring it out :-P
	if (!function_exists('tcm_widgets_init')) :
		function tcm_widgets_init() {
		// Define an object to represent the 404 page
			$four_oh_four = new stdClass;
			$four_oh_four->post_name = $four_oh_four->post_title = '404';

			// Get all of the pages
			$pages = query_posts(array(
				'post_type' => 'page',
				'post_parent' => 0,
				'nopaging' => true,
				'orderby' => 'title',
				'order' => 'ASC',
			));
			// ... and reset the main query otherwise pages come through as posts
			wp_reset_query();

			// If there are no pages, use an empty array
			if (empty($pages)) {
				$pages = array();
				}
				// Add the 404 object to the array of pages
				$pages[] = $four_oh_four;

				// Loop through all of the pages
				foreach ($pages as $page) {
				// ... add a widget area for the page's left rail
				register_sidebar(array(
					'id' => $page->post_name . '-left-rail',
					'name' => $page->post_title . ' - Left Rail',
					'description' => 'The left rail for ' . $page->post_title,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				));
		}
	}
	endif;
	add_action('widgets_init', 'tcm_widgets_init');






   //functions
   function tw_is_valid_url($url) {
	  return preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(\/.*)?$/i', $url);
   }

   function tw_format_title ($title, $length) {
	  $original_string = $title;

	  if (mb_strlen($title) > $length) {

		 //remove tags
		 $title = strip_tags($title);

		 //shorten to required length
		 $title = mb_substr($title, 0, $length);
		 $whitespace_position = mb_strrpos($title, ' ');

		 if ($whitespace_position > 0) {
			$title = mb_substr($original_string, 0, $whitespace_position);
		 }

		 $title .= '...';
	  }
	  return $title;
   }


   function tw_get_thumbnail($post_id, $size) {
		if (empty($post_id) || empty($size)) return '';

		// Check if the gallery has a featured image
		if (has_post_thumbnail($post_id)) {
			// ... if so, use it
			$attachment = get_the_post_thumbnail($post_id, $size);
			if($attachment) return $attachment;
		}

		// ... otherwise, use the first attachment
		$attachment = get_children(array(
				'post_parent' => $post_id,
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => 1,
			));

		// Make sure there is a first attachment
		if (empty($attachment)) return '';

		$attachment = array_shift($attachment);

		return wp_get_attachment_image($attachment->ID, $size);
	}
