<?php
/*
Template Name: Page with Leads
*/

	get_header();
?>

			<div id="content">

<!--			<?php get_sidebar(); ?>-->

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