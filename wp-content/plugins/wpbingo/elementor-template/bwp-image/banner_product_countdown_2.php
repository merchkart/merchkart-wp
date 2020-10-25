<?php 
$arr = array('br' => array(), 'p' => array()); 
?>
<div class="bwp-widget-banner <?php echo esc_html( $layout ); ?>">
	<div class="bg-banner">
		<?php  if($product_id && $product = wc_get_product( $product_id )):
			$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );			
		?>
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-12 col-12">
				<div class="products-content">
					<?php if( $title1) : ?>
					<h2 class="title-banner"><?php echo wp_kses( $title1,$arr); ?></h2>
					<?php endif; ?>
					<div class="content">
						<div class="product-title"><a href="<?php echo get_permalink( $product_id );  ?>"><?php echo $product->get_title(); ?></a></div>
						<div class="product-price"><?php echo $product->get_price_html(); ?></div>
						<div class="countdown">
							<?php if( $description) : ?>
							<div class="description-banner"><?php echo esc_html( $description ); ?></div>
							<?php endif; ?>
								<?php if( $time_deal) : ?>
								<div class="countdown-deal">
									<?php
										$start_time = time();
										$countdown_time = strtotime($time_deal);
										$date = bwp_timezone_offset( $countdown_time );
									?>
									<div class="product-countdown"  
										data-day="<?php echo esc_html__("Days","wpbingo"); ?>"
										data-hour="<?php echo esc_html__("Hours","wpbingo"); ?>"
										data-min="<?php echo esc_html__("Mins","wpbingo"); ?>"
										data-sec="<?php echo esc_html__("Secs","wpbingo"); ?>"	
										data-date="<?php echo esc_attr( $date ); ?>"  
										data-sttime="<?php echo esc_attr( $start_time ); ?>" 
										data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" 
										data-id="<?php echo $widget_id; ?>">
									</div>
								</div>
							<?php endif;?>
						</div>
						<?php if( $label) : ?>
							<div class="button-banner">
								<a class="btn-banner" href="<?php echo esc_url($link);?>"><?php echo esc_html( $label ); ?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-12">
				<div class="content-image">
					<div class="content-feature">
						<div class="slider slider-for slick-carousel" data-fade="true" data-asnavfor=".slider-nav" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns="1">
							<div class="image">
								<img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" alt="<?php echo esc_attr__("Feature Product","wpbingo"); ?>" />
							</div>
							<?php
								$product = new WC_product($product_id);
								$attachment_ids = $product->get_gallery_image_ids();

								foreach( $attachment_ids as $attachment_id ) { ?>
									<div class="image">
									<?php
									  // Display Image instead of URL
										echo wp_get_attachment_image($attachment_id, 'full');
									?>
									</div>
									<?php
									}
							?>
						</div>
					</div>
					<div class="content-gallery">
						<div class="gallery-items">
							<div class="slider slider-thumb slick-carousel slider-nav" data-asnavfor=".slider-for" data-nav="true" data-centermode="true" data-focusonselect="true" data-vertical="true" data-verticalswiping="true" data-columns4="4" data-columns3="4" data-columns2="4" data-columns1="4" data-columns="4">
								<div class="image">
									<img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" alt="<?php echo esc_attr__("Thumble Product","wpbingo"); ?>" />
								</div>
								<?php
									$product = new WC_product($product_id);
									$attachment_ids = $product->get_gallery_image_ids();

									foreach( $attachment_ids as $attachment_id ) { ?>
										<div class="image">
										<?php
										  // Display Image instead of URL
											echo wp_get_attachment_image($attachment_id, 'full');
										?>
										</div>
										<?php
										}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endif ?>
	</div>
</div>