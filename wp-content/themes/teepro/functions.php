<?php

/**
 * Netbaseteam core
 */
require get_template_directory() . '/netbase-core/core.php';

if ( ! function_exists( 'pt_woocommerce_template_loop_variation' ) ) {
    function pt_woocommerce_template_loop_variation($args = array()) {
      global $product;
  
      if ( $product ) {
          $defaults = array(
            'quantity' => 1,
            'class'    => implode( ' ', array_filter( array(
              'button',
              'product_type_' . $product->get_type(),
              $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
              $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
            ) ) )
          );
  
          $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
  
          if ($product->get_type() == "variable" ) {
            //woocommerce_variable_add_to_cart();
                      wp_enqueue_script( 'wc-add-to-cart-variation' );
  
                      // Get Available variations?
                      $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
  
                      // Load the template.
                      wc_get_template( 'woocommerce/netbase/loop/loop_variable.php', array(
                          'available_variations' => $get_variations ? $product->get_available_variations() : false,
                          'attributes'           => $product->get_variation_attributes(),
                          'selected_attributes'  => $product->get_default_attributes(),
                      ) );
          }
          /*else {
            wc_get_template( 'loop/add-to-cart.php', $args );
          }*/
  
      }
    }
  }

  add_filter('filter_metabox','custom_field_img_banner');
  function custom_field_img_banner($array){
    $array[] = array(
        'name' => __('Show Banner Bottom', 'teepro'),
        'desc' => __('Check this show banner', 'teepro'),
        'id' => 'teepro_show_banner',
        'type' => 'checkbox',
        'default' => '',
        'tab' => 'layout'
    );
    return $array;
  }



  if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }
 