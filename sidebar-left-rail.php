<?php
	$post_name = '';
	if (is_404()) {
		$post_name = '404';
	}
	else if (is_page()) {
		$post_name = $post->post_name;
	}
?>

<?php if (is_active_sidebar($post_name . '-left-rail')) : ?>

<div class="primary-widget-area">
	<div id="subnav">
		<span class="title"><?php the_title();?></span>
	</div>
<?php dynamic_sidebar($post_name . '-left-rail'); ?>
</div>

<?php endif; ?>