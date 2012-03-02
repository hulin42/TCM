<div id="slider">
<?php $lead_handle = Tw_Lead_Post_Type::get_lead_posts(1, 'feature-main'); ?>
<?php if (!empty($lead_handle) && $lead_handle->have_posts()) : while ($lead_handle->have_posts()) : $lead_handle->the_post(); ?>
	<?php
		$post_id = get_the_ID();
		$clickthru_url_options = get_post_meta($post_id, Tw_Clickthru_Meta_Handler::SUPPORTS, true);
		if (empty($clickthru_url_options['url']) || !tw_is_valid_url($clickthru_url_options['url'])) {
			$block_tag_start = $block_tag_end = 'div';
		} else {
			$block_tag_start = 'a href="' . esc_url($clickthru_url_options['url']) . '"';
			if (!empty($clickthru_url_options['is_new']) && $clickthru_url_options['is_new']) {
				$block_tag_start.= ' target="_blank"';
			}
			$block_tag_end = 'a';
		}
	?>
	<<?php echo $block_tag_start; ?> class="post" id="post-<?php echo $post_id; ?>">
		<?php echo get_the_post_thumbnail($post_id, 'lead-main'); ?>
		<h1><?php the_title(); ?></h1>
		<div class="entry">
			<?php echo tw_format_title(get_the_excerpt(), 200); ?>
		</div>
	</<?php echo $block_tag_end; ?>>
<?php endwhile; endif; ?>
</div>

<div id="menu">
	<?php wp_nav_menu(array('menu' => 'TCM Main Nav')); ?>
</div>
			
<div id="homepageSubFeatures">
<?php foreach (array('feature-left', 'feature-center', 'feature-right') as $dynamic_position) : ?>
	<?php $lead_handle = Tw_Lead_Post_Type::get_lead_posts(1, $dynamic_position); ?>
	<?php if (!empty($lead_handle) && $lead_handle->have_posts()) : while ($lead_handle->have_posts()) : $lead_handle->the_post(); ?>
		<?php
			$post_id = get_the_ID();
			$clickthru_url_options = get_post_meta($post_id, Tw_Clickthru_Meta_Handler::SUPPORTS, true);
			if (empty($clickthru_url_options['url']) || !tw_is_valid_url($clickthru_url_options['url'])) {
				$block_tag_start = $block_tag_end = 'div';
			} else {
				$block_tag_start = 'a href="' . esc_url($clickthru_url_options['url']) . '"';
				if (!empty($clickthru_url_options['is_new']) && $clickthru_url_options['is_new']) {
					$block_tag_start.= ' target="_blank"';
				}
				$block_tag_end = 'a';
			}
		?>
		<<?php echo $block_tag_start; ?> class="post" id="post-<?php the_ID(); ?>">
			<?php echo tw_get_thumbnail(get_the_ID(), 'lead-side'); ?>
			<h4><?php the_title(); ?></h4>
			<div class="entry">
				<?php echo tw_format_title(get_the_excerpt(), 200); ?>
			</div>
		</<?php echo $block_tag_end; ?>>
	<?php endwhile; endif; ?>
<?php endforeach; ?>
</div>