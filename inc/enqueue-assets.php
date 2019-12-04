<?php

function btemp_enqueue_admin_scripts() {
	wp_enqueue_script(
		'btemp-admin-scripts',
		plugin_dir_url( __FILE__ ) . '../js/admin.js',
		array( 'jquery' )
	);
}
add_action( 'admin_enqueue_scripts', 'btemp_enqueue_admin_scripts', 10 );