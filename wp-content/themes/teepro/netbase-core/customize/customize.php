<?php

/**
 * Class that handle all the options in WordPress Theme Customize
 */
class Teepro_Customize
{
    public function __construct()
    {
        add_action('customize_register', array($this, 'register'));
        add_action('customize_controls_enqueue_scripts', array($this, 'customize_control_js'));
        add_action('customize_preview_init', array($this, 'customize_preview_js'));
        add_action('customize_controls_print_styles', array($this, 'customize_style'));
    }

    public function register($wp_customize)
    {

        $customize_options = array();

        $customize_arr = new Teepro_Customize_Options();
        $customize_options['footer'] = $customize_arr->footer();
        $customize_options['blog'] = $customize_arr->blog();
        $customize_options['color'] = $customize_arr->color();
        $customize_options['elements'] = $customize_arr->elements();
        $customize_options['header'] = $customize_arr->header();
        $customize_options['typo'] = $customize_arr->typo();
        $customize_options['pages'] = $customize_arr->pages();
        $customize_options['dokan'] = $customize_arr->dokan();
        $customize_options['services'] = $customize_arr->services();
        $customize_options['layout'] = $customize_arr->nblayout();

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            $customize_options['shop'] = $customize_arr->woocommerce();
        }
        if ( is_plugin_active( 'web-to-print-online-designer/nbdesigner.php' ) ) {
            $customize_options['onlinedesign'] = $customize_arr->onlinedesign();
        }

        if ($wp_customize) {
            $wp_customize->remove_section('colors');
        }

        foreach($customize_options as $section => $define) {
            $options = isset($define['options']) ? $define['options'] : array();
            unset($define['options']);

            if(isset($define['sections'])) {
                $sections = $define['sections'];

                unset($define['sections']);

                if ($wp_customize) {
                    if($wp_customize->get_panel($section)) {
                        foreach($define as $k => $v) {
                            $wp_customize->get_panel($section)->$k = $v;
                        }

                        foreach($sections as $section_in_panel => $section_define) {
                            $wp_customize->add_section($section_in_panel, array_merge(array('panel' => $section), $define));
                        }
                    } else {
                        $wp_customize->add_panel($section, $define);

                        foreach($sections as $section_in_panel => $section_define) {
                            $wp_customize->add_section($section_in_panel, array_merge(array('panel' => $section), $section_define));
                        }
                    }
                }
            } else {
                if ($wp_customize) {
                    $wp_customize->add_section($section, $define);
                }
            }

            foreach($options as $option => $option_define) {
                $default_arr = teepro_default_options();
                if(array_key_exists($option, $default_arr)) {
                    $default = $default_arr[$option];
                } else {
                    $default = '';
                }

                if ($wp_customize) {
                    $wp_customize->add_setting($option, array_merge(array('default' => $default), $option_define['settings']));

                    if (isset($option_define['controls']['type']) && class_exists($class = $option_define['controls']['type'])) {

                        unset($option_define['controls']['type']);

                        $wp_customize->add_control(
                            new $class(
                                $wp_customize,
                                $option,
                                array_merge(array('section' => $section), $option_define['controls'])
                            )
                        );
                    } else {
                        $wp_customize->add_control($option, array_merge(array('section' => $section), $option_define['controls']));
                    }
                }
            }
        }
    }

    // Todo change to minified version
    public function customize_control_js()
    {
        //this is minified version
//        wp_enqueue_script('nbcore_customizer_control', get_template_directory_uri() . '/assets/netbase/js/admin/control.min.js', array('customize-controls', 'jquery'), TEEPRO_VER, true);
        wp_enqueue_script('nbcore-customizer-control', get_template_directory_uri() . '/assets/netbase/js/admin/control.min.js', array('customize-controls', 'jquery'), TEEPRO_VER, true);
        wp_enqueue_script('nbcore-customize', get_template_directory_uri() . '/assets/netbase/js/admin/customize.min.js', array('jquery'), TEEPRO_VER, true);

        wp_localize_script('nbcore-customizer-control', 'nbUpload', array(
            'google_fonts' => Teepro_Helper::google_fonts(),
        ));
    }

    // Todo change to minified version
    public function customize_preview_js()
    {
        //this is minified version
//        wp_enqueue_script('nbcore_customizer_preview', get_template_directory_uri() . '/assets/netbase/js/admin/preview.min.js', array('customize-preview', 'jquery'), TEEPRO_VER, true);
        wp_enqueue_script('nbcore_customizer_preview', get_template_directory_uri() . '/assets/netbase/js/admin/preview.min.js', array('customize-preview', 'jquery'), TEEPRO_VER, true);
    }

    // Todo change to minified version
    public function customize_style()
    {
        //this is minified version
//        wp_enqueue_style('nbcore_customizer_style', get_template_directory_uri() . '/assets/netbase/css/admin/customizer.min.css', NULL, TEEPRO_VER, 'all');
        wp_enqueue_style('nbcore_customizer_style', get_template_directory_uri() . '/assets/netbase/css/admin/customizer/customizer.css', NULL, TEEPRO_VER, 'all');
    }

//    public function get_options()
//    {
//        $this->register( null );
//
//        $theme_mods = get_theme_mods();
//
//        if ( $theme_mods && is_array( $theme_mods ) ) {
//            $this->customize_options = array_merge( $this->customize_options, $theme_mods );
//        }
//
//        return $this->customize_options;
//    }
}