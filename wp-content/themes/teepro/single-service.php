<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package nbcore
 */

get_header();
$services_sidebar = teepro_get_options('nbcore_services_sidebar');
$nbcore_services_image_banner_bottom = teepro_get_options('nbcore_services_image_banner_bottom');
$nbcore_services_text_banner_bottom = teepro_get_options('nbcore_services_text_banner_bottom');
$nbcore_services_text_banner_top = teepro_get_options('nbcore_services_image_banner_top');
$service_image_top_url=array();
if($nbcore_services_text_banner_top){
    
    $service_image_top_url = wp_get_attachment_image_src( $nbcore_services_text_banner_top,'full' );
}

?>
<?php
   $nbcore_services_title = teepro_get_options('show_service_title');
    if($nbcore_services_title){
?>
    <div class="nb-page-title-wrap <?php if($service_image_top_url) {  echo 'bg_title_services bg_img'; } ?>" <?php if($service_image_top_url) { ?> style ="background-image:url('<?php echo $service_image_top_url[0]; ?>')" <?php } ?>>
        <div class="container">
            <div class="nb-page-title">
                <h1 class="entry-title">
                        <?php
                            echo esc_html( get_the_title() );
                        ?>
                </h1>
            </div>
        </div>
   </div>


<?php } ?>
	<div class="container">
		<div class="row services-<?php echo esc_attr($services_sidebar); ?>">
        
			<div id="primary" class="content-area ">
				<main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) : the_post();

						?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php
                            if('no-thumb' !== teepro_get_options('page_thumb')) {
                                teepro_featured_thumb();
                            }
                            ?>
                            <div class="entry-content">
                                <?php
                                the_content();

                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'teepro' ),
                                    'after'  => '</div>',
                                ) );
                                ?>
                            </div><!-- .entry-content -->
                        </article><!-- #post-## -->
                        <?php
					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
            </div><!-- #primary -->
            <?php if($services_sidebar != 'no-sidebar'):  ?>
                <?php if ( is_active_sidebar( 'service-sidebar' ) ) : ?>
                <div id="secondary" class="widget-area">
                    <div class="sidebar-wrapper">
                    <?php dynamic_sidebar( 'service-sidebar' ); ?>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif;  ?>

		</div>
	</div>

            <?php if($nbcore_services_image_banner_bottom){ $service_image_url = wp_get_attachment_image_src( $nbcore_services_image_banner_bottom,'full' );?>
                <div class="image_banner_services bg_bottom_service"style ="background-image: url(<?php echo $service_image_url[0]; ?>)" >
                    <div class="container ">
                        <?php if($nbcore_services_text_banner_bottom) {?>
                            <div class="text_banner_bottom_section_services">
                                <?php echo do_shortcode($nbcore_services_text_banner_bottom);  ?>
                            </div>
                        <?php }?>
                    </div>
                </div
            <?php } ?>
    
<?php
get_footer();
