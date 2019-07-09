<div class="store-content">
	<div class="store-info" style="background-image: url( '<?php echo is_array( $banner_url ) ? $banner_url[0] : $banner_url; ?>');">
		<div class="store-data-container">
			<div class="featured-favourite">
				<?php if ( ! empty( $featured_seller ) && 'yes' == $featured_seller ): ?>
					<div class="featured-label"><span><?php esc_html_e( 'Featured', 'teepro' ); ?><span></div>
				<?php endif ?>

				<?php do_action( 'dokan_seller_listing_after_featured', $seller, $store_info ); ?>
			</div>

			<div class="store-data">
				<h2><a href="<?php echo esc_url($store_url); ?>"><?php echo esc_html($store_name); ?></a></h2>

				<?php if ( !empty( $seller_rating['count'] ) ): ?>
					<div class="star-rating dokan-seller-rating" title="<?php echo sprintf( esc_html__( 'Rated %s out of 5', 'teepro' ), $seller_rating['rating'] ) ?>">
						<span style="width: <?php echo ( ( $seller_rating['rating']/5 ) * 100 - 1 ); ?>%">
							<strong class="rating"><?php echo ($seller_rating['rating']); ?></strong> <?php echo esc_html('out of 5', 'teepro'); ?>
						</span>
					</div>
				<?php endif ?>

				<?php if ( $store_address ): ?>
					<p class="store-address"><i class="fa fa-home" aria-hidden="true"></i><?php echo $store_address; ?></p>
				<?php endif ?>

				<?php if ( !empty( $store_info['phone'] ) ) { ?>
					<p class="store-phone">
						<i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html( $store_info['phone'] ); ?>
					</p>
				<?php } ?>

				<?php do_action( 'dokan_seller_listing_after_store_data', $seller, $store_info ); ?>

			</div>
		</div>
	</div>
</div>
<div class="store-footer">
	<div class="seller-avatar">
		<?php echo get_avatar( $seller->ID, 150 ); ?>
	</div>
	<a href="<?php echo esc_url($store_url); ?>" class="dokan-btn dokan-btn-theme"><?php echo esc_html__( 'Visit Store', 'teepro' ); ?></a>

	<?php do_action( 'dokan_seller_listing_footer_content', $seller, $store_info ); ?>
</div>