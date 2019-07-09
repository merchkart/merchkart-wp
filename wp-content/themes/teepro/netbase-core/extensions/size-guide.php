<?php

// Add metaboxes
if( ! function_exists( 'teepro_add_metaboxes_size_guide' ) ) {

    function teepro_add_metaboxes_size_guide() {

        //Add table
        add_meta_box( 'teepro_size_guide_metaboxes', esc_html__( 'Create/edit size guide table', 'teepro' ), 'teepro_size_guide_metaboxes', 'teepro_size_guide', 'normal', 'default' );
        
        //Add dropdown to product
        add_meta_box( 'teepro_size_guide_dropdown_template', esc_html__( 'Choose size guide for this product', 'teepro' ), 'teepro_size_guide_dropdown_template', 'product', 'side' );

        //Add category 
        add_meta_box( 'teepro_size_guide_category_template', esc_html__( 'Choose product categories', 'teepro' ), 'teepro_size_guide_category_template', 'teepro_size_guide', 'side' );

        //Add hide table checkbox
        add_meta_box( 'teepro_size_guide_hide_table_template', esc_html__( 'Hide size guide table', 'teepro' ), 'teepro_size_guide_hide_table_template', 'teepro_size_guide', 'side' );
    }
    add_action( 'add_meta_boxes', 'teepro_add_metaboxes_size_guide' );
}

//Save Edit Table Action
add_action( 'save_post_teepro_size_guide', 'teepro_size_guide_save_table' );

add_action( 'save_post_teepro_size_guide', 'teepro_size_guide_save_hide_table' );

//Save Edit Product Action
add_action( 'save_post_product', 'teepro_size_guide_dropdown_save', 999, 1 );

//Add size guide to single product page
add_action( 'woocommerce_single_product_summary', 'teepro_size_guide_front_end', 38 );

//Metaboxes template
if( ! function_exists( 'teepro_size_guide_metaboxes' ) ) {
    function teepro_size_guide_metaboxes( $post ) {

        if ( get_current_screen()->action == 'add' ) {
            $tables = array(
                array( 'Size', 'Italian (IT)', 'European (EU)', 'French (FR)', 'UK/US Chest', 'UK/US Waist' ),
                array( 'S', '46', '46', '46', '36', '30'  ),
                array( 'M', '48', '48', '48', '38', '32'  ),
                array( 'L', '50', '50', '50', '40', '34'  ),
                array( 'XL', '52', '52', '52', '42', '36'  ),
                array( 'XXL', '54', '54', '54', '44', '38'  ),
                array( '3XL', '56', '56', '56', '46', '40'  ),
            );
        } else {
            $tables = get_post_meta( $post->ID, 'teepro_size_guide' );
            $tables = $tables[0];
        }

        teepro_size_guide_table_template( $tables );
    }
}

//Table template
if( ! function_exists( 'teepro_size_guide_table_template' ) ) {
    function teepro_size_guide_table_template( $tables ) {
        ?>
        <textarea class="teepro-size-guide-edit-table" name="teepro_size_guide_table" style="display:none;">
            <?php echo json_encode( $tables ); ?>
        </textarea>
        <?php
    }
}

//Size guide category template
if( ! function_exists( 'teepro_size_guide_category_template' ) ) {

    function teepro_size_guide_category_template( $post ) {

        $arg = array(
            'taxonomy'     => 'product_cat',
            'orderdby'     => 'name',
            'hierarchical' => 1
        );

        $teepro_guide_size_cats = get_post_meta( $post->ID, 'teepro_guide_size_cats' );
        
        if ( ! empty( $teepro_guide_size_cats ) ) $teepro_guide_size_cats = $teepro_guide_size_cats[0];

        $all_categories = get_categories( $arg );
        
        ?>
        <ul>
            <?php foreach ( $all_categories as $size_guide_cat ): ?>

                <?php $checked = false; ?>

                <?php if ( is_array( $teepro_guide_size_cats  ) && in_array( $size_guide_cat->term_id, $teepro_guide_size_cats ) ) $checked = 'checked'; ?>
                <li>
                    <input type="checkbox" name="teepro_size_guide_category[]" value="<?php echo $size_guide_cat->term_id; ?>" <?php echo $checked; ?>>
                    <?php echo $size_guide_cat->name; ?>
                </li>

            <?php endforeach; ?>
        </ul>
        <?php
    }
}

//Save table action
if( ! function_exists( 'teepro_size_guide_save_table' ) ) {

    function teepro_size_guide_save_table( $post_id ){

        if ( !isset( $_POST['teepro_size_guide_table'] ) ) return;

        $size_guide = json_decode( stripslashes ( $_POST['teepro_size_guide_table'] ) );

        update_post_meta( $post_id, 'teepro_size_guide', $size_guide );
        
        teepro_size_guide_save_category( $post_id );
    }
}

//Size guide save category
if( ! function_exists( 'teepro_size_guide_save_category' ) ) {

    function teepro_size_guide_save_category( $post_id ) {
        
        if ( isset( $_POST['teepro_size_guide_category'] ) ) {

            $selected_size_guide_category = $_POST['teepro_size_guide_category'];

            update_post_meta( $post_id, 'teepro_guide_size_cats', $selected_size_guide_category );
            
            $terms = get_terms( 'product_cat' );

            foreach ( $selected_size_guide_category as $selected_sguide_cat ) {
                update_woocommerce_term_meta( $selected_sguide_cat, 'teepro_chosen_size_guide', $post_id );
            }   

            foreach( $terms as $term ){
                if ( !in_array( $term->term_id, $selected_size_guide_category ) ) {
                    if ( $post_id == get_term_meta( $term->term_id, 'teepro_chosen_size_guide' ) ) {
                        update_woocommerce_term_meta( $term->term_id, 'teepro_chosen_size_guide', '' );
                    }
                }
            }
        }
        else{
            update_post_meta( $post_id, 'teepro_guide_size_cats', '' );

            $terms = get_terms( 'product_cat' );

            foreach( $terms as $term ){
                if ( $post_id == get_term_meta( $term->term_id, 'teepro_chosen_size_guide' ) ) {
                    update_woocommerce_term_meta( $term->term_id, 'teepro_chosen_size_guide', '' );
                }
            }
            
        }
    }
}

//Size guide hide table template
if( ! function_exists( 'teepro_size_guide_hide_table_template' ) ) {

    function teepro_size_guide_hide_table_template( $post ) {

        $hide_table_option = get_post_meta( $post->ID, 'teepro_size_guide_hide_table' );
        $hide_table_option = isset( $hide_table_option[0] ) ? $hide_table_option[0] : 'off';
        ?>
        <label>
            <input type="checkbox" name="teepro_size_guide_hide_table" id="teepro_size_guide_hide_table" <?php checked( 'on', $hide_table_option, true ); ?> > 
            <?php esc_html_e( 'Hide size guide table', 'teepro' ) ?>
        </label>
        <?php
    }
    
}

//Size guide hide table save
if( ! function_exists( 'teepro_size_guide_save_hide_table' ) ) {

    function teepro_size_guide_save_hide_table( $post_id ){

        if ( isset( $_POST['teepro_size_guide_hide_table'] ) && $_POST['teepro_size_guide_hide_table'] == 'on' ) {
            update_post_meta( $post_id, 'teepro_size_guide_hide_table', 'on' );
        } else {
            update_post_meta( $post_id, 'teepro_size_guide_hide_table', 'off' );
        }
    }

}

//Dropdown template
if( ! function_exists( 'teepro_size_guide_dropdown_template' ) ) {

    function teepro_size_guide_dropdown_template( $post ){

        $arg = array(
            'post_type' => 'teepro_size_guide',
            'numberposts' => -1
        );

        $all_size_guides = get_posts( $arg );

        $selected_size_guide_id = get_post_meta( $post->ID, 'teepro_size_guide_select' );

        $selected_size_guide_id = isset( $selected_size_guide_id[0] ) ? $selected_size_guide_id[0] : '';
        
        ?>
            <select name="teepro_size_guide_select">
            
                <option value=""> <?php esc_html_e( 'None', 'teepro' )?> </option>
                
                <?php foreach ( $all_size_guides as $size_guide ): ?>

                    <option value="<?php echo $size_guide->ID; ?>" <?php selected( $selected_size_guide_id, $size_guide->ID ); ?>><?php echo $size_guide->post_title; ?></option>

                <?php endforeach; ?>
                
            </select>
            
            <br><br>
            
            <label>
                <input type="checkbox" name="teepro_disable_size_guide" id="teepro_disable_size_guide" <?php checked( 'disable', $selected_size_guide_id, true ); ?>> 
                <?php esc_html_e( 'Hide size guide from this product', 'teepro' ) ?>
            </label>
        <?php
    }

}

//Dropdown Save
if( ! function_exists( 'teepro_size_guide_dropdown_save' ) ) {

    function teepro_size_guide_dropdown_save( $post_id ){

        if ( isset( $_POST['teepro_size_guide_select'] ) ) {
            
            if ( isset( $_POST['teepro_disable_size_guide'] ) && $_POST['teepro_disable_size_guide'] == 'on' ) {
                update_post_meta( $post_id, 'teepro_size_guide_select', 'disable' );
            } else {
                update_post_meta( $post_id, 'teepro_size_guide_select', $_POST['teepro_size_guide_select'] );
            }
            
        }
    }

}


//Size guide front end
if( ! function_exists( 'teepro_size_guide_front_end' ) ) {

    function teepro_size_guide_front_end( $post_id = false ) {

        $post_id = ( $post_id ) ? $post_id : get_the_ID();
        
        $size_guide_post_id = get_post_meta( $post_id, 'teepro_size_guide_select' );
        
        if ( isset( $size_guide_post_id[0] ) && $size_guide_post_id[0] == 'disable' ) return; 

        if ( !teepro_get_options( 'nbcore_pd_show_size_guide' ) )  return;
        
        if ( isset( $size_guide_post_id[0] ) && !empty( $size_guide_post_id[0] ) ) {
            $size_guide_post_id = $size_guide_post_id[0];
        }
        else {
            $terms = wp_get_post_terms( $post_id, 'product_cat' );
            if ( $terms ) {
                foreach( $terms as $term ){
                    if ( get_term_meta( $term->term_id, 'teepro_chosen_size_guide' ) ) {
                        $size_guide_post_id = get_term_meta( $term->term_id, 'teepro_chosen_size_guide' );
                    }else{
                        $size_guide_post_id = false;
                    }
                }
            }
        }    
        if ( $size_guide_post_id ) {
            $size_guide_post    = get_post( $size_guide_post_id );
            $size_guide_tables  = get_post_meta( $size_guide_post_id, 'teepro_size_guide' );
                
            teepro_size_guide_front_end_table_template( $size_guide_post, $size_guide_tables );
        }
    }
}

//Size guide front end template
if( ! function_exists( 'teepro_size_guide_front_end_table_template' ) ) {

    function teepro_size_guide_front_end_table_template( $size_guide_post, $size_guide_tables ) {

        if ( !$size_guide_tables || !$size_guide_post ) return;
        
        $hide_size_guide_table = get_post_meta( $size_guide_post->ID, 'teepro_size_guide_hide_table' );
        $hide_size_guide_table = isset( $hide_size_guide_table[0] ) ? $hide_size_guide_table[0] : 'off';

        ?>
            <div id="teepro_size_guide_wrapper" class="mfp-with-anim teepro-content-popup mfp-hide teepro-sizeguide">
                <h4 class="teepro-sizeguide-title"><?php echo esc_html( $size_guide_post->post_title ); ?></h4>
                <div class="teepro-sizeguide-content"><?php echo do_shortcode( $size_guide_post->post_content ); ?></div>
                <?php if ( $hide_size_guide_table == 'off' ): ?>
                    <div class="responsive-table">
                        <table class="teepro-sizeguide-table">
                            <?php foreach ( $size_guide_tables as $table ): ?>
                                <?php foreach ( $table as $row ): ?>
                                    <tr>
                                        <?php foreach ( $row as $col ): ?>
                                            <td><?php echo esc_html( $col ); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="size-guide-btn-wrapper">
                <a class="teepro-open-popup teepro-sizeguide-btn button" href="#teepro_size_guide_wrapper">
                    <i class="icon-ruler"></i>
                    <span class="tooltip"><?php esc_html_e( 'Size Guide', 'teepro' ); ?></span>
                </a>
            </div>
        <?php
    }
}