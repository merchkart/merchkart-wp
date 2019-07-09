<?php
require_once get_template_directory() . '/netbase-core/helper/template-tags.php';
if(! function_exists('add_wrap_container_before'))
{
    function add_wrap_container_before(){
        global $post_id;
        $return = '';
        if ( $post_id ) {
            $return = '
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area page-full-width">
                            <main id="main" class="site-main left-sidebar" role="main">
                                <article class="page type-page status-publish hentry">
                                    <div class="entry-content">
                ';
        }
       print $return;
    }
}
if(! function_exists('add_wrap_container_after')) {
    function add_wrap_container_after(){
        print '
                                    </div>
                                </article>
                            </main>
                        </div>
                    </div>
                </div>
            ';
    }
}

add_action('dokan_dashboard_wrap_before', 'add_wrap_container_before');
add_action('dokan_dashboard_wrap_after', 'add_wrap_container_after');

if(! function_exists('edit_common_links_dashboard_menu')) {
    function edit_common_links_dashboard_menu() {

        $common_links = '
            <li class="dokan-common-links dokan-clearfix">
                <a title="' . esc_html__( 'Visit Store', 'teepro' ) . '" class="tips" data-placement="top" href="' . dokan_get_store_url( get_current_user_id()) .'" target="_blank">
                    <i class="fa fa-external-link"></i>
                    ' . esc_html__( 'Visit Store', 'teepro' ) . '
                </a>
            </li>
            <li class="dokan-common-links dokan-clearfix">
                <a title="' . esc_html__( 'Edit Account', 'teepro' ) . '" class="tips" data-placement="top" href="' . dokan_get_navigation_url( 'edit-account' ) . '">
                    <i class="fa fa-user"></i>
                    ' . esc_html__( 'Edit Account', 'teepro' ) . '
                </a>
            </li>
            <li class="dokan-common-links dokan-clearfix">
                <a title="' . esc_html__( 'Log out', 'teepro' ) . '" class="tips" data-placement="top" href="' . wp_logout_url( home_url() ) . '">
                    <i class="fa fa-power-off"></i>
                    ' . esc_html__( 'Log out', 'teepro' ) . '
                </a>
            </li>';

        return $common_links;
    }
}

if(teepro_get_options('nbcore_dashboard_style')) {
    add_filter( 'dokan_dashboard_nav_common_link', 'edit_common_links_dashboard_menu' );
}
