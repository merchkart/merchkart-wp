<?php
 
class Teepro_Admin
{
    protected $plugins;

    protected $tgmpa;

    protected $package;

    public function __construct()
    {
        $this->tgmpa        = isset($GLOBALS['tgmpa']) ? $GLOBALS['tgmpa'] : TGM_Plugin_Activation::get_instance();
        $this->package      = wp_get_theme(get_template())->get('Tags');

        add_action('admin_enqueue_scripts', array($this, 'admin_scripts_enqueue'));

        if( in_array('nb-advanced', $this->package) || in_array('nb-premium', $this->package) || in_array('nb-enterprise', $this->package) ) {
            add_action( 'tgmpa_register', array($this, 'register_required_plugins') );
        }
        else {
            add_action( 'tgmpa_register', array($this, 'register_required_plugins_tf') );
        }
        add_action('wp_ajax_nbt_install_framework', array($this, 'ajax_install_framework'));
        add_action('wp_ajax_nbt_active_framework', array($this, 'ajax_active_framework'));

    }

    public function admin_scripts_enqueue()
    {

        if(is_customize_preview()){
            wp_enqueue_style('fontello-admin', get_template_directory_uri() . '/assets/vendor/fontello/fontello.css', array(), TEEPRO_VER);
        }

        if ( teepro_get_options( 'nbcore_pd_show_size_guide' ) ) {
            wp_enqueue_style('teepro-edittable-css', get_template_directory_uri() . '/assets/vendor/edit-table/jquery.edittable.min.css', array(), TEEPRO_VER);

            wp_enqueue_script( 'teepro-edittable-scripts', get_template_directory_uri() . '/assets/vendor/edit-table/jquery.edittable.min.js', array(), TEEPRO_VER, true );
            
            wp_enqueue_script( 'teepro-admin-scripts', get_template_directory_uri() . '/assets/netbase/js/admin/admin.js', array(), TEEPRO_VER, true );
            
		}

    }


    public function register_required_plugins()
    {

        $required = array(
            array(
                'name' 		        => 'Woocommerce',
                'slug' 		        => 'woocommerce',
                'required' 	        => true,
                'version' 	        => '3.6.1',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Compare',
                'slug' 		        => 'yith-woocommerce-compare',
                'required' 	        => true,
                'version' 	        => '2.3.7',
            ),
            array(
                'name' 		        => 'Contact Form 7',
                'slug' 		        => 'contact-form-7',
                'required' 	        => false,
                'version' 	        => '5.1.1',
            ),
            array(
                'name' 		        => 'MailChimp for WordPress',
                'slug' 		        => 'mailchimp-for-wp',
                'required' 	        => false,
                'version' 	        => '4.3.2',
            ),
            array(
                'name' 		        => 'Max Mega Menu',
                'slug' 		        => 'megamenu',
                'required' 	        => true,
                'version' 	        => '2.5.3.2',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Wishlist',
                'slug' 		        => 'yith-woocommerce-wishlist',
                'required' 	        => true,
                'version' 	        => '2.2.5',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Quick View',
                'slug' 		        => 'yith-woocommerce-quick-view',
                'required' 	        => true,
                'version' 	        => '1.3.6',
            ),
            array(
                'name'              => 'Netbase Framework',
                'slug'              => 'nb-fw',
                'required'          => true,
                'version'           => '1.4.4',
                'source'            => esc_url('http://demo9.cmsmart.net/plugins/teepro/nb-fw.zip'),
            ),
            array(
                'name' 		        => 'Slider Revolution',
                'slug' 		        => 'revslider',
                'required' 	        => true,
                'version' 	        => '5.4.8.3',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/revslider.zip'),
            ),
            array(
                'name' 		        => 'WPBakery Visual Composer',
                'slug' 		        => 'js_composer',
                'required'          => true,
                'version' 	        => '6.0.3',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/js_composer.zip'),
            ),
            array(
                'name' 		        => 'Ultimate VC Addons',
                'slug' 		        => 'Ultimate_VC_Addons',
                'required' 	        => true,
                'version' 	        => '3.18.0',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/Ultimate_VC_Addons.zip'),
            ),
            array(
                'name' 		        => 'Netbase Solutions',
                'slug' 		        => 'netbase_solutions',
                'required' 	        => true,
                'version' 	        => '1.5.4',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/netbase_solutions.zip'),
            ),
            array(
                'name' 		        => 'Max Mega Menu Pro',
                'slug' 		        => 'megamenu-pro',
                'required' 	        => true,
                'version' 	        => '1.3.12',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/megamenu-pro.zip'),
            ),             
            array(
                'name' 		        => 'Teepro elements',
                'slug' 		        => 'teepro-elements',
                'required' 	        => true,
                'version' 	        => '1.1.1',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/teepro-elements.zip'),
            ),
            array(
                'name' 		        => 'WooCommerce Products Filter',
                'slug' 		        => 'woocommerce-products-filter',
                'required' 	        => true,
                'version' 	        => '2.2.2.1',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/woocommerce-products-filter.zip'),
            )
        );
        
        $advance = array(
            array(
                'name'              => 'Netbase Dashboard',
                'slug'              => 'netbase_dashboard',
                'required'          => false,
                'version'           => '1.1.4',
                'source'            => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/netbase_dashboard.zip'),
            )
        );
        
        $premium = array(
            array(
                'name'              => 'Nbdesigner',
                'slug'              => 'web-to-print-online-designer',
                'required'          => true,
                'version'           => '2.4.0',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/web-to-print-online-designer.zip'),
            ),
        );
        
        $enterprise = array(
            array(
                'name'              => 'Dokan',
                'slug'              => 'dokan-lite',
                'required'          => true,
                'version'           => '2.9.12',
            ),
            array(
                'name'              => 'Dokan Pro',
                'slug'              => 'dokan-pro',
                'required'          => true,
                'version'           => '2.9.9',
                'source'            => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/dokan-pro.zip'),
            )
        );
        
        $this->plugins = $required;
        
        if( in_array('nb-advanced', $this->package) ) {
            $this->plugins = array_merge($required, $advance);
        }
        
        if( in_array('nb-premium', $this->package) ) {
            $this->plugins = array_merge($required, $advance, $premium);
        }
        
        if( in_array('nb-enterprise', $this->package) ) {
            $this->plugins = array_merge($required, $advance, $premium, $enterprise);
        }

        $config = array(
            'id'           => 'core-wp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );

        tgmpa( $this->plugins, $config );
    }

    public function register_required_plugins_tf()
    {

        $required = array(
            array(
                'name' 		        => 'Woocommerce',
                'slug' 		        => 'woocommerce',
                'required' 	        => true,
                'version' 	        => '3.6.1',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Compare',
                'slug' 		        => 'yith-woocommerce-compare',
                'required' 	        => true,
                'version' 	        => '2.3.7',
            ),
            array(
                'name' 		        => 'Contact Form 7',
                'slug' 		        => 'contact-form-7',
                'required' 	        => false,
                'version' 	        => '5.1.1',
            ),
            array(
                'name' 		        => 'MailChimp for WordPress',
                'slug' 		        => 'mailchimp-for-wp',
                'required' 	        => false,
                'version' 	        => '4.3.2',
            ),
            array(
                'name' 		        => 'Max Mega Menu',
                'slug' 		        => 'megamenu',
                'required' 	        => true,
                'version' 	        => '2.5.3.2',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Wishlist',
                'slug' 		        => 'yith-woocommerce-wishlist',
                'required' 	        => true,
                'version' 	        => '2.2.5',
            ),
            array(
                'name' 		        => 'YITH WooCommerce Quick View',
                'slug' 		        => 'yith-woocommerce-quick-view',
                'required' 	        => true,
                'version' 	        => '1.3.6',
            ),
            array(
                'name'              => 'Dokan',
                'slug'              => 'dokan-lite',
                'required'          => true,
                'version'           => '2.9.12',
            ),
            array(
                'name'              => 'Netbase Framework',
                'slug'              => 'nb-fw',
                'required'          => true,
                'version'           => '1.4.4',
                'source'            => esc_url('http://demo9.cmsmart.net/plugins/teepro/nb-fw.zip'),
            ),
            array(
                'name' 		        => 'Slider Revolution',
                'slug' 		        => 'revslider',
                'required' 	        => true,
                'version' 	        => '5.4.8.3',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/revslider.zip'),
            ),
            array(
                'name' 		        => 'WPBakery Visual Composer',
                'slug' 		        => 'js_composer',
                'required'          => true,
                'version' 	        => '6.0.3',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/js_composer.zip'),
            ),
            array(
                'name' 		        => 'Ultimate VC Addons',
                'slug' 		        => 'Ultimate_VC_Addons',
                'required' 	        => true,
                'version' 	        => '3.18.0',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/Ultimate_VC_Addons.zip'),
            ),
            array(
                'name' 		        => 'Netbase Solutions',
                'slug' 		        => 'netbase_solutions',
                'required' 	        => true,
                'version' 	        => '1.5.4',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/tf/netbase_solutions.zip'),
            ),
            array(
                'name' 		        => 'Max Mega Menu Pro',
                'slug' 		        => 'megamenu-pro',
                'required' 	        => true,
                'version' 	        => '1.3.12',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/printshop-solution/megamenu-pro.zip'),
            ),             
            array(
                'name' 		        => 'Teepro elements',
                'slug' 		        => 'teepro-elements',
                'required' 	        => true,
                'version' 	        => '1.1.1 ',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/teepro-elements.zip'),
            ),
            array(
                'name' 		        => 'WooCommerce Products Filter',
                'slug' 		        => 'woocommerce-products-filter',
                'required' 	        => true,
                'version' 	        => '2.2.2.1',
                'source' 	        => esc_url('http://demo9.cmsmart.net/plugins/teepro/woocommerce-products-filter.zip'),
            ),
            array(
                'name'              => 'Nbdesigner',
                'slug'              => 'web-to-print-online-designer',
                'required'          => true,
                'version'           => '2.2.0'
            ),
        );
        
        
        $this->plugins = $required;

        $config = array(
            'id'           => 'core-wp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
        );

        tgmpa( $this->plugins, $config );
    }

    public function ajax_install_framework()
    {
        if (!check_ajax_referer('nbt_nonce', 'wpnonce') || empty($_POST['slug'])) {
            exit(0);
        }

        $json = array();
        $tgmpa_url = $this->tgmpa->get_tgmpa_url();

        if($_POST['slug'] === 'install') {
            $json = array(
                'url' => $tgmpa_url,
                'plugin' => array('nb-fw'),
                'tgmpa-page' => $this->tgmpa->menu,
                '_wpnonce' => wp_create_nonce('bulk-plugins'),
                'action' => 'tgmpa-bulk-install',
                'action2' => - 1,
                'message' => esc_html__('Installing', 'teepro'),
            );
        } elseif($_POST['slug'] === 'active') {
            $json = array(
                'url' => $tgmpa_url,
                'plugin' => array('nb-fw'),
                'tgmpa-page' => $this->tgmpa->menu,
                '_wpnonce' => wp_create_nonce('bulk-plugins'),
                'action' => 'tgmpa-bulk-activate',
                'action2' => - 1,
                'message' => esc_html__('Activating', 'teepro'),
            );
        }

        if($json) {
            wp_send_json($json);
        } else {
            wp_send_json(array('done' => 1, 'message' => esc_html__('Success', 'teepro')));
        }

        exit;
    }
}