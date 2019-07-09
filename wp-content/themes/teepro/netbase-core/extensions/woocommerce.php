<?php
/**
 * Extend and customize Woocommerce
 */
class Teepro_Extensions_Woocommerce {

	public function __construct()
	{
		remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
		remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        
        
        add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 21 );
        
        if(!teepro_get_options('nbcore_product_rating')) {
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        }

		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_filter( 'woocommerce_before_main_content', 'teepro_page_title', 5 );
		add_filter( 'loop_shop_columns', array($this, 'loop_columns') );
		add_filter( 'loop_shop_per_page', array($this, 'products_per_page'), 20 );
		add_filter( 'woocommerce_pagination_args', array($this, 'woocommerce_pagination') );
		add_filter('woocommerce_product_description_heading', '__return_empty_string');
		add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');
		add_filter('woocommerce_review_gravatar_size', array($this, 'wc_review_avatar_size'));
		add_filter('woocommerce_cross_sells_total', array($this, 'cross_sells_limit'));
		add_filter('woocommerce_upsells_total', array($this, 'upsells_limit'));
		add_filter('yith_add_quick_view_button_html', array($this, 'quickview_button'), 10, 3);
		add_filter('yith_quick_view_loader_gif', '__return_empty_string');
        add_filter( 'option_yith_woocompare_button_text',  array($this, 'compare_button_text'), 99 );

		add_action('woocommerce_after_shop_loop_item', array($this, 'product_action_div_open'), 6);
        add_action('woocommerce_after_shop_loop_item', array($this, 'product_action_div_close'), 50);

        if ( teepro_get_options('product_category_compare') && get_option('yith_woocompare_compare_button_in_products_list') == 'yes' && function_exists('yith_woocompare_constructor') ) 
            add_action( 'woocommerce_after_shop_loop_item', array( $this, 'add_compare_link' ), 20 );
        
        if(teepro_get_options('nbcore_product_action_style') != 'vertical' && teepro_get_options('nbcore_product_action_style') != 'horizontal' ) {

            add_action('woocommerce_after_shop_loop_item', array($this, 'wishlist_button'), 20); 
        }
        else {
            add_action('woocommerce_after_shop_loop_item', array($this, 'wishlist_fixed_button'), 53);    
        }

		add_action('woocommerce_shop_loop_item_title', array($this, 'product_title'), 10);
        add_action('woocommerce_before_main_content', array($this, 'shop_banner'), 15);
        
        if(teepro_get_options('nbcore_product_image_mask')) {

            add_action('woocommerce_after_shop_loop_item', array($this, 'product_img_mask_div_open'), 52);
            add_action('woocommerce_after_shop_loop_item', array($this, 'product_img_mask_div_close'), 52);
        }

		add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
		add_action('woocommerce_single_product_summary', array($this, 'wide_meta_left_div_open'), 9);
		add_action('woocommerce_single_product_summary', array($this, 'wide_meta_left_div_close'), 24);
		add_action('woocommerce_single_product_summary', array($this, 'wide_meta_right_div_open'), 26);
        add_action('woocommerce_single_product_summary', array($this, 'wide_meta_right_div_close'), 55);
        add_action('woocommerce_before_add_to_cart_button', array($this, 'woocommerce_custom_online_design_button'), 30);
		add_action('woocommerce_share', array($this, 'wc_share_social'));
		add_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 15);
        add_action('wp_footer', array($this, 'add_cart_notice'));
        // add_action('woocommerce_product_thumbnails', array($this, 'thumb_open_tag'), 10);
        // add_action('woocommerce_product_thumbnails', array($this, 'thumb_close_tag'), 30);
		
        //TODO Fix this hack?
        add_filter('woocommerce_in_cart_product', array($this, 'remove_wishlist_quickview'), 50, 1 );

        add_action('woocommerce_after_shop_loop_item_title', array($this, 'wc_shop_loop_item_desc'), 50);

        if(class_exists('WeDevs_Dokan')){
            add_filter( 'pre_get_posts', array($this, 'store_query_filter' ), 20 );
        }
    }
    
    public function wc_shop_loop_item_desc() {

        if(teepro_get_options('nbcore_grid_product_description')) {

            global $product;

            echo '<p class="product-excerpt">'.esc_html(get_the_excerpt($product->get_id())).'</p>';
        }
    }

    public function compare_button_text( $button_text ){
        return '<i class="icon-compare"></i><span class="tooltip">'.esc_html($button_text).'</span>';
    }

	public function remove_wishlist_quickview($a){
        add_filter('yith_add_quick_view_button_html',  '__return_empty_string', 50, 3);
    }

	public function product_action_div_open()
	{
		$product_action_style = ' ' . teepro_get_options('nbcore_product_action_style');
        echo '<div class="product-action' . esc_attr($product_action_style) . '">';
	}

	public function product_action_div_close()
	{
		echo '</div>';
    }
    
    public function product_img_mask_div_open()
    {
        echo '<div class="product-image-mask">';
    }

    public function product_img_mask_div_close()
    {
        echo '</div>';
    }

    public function wishlist_button()
    {
        if(teepro_get_options('product_category_wishlist')) {
            if ( class_exists( 'YITH_WCWL' ) ) {
                echo '<div class="wishlist-btn button bt-4">' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</div>';
            }
        }
    }
    
    public function wishlist_fixed_button()
    {
        if(teepro_get_options('product_category_wishlist')) {
            if ( class_exists( 'YITH_WCWL' ) ) {
                echo '<div class="wishlist-fixed-btn">' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</div>';
            }
        }
    }

	public function product_title()
	{
		echo '<h4 class="product-title"><a href="' . esc_url(get_the_permalink()) . '">' . esc_html(get_the_title()) . '</a></h4>';
	}

	public function products_per_page($cols)
	{
		return teepro_get_options('nbcore_products_per_page');
	}

	public function woocommerce_pagination()
	{
		return array(
			'prev_text' => '<i class="icon-left-open"></i>',
			'next_text' => '<i class="icon-right-open"></i>',
			'end_size' => 1,
			'mid_size' => 1,
		);
	}

	public function product_description()
	{
        if ( has_excerpt() ){
		  echo '<p class="product-description">' . strip_tags(get_the_excerpt()) . '</p>';
        }
	}

	public function product_category()
	{
		global $post;
		$terms = get_the_terms( $post->ID, 'product_cat' );
		foreach ($terms as $term) {
			echo '<a class="product-category-link" href="' . esc_url(get_term_link($term->term_id)) . '">' . esc_html($term->name) . '</a>';
		}
	}

	public function shop_banner()
	{
		if(function_exists( 'is_shop' ) && is_shop()) {
			$shop_banner_url = teepro_get_options('nbcore_shop_banner');
			if ($shop_banner_url) {
				echo '<div class="shop-banner"><img src="' . esc_url(wp_get_attachment_url(absint($shop_banner_url))) . '" /></div>';
			}
		}
	}

	public function wc_review_avatar_size()
	{
		return '80';
	}

	public function wide_meta_left_div_open()
	{
		if('wide' === teepro_get_options('nbcore_pd_meta_layout')) {
			echo '<div class="pd-meta-left">';
		}
	}

	public function wide_meta_left_div_close()
	{
		if('wide' === teepro_get_options('nbcore_pd_meta_layout')) {
			echo '</div>';
		}
	}

	public function wide_meta_right_div_open()
	{
		if('wide' === teepro_get_options('nbcore_pd_meta_layout')) {
			echo '<div class="pd-meta-right">';
		}
	}

	public function wide_meta_right_div_close()
	{
		if('wide' === teepro_get_options('nbcore_pd_meta_layout')) {
			echo '</div>';
		}
    }
    
    public function woocommerce_custom_online_design_button()
    {
    global $product;
    if ( is_plugin_active( 'web-to-print-online-designer/nbdesigner.php' ) && get_post_meta($product->get_id(), '_nbdesigner_enable', true) ):

        $nbdesigner_position_button_product_detail = nbdesigner_get_option('nbdesigner_position_button_product_detail');

        if($nbdesigner_position_button_product_detail == 4):
    ?>
            <div class="wc-custom-online-desginer">
                <p class="custom-od-title"><?php esc_html_e('Online Desgin', 'teepro');?></p>
                <p class="custom-od-des"><?php esc_html_e('Combine it with our layouts and fonts.', 'teepro');?></p>
                <?php echo do_shortcode( '[nbdesigner_button]' );?>
            </div>

        <?php endif; ?>
    <?php endif; ?>

    <?php
    }

	public function wc_share_social()
	{
		if(teepro_get_options('nbcore_pd_show_social') && function_exists('nbcore_share_social')) {
			nbcore_share_social();
		}
	}

	public function cross_sells_limit()
	{
		$cross_sells_limit = teepro_get_options('nbcore_cross_sells_limit');
		return $cross_sells_limit;
	}

	public function upsells_limit()
	{
		$upsells_limit = teepro_get_options('nbcore_upsells_limit');
		return $upsells_limit;
	}

    public function quickview_button($button, $label, $product)
    {
        $html = '';
        if(teepro_get_options('product_category_quickview')) {
            global $product;

            $product_id = yit_get_prop( $product, 'id', true );

            $html = '<a href="#" class="button yith-wcqv-button bt-4" data-product_id="' . $product_id . '"><i class="icon-opened-eye"></i><span class="tooltip">' . $label . '</span></a>';

        }
        return $html;
	}

	public function upload_scripts()
    {
        wp_enqueue_script('media-upload');
        wp_enqueue_media();
    }

    public function add_cart_notice()
    {
        $settings_modules = !empty(get_option('solutions_core_settings')) ? get_option('solutions_core_settings') : array();
        if(! in_array('ajax-cart', $settings_modules)) {
            $url = wc_get_cart_url();
            ?>
            <div class="cart-notice-wrap">
                <div class="cart-notice">
                    <p><?php esc_html_e('Product has been added to cart', 'teepro'); ?></p>
                    <p class="cart-url button"><a href="<?php echo esc_url($url); ?>"><?php esc_html_e('View Cart', 'teepro'); ?></a></p>
                    <span><i class="icon-cancel-circle"></i></span>
                </div>
            </div>
            <?php
        }
    }
	
	public function add_attribute_fields() {
        ?>

        <div class="form-field">
            <label><?php esc_html_e( 'Thumbnail', 'teepro' ); ?></label>
            <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
            <div style="line-height: 60px;">
                <input type="hidden" name="is_attribute" value="1">
                <input type="hidden" id="product_attribute_thumbnail_id" name="product_attribute_thumbnail_id" />
                <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'teepro' ); ?></button>
                <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'teepro' ); ?></button>
            </div>
            <script type="text/javascript">
                ( function( $ ) {
                    "use strict";
                    // Only show the "remove image" button when needed
                    if ( ! $( '#product_attribute_thumbnail_id' ).val() ) {
                        $( '.remove_image_button' ).hide();
                    }

                    // Uploading files
                    var file_frame;

                    $( document ).on( 'click', '.upload_image_button', function( event ) {

                        event.preventDefault();

                        // If the media frame already exists, reopen it.
                        if ( file_frame ) {
                            file_frame.open();
                            return;
                        }

                        // Create the media frame.
                        file_frame = wp.media.frames.downloadable_file = wp.media({
                            title: '<?php esc_html_e( "Choose an image", 'teepro' ); ?>',
                            button: {
                                text: '<?php esc_html_e( "Use image", 'teepro' ); ?>'
                            },
                            multiple: false
                        });

                        // When an image is selected, run a callback.
                        file_frame.on( 'select', function() {
                            var attachment = file_frame.state().get( 'selection' ).first().toJSON();
                            $( '#product_cat_thumbnail_id' ).val( attachment.id );
                            $( '#product_cat_thumbnail img' ).attr( 'src', attachment.sizes.thumbnail.url );
                            $( '.remove_image_button' ).show();
                        });

                        // Finally, open the modal.
                        file_frame.open();
                    });

                    $( document ).on( 'click', '.remove_image_button', function() {
                        $( '#product_cat_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                        $( '#product_attribute_thumbnail_id' ).val( '' );
                        $( '.remove_image_button' ).hide();
                        return false;
                    });
                } )( jQuery );
            </script>
            <div class="clear"></div>
        </div>
    <?php
    }
	
	public function edit_attribute_fields( $term ) {
        $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );

        if ( $thumbnail_id ) {
            $image = wp_get_attachment_thumb_url( $thumbnail_id );
        } else {
            $image = wc_placeholder_img_src();
        }
        ?>

        <tr class="form-field">
            <th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'teepro' ); ?></label></th>
            <td>
                <div id="product_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
                <div style="line-height: 60px;">
                    <input type="hidden" name="is_attribute" value="1">
                    <input type="hidden" id="product_attribute_thumbnail_id" name="product_attribute_thumbnail_id" value="<?php echo esc_attr($thumbnail_id); ?>" />
                    <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'teepro' ); ?></button>
                    <button type="button" class="remove_image_button button"><?php esc_html_e( 'Remove image', 'teepro' ); ?></button>
                </div>
                <script type="text/javascript">
                    ( function( $ ) {
                        "use strict";
                        // Only show the "remove image" button when needed
                        if ( '0' === $( '#product_attribute_thumbnail_id' ).val() ) {
                            $( '.remove_image_button' ).hide();
                        }

                        // Uploading files
                        var file_frame;

                        $( document ).on( 'click', '.upload_image_button', function( event ) {

                            event.preventDefault();

                            // If the media frame already exists, reopen it.
                            if ( file_frame ) {
                                file_frame.open();
                                return;
                            }

                            // Create the media frame.
                            file_frame = wp.media.frames.downloadable_file = wp.media({
                                title: '<?php _e( "Choose an image", "teepro" ); ?>',
                                button: {
                                    text: '<?php _e( "Use image", "teepro" ); ?>'
                                },
                                multiple: false
                            });

                            // When an image is selected, run a callback.
                            file_frame.on( 'select', function() {
                                var attachment = file_frame.state().get( 'selection' ).first().toJSON();

                                $( '#product_attribute_thumbnail_id' ).val( attachment.id );
                                $( '#product_cat_thumbnail img' ).attr( 'src', attachment.url );
                                $( '.remove_image_button' ).show();
                            });

                            // Finally, open the modal.
                            file_frame.open();
                        });

                        $( document ).on( 'click', '.remove_image_button', function() {
                            $( '#product_cat_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
                            $( '#product_attribute_thumbnail_id' ).val( '' );
                            $( '.remove_image_button' ).hide();
                            return false;
                        });
                    } )( jQuery );


                </script>
                <div class="clear"></div>
            </td>
        </tr>
    <?php
    }
	
    public function save_attribute_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
        if ( isset( $_POST['product_attribute_thumbnail_id'] ) && isset($_POST['is_attribute']) && $_POST['is_attribute'] == 1 ) {
            update_woocommerce_term_meta( $term_id, 'thumbnail_id', absint( $_POST['product_attribute_thumbnail_id'] ) );
        }
    }

    /**
     *  Add the link to compare
     */
    public function add_compare_link( $product_id = false, $args = array() ) {
        extract( $args );

        if ( ! $product_id ) {
            global $product;
            $product_id = ! is_null( $product ) ? yit_get_prop( $product, 'id', true ) : 0;
        }

        // return if product doesn't exist
        if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
            return;

        $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

        if ( ! isset( $button_text ) || $button_text == 'default' ) {
            $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'teepro' ) );
            do_action ( 'wpml_register_single_string', 'Plugins', 'plugin_yit_compare_button_text', $button_text );
            $button_text = apply_filters( 'wpml_translate_single_string', $button_text, 'Plugins', 'plugin_yit_compare_button_text' );
        }

        printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>', $this->add_product_url( $product_id ), 'compare bt-4 real-compare-button' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );
    }

    /**
     * The URL to add the product into the comparison table
     *
     * @param int $product_id ID of the product to add
     * @return string The url to add the product in the comparison table
     */
    public function add_product_url( $product_id ) {
        $url_args = array(
            'action' => 'yith-woocompare-add-product',
            'id' => $product_id
        );

        $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;
        if( $lang ) {
            $url_args['lang'] = $lang;
        }

        return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args, site_url() ) ), 'yith-woocompare-add-product' );
    }

    public function thumb_open_tag() {
        echo '<div class="flex-control-wrapper">';
    }

    public function thumb_close_tag() {
        echo '</div>';
    }

    public function loop_columns()
	{		

        if ( ( function_exists( 'dokan_is_store_page') ) && dokan_is_store_page() ) {
            return teepro_get_options('nbcore_vendor_loop_columns');
        } else {
            return teepro_get_options('nbcore_loop_columns');
        }
	}

    public static function loop_columns_resp()
    {
        if ( ( function_exists( 'dokan_is_store_page') ) && dokan_is_store_page() ) {
            $nbcore_vendor_loop_columns['xl'] = teepro_get_options('nbcore_vendor_loop_columns_xl');
            $nbcore_vendor_loop_columns['lg'] = teepro_get_options('nbcore_vendor_loop_columns_lg');
            $nbcore_vendor_loop_columns['md'] = teepro_get_options('nbcore_vendor_loop_columns_md');
            $nbcore_vendor_loop_columns['sm'] = teepro_get_options('nbcore_vendor_loop_columns_sm');
            // return teepro_get_options('nbcore_vendor_loop_columns');
        } else {
            $nbcore_vendor_loop_columns['xl'] = teepro_get_options('nbcore_loop_columns_xl');
            $nbcore_vendor_loop_columns['lg'] = teepro_get_options('nbcore_loop_columns_lg');
            $nbcore_vendor_loop_columns['md'] = teepro_get_options('nbcore_loop_columns_md');
            $nbcore_vendor_loop_columns['sm'] = teepro_get_options('nbcore_loop_columns_sm');
            // return teepro_get_options('nbcore_loop_columns');
        }
        return $nbcore_vendor_loop_columns;
    }

    public function store_query_filter( $query ) {
        global $wp_query;

        $author = get_query_var( dokan_get_option( 'custom_store_url', 'dokan_general', 'store' ) );

        if ( !is_admin() && $query->is_main_query() && !empty( $author ) ) {
            $seller_info  = get_user_by( 'slug', $author );
            $store_info   = dokan_get_store_info( $seller_info->data->ID );
            $post_per_page = isset( $store_info['store_ppp'] ) && !empty( $store_info['store_ppp'] ) ? $store_info['store_ppp'] : teepro_get_options('nbcore_vendor_per_page');
            set_query_var( 'posts_per_page', $post_per_page );
            $query->set( 'post_type', 'product' );
            $query->set( 'author_name', $author );
            $query->query['term_section'] = isset( $query->query['term_section'] ) ? $query->query['term_section'] : array();

            if ( $query->query['term_section'] ) {
                $query->set( 'tax_query',
                    array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $query->query['term']
                        )
                    )
                );
            }
        }
    }
}

