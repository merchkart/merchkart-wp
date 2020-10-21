<?php if( $show_bestseller ) : ?>
<?php
$limit_bestseller				= cerio_get_config('bestseller_limit',9);
$product_visibility_term_ids 	= wc_get_product_visibility_term_ids();
$product_col_large		= cerio_get_config('product_col_large',4);	
$product_col_medium 	= cerio_get_config('product_col_medium',3);
$product_col_sm 		= cerio_get_config('product_col_sm',1);
$product_col_xs 		= cerio_get_config('product_col_xs',1);
if( $id_category != 0 ){
	$args = array(
		'post_type'				=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' 		=> $limit_bestseller,
		'tax_query'	=> array(
			array(
				'taxonomy'	=> 'product_cat',
				'field'		=> 'term_id',
				'terms'		=> $id_category
			),
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['featured'],
			)						
		)
	);
}else{
	$args = array(
		'post_type'				=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' 		=> $limit_bestseller,
		'tax_query'	=> array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['featured'],
			)						
		)
	);	
}
$list = new \WP_Query( $args );
?>
<div class="bestseller-product">
	<div class="title-box">
		<h2 class="title-bestseller"><?php echo esc_html__("Bestseller Products","cerio") ?></h2>
		<a class="view-all" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php echo esc_html__("View all products","cerio") ?></a>
	</div>
	<div class="slick-carousel products-list grid" data-slidestoscroll="true" data-dots="false" data-nav="true" data-columns4="1" data-columns3="1" data-columns2="<?php echo esc_attr($product_col_sm); ?>" data-columns1="<?php echo esc_attr($product_col_medium); ?>" data-columns="<?php echo esc_attr($product_col_large); ?>">	
	<?php while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average; ?>
		<div class="item">
			<?php wc_get_template_part( 'content-grid', 'product' ); ?>
		</div>
	<?php endwhile; wp_reset_postdata(); ?>
	</div>
</div>
<?php endif; ?>