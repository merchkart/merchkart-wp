<?php

define('TEEPRO_VER', '3.2.0');

// define('NBT_CTP', 'netbase-core/templates/');

class Teepro_Core
{
    /**
     * Class prefix for autoload
     *
     * @var string
     */
    protected $prefix = 'Teepro_';

    /**
     * Variable hold the page options
     *
     * @var array
     */
//    protected $page_options = array();

//    protected $tgmpa;

//    protected $theme_mods;

    public function __construct()
    {
        require_once get_template_directory() . '/netbase-core/vendor/tgmpa/class-tgm-plugin-activation.php';

        if(! class_exists('Merlin')) {
            require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
            require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );
            require_once get_parent_theme_file_path( '/netbase-core/import/merlin-config.php' );
        }

        if(class_exists('WeDevs_Dokan')) {

            require get_template_directory() . '/dokan/dokan.php';
        }

        spl_autoload_register(array($this, 'autoload'));

        // if(is_admin()) {
        //     new Teepro_Admin();
        // }
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        new Teepro_Customize();

        Teepro_Helper::include_template_tags();

        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            new Teepro_Extensions_Woocommerce();
        }

        require_once get_template_directory() . '/netbase-core/extensions/extras.php';
        require_once get_template_directory() . '/netbase-core/extensions/size-guide.php';
//        new NBT_Metaboxes();

//        add_action('init', array('Teepro_Helper', 'include_template_tags'));
//        add_action('wp', array('Teepro_Helper', 'get_options'));
        add_action( 'init', array($this, 'register_size_guide'), 1 );
        add_action('after_switch_theme', array($this, 'setup_after_switch_theme'));
        add_action('after_setup_theme', array($this, 'theme_setup'));
        add_action('widgets_init', array($this, 'default_sidebars'));
        add_action('wp_enqueue_scripts', array($this, 'core_scripts_enqueue'), 9998);
        add_action('wp_enqueue_scripts', array($this, 'print_embed_style'), 9999);
        add_action('wp_enqueue_scripts', array($this, 'google_fonts_url'));
        add_action('wp_head', array('Teepro_Helper', 'nbcore_pingback_header'));

        add_filter('body_class', array('Teepro_Helper', 'nbcore_body_classes'));
        add_filter('show_recent_comments_widget_style', '__return_false');
        add_filter('upload_mimes', array($this, 'upload_mimes'));
        add_filter( 'woocommerce_prevent_automatic_wizard_redirect', array($this, 'woo_prevent_automatic_wizard_redirect'));

        add_action('template_redirect', array($this, 'remove_ctp_feed'));

        $content_width = 1170;

        if(empty(get_transient('current_load_css')) && $this->is_plugin_active_byme('nb-fw/nb-fw.php')) {
            set_transient('current_load_css', NBT_LOAD_CUSTOMIZE_FROM_HEAD, NBT_TIMEOUT_TRANSIENT_CUSTOMIZE);
        }

        //Exclude pages from WordPress Search
        if (!is_admin()) {
            function wpb_search_filter($query) {
                if ($query->is_search) {
                    $query->set('post_type', array('product' ));
                }
                return $query;
            }
            add_filter('pre_get_posts','wpb_search_filter');
        }

        // Initialize welcome page.
        // new NBT_Welcome();
    }

    public function autoload($class_name)
    {
        if (0 !== strpos($class_name, $this->prefix)) {
            return false;
        }

        // Generate file path from class name.
        $base = get_template_directory() . '/netbase-core/';
        $path = strtolower(str_replace('_', '/', substr($class_name, strlen($this->prefix))));

        // Check if class file exists.
        $standard = $path . '.php';
        $alternative = $path . '/' . current(array_slice(explode('/', str_replace('\\', '/', $path)), -1)) . '.php';

        while (true) {
            // Check if file exists in standard path.
            if (@is_file($base . $standard)) {
                $exists = $standard;

                break;
            }

            // Check if file exists in alternative path.
            if (@is_file($base . $alternative)) {
                $exists = $alternative;

                break;
            }

            // If there is no more alternative file, quit the loop.
            if (false === strrpos($standard, '/') || 0 === strrpos($standard, '/')) {
                break;
            }

            // Generate more alternative files.
            $standard = preg_replace('#/([^/]+)$#', '-\\1', $standard);
            $alternative = implode('/', array_slice(explode('/', str_replace('\\', '/', $standard)), 0, -1)) . '/' . substr(current(array_slice(explode('/', str_replace('\\', '/', $standard)), -1)), 0, -4) . '/' . current(array_slice(explode('/', str_replace('\\', '/', $standard)), -1));
        }

        // Include class declaration file if exists.
        if (isset($exists)) {
            return include_once $base . $exists;
        }

        return false;
    }

    public function theme_setup()
    {
        new Teepro_Admin();
       
        load_theme_textdomain('teepro', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // A theme must have at least one navbar, right?
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'teepro'),
            'header-sub' => esc_html__('Header sub menu', 'teepro'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         * See https://developer.wordpress.org/themes/functionality/post-formats/
         */
//        add_theme_support('post-formats', array(
//            'aside',
//            'image',
//            'audio',
//            'video',
//            'quote',
//            'link',
//        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        add_image_size('nbcore-masonry', 450, 450, true);
        
        add_theme_support( 'woocommerce' );

        add_theme_support('custom-header');

        add_theme_support('custom-background');

        add_editor_style(get_template_directory_uri() . '/assets/editor-style/editor-style.css');
    }

    public function setup_after_switch_theme() {
        //update revslider-templates-check option to prevent download rev templates
        update_option( 'revslider-templates-check', strtotime(date("Y-m-d H:i:s")), 'yes' );
    }

    // since woo 3.6, need this function to activate plugin below Woo in Merlin Import
    public function woo_prevent_automatic_wizard_redirect() {
        return true;
    }



    /**
     * Theme default sidebar.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function default_sidebars()
    {
        register_sidebar(array(
            'name' => esc_html__('Default Sidebar', 'teepro'),
            'id' => 'default-sidebar',
            'description' => esc_html__('Add widgets here.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Shop Sidebar', 'teepro'),
            'id' => 'shop-sidebar',
            'description' => esc_html__('Add widgets for category page.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s shop-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Page Sidebar', 'teepro'),
            'id' => 'page-sidebar',
            'description' => esc_html__('Add widgets for single page.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s page-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Product Sidebar', 'teepro'),
            'id' => 'product-sidebar',
            'description' => esc_html__('Add widgets for product details page', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Service Sidebar', 'teepro'),
            'id' => 'service-sidebar',
            'description' => esc_html__('Add widgets here.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s service-sidebar">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Currency Switcher', 'teepro'),
            'id' => 'currency-switcher',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Top #1', 'teepro'),
            'id' => 'footer-top-1',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Top #2', 'teepro'),
            'id' => 'footer-top-2',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Top #3', 'teepro'),
            'id' => 'footer-top-3',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Top #4', 'teepro'),
            'id' => 'footer-top-4',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Bottom #1', 'teepro'),
            'id' => 'footer-bot-1',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Bottom #2', 'teepro'),
            'id' => 'footer-bot-2',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Bottom #3', 'teepro'),
            'id' => 'footer-bot-3',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Bottom #4', 'teepro'),
            'id' => 'footer-bot-4',
            'description' => esc_html__('For best display, please assign only one widget in this section.', 'teepro'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    
	// Register Custom Post Type for Size Guide
	public function register_size_guide() {
		
		if ( function_exists( 'teepro_get_options' ) && ! teepro_get_options( 'nbcore_pd_show_size_guide' ) ) return;

		$labels = array(
			'name'                => esc_html__( 'Size Guides', 'teepro' ),
			'singular_name'       => esc_html__( 'Size Guide', 'teepro' ),
			'menu_name'           => esc_html__( 'Size Guides', 'teepro' ),
			'add_new'             => esc_html__( 'Add new', 'teepro' ),
			'add_new_item'        => esc_html__( 'Add new size guide', 'teepro' ),
			'new_item'            => esc_html__( 'New size guide', 'teepro' ),
			'edit_item'           => esc_html__( 'Edit size guide', 'teepro' ),
			'view_item'           => esc_html__( 'View size guide', 'teepro' ),
			'all_items'           => esc_html__( 'All size guides', 'teepro' ),
			'search_items'        => esc_html__( 'Search size guides', 'teepro' ),
			'not_found'           => esc_html__( 'No size guides found.', 'teepro' ),
			'not_found_in_trash'  => esc_html__( 'No size guides found in trash.', 'teepro' )
		);

		$args = array(
			'label'               => esc_html__( 'teepro_size_guide', 'teepro' ),
			'description'         => esc_html__( 'Size guide to place in your products', 'teepro' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-screenoptions',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'teepro_size_guide', $args );
	}

    // Todo change to minified version and load conditional. Example: isotope is now always load
    public function core_scripts_enqueue()
    {
        //TODO Remember this
        // wp_dequeue_script('wc-cart');
        wp_enqueue_style('fontello', get_template_directory_uri() . '/assets/vendor/fontello/fontello.css', array(), TEEPRO_VER);
        if(is_rtl()){
            wp_enqueue_style('nbcore_front_style_rtl', get_template_directory_uri() . '/rtl.css', array(), TEEPRO_VER);
        }
        wp_enqueue_style('nbcore_front_style', get_template_directory_uri() . '/assets/netbase/css/main.css',array(), TEEPRO_VER);

        wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/vendor/isotope/isotope.pkdg.min.js', array('jquery'), '3.0.3', true);


        wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/vendor/magnific-popup/magnific-popup.css', array(), '2.0.5');
        wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/vendor/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '2.0.5', true);

        wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper.min.css', array(), '4.4.3');
        wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/vendor/swiper/swiper.min.js', array('jquery'), '4.4.3', true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        if (function_exists('is_product') && is_product() && 'accordion-tabs' == teepro_get_options('nbcore_info_style')) {
            wp_enqueue_script('jquery-ui-accordion');
        }

        if (teepro_get_options('nbcore_header_fixed')) {
            wp_enqueue_script('waypointstheme', get_template_directory_uri() . '/assets/vendor/waypoints/jquery.waypoints.min.js', array('jquery'), '4.0.1', true);
        }

        if (teepro_get_options('nbcore_blog_sticky_sidebar') || teepro_get_options('shop_sticky_sidebar') || teepro_get_options('product_sticky_sidebar') || teepro_get_options('nbcore_vendor_sticky_sidebar'))  {
            wp_enqueue_script('sticky-kit', get_template_directory_uri() . '/assets/vendor/sticky-kit/jquery.sticky-kit.min.js', array('jquery'), '1.1.2', true);
        }

        wp_enqueue_script('nbcore_front_script', get_template_directory_uri() . '/assets/netbase/js/main.js', array('jquery'), TEEPRO_VER, true);

        $localize_array = array(
            'ajaxurl'               => admin_url( 'admin-ajax.php', 'relative' ),
            'rest_api_url'          => site_url() . '/wp-json/wp/v2/',
            'upsells_columns'       => teepro_get_options('nbcore_pd_upsells_columns'),
            'related_columns'       => teepro_get_options('nbcore_pd_related_columns'),
            'cross_sells_columns'   => teepro_get_options('nbcore_cross_sells_per_row'),
            'thumb_pos'             => teepro_get_options('nbcore_pd_thumb_pos'),
            'menu_resp' => teepro_get_options('nbcore_menu_resp'),
        );
        
        if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $version = version_compare( preg_replace( '/-beta-([0-9]+)/', '', WC()->version ), '2.3.0', '<' );   
            $localize_array['is2_2'] = $version;
        }

        wp_localize_script('nbcore_front_script','teepro', $localize_array);

        wp_dequeue_script('yith-wcqv-frontend');
        wp_dequeue_style('yith-quick-view');
    }


    //TODO optimize this(grouping and bring to css if can)
    //TODO early esc_
    public static function get_embed_style()
    {
        $bg_color = teepro_get_options('nbcore_background_color');
        $inner_bg = teepro_get_options('nbcore_inner_background');

        $top_padding = teepro_get_options('nbcore_top_section_padding');
        $top_bg = teepro_get_options('nbcore_header_top_bg');
        $top_color = teepro_get_options('nbcore_header_top_color');
        $top_color_hover = teepro_get_options('nbcore_header_top_color_hover');
        $middle_padding = teepro_get_options('nbcore_middle_section_padding');
        $middle_bg = teepro_get_options('nbcore_header_middle_bg');
        $middle_color = teepro_get_options('nbcore_header_middle_color');
        $middle_color_hover = teepro_get_options('nbcore_header_middle_color_hover');
        
        $bot_padding = teepro_get_options('nbcore_bot_section_padding');
        $bot_bg = teepro_get_options('nbcore_header_bot_bg');
        $bot_color = teepro_get_options('nbcore_header_bot_color');
        //$menu_bg = teepro_get_options('nbcore_header_mainmn_bg');
        $menu_color = teepro_get_options('nbcore_header_mainmn_color');
        $menu_bor = teepro_get_options('nbcore_header_mainmn_bor');
        //$menu_bg2 = teepro_get_options('nbcore_header_mainmnhover_bg');
        $menu_color2 = teepro_get_options('nbcore_header_mainmnhover_color');
        $menu_bor2 = teepro_get_options('nbcore_header_mainmnhover_bor');

        $logo_area_width = teepro_get_options('nbcore_logo_width');
        $logo_currency_width = teepro_get_options('nbcore_logo_currency_width');
        $blog_width = teepro_get_options('nbcore_blog_width');
        $primary_color = teepro_get_options('nbcore_primary_color');
        $divider_color = teepro_get_options('nbcore_divider_color');

        $heading_font_array = explode(",", teepro_get_options('heading_font_family'));
        $heading_family = end($heading_font_array);
        $heading_font_style = explode(",", teepro_get_options('heading_font_style'));
        $heading_weight = end($heading_font_style);
        $heading_color = teepro_get_options('nbcore_heading_color');

        $heading_base_size = teepro_get_options('heading_base_size');

        $body_family_array = explode(",", teepro_get_options('body_font_family'));
        $body_family = end($body_family_array);
        $body_style_array = explode(",", teepro_get_options('body_font_style'));
        $body_weight = end($body_style_array);
        $body_color = teepro_get_options('nbcore_body_color');
        $body_size = teepro_get_options('body_font_size');

        $link_color = teepro_get_options('nbcore_link_color');
        $link_hover_color = teepro_get_options('nbcore_link_hover_color');

        $blog_sidebar = teepro_get_options('nbcore_blog_sidebar');
        $page_title_padding = teepro_get_options('nbcore_page_title_padding');
        $page_title_color = teepro_get_options('nbcore_page_title_color');

        $wc_content_width = teepro_get_options('nbcore_shop_content_width');
        $shop_sidebar = teepro_get_options('nbcore_shop_sidebar');
        $loop_columns = teepro_get_options('nbcore_loop_columns');
        $pd_details_sidebar = teepro_get_options('nbcore_pd_details_sidebar');
        $pd_details_width = teepro_get_options('nbcore_pd_details_width');
        $pd_images_width = teepro_get_options('nbcore_pd_images_width');

        $pb_bg = teepro_get_options('nbcore_pb_background');
        $pb_bg_hover = teepro_get_options('nbcore_pb_background_hover');
        $pb_text = teepro_get_options('nbcore_pb_text');
        $pb_text_hover = teepro_get_options('nbcore_pb_text_hover');
        $pb_border = teepro_get_options('nbcore_pb_border');
        $pb_border_hover = teepro_get_options('nbcore_pb_border_hover');
        $sb_bg = teepro_get_options('nbcore_sb_background');
        $sb_bg_hover = teepro_get_options('nbcore_sb_background_hover');
        $sb_text = teepro_get_options('nbcore_sb_text');
        $sb_text_hover = teepro_get_options('nbcore_sb_text_hover');
        $sb_border = teepro_get_options('nbcore_sb_border');
        $sb_border_hover = teepro_get_options('nbcore_sb_border_hover');
        $button_padding = teepro_get_options('nbcore_button_padding');
        $button_border_radius = teepro_get_options('nbcore_button_border_radius');
        $button_border_width = teepro_get_options('nbcore_button_border_width');

        $footer_top_heading = teepro_get_options('nbcore_footer_top_heading');
        $footer_top_color = teepro_get_options('nbcore_footer_top_color');
        $footer_top_bg = teepro_get_options('nbcore_footer_top_bg');
        $footer_top_padding_top = teepro_get_options('nbcore_footer_top_padding_top');
        $footer_top_padding_bottom = teepro_get_options('nbcore_footer_top_padding_bottom');
        $footer_top_border_bot_color = teepro_get_options('nbcore_footer_top_border_bot_color');
        $footer_bot_heading = teepro_get_options('nbcore_footer_bot_heading');
        $footer_bot_color = teepro_get_options('nbcore_footer_bot_color');
        $footer_bot_bg = teepro_get_options('nbcore_footer_bot_bg');
        $footer_bot_padding_top = teepro_get_options('nbcore_footer_bot_padding_top');
        $footer_bot_padding_bottom = teepro_get_options('nbcore_footer_bot_padding_bottom');
        $footer_bot_border_bot_color = teepro_get_options('nbcore_footer_bot_border_bot_color');
        $footer_abs_bg = teepro_get_options('nbcore_footer_abs_bg');
        $footer_abs_color = teepro_get_options('nbcore_footer_abs_color');

        $blog_title_size = teepro_get_options('nbcore_blog_single_title_size');
        $page_title_size = teepro_get_options('nbcore_page_title_size');

        $footer_abs_padding = teepro_get_options('nbcore_footer_abs_padding');

        $pages_sidebar      = teepro_get_options('nbcore_pages_sidebar');
        $page_content_width = teepro_get_options('nbcore_page_content_width') != 0 ? teepro_get_options('nbcore_page_content_width') : 70;

        $page_bg = wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'page_bg_image', true), 'full');
        $page_bg_color = get_post_meta(get_the_ID(), 'page_bg_color', true);
        $nbcore_container_width = teepro_get_options('nbcore_container_width');

        $nbcore_dokan_dashboard_sidebar = teepro_get_options('nbcore_dokan_sidebar');

        if ( class_exists( 'WeDevs_Dokan' ) ) {
            $vendor_width = teepro_get_options('nbcore_vendor_details_width');
            $vendor_sidebar = teepro_get_options('nbcore_vendor_details_sidebar');
        }

        $vendor_map_height = teepro_get_options('nbcore_vendor_map_height');
        

        $css = "";

        if(isset($nbcore_container_width) && $nbcore_container_width > '1170'){
            $css .= "
            @media (min-width: 1920px){
                .container {
                    max-width: " . $nbcore_container_width . "px;
                    width: " . $nbcore_container_width . "px;
                }
            }
            ";
        }

        if($body_family_array[0] === 'custom') {
            $body_custom_font_url = array_slice($body_family_array, 1, -1);
            $css .= "
            @font-face {
                font-family: '" . end($body_family_array) . "';            
                ";

                foreach($body_custom_font_url as $url) {
                    $css .= "
                    src: url('" . $url . "');
                    ";
                }

                $css .= "
            }
            ";
        }
        if($heading_font_array[0] === 'custom') {
            $heading_custom_font_url = array_slice($heading_font_array, 1, -1);
            $css .= "
            @font-face {
                font-family: '" . end($heading_font_array) . "';            
                ";

                foreach($heading_custom_font_url as $url) {
                    $css .= "
                    src: url('" . $url . "');
                    ";
                }

                $css .= "
            }
            ";
        }
        $css .= "
            #site-wrapper {
        background: " . esc_attr($bg_color) . ";
    }
    .nb-page-title-wrap,
    .single-blog .entry-author,
    .shop-main.accordion-tabs .accordion-title-wrap,
    .woocommerce .woocommerce-message,
    .woocommerce .woocommerce-info,
    .woocommerce .woocommerce-error,
    .woocommerce-page .woocommerce-message,
    .woocommerce-page .woocommerce-info,
    .woocommerce-page .woocommerce-error,
    .cart-layout-2 .cart-totals-wrap,
    .blog.style-2 .post .entry-content,
    .nb-comment-form textarea,
    .comments-area,
    .blog .post .entry-cat a
    {
        background-color: " . esc_attr($inner_bg) . ";
    }
    .products.list-type .product .list-type-wrap .product-image:before {
        border-right-color: " . esc_attr($inner_bg) . ";
    }
    .main-logo {
        width: " . esc_attr($logo_area_width) . "px;
    }
    .dd-select .dd-selected img,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .woocs_flag_view_item{
        width: " . esc_attr($logo_currency_width) . "px;
    }
    .dd-options .dd-option img{
        width: calc(" . esc_attr($logo_currency_width) . "px + 15px);
    }
    a,
    .widget ul li a,
    .footer-top-section a,
    .footer-top-section .widget ul li a,
    .footer-bot-section a,
    .footer-bot-section .widget ul li a {
        color: " . esc_attr($link_color) . ";
    }
    a:hover, a:focus, a:active,
    .widget ul li a:hover,
    .footer-top-section a:hover,
    .footer-top-section .widget ul li a:hover,
    .footer-bot-section a:hover,
    .footer-bot-section .widget ul li a:hover,
    .widget_nbelement_contact_info ul.nbelement-info li:hover i {
        color: " . esc_attr($link_hover_color) . ";
    }
    body {
        font-family: " . esc_attr($body_family) . "; 
        font-weight: " . esc_attr($body_weight) . ";
        font-size: " . esc_attr($body_size) . "px;
        ";
        if (in_array("italic", $body_style_array)) {
            $css .= "
            font-style: italic;
            ";
        }
        if (in_array("underline", $body_style_array)) {
            $css .= "
            text-decoration: underline;
            ";
        }
        if (in_array("uppercase", $body_style_array)) {
            $css .= "
            text-transform: uppercase;
            ";
        }
        $css .= "
    }
    .button, .nb-primary-button, .post-password-form input[type='submit'],
    .teepro-button button.ubtn-normal, 
    .teepro-button button.ubtn-mini,
    .teepro-button button.ubtn-small,
    .teepro-button button.ubtn-large,
    .teepro-button button.ubtn-block,
    .contact-tshirt .contact_right input[type='submit'],
    .category_banner .vc_column-inner .button_comback_shop a,
    .nb_layout_wp-img-left .nb_wp_post .nb-post-block .nb-post-content .nb-post-readmore a,
    .nb_layout_wp-img-top .nb_wp_post .nb-post-block .nb-post-content .readmore,
    .button_joinus.vc_btn3-center.vc_btn3-container a.vc_general.vc_btn3,
    .dokan-order-action a.dokan-btn:hover,
    a.dokan-btn-default.dokan-coupon-product-select-all,a.dokan-btn-default.dokan-coupon-product-clear-all,
    input[type='submit'].dokan-btn-success, a.dokan-btn-success, .dokan-btn-success,
    .dokan-dashboard-content button,a.dokan-btn-theme,
    .dokan-form-group input[type='submit'],.category .blog .bt-4.nb-secondary-button,
    .intro_teepro .readmore_teepro:hover,.single-product .nbcs-section .nbcs-add-to-cart-button input[type='submit'],
    a.dokan-btn-theme:focus, .dokan-btn-theme:focus
    {
        color: " . esc_attr($pb_text) . " !important;
        background-color: " . esc_attr($pb_bg) . ";
        border-color: " . esc_attr($pb_border) . ";
    }
    .woocommerce-order .btn-pdf-preview,.text-notice a,.woocommerce-checkout .woocommerce a.button{
        color: " . esc_attr($pb_text) . " !important;
        background-color: " . esc_attr($pb_bg) . " !important;
        border-color: " . esc_attr($pb_border) . " !important;        
    }
    .button:hover, .nb-primary-button:hover, .button:focus, .nb-primary-button:focus,
    .contact-tshirt .contact_right input[type='submit']:hover,
    .button_joinus.vc_btn3-center.vc_btn3-container a.vc_general.vc_btn3:hover,
    .category_banner .vc_column-inner .button_comback_shop a:hover,
    .nb_layout_wp-img-left .nb_wp_post .nb-post-block .nb-post-content .nb-post-readmore a:hover,
    .nb_layout_wp-img-top .nb_wp_post .nb-post-block .nb-post-content .readmore:hover,
    .teepro-button button.ubtn-normal:hover,
    a.dokan-btn-default.dokan-coupon-product-select-all:hover,a.dokan-btn-default.dokan-coupon-product-clear-all:hover,
    input[type='submit'].dokan-btn-success:hover, a.dokan-btn-success:hover, .dokan-btn-success:hover,
    .intro_teepro .readmore_teepro:hover,.single-product .nbcs-section .nbcs-add-to-cart-button input[type='submit']:hover,
    .category .blog .bt-4.nb-secondary-button:hover,
    .dokan-dashboard-content button:hover,a.dokan-btn-theme:hover
    {
        color: " . esc_attr($pb_text_hover) . ";
        background-color: " . esc_attr($pb_bg_hover) . ";
        border-color: " . esc_attr($pb_border_hover) . ";
    }
    .woocommerce-order .btn-pdf-preview:hover,.text-notice a:hover,.woocommerce-checkout .woocommerce a.button:hover{
        color: " . esc_attr($pb_text_hover) . " !important;
        background-color: " . esc_attr($pb_bg_hover) . " !important;
        border-color: " . esc_attr($pb_border_hover) . " !important;        
    }
    .teepro-button button.ubtn-normal .ubtn-hover,
    .teepro-button button.ubtn-normal .ubtn-hover, 
    .teepro-button button.ubtn-mini .ubtn-hover,
    .teepro-button button.ubtn-small .ubtn-hover,
    .teepro-button button.ubtn-large .ubtn-hover,
    .teepro-button button.ubtn-block .ubtn-hover {
        background-color: " . esc_attr($pb_bg_hover) . ";
    }
    .nb-secondary-button {
        color: " . esc_attr($pb_text) . ";
        background-color: " . esc_attr($pb_bg) . ";
        border-color: " . esc_attr($pb_border) . ";
    }
    .nb-secondary-button:hover, .nb-secondary-button:focus {
        color: " . esc_attr($pb_text_hover) . ";
        background-color: " . esc_attr($pb_bg_hover) . ";
        border-color: " . esc_attr($pb_border_hover) . ";
    }
    .list-type .add_to_cart_button, .nb-primary-button, .nb-secondary-button, .single_add_to_cart_button, .post-password-form input[type='submit']{
        padding-left: " . esc_attr($button_padding) . "px;
        padding-right: " . esc_attr($button_padding) . "px;
        border-width: " . esc_attr($button_border_width) . "px;
        ";
        if ($button_border_radius) {
            $css .= "
            border-radius: " . esc_attr($button_border_radius) . "px;
            ";
        } else {
            $css .= "
            border-radius: 0px;
            ";
        }
        $css .= "
    }
    body,
    .widget ul li a,
    .woocommerce-breadcrumb a,
    .nb-social-icons > a,
    .wc-tabs > li:not(.active) a,
    .shop-main.accordion-tabs .accordion-title-wrap:not(.ui-state-active) a,
    .nb-account-dropdown a,
    .header-account-wrap .not-logged-in,
    .mid-inline .nb-account-dropdown a, 
    .mid-inline .mini-cart-section span, 
    .mid-inline .mini-cart-section a, 
    .mid-inline .mini-cart-section strong,
    .entry-meta .byline a,
    .comments-link a{
        color: " . esc_attr($body_color) . ";
    }
    h1 {
        font-size: " . esc_attr(intval($heading_base_size * 1.602)) . "px;
    }
    h2 {
        font-size: " . esc_attr(intval($heading_base_size * 1.424)) . "px;
    }
    h3 {
        font-size: " . esc_attr(intval($heading_base_size * 1.266)) . "px;
    }
    h4 {
        font-size: " . esc_attr(intval($heading_base_size * 1.125)) . "px;
    }
    h5 {
        font-size: " . esc_attr(intval($heading_base_size * 1)) . "px;
    }
    h6 {
        font-size: " . esc_attr(intval($heading_base_size * 0.889)) . "px;
    }
    h1, h2, h3, h4, h5, h6,
    h1 > a, h2 > a, h3 > a, h4 > a, h5 > a, h6 > a,
    .entry-title > a,
    .woocommerce-Reviews .comment-reply-title {
        font-family: " . esc_attr($heading_family) . "; 
        font-weight: " . esc_attr($heading_weight) . ";
        color: " . esc_attr($heading_color) . ";
        ";
        if (in_array("italic", $heading_font_style)) {
            $css .= "
            font-style: italic;
            ";
        }
        if (in_array("underline", $heading_font_style)) {
            $css .= "
            text-decoration: underline;
            ";
        }
        if (in_array("uppercase", $heading_font_style)) {
            $css .= "
            text-transform: uppercase;
            ";
        }
        //TODO after make inline below woocommerce.css remove these !important
        //TODO postMessage font-size .header-top-bar a
        $css .= "
    }
    .site-header .top-section-wrap {
        padding: " . esc_attr($top_padding) . "px 0;
        background-color: " . esc_attr($top_bg) . ";
    }
    .site-header.left-inline .top-section-wrap .header_top_right_menu,
    .site-header .top-section-wrap .sub-navigation
    {
        margin: -" . esc_attr($top_padding) . "px 0;
    }
    .site-header.left-inline .top-section-wrap .header_top_right_menu ul,
    .site-header.teepro-header-1 .top-section-wrap .sub-navigation .nb-header-sub-menu >.menu-item,
    .site-header.teepro-header-2 .top-section-wrap .sub-navigation .nb-header-sub-menu >.menu-item,
    .site-header.teepro-header-3 .top-section-wrap .sub-navigation .nb-header-sub-menu >.menu-item,
    .site-header.teepro-header-4 .top-section-wrap .sub-navigation .nb-header-sub-menu >.menu-item,
    .site-header .sub-navigation .widget .dd-select
    {
        padding: " . esc_attr($top_padding) . "px 0;
    }
    .WOOCS_SELECTOR .wSelect,
    .WOOCS_SELECTOR .chosen-container,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR select.woocommerce-currency-switcher,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .woocs_flag_view_item
    {
        margin: calc(" . esc_attr($top_padding) . "px - 3px) 0 0;
    }
    .top-section-wrap .nb-header-sub-menu a {
        color: " . esc_attr($top_color) . ";
    }
    .top-section-wrap a:hover,
    .site-header .top-section-wrap .sub-navigation .nb-header-sub-menu li.menu-item-has-children .sub-menu li:hover a span,
    .top-section-wrap .nb-header-sub-menu a:hover,.top-section-wrap li:hover a span,.site-header .top-section-wrap .sub-navigation .nb-header-sub-menu li.menu-item-has-children .sub-menu li:hover a span,
    .site-header .top-section-wrap .header_top_right_menu .data_user .user-menu > li > a:hover {
        color: " . esc_attr($top_color_hover) . ";
    }
    
    .top-section-wrap .nb-header-sub-menu .sub-menu {
        background-color: " . esc_attr($top_bg) . ";
    }
    .site-header .middle-section-wrap {
        padding: " . esc_attr($middle_padding) . "px 0;
        background-color: " . esc_attr($middle_bg) . ";
    }
    .site-header .middle-section-wrap .nb-navbar,
    .site-header.header-desktop .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary
    {
        margin: -" . esc_attr($middle_padding) . "px 0;  
    }
    .site-header .middle-section-wrap .nb-navbar > .menu-item,
    .site-header.header-desktop .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li
    {
        padding: " . esc_attr($middle_padding) . "px 0;  
    }
  
    .site-header:not(.mid-stack) .bot-section-wrap {
        padding: " . esc_attr($bot_padding) . "px 0;                
    }
    .site-header.mid-stack .nb-navbar > .menu-item > a {
        padding: " . esc_attr($bot_padding) . "px 20px;                
    }
    .site-header .bot-section-wrap {
        background-color: " . esc_attr($bot_bg) . ";           
    }
    .bot-section-wrap a, .bot-section-wrap span, .bot-section-wrap i, .bot-section-wrap div{
        color: " . esc_attr($bot_color) . ";
    }
    .middle-section-wrap a, .middle-section-wrap span, .middle-section-wrap i, .middle-section-wrap div,.nbt-ajax-cart-icon i,.nbt-ajax-cart .nbt-ajax-cart-icon .nbt-ajax-cart-count{
        color: " . esc_attr($middle_color) . ";
    }
    .nbt-icon-search{
        color: " . esc_attr($middle_color) . " !important;
    }
    .middle-section-wrap a:hover,.middle-section-wrap a:hover span,.middle-section-wrap a:hover i,.middle-section-wrap .nb-navbar .menu-item:hover > a,
    .mini-cart-section .mini-cart-wrap .mini_cart_item .minicart-pd-meta a:hover,.mini-cart-section .mini-cart-wrap .mini_cart_item .remove:hover i,
    .nbt-ajax-cart .nbt-ajax-cart-popup .woocommerce-Price-amount
    {
        color: " . esc_attr($middle_color_hover) . ";
    }
    .nbt-ajax-cart .nbt-ajax-cart-popup ul li .nbt-ajax-cart-right h4 a{
        color: " . esc_attr($middle_color_hover) . "!important;
    }
    .nbt-ajax-cart .nbt-ajax-cart-icon .nbt-ajax-cart-count{
        background: " . esc_attr($middle_color_hover) . ";
    }
    .nbt-ajax-cart .nbt-ajax-cart-popup .buttons a:hover{
        background: " . esc_attr($middle_color_hover) . "!important;
    }
    .mini-cart-wrap .mini_cart_item .mini-cart-pd-image:hover img{
        border-color: " . esc_attr($middle_color_hover) . ";
    }
    .nbt-ajax-cart .nbt-ajax-cart-icon:after{
        border-bottom-color: " . esc_attr($middle_color_hover) . ";
    }
    .nbt-ajax-cart .nbt-ajax-cart-popup{
        border-top-color: " . esc_attr($middle_color_hover) . ";
    }
    .site-header .middle-section-wrap .icon-header-section .icon-header-wrap .header-cart-wrap .nb-cart-section .count-item,
    .site-header.header-desktop .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li > ul.mega-sub-menu::before
    {
        background-color: " . esc_attr($middle_color_hover) . ";
    }
    .site-header.header-desktop .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li.mega-toggle-on > a::before,
    .site-header.header-desktop .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li:hover > a::before
    {
        border-top-color:  " . esc_attr($middle_color_hover) . ";
    }
    .top-section-wrap a, .top-section-wrap span, .top-section-wrap i, .top-section-wrap div{
        color: " . esc_attr($top_color) . ";
    }
    .nb-navbar > .menu-item,.nb-navbar a,.nb-navbar span,
    .site-header.header-desktop .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary span,
    .site-header.header-desktop .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary div,
    .site-header.header-desktop .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary a,.middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary i
    {
        color: " . esc_attr($menu_color) . ";
    }
    .nb-navbar > .menu-item:hover >a span,.nb-navbar a:hover,
    .site-header.teepro-header-2.header-desktop .middle-section-wrap .main-nav-wrap .nb-navbar > li.menu-item.current-menu-item > a > span,
    .site-header .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li > ul.mega-sub-menu .mega-menu-row.menu_link_title .menu > li > a,
    .site-header .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li > ul.mega-sub-menu .mega-menu-row.menu_about .about_readmore,
    .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary .menu-item:hover >a,
    .site-header.header-mobile .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li.mega-menu-flyout .mega-sub-menu > li:hover > a,
    .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary a:hover,.middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary a:hover >*,
    .site-header.header-mobile .main-nav-wrap .mega-menu-wrap#mega-menu-wrap-primary ul.mega-menu#mega-menu-primary > li.mega-menu-grid a:hover,
     .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary .mega-menu-item:hover >a,
     .middle-section-wrap .mega-menu-wrap#mega-menu-wrap-primary .mega-menu-item:hover >a *
    {   
        color: " . esc_attr($menu_color2) . ";
    }
    .site-header.teepro-header-2.header-desktop .middle-section-wrap .main-nav-wrap .nb-navbar > li.menu-item > a > span::after{
        border-color: " . esc_attr($menu_bor) . ";
    }
    .site-header.teepro-header-2.header-desktop .middle-section-wrap .main-nav-wrap .nb-navbar > li.menu-item.current-menu-item > a > span::after,
    .site-header.teepro-header-2.header-desktop .middle-section-wrap .main-nav-wrap .nb-navbar > li.menu-item:hover > a > span::after
    {
        border-color: " . esc_attr($menu_bor2) . ";
    }
    .nb-navbar .menu-item-has-children > a span:after,
    .icon-header-section .nb-cart-section,
    .nb-navbar .menu-item a,
    .nb-navbar .sub-menu > .menu-item:not(:last-child),
    .nb-header-sub-menu .sub-menu > .menu-item:not(:last-child),
    .widget .widget-title,
    .blog .classic .post .entry-footer,
    .single-post .single-blog .entry-footer,
    .nb-social-icons > a,
    .single-blog .entry-author-wrap,
    .shop-main:not(.wide) .single-product-wrap .product_meta,
    .shop-main.accordion-tabs .accordion-item .accordion-title-wrap,
    .shop-main.horizontal-tabs .wc-tabs-wrapper .wc-tabs,
    .shop_table thead th,
    .shop_table th,
    .shop_table td,
    .mini-cart-wrap .total,
    .icon-header-wrap .nb-account-dropdown ul li:not(:last-of-type) a,
    .widget tbody th, .widget tbody td,
    .widget ul > li:not(:last-of-type),
    .blog .post .entry-image .entry-cat,
    .comment-list .comment,
    .nb-comment-form textarea,
    .paging-navigation.pagination-style-1 .page-numbers.current,
    .woocommerce-pagination.pagination-style-1 .page-numbers.current,
    .single-product-wrap .cart,
    .single-product-wrap .woocommerce-product-details__short-description, 
    .dokan-single-seller .store-wrapper,
    .sp-ou-meta,
    .widget.WOOF_Widget .woof .woof_container.woof_by_rating_container .woof_container_inner .chosen-results li
    {
        border-color: " . esc_attr($divider_color) . ";
    }
    @media (max-width: 767px) {
        .shop_table.cart {
            border: 1px solid " . esc_attr($divider_color) . ";
        }
        .shop_table.cart td {
            border-bottom: 1px solid " . esc_attr($divider_color) . ";
        }
    }

    .sticky
    {
        border-top: 1px solid " . esc_attr($primary_color) . ";
        box-shadow: 0px 0px 20px " . esc_attr($primary_color) . ";
    }

    .product .product-image .onsale,
    .wc-tabs > li.active,
    .product .onsale.sale-style-2 .percent,
    .product .onsale.sale-style-3 .percent,
    .wc-tabs-wrapper .woocommerce-Reviews #review_form_wrapper .comment-respond,
    .site-header.mid-stack .main-navigation .nb-navbar > .menu-item:hover,
    .shop-main.accordion-tabs .accordion-item .accordion-title-wrap.ui-accordion-header-active,
    .widget .tagcloud a,
    .footer-top-section .widget .tagcloud a,
    .footer-bot-section .widget .tagcloud a,
	.service_tab_1 .vc_tta-panels-container .vc_tta-panels .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title a::after,
    .cart-notice-wrap .cart-notice,
    .products .product .product-action.center .bt-4:hover,
    .products .product .nb-loop-variable .nbtcs-swatches .swatch:hover:before,
    .single-product-wrap .nbtcs-swatches .swatch:hover:before,
    .vc-tab-product-wrapper .vc-tab-product-content .tab-panel .cat_img a .cat_img_button:hover,
    .pt_home_6 .vc-tab-product-wrapper ul.style-border_bottom li.active a,
    .vc-tab-product-wrapper .vc-tab-product-content .tab-panel .cat_img a:hover .cat_img_button,
    .uvc-heading-spacer.line_with_icon:before, 
    .uvc-heading-spacer.line_with_icon:after,
    .new_letter_1 .footer-newsletter .footer-newsletter-form button[type='submit'],
    .teepro-our-customers .our-customers-wrap .our-customer-images .swiper-wrapper .swiper-slide .customer-img.has-border:hover,
    .widget .nbfw-social-link-widget.gray-icon li a:hover,
    .related-product:hover > a img,
    #secondary .widget.nbfw-social-links,
    .loading.demo7 #loading-center #loading-center-absolute .object,
    .nb-page-title-wrap.bg_img .nb-page-title h1:before,
    .single-product-wrap .product-image .thumb-gallery .swiper-slide.swiper-slide-active img,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
    .dokan-dashboard.dokan-custom-style .dokan-dashboard-content .dokan-report-wrap .dokan-reports-sidebar ul.chart-legend li:first-child,
    .store-coupon-wrap.teepro_show_store_coupons,
    .loading.demo3 #loading-center #loading-center-absolute .object,
    #yith-wcwl-popup-message,
    .nbt-upload-zone .nbt-oupload-target,
    .intro_teepro .readmore_teepro,.noo-line .line-one,.noo-line .line-two,
    .single-product-wrap .nbtcs-swatches .swatch-color.circle.selected:before,
    .nbd-gallery #primary .nbd-list-designs .nbd-gallery-item:hover,
    .woof .woof_redraw_zone .woof_container.woof_container_label ul.woof_list li span.checkbox:hover,
    .woof .woof_redraw_zone .woof_container.woof_container_label ul.woof_list li span.checkbox.checked,
    .woof .woof_redraw_zone .woof_container.woof_container_color .woof_tooltip:hover span.checkbox,
    .woof .woof_redraw_zone .woof_container.woof_container_color .woof_tooltip span.checkbox.checked,
    .products .product .nb-loop-variable .nbtcs-swatches .swatch.swatch-text:hover,
    .products .product .nb-loop-variable .nbtcs-swatches .swatch.swatch-image:hover
    {
        border-color: " . esc_attr($primary_color) . ";
    }
    .loading.demo14 #loading-center #loading-center-absolute .object{
        border-left-color: " . esc_attr($primary_color) . ";
        border-right-color: " . esc_attr($primary_color) . ";
    }
    .loading.demo15 #loading-center #loading-center-absolute .object{
        border-left-color: " . esc_attr($primary_color) . ";
        border-top-color: " . esc_attr($primary_color) . ";
    }
    .nbfw_banner-container .nbfw-txt-info .banner-more:hover,.stepbystep2 .wpb_column:hover .wpb_single_image .vc_box_rounded,
    .vc_testimonial_wrap.testimonial_multi_thumb_style_1 .vc-avatar-testimonial .swiper-slide.swiper-slide-active .vc-avatar-img img,
    .hello-teepro .uvc-headings-line,
    .woof .woof_redraw_zone .woof_container.woof_container_image .woof_tooltip span.checkbox:hover,
    .woof .woof_redraw_zone .woof_container.woof_container_image .woof_tooltip span.checkbox.checked,
    .products .product .nb-loop-variable .nbtcs-swatches .swatches-radio li:hover .check,
    .products .product .nb-loop-variable .nbtcs-swatches .swatches-radio li input[type=radio]:checked ~ .check
    {
        border-color: " . esc_attr($primary_color) . " !important;
    }
    .growl-message{
        border: 1px solid " . esc_attr($primary_color) . ";
    }
    .noo-line .line-one span:first-child:before,.noo-line .line-one span:last-child:before,.noo-line .line-two span:first-child:before,.noo-line .line-two span:last-child:before{
        border: 2px solid " . esc_attr($primary_color) . ";
    }
    .products .product .product-action.center .tooltip:before,
    .products .product .product-action.horizontal .tooltip:before,
    .mini-cart-wrap,.nbt-search-wrapper,
    .vc_step.content_top .vc-step-items .step_box .step_title_content:before,
    .nbfw_banner-container .nbfw-txt-info .txt-caption .txt-caption-divider,
    .products .product .product-action.horizontal span.tooltip:before
    {
        border-top-color: " . esc_attr($primary_color) . ";
    }
    .vc_step.content_top .vc-step-items .step_box .step_title_content:before,
    .vc_step.content_bottom .vc-step-items .step_box .step_number:before{
        border-right-color: " . esc_attr($primary_color) . ";

    }
    .text_service .text_banner_service::after,
    .about_history_content .vc_toggle_content .about_heading::after,
    .vc_step.content_left .vc-step-items .step_box .step_number:before,
    .vc_step.content_right .vc-step-items .step_box .step_number:before,
    .text_service .text_banner_service::before
    {
        border-bottom-color: " . esc_attr($primary_color) . ";
    }
    .widget .widget-title:before,
    .paging-navigation.pagination-style-2 .current,
    .product .onsale.sale-style-1,
    .woocommerce-pagination.pagination-style-2 span.current,
    .shop-main.right-dots .flickity-page-dots .dot,
    .wc-tabs-wrapper .form-submit input,
    .nb-input-group .search-button button,
    .widget .tagcloud a:hover,
    .nb-back-to-top-wrap a:hover,
	.nb_layout_wp-img-top .nb_wp_post .nb-post-date .nb-post-date-i,
    .nb_layout_wp-img-left .nb_wp_post .nb-post-block .nb-post-content .nb-post-readmore a::before,
    .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,
    .products .product .product-action .button .tooltip,
    .product .product-image .wishlist-fixed-btn .yith-wcwl-add-to-wishlist .tooltip,
    .products .product .product-action .bt-4:hover,
    .products .product .product-action.horizontal .button:hover,
    .products .product .product-action.horizontal .button .tooltip,
    .wpt-loading:after,
    .vc-tab-product-wrapper .vc-tab-product-content .tab-panel .cat_img a:hover .cat_img_button,
    .vc-tab-product-wrapper .vc-tab-product-header .product-tab-header.show_heading_line h2:after,
    .pt_home_6 .vc-tab-product-wrapper ul.style-border_bottom li a:before,
    .line-through .uvc-main-heading h1:after, 
    .line-through .uvc-main-heading h2:after, 
    .line-through .uvc-main-heading h3:after, 
    .line-through .uvc-main-heading h4:after, 
    .line-through .uvc-main-heading h5:after, 
    .line-through .uvc-main-heading h6:after,
    .uvc-heading.hp1-heading .uvc-sub-heading:before,
    .uvc-heading.hp1-heading .uvc-sub-heading:after,
    .nbfw_banner-container .nbfw-txt-info .banner-more:hover,
    .bg-fullwidth .nbfw_banner-container,
    .category-layout-hp4 .nbfw_banner-container:hover .nbfw-txt-info h4,
    .info-box-our-services .aio-icon-box:hover,
    .teepro-our-customers .our-customers-wrap .our-customers-pagination .swiper-pagination-bullet-active,
    .teepro-image-slider .image-slider-block .image-slider-pagination .swiper-pagination-bullet-active,
    .widget .nbfw-social-link-widget.black-icon li a:hover,
    .site-footer.colorful-widget-title .widget .widget-title:after,
    .sc-video .sc-video-thumb .icon-play-button,
    .content_manage .link_profile li a::before,
    .nb_vc_page_tab:hover .page_tab_content::before,
    .new_letter_1  .footer-newsletter .footer-newsletter-form button[type='submit'],
    .single-product-wrap .yith-wcwl-add-to-wishlist,
    .vc_testimonial_wrap.testimonial_multi_thumb_style_1 .vc-avatar-testimonial .swiper-slide .vc-title .client-name::before,
    .vc_testimonial_wrap.testimonial_multi_thumb_style_1 .vc-avatar-testimonial .swiper-slide .vc-title .client-name::after,
    .widget .sidebar-policy .clear .sidebar-top-icon,
    .faq_page .vc_toggle.vc_toggle_active .vc_toggle_title,
    #secondary .widget .nbfw-social-link-widget.gray-icon li a:hover,
    .widget.service-sidebar .textwidget a,
    .new_letter_1 .footer-newsletter .footer-newsletter-form input[type='submit'],
    .widget.shop-sidebar h3.widget-title,
    .loading #loading-center #loading-center-absolute #object,
    .loading #loading-center #loading-center-absolute .object,
    .loading #loading-center .object-one,
    .loading #loading-center .object-two,
    .image_banner_pages .container .text_banner_bottom_section .custom_link,
    .text-notice a:hover,
    .dokan-dashboard.dokan-custom-style .dokan-progress.m-dokan-progress .dokan-progress-bar,
    .ou-tab .tablinks.activated,
    .page-template-nb-checkout #nb-checkout-cart .shop_table .nbt-ou-fast button,
    #dokan-seller-listing-wrap .pagination-container .pagination-wrap .pagination li .current,
    .shop-main .woof_products_top_panel ul li a,
    .woof_select_radio_check dt.woof_select_radio_check_opened a,
    .woof .woof_redraw_zone .woof_container.woof_container_label ul.woof_list li span.checkbox:hover,
    .woof .woof_redraw_zone .woof_container.woof_container_label ul.woof_list li span.checkbox.checked,
    .woof .woof_redraw_zone .woof_container.woof_container_label ul.woof_list li span.woof_label_count,
    .woof .woof_redraw_zone .woof_container.woof_container_image .woof_tooltip .woof_tooltip_data,
    .woof .woof_container .woof_add_subscr_cont #woof_add_subscr:hover,
    .woof input.woof_add_query_save:hover,
    .woof .woof_redraw_zone .woof_container.woof_container_slider span.irs-with-grid span.irs-slider:hover:after,
    .woof .woof_redraw_zone .woof_container.woof_price_filter span.irs-with-grid span.irs-slider:hover:after,
    .woof .widget_price_filter .ui-slider .ui-slider-range,
    .woof .widget_price_filter .ui-slider .ui-slider-handle,
    .products .product .nb-loop-variable .nbtcs-swatches .swatches-radio li input[type=radio]:checked ~ .check::before,
    .site-header .sub-navigation .woocommerce-currency-switcher-form .wSelect-theme-classic .wSelect-option-selected, 
    .site-header .sub-navigation .woocommerce-currency-switcher-form .wSelect-theme-classic .wSelect-option:hover,
    .error404 main .home-link
    {
        background-color: " . esc_attr($primary_color) . ";
    }
    .teepro-info-box.has-icon-bg .aio-icon-component .aio-icon.circle,
    .swiper-pagination-bullet-active,
    .teepro-info-box.change-bg .aio-icon-component:hover .aio-icon.circle,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .chosen-container .chosen-drop .chosen-results li.result-selected,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .chosen-container .chosen-drop .chosen-results li.active-result:hover,
    .woof .woof_container .chosen-container .chosen-drop .chosen-results .active-result.highlighted
    {
        background-color: " . esc_attr($primary_color) . " !important;
    }
    .product .star-rating:before,
    .product .star-rating span,
    .single-product-wrap .price ins,
    .single-product-wrap .price > span.amount,
    .single-product-wrap .summary >.price .nbtwccs_price_code > span.amount,
    .wc-tabs > li.active a,
    .wc-tabs > li.active a:hover,
    .wc-tabs > li.active a:focus,
    .wc-tabs .ui-accordion-header-active a,
    .wc-tabs .ui-accordion-header-active a:focus,
    .wc-tabs .ui-accordion-header-active a:hover,
    .shop-main.accordion-tabs .ui-accordion-header-active:after,
    .shop_table .cart_item td .amount,
    .cart_totals .order-total .amount,
    .shop_table.woocommerce-checkout-review-order-table .order-total .amount,
    .woocommerce-order .woocommerce-thankyou-order-received,
    .woocommerce-order .woocommerce-table--order-details .amount,
    .paging-navigation.pagination-style-1 .current,
	.service_tab_1 .vc_tta-tabs-container .vc_tta-tabs-list .vc_tta-tab.vc_active a span,
    .service_tab_1 .vc_tta-tabs-container .vc_tta-tabs-list .vc_tta-tab a:hover span,
    .nb_vc_page_tab .page_tab_content .page_tab_readmore:hover,
    .nb_layout_wp-img-top .nb_wp_post .nb-post-block .nb-post-meta a:hover,
    .woocommerce-pagination.pagination-style-1 .page-numbers.current,
    .product .product-image .wishlist-fixed-btn .yith-wcwl-wishlistexistsbrowse .icon-heart, 
    .product .product-image .wishlist-fixed-btn .yith-wcwl-wishlistaddedbrowse .icon-heart, 
    .product .product-image .wishlist-fixed-btn .yith-wcwl-add-to-wishlist i.icon-heart:hover,
    .products .product .price .amount,
    .vc_toggle .vc_toggle_title .vc_custom_heading,
    .vc-tab-product-wrapper ul.style-separated li.active a,
    .vc-tab-product-wrapper ul.style-separated li:hover a,

    .uvc-heading-spacer.line_with_icon .aio-icon,
    .uvc-heading.hp1-heading .uvc-main-heading .big-text,
    .content_manage .link_profile li a,
    .content_manage .read_more,
    .category-layout-hp5 .nbfw_banner-container:hover .nbfw-txt-info h4,
    .site-footer .footer-workingtime-wrapper .love-hour .love-hour-text span i,
    .widget .nbfw-social-link-widget.gray-icon li a:hover,
    .widget .nbfw-social-link-widget.white-icon li a:hover,
    .site-footer.colorful-widget-title .widget .widget-title,
    .banner-images-1 .txt_primary_custom_1,
    .banner-images-1 .txt_primary_custom_2,
    .nb_layout_wp-content-absolute .nb-post-block .nb-post-header .nb-post-meta .nb-post-comments:hover,
    .sub_title_teepro,
    .text_signature,
    .site-header.teepro-header-2 .top-section-wrap .text-section .start_design,
    .category .style-3 article.type-post .entry-content .entry-title a:hover,
    .demo-shortcode-heading .uvc-main-heading h3,
    .teepro-our-customers .our-customers-wrap .swiper-button-next:hover, 
    .teepro-our-customers .our-customers-wrap .swiper-button-prev:hover,
    .teepro-image-slider .image-slider-block .swiper-button-prev:hover, 
    .teepro-image-slider .image-slider-block .swiper-button-next:hover,
    .shop-main .woocommerce-Reviews #review_form_wrapper .stars a,
    .vc_testimonial_wrap .swiper-button-next:not(.swiper-button-disabled):hover,
    .vc_testimonial_wrap .swiper-button-prev:not(.swiper-button-disabled):hover,
    .about_history_content .vc_toggle_content .about_content_aug .content_right p .about_seemore,
    .vc_testimonial_wrap.testimonial_multi_thumb_zoom_image .vc-content-testimonial .swiper-wrapper .swiper-slide .vc-testimonial-img .vc-testimonial-content .client-position,
    .related-product .relate_content .price,
    .widget .sidebar-policy .clear:nth-of-type(2n+1) i,
    .widget.page-sidebar .menu .menu-item.current-menu-item a,
    .widget.service-sidebar .menu .menu-item.current-menu-item a,
    .widget.service-sidebar .service-info li i,
    .site-footer .footer-abs-middle a,
    .intro_teepro .readmore_teepro,
    .widget.shop-sidebar ul.menu .menu-item-has-children.current-menu-parent > a,
    .widget.shop-sidebar ul.menu .current-menu-item  a,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li a i,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover a,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li.active a,
    .dokan-dashboard.dokan-custom-style .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
    .dokan-dashboard.dokan-custom-style .dokan-dashboard-content .dokan-report-wrap ul.dokan_tabs li:hover a,
    .dokan-dashboard.dokan-custom-style .dokan-dashboard-content .dokan-report-wrap ul.dokan_tabs li.active a,
    .start_designing_1 .vc_btn3-container .vc_general:hover,
    .dokan-dashboard.dokan-custom-style .dokan-dashboard-content .dokan-report-wrap .dokan-reports-sidebar ul.chart-legend li:first-child,
    .dokan-product-listing .dokan-product-listing-area table.product-listing-table td.post-date .status,
    .single-product .single-product-wrap .product-vendor-info .dokan-store-info .store-name a, 
    .single-product #tab-seller .product-vendor-info .dokan-store-info .store-name a,
    .single-product .single-product-wrap .product-vendor-info .dokan-store-info .store-details > a, 
    .nb_wp_post .nb-title-post a:hover,
    .single-product #tab-seller .product-vendor-info .dokan-store-info .store-details > a,
    .single-product-wrap .woocommerce-product-gallery__wrapper .featured-gallery div:not(.swiper-button-disabled):before,
    #dokan-seller-listing-wrap .pagination-container .pagination-wrap .pagination li a:hover,
    #dokan-seller-listing-wrap .pagination-container .pagination-wrap .pagination li a:hover:after,
    #dokan-primary .dokan-store-tabs li a:hover,
    .nbd-gallery #primary .nbd-sidebar .nbd-sidebar-con .nbd-sidebar-con-inner ul li a:hover,
    .dokan-single-seller.store_style-3 .store-wrapper .store-content .store-info .store-lnk .dokan-store-lnk,
    .woocommerce-cart .cart_item .product-name a:hover,
    .nbd-gallery #primary .nbd-sidebar .nbd-sidebar-con .nbd-sidebar-con-inner .nbd-tag:hover,
    .woof_list li:hover > label,
    .woof_list li > input[checked] ~ label,
    .woof_container > .woof_container_inner:hover > label,
    .woof_container > .woof_container_inner > input[checked] ~ label,
    .woof_price_filter li:hover > label,
    .woof_price_filter li > input[checked] ~ label,
    .woof .woof_redraw_zone .woof_container.woof_author_search_container .woof_container .woof_container_inner ul.woof_authors li:hover label,
    .woof .woof_redraw_zone .woof_container.woof_author_search_container .woof_container .woof_container_inner ul.woof_authors li > input[checked] ~ label,
    .products .product .nb-loop-variable .nbtcs-swatches .swatch.swatch-text:hover,
    .products .product .nb-loop-variable .nbtcs-swatches .swatches-radio li:hover .swatch-radio,
    .products .product .nb-loop-variable .nbtcs-swatches .swatches-radio li input[type=radio]:checked ~ label,
    .site-header .sub-navigation .widget .dd-options .dd-option-selected .dd-option-text,
    .site-header .sub-navigation .widget .dd-container:hover .dd-selected label,
    .site-header .sub-navigation .widget .dd-container:hover .dd-selected small,
    .site-header .sub-navigation .widget .dd-container:hover .dd-select .dd-pointer,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .chosen-container .chosen-single:hover span,
    .site-header .sub-navigation .menu-menu-top-left-container ~ .WOOCS_SELECTOR .wSelect .wSelect-selected:hover,
    .error404 main .pnf-heading,
    .error404 main h1
    {
        color: " . esc_attr($primary_color) . ";                
    }
    .text-notice a{
        background-color: " . esc_attr($primary_color) . " !important;
    }
    .nbt-ajax-cart .nbt-ajax-cart-popup ul li .nbt-ajax-cart-right .product-price span,
    .stepbystep2 .wpb_column:hover .step-heading .uvc-main-heading > *{
        color: " . esc_attr($primary_color) . " !important;  
    }
    .new_letter_1 .wpb_raw_code .footer-newsletter .footer-newsletter-form input[type='email']{
        border: 1px solid " . esc_attr($primary_color) . "!important;
    }
    .nb-page-title-wrap.bg_img {
        padding-top: " . esc_attr($page_title_padding) . "px;
        padding-bottom: " . esc_attr($page_title_padding) . "px;            
    }
    .nb-page-title-wrap a, .nb-page-title-wrap h1, .nb-page-title-wrap nav {
        color: " . esc_attr($page_title_color) . ";
    }            
    .nb-page-title-wrap h1 {
        font-size: " . esc_attr($page_title_size) . "px;
        text-transform: uppercase;
    }
    .woocommerce-page.wc-no-sidebar #primary {
        width: 100%;
    }
    .shop-main .products.grid-type .product:nth-child(" . esc_attr($loop_columns) . "n + 1) {
        clear: both;
    }                                   
    ";
    $css .= "
    .footer-top-section {                
        background-color: " . esc_attr($footer_top_bg) . ";
    }
    .footer-top-section h1,
    .footer-top-section h2,
    .footer-top-section h3,
    .footer-top-section h4,
    .footer-top-section h5,
    .footer-top-section h6,
    .footer-top-section .widget-title a{
        color: " . esc_attr($footer_top_heading) . ";
    }
    .footer-top-section,
    .footer-top-section a,
    .footer-top-section .widget ul li a{
        color: " . esc_attr($footer_top_color) . ";
    }
    .footer-top-section .widget .tagcloud a{
        border-color: " . esc_attr($footer_top_color) . ";
    }
    .footer-bot-section{
        background-color: " . esc_attr($footer_bot_bg) . ";
    }
    footer.site-footer .footer-top-section{
        padding-top:".esc_attr($footer_top_padding_top)."px;
        padding-bottom:".esc_attr($footer_top_padding_bottom)."px;
        border-bottom: 1px solid " . esc_attr($footer_top_border_bot_color) . ";
    }
    footer.site-footer .footer-bot-section{
        padding-top:".esc_attr($footer_bot_padding_top)."px;
        padding-bottom:".esc_attr($footer_bot_padding_bottom)."px;
        border-bottom: 1px solid " . esc_attr($footer_bot_border_bot_color) . ";
    }
    .footer-bot-section h1,
    .footer-bot-section h2,
    .footer-bot-section h3,
    .footer-bot-section h4,
    .footer-bot-section h5,
    .footer-bot-section h6,
    .footer-bot-section .widget-title a{
        color: " . esc_attr($footer_bot_heading) . ";
    }
    .footer-bot-section,
    .footer-bot-section a,
    .footer-bot-section .widget ul li a{
        color: " . esc_attr($footer_bot_color) . ";
    }
    .footer-bot-section .widget .tagcloud a{
        border-color: " . esc_attr($footer_bot_color) . ";
    }
    .footer-abs-section{
        color: " . esc_attr($footer_abs_color) . ";
        background-color: " . esc_attr($footer_abs_bg) . ";
        padding-top: " . esc_attr($footer_abs_padding) . "px;
        padding-bottom: " . esc_attr($footer_abs_padding) . "px;
    }
    .footer-abs-section a, .footer-abs-section p {
        color: " . esc_attr($footer_abs_color) . ";
    }
    .single-post .nb-page-title .entry-title,
    .single-post .entry-title{
        font-size: " . esc_attr($blog_title_size) . "px;
    }
    .dokan-store-sidebar #dokan-store-location{
        height: " . $vendor_map_height . "px;
    }
    ";
    if ($page_bg_color) {
        $css .= "
        .page #site-wrapper {
            background-color: " . esc_attr($page_bg_color) . ";
        }
        ";
    }
    if ($page_bg[0]) {
        $css .= "
        .page #site-wrapper {
            background: url(" . esc_url($page_bg[0]) . ") repeat center center / cover; 
        }
        ";
    }
    $css .= "
    @media (min-width: 768px) {
        .shop-main:not(.wide) .single-product-wrap .product-image {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 " . esc_attr($pd_images_width) . "%;
            flex: 0 0 " . esc_attr($pd_images_width) . "%;                   
            max-width: " . esc_attr($pd_images_width) . "%;
        }
        .shop-main:not(.wide) .single-product-wrap .entry-summary {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 calc(100% - " . esc_attr($pd_images_width) . "%);
            flex: 0 0 calc(100% - " . esc_attr($pd_images_width) . "%);                   
            max-width: calc(100% - " . esc_attr($pd_images_width) . "%);
        }
    }
    @media (min-width: 992px) {
        ";

        if ('no-sidebar' !== $blog_sidebar) {
            $css .= "            
            .site-content .blog #primary,
            .site-content .single-blog #primary {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 " . esc_attr($blog_width) . "%;
                flex: 0 0 " . esc_attr($blog_width) . "%;
                max-width: " . esc_attr($blog_width) . "%;
            } 
            .site-content .blog #secondary,
            .site-content .single-blog #secondary {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 calc(100% - " . esc_attr($blog_width) . "%);
                flex: 0 0 calc(100% - " . esc_attr($blog_width) . "%);
                max-width: calc(100% - " . esc_attr($blog_width) . "%);
            }                                  
            ";
        }
        if ('left-sidebar' == $blog_sidebar) {
            $css .= "
            .single-blog #primary, .blog #primary {
                order: 2;
            }
            .single-blog #secondary, .blog #secondary {
                padding-right: 30px;
            }
            ";
        } elseif ('right-sidebar' == $blog_sidebar) {
            $css .= "
            .single-blog #secondary, .blog #secondary {
                padding-left: 30px;
            }
            ";
        }

        if ( class_exists( 'WeDevs_Dokan' ) ) {

            /*Vendor Sidebar*/
            $vendor_width = teepro_get_options('nbcore_vendor_details_width');
            $vendor_sidebar = teepro_get_options('nbcore_vendor_details_sidebar');
            if ('no-sidebar' !== $vendor_sidebar) {
                $css .= '
                    .dokan-store.dk-has-sidebar .shop-main{
                        -webkit-box-flex: 1;
                        -webkit-flex: 1;
                        -ms-flex: 1;
                        flex: 1;
                    }
                    .dokan-store.dk-has-sidebar #secondary{
                        -webkit-box-flex: 0;
                        -ms-flex: 0 0 ' . esc_attr(100 - absint($vendor_width)) . '%;
                        flex: 0 0 ' . esc_attr(100 - absint($vendor_width)) . '%;
                        max-width: ' . esc_attr(100 - absint($vendor_width)) . '%;
                    }
                ';
                if ('left-sidebar' == $vendor_sidebar) {
                    $css .= '
                        .dokan-store.dk-has-sidebar .shop-main {
                            order: 2;
                        }
                    ';
                }
            } else {
                $css .= '
                    .dokan-store.dk-no-sidebar .shop-main {
                        -webkit-box-flex: 0;
                        -ms-flex: 0 0 100%;
                        flex: 0 0 100%;
                        max-width: 100%;
                    }
                ';
            }

            /*Dokan sidebar*/
            if ('no-sidebar' !== $nbcore_dokan_dashboard_sidebar) {
                $css .= "            
                    .site-main .dokan-dashboard-wrap .dokan-dashboard-content
                    {
                        -webkit-box-flex: 0;
                        -ms-flex: 0 0 77%;
                        flex: 0 0 77%;
                        max-width: 77%;
                        
                    } 
                    .dokan-dashboard .site-main .dokan-dashboard-content{width: 77%;}
                    .site-main .dokan-dashboard-wrap .dokan-dash-sidebar {
                        -webkit-box-flex: 0;
                        -ms-flex: 0 0 calc(100% - 77%);
                        flex: 0 0 calc(100% - 77%);
                        max-width: calc(100% - 77%);

                    }                                  
                ";
            }
            if ('left-sidebar' == $nbcore_dokan_dashboard_sidebar) {
                $css .= "
                    .site-main .dokan-dashboard-wrap .dokan-dashboard-content {
                        order: 2;
                    }
                    .site-main .dokan-dashboard-wrap .dokan-dashboard-content {
                        padding-left: 30px;
                    }
                ";
            } elseif ('right-sidebar' == $nbcore_dokan_dashboard_sidebar) {
                $css .= "
                    .site-main .dokan-dashboard-wrap .dokan-dash-sidebar {
                         order: 2;
                    }
                    .site-main .dokan-dashboard-wrap .dokan-dashboard-content{padding-left:0;
                        padding-right: 30px;}
                    
                ";
            }
        }

        /*Pages sidebar*/
        
        if ('no-sidebar' !== $pages_sidebar) {
            $css .= "            
                .page .site-content #primary
                {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 " . esc_attr($page_content_width) . "%;
                    flex: 0 0 " . esc_attr($page_content_width) . "%;                 
                    max-width: " . esc_attr($page_content_width) . "%;
                    
                } 
                .page .site-content #primary{width: 70%;}
                .page .site-content #secondary {
                    -webkit-box-flex: 0;
                    -ms-flex: 0 0 calc(100% - " . esc_attr($page_content_width) . "%);
                    flex: 0 0 calc(100% - " . esc_attr($page_content_width) . "%);              
                    max-width: calc(100% - " . esc_attr($page_content_width) . "%);

                }                                  
            ";
        }
        if ('left-sidebar' == $pages_sidebar) {
            $css .= "
                .page .site-content #primary {
                    order: 2;
                }
              
            ";
        } elseif('right-sidebar' == $pages_sidebar) {
            $css .= "
                .page .site-content #secondary {
                    order: 2;
                }
                
            ";
        }


        if ('left-sidebar' == $shop_sidebar) {
            $css .= "
            .archive.woocommerce .shop-main {
                order: 2;
            }
            .archive.woocommerce #secondary {
                padding-right: 30px;
                padding-left: 15px;
                z-index: 0;
            }
            ";
        } elseif('right-sidebar' == $shop_sidebar) {
            $css .= "
            .archive.woocommerce #secondary {
                padding-left: 30px;
                padding-right: 15px;
            }
            ";
        }

        if ('left-sidebar' == $pd_details_sidebar) {
            $css .= "
            .single-product .shop-main {
                order: 2;
            }
            .single-product #secondary {
                padding-right: 30px;
            }
            ";
        } elseif('right-sidebar' == $pd_details_sidebar) {
            $css .= "
            .single-product #secondary {
                padding-left: 30px;
            }
            ";
        }
        if ('no-sidebar' !== $pd_details_sidebar) {
            $css .= "
            .single-product.wc-pd-has-sidebar .shop-main {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 " . esc_attr($pd_details_width) . "%;
                flex: 0 0 " . esc_attr($pd_details_width) . "%;
                max-width: " . esc_attr($pd_details_width) . "%;
            }
            .single-product #secondary {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 calc(100% - " . esc_attr($pd_details_width) . "%);
                flex: 0 0 calc(100% - " . esc_attr($pd_details_width) . "%);
                max-width: calc(100% - " . esc_attr($pd_details_width) . "%);
            }
            ";
        }
        // TODO check this for tag ... ?
        if ('no-sidebar' !== $shop_sidebar) {
            $css .= "
            .archive.woocommerce.wc-left-sidebar .shop-main,
            .archive.woocommerce.wc-right-sidebar .shop-main {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 " . esc_attr($wc_content_width) . "%;
                flex: 0 0 " . esc_attr($wc_content_width) . "%;
                max-width: " . esc_attr($wc_content_width) . "%;
            }
            .archive.woocommerce.wc-left-sidebar #secondary,
            .archive.woocommerce.wc-right-sidebar #secondary {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 calc(100% - " . esc_attr($wc_content_width) . "%);
                flex: 0 0 calc(100% - " . esc_attr($wc_content_width) . "%);
                max-width: calc(100% - " . esc_attr($wc_content_width) . "%);
            }
            ";
        } else {
            $css .= "
            .site-content .shop-main {
                -webkit-box-flex: 0;
                -ms-flex: 0 0 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }
            ";
        }

        $css .= "
    }
    ";

    return $css;
}

public function print_embed_style()
{
    if (class_exists( 'NetbaseCustomizeClass', false ) ) {
        if(!empty(get_transient('change_customize_css'))) {
            if(get_transient('change_customize_css')==1) {
                set_transient('change_customize_css', 0, NBT_TIMEOUT_TRANSIENT_CUSTOMIZE);
                $style = $this->get_embed_style();
                $style = preg_replace('#/\*.*?\*/#s', '', $style);
                $style = preg_replace('/\s*([{}|:;,])\s+/', '$1', $style);
                $style = preg_replace('/\s\s+(.*)/', '$1', $style);
                if(get_option('customize_save_css')==false) {
                    add_option( 'customize_save_css', $style, '', 'yes' );
                } else {
                    update_option( 'customize_save_css', $style );
                }
                $cp = new NetbaseCustomizeClass();
                $cp->save_css_customize();
            }
        }
    }
    $my_transient = get_transient('current_load_css');
    if(empty($my_transient) || !$this->is_plugin_active_byme('nb-fw/nb-fw.php')) {
        $this->print_style_head();
    } else {
        if($my_transient==NBT_LOAD_CUSTOMIZE_FROM_HEAD) {
            $this->print_style_head();
        } else {
            if($my_transient==NBT_LOAD_CUSTOMIZE_FROM_CSS_FILE && file_exists(NBT_REAL_PATH_TEMPLATE . NBT_CSS_CUSTOMIZE_PATH . NBT_CSS_CUSTOMIZE_NAME)) {
                wp_enqueue_style('customize', get_template_directory_uri() . NBT_CSS_CUSTOMIZE_PATH . NBT_CSS_CUSTOMIZE_NAME, array(), TEEPRO_VER);
            } else {
                set_transient('current_load_css', NBT_LOAD_CUSTOMIZE_FROM_HEAD, NBT_TIMEOUT_TRANSIENT_CUSTOMIZE);
                $this->print_style_head();
            }
        }
    }
}

public function print_style_head() {

    $style = $this->get_embed_style();

    $style = preg_replace('#/\*.*?\*/#s', '', $style);
    $style = preg_replace('/\s*([{}|:;,])\s+/', '$1', $style);
    $style = preg_replace('/\s\s+(.*)/', '$1', $style);

    wp_add_inline_style('nbcore_front_style', $style);
}

function is_plugin_active_byme( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}

public function filter_fonts($font)
{
    $font_args = explode(",", teepro_get_options($font));
    if($font_args[0] === 'google') {
        $this->handle_google_font($font_args[1]);
    } elseif($font_args[0] === 'custom') {
        $this->handle_custom_font($font_args[1]);
    } elseif($font_args[0] === 'standard') {
        $this->handle_standard_font($font_args[1]);
    }
}

public function handle_google_font($font_name)
{
    $font_subset = 'latin,latin-ext';
    $font_families = array();
    $google_fonts = Teepro_Helper::google_fonts();
    $font_parse = array();


    $font_weight = $google_fonts[$font_name];
    $font_families[$font_name] = isset($font_families[$font_name]) ? array_unique(array_merge($font_families[$font_name], $font_weight)) : $font_weight;

    foreach ($font_families as $font => $font_weight) {
        $font_parse[] = $font . ':' . implode(',', $font_weight);
    }

    if (teepro_get_options('subset_cyrillic')) {
        $font_subset .= ',cyrillic,cyrillic-ext';
    }
    if (teepro_get_options('subset_greek')) {
        $font_subset .= ',greek,greek-ext';
    }
    if (teepro_get_options('subset_vietnamese')) {
        $font_subset .= ',vietnamese';
    }

    $query_args = array(
        'family' => urldecode(implode('|', $font_parse)),
        'subset' => urldecode($font_subset),
    );

    $font_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

    $enqueue = esc_url_raw($font_url);

    wp_enqueue_style('nb-google-fonts', $enqueue);
}

public function google_fonts_url()
{
    $gg_font_arr = array();
    $gg_font_parse = array();
    $google_fonts = Teepro_Helper::google_fonts();
    $gg_subset = 'latin,latin-ext';

    $body_font = explode(',', teepro_get_options('body_font_family'));
    $heading_font = explode(',', teepro_get_options('heading_font_family'));

    if($body_font[0] === 'google') {
        $body_name = $body_font[1];
        $body_weight = $google_fonts[$body_name];
        $gg_font_arr[$body_name] = isset($gg_font_arr[$body_name]) ? array_unique(array_merge($gg_font_arr[$body_name], $body_weight)) : $body_weight;
    }

    if($heading_font[0] === 'google') {
        $heading_name = $heading_font[1];
        $heading_weight = $google_fonts[$heading_name];
        $gg_font_arr[$heading_name] = isset($gg_font_arr[$heading_name]) ? array_unique(array_merge($gg_font_arr[$heading_name], $heading_weight)) : $heading_weight;
    }

    if(!empty($gg_font_arr)) {
        foreach ($gg_font_arr as $gg_font_name => $gg_font_weight) {
            $gg_font_parse[] = $gg_font_name . ':' . implode(',', $gg_font_weight);
        }

        if (teepro_get_options('subset_cyrillic')) {
            $gg_subset .= ',cyrillic,cyrillic-ext';
        }
        if (teepro_get_options('subset_greek')) {
            $gg_subset .= ',greek,greek-ext';
        }
        if (teepro_get_options('subset_vietnamese')) {
            $gg_subset .= ',vietnamese';
        }

        $query_args = array(
            'family' => urldecode(implode('|', $gg_font_parse)),
            'subset' => urldecode($gg_subset),
        );

        $font_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');

        $enqueue = esc_url_raw($font_url);

        wp_enqueue_style('nb-google-fonts', $enqueue);
    }
}

public function upload_mimes($t)
{
        // Add supported font extensions and MIME types.
    $t['eot'] = 'application/vnd.ms-fontobject';
    $t['otf'] = 'application/x-font-opentype';
    $t['ttf'] = 'application/x-font-ttf';
    $t['woff'] = 'application/font-woff';
    $t['woff2'] = 'application/font-woff2';

    return $t;
}

public function setup_helper_popup()
{
    if(!get_transient('nbt_first_time_setup')) {
        set_transient('nbt_first_time_setup' , 1);
    }
}

public static function remove_ctp_feed() {
    if ( is_post_type_archive('service') || is_singular('service') ) {
        remove_action('wp_head', 'feed_links_extra', 3 );
        remove_action('wp_head', 'feed_links', 2 );
    }
}

}
new Teepro_Core();