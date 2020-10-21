<?php
if ($wp_query->post_count) :
    $_delay = $count = 0;
    $_delay_item = (isset($nasa_opt['delay_overlay']) && (int) $nasa_opt['delay_overlay']) ? (int) $nasa_opt['delay_overlay'] : 100;
    
    $wrapper_class = '';
    if (isset($nasa_opt['loop_layout_buttons']) && $nasa_opt['loop_layout_buttons'] != '') {
        $wrapper_class = 'nasa-' . $nasa_opt['loop_layout_buttons'];
    }

    while ($wp_query->have_posts()) :
        $wp_query->the_post();
        
        wc_get_template(
            'content-product.php',
            array(
                '_delay' => $_delay,
                'wrapper' => 'li',
                'wrapper_class' => $wrapper_class
            )
        );
        $_delay += $_delay_item;
        $count++;
    endwhile;
    wp_reset_postdata();
endif;
