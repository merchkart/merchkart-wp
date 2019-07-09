<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$temp_style= get_query_var('temp_style');

if($temp_style && $temp_style !='') {
	$product_list = $temp_style;
}
else {
	$product_list = teepro_get_options('nbcore_product_list');	
}

$product_category_compare = teepro_get_options('product_category_compare');
$product_category_wishlist = teepro_get_options('product_category_wishlist');
$product_category_quickview = teepro_get_options('product_category_quickview');
$start_design_button 		= 0;
if(class_exists('Nbdesigner_Plugin') && is_nbdesigner_product($product->get_id())){

	$catalog_button_pos = nbdesigner_get_option('nbdesigner_position_button_in_catalog');

	if($catalog_button_pos == 2) {
		$start_design_button = 1;
	}
}

$col = $product_category_compare + $product_category_wishlist + $product_category_quickview + $start_design_button + 1;
$product_meta_align 	= 'align-' . teepro_get_options('nbcore_product_meta_align');
$product_hover 			= teepro_get_options('nbcore_product_hover') . '-hover';
$product_price_style 	= teepro_get_options('nbcore_product_price_style') . '-price';
$product_title_bold 	= teepro_get_options('nbcore_enable_product_title_bold') ? 'product-title-bold' : '';

?>
<div <?php post_class(array('button-cols-' . $col, $product_meta_align, $product_hover, $product_price_style, $product_title_bold )); ?> >
	<div class="pt-product-meta">
	<?php 
		$tabs = apply_filters( 'woocommerce_product_tabs', array() );
		if ( ! empty( $tabs ) && is_product() ) :
			wc_get_template('netbase/content-product/' . 'grid-type.php');
		else:
			wc_get_template('netbase/content-product/' . esc_attr($product_list) . '.php');
		endif;
	?>
	</div>
</div>
