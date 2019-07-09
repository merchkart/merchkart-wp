<?php

class Teepro_Helper
{

    public static function include_template_tags()
    {
        require_once get_template_directory() . '/netbase-core/helper/template-tags.php';
    }

    public static function nbcore_body_classes($classes)
    {
        // Adds a class of group-blog to blogs with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        // Adds a class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        if ((function_exists('is_woocommerce') && is_woocommerce()) && function_exists('is_product') && !is_product() || (function_exists('is_cart') && is_cart())) {
            $shop_sidebar = teepro_get_options('nbcore_shop_sidebar');
            if ('no-sidebar' !== $shop_sidebar && is_active_sidebar('shop-sidebar')) {
                if('left-sidebar' === $shop_sidebar) {
                    $classes['wc_sidebar'] = 'wc-left-sidebar';
                } elseif('right-sidebar' === $shop_sidebar) {
                    $classes['wc_sidebar'] = 'wc-right-sidebar';
                }
            } else {
                $classes['wc_sidebar'] = 'wc-no-sidebar';
            }
        }

        if (function_exists('is_product') && is_product()) {
            if ('no-sidebar' !== teepro_get_options('nbcore_pd_details_sidebar') && is_active_sidebar('product-sidebar')) {
                $classes['wc_pd_sidebar'] = 'wc-pd-has-sidebar';
            } else {
                $classes['wc_pd_sidebar'] = 'wc-pd-no-sidebar';
            }
        }

        if (get_the_ID()) {
            $classes[] = get_post_meta(get_the_ID(), 'page_class', true);
        }

        if (function_exists('dokan_is_seller_dashboard') && Teepro_Helper::dokan_is_seller_dashboard_wpml() && teepro_get_options('nbcore_dashboard_style') || ( get_query_var( 'edit' ) && is_singular( 'product' ))) {
            $classes[] = 'dokan-custom-style';
        }
        if (function_exists('dokan_is_store_page') && dokan_is_store_page()){
            if ('no-sidebar' !== teepro_get_options('nbcore_vendor_details_sidebar')){
                if( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) {
                    $classes['dk_sidebar'] = 'dk-has-sidebar';
                } elseif( is_active_sidebar('sidebar-store') ) {
                    $classes['dk_sidebar'] = 'dk-has-sidebar';
                } else {
                    $classes['dk_sidebar'] = 'dk-no-sidebar';
                }
            } else {
                $classes['dk_sidebar'] = 'dk-no-sidebar';
            }
        }

        return $classes;
    }

    public static function dokan_is_seller_dashboard_wpml() {

        $page_id = dokan_get_option( 'dashboard', 'dokan_pages' );

        if( function_exists('icl_get_languages') ) {

            $page_id = icl_object_id($page_id, 'page', false, ICL_LANGUAGE_CODE); 

        }
    
        if ( ! $page_id ) {
            return false;
        }
    
        if ( $page_id == get_the_ID() ) {
            return true;
        }
    
        return false;
    
    }

    public static function nbcore_pingback_header()
    {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }

    /**
     * Load google fonts from table option
     * Auto update font after 30 days
     */
    public static function google_fonts() 
    {
        $nbcore_google_font_check   = get_option('nbcore_google_font_check');

        if( empty( $nbcore_google_font_check ) ) {

            $google_fonts = self::get_google_fonts();
        }
        else {

            //update after 30 days
            $next_check_date    = strtotime( date('Y-m-d H:i:s', $nbcore_google_font_check) . "+30 days" );
            $current_date       = strtotime( date('Y-m-d H:i:s') );

            if( $current_date - $next_check_date > 0 ) {
                $google_fonts = self::get_google_fonts();
            }
            else {
                $google_fonts = get_option('nbcore_google_fonts');
            }
        }

        return $google_fonts;
    }

    /**
     * Get all fonts from web google fonts api
     * return array format
     * 
     * array('ABeeZee' => array('400'),
     *       'Abel' => array('400'),
     *       'Abhaya Libre' => array('400', '500', '600', '700', '800'),
     *      )
     */

    public static function get_google_fonts() {

        $font_data          = wp_remote_get( 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCgmsne86nQoMVHIpNavvzoL5ChWe0pQKc' );        
        $output_array       = array();

        if($font_data['response']['code'] == '200')
        {
            $font_data          = json_decode( $font_data['body'], true );
            $font_items         = $font_data['items'];
            foreach ( $font_items as $item ) {
    
                $variant_array      = array();
    
                foreach ( $item['variants'] as $variant ) {
    
                    if( $variant == 'regular' ) {
                        $variant = '400';
                    }
    
                    if( preg_match('/italic/', $variant, $matches) ) {
                        continue;
                    }
    
                    array_push( $variant_array, $variant );
                }
    
                $output_array[$item['family']] = $variant_array;
            }

            update_option( 'nbcore_google_font_check', strtotime(date('Y-m-d H:i:s') ) );
            update_option('nbcore_google_fonts', $output_array);
        }
        else {
            $output_array = get_option('nbcore_google_fonts');
        }

        return $output_array;
    }

    public static function write_log($log)
    {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }
}
