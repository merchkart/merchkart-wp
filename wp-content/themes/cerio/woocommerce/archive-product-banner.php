<?php if( $id_category != 0 && $show_banner){
	$banner 		= get_term_meta( $id_category, 'category_banner', true );
	$title 			= get_term_meta( $id_category, 'category_title_banner', true );
	$subtitle 		= get_term_meta( $id_category, 'category_subtitle_banner', true );
	$button 		= get_term_meta( $id_category, 'category_button_banner', true );
	$link_button 	= get_term_meta( $id_category, 'category_link_button', true );
?>
<?php if( isset($banner) && !empty($banner) ) : ?>
	<div class="banner-shop">
		<div class="item-thumbnail">
			<img src="<?php echo esc_url($banner); ?>" alt="<?php echo esc_attr__("banner category","cerio");?>" />
		</div>
		<div class="content">
			<?php if( isset($subtitle) && !empty($subtitle) ) : ?>
				<div class="subtitle"><?php echo esc_html($subtitle); ?></div>
			<?php endif; ?>
			<?php if( isset($title) && !empty($title) ) : ?>
				<h2 class="title"><?php echo esc_html($title); ?></h2>
			<?php endif; ?>
			<?php if( isset($button) && !empty($button) &&  isset($link_button) && !empty($link_button) ) : ?>
			<div class="button">
				<a href="<?php echo esc_url($link_button) ?>"><?php echo esc_html($button); ?></a>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
<?php } ?>