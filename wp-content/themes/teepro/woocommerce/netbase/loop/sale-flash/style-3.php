<?php
global $post, $product;
echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale sale-style-3"><span class="percent">' . esc_html__( 'Sale', 'teepro' ) . '</span></span>', $post, $product );