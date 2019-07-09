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
$page_sidebar = teepro_get_options('nbcore_pages_sidebar');
$nbcore_page_image_banner_bottom = teepro_get_options('nbcore_pages_image_banner_bottom');
$nbcore_page_text_banner_bottom = teepro_get_options('nbcore_page_text_banner_bottom');

if(get_post_meta(get_the_ID(), 'nbcore_pages_title', true)) {
    teepro_page_title();
}
?>
	<div class="container">
		<div class="row">
			<div id="primary" class="content-area page-<?php echo esc_attr($page_sidebar); ?>">
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
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->
			<?php
            if('no-sidebar' !== $page_sidebar) {
                get_sidebar();
            }
			?>
		</div>
	</div>
    <?php
        $showbanner = '';
        $showbanner = get_post_meta($id, 'teepro_show_banner', true);
        if($showbanner)
        {
            if($nbcore_page_image_banner_bottom){ 
                $feat_image_url = wp_get_attachment_image_src( $nbcore_page_image_banner_bottom,'full' );?>
                    <div class="image_banner_pages" >
                        <div class="container" style ="background-image: url(<?php echo $feat_image_url[0]; ?>);">
                            <?php if($nbcore_page_text_banner_bottom) { ?>
                                <div class="text_banner_bottom_section">
                                    <?php echo $nbcore_page_text_banner_bottom;  ?>
                                </div>
                            <?php }?>
                        </div>
                    </div
            <?php } } ?>
<?php
get_footer();
