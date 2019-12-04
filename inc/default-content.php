<?php
/**
 * This filter is run when a new post is created
 * If the user has paired a Template post to be used as default content for this post type
 * this filter will get that content and inject it into the new post for editing.
 * 
 * @param string $post_content
 * @param object $post
 * 
 * @return string
**/
function load_post_with_default_content( $post_content, $post ) {
    $post_type_default_template = get_option( 'post_type_default_template' );
    if ( ! empty( $post_type_default_template ) && ! empty( $post_type_default_template[ $post->post_type ]['template_id'] ) ) {
        // get the content from the template
        $template_post = get_post( $post_type_default_template[ $post->post_type ]['template_id'] );
        // insert as default content into new post
        $post_content = $template_post->post_content;
    }
    return $post_content;
}
add_filter( 'default_content', 'load_post_with_default_content', 10, 2 );
