<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
add_action('woocommerce_after_shop_loop_item', 'cerio_woocommerce_template_loop_add_to_cart', 15 );
add_action('woocommerce_after_shop_loop_item', 'cerio_add_loop_wishlist_link', 15 );
?>
<div class="products-entry content-product clearfix product-wapper">
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