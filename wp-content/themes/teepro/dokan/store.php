<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();

global $woocommerce_loop;
$cols = Teepro_Extensions_Woocommerce::loop_columns_resp();
$col_xl = isset($woocommerce_loop['cols_xl']) ? absint($woocommerce_loop['cols_xl']) : absint($cols['xl']);
$col_lg = isset($woocommerce_loop['cols_lg']) ? absint($woocommerce_loop['cols_lg']) : absint($cols['lg']);
$col_md = isset($woocommerce_loop['cols_md']) ? absint($woocommerce_loop['cols_md']) : absint($cols['md']);
$col_sm = isset($woocommerce_loop['cols_sm']) ? absint($woocommerce_loop['cols_sm']) : absint($cols['sm']);
$width_xl = absint(12 / $col_xl);
$width_lg = absint(12 / $col_lg);
$width_md = absint(12 / $col_md);
$width_sm = absint(12 / $col_sm);

get_header( 'shop' );
?>
    <?php do_action( 'woocommerce_before_main_content' ); ?>
    <div id="dokan-primary" class="dokan-single-store">
        <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

            <?php dokan_get_template_part( 'store-header' ); ?>

            <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

            <?php if ( have_posts() ) { ?>

				<?php do_action( 'woocommerce_before_shop_loop' ); ?>
                <div class="seller-items">
                    <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <div class="<?php echo 'col-xl-' . $width_xl . ' col-lg-' . $width_lg . ' col-md-' . $width_md . ' col-sm-' . $width_sm; ?>">
								<?php wc_get_template_part( 'content', 'product' ); ?>
							</div>

                        <?php endwhile; // end of the loop. ?>

                    <?php woocommerce_product_loop_end(); ?>

                </div>
				<?php dokan_content_nav( 'nav-below' ); ?>
            <?php } else { ?>

                <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'teepro' ); ?></p>

            <?php } ?>
        </div>

    </div><!-- .dokan-single-store -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer( 'shop' ); ?>