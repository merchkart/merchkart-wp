<div class="top-section-wrap">
    <div class="container">
        <div class="top-section">
         
            
            <?php 
                if(!is_user_logged_in()){ ?>
                <?php   if ( class_exists( 'WooCommerce' ) ){ ?>
                    <div class="header_top_right_menu">
                    <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('login/register','teepro'); ?>"><?php esc_html_e('Login / Register','teepro'); ?></a>
                    </div>
                    <?php  } else { ?>
                            <a href="<?php echo wp_login_url( home_url() ); ?>" title="Login" class="wp_login">Login</a>
                    <?php } ?>
                <?php
             }
             else{ 
                $user = wp_get_current_user();

                $role = (array) $user->roles;
                ?>
                <div class="header_top_right_menu">
                    <ul>
                        <li class="data_user">
                            <a>
                                <img src="<?php echo esc_url( get_avatar_url($user->ID)); ?>" alt="avata1_user"/>
                            </a>
                            <ul class="user-menu">
                                <li class="user-info">
                                     <a class="user_avatar">
                                        <img src="<?php echo esc_url( get_avatar_url($user->ID)); ?>" alt="avata2_user"/>
                                    </a>
                                    <div class="user_role_email">
                                        <div class="user_role"><?php echo $role[0]; ?></div>
                                        <div class="user_email"><?php echo $user->user_email; ?></div>
                                    </div>
                                </li>
                                <?php   if ( class_exists( 'WooCommerce' ) ){ ?>
                                  <li class="user_my_account">  <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('My account','teepro'); ?>"><?php esc_html_e('My account','teepro'); ?></a> </li>
                                  <li class="user_my_order">  <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id')).'orders'; ?>" title="<?php esc_html_e('My order','teepro'); ?>"><?php esc_html_e('My order','teepro'); ?></a> </li>

                                <?php } ?>
                                <li class="user_logout"><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            <?php  } ?>
            <?php teepro_sub_menu(); ?>
            <?php $text_section_content = teepro_get_options('nbcore_header_text_section'); 
            if($text_section_content):
            ?>
            <div class="text-section">
                <?php echo do_shortcode($text_section_content); ?>
            </div>
            <?php endif;?>

        </div>
    </div>
</div>
<div class="middle-section-wrap">
    <div class="container">
        <div class="middle-section">
            <?php teepro_get_site_logo(); ?>
            <div class="main-nav-wrap">
                <?php teepro_main_nav(); ?>
               
            </div>
            <div class="icon-header-section">
                    <div class="icon-header-wrap">
                    <?php 
                      $core_settings = get_option('solutions_core_settings');
                      if( ! empty($core_settings) && is_array($core_settings) && in_array('ajax-cart', $core_settings) ) {
                        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                            echo do_shortcode('[nbt_ajax_cart]');
                        }
                    }
                    else{
                        teepro_header_woo_section(false);
                    }
                    teepro_search_section(true);
                    ?>
                    </div>
            </div>
            
        </div>
    </div>
</div>
