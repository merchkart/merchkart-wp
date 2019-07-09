<?php
/**
 * Dokan Seller Single product tab Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<div class="product-vendor-info">
	<div class="profile-img">
		<?php echo get_avatar( $author->ID, 90 ); ?>
	</div>
	<div class="dokan-store-info">
		<?php if ( !empty( $store_info['store_name'] ) ) : ?>
			<h4 class="store-name"><?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), $store_info['store_name'] ); ?></h4>
		<?php endif; ?>
		<div class="store-ratings">
			<?php dokan_get_readable_seller_rating( $author->ID ); ?>
		</div>
		<div class="seller-name">
			<span><?php esc_html_e( 'Vendor:', 'teepro' ); ?></span>

			<span class="details">
				<?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), $author->display_name ); ?>
			</span>

			<?php do_action( 'dokan_store_header_info_fields',  $author->ID ); ?>
		</div>
		<?php if ( !empty( $store_info['address'] ) ) : ?>
			<div class="store-address">
				<i class="fa fa-map-marker"></i>
				<address class="address"><?php echo dokan_get_seller_address( $author->ID ); ?></address>
			</div>
		<?php endif; ?>
		<?php if ( !empty( $store_info['phone'] ) ) : ?>
			<div class="store-phone">
				<i class="fa fa-phone"></i>
				<address class="phone"><?php echo ($store_info['phone']); ?></address>
			</div>
		<?php endif; ?>
		<div class="store-details">
			<i class="fa fa-eye"></i>
			<?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), esc_html__('View store', 'teepro') ); ?>
		</div>
	</div>
</div>