<?php

function btemp_enqueue_admin_scripts() {
	wp_enqueue_script(
		'btemp-admin-scripts',
		plugin_dir_url( __FILE__ ) . '../js/admin.js',
		array( 'jquery' )
	);
}
add_action( 'admin_enqueue_scripts', 'btemp_enqueue_admin_scripts', 10 );

function btemp_register_themes() {
	wp_register_style( 'theme-01', plugin_dir_url( __DIR__ ) . 'assets/css/theme-01.css', array(), false );
	wp_register_style( 'theme-02', plugin_dir_url( __DIR__ ) . 'assets/css/theme-02.css', array(), false );
}
add_action( 'wp_enqueue_scripts', 'btemp_register_themes', 10 );

function btemp_enqueue_theme() {
	global $post;
	$selected_stylesheet = get_post_meta( $post->ID, '_btemp_post_theme', true );

	if ( ! empty( $selected_stylesheet ) ) {
		wp_enqueue_style( $selected_stylesheet );
	}
}
add_action( 'wp_enqueue_scripts', 'btemp_enqueue_theme', 11 );
