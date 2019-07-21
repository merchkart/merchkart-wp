<?php
$k = 1;
$class_small = 'large-2 medium-3 small-6 columns';
$class_large = 'large-6 medium-6 small-6 columns';
$custom_class = isset($custom_class) ? $custom_class : '';

while ($loop->have_posts()) :
    $loop->the_post();
    $class_wrap = in_array($k, array(4, 5, 12, 13)) ? $class_large : $class_small;
    $class_wrap .= $custom_class ? ' ' . $custom_class : '';
    ?>
    <div class="nasa-masonry-item padding-left-5 padding-right-5 <?php echo $class_wrap; ?>">
        <?php 
        wc_get_template(
            'content-product.php',
            array(
                'wrapper' => 'div'
            )
        );
        ?>
    </div>
<?php 
$k++;
endwhile;
