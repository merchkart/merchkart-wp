<?php
$countItems = count($wishlist_items);
?>

<!-- WISHLIST TABLE -->
<table class="shop_table wishlist_table wishlist-fragment">
    <tbody>
        <?php if ($countItems > 0) :
            foreach ($wishlist_items as $item) :
                global $product;
                $product = wc_get_product($item);
                
                if (empty($product)) :
                    continue;
                endif;
                
                $productId = $product->get_id();
                $status = $product->get_status();
                
                if (!$product->is_visible() || $status != 'publish') : ?>
                    <tr class="nasa-tr-wishlist-item hidden-tag item-invisible" id="nasa-wishlist-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                        <td class="product-remove" colspan="2">
                            <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist btn-wishlist btn-nasa-wishlist nasa-added" title="<?php esc_attr_e('Remove this product', 'elessi-theme'); ?>" data-prod="<?php echo (int) $productId; ?>">
                                <?php esc_html_e('Remove', 'elessi-theme') ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                    continue;
                endif;

                $availability = $product->get_availability();
                $stock_status = isset($availability['class']) ? $availability['class'] : 'in-stock';
                ?>
                <tr class="nasa-tr-wishlist-item" id="nasa-wishlist-row-<?php echo (int) $productId; ?>" data-row-id="<?php echo (int) $productId; ?>">
                    <td class="product-wishlist-info">
                        <div class="wishlist-item-warper nasa-relative">
                            <div class="row wishlist-item">
                                <div class="image-wishlist large-4 small-4 columns padding-left-0">
                                    <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                        <?php echo $product->get_image('thumbnail'); ?>
                                    </a>
                                </div>

                                <div class="info-wishlist large-8 small-8 columns padding-right-0">
                                    <div class="row">
                                        <div class="large-12 columns nasa-wishlist-title">
                                            <a href="<?php echo esc_url(get_permalink(apply_filters('woocommerce_in_cart_product', $productId))); ?>">
                                                <?php echo apply_filters('woocommerce_in_cartproduct_obj_title', $product->get_name(), $product); ?>
                                            </a>
                                        </div>

                                        <div class="wishlist-price large-12 columns">
                                            <span class="price">
                                                <?php echo $product->get_price_html(); ?>
                                            </span>
                                            <?php
                                            if ($stock_status == 'out-of-stock') :
                                                echo '<span class="wishlist-out-of-stock">' . esc_html__(' - Out of Stock', 'elessi-theme') . '</span>';
                                            else :
                                                echo '<span class="wishlist-in-stock">' . esc_html__(' - In Stock', 'elessi-theme') . '</span>';
                                            endif;
                                            ?>
                                        </div>

                                        <?php if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) :?>
                                            <div class="add-to-cart-wishlist large-12 columns">
                                                <?php 
                                                if ($stock_status != 'out-of-stock'):
                                                    echo elessi_add_to_cart_in_wishlist();
                                                endif;
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="product-remove">
                        <a href="javascript:void(0);" class="remove nasa-remove_from_wishlist btn-wishlist btn-nasa-wishlist nasa-added" title="<?php esc_attr_e('Remove this product', 'elessi-theme'); ?>" data-prod="<?php echo (int) $productId; ?>">
                            <?php esc_html_e('Remove', 'elessi-theme') ?>
                        </a>
                    </td>
                </tr>
                
            <?php endforeach;
        else: ?>
            <tr>
                <td class="wishlist-empty">
                    <p class="empty">
                        <i class="nasa-empty-icon icon-nasa-like"></i>
                        <?php esc_html_e('No products were added to the wishlist.', 'elessi-theme') ?>
                        <a href="javascript:void(0);" class="button nasa-sidebar-return-shop"><?php echo esc_html__('RETURN TO SHOP', 'elessi-theme'); ?></a>
                    </p>
                </td>
            </tr>
        <?php
        endif; ?>
    </tbody>

</table>
