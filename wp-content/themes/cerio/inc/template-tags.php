<?php
if ( ! function_exists( 'cerio_paging_nav' ) ) :
function cerio_paging_nav() {
	global $wp_query, $wp_rewrite;
	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );
	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}
	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
	// Set up paginated links.
	$pagination = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( 'Previous', 'cerio' ),
		'next_text' => esc_html__( 'Next', 'cerio' ),
		'type'      => 'list'
	) );
	if ( $pagination ) :
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'cerio' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo wp_kses($pagination,'social'); ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;
if ( ! function_exists( 'cerio_post_nav' ) ) :
function cerio_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<div class="prevNextArticle box">
		<div class="previousArticle">
			<?php previous_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Previous article','cerio').'</span></div><div class="title">%title</div>' ); ?>
		</div>
		<div class="nextArticle">
			<?php next_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Next article','cerio').'</span></div><div class="title">%title</div>' ); ?>
		</div>
	</div><!-- Previous / next article -->
	<?php
}
endif;
function cerio_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'cerio_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'cerio_category_count', $all_the_cool_cats );
	}
	if ( 1 !== (int) $all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}
function cerio_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'cerio_category_count' );
}
add_action( 'edit_category', 'cerio_category_transient_flusher' );
add_action( 'save_post',     'cerio_category_transient_flusher' );
if ( ! function_exists( 'cerio_post_thumbnail' ) ) :
function cerio_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	if ( is_singular() ) : ?>
		<div class="post-thumbnail">
		<?php the_post_thumbnail( 'cerio-full-width' ); ?>
		</div>
	<?php else : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'cerio-full-width' ); ?>
		</a>
	<?php endif; // End is_singular()
}
endif;
if ( ! function_exists( 'cerio_single_posted_on' ) ) :
function cerio_single_posted_on() { 
	global $cerio_settings,$post; ?>
	<div class="entry-meta">
		<!-- Categories -->
		<?php $categories_list = get_the_category_list( __( ', ', 'cerio' ) );
		if ( $categories_list ) : ?>
			<span class="cat-links">
				<span><?php echo esc_html__('', 'cerio'); ?></span>
				<?php echo wp_kses( $categories_list,'social' ); ?>
			</span>
		<?php endif; ?>
		<!-- End if categories. -->
	</div>			
<?php }
endif;
if ( ! function_exists( 'cerio_single_posted_on_2' ) ) :
function cerio_single_posted_on_2(){
	global $cerio_settings,$post;?>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
		<span class="sticky-post"><?php echo esc_html__( 'Featured', 'cerio' ) ?></span>
	<?php } ?>
	<?php if (cerio_get_config('archives-author')) { ?>
		<div class="entry-author">
			<span class="entry-meta-link"><i class="icon-user"></i><?php echo the_author_posts_link(); ?></span>
		</div>
	<?php } ?>		
	<span class="post-date">
		<i class="icon-calendar"></i><?php echo cerio_time_link(); ?>
	</span>
	<div class="comments-link">
		<i class="icon-coment"></i>
		<a href="<?php echo esc_attr('#respond'); ?>" >
			<?php 
			$comment_count =  wp_count_comments(get_the_ID())->total_comments;
			if($comment_count > 0) {
			?>
				<?php if($comment_count == 1){?>
					<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comment', 'cerio').'</span>'; ?>
				<?php }else{ ?>
					<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'cerio').'</span>'; ?>
				<?php } ?>
			<?php }else{ ?>
				<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'cerio').'</span>'; ?>
			<?php } ?>
		</a>
	</div>
<?php }
endif;
if ( ! function_exists( 'cerio_single_author' ) ) :
function cerio_single_author(){
	global $cerio_settings,$post;
	$user_description = get_user_meta( get_the_author_meta( 'ID' ), 'description', true ); ?>
	<?php if ( cerio_get_config('archives-author',true) && $user_description ) { ?>
		<div class="entry-meta-author">
			<div class="author-avatar">
				<span class="author-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100); ?> </span>
			</div>
			<div class="author-info">
				<span class="author-link"><?php the_author_posts_link(); ?></span>
				<span class="author-description"><?php the_author_meta('description'); ?></span>
			</div>
		</div>	
	<?php } ?>
<?php }
endif;
if ( ! function_exists( 'cerio_posted_on' ) ) :
function cerio_posted_on() { 
	global $cerio_settings,$post; ?>
		<div class="entry-meta">
			<div class="post-date">
				<span><i class="fa fa-clock-o"></i><?php echo cerio_time_link(); ?></span>
			</div>
			<?php if (cerio_get_config('archives-author')) { ?>
				<div class="entry-author">
					<span class="entry-meta-link"><i class="fa fa-pencil-square-o"></i><?php the_author_posts_link(); ?></span>
				</div>
			<?php } ?>
			<div class="comments-link">
				<i class="fa fa-comment"></i>
				<?php 
				$comment_count =  wp_count_comments(get_the_ID())->total_comments;
				if($comment_count > 0) {
				?>
					<?php if($comment_count == 1){?>
						<a href="<?php comments_link(); ?>"><?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comment', 'cerio').'</span>'; ?></a>
					<?php }else{ ?>
						<a href="<?php comments_link(); ?>"><?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'cerio').'</span>'; ?></a>
					<?php } ?>
				<?php }else{ ?>
					<?php echo '<span class="no-comment">'. esc_html__('No Comments', 'cerio').'</span>'; ?>
				<?php } ?>
			</div>
		</div>			
<?php }
endif;
if ( ! function_exists( 'cerio_posted_on_2' ) ) :
function cerio_posted_on_2() { 
	global $cerio_settings,$post; ?>	
		<?php if (cerio_get_config('archives-author')) { ?>
			<div class="entry-author">
				<span class="entry-meta-link"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
			</div>
		<?php } ?>
		<div class="entry-date">
			<i class="fa fa-calendar"></i>
			<?php echo cerio_time_link(); ?>
		</div>
<?php }
endif;
if ( ! function_exists( 'cerio_entry_footer' ) ) :
	function cerio_entry_footer() {
		edit_post_link(
			sprintf(
				wp_kses(
					__( 'Edit <span class="screen-reader-text">%s</span>', 'cerio' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;
if ( ! function_exists( 'cerio_time_link' ) ) :
	function cerio_time_link() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%3$s, %4$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%3$s, %4$s</time><time class="updated" datetime="%6$s">%7$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			get_the_date( DATE_W3C ),
			get_the_date('l'),
			get_the_date('F j'),
			get_the_date('Y'),
			get_the_date('g:i a'),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);
		return sprintf(
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}
endif;
function cerio_get_page_title(){
	global $cerio_settings;
	$enable_breadcrumb = cerio_get_config('breadcrumb',true);
	$enable_page_title = cerio_get_config('page_title',true);
	$layout_breadcrumb = cerio_get_config('layout_breadcrumb','layout_1');
	$show_subcategories = cerio_get_config('show-subcategories',false);
	$subcategories_style = cerio_get_config('style-subcategories','image_categories');
	$bg_default = isset($cerio_settings['page_title_bg']['url']) ? $cerio_settings['page_title_bg']['url'] : "";
	if( function_exists('is_product_category') && is_product_category()){
		$current_category = get_queried_object();
		$category_bg_breadcrumb = get_term_meta( $current_category->term_id, 'category_bg_breadcrumb', true );
		$bg = !empty($category_bg_breadcrumb) ? $category_bg_breadcrumb : $bg_default;
	}else{
		$bg = $bg_default;
	}
	$class_empty = (empty($bg)) ? " empty-image" : ""; ?>
	<?php if( !is_single() ): ?>
		<div data-bg_default ="<?php echo esc_attr($bg_default); ?>" class="page-title bwp-title<?php echo esc_attr($class_empty); ?>" <?php echo (!empty($bg) ? ' style="background-image:url(' .esc_url($bg). ');"' : ''); ?>>
			<div class="container" >	
			<?php if($enable_page_title): ?>
				<?php cerio_page_title(); ?>
			<?php endif;
			if($enable_breadcrumb): ?>
				<?php
					if(function_exists('is_woocommerce') && is_woocommerce()){
						if (class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page()){
							get_template_part( 'breadcrumb');
						}else{
							cerio_woocommerce_breadcrumb();
						}
					}else{
						get_template_part( 'breadcrumb');
					}		
				?>			
			<?php endif; ?>
			<?php if( apply_filters( 'cerio_custom_category', $html = '' ) && $show_subcategories && function_exists('is_woocommerce') && is_woocommerce() ){ ?>
				<?php
					$sub_col_large 		= cerio_get_config('sub_col_large',6);
					$sub_col_medium 	= cerio_get_config('sub_col_medium',4);
					$sub_col_sm 		= cerio_get_config('sub_col_sm',3);
				?>
				<?php if ($subcategories_style!="shop_mini_categories") { ?>
				<div class="woocommerce-product-subcategorie-content">
					<div class="subcategorie-content">
						<ul class="woocommerce-product-subcategories   slick-carousel <?php echo esc_attr($subcategories_style) ?>" data-nav="true" data-columns4="1" data-columns3="2" data-columns2="<?php echo esc_attr($sub_col_sm); ?>" data-columns1="<?php echo esc_attr($sub_col_medium); ?>" data-columns="<?php echo esc_attr($sub_col_large); ?>">
							<?php echo (apply_filters( 'cerio_custom_category', $html = '' )); ?>
						</ul>
					</div>
				</div>
				<?php } ?>
			<?php } ?>
			</div>
		</div><!-- .container -->
	<?php else: ?>
		<div class="breadcrumb-noheading">
			<div class="container">
			<?php if(function_exists('is_woocommerce') && is_woocommerce()){
				if (class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page()){
					get_template_part( 'breadcrumb');
				}else{
					cerio_woocommerce_breadcrumb();
				}
			}else{
				get_template_part( 'breadcrumb');
			} ?>
			</div>
		</div>	
	<?php endif; ?>
<?php }
function cerio_page_title() {
	global $post; ?>
	<div class="content-title-heading">
		<span class="back-to-shop"><?php echo apply_filters( 'woocommerce_page_title', esc_html__('Shop', 'cerio') ); ?></span>
		<h1 class="text-title-heading">
			<?php						
			if( is_category() ) :
				single_cat_title();
			elseif (class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page()) :
				$vendor_shop 		= urldecode( get_query_var( 'vendor_shop' ) );
				$vendor_id   		= WCV_Vendors::get_vendor_id( $vendor_shop );
				$shop_name 			= WCV_Vendors::get_vendor_shop_name( stripslashes( $vendor_id ) );
			echo esc_html($shop_name);
			elseif (class_exists("WeDevs_Dokan") && dokan()->vendor->get( get_query_var( 'author' ) ) && get_query_var( 'author' ) != 0 ) :
				$store_user    = dokan()->vendor->get( get_query_var( 'author' ) );
				$shop_name 			= $store_user->get_shop_name();
				echo esc_html($shop_name);							
			elseif ( is_tax() ) :
				single_tag_title();	
			elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
				esc_html_e( 'Galleries', 'cerio' );
			elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
				esc_html_e( 'Images', 'cerio' );
			elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
				esc_html_e( 'Videos', 'cerio' );
			elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
				esc_html_e( 'Quotes', 'cerio' );
			elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
				esc_html_e( 'Audios', 'cerio' );
			elseif ( is_archive() && is_author() ) :
				esc_html_e( 'Posts by " ', 'cerio' ) . the_author() . esc_html_e(' " ','cerio');
			elseif ( function_exists('is_shop') && is_shop() ) :							
				esc_html_e( 'Shop', 'cerio' );
			elseif ( is_archive() && !is_search()) :						
				the_archive_title();
			elseif ( is_search() ) :
				printf( esc_html__( 'Search for: %s', 'cerio' ), get_search_query() );
			elseif ( is_404() ) :
				esc_html_e( '404 Error', 'cerio' );
			elseif ( is_singular( 'knowledge' ) ) :
				esc_html_e( 'Knowledge Base', 'cerio' );
			elseif ( is_home() ) :
				esc_html_e( 'Posts', 'cerio' );
			else :
				echo get_the_title();
			endif;
			?>
		</h1>
	</div><!-- Page Title -->
<?php }
?>