<div id="primary-widget-area">

	<div id="subnav">
		<span class="title"><?php the_title();?></span>

		<?php if(!$post->post_parent){ 
			$children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
		
			}else{
		
			if($post->ancestors)
				{$ancestors = end($post->ancestors); $children = wp_list_pages('title_li=&child_of='.$ancestors.'&echo=0');}
			}

		if ($children) {?>
		
		<ul> <?php echo $children; ?></ul>
		<?php } ?>		
				
	</div>

</div>