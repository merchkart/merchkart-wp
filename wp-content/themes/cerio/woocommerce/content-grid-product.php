<?php
	global $product, $woocommerce_loop, $post;
	$cerio_settings = cerio_global_settings();
	$layout_shop = cerio_get_config('layout_shop','1');
	$available 	=	$product->get_stock_quantity();
	$sold		=	get_post_meta( $product->get_id(), 'total_sales', true );
	$total 		=	$available + $sold;
	if(($total > 0) && ($available > 0)){
		$percent = round( ($sold  / $total ) * 100 ) ;
	}else{
		$percent = 0;
	}
?>
<?php if ($layout_shop == '1') { ?>
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
<?php }elseif ($layout_shop == '2') { ?>
	<div class="products-entry clearfix content-product2 product-wapper">
		<div class="products-content">
			<div class="contents">
				<?php woocommerce_template_loop_rating(); ?>
				<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			</div>
		</div>
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
		<div class="available-box">
			<div class="percent"><div class="content" style="width:<?php echo esc_attr($percent); ?>%;"></div></div>
			<div class="content-available">
				<div class="available"><label><?php echo esc_html__("Available:",'cerio') ?></label><?php echo esc_attr($available); ?></div>
				<div class="sold"><label><?php echo esc_html__("Sold:",'cerio') ?></label><?php echo esc_attr($sold); ?></div>
			</div>
		</div>
	</div>
<?php }elseif ($layout_shop == '3') { ?>
	<?php
	remove_action('woocommerce_before_shop_loop_item_title', 'cerio_add_countdownt_item', 15 );
	remove_action('woocommerce_before_shop_loop_item_title', 'bwp_display_woocommerce_attribute', 20 );
	?>
	<div class="products-entry clearfix content-product3 product-wapper">
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
		</div>
		<div class="products-content">
			<div class="contents">
				<?php woocommerce_template_loop_rating(); ?>
				<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			</div>
		</div>
	</div>
<?php }elseif ($layout_shop == '4') { ?>
	<div class="products-entry clearfix content-product4 product-wapper">
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
		</div>
		<div class="products-content">
			<div class="contents">
				<?php woocommerce_template_loop_rating(); ?>
				<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				<div class='product-button'>
					<?php do_action('woocommerce_after_shop_loop_item'); ?>
				</div>
			</div>
		</div>
	</div>
<?php }elseif ($layout_shop == '5') { ?>
	<?php	remove_action('woocommerce_after_shop_loop_item', 'cerio_woocommerce_template_loop_add_to_cart', 15 ); ?>
	<div class="products-entry clearfix content-product5 product-wapper">
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
				<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>
				<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			</div>
			<div class="product-button-cart">
				<?php
					if(function_exists("cerio_woocommerce_template_loop_add_to_cart")){
						cerio_woocommerce_template_loop_add_to_cart();
					}
				?>
			</div>
		</div>
	</div>
<?php }elseif ($layout_shop == '6') { ?>
	<?php remove_action('woocommerce_after_shop_loop_item', 'cerio_add_loop_wishlist_link', 15 ); ?>
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
<?php }elseif ($layout_shop == '7') { ?>
	<div class="products-entry content-product7 clearfix product-wapper">
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
<?php } ?>