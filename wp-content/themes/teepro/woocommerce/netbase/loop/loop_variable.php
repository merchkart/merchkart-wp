<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;
global $tshirt_option;
/*$attribute_keys = array_keys( $attributes );*/

$pt_attrs = teepro_get_options('nbcore_pa_swatch_style');
$pt_attrs = $pt_attrs != '' ? json_decode($pt_attrs) : array();

do_action( 'woocommerce_before_add_to_cart_form' );
?>
        <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
            <p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'teepro' ); ?></p>
        <?php else : ?>
            <table class="variations nb-loop-variable" cellspacing="0">
                <tbody>
                    <?php foreach ( $attributes as $attribute_name => $options ) :
                            $attr_custom =substr($attribute_name, 0, 3);
                            $chva = '';
                            foreach ($pt_attrs as $aname => $aval){

                                if($attr_custom !='pa_' || ($aval =='1' && 'pa_'.$aname == $attribute_name && $attr_custom =='pa_')){
                                    $chva = '1';
                                }
                            }

                            if($chva == '1'){
                            ?>
                                <tr>
                                    <td class="value">
                                        <?php
                                        $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
                                        wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                    <?php endforeach;?>

                </tbody>
            </table>
        <?php endif; ?>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
