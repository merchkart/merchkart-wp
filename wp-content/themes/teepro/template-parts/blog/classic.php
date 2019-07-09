<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package nbcore
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
        <?php
        teepro_get_categories();
        the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
        teepro_posted_on();
        if(teepro_get_options('nbcore_blog_archive_comments')):?>
            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                <span class="comments-link"><i class="icon-speech-bubble"></i><?php comments_popup_link( esc_html__( 'Leave a comment', 'teepro' ), esc_html__( 'One Comment', 'teepro' ), esc_html__( '% Comments', 'teepro' ) ); ?></span>
            <?php endif; ?>
        <?php endif;
        teepro_featured_thumb();
		if(teepro_get_options('nbcore_blog_archive_summary')):
		?>
		<div class="entry-text">
			<?php
			if(teepro_get_options('nbcore_excerpt_only')) {
				teepro_get_excerpt();
				echo '<div class="read-more-link"><a class="bt-4 nb-secondary-button" href="' . get_permalink() . '">' . esc_html__('View post', 'teepro') . '<span>&rarr;</span></a></div>';
			} else {
				the_content( sprintf(
				/* translators: %s: Name of current post. */
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'teepro' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'teepro' ),
					'after'  => '</div>',
				) );
			}			
			?>
		</div>
		<?php endif; ?>
        <div class="entry-footer">
		    <?php teepro_get_tags(); ?>
        </div>
	</div>
	
</article><!-- #post-## -->
