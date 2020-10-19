<?php
$close = NASA_WOO_ACTIVED ? is_product() : false;
$is_close = apply_filters('nasa_close_mobile_bottom_bar', $close);
if ($is_close) :
    return;
endif;

$is_cart = true;
if (!NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) :
    $is_cart = false;
endif;

$shopPageLink = NASA_WOO_ACTIVED ? wc_get_page_permalink('shop') : home_url('/');

$icon_home = apply_filters('nasa_bot_icon_home', '<i class="nasa-icon pe-7s-home"></i>');
$icon_filter = apply_filters('nasa_bot_icon_filter', '<i class="nasa-icon pe-7s-filter"></i>');
$icon_cats = apply_filters('nasa_bot_icon_filter_cats', '<i class="nasa-icon pe-7s-keypad"></i>');
$icon_search = apply_filters('nasa_bot_icon_search', '<i class="nasa-icon pe-7s-search"></i>');
?>

<ul class="nasa-bottom-bar-icons">
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-shop" href="<?php echo esc_url($shopPageLink); ?>" title="<?php echo esc_attr__('Shop', 'elessi-theme'); ?>">
            <?php echo $icon_home; ?>
            <?php echo esc_html__('Shop', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-sidebar hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-sidebar" href="javascript:void(0);" title="<?php echo esc_attr__('Filters', 'elessi-theme'); ?>">
            <?php echo $icon_filter; ?>
            <?php echo esc_html__('Filters', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item">
        <a class="nasa-bot-icons nasa-bot-icon-categories filter-cat-icon-mobile" href="javascript:void(0);" title="<?php echo esc_attr__('Categories', 'elessi-theme'); ?>">
            <?php echo $icon_cats; ?>
            <?php echo esc_html__('Categories', 'elessi-theme'); ?>
        </a>
    </li>
    
    <li class="nasa-bot-item nasa-bot-item-search hidden-tag">
        <a class="nasa-bot-icons nasa-bot-icon-search botbar-mobile-search" href="javascript:void(0);" title="<?php echo esc_attr__('Search', 'elessi-theme'); ?>">
            <?php echo $icon_search; ?>
            <?php echo esc_html__('Search', 'elessi-theme'); ?>
        </a>
    </li>
    
    <?php
    /**
     * Cart bottom bar
     */
    if ($is_cart) :
        $icon_number = isset($nasa_opt['mini-cart-icon']) ? $nasa_opt['mini-cart-icon'] : '1';
        switch ($icon_number) :
            case '2':
                $icon_class = 'nasa-font-icon icon-nasa-cart-2';
                break;
            
            case '3':
                $icon_class = 'nasa-font-icon icon-nasa-cart-4';
                break;
            
            case '4':
                $icon_class = 'pe-7s-cart';
                break;
            
            case '5':
                $icon_class = 'fa fa-shopping-cart';
                break;
            
            case '6':
                $icon_class = 'fa fa-shopping-bag';
                break;
            
            case '7':
                $icon_class = 'fa fa-shopping-basket';
                break;
            
            case '1':
            default:
                $icon_class = 'nasa-font-icon icon-nasa-cart-3';
                break;
        endswitch;
        
        $icon_class = apply_filters('nasa_mini_icon_cart', $icon_class);
        ?>
        <li class="nasa-bot-item">
            <a class="nasa-bot-icons nasa-bot-icon-cart botbar-cart-link" href="javascript:void(0);" title="<?php echo esc_attr__('Cart', 'elessi-theme'); ?>">
                <i class="nasa-icon <?php echo $icon_class; ?>"></i>
                <?php echo esc_html__('Cart', 'elessi-theme'); ?>
            </a>
        </li>
    <?php endif; ?>
</ul>
