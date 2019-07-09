<?php if (!defined('ABSPATH')) exit; 
if(count($templates)):  ?>
<?php
    
    $UrlPageNBD = getUrlPageNBD('create');
    foreach ($templates as $key => $temp): 
    $link_template = add_query_arg(array(
        'product_id' => $temp['product_id'],
        'variation_id' => $temp['variation_id'],
        'reference'  =>  $temp['folder']
    ), $UrlPageNBD);       
    $gallery_type = 1;
?>
    <div class="nbdesigner-item" data-id="<?php echo $temp['tid']; ?>" data-img="<?php echo $temp['image']; ?>" data-title="<?php echo $temp['title']; ?>">
        <div class="nbd-gallery-item">
            <div class="nbd-gallery-item-inner">
                <a href="<?php echo $link_template; ?>" onclick="previewTempalte(event, <?php echo $temp['tid']; ?>)">
                    <img src="<?php echo $temp['image']; ?>" class="nbdesigner-img"/>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach;
    else: ?>    
    <?php //todo something ?>
<?php endif;