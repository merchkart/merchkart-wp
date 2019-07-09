<div id="dokan-seller-listing-wrap" class="col-12">
	<div class="seller-listing-content">
		<?php
		if ( $sellers['users'] ) :
			$width_xl = $per_row_xl ? absint(12 / absint($per_row_xl)) : '4';
			$width_lg = $per_row_lg ? absint(12 / absint($per_row_lg)) : '3';
			$width_md = $per_row_md ? absint(12 / absint($per_row_md)) : '2';
			$width_sm = $per_row_sm ? absint(12 / absint($per_row_sm)) : '1';
			?>
			<div class="dokan-seller-wrap">
				<?php
				foreach ( $sellers['users'] as $seller ) :
					$store_info = dokan_get_store_info( $seller->ID );
					$banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;
					$store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : esc_html__( 'N/A', 'teepro' );
					$store_url  = dokan_get_store_url( $seller->ID );
					$store_address  = dokan_get_seller_short_address( $seller->ID );
                    $seller_rating  = dokan_get_seller_rating( $seller->ID );
                    $banner_url = ( $banner_id ) ? wp_get_attachment_image_src( $banner_id, $image_size ) : dokan_get_no_seller_image();
                    $featured_seller = get_user_meta( $seller->ID, 'dokan_feature_seller', true );
					?>

					<div class="<?php echo 'col-xl-' . $width_xl . ' col-lg-' . $width_lg . ' col-md-' . $width_md . ' col-sm-' . $width_sm; ?>">
						<div class="dokan-single-seller store_<?php echo esc_attr($style . (( ! $banner_id ) ? ' no-banner-img' : '')); ?>">
							<div class="store-wrapper">
								<?php
								$template_args = array(
									'seller'			=> $seller,
									'store_info'		=> $store_info,
									'banner_id'			=> $banner_id,
									'store_name'		=> $store_name,
									'store_url'			=> $store_url,
									'store_address'		=> $store_address,
									'seller_rating'		=> $seller_rating,
									'banner_url'		=> $banner_url,
									'featured_seller'	=> $featured_seller,
								);
								echo dokan_get_template_part( 'liststyle/' . $style, false, $template_args );
								?>
							</div>
						</div>
					</div> <!-- .single-seller -->
				<?php endforeach; ?>
			</div> <!-- .dokan-seller-wrap -->

			<?php
			
			$user_count   = $sellers['count'];
			$num_of_pages = ceil( $user_count / $limit );

			if ( $num_of_pages > 1 ) :
				echo '<div class="pagination-container clearfix">';

				$pagination_args = array(
					'current'   => $paged,
					'total'     => $num_of_pages,
					'base'      => $pagination_base,
					'type'      => 'array',
					'prev_text' => wp_kses(__('<i class=\'icon-angle-left\'></i>', 'teepro'), array('i' => array('class' => array()))),
					'next_text' => wp_kses(__('<i class=\'icon-angle-right\'></i>', 'teepro'), array('i' => array('class' => array()))),
				);

				if ( ! empty( $search_query ) ) :
					$pagination_args['add_args'] = array(
						'dokan_seller_search' => $search_query,
					);
				endif;

				$page_links = paginate_links( $pagination_args );

				if ( $page_links ) :
					$pagination_links  = '<nav class="navigation paging-navigation ' . teepro_get_options('pagination_style') . '">';
					$pagination_links .= '<div class="pagination loop-pagination">';
					$pagination_links .= join( "", $page_links );
					$pagination_links .= '</div>';
					$pagination_links .= '</nav>';

					print $pagination_links;
				endif;

				echo '</div>';
			endif;
			?>

		<?php else : ?>
			<p class="dokan-error"><?php esc_html_e( 'No vendor found!', 'teepro' ); ?></p>
		<?php endif; ?>
	</div>
</div>