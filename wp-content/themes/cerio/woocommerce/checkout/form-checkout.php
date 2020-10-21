<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'cerio' ) ) );
	return;
}
global $woocommerce;
?>
<div class="woocommerce-page-header">
	<ul>
		<li class="shopping-cart-link line-hover">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php echo esc_html__("Shopping Cart","cerio"); ?><span class="cart-count">(<?php echo esc_attr($woocommerce->cart->cart_contents_count); ?>)</span></a>
		</li>
		<li class="checkout-link line-hover active"><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php echo esc_html__("Checkout","cerio"); ?></a></li>
		<?php if (get_page_by_path('order-tracking')) { ?>
			<li class="order-tracking-link"><a href="<?php echo get_permalink( get_page_by_path( 'order-tracking' ) ); ?>"><?php echo esc_html__("Order Tracking","cerio"); ?></a></li>
		<?php } ?>
	</ul>
</div>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="row">
		<?php if ( $checkout->get_checkout_fields() ) : ?>
			<div class="col-xl-7 col-lg-7 col-md-12 col-12">	
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div class="row" id="customer_details">
					<div class="col-12">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<div class="col-12">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-12 col-12">
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
				<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'cerio' ); ?></h3>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<div id="order_review" class="woocommerce-checkout-review-order">
					<div class="checkout-review-order-table-wrapper">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>
				</div>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
		<?php else: ?>
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'cerio' ); ?></h3>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">	
				<div class="checkout-review-order-table-wrapper">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>		
		<?php endif; ?>
	</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>