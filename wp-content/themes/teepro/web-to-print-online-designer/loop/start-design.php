<?php
if (!defined('ABSPATH')) exit;
$product_id = $product->get_id();
$product_id = get_wpml_original_id($product_id);
$url = esc_url( get_permalink($product->get_id()) );
//if($type == 'simple'){ 
    $url =  add_query_arg(array(
            'product_id'    =>  $product_id
            ),  getUrlPageNBD('create'));
//}else if($type == 'variable'){
//    $label = __('Choose option','web-to-print-online-designer');
//}


$catalog_button_pos = nbdesigner_get_option('nbdesigner_position_button_in_catalog');
$start_design_button_class = $catalog_button_pos == 1 ? 'replace-add-to-cart-button' : '';

echo sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="bt-4 start-design %s %s %s">%s<span class="tooltip">%s</span></a>',
        $url,
        esc_attr( isset( $quantity ) ? $quantity : 1 ),
        esc_attr( $product->get_id() ),
        esc_attr( $product->get_sku() ),
        esc_attr( isset( $class ) ? $class : 'button' ),
        $start_design_button_class,
        nbdesigner_get_option('nbdesigner_class_design_button_catalog'),
        esc_html( $label ),
        esc_html( $label )
);
