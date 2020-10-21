<?php 
	global $instance;
	$format = get_post_format();
	$class = 'masonry-post '.esc_attr(cerio_get_class()->class_item_blog);
?>
<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class($class); ?>>
	<div class="entry-post">
		<?php if( empty($format) || $format == 'image' || $format == 'quote') : ?>	
			<?php if ( get_the_post_thumbnail() ){?>
			<div class="entry-thumb single-thumb">
				<a class="post-thumbnail" href="<?php echo esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'post-large' )?>				
				</a>
			</div>
			<?php } ?>
		<?php elseif( $format == 'video' || $format == 'audio' ) : ?>
			<div class="entry-thumb single-thumb">
				<a class="post-thumbnail" href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'post-large', array( 'alt' => get_the_title() ) );	?>      
				</a> 
			</div>	
		<?php elseif( $format == 'gallery' ) : 
			$ids = "";	
			if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
				$attrs = array();
					if (count($matches[1])>0){
						foreach ($matches[1] as $m){
							$attrs[] = shortcode_parse_atts($m);
						}
					}
					if (count($attrs)> 0){
						foreach ($attrs as $attr){
							if (is_array($attr) && array_key_exists('ids', $attr)){
								$ids = $attr['ids'];
								break;
							}
						}
					}
				?>
				<div class="entry-thumb">
					<div id="gallery_slider_<?php echo esc_attr($post->ID); ?>" class="gallery-slider">	
						<div class="slick-carousel" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns="1" data-nav="true">
								<?php
									if($ids){
										$ids = explode(',', $ids);						
										foreach ( $ids as $i => $id ){ ?>
											<div class="item">
													<?php echo wp_get_attachment_image($id, 'post-large'); ?>
											</div>
										<?php }	
									}
								?>
						</div>
					</div>
				</div>
				<?php }	?>			
		<?php endif; ?>
		<div class="post-content">
        	<?php if( bwp_category_post()){ ?>
				<div class="post-categories">
					<a href="<?php echo esc_url(bwp_category_post()->cat_link);?>"><?php echo esc_html(bwp_category_post()->name); ?></a>
				</div>
			<?php } ?>
        	<h3 class="entry-title"><a href="<?php echo esc_url(the_permalink()) ?>"><?php echo the_title(); ?></a></h3>
        	<?php
        		if (cerio_get_config('blog-excerpt')) {
                    echo cerio_get_excerpt( cerio_get_config('list-blog-excerpt-length',30), false);
                }
			?>
			<div class="post-date">
				<span><?php echo cerio_time_link(); ?></span>
			</div>
		</div>
	</div>
</article><!-- #post-## -->