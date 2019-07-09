<div class="nbd-category nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Design Category', 'teepro'); ?></p>
    <div class="nbd-sidebar-con-inner">
    <?php
        $walker = new NBD_Category();
        echo "<ul>";
        echo call_user_func_array( array(&$walker, 'walk'), array($categories, 0, array()) );
        echo "</ul>";
    ?>
    </div>    
</div>    
<div class="nbd-designers nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Designer', 'teepro'); ?></p>
    <div class="nbd-sidebar-con-inner">
        <?php foreach( $designers as $designer ): 
            $link_designer = add_query_arg(array('id' => $designer['art_id']), getUrlPageNBD('designer'));
        ?>
        <a href="<?php echo $link_designer; ?>" class="nbd-tag"><span><?php echo $designer['art_name']; ?></span></a>        
        <?php endforeach; ?>
    </div>
</div>  
<div class="nbd-designers nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Products', 'teepro'); ?></p>
    <div class="nbd-sidebar-con-inner">
        <div class="nbd-tem-list-product-wrap">
            <ul>
            <?php        
            foreach( $products as $key => $product ): 
                $link_prodcut_templates = add_query_arg(array('pid' => $product['product_id']), getUrlPageNBD('gallery'));
            ?>
                <li class="nbd-tem-list-product <?php if($key > 14) echo 'nbd-hide'; ?>">
                    <a class="<?php if($pid == $product['product_id']) echo 'active'; ?>" href="<?php echo $link_prodcut_templates; ?>">                   
                        <svg class="before" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" d="M0 0h24v24H0z"/>
                            <path d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z"/>
                        </svg>    
                        <span><?php echo $product['name']; ?></span>
                    </a>
                </li>        
            <?php endforeach; ?>  
            </ul>
            <?php if(count($products) > 15): ?>
            <a class="nbd-see-all" href="javascript:void(0)" onclick="showAllProduct( this )"><?php _e('See All', 'teepro'); ?></a>
            <?php endif; ?>
        </div>   
    </div>
</div>
<div class="nbd-designers nbd-sidebar-con">
    <p class="nbd-sidebar-h3"><?php _e('Wishlist', 'teepro'); ?></p>
    <div class="nbd-sidebar-con-inner wishlist">
        <?php foreach( $fts as $t ): ?>
        <div class="wishlist-tem-wrap" data-id="<?php echo $t['id']; ?>">
            <div class="left" onclick="previewTempalte(event, <?php echo $t['id']; ?>)">
                <img src="<?php echo $t['img']; ?>" class="nbdesigner-img"/>
            </div>
            <div class="right">
                <div><?php _e('Template for', 'teepro'); ?></div>
                <div><?php echo $t['title']; ?></div>
            </div>
        </div>    
        <?php endforeach; ?>
    </div>    
</div>
<script>
    var showAllProduct = function(e){
        jQuery(e).hide();
        jQuery('.nbd-tem-list-product-wrap').addClass('see-all');
        jQuery('.nbd-tem-list-product-wrap ul li').removeClass('nbd-hide');
    }
</script>