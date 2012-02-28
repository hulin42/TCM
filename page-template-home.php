<?php
/*
Template Name: Page with Leads
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />

	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" />
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>

	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div id="wrapper">
		<div id="topNav">
			<?php wp_nav_menu(array('menu' => 'TCM Top Nav')); ?>
			
			<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
				<a class="addthis_button_email"></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f4a72c065c6de87"></script>

			<div id="social-facebook"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/social_facebook.png" alt="social_facebook" width="31" height="31" /></a></div>
			<div id="social-youtube"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/social_youTube.png" alt="social_youTube" width="31" height="31" /></a></div>
		</div>
		<div id="header">
			<div id="siteLogo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_directory'); ?>/images/tcm_logo.png" alt="tcm_logo" width="293" height="92" /></a></div>
			<div id="search">
		    	<?php get_search_form(); ?>
			</div>
			<div id="menu">
				<?php wp_nav_menu(array('menu' => 'TCM Main Nav')); ?>
			</div>
		</div>

			<div id="content">

				<div id="primary-widget-area">

					<div id="subnav">

					<?php
					$has_subpages = false;
					// Check to see if the current page has any subpages
					$children = wp_list_pages('&child_of='.$post->ID.'&echo=0');
					if($children) {
					    $has_subpages = true;
					}
					// Reseting $children
					$children = "";

					// Fetching the right thing depending on if we're on a subpage or on a parent page (that has subpages)
					if(is_page() && $post->post_parent) {
					    // This is a subpage
					    $children = wp_list_pages("title_li=&include=".$post->post_parent ."&echo=0");
					    $children .= wp_list_pages("title_li=&child_of=".$post->post_parent ."&echo=0");
					} else if($has_subpages) {
					    // This is a parent page that have subpages
					    $children = wp_list_pages("title_li=&include=".$post->ID ."&echo=0");
					    $children .= wp_list_pages("title_li=&child_of=".$post->ID ."&echo=0");
					}
					?>
					<?php // Check to see if we have anything to output ?>
					<?php if ($children) { ?>
					<ul class="submenu">
					    <?php echo $children; ?>
					</ul>
					<?php } ?>

					</div>

					<?php
						$page = $post;
						$page_name = null;
						while ($page) {
							if (is_active_sidebar($page->post_name . '-left-rail')) {
								$page_name = $page->post_name;
								$page = null;
							}
							else if ($page->post_parent) {
								$page = get_post($page->post_parent);
							}
							else {
								$page = null;
							}
						}
					?>
					<?php if ($page_name) : ?>
						<?php dynamic_sidebar($page_name . '-left-rail'); ?>
					<?php else : ?>
						<?php get_sidebar(); ?>
					<?php endif; ?>

				</div>

				<div class="content">
					<?php require_once ('inc/home-leads-block.php'); ?>
				</div>

			</div>

<?php get_footer(); ?>