<?php

class Tw_Feature_Location_Meta_Handler {

	const SUPPORTS = 'feature-location';

	const NONCE_NAME = 'feature-location-nonce';
	const NONCE_VALUE = 'feature-location-nonce-action';

	static $positions = array(
		'' => 'None',
		'feature-main' => 'Main block',
		'feature-left' => 'Left Box',
		'feature-center' => 'Center Box',
		'feature-right' => 'Right Box',
	);

	public function initialize() {
		global $_wp_post_type_features;

		add_action ('add_meta_boxes', array(&$this, 'add_metabox'), 10, 2);
		add_action ('save_post', array(&$this, 'update'));

		$supported_object_types = array();
		foreach ($_wp_post_type_features as $post_type => $features) {
			if(in_array(self::SUPPORTS, $features)) {
				$supported_object_types[] = $post_type;
			}
		}

		register_taxonomy(self::SUPPORTS, $supported_object_types,  array(
			'label' => __('Feature Locations'),
			'singular_label' => __('Feature Location'),
			'hierarchical' => true,
			'query_var' => 'feature_location',
			'rewrite' => false,
			'public' => false,
			'show_ui' => null,
			'show_in_nav_menus' => false,
		));
	}

	function add_metabox($post_type, $post) {
		if (post_type_supports($post_type, self::SUPPORTS)) {
			add_meta_box(self::SUPPORTS, 'Feature Position', array(&$this, 'metabox'), $post_type, 'side');
		}
	}

	function metabox($post) {
		$selected_position = get_post_meta($post->ID, self::SUPPORTS, true);
	?>
		<ul>
			<?php foreach (self::$positions as $key => $name): ?>
				<li>
					<label class="selectit" for="featurelocation-<?php echo esc_attr($key); ?>">
						<input id="featurelocation-<?php echo esc_attr($key); ?>" type="radio" name="<?php echo self::SUPPORTS; ?>" value="<?php echo esc_attr($key) ?>" <?php checked($selected_position, $key)?> />
						<?php echo esc_html($name) ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php
		wp_nonce_field(self::NONCE_VALUE, self::NONCE_NAME);
	}

	public function update($post_id) {
		if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) return $post_id;

		if (!isset($_REQUEST[self::NONCE_NAME]) || !wp_verify_nonce($_REQUEST[self::NONCE_NAME], self::NONCE_VALUE)) return;

		$feature_location = !empty($_REQUEST[self::SUPPORTS]) ? strip_tags($_REQUEST[self::SUPPORTS]) : '';

		if (!empty($feature_location) && array_key_exists($feature_location, self::$positions)) {
			update_post_meta($post_id, self::SUPPORTS, $feature_location);
		} else {
			delete_post_meta($post_id, self::SUPPORTS);
		}
	}
}

add_action('init', array(new Tw_Feature_Location_Meta_Handler(), 'initialize'));
