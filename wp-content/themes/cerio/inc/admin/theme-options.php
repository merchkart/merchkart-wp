<?php
/**
 * Cerio Settings Options
 */
if (!class_exists('Redux_Framework_cerio_settings')) {
    class Redux_Framework_cerio_settings {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
			$custom_font = cerio_get_config('custom_font',false);
			if($custom_font != 1){
				remove_action( 'wp_head', array( $this->ReduxFramework, '_output_css' ),150 );
			}
        }
        function compiler_action($options, $css, $changed_values) {
        }
        function dynamic_section($sections) {
            return $sections;
        }
        function change_arguments($args) {
            return $args;
        }
        function change_defaults($defaults) {
            return $defaults;
        }
        function remove_demo() {
        }
        public function setSections() {
            $page_layouts = cerio_options_layouts();
            $sidebars = cerio_options_sidebars();
            $cerio_header_type = cerio_options_header_types();
            $cerio_banners_effect = cerio_options_banners_effect();
            // General Settings  ------------
            $this->sections[] = array(
                'icon' => 'fa fa-home',
                'icon_class' => 'icon',
                'title' => esc_html__('General', 'cerio'),
                'fields' => array(                
                )
            );  
            // Layout Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'cerio'),
                'fields' => array(
                    array(
                        'id' => 'background_img',
                        'type' => 'media',
                        'title' => esc_html__('Background Image', 'cerio'),
                        'sub_desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id'=>'show-newletter',
                        'type' => 'switch',
                        'title' => esc_html__('Show Newletter Form', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Show', 'cerio'),
                        'off' => esc_html__('Hide', 'cerio'),
                    ),
                    array(
                        'id' => 'background_newletter_img',
                        'type' => 'media',
                        'title' => esc_html__('Popup Newletter Image', 'cerio'),
                        'url'=> true,
                        'readonly' => false,
                        'sub_desc' => '',
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/newsletter-image.jpg'
                        )
                    ),
                    array(
                            'id' => 'back_active',
                            'type' => 'switch',
                            'title' => esc_html__('Back to top', 'cerio'),
                            'sub_desc' => '',
                            'desc' => '',
                            'default' => '1'// 1 = on | 0 = off
                            ),                          
                    array(
                            'id' => 'direction',
                            'type' => 'select',
                            'title' => esc_html__('Direction', 'cerio'),
                            'options' => array( 'ltr' => esc_html__('Left to Right', 'cerio'), 'rtl' => esc_html__('Right to Left', 'cerio') ),
                            'default' => 'ltr'
                        )        
                )
            );
            // Logo & Icons Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo & Icons', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'sitelogo',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Logo', 'cerio'),
                        'desc'      => esc_html__('Upload Logo image default here.', 'cerio'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo/logo.png'
                        )
                    )
                )
            );
			//Vertical Menu
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'subsection' => true,
                'title' => esc_html__('Vertical Menu', 'cerio'),
                'fields' => array( 
                    array(
                        'id'        => 'max_number_1530',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on screen >= 1530px', 'cerio'),
                        'default'   => '12'
                    ),
                    array(
                        'id'        => 'max_number_1200',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 1200px', 'cerio'),
                        'default'   => '8'
                    ),
					array(
                        'id'        => 'max_number_991',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 991px', 'cerio'),
                        'default'   => '6'
                    )
                )
            );
            // Header Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Header', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'header_style',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Header Type', 'cerio'),
                        'options' => $cerio_header_type,
                        'default' => '4'
                    ),
                    array(
                        'id'=>'show-header-top',
                        'type' => 'switch',
                        'title' => esc_html__('Show Header Top', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'show-searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Form', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'show-ajax-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Ajax Search', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio')
                    ),
                    array(
                        'id'=>'limit-ajax-search',
                        'type' => 'text',
                        'title' => esc_html__('Limit Of Result Search', 'cerio'),
						'default' => 6,
						'required' => array('show-ajax-search','equals',true)
                    ),					
                    array(
                        'id'=>'search-cats',
                        'type' => 'switch',
                        'title' => esc_html__('Show Categories', 'cerio'),
                        'required' => array('search-type','equals',array('post', 'product')),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'show-wishlist',
                        'type' => 'switch',
                        'title' => esc_html__('Show Wishlist', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
					array(
                        'id'=>'show-menutop',
                        'type' => 'switch',
                        'title' => esc_html__('Show Menu Top', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
					array(
                        'id'=>'show-currency',
                        'type' => 'switch',
                        'title' => esc_html__('Show Currency', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
					array(
                        'id'=>'show-compare',
                        'type' => 'switch',
                        'title' => esc_html__('Show Compare', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
					array(
                        'id'=>'show-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
					array(
                        'id'=>'cart-style',
						'type' => 'button_set',
                        'title' => esc_html__('Cart Style', 'cerio'),
                        'options' => array('dropdown' => esc_html__('Dropdown', 'cerio'),
											'popup' => esc_html__('Popup', 'cerio')),
						'default' => 'popup',
						'required' => array('show-minicart','equals',true),
                    ),
                    array(
                        'id'=>'enable-sticky-header',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Header', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),		
                    array(
                        'id'=>'phone',
                        'type' => 'text',
                        'title' => esc_html__('Header Phone', 'cerio'),
                        'default' => ''
                    ),
					 array(
                        'id'=>'shipping',
                        'type' => 'text',
                        'title' => esc_html__('Header Ship', 'cerio'),
                        'default' => ''
                    ),
					array(
                        'id'=>'email',
                        'type' => 'text',
                        'title' => esc_html__('Header Email', 'cerio'),
                        'default' => ''
                    ),
					array(
                        'id'=>'address',
                        'type' => 'text',
                        'title' => esc_html__('Header Address', 'cerio'),
                        'default' => ''
                    ),
					array(
                        'id'=>'ship',
                        'type' => 'text',
                        'title' => esc_html__('Shipping', 'cerio'),
                        'default' => ''
                    ),
					array(
                        'id'=>'sale',
                        'type' => 'text',
                        'title' => esc_html__('Order Sale', 'cerio'),
                        'default' => ''
                    ),
                )
            );
            // Footer Settings
            $footers = cerio_get_footers();
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Footer', 'cerio'),
                'fields' => array(
                    array(
                        'id' => 'footer_style',
                        'type' => 'image_select',
                        'title' => esc_html__('Footer Style', 'cerio'),
                        'sub_desc' => esc_html__( 'Select Footer Style', 'cerio' ),
                        'desc' => '',
                        'options' => $footers,
                        'default' => '32'
                    ),
                )
            );
            // Copyright Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Copyright', 'cerio'),
                'fields' => array(
                    array(
                        'id' => "footer-copyright",
                        'type' => 'textarea',
                        'title' => esc_html__('Copyright', 'cerio'),
                        'default' => sprintf( wp_kses('&copy; Copyright %s. All Rights Reserved.', 'cerio'), date('Y') )
                    ),
                    array(
                        'id'=>'footer-payments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Payments Logos', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'footer-payments-image',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Payments Image', 'cerio'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/payments.png'
                        )
                    ),
                    array(
                        'id'=>'footer-payments-image-alt',
                        'type' => 'text',
                        'title' => esc_html__('Payments Image Alt', 'cerio'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'footer-payments-link',
                        'type' => 'text',
                        'title' => esc_html__('Payments Link URL', 'cerio'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    )
                )
            );
            // Page Title Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Page Title', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'page_title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page Title', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'page_title_bg',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Background', 'cerio'),
                        'required' => array('page_title','equals', true),
	                    'default' => array(
                            'url' => "",
                        )							
                    ),
                    array(
                        'id' => 'breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Show Breadcrumb', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                        'required' => array('page_title','equals', true),
                    ),
                )
            );
            // 404 Page Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('404 Error', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'title-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'cerio'),
                        'desc' => esc_html__('Input a block slug name', 'cerio'),
                        'default' => '404'
                    ),
					array(
                        'id'=>'sub-title',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'cerio'),
                        'desc' => esc_html__('Input a block slug name', 'cerio'),
                        'default' => "Oops! That page can't be found."
                    ), 					
                    array(
                        'id'=>'sub-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'cerio'),
                        'desc' => esc_html__('Input a block slug name', 'cerio'),
                        'default' => 'Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.'
                    ),               
                    array(
                        'id'=>'btn-error',
                        'type' => 'text',
                        'title' => esc_html__('Button Page 404', 'cerio'),
                        'desc' => esc_html__('Input a block slug name', 'cerio'),
                        'default' => 'Go To Home'
                    )                      
                )
            );
            // Social Share Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Social Share', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'social-share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Links', 'cerio'),
                        'desc' => esc_html__('Show social links in post and product, page, portfolio, etc.', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'share-fb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Facebook Share', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'share-tw',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Twitter Share', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'share-linkedin',
                        'type' => 'switch',
                        'title' => esc_html__('Enable LinkedIn Share', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'share-pinterest',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Pinterest Share', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                )
            );
            $this->sections[] = array(
				'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Socials Link', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'socials_link',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Socials link', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'link-fb',
                        'type' => 'text',
                        'title' => esc_html__('Enter Facebook link', 'cerio'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-tw',
                        'type' => 'text',
                        'title' => esc_html__('Enter Twitter link', 'cerio'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-linkedin',
                        'type' => 'text',
                        'title' => esc_html__('Enter LinkedIn link', 'cerio'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-youtube',
                        'type' => 'text',
                        'title' => esc_html__('Enter Youtube link', 'cerio'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Enter Pinterest link', 'cerio'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-instagram',
                        'type' => 'text',
                        'title' => esc_html__('Enter Instagram link', 'cerio'),
						'default' => '#'
                    ),
                )
            );			
            //     The end -----------
            // Styling Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-brand-appstore',
                'icon_class' => 'icon',
                'title' => esc_html__('Styling', 'cerio'),
                'fields' => array(              
                )
            );  
            // Color & Effect Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Color & Effect', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'compile-css',
                        'type' => 'switch',
                        'title' => esc_html__('Compile Css', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),					
                    array(
                      'id' => 'main_theme_color',
                      'type' => 'color',
                      'title' => esc_html__('Main Theme Color', 'cerio'),
                      'subtitle' => esc_html__('Select a main color for your site.', 'cerio'),
                      'default' => '#222222',
                      'transparent' => false,
					  'required' => array('compile-css','equals',array(true)),
                    ),      
                    array(
                        'id'=>'show-loading-overlay',
                        'type' => 'switch',
                        'title' => esc_html__('Loading Overlay', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Show', 'cerio'),
                        'off' => esc_html__('Hide', 'cerio'),
                    ),
                    array(
                        'id'=>'banners_effect',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Banner Effect', 'cerio'),
                        'options' => $cerio_banners_effect,
                        'default' => 'banners-effect-1'
                    )                   
                )
            );
            // Typography Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Typography', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'custom_font',
                        'type' => 'switch',
                        'title' => esc_html__('Custom Font', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),				
                    array(
                        'id'=>'select-google-charset',
                        'type' => 'switch',
                        'title' => esc_html__('Select Google Font Character Sets', 'cerio'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
						'required' => array('custom_font','equals',true),
                    ),
                    array(
                        'id'=>'google-charsets',
                        'type' => 'button_set',
                        'title' => esc_html__('Google Font Character Sets', 'cerio'),
                        'multi' => true,
                        'required' => array('select-google-charset','equals',true),
                        'options'=> array(
                            'cyrillic' => 'Cyrrilic',
                            'cyrillic-ext' => 'Cyrrilic Extended',
                            'greek' => 'Greek',
                            'greek-ext' => 'Greek Extended',
                            'khmer' => 'Khmer',
                            'latin' => 'Latin',
                            'latin-ext' => 'Latin Extneded',
                            'vietnamese' => 'Vietnamese'
                        ),
                        'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
                    ),
                    array(
                        'id'=>'family_font_body',
                        'type' => 'typography',
                        'title' => esc_html__('Body Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
						'output'      => array('body'),
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h1-font',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' 	=> false,
						'output'      => array('body h1'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'36px',
                            'line-height' => '44px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h2-font',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h2'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'300',
                            'font-family'=>'Open Sans',
                            'font-size'=>'30px',
                            'line-height' => '40px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h3-font',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h3'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'25px',
                            'line-height' => '32px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h4-font',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h4'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'20px',
                            'line-height' => '27px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h5-font',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h5'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'600',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
						'required' => array('custom_font','equals',true)
                    ),
                    array(
                        'id'=>'h6-font',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Font', 'cerio'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h6'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
						'required' => array('custom_font','equals',true)
                    )
                )
            );
            //     The end -----------          
            if ( class_exists( 'Woocommerce' ) ) :
                $this->sections[] = array(
                    'icon' => 'icofont icofont-cart-alt',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Ecommerce', 'cerio'),
                    'fields' => array(              
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product Archives', 'cerio'),
                    'fields' => array(
                        array(
                            'id'=>'category_style',
                            'title' => esc_html__('Product Archives Style', 'cerio'),
                            'type' => 'select',
							'options' => array(
								'default' => esc_html__('Filter Default', 'cerio'),
                                'sidebar' => esc_html__('Sidebar', 'cerio'),       
                                'filter_drawer' => esc_html__('Filter Drawer', 'cerio'),
								'filter_dropdown' => esc_html__('Filter Dropdown', 'cerio'),
								'filter_offcanvas' => esc_html__('Filter Off Canvas', 'cerio'),
								'only_categories' => esc_html__('Shop Only Categories', 'cerio'),
                             ),
                            'default' => 'sidebar',
                        ),
						array(
                            'id'=>'shop_background',
                            'type' => 'switch',
                            'title' => esc_html__('Show Background Shop', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
						  'id' => 'shop_background_color',
						  'type' => 'color',
						  'title' => esc_html__('Background Shop Color', 'cerio'),
						  'subtitle' => esc_html__('Select a shop color for shop page.', 'cerio'),
						  'default' => '#f5f5f5',
						  'transparent' => false,
						  'required' => array('shop_background','equals',array(true)),
						),
						array(
                            'id'=>'show-subcategories',
                            'type' => 'switch',
                            'title' => esc_html__('Show Sub Categories', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'style-subcategories',
							'title' => esc_html__('Style Sub Categories', 'cerio'),
                            'type' => 'select',
							'options' => array(
								'shop_mini_categories' => esc_html__('Mini Categories', 'cerio'),
								'icon_categories' => esc_html__('Icon Categories', 'cerio'),
								'image_categories' => esc_html__('Image Categories', 'cerio'),
                             ),
                            'default' => 'mini',
							'required' => array('show-subcategories','equals','1'),
                        ),
						array(
                            'id'=>'layout_shop',
							'title' => esc_html__('Style Layout Shop', 'cerio'),
                            'type' => 'button_set',
							'options' => array(
								'1' => esc_html__('Style 1', 'cerio'),
								'2' => esc_html__('Style 2', 'cerio'),
								'3' => esc_html__('Style 3', 'cerio'),
								'4' => esc_html__('Style 4', 'cerio'),
								'5' => esc_html__('Style 5', 'cerio'),
								'6' => esc_html__('Style 6', 'cerio'),
								'7' => esc_html__('Style 7', 'cerio'),
                             ),
                            'default' => '1',
                        ),
                        array(
                            'id' => 'sub_col_large',
                            'type' => 'button_set',
                            'title' => esc_html__('Sub Categories column Desktop', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',  
									'5' => '5',
                                    '6' => '6'                          
                                ),
                            'default' => '4',
							'required' => array('show-subcategories','equals','1'),
                            'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'cerio' ),
                        ),
                        array(
                            'id' => 'sub_col_medium',
                            'type' => 'button_set',
                            'title' => esc_html__('Sub Categories column Medium Desktop', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',  
									'5' => '5',
                                    '6' => '6'                          
                                ),
                            'default' => '3',
							'required' => array('show-subcategories','equals','1'),
                            'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'cerio' ),
                        ),
                        array(
                            'id' => 'sub_col_sm',
                            'type' => 'button_set',
                            'title' => esc_html__('Sub Categories column Ipad Screen', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',  
									'5' => '5',
                                    '6' => '6'                          
                                ),
                            'default' => '3',
							'required' => array('show-subcategories','equals','1'),
                            'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'cerio' ),
                        ),						
                        array(
                            'id'=>'category-view-mode',
                            'type' => 'button_set',
                            'title' => esc_html__('View Mode', 'cerio'),
                            'options' => cerio_ct_category_view_mode(),
                            'default' => 'grid',
                        ),
                        array(
                            'id' => 'product_col_large',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Desktop', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '4',
							'required' => array('category-view-mode','equals','grid'),
                            'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'cerio' ),
                        ),
                        array(
                            'id' => 'product_col_medium',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Medium Desktop', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
							'required' => array('category-view-mode','equals','grid'),
                            'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'cerio' ),
                        ),
                        array(
                            'id' => 'product_col_sm',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Ipad Screen', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
							'required' => array('category-view-mode','equals','grid'),
                            'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'cerio' ),
                        ),
						array(
                            'id' => 'product_col_xs',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Mobile Screen', 'cerio'),
                            'options' => array(
									'1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                ),
                            'default' => '2',
							'required' => array('category-view-mode','equals','grid'),
                            'sub_desc' => esc_html__( 'Select number of column on Mobile Screen', 'cerio' ),
                        ),
						array(
                            'id'=>'show-bestseller-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Bestseller on Page Category', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						 array(
                            'id' => 'bestseller_limit',
                            'type' => 'text',
                            'title' => esc_html__('Shop product Bestseller', 'cerio'),
                            'default' => '9',
							'required' => array('show-bestseller-category','equals',true),
                        ),
                        array(
                            'id'=>'show-banner-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Banner Category', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'woo-show-rating',
                            'type' => 'switch',
                            'title' => esc_html__('Show Rating in Woocommerce Products Widget', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),						
						array(
                            'id'=>'show-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Category', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id' => 'product_count',
                            'type' => 'text',
                            'title' => esc_html__('Shop pages show at product', 'cerio'),
                            'default' => '12',
                            'sub_desc' => esc_html__( 'Type Count Product Per Shop Page', 'cerio' ),
                        ),						
                        array(
                            'id'=>'category-image-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Hover Effect', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'category-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Hover Effect', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
							'id'=>'product-compare',
							'type' => 'switch',
							'title' => esc_html__('Show Compare', 'cerio'),
							'default' => false,
							'on' => esc_html__('Yes', 'cerio'),
							'off' => esc_html__('No', 'cerio'),
						),						
                        array(
                            'id'=>'product_quickview',
                            'type' => 'switch',
                            'title' => esc_html__('Show Quick View', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio')
                        ),
                        array(
                            'id'=>'product-quickview-label',
                            'type' => 'text',
                            'required' => array('product-quickview','equals',true),
                            'title' => esc_html__('"Quick View" Text', 'cerio'),
                            'default' => ''
                        ),
						array(
                            'id'=>'product-countdown',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Countdown', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio')
                        ),
						array(
                            'id'=>'product-attribute',
                            'type' => 'switch',
                            'title' => esc_html__('Show Product Attribute', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio')
                        ),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'cerio'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_detail_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'cerio'),
                            'options' => $page_layouts,
                            'default' => 'full'
                        ),
                        array(
                            'id'=>'product-stock',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Out of stock" Status', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'show-extra-sidebar',
                            'type' => 'switch',
                            'title' => esc_html__('Show Extra Sidebar', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'show-featured-icon',
                            'type' => 'switch',
                            'title' => esc_html__('Show Featured Icon', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'show-sticky-cart',
                            'type' => 'switch',
                            'title' => esc_html__('Show Sticky Cart Product', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'show-brands',
                            'type' => 'switch',
                            'title' => esc_html__('Show Brands', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'show-offer',
                            'type' => 'switch',
                            'title' => esc_html__('Show Offer List', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),						
						array(
                            'id'=>'show-countdown',
                            'type' => 'switch',
                            'title' => esc_html__('Show CountDown', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'product-short-desc',
                            'type' => 'switch',
                            'title' => esc_html__('Show Short Description', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
							'id' => 'length-product-short-desc',
							'type' => 'text',
							'title' => esc_html__('Length Short Description Quickview', 'cerio'),
							'required' => array('product-short-desc','equals',true),
							'default' =>'25',
						),
                        array(
                            'id'=>'show-trust-bages',
                            'type' => 'switch',
                            'title' => esc_html__('Show Trust Bages Product', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
							'id' => 'trust-bages',
							'type' => 'media',
							'title' => esc_html__('Trust Bages', 'cerio'),
							'url'=> true,
							'readonly' => false,
							'required' => array('show-trust-bages','equals',true),
							'sub_desc' => '',
							'default' => array(
								'url' => ""
							)
						),					
                        array(
                            'id'=>'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Product', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'product-related-count',
                            'type' => 'text',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Product Count', 'cerio'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-related-cols',
                            'type' => 'button_set',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Product Columns', 'cerio'),
                            'options' => cerio_ct_related_product_columns(),
                            'default' => '4',
                        ),
                        array(
                            'id'=>'product-upsell',
                            'type' => 'switch',
                            'title' => esc_html__('Show Upsell Products', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),                      
                        array(
                            'id'=>'product-upsell-count',
                            'type' => 'text',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Products Count', 'cerio'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-upsell-cols',
                            'type' => 'button_set',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Product Columns', 'cerio'),
                            'options' => cerio_ct_related_product_columns(),
                            'default' => '3',
                        ),
                        array(
                            'id'=>'product-crosssells',
                            'type' => 'switch',
                            'title' => esc_html__('Show Crooss Sells Products', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),                      
                        array(
                            'id'=>'product-crosssells-count',
                            'type' => 'text',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Products Count', 'cerio'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-crosssells-cols',
                            'type' => 'button_set',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Product Columns', 'cerio'),
                            'options' => cerio_ct_related_product_columns(),
                            'default' => '3',
                        ),						
                        array(
                            'id'=>'product-hot',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Hot" Label', 'cerio'),
                            'desc' => esc_html__('Will be show in the featured product.', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'product-hot-label',
                            'type' => 'text',
                            'required' => array('product-hot','equals',true),
                            'title' => esc_html__('"Hot" Text', 'cerio'),
                            'default' => ''
                        ),
                        array(
                            'id'=>'product-sale',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Sale" Label', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                         array(
                            'id'=>'product-sale-percent',
                            'type' => 'switch',
                            'required' => array('product-sale','equals',true),
                            'title' => esc_html__('Show Sale Price Percentage', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),  
                        array(
                            'id'=>'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Social Share Links', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
                            'id'=>'size-guide',
                            'type' => 'switch',
                            'title' => esc_html__('Show Size Guide', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
						array(
							'id' => 'img-size-guide',
							'type' => 'media',
							'title' => esc_html__('Image Size Guide', 'cerio'),
							'url'=> true,
							'readonly' => false,
							'required' => array('size-guide','equals',true),
							'sub_desc' => '',
							'default' => array(
								'url' => ""
							)
						),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Image Product', 'cerio'),
                    'fields' => array(
                        array(
                            'id'=>'product-thumbs',
                            'type' => 'switch',
                            'title' => esc_html__('Show Thumbnails', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'position-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Position Thumbnails', 'cerio'),
                            'options' => array('left' => esc_html__('Left', 'cerio'),
												'right' => esc_html__('Right', 'cerio'),
												'bottom' => esc_html__('Bottom', 'cerio'),
												'outsite' => esc_html__('Outsite', 'cerio')),
                            'default' => 'bottom',
							'required' => array('product-thumbs','equals',true),
                        ),						
                        array(
                            'id' => 'product-thumbs-count',
                            'type' => 'button_set',
                            'title' => esc_html__('Thumbnails Count', 'cerio'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4', 
									'5' => '5', 									
                                    '6' => '6'                          
                                ),
							'default' => '4',
							'required' => array('product-thumbs','equals',true),
                        ),
                        array(
                            'id'=>'product-image-popup',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Popup', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),						
                        array(
                            'id'=>'layout-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Layouts Thumbnails', 'cerio'),
                            'options' => array('zoom' => esc_html__('Zoom', 'cerio'),
												'scroll' => esc_html__('Scroll', 'cerio'),
												'sticky' => esc_html__('Sticky', 'cerio'),
												'sticky2' => esc_html__('Sticky 2', 'cerio'),
												'slider' => esc_html__('Slider', 'cerio'),
												'large_grid' => esc_html__('Large Grid', 'cerio'),
												'small_grid' => esc_html__('Small Grid', 'cerio'),
											),	
                            'default' => 'zoom',
                        ),
						array(
                            'id'=>'background',
                            'type' => 'switch',
                            'title' => esc_html__('Show Background Product Image', 'cerio'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
                        ),
                        array(
                            'id'=>'zoom-type',
                            'type' => 'button_set',
                            'title' => esc_html__('Zoom Type', 'cerio'),
                            'options' => array('inner' => esc_html__('Inner', 'cerio'), 'lens' => esc_html__('Lens', 'cerio')),
                            'default' => 'inner',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-scroll',
                            'type' => 'switch',
                            'title' => esc_html__('Scroll Zoom', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border',
                            'type' => 'text',
                            'title' => esc_html__('Border Size', 'cerio'),
                            'default' => '2',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Border Color', 'cerio'),
                            'default' => '#f9b61e',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),                      
                        array(
                            'id'=>'zoom-lens-size',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Size', 'cerio'),
                            'default' => '200',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-shape',
                            'type' => 'button_set',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Shape', 'cerio'),
                            'options' => array('round' => esc_html__('Round', 'cerio'), 'square' => esc_html__('Square', 'cerio')),
                            'default' => 'square',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-contain-lens',
                            'type' => 'switch',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Contain Lens Zoom', 'cerio'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'cerio'),
                            'off' => esc_html__('No', 'cerio'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-border',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Border', 'cerio'),
                            'default' => true,
							'required' => array('layout-thumbs','equals',"zoom")
                        ),
                    )
                );
            endif;
            // Blog Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-ui-copy',
                'icon_class' => 'icon',
                'title' => esc_html__('Blog', 'cerio'),
                'fields' => array(              
                )
            );      
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'post-format',
                        'type' => 'switch',
                        'title' => esc_html__('Show Post Format', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'hot-label',
                        'type' => 'text',
                        'title' => esc_html__('"HOT" Text', 'cerio'),
                        'desc' => esc_html__('Hot post label', 'cerio'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'sidebar_blog',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'cerio'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id' => 'layout_blog',
                        'type' => 'button_set',
                        'title' => esc_html__('Layout Blog', 'cerio'),
                        'options' => array(
                                'list'  =>  esc_html__( 'List', 'cerio' ),
                                'grid' =>  esc_html__( 'Grid', 'cerio' ),
								'masonry' =>  esc_html__( 'Masonry', 'cerio' )	
                        ),
                        'default' => 'list',
                        'sub_desc' => esc_html__( 'Select style layout blog', 'cerio' ),
                    ),
                    array(
                        'id' => 'blog_col_large',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Desktop', 'cerio'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '4',
                        'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'cerio' ),
                    ),
                    array(
                        'id' => 'blog_col_medium',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Medium Desktop', 'cerio'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'cerio' ),
                    ),   
                    array(
                        'id' => 'blog_col_sm',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Ipad Screen', 'cerio'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'cerio' ),
                    ),   					
                    array(
                        'id'=>'archives-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'archives-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Count Comments', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),                  
                    array(
                        'id'=>'blog-excerpt',
                        'type' => 'switch',
                        'title' => esc_html__('Show Excerpt', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'list-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('List Excerpt Length', 'cerio'),
                        'desc' => esc_html__('The number of words', 'cerio'),
                        'default' => '50',
                    ),
                    array(
                        'id'=>'grid-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('Grid Excerpt Length', 'cerio'),
                        'desc' => esc_html__('The number of words', 'cerio'),
                        'default' => '12',
                    ),                  
                )
            );
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Single Post', 'cerio'),
                'fields' => array(
                    array(
                        'id'=>'post-single-layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'cerio'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id'=>'post-title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'post-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author Info', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
                    ),
                    array(
                        'id'=>'post-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Comments', 'cerio'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'cerio'),
                        'off' => esc_html__('No', 'cerio'),
					)
				)
			);	
            $this->sections[] = array(
				'id' => 'wbc_importer_section',
				'title'  => esc_html__( 'Demo Importer', 'cerio' ),
				'icon'   => 'fa fa-cloud-download',
				'desc'   => wp_kses( 'Increase your max execution time, try 40000 I know its high but trust me.<br>
				Increase your PHP memory limit, try 512MB.<br>
				1. The import process will work best on a clean install. You can use a plugin such as WordPress Reset to clear your data for you.<br>
				2. Ensure all plugins are installed beforehand, e.g. WooCommerce - any plugins that you add content to.<br>
				3. Be patient and wait for the import process to complete. It can take up to 3-5 minutes.<br>
				4. Enjoy','social' ),				
				'fields' => array(
					array(
						'id'   => 'wbc_demo_importer',
						'type' => 'wbc_importer'
					)
				)
            );			
        }
        public function setHelpTabs() {
        }
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                'opt_name'          => 'cerio_settings',
                'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'cerio'),
                'display_version'   => esc_html__('Theme Version: ', 'cerio') . cerio_version,
                'menu_type'         => 'submenu',
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__('Theme Options', 'cerio'),
                'page_title'        => esc_html__('Theme Options', 'cerio'),
                'footer_credit'     => esc_html__('Theme Options', 'cerio'),
                'google_api_key' => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII',
                'disable_google_fonts_link' => true,
                'async_typography'  => false,
                'admin_bar'         => false,
                'admin_bar_icon'       => 'dashicons-admin-generic',
                'admin_bar_priority'   => 50,
                'global_variable'   => '',
                'dev_mode'          => false,
                'customizer'        => false,
                'compiler'          => false,
                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'menu_icon'         => '',
                'last_tab'          => '',
                'page_icon'         => 'icon-themes',
                'page_slug'         => 'cerio_settings',
                'save_defaults'     => true,
                'default_show'      => false,
                'default_mark'      => '',
                'show_import_export' => true,
                'show_options_object' => false,
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,
                'output_tag'        => true,
                'database'              => '',
                'system_info'           => false,
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                ),
                'ajax_save'                 => false,
                'use_cdn'                   => true,
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }
            $this->args['intro_text'] = sprintf('<p style="color: #0088cc">'.wp_kses('Please regenerate again default css files in <strong>Skin > Compile Default CSS</strong> after <strong>update theme</strong>.', 'cerio').'</p>', $v);
        }           
    }
	if ( !function_exists( 'wbc_extended_example' ) ) {
		function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );
			$current_key = key( $demo_active_import );	
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] )) {
				//Import Sliders
				if ( class_exists( 'RevSlider' ) ) {
					$wbc_sliders_array = array(
						'cerio' => array('slider-1.zip','slider-2.zip','slider-3.zip','slider-4.zip','slider-5.zip','slider-6.zip','slider-7.zip','slider-8.zip','slider-9.zip','slider-10.zip','slider-11.zip','slider-12.zip')
					);
					$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
					if( is_array( $wbc_slider_import ) ){
						foreach ($wbc_slider_import as $slider_zip) {
							if ( !empty($slider_zip) && file_exists( $demo_directory_path.'rev_slider/'.$slider_zip ) ) {
								$slider = new RevSlider();
								$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$slider_zip );
							}
						}
					}else{
						if ( file_exists( $demo_directory_path.'rev_slider/'.$wbc_slider_import ) ) {
							$slider = new RevSlider();
							$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$wbc_slider_import );
						}
					}
				}				
				// Setting Menus
				$primary = get_term_by( 'name', 'Main menu', 'nav_menu' );
				$primary_vertical = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
				$primary_currency = get_term_by( 'name', 'Currency Menu', 'nav_menu' );
				$primary_language = get_term_by( 'name', 'Language Menu', 'nav_menu' );
				$primary_topbar   = get_term_by( 'name', 'Menu Topbar', 'nav_menu' );
				if ( isset( $primary->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
							'main_navigation' => $primary->term_id,
							'vertical_menu' => $primary_vertical->term_id,
							'currency_menu' => $primary_currency->term_id,
							'language_menu' => $primary_language->term_id,
							'topbar_menu' => $primary_topbar->term_id	
						)
					);
				}
				// Set HomePage
				$home_page = 'Home Page 1';	
				$page = get_page_by_title( $home_page );
				if ( isset( $page->ID ) ) {
					update_option( 'page_on_front', $page->ID );
					update_option( 'show_on_front', 'page' );
				}					
			}
		}
		// Uncomment the below
		add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
	}
    global $reduxCerioSettings;
    $reduxCerioSettings = new Redux_Framework_cerio_settings();
}