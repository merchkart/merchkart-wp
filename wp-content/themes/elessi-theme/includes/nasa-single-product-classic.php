<?php
$slideHoz = false;
if (isset($nasa_opt['product_detail_layout']) && $nasa_opt['product_detail_layout'] === 'classic' && isset($nasa_opt['product_thumbs_style']) && $nasa_opt['product_thumbs_style'] === 'hoz') {
    $slideHoz = true; 
}

$class_image = 'large-6 small-12 columns product-gallery rtl-right';
$class_info = 'large-6 small-12 columns product-info summary entry-summary left rtl-left';

if($slideHoz) {
    $class_image = 'large-6 small-12 columns product-gallery rtl-right desktop-padding-right-20 rtl-desktop-padding-right-10 rtl-desktop-padding-left-20';
    $class_info = 'large-6 small-12 columns product-info summary entry-summary left rtl-left';
}
?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
        <div class="div-toggle-sidebar center">
            <a class="toggle-sidebar" href="javascript:void(0);"><i class="fa fa-bars"></i> <?php esc_html_e('Sidebar', 'elessi-theme'); ?></a>
        </div>
    <?php endif; ?>
    
    <div class="row nasa-product-details-page">
        <div class="<?php echo esc_attr($main_class); ?>" data-num_main="1" data-num_thumb="6" data-speed="300">
            <div class="row">
                <div class="<?php echo $class_image; ?>"> 
                    <?php do_action('woocommerce_before_single_product_summary'); ?>
                </div>
                
                <div class="<?php echo $class_info; ?>">
                    <?php do_action('woocommerce_single_product_summary'); ?>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>

        </div>

        <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">     
                <div class="inner">
                    <?php dynamic_sidebar('product-sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>