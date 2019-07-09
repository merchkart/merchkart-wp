<?php
if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and other settings for Merlin WP.
 */
$wizard = new Merlin(
	// Configure Merlin with custom settings.
	$config = array(
		'directory'            => 'inc/merlin', // Location where the 'merlin' directory is placed.
		'merlin_url'           => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => true, // Enable development mode for testing.
		'license_step'         => false, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => '', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => '', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => '', // EDD_Theme_Updater_Admin item_slug.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup', 'teepro' ),
		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'teepro' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'teepro' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'teepro' ),
		'btn-skip'                 => esc_html__( 'Skip', 'teepro' ),
		'btn-next'                 => esc_html__( 'Next', 'teepro' ),
		'btn-start'                => esc_html__( 'Start', 'teepro' ),
		'btn-no'                   => esc_html__( 'Cancel', 'teepro' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'teepro' ),
		'btn-child-install'        => esc_html__( 'Install', 'teepro' ),
		'btn-content-install'      => esc_html__( 'Install', 'teepro' ),
		'btn-import'               => esc_html__( 'Import', 'teepro' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'teepro' ),
		'btn-license-skip'         => esc_html__( 'Later', 'teepro' ),
		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'teepro' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'teepro' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'teepro' ),
		'license-label'            => esc_html__( 'License key', 'teepro' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'teepro' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'teepro' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'teepro' ),
		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'teepro' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'teepro' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'teepro' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'teepro' ),
		'child-header'             => esc_html__( 'Install Child Theme', 'teepro' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'teepro' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'teepro' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'teepro' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'teepro' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'teepro' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'teepro' ),
		'plugins-header'           => esc_html__( 'Install Plugins', 'teepro' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'teepro' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'teepro' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'teepro' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'teepro' ),
		'import-header'            => esc_html__( 'Import Content', 'teepro' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'teepro' ),
		'import-action-link'       => esc_html__( 'Advanced', 'teepro' ),
		'ready-header'             => esc_html__( 'All done. Have fun!', 'teepro' ),
		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'teepro' ),
		'ready-action-link'        => esc_html__( 'Extras', 'teepro' ),
		'ready-big-button'         => esc_html__( 'View your website', 'teepro' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'teepro' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'http://cmsmart.net', esc_html__( 'Get Theme Support', 'teepro' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'teepro' ) ),
	)
);

function teepro_local_import_files() {

	ini_set('max_execution_time', 300);

	return array(
		array( 
			'import_file_name'             		=> 'Teepro Shop',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-1/pillots-home-tshirt.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-1/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home',
			'title_home_page'                  	=> 'Home 1',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),

			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
		array( 
			'import_file_name'             		=> 'Beautiful Printing',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-2/home2.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-2/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home/home-2/',
			'title_home_page'                  	=> 'Home 2',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),

			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
		array( 
			'import_file_name'             		=> 'Printing Corporate',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-3/home3.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-3/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home/home-3',
			'title_home_page'                  	=> 'Home 3',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),

			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
		array( 
			'import_file_name'             		=> 'Minimal Style',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-4/slider_home4.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-4/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home4',
			'title_home_page'                  	=> 'Home 4',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),
			
			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
		array( 
			'import_file_name'             		=> 'Creative T-shirt',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-5/slider_home5.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-5/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home5',
			'title_home_page'                  	=> 'Home 5',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),

			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
		array( 
			'import_file_name'             		=> 'Exquisite Store',
			'local_import_file'            		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/content.xml',
			'local_import_megamenu_themes'      => array(
				'megamenu_themes' 				=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/megamenu_themes.txt',
				'megamenu_settings' 			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/megamenu_settings.txt',
			),
			'local_import_solutions_core'       => trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/solutions_core_settings.txt',
			'local_import_widget_file'     		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/widgets.wie',
			'local_import_customizer_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/customizer.dat',
			'local_import_rev_slider_file' 		=> trailingslashit( get_template_directory() ) . 'inc/demo-data/home-6/slider_home6.zip',
			'import_preview_image_url'     		=> trailingslashit( get_template_directory_uri() ) . 'inc/demo-data/home-6/screenshot.jpg',
			'import_notice'                		=> esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'teepro' ),
			'preview_url'                  		=> 'http://demo9.cmsmart.net/teepro_tf/home6',
			'title_home_page'                  	=> 'Home 6',

			'local_import_font_icon' 			=> array(
				'font_icon_file'				=> array(
					'teepro-svg-icon'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/teepro-svg-icon.zip'
				),
				'font_icon_settings'			=> trailingslashit( get_template_directory() ) . 'inc/demo-data/font_icon_settings.txt',
			),

			'term_meta_key'                     => '',
			'nbdesigner' 						=> 'yes',
		),
	);
}
add_filter( 'merlin_import_files', 'teepro_local_import_files' );


/**
 * Execute custom code after the whole import has finished.
 */
function teepro_merlin_after_import_setup( $selected_import_index ) {

	// $wizard->logger->debug('aaaaaaaaaaaa');

	$total_import_array = teepro_local_import_files();
	$current_import_array = $total_import_array[$selected_import_index];

	update_hello_world_post();

	// Assign menus to their locations.
	update_menu_locations();

	// Assign front page
	update_front_page($current_import_array);

	// Update megamenu options
	if( !empty( $current_import_array['local_import_megamenu_themes'] )) {
		update_megamenu_options($current_import_array);
	}

	// Update megamenu metadata
	if( class_exists( 'Mega_Menu' ) ) {
		update_megamenu_metadata();
	}

	// Update solution core settings 
	if( !empty( $current_import_array['local_import_solutions_core'] )) {
		update_solution_core_options($current_import_array['local_import_solutions_core']);
	}

	update_page_options();

	update_default_woocommerce_options();

	//update price matrix and color swatch post

	if( !empty( $current_import_array['local_import_font_icon'] ) ) {
		setup_font_icon( $current_import_array['local_import_font_icon'] );
	}

	update_special_post();

}
add_action( 'merlin_after_all_import', 'teepro_merlin_after_import_setup' );


/**
 * Get data from a file with WP_Filesystem
 *
 * @param $file
 *
 * @return bool
 */
function teepro_get_file_contents( $file ) {
	WP_Filesystem();
	global $wp_filesystem;
	return $wp_filesystem->get_contents( $file );
}

function update_hello_world_post() {

	$hello_world = get_page_by_title( 'Hello World!', OBJECT, 'post' );
	
	if ( ! empty( $hello_world ) ) {
		$hello_world->post_status = 'draft';
		wp_update_post( $hello_world );

		echo 'Update Hello World post successful <br/>';
	}
}

function update_menu_locations() {

	$menu_settings = array(
		'primary' 		=> 'main menu',
		'header-sub' 	=> 'menu-top-left',
	);

	$menu_location_array 	= array();

	foreach($menu_settings as $menu_location => $menu_name) {
		
		$current_menu = get_term_by( 'name', $menu_name, 'nav_menu' );
		$menu_location_array[$menu_location] = $current_menu->term_id;

	}
	set_theme_mod( 'nav_menu_locations', $menu_location_array);

	echo 'Assign menus successful <br/>';
}

function update_front_page($options = array()) {

	$front_page_id = get_page_by_title( $options['title_home_page'] );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );

	echo 'Assign front page successful <br/>';
}

function update_megamenu_options($options = array()) {

	global $wpdb;
			
		$megamenu_options = $options['local_import_megamenu_themes'];

		//update megamenu_themes option
		$megamenu_themes = teepro_get_file_contents($megamenu_options['megamenu_themes']);
		
		$affected_row = $wpdb->replace($wpdb->prefix.'options', 
			array( 
				'option_name' => 'megamenu_themes',
				'option_value' => $megamenu_themes, 
				'autoload' => 'yes'
			), 
			array( 
				'%s',
				'%s',
				'%s' 
			) 
		);

		//update megamenu_settings option
		$megamenu_settings = teepro_get_file_contents($megamenu_options['megamenu_settings']);

		$affected_row = $wpdb->replace($wpdb->prefix.'options', 
			array( 
				'option_name' => 'megamenu_settings',
				'option_value' => $megamenu_settings, 
				'autoload' => 'yes'
			), 
			array( 
				'%s',
				'%s', 
				'%s' 
			) 
		);

		do_action( "megamenu_after_save_settings" );
		do_action( "megamenu_delete_cache" );

		echo 'Update megamenu options successful <br/>';
}

function update_megamenu_metadata(){

	$sidebar_widgets    = get_option( 'sidebars_widgets' );

	if( isset( $sidebar_widgets[ 'mega-menu' ] ) ) {

		$mm_sidebar_widgets = $sidebar_widgets[ 'mega-menu' ];


		$mm_imported_widgets  	= get_imported_megamenu_data( $mm_sidebar_widgets );
		$new_mm_widget_id       = rebuild_mmm_widget_id( $mm_sidebar_widgets , $mm_imported_widgets );

		//update megamenu grid type post meta
		update_megamenu_grid_type_post_meta( $new_mm_widget_id );
	}

	echo 'Update megamenu metadata successful <br/>';
}

/**
 * Get all imported megamenu data
 * @param  array $mm_imported_widgets
 */
function get_imported_megamenu_data( $mm_sidebar_widgets ) {

	global $wpdb;

	$mm_imported_widgets = array();

	$megamenu_meta = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_megamenu'" );

	foreach ( $megamenu_meta as $meta ) {

		$meta_value = unserialize( $meta->meta_value );

		if( isset( $meta_value['type'] ) && $meta_value['type'] == 'grid' ) {

			foreach( $meta_value['grid'] as $i => $grids ) {                

				foreach( $grids['columns'] as $j => $column ) {

					foreach ( $column[ 'items' ] as $k => $item ) {                         

						// $meta_value['grid'][$i]['columns'][$j]['items'][$k]['id'] = $new_widget_id;

						$mm_imported_widgets[] = $item[ 'id' ];
					}
				}
			}
		}
	}

	return $mm_imported_widgets;
}

/**
 * Rebuild max megamenu metadata after imported
 * @param  [array] $mm_sidebar_widgets     
 * @param  [array] $mm_imported_widgets 
 * @return [array]                        
 */
function rebuild_mmm_widget_id( $mm_sidebar_widgets, $mm_imported_widgets) {

	$mm_sidebar_widgets_by_key      = array();
	$mm_imported_widgets_by_key    = array();
	$rebuild_array                  = array();

	foreach($mm_sidebar_widgets as $value) {
		$exploded_widgets = explode('-', $value);
		$mm_sidebar_widgets_by_key[$exploded_widgets[0]][] = $exploded_widgets[1];
	}

	foreach($mm_imported_widgets as $value) {
		$exploded_widgets = explode('-', $value);
		$mm_imported_widgets_by_key[$exploded_widgets[0]][] = $exploded_widgets[1];
	}

	foreach($mm_sidebar_widgets_by_key as $key => $a) {
		rsort($a);
		$mm_sidebar_widgets_by_key[$key] = $a;
	}

	foreach($mm_imported_widgets_by_key as $key => $a) {
		rsort($a);
		$mm_imported_widgets_by_key[$key] = $a;
	}

	foreach ($mm_imported_widgets_by_key as $key => $values) {

		foreach($values as $index => $value ) {
			$widget_key = $key . '-' . $value;
			$new_value = $key . '-' . $mm_sidebar_widgets_by_key[$key][$index];
			$rebuild_array[$widget_key] = $new_value;        
		}
	}

	return $rebuild_array;
}

/**
 * Update incorrect wiget name in megamenu post metadata
 */
function update_megamenu_grid_type_post_meta( $new_mm_widget_id ) {

	global $wpdb;

	$megamenu_meta = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_megamenu'" );

	foreach ( $megamenu_meta as $meta ) {

		$meta_value = unserialize( $meta->meta_value );

		if( isset( $meta_value['type'] ) && $meta_value['type'] == 'grid' ) {

			foreach( $meta_value['grid'] as $i => $grids ) {                

				foreach( $grids['columns'] as $j => $column ) {

					foreach ( $column[ 'items' ] as $k => $item ) {                         

						$meta_value['grid'][$i]['columns'][$j]['items'][$k]['id'] = isset($new_mm_widget_id[ $item[ 'id' ] ]) ? $new_mm_widget_id[ $item[ 'id' ] ] : $item[ 'id' ];
					}
				}
			}

			// update grid post meta data
			update_post_meta( $meta->post_id, '_megamenu', $meta_value);
		}
	}
}

function update_solution_core_options( $solution_core_file ) {

	global $wpdb;

	$solution_settings = json_decode(teepro_get_file_contents($solution_core_file), true);

	if(isset($solution_settings['enable'])) {

		$affected_row = $wpdb->replace($wpdb->prefix.'options', 
			array( 
				'option_name' 	=> 'solutions_core_settings',
				'option_value' 	=> maybe_serialize($solution_settings['enable']), 
				'autoload' 		=> 'yes'
			), 
			array( 
				'%s',
				'%s', 
				'%s' 
			)
		);
	}

	if(isset($solution_settings['settings'])) {

		foreach($solution_settings['settings'] as $module_name => $module_setting) {

		$affected_row = $wpdb->replace($wpdb->prefix.'options', 
				array( 
					'option_name' 	=> $module_name. '_settings',
					'option_value' 	=> maybe_serialize($module_setting), 
					'autoload' 		=> 'yes'
				), 
				array( 
					'%s',
					'%s', 
					'%s' 
				)
			);
		}
	}

	echo 'Update Solution Core successful <br/>';
}

function update_page_options() {

	global $wpdb;

	$arr_page_setup = array(
		'woocommerce_cart_page_id' 		=> 'Cart', 
		'woocommerce_checkout_page_id' 	=> 'Checkout', 
		'woocommerce_myaccount_page_id' => 'My account', 
		'woocommerce_terms_page_id' 	=> 'Terms of Service', 
		'woocommerce_shop_page_id' 		=> 'Shop', 
		'yith_wcwl_wishlist_page_id' 	=> 'Wishlist'
	);

	foreach ($arr_page_setup as $key => $value) {
		$page = get_page_by_title(trim($value));
		if($page) {
			$kq = $wpdb->replace($wpdb->prefix.'options', 
				array( 
					'option_name' => $key,
					'option_value' => $page->ID, 
					'autoload' => 'yes'
				), 
				array( 
					'%s',
					'%s', 
					'%s' 
				) 
			);
		}
	}

	echo 'Update Page Options successful <br/>';
}

function update_default_woocommerce_options() {
	
	global $wpdb;
	$arr_setting_default = array(
		"permalink_structure" => "/%postname%/",
		"woocommerce_currency" => "USD",
	);
	foreach ($arr_setting_default as $key => $value) {
		$kq2 = $wpdb->replace($wpdb->prefix.'options', 
			array( 
				'option_name' => $key,
				'option_value' => $value, 
				'autoload' => 'yes'
			), 
			array( 
				'%s',
				'%s', 
				'%s' 
			) 
		);
	}

	echo 'Update Default Woocommerce Options successful <br/>';
}

//update price matrix and color swatch post
function update_special_post() {

	$price_matrix_post_slug 	= 'kid-t-shirt-nb10';
	$color_swatches_post_slug 	= 't-shirt-white-h8';

	create_all_variation($price_matrix_post_slug);
	create_all_variation($color_swatches_post_slug, 'cs');

	echo 'Update price matrix and color swatch posts successful <br/>';
}

function create_all_variation($slug = '', $type = 'pm') {

	if($slug!='') {

		$post_id = get_page_by_path( $slug, OBJECT, 'product' )->ID;
		$post_id = intval( $post_id );
		
		if ( $post_id ) {
			
			$product    = wc_get_product( $post_id );
			$attributes = wc_list_pluck( array_filter( $product->get_attributes(), 'wc_attributes_array_filter_variation' ), 'get_slugs' );

			if ( ! empty( $attributes ) ) {

				$existing_variations = array_map( 'wc_get_product', $product->get_children() );
				$existing_attributes = array();

				foreach ( $existing_variations as $existing_variation ) {
					$existing_attributes[] = $existing_variation->get_attributes();
				}

				$added               = 0;
				$possible_attributes = array_reverse( wc_array_cartesian( $attributes ) );

				foreach ( $possible_attributes as $possible_attribute ) {

					if ( in_array( $possible_attribute, $existing_attributes ) ) {
						continue;
					}

					$variation = new WC_Product_Variation();
					$variation->set_parent_id( $post_id );
					$variation->set_attributes( $possible_attribute );
					$price = random_int(1, 100);
					$variation->set_price($price);
					$variation->set_regular_price($price);

					if($type=='cs') {
						$variation->set_stock_quantity(random_int(1, 100));
						$variation->set_stock_status();
					}

					do_action( 'product_variation_linked', $variation->save() );

					if ( ( $added ++ ) > 49 ) {
						break;
					}
				}
			}
			$data_store = $product->get_data_store();
			$data_store->sort_all_product_variations( $product->get_id() );
		}
	}
}

function setup_font_icon( $options = array() ) {
	unzip_teepro_font_package( $options['font_icon_file'] );
	update_smile_fonts_option( $options['font_icon_settings'] );
}

function update_smile_fonts_option( $font_icon_settings ) {

	global $wpdb;

	$affected_row = $wpdb->replace($wpdb->prefix.'options', 
				array( 
					'option_name' => 'smile_fonts',
					'option_value' => teepro_get_file_contents($font_icon_settings),
					'autoload' => 'yes'
				), 
				array( 
					'%s',
					'%s',
					'%s' 
				) 
			);

	echo 'update smile_fonts option ok <br/>';
}

function unzip_teepro_font_package( $font_icon_file = array() ) {
	
	WP_Filesystem();
	$unzipfile ='';
	$destination 		= wp_upload_dir();
	$base_dir			= $destination['basedir'];
	$smile_fonts_path	= $base_dir . '/smile_fonts';

	foreach($font_icon_file as $font_icon){	

		$unzipfile 			= unzip_file( $font_icon, $smile_fonts_path);
		if ( is_wp_error( $unzipfile ) ) {
			echo 'There was an error unzipping the icon file '.$font_icon.' <br/>';
		} 
		else {
			echo 'Successfully unzipped the icon file '.$font_icon.'<br/>';      
		}
	}
}

/**
 * Remove the child theme step.
 * @since   0.1.0
 *
 * @return  $array  The merlin import steps.
 */
add_filter( 'teepro_merlin_steps', function( $steps ) {
	unset( $steps['child'] );
	return $steps;
});