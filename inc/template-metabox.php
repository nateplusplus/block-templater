<?php

function btemp_add_template_box() {
	$screens = [ 'post' ];
	foreach ($screens as $screen) {
		add_meta_box(
			'btemp_box_id',            // Unique ID
			'Select a Post Template',  // Box title
			'btemp_template_box_html', // Content callback, must be of type callable
			$screen,                   // Post type
			'side',                    // Context
			'high'                     // Priority
		);
	}
}
add_action('add_meta_boxes', 'btemp_add_template_box');

function btemp_template_box_html($post) {
	$templates = get_posts( array(
		'numberposts' => -1,
		'orderby'     => 'title',
		'order'       => 'ASC',
		'post_type'   => 'templates'
	) );
	?>
	<select name="btemp_select_template" id="btemp_select_template" class="postbox">
		<option value="">Click to select...</option>
		<?php foreach ( $templates as $template ): ?>
			<option value="<?php echo $template->ID ?>"><?php echo $template->post_title; ?></option>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Return all data for 
 * 
**/
function btemp_get_template_by_id( $request ) {

	$args = array(
		'orderby'     => 'title',
		'order'       => 'ASC',
		'post_type'   => 'templates'
	);

	if ( ! empty( $request['id'] ) ) {
		$args['include'] = $request['id'];
	}

	$templates = get_posts( $args );
	if ( empty( $templates ) ) {
		return new WP_Error( 'empty_category', 'there is no post in this category', array('status' => 404) );
	}

	$response = new WP_REST_Response( $templates );
	$response->set_status(200);

	return $response;
}


function btemp_register_rest_route() {
	register_rest_route( 'block-templater/v1', 'templates/(?P<id>\d+)',array(
		'methods'  => 'GET',
		'callback' => 'btemp_get_template_by_id'
	));
}
add_action( 'rest_api_init', 'btemp_register_rest_route' );
