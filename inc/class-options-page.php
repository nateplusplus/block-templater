<?php
class BlockTemplaterOptionsPage
{
	/**
	 * Start up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_block_templater_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}
	/**
	 * Add options page
	 */
	public function add_block_templater_plugin_page() {
		// This page will be under "Settings"
		add_options_page(
			'Settings Admin', 
			'Block Templater', 
			'manage_options', 
			'btemp-settings', 
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'default_templates', // Option group
			'post_type_default_template', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'Select default template for each post type', // Title
			array( $this, 'print_section_info' ), // Callback
			'block-templater-admin' // Page
		);

		foreach ( $this->get_editor_post_types() as $post_type ) {
			add_settings_field(
				'default_template_' . $post_type->name, // ID
				$post_type->label, // Title 
				array( $this, 'post_type_template_callback' ), // Callback
				'block-templater-admin', // Page
				'setting_section_id', // Section
				array(
					'post_type_name' => $post_type->name
				)
			);
		}
	}

	/**
	 * Get post types used by editors
	 * Ignore hidden post types like attachments or templates
	 * 
	 * @return array
	**/
	public function get_editor_post_types() {
		$post_types = get_post_types(
			array( 'public' => true, 'show_ui' => true ),
			'objects'
		);
		$post_types_to_exclude = array( 'attachment', 'templates' );
		foreach ( $post_types as $key => $post_type ) {
			if ( in_array( $post_type->name, $post_types_to_exclude ) ) {
				unset( $post_types[ $key ] );
			}
		}
		return $post_types;
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		$this->options = get_option( 'post_type_default_template' );
		?>
		<h1>Block Templater Settings</h1>
		<form method="post" action="options.php">
		<?php
			// This prints out all hidden setting fields
			settings_fields( 'default_templates' );
			do_settings_sections( 'block-templater-admin' );
			submit_button();
		?>
		</form>
		<?php
	}
	
	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		foreach( $this->get_editor_post_types() as $post_type ) {
			if( isset( $input[ $post_type->name ][ 'template_id' ] ) ) {
				$new_input[ $post_type->name ][ 'template_id' ] = absint( $input[ $post_type->name ][ 'template_id' ] );
			}
		}

		return $new_input;
	}

	/** 
	 * Print the Section text
	 */
	public function print_section_info() {
		// print 'Enter your settings below:';
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function post_type_template_callback( $args ) {
		$templates = get_posts( array(
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
			'post_type'   => 'templates'
		) );

		$post_type_name = $args[ 'post_type_name' ];
		$selected_template_id = '';
		if ( isset( $this->options[ $post_type_name ][ 'template_id' ] ) ) {
			$selected_template_id = esc_attr( $this->options[ $post_type_name ][ 'template_id' ] );
		}

		printf(
			'<select id="template_id" name="post_type_default_template[%s][template_id]" />',
			$post_type_name
		);
		echo '<option value="">No default template</option>';
		if ( !empty( $templates ) ) {
			foreach ( $templates as $template ) {
				printf(
					'<option ' . selected( $selected_template_id, $template->ID ) . ' value="%s">%s</option>',
					$template->ID,
					$template->post_title
				);
			}
		}
		echo '</select>';
	}
}

if ( is_admin() ) {
	$my_settings_page = new BlockTemplaterOptionsPage();
}