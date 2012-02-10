<?php
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Include Custom Post Types
	include_once(ABSPATH . 'wp-content/themes/TCM/posttypes.php');
		
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

?>