<?php if (isset($_REQUEST['q'])) : ?>
	<?php
		$google_api_key = '012338320268122811719:p1upxvdzunm';
	?>
	<div id="cse" style="width: 100%;">Loading</div>
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
	<script type="text/javascript">
	//<![CDATA[
		google.load('search', '1', {language : 'en'});
		google.setOnLoadCallback(function() {
			var customSearchControl = new google.search.CustomSearchControl('<?php echo esc_attr($google_api_key); ?>');
			customSearchControl.setResultSetSize(google.search.Search.LARGE_RESULTSET);
			customSearchControl.draw('cse');
			customSearchControl.execute('<?php echo esc_js($_REQUEST['q']); ?>');
		}, true);
	//]]>
	</script>
<?php endif; ?>