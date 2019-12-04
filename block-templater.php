<?php
/**
 * Block Templater
 * 
 * Make templates with the Gutenberg Editor
 * 
 * @since       1.0.0
 * @package     BlockTemplater
 * 
 * @wordpress-plugin
 * Plugin Name:       Block Templater
 * Plugin URI:        https://natehub.net
 * Description:       Make templates with the Gutenberg Editor
 * Version:           1.0.0
 * Author:            Nathan Blair
 * Author URI:        https://natehub.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       block-templater
 * Domain Path:       /languages
**/
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require plugin_dir_path( __FILE__ ) . 'inc/enqueue-assets.php';
require plugin_dir_path( __FILE__ ) . 'inc/class-options-page.php';
require plugin_dir_path( __FILE__ ) . 'inc/template-metabox.php';
require plugin_dir_path( __FILE__ ) . 'inc/stylesheet-metabox.php';
require plugin_dir_path( __FILE__ ) . 'inc/default-content.php';
