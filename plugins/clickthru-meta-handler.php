<?php

class Tw_Clickthru_Meta_Handler {
	const SUPPORTS = 'clickthru-url';

	const NONCE_NAME = 'clickthru-url-nonce';
	const NONCE_VALUE = 'clickthru-url-nonce-action';

	function initialize() {
		add_action('add_meta_boxes', array(&$this, 'add_metabox'), 10, 2);
		add_action('save_post', array(&$this, 'update'));
	}

	function add_metabox($post_type, $post) {
		if (post_type_supports($post_type, self::SUPPORTS)) {
			add_meta_box(self::SUPPORTS, 'ClickThru URL', array(&$this, 'metabox'), $post_type);
		}
	}

	function metabox($post) {
		$clickthru_url_options = get_post_meta($post->ID, self::SUPPORTS, true);

		if (!empty($clickthru_url_options)) {
			extract($clickthru_url_options);
		}

		if (empty($url)) {
			$url = 'http://';
		}
		?>
			<label for="clickthru_url">URL:</label>
			<input type="text" style="width: 70%;" value="<?php echo esc_url($url);?>" name="clickthru_url" id="clickthru_url" />
			<br />
			<label for="enable_new_window">Open in New Window:</label>
			<input type="checkbox" name="enable_new_window" id="enable_new_window" value="1" <?php checked($is_new, true) ?> />
		<?php
		wp_nonce_field(self::NONCE_VALUE, self::NONCE_NAME);
	}

	function update($post_id) {
		if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
			return $post_id;
		}

		//quit if nonce is not set
		if (!isset($_REQUEST[self::NONCE_NAME]) || !wp_verify_nonce($_REQUEST[self::NONCE_NAME], self::NONCE_VALUE)) return;

		$clickthru_url_options = array();

		if (!empty($_REQUEST['clickthru_url']) || tw_is_valid_url($_REQUEST['clickthru_url'])) {
			$clickthru_url_options['url'] = strip_tags($_REQUEST['clickthru_url']);
		}
		if (!empty($_REQUEST['enable_new_window'])) {
			$clickthru_url_options['is_new'] = true;
		}

		if (empty($clickthru_url_options)) {
			delete_post_meta($post_id, self::SUPPORTS);
		} else {
			update_post_meta($post_id, self::SUPPORTS, $clickthru_url_options);
		}
	}
}

add_action('init', array(new Tw_Clickthru_Meta_Handler, 'initialize'));