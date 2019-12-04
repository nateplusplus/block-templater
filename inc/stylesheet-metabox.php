<?php

function btemp_add_stylesheet_box() {
	$screens = [ 'post' ];
	foreach ($screens as $screen) {
		add_meta_box(
			'btemp_stylesheet',
			'Select a Theme',
			'btemp_stylesheet_box_html',
			$screen,
			'side'
		);
	}
}
add_action('add_meta_boxes', 'btemp_add_stylesheet_box');

function btemp_stylesheet_box_html($post) {
	$stylesheet = get_post_meta($post->ID, '_btemp_template', true);
	?>
	<!-- <label for="btemp_field">Select a Post Template</label> -->
	<select name="btemp_select_stylesheet" id="btemp_select_stylesheet" class="postbox">
		<option value="">Click to select...</option>
		<option value="style-1" <?php selected($stylesheet, 'style-1'); ?>>Stylesheet 1</option>
		<option value="style-2" <?php selected($stylesheet, 'style-2'); ?>>Stylesheet 2</option>
	</select>
	<?php
}

// function btemp_save_postdata($post_id)
// {
//     if (array_key_exists('btemp_field', $_POST)) {
//         update_post_meta(
//             $post_id,
//             '_btemp_meta_key',
//             $_POST['btemp_field']
//         );
//     }
// }
// add_action('save_post', 'btemp_save_postdata');
