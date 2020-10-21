<?php 
if ( !class_exists('Woocommerce') ) { 
	return false;
}
$cerio_settings = cerio_global_settings();
$cart_style = cerio_get_config('cart-style','popup');
global $woocommerce;
global $woocommerce; ?>
<div class="dropdown mini-cart top-cart">
	<div class="remove-cart-shadow"></div>
	<a class="dropdown-toggle cart-icon" data-toggle="dropdown" data-hover="dropdown" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'cerio'); ?>">
		<div class="icons-cart"><i class="icon-bag"></i><span class="cart-count"><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?></span></div>
    </a>
	<div class="cart-popup <?php echo esc_attr($cart_style); ?>">
		<?php if($cart_style=="popup" && ( ! WC()->cart->is_empty()) ){ ?>
		<div class="box-cart-top">
			<div class="top-total-cart"><?php echo esc_html__("Cart","cerio"); ?>(<?php echo esc_attr($woocommerce->cart->cart_contents_count); ?>)</div>
			<div class="remove-cart">
				<a class="dropdown-toggle cart-remove" data-toggle="dropdown" data-hover="dropdown" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'cerio'); ?>">
					<i class="icon_close"></i><?php echo esc_html__("Close","cerio") ?>
				</a>
			</div>
		</div>
		<?php } ?>
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>