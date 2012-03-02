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
		<div id="header" style="height:112px">
			<div id="siteLogo"><a href="<?php echo get_option('home'); ?>/"><img src="<?php bloginfo('template_directory'); ?>/images/tcm_logo.png" alt="tcm_logo" width="293" height="92" /></a></div>
			<div id="search">
		    	<?php get_search_form(); ?>
			</div>
			<div id="menu" style="visibility:hidden; height:0">
				<?php wp_nav_menu(array('menu' => 'TCM Main Nav')); ?>
			</div>
		</div>

			<div id="content">
				<?php require_once ('inc/home-leads-block.php'); ?>
			</div>

<?php get_footer(); ?>