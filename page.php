<?php get_header(); ?>

			<div id="content">

<!--			<?php get_sidebar(); ?>-->
				
				<?php
					$page = $post;
					$page_name = null;
					while ($page) {
						if (is_active_sidebar($page->post_name . '-left-rail')) {
							$page_name = $page->post_name;
							$page = null;
						}
						else {
							$page = get_post($page->post_parent);
						}
					}
				?>
				<?php if ($page_name) : ?>
					<?php dynamic_sidebar($page_name . '-left-rail'); ?>
				<?php else : ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
										
				<div class="content">
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
						<div class="post" id="post-<?php the_ID(); ?>">
				
							<h1><?php the_title(); ?></h1>
				
							<div class="entry">
				
								<?php the_content(); ?>
				
								<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
				
							</div>
				
						</div>
						
						<?php // comments_template(); ?>
				
						<?php endwhile; endif; ?>
				
				</div>

			</div>

<?php get_footer(); ?>