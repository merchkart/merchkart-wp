<div class="dokan-seller-listing row">

    <?php
	global $post;
    $pagination_base = str_replace( $post->ID, '%#%', esc_url( get_pagenum_link( $post->ID ) ) );

    if(isset($limit)){

        $limit = teepro_get_options('nbcore_storelist_per_page');
    }
	if(!isset($style) || $style==''){
        $style= teepro_get_options('nbcore_vendors_list');        
    }
	if(!isset($per_row_xl)){
        $per_row_xl = teepro_get_options('nbcore_storelist_loop_columns_xl');
    }
    if(!isset($per_row_lg)){
        $per_row_lg = teepro_get_options('nbcore_storelist_loop_columns_lg');
    }
    if(!isset($per_row_md)){
        $per_row_md = teepro_get_options('nbcore_storelist_loop_columns_md');    
    }
    if(!isset($per_row_sm)){
        $per_row_sm = teepro_get_options('nbcore_storelist_loop_columns_sm');        
    }
	/*$per_row_xl = $per_row_xl ? $per_row_xl : teepro_get_options('nbcore_vendor_loop_columns_xl');
	$per_row_lg = $per_row_lg ? $per_row_lg : teepro_get_options('nbcore_vendor_loop_columns_lg');
	$per_row_md = $per_row_md ? $per_row_md : teepro_get_options('nbcore_vendor_loop_columns_md');
	$per_row_sm = $per_row_sm ? $per_row_sm : teepro_get_options('nbcore_vendor_loop_columns_sm');
*/
	if ( $search == 'yes' ) {
		$search_query = isset( $_GET['dokan_seller_search'] ) ? sanitize_text_field( $_GET['dokan_seller_search'] ) : '';

		if ( ! empty( $search_query ) ) {
			printf( '<h2 class="col-12 col-md-7">' . esc_html__( 'Search Results for: %s', 'teepro' ) . '</h2>', $search_query );
		} else {
			echo '<h2 class="col-12 col-md-7">' . esc_html( get_the_title() ) . '</h2>';
		}
		?>

        <form role="search" method="get" class="dokan-seller-search-form col-12 col-md-5<?php echo (empty( $search_query ) ? ' no-query' : ''); ?>" action="">
            <label>
                <span class="screen-reader-text"><?php _e( 'Search vendor', 'teepro' ); ?></span>
            </label>
			<div class="nb-input-group">
				<input type="search" id="search" class="search-field dokan-seller-search" placeholder="<?php esc_attr_e( 'Search &hellip;', 'teepro' ); ?>" value="<?php echo esc_attr( $search_query ); ?>" name="dokan_seller_search" title="<?php esc_attr_e( 'Search seller &hellip;', 'teepro' ); ?>" />
                <span class="search-button">
					<button class="bt-4" type="submit"><i class="icon-search"></i></button>
				</span>
            </div>
            <input type="hidden" id="pagination_base" name="pagination_base" value="<?php echo esc_attr($pagination_base); ?>" />
            <input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce( 'dokan-seller-listing-search' ); ?>" />
            <div class="dokan-overlay" style="display: none;"><span class="dokan-ajax-loader"></span></div>
        </form>
		<?php
            /**
             *  Added extra search field after store listing search
             *
             * `dokan_after_seller_listing_serach_form` - action
             *
             *  @since 2.5.7
             *
             *  @param array|object $sellers
             */
            do_action( 'dokan_after_seller_listing_serach_form', $sellers );
        ?>
    <?php }
    else 
    {
        $search_query = null;
		echo '<h2>' . esc_html( get_the_title() ) . '</h2>';
    }
    $paged   = max( 1, get_query_var( 'paged' ) );
    $limit   = $limit;
    $offset  = ( $paged - 1 ) * $limit;

    $seller_args = array(
        'number' => $limit,
        'offset' => $offset
    );
    
    $sellers = dokan_get_sellers( apply_filters( 'dokan_seller_listing_args', $seller_args ) );
    ?>

    <?php
	$template_args = array(
		'sellers'			=> $sellers,
		'limit'				=> $limit,
		'offset'			=> $offset,
		'paged'				=> $paged,
		'search_query'		=> $search_query,
		'pagination_base'	=> $pagination_base,
		'per_row_xl'		=> $per_row_xl,
		'per_row_lg'		=> $per_row_lg,
		'per_row_md'		=> $per_row_md,
		'per_row_sm'		=> $per_row_sm,
		'search_enabled'	=> $search,
		'image_size'		=> $image_size,
		'style'				=> $style,
	); 
	echo dokan_get_template_part( 'store-lists-loop', false, $template_args );
	?>
</div>

<?php $inline_script = '
    (function($){
        $(document).ready(function(){
            var form = $(".dokan-seller-search-form");
            var xhr;
            var timer = null;

            form.on("keyup", "#search", function() {
                var self = $(this),
                    data = {
                        search_term: self.val(),
                        pagination_base: form.find("#pagination_base").val(),
                        limit: ' . $limit . ',
                        style: "' . $style . '",
                        per_row_xl: ' . $per_row_xl . ',
                        per_row_lg: ' . $per_row_lg . ',
                        per_row_md: ' . $per_row_md . ',
                        per_row_sm: ' . $per_row_sm . ',
                        action: "dokan_seller_listing_search",
                        _wpnonce: form.find("#nonce").val()
                    };

                if (timer) {
                    clearTimeout(timer);
                }

                if ( xhr ) {
                    xhr.abort();
                }

                timer = setTimeout(function() {
                    form.find(".dokan-overlay").show();

                    xhr = $.post(dokan.ajaxurl, data, function(response) {
                        if (response.success) {
                            form.find(".dokan-overlay").hide();

                            var data = response.data;
                            $("#dokan-seller-listing-wrap").html( $(data).find( ".seller-listing-content" ) );
                        }
                    });
                }, 500);
            } );
        });
    })(jQuery);';
wp_enqueue_script( 'teepro_front_script' );
wp_add_inline_script( 'teepro_front_script', $inline_script );