<div class="store-content">
	<div class="store-data-container">
		<div class="featured-favourite">
			<?php if ( ! empty( $featured_seller ) && 'yes' == $featured_seller ): ?>
				<div class="featured-label"><span><?php esc_html_e( 'Featured', 'teepro' ); ?><span></div>
			<?php endif ?>
			<?php do_action( 'dokan_seller_listing_after_featured', $seller, $store_info ); ?>
		</div>
		<div class="store-info">
			<div class="seller-avatar">
				<div class="seller-avatar-i">
					<?php echo get_avatar( $seller->ID, 75 ); ?>
				</div>
			</div>
			<div class="store-data">
				<h4 class="store-name"><a href="<?php echo esc_url($store_url); ?>"><?php echo esc_html($store_name); ?></a></h4>
				<?php if ( !empty( $seller_rating['count'] ) ): ?>
					<div class="store-ratings">
						<span class="dokan-seller-rating">
							<span class="star-rating" title="<?php echo sprintf( esc_html__( 'Rated %s out of 5', 'teepro' ), $seller_rating['rating'] ) ?>">
								<span style="width: <?php echo ( ( $seller_rating['rating']/5 ) * 100 ); ?>%"></span>
							</span>
						</span>
						<span>(<strong class="rating"><?php echo ($seller_rating['rating']); ?></strong> <?php echo esc_html('out of 5', 'teepro'); ?>)</span>
					</div>					
				<?php endif ?>
				<?php if ( $store_address ): ?>
					<div class="store-address">
						<i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo ($store_address); ?>
					</div>
				<?php endif ?>
				<?php if ( !empty( $store_info['phone'] ) ) { ?>
					<div class="store-phone">
						<i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html( $store_info['phone'] ); ?>
					</div>
				<?php } ?>
				<?php do_action( 'dokan_seller_listing_after_store_data', $seller, $store_info ); ?>
				<div class="store-lnk">
					<a href="<?php echo esc_url($store_url); ?>" class="dokan-btn dokan-btn-theme"><?php echo esc_html__( 'Visit Store', 'teepro' ); ?></a>
				</div>
				<?php do_action( 'dokan_seller_listing_footer_content', $seller, $store_info ); ?>
			</div>
		</div>
	</div>
</div>