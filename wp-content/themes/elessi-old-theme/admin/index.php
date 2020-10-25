<?php

/*
 * Required Plugins use in theme
 * 
 * In Admin
 */
require_once ELESSI_THEME_PATH . '/admin/classes/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'elessi_register_required_plugins');
function elessi_register_required_plugins() {
    $plugins = array(
        array(
            'name' => esc_html__('WooCommerce', 'elessi-theme'),
            'slug' => 'woocommerce',
            'required' => true
        ),
        
        array(
            'name' => esc_html__('Nasa Core', 'elessi-theme'),
            'slug' => 'nasa-core',
            'source' => ELESSI_THEME_PATH . '/admin/plugins/nasa-core_v3.9.0.zip',
            'required' => true,
            'version' => '3.9.0'
        ),
        
        array(
            'name' => esc_html__('WPBakery Page Builder', 'elessi-theme'),
            'slug' => 'js_composer',
            'source' => ELESSI_THEME_PATH . '/admin/plugins/js_composer.zip',
            'required' => true,
            'version' => '6.4.1'
        ),
        
        array(
            'name' => esc_html__('YITH WooCommerce Compare', 'elessi-theme'),
            'slug' => 'yith-woocommerce-compare',
            'required' => false
        ),
        
        array(
            'name' => esc_html__('Contact Form 7', 'elessi-theme'),
            'slug' => 'contact-form-7',
            'required' => false
        ),
        
        array(
            'name' => esc_html__('Smash Balloon Instagram Feed', 'elessi-theme'),
            'slug' => 'instagram-feed',
            'required' => false
        ),
        
        array(
            'name' => esc_html__('Revolution Slider', 'elessi-theme'),
            'slug' => 'revslider',
            'source' => ELESSI_THEME_PATH . '/admin/plugins/revslider.zip',
            'required' => false,
            'version' => '6.2.23'
        )
    );

    $config = array(
        'domain' => 'elessi-theme', // Text domain - likely want to be the same as your theme.
        'default_path' => '', // Default absolute path to pre-packaged plugins
        'parent_slug' => 'themes.php', // Default parent menu slug
        'menu' => 'install-required-plugins', // Menu slug
        'has_notices' => true, // Show admin notices or not
        'is_automatic' => false, // Automatically activate plugins after installation or not
        'message' => '', // Message to output right before the plugins table
    );

    tgmpa($plugins, $config);
}

/*
 * Title	: SMOF
 * Description	: Slightly Modified Options Framework
 * Version	: 1.5.2
 * Author	: Syamil MJ
 * Author URI	: http://aquagraphite.com
 * License	: GPLv3 - http://www.gnu.org/copyleft/gpl.html

 * define( 'SMOF_VERSION', '1.5.2' );
 * Definitions
 *
 * @since 1.4.0
 */
$smof_output = '';

if (function_exists('wp_get_theme')) {
    if (is_child_theme()) {
        $temp_obj = wp_get_theme();
        $theme_obj = wp_get_theme($temp_obj->get('Template'));
    } else {
        $theme_obj = wp_get_theme();
    }

    $theme_name = $theme_obj->get('Name');
} else {
    $theme_data = wp_get_theme(ELESSI_THEME_PATH . '/style.css');
    $theme_name = $theme_data['Name'];
}

if (!defined('ELESSI_ADMIN_PATH')) {
    define('ELESSI_ADMIN_PATH', ELESSI_THEME_PATH . '/admin/');
}

if (!defined('ELESSI_ADMIN_DIR_URI')) {
    define('ELESSI_ADMIN_DIR_URI', ELESSI_THEME_URI . '/admin/');
}

define('ELESSI_ADMIN_THEMENAME', $theme_name);
define('ELESSI_ADMIN_SUPPORT_FORUMS', 'https://elessi.nasatheme.com/documentation/');

define('ELESSI_ADMIN_BACKUPS', 'backups');

/**
 * Functions Load
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */
require_once ELESSI_THEME_PATH . '/admin/dynamic-style.php';
require_once ELESSI_THEME_PATH . '/admin/functions/functions.interface.php';
require_once ELESSI_THEME_PATH . '/admin/functions/functions.options.php';
require_once ELESSI_THEME_PATH . '/admin/functions/functions.admin.php';

add_action('admin_head', 'optionsframework_admin_message');
add_action('admin_init', 'optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');

/**
 * Required Files
 *
 * @since 1.0.0
 */
require_once ELESSI_THEME_PATH . '/admin/classes/class.options_machine.php';

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');

/**
 * Add editor style
 */
add_editor_style();