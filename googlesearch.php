<?php
/*
Template Name: Google Search
*/
?>

<?php get_header(); ?>

			<div id="content">

<!--			<?php get_sidebar(); ?>-->
				
				<div id="primary-widget-area">
				
				<div class="content">
				
				<?php while ( have_posts() ) : the_post(); ?>
				
					<div id="cse" style="width: 100%;">Loading</div>
					<script src="http://www.google.com/jsapi" type="text/javascript"></script>
					<script type="text/javascript"> 
					  google.load('search', '1', {language : 'en'});
					  google.setOnLoadCallback(function() {
					    var customSearchOptions = {};  var customSearchControl = new google.search.CustomSearchControl(
					      '012338320268122811719:yru3b4yww-k', customSearchOptions);
					    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
						customSearchControl.setLinkTarget(google.search.Search.LINK_TARGET_SELF);
					    customSearchControl.draw('cse');
					  }, true);
					</script>
					<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />

				<?php endwhile ?>
		
				</div>

			</div>

<?php get_footer(); ?>