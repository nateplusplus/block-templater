<?php
/**
 * Metabox functions for selecting a post stylesheet.
 * 
 * @package block-templater
 */


 /**
 * Register a metbox for each specified screen.
 *
 * @return void
 * @package block-templater
 */
function btemp_add_stylesheet_box() {
	$screens = [ 'post' ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'btemp_stylesheet',          // Unique ID
			'Select a Theme',            // Box title
			'btemp_stylesheet_box_html', // Content callback, must be of type callable
			$screen,                     // Post type
			'side' ,                     // Context
			'high'                       // Priority
		);
	}
}
add_action('add_meta_boxes', 'btemp_add_stylesheet_box');

/**
 * HTML dropdown select for stylesheet metabox.
 *
 * @param object $post    The current post object.
 * @return void
 * @package block-templater
 */
function btemp_stylesheet_box_html( $post ) {
	$stylesheets = array(
		'theme-01' => 'Red Theme',
		'theme-02' => 'Blue Theme',
	);

	$selected_stylesheet = get_post_meta( $post->ID, 'btemp_post_theme', true );

	?>
	<select name="btemp_post_theme" id="btemp_post_theme" class="postbox">
		<option value="">Click to select...</option>
		<?php foreach ( $stylesheets as $stylesheet_slug => $stylesheet_name ): ?>
			<?php
			printf(
				'<option %s value="%s">%s</option>',
				selected( $selected_stylesheet, $stylesheet_slug, false ),
				$stylesheet_slug,
				$stylesheet_name
			);
			?>
		<?php endforeach; ?>
	</select>
	<?php
}

/**
 * Save postmeta if theme selected.
 *
 * @param integer $post_id    The ID of the current post.
 * @return void
 * @package block-templater
 */
function btemp_stylesheet_save_postdata( $post_id )
{
    if (array_key_exists('btemp_post_theme', $_POST)) {
        update_post_meta(
            $post_id,
            '_btemp_post_theme',
            $_POST['btemp_post_theme']
        );
    }
}
add_action('save_post', 'btemp_stylesheet_save_postdata');
