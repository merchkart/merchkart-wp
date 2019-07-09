<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nbcore
 */

$blog_class     = '';
$shop_class     = '';
$product_class  = '';
$page_class     = '';
$store_class    = '';

//$page_sidebar = teepro_get_options('page_sidebar');

if(teepro_get_options('nbcore_blog_sticky_sidebar')) {
    $blog_class = ' sticky-wrapper sticky-sidebar';
}
if(teepro_get_options('shop_sticky_sidebar')) {
    $shop_class = ' sticky-wrapper sticky-sidebar';
}
if(teepro_get_options('product_sticky_sidebar')) {
    $product_class = ' sticky-wrapper sticky-sidebar';
}

if(teepro_get_options('nbcore_vendor_sticky_sidebar')) {
    $store_class = ' sticky-wrapper sticky-sidebar';
}

if( (function_exists('is_woocommerce') && is_woocommerce()) || (function_exists('dokan_is_store_page') && dokan_is_store_page()) ) {
    if (is_product()) {
        if ('no-sidebar' !== teepro_get_options('nbcore_pd_details_sidebar') && is_active_sidebar('product-sidebar')) {
            echo '<aside id="secondary" class="widget-area shop-sidebar" role="complementary"><div class="sidebar-wrapper' . esc_attr($product_class) . '">';
            dynamic_sidebar('product-sidebar');
            echo '</div></aside>';
        }
    } 
    elseif (function_exists('dokan_is_store_page') && dokan_is_store_page()){
        if ('no-sidebar' !== teepro_get_options('nbcore_vendor_details_sidebar')){
            echo '<aside id="secondary" class="widget-area dokan-store-sidebar"><div class="sidebar-wrapper' . esc_attr($store_class) . '">';
            if( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) {

                $store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
                $store_info   = $store_user->get_shop_info();
                $map_location = $store_user->get_location();
                
                do_action( 'dokan_sidebar_store_before', $store_user, $store_info );
                if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

                    $args = array(
                        'before_widget' => '<div class="widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    );
                    if ( class_exists( 'Dokan_Store_Location' ) ) {                        
                        the_widget( 'Dokan_Store_Category_Menu', array( 'title' => esc_html__( 'Store Category', 'teepro' ) ), $args );

                        if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && !empty( $map_location ) ) {
                            the_widget( 'Dokan_Store_Location', array( 'title' => esc_html__( 'Store Location', 'teepro' ) ), $args );
                        }

                        if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                            the_widget( 'Dokan_Store_Contact_Form', array( 'title' => esc_html__( 'Contact Vendor', 'teepro' ) ), $args );
                        }
                    }
                }
                do_action( 'dokan_sidebar_store_after', $store_user, $store_info );
                if ( is_plugin_active( 'dokan-lite/dokan.php' ) && is_plugin_active( 'dokan-pro/dokan-pro.php' )) {
                    teepro_show_store_coupons($store_user, $store_info);
                }
            } else {
                dynamic_sidebar( 'sidebar-store' );
            }
            echo '</div></aside>';
        }
    }
    else {
        if ('no-sidebar' !== teepro_get_options('nbcore_shop_sidebar') && is_active_sidebar('shop-sidebar')) {
            echo '<aside id="secondary" class="widget-area shop-sidebar" role="complementary"><div class="sidebar-wrapper' . esc_attr($shop_class) . '">';
            dynamic_sidebar('shop-sidebar');
            echo '</div></aside>';
        }
    }
} elseif(is_page() && 'no-sidebar' !== teepro_get_options('nbcore_pages_sidebar') && is_active_sidebar('page-sidebar') ) {
    echo '<aside id="secondary" class="widget-area" role="complementary"><div class="sidebar-wrapper' . esc_attr($blog_class) . '">';
    dynamic_sidebar( 'page-sidebar' );
    echo '</div></aside>';
}
 else {
	if( 'no-sidebar' !== teepro_get_options('nbcore_blog_sidebar') && is_active_sidebar('default-sidebar') ) {
        echo '<aside id="secondary" class="widget-area" role="complementary"><div class="sidebar-wrapper' . esc_attr($blog_class) . '">';
        dynamic_sidebar( 'default-sidebar' );
        echo '</div></aside>';
	}
}

