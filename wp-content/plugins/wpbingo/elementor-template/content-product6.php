<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
$cerio_settings = cerio_global_settings();
remove_action('woocommerce_after_shop_loop_item', 'cerio_add_loop_wishlist_link', 15 );
?>
<div class="products-entry clearfix content-product6 product-wapper">
	<div class="products-thumb">
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<?php 
		if(isset($cerio_settings['product-wishlist']) && $cerio_settings['product-wishlist'] && class_exists( 'YITH_WCWL' ) ){
			if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
				echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
			}
		}
		?>
		<div class='product-button'>
			<?php do_action('woocommerce_after_shop_loop_item'); ?>
		</div>
	</div>
	<div class="products-content">
		<div class="contents">
			<?php woocommerce_template_loop_rating(); ?>
			<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
			<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
		</div>
	</div>
</div>