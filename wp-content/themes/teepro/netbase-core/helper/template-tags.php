<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package nbcore
 */

function teepro_get_header()
{

    // $options = Teepro_Core::get_options();

    $header_style = teepro_get_options('nbcore_header_style');

    get_template_part('template-parts/headers/' . $header_style);
}

function teepro_main_nav()
{
    $admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';

    if (has_nav_menu('primary')) {
        echo '<nav class="main-navigation" role="navigation">';
        echo '<button class="mobile-toggle-button icon-menu"></button>';
        echo '<div class="menu-main-menu-wrap">';
        echo '<div class="menu-main-menu-title"><h3>' . esc_html__('Navigation', 'teepro') . '</h3><span class="icon-cancel-circle"></span></div>';
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'nb-navbar',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));

        echo '</div></nav>';
    } else {
        echo '<li><a href="' . $admin_url . '">' . esc_html__('Assign a menu here', 'teepro') . '</a></li>';
    }
}

function teepro_sub_menu()
{
    $admin_url = get_admin_url() . 'customize.php?url=' . get_permalink() . '&autofocus%5Bsection%5D=menu_locations';

    if (has_nav_menu('header-sub')) {
        echo '<nav class="sub-navigation" role="navigation">';

        wp_nav_menu(array(
            'theme_location' => 'header-sub',
            'menu_class' => 'nb-header-sub-menu',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));

        if(is_plugin_active('woocommerce-currency-switcher/index.php')){
            if(is_active_sidebar('currency-switcher')){
                dynamic_sidebar('currency-switcher');
            }
        }

        echo '</nav>';
    } else {
        echo '<a href="' . $admin_url . '">' . esc_html__('Assign a menu for the Sub Menu ', 'teepro') . '</a>';
    }
}

function teepro_get_nav_mobile()
{
    if (has_nav_menu('primary')) {
        echo '<nav class="main-mobile-navigation" role="navigation">';

        echo '<button class="mobile-toggle-button icon-menu"></button>';

        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'nb-mobile-navbar',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));

        echo '</nav>';
    }
}

function teepro_header_class()
{
    $classes = array();

    // $options = Teepro_Core::get_options();

    $classes['header_style'] = teepro_get_options('nbcore_header_style');

    if (teepro_get_options('nbcore_header_fixed')) {
        $classes['header_fixed'] = 'fixed';
    }

    echo implode(' ', $classes);
}

function teepro_header_woo_section($account = TRUE)
{

        $header_style = teepro_get_options('nbcore_header_style');

        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            if ($account): ?>
                <div class="header-account-wrap">
                    <?php if (is_user_logged_in()):
                        if ('left-inline' == $header_style):?>
                            <i class="icon-user-o"></i>
                        <?php else: ?>
                            <span class="account-text"><?php esc_html_e('My Account', 'teepro'); ?></span>
                        <?php endif; ?>
                        <div class="nb-account-dropdown">
                            <?php wc_get_template('myaccount/navigation.php'); ?>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"
                           class="not-logged-in" title="<?php esc_attr_e('Login', 'teepro'); ?>">
                            <?php if ('left-inline' == $header_style): ?>
                                <i class="icon-text-height"></i>
                            <?php else: ?>
                                <span class="account-text"><?php esc_html_e('Login', 'teepro'); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="header-cart-wrap">
                <a class="nb-cart-section" href="<?php echo wc_get_cart_url(); ?>"
                   title="<?php esc_attr_e('View cart', 'teepro'); ?>">
                    <i class="icon-bag"></i>
                    <span class="count-item"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                </a>
                <div class="mini-cart-section">
                    <div class="mini-cart-wrap">
                        <?php woocommerce_mini_cart(); ?>
                    </div>
                </div>
            </div>
        <?php }
    
  
}

function teepro_social_section($text = false)
{
    $facebook = teepro_get_options('nbcore_header_facebook');
    $twitter = teepro_get_options('nbcore_header_twitter');
    $linkedin = teepro_get_options('nbcore_header_linkedin');
    $instagram = teepro_get_options('nbcore_header_instagram');
    $blog = teepro_get_options('nbcore_header_blog');
    $pinterest = teepro_get_options('nbcore_header_pinterest');
    $ggplus = teepro_get_options('nbcore_header_ggplus');
    if ($facebook || $twitter || $linkedin || $instagram || $blog || $pinterest || $ggplus) {
        echo '<ul class="social-section">';
        if ($facebook) {
            echo '<li class="social-item"><a href="' . esc_url($facebook) . '"><i class="icon-facebook"></i></a></li>';
        }
        if ($twitter) {
            echo '<li class="social-item"><a href="' . esc_url($twitter) . '"><i class="icon-twitter"></i></a></li>';
        }
        if ($linkedin) {
            echo '<li class="social-item"><a href="' . esc_url($linkedin) . '"><i class="icon-linkedin"></i></a></li>';
        }
        if ($instagram) {
            echo '<li class="social-item"><a href="' . esc_url($instagram) . '"><i class="icon-instagram"></i></a></li>';
        }
        if ($blog) {
            echo '<li class="social-item"><a href="' . esc_url($blog) . '"><i class="icon-blogger"></i></a></li>';
        }
        if ($pinterest) {
            echo '<li class="social-item"><a href="' . esc_url($pinterest) . '"><i class="icon-pinterest2"></i></a></li>';
        }
        if ($ggplus) {
            echo '<li class="social-item"><a href="' . esc_url($ggplus) . '"><i class="icon-gplus"></i></a></li>';
        }
        echo '</ul>';
    }
}

function teepro_search_section($popup = true)
{

    $core_settings = get_option('solutions_core_settings');
    if( ! empty($core_settings) && is_array($core_settings) && in_array('ajax-search', $core_settings) ){
        echo do_shortcode('[nbt_search]');
    }
    else{
        echo '<div class="header-search-wrap">';
    if ($popup) {
        echo '<a class="icon-header-search popup-search" href="#nbt-search-wrap" data-rel="prettyPhoto" target="_self"><i class="icon-search"></i></a>';
        echo '<div id="nbt-search-wrap"><div class="nbt-search-wrap">';
    }
    get_search_form();
    if ($popup) {
        echo '</div></div>';
    }
    echo '</div>';
    }
    
}

function teepro_get_site_logo()
{
    $logo = teepro_get_options('nbcore_logo_upload');
    if ($logo) {
        $output = '<div class="main-logo img-logo">';
        $output .= '<a href="' . esc_url(home_url('/')) . '" title="' . get_bloginfo('description') . '">';
        $output .= '<img src="' . teepro_get_options('nbcore_logo_upload') . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '">';
        $output .= '</a>';
        $output .= '</div>';
    } else {
        $output = '<div class="main-logo text-logo">';
        $output .= '<a href="' . esc_url(home_url('/')) . '" title="' . get_bloginfo('description') . '">';
        $output .= get_bloginfo('name');
        $output .= '</a>';
        $output .= '</div>';
    }
    print($output);
}

function teepro_featured_thumb()
{
    $blog_layout = teepro_get_options('nbcore_blog_archive_layout');
    if (has_post_thumbnail()):
        if ('classic' == $blog_layout) {
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        } else {
            $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'nbcore-masonry');
        }
        if ('classic' === $blog_layout):
            ?>
            <div class="entry-image">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    printf('<img src="%1$s" title="%2$s" width="%3$s" height="%4$s" />',
                        $thumb[0],
                        esc_attr(get_the_title()),
                        $thumb[1],
                        $thumb[2]
                    );
                    ?>
                </a>
            </div>
        <?php else: ?>
            <div class="entry-image">
                <?php
                printf('<img src="%1$s" title="%2$s" width="%3$s" height="%4$s" />',
                    $thumb[0],
                    esc_attr(get_the_title()),
                    $thumb[1],
                    $thumb[2]
                );
                ?>
                <div class="image-mask">
                    <a href="<?php the_permalink(); ?>"><span><?php esc_html_e('View post &rarr;', 'teepro'); ?></span></a>
                    <?php
                    $post = get_post();
                    $words = str_word_count(strip_tags($post->post_content));
                    $minutes = floor($words / 180);
                    if (1 < $minutes) {
                        $estimated_time = $minutes . ' minutes read';
                    } else {
                        $estimated_time = esc_html__('1 minute read', 'teepro');
                    }
                    echo '<div class="read-time"> ' . $estimated_time . '</div>';
                    ?>
                </div>

            </div>
        <?php endif;
    endif;
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function teepro_posted_on()
{
    $html = '';

    if (is_single()) {
        $recent_posts = wp_get_recent_posts();
        $display_name='';
        foreach( $recent_posts as $recent ){
            $user_id = get_user_by( 'ID', $recent["post_author"] );
            $display_name = $user_id->display_name;
        }
        $date= get_the_date('F n Y');
        $html .= '<span class="post-author"><i class="icon-user"></i>' . $display_name . '</span>'
                .'<span class="post-date"><i class="icon-calendar-empty"></i>' . $date . '</span>'
                .'<span class="post-comment"><i class="icon-comment"></i>' . get_comments_number() . '</span>';
        
        
    }
    else{
        if (!is_single()) {
            if (teepro_get_options('nbcore_blog_meta_author')) {
                $byline = sprintf(
                    esc_html_x('%s', 'post author', 'teepro'),
                    '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
                );
    
                $html .= '<span class="byline"><i class="icon-user"></i>' . $byline . '</span>';
            }
        }
    
        if (teepro_get_options('nbcore_blog_meta_date')) {
            $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
            if (get_the_time('U') !== get_the_modified_time('U')) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }
    
            $time_string = sprintf($time_string,
                esc_attr(get_the_date('c')),
                esc_html(get_the_date()),
                esc_attr(get_the_modified_date('c')),
                esc_html(get_the_modified_date())
            );
    
            $posted_on = sprintf(
                esc_html_x('%s', 'post date', 'teepro'), $time_string);
    
            $html .= '<span class="posted-on"><i class="icon-calendar-empty"></i>' . $posted_on . '</span>';
        };
        if ('style-3' == teepro_get_options('nbcore_blog_archive_post_style')) {
            
            $html .= '<span class="comments"> <i class="icon-comment"></i>' .get_comments_number(). '</span>';
        }
    
        if ('masonry' !== teepro_get_options('nbcore_blog_archive_layout')) {
            if (teepro_get_options('nbcore_blog_meta_read_time')) {
                $post = get_post();
                $words = str_word_count(strip_tags($post->post_content));
                $minutes = floor($words / 180);
                if (1 < $minutes) {
                    $estimated_time = $minutes . ' minutes read';
                } else {
                    $estimated_time = esc_html__('1 minute read', 'teepro');
                }
    
                $html .= '<span class="read-time"> ' . $estimated_time . '</span>';
            }
        }
    }
    if ('' != $html) {
        echo '<div class="entry-meta">' . $html . '</div>';
    }
}

function teepro_get_categories()
{
    if (teepro_get_options('nbcore_blog_meta_category')):?>
        <div class="entry-cat">
            <?php echo get_the_category_list(' '); ?>
        </div>
    <?php endif;
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 * TODO entry-footer wrap div rearrange
 */
function teepro_get_tags()
{
    if (teepro_get_options('nbcore_blog_meta_tag')) {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'teepro'));
            if ($tags_list) {
                printf('<span class="tags-links icon-tags">' . esc_html__('%1$s', 'teepro') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }
    }
}

function teepro_get_excerpt()
{
    echo '<p class="entry-summary">';
    $limit = teepro_get_options('nbcore_excerpt_length');
    $excerpt = wp_trim_words(get_the_excerpt(), $limit, ' [...]');
    echo esc_html($excerpt);
    echo '</p>';
}

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function teepro_categorized_blog()
{
    if (false === ($all_the_cool_cats = get_transient('nbcore_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('nbcore_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so teepro_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so teepro_categorized_blog should return false.
        return false;
    }
}

function teepro_paging_nav()
{
    // Don't print empty markup if there's only one page.
    if ($GLOBALS['wp_query']->max_num_pages < 2) {
        return;
    }

    $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $query_args = array();
    $url_parts = explode('?', $pagenum_link);

    if (isset ($url_parts[1])) {
        wp_parse_str($url_parts[1], $query_args);
    }

    $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
    $pagenum_link = trailingslashit($pagenum_link) . '%_%';

    $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(array(
        'nbcore' => $pagenum_link,
        'format' => $format,
        'total' => $GLOBALS['wp_query']->max_num_pages,
        'current' => $paged,
        'mid_size' => 1,
        'add_args' => array_map('urlencode', $query_args),
        'prev_text' => wp_kses(__('<i class=\'icon-left-open\'></i>', 'teepro'), array('i' => array('class' => array()))),
        'next_text' => wp_kses(__('<i class=\'icon-right-open\'></i>', 'teepro'), array('i' => array('class' => array()))),
    ));

    if ($links) :

        ?>
        <nav class="navigation paging-navigation <?php echo teepro_get_options('pagination_style'); ?>"
             role="navigation">
            <div class="pagination loop-pagination">
                <?php echo wp_kses($links, array(
                    'a' => array(
                        'href' => array(),
                        'class' => array()
                    ),
                    'i' => array(
                        'class' => array()
                    ),
                    'span' => array(
                        'class' => array()
                    )
                )); ?>
            </div><!--/ .pagination -->
        </nav><!--/ .navigation -->
        <?php
    endif;
}

function teepro_page_title()
{

    if (teepro_get_options('show_title_section')) {
    
        if (is_home() || is_front_page()) {
            if (teepro_get_options('home_page_title_section')) {
                echo '<div class="nb-page-title-wrap"><div class="container"><div class="nb-page-title"><h1>';
                esc_html_e('Home', 'teepro');
                echo '</h1></div></div></div>';
            }
        }
        elseif ( function_exists('is_product') && is_product()){
            echo '<div class="nb-page-title-wrap"><div class="container">';
            if (function_exists('woocommerce_breadcrumb')) {
                if (teepro_get_options('nbcore_wc_breadcrumb')) {
                    woocommerce_breadcrumb();
                }
            }
            echo '</div></div>';
        } 
        else {

            if(is_page() && teepro_get_options('nbcore_page_title_image')){
                $show_bg_title = teepro_get_options('nbcore_page_title_image');
                $bg_title = array();
                if($show_bg_title){
                    $bg_title = wp_get_attachment_image_src( $show_bg_title,'full' );
                }
                if($bg_title){
                    echo '<div class="nb-page-title-wrap bg_title_pages bg_img" style ="background-image: url('.$bg_title[0].')"><div class="container"><div class="nb-page-title"><h1>'; 
                }
                else{
                    echo '<div class="nb-page-title-wrap"><div class="container"><div class="nb-page-title"><h1>';
                }
            }
            elseif(is_category() && teepro_get_options('nbcore_blog_bg_single_title')){
                $title_blog_single_bg = teepro_get_options('nbcore_blog_bg_single_title');
                $title_bg = array();
                if($title_blog_single_bg){
                    $title_bg = wp_get_attachment_image_src( $title_blog_single_bg,'full' );
                }
                if($title_bg){
                    echo '<div class="nb-page-title-wrap bg_title_post_category bg_img" style ="background-image: url('.$title_bg[0].')"><div class="container"><div class="nb-page-title"><h1>'; 
                }
                else{
                    echo '<div class="nb-page-title-wrap"><div class="container"><div class="nb-page-title"><h1>';
                }
            }
            else{
                echo '<div class="nb-page-title-wrap"><div class="container"><div class="nb-page-title"><h1>';
            }
            if (function_exists('is_shop') && is_shop()) {
                echo esc_html(teepro_get_options('nbcore_shop_title'), 'teepro');
            } elseif (function_exists('is_product_category') && is_product_category()) {
                echo single_cat_title();
            } elseif (function_exists('is_product_tag') && is_product_tag()) {
                echo single_tag_title();
            } elseif (is_post_type_archive()) {
                post_type_archive_title();
            } elseif (is_tax()) {
                single_term_title();
            } elseif (is_category()) {
                echo single_cat_title('', false);
            } elseif (is_archive()) {
                echo the_archive_title();
            } elseif (is_search()) {
                esc_html_e('Search Results', 'teepro');
            } elseif (function_exists('dokan_is_store_page') && dokan_is_store_page()) {
                $store_user    = dokan()->vendor->get( get_query_var( 'author' ) );
                echo $store_user->get_shop_name();
            } else {
                if (!is_page()) {
                    the_title();
                } else {
                    if (get_post_meta(get_the_ID(), 'nbcore_pages_title', true)) {
                        the_title();
                    }
                }
            }

            echo '</h1>';
            if(!is_page() && !is_category()){
                if (function_exists('woocommerce_breadcrumb')) {
                    if (teepro_get_options('nbcore_wc_breadcrumb')) {
                        woocommerce_breadcrumb();
                    }
                }
            }
            echo '</div></div></div>';
        }
    }
}

/**
 * Flush out the transients used in teepro_categorized_blog.
 */
function teepro_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('nbcore_categories');
}

add_action('edit_category', 'teepro_category_transient_flusher');
add_action('save_post', 'teepro_category_transient_flusher');

function teepro_default_options()
{
    return array(
        'nbcore_blog_archive_layout' => 'classic',
        'nbcore_blog_sidebar' => 'right-sidebar',
        'nbcore_excerpt_only' => false,
        'nbcore_excerpt_length' => '35',
        'nbcore_blog_single_sidebar' => 'right-sidebar',
        'nbcore_color_scheme' => 'scheme_1',
        'nbcore_primary_color' => '#1e88e5',
        'nbcore_secondary_color' => '#fdd835',
        'nbcore_background_color' => '#ffffff',
        'nbcore_inner_background' => '#edf0f5',
        'nbcore_heading_color' => '#323232',
        'nbcore_body_color' => '#676c77',
        'nbcore_link_color' => '#000000',
        'nbcore_link_hover_color' => '#888888',
        'nbcore_divider_color' => '#e4e4e4',
        'nbcore_header_style' => 'teepro-header-1',
        'nbcore_logo_upload' => '',
        'nbcore_logo_width' => '200',
        'nbcore_logo_currency_width' => '15',
        'nbcore_menu_resp'=>'768',
        'nbcore_header_fixed' => false,
        'header_bgcolor' => '#ffffff',
        'nbcore_blog_width' => '70',
        'nbcore_blog_meta_date' => true,
        'nbcore_blog_meta_read_time' => true,
        'nbcore_blog_meta_author' => true,
        'nbcore_blog_meta_category' => true,
        'nbcore_blog_meta_tag' => true,
        'nbcore_blog_sticky_sidebar' => false,
        'nbcore_blog_meta_align' => 'center',
        'show_title_section' => true,
        'nbcore_page_title_padding' => '75',
        'nbcore_page_title_image' => '',
        'nbcore_page_title_color' => '#323232',
        'body_font_family' => 'google,Lato',
        'body_font_size' => '14',
        'heading_font_family' => 'google,Merriweather',
        'heading_base_size' => '16',
        'subset_cyrillic' => false,
        'subset_greek' => false,
        'subset_vietnamese' => false,
        'nbcore_wc_breadcrumb' => true,
        'nbcore_wc_content_width' => '70',
        'nbcore_pa_swatch_style' => '',
        'nbcore_shop_title' => esc_html__('Shop', 'teepro'),
        'nbcore_shop_action' => true,
        'nbcore_product_image_mask' => true,
        'nbcore_product_rating' => false,
        'nbcore_product_action_style' => 'center',
        'nbcore_shop_sidebar' => 'right-sidebar',
        'nbcore_loop_columns' => 'three-columns',
        'nbcore_products_per_page' => '12',
        'nbcore_product_list' => 'grid-type',
        'nbcore_shop_content_width' => '70',
        'nbcore_grid_product_description' => false,
        'nbcore_enable_product_title_bold' => false,
        'nbcore_footer_top_border_bot_color' => 'rgba(255, 255, 255, 0)',
        'nbcore_footer_bot_border_bot_color' => 'rgba(255, 255, 255, 0)',
        'nbcore_pd_details_title' => true,
        'nbcore_pd_details_width' => '70',
        'nbcore_pd_details_sidebar' => 'right-sidebar',
        'nbcore_wc_sale' => 'style-1',
        'nbcore_pd_images_width' => '50',
        'nbcore_pd_thumb_pos' => 'bottom-thumb',
        'nbcore_pd_meta_layout' => 'left-images',
        'nbcore_pd_featured_autoplay' => false,
        'nbcore_info_style' => 'accordion-tabs',
        'nbcore_reviews_form' => 'full-width',
        'nbcore_reviews_round_avatar' => true,
        'nbcore_add_cart_style' => 'style-1',
        'nbcore_pd_show_social' => true,
        'nbcore_pd_show_size_guide' => true,
        'nbcore_show_related' => true,
        'nbcore_pd_related_columns' => '3',
        'nbcore_show_upsells' => false,
        'nbcore_pd_upsells_columns' => '3',
        'nbcore_upsells_limit'      => '6',
        'nbcore_pb_background' => '#1e88e5',
        'nbcore_pb_background_hover' => '#1565C0',
        'nbcore_pb_text' => '#ffffff',
        'nbcore_pb_text_hover' => '#ffffff',
        'nbcore_pb_border' => '#1e88e5',
        'nbcore_pb_border_hover' => '#1565C0',
        'nbcore_sb_background' => 'transparent',
        'nbcore_sb_background_hover' => '#1e88e5',
        'nbcore_sb_text' => '#1e88e5',
        'nbcore_sb_text_hover' => '#ffffff',
        'nbcore_sb_border' => '#1e88e5',
        'nbcore_sb_border_hover' => '#1e88e5',
        'nbcore_button_padding' => '30',
        'nbcore_button_border_radius' => '0',
        'nbcore_button_border_width' => '2',
        'nbcore_cart_layout' => 'cart-layout-2',
        'nbcore_show_cross_sells' => true,
        'nbcore_cross_sells_per_row' => '4',
        'nbcore_cross_sells_limit' => '6',
        'home_page_title_section' => false,
        'nbcore_show_footer_top' => false,
        'nbcore_footer_top_layout' => 'layout-9',
        'nbcore_footer_top_color' => '#777777',
        'nbcore_footer_top_bg' => '#edf0f5',
        'nbcore_show_footer_bot' => false,
        'nbcore_footer_bot_layout' => 'layout-9',
        'nbcore_footer_bot_color' => '#777777',
        'nbcore_footer_bot_bg' => '#edf0f5',
        'nbcore_footer_abs_color' => '#edf0f5',
        'nbcore_footer_abs_bg' => '#1f1f1f',
        'nbcore_top_section_padding' => '10',
        'nbcore_middle_section_padding' => '20',
        'nbcore_bot_section_padding' => '30',
        'nbcore_header_top_bg' => '#282725',
        'nbcore_header_top_color' => '#e4e4e4',
        'nbcore_header_top_color_hover' => '#e4e4e4',
        'nbcore_header_middle_bg' => '#ffffff',
        'nbcore_header_middle_color' => '#646464',
        'nbcore_header_middle_color_hover'=>'#646464',
        'nbcore_header_bot_bg' => '#fff',
        'nbcore_header_bot_color' => '#646464',
        'nbcore_footer_top_heading' => '#323232',
        'nbcore_footer_bot_heading' => '#323232',
        'nbcore_blog_archive_comments' => true,
        'nbcore_blog_archive_summary' => true,
        'nbcore_blog_archive_post_style' => 'style-1',
        'nbcore_blog_single_title_position' => 'position-1',
        'nbcore_blog_bg_single_title'=>'',
        'nbcore_blog_single_show_thumb' => true,
        'nbcore_blog_single_title_size' => '50',
        'nbcore_blog_single_show_social' => true,
        'nbcore_blog_single_show_author' => true,
        'nbcore_blog_single_show_nav' => true,
        'nbcore_blog_single_show_comments' => true,
        'nbcore_page_title_size' => '50',
        'nbcore_footer_top_padding_top' => '15',
        'nbcore_footer_top_padding_bottom' => '15',
        'nbcore_footer_bot_padding_top' => '15',
        'nbcore_footer_bot_padding_bottom' => '15',
        'nbcore_enable_colorful_widget_title' => false,
        'nbcore_footer_abs_padding' => '10',
        'share_buttons_style' => 'style-1',
        'share_buttons_position' => 'inside-content',
        'pagination_style' => 'pagination-style-1',
        'show_back_top' => true,
        'back_top_shape' => 'circle',
        'back_top_style' => 'light',
        'shop_sticky_sidebar' => false,
        'product_sticky_sidebar' => false,
        'nbcore_product_meta_align' => 'left',
        'nbcore_product_price_style' => 'default_woo',
        'nbcore_product_hover' => 'image',
        'page_thumb' => 'no-thumb',
        'nbcore_pages_sidebar'=>'no-sidebar',
        'nbcore_pages_image_banner_bottom'=>'',
        'nbcore_page_text_banner_bottom'=>'',
        'page_content_width' => '70',
        'nbcore_blog_masonry_columns' => '2',
        'product_category_wishlist' => false,
        'product_category_quickview' => false,
        'product_category_compare'=>false,
       // 'nbcore_header_mainmn_bg' => '#fff',
        'nbcore_header_mainmn_color' => '#646464',
        'nbcore_header_mainmn_bor' => '#646464',
        //'nbcore_header_mainmnhover_bg' => '#fff',
        'nbcore_header_mainmnhover_color' => '#646464',
        'nbcore_header_mainmnhover_bor' => '#646464',
        'heading_font_style' => '400',
        'body_font_style' => '400',
        'nbcore_footer_abs_left_content' => '',
        'nbcore_footer_abs_right_content' => '',
        'nbcore_page_fullbox' => false,
        'nbcore_page_layout' => 'full-width',
        'nbcore_page_content_width' => 60,
        'nbcore_shop_banner' => '',
        'nbcore_wc_attr'=>true,
        'nbcore_header_text_section'=>'',
        'nbcore_show_to_shop'=>false,
        'nbcore_container_width' => '1170',
        'nbcore_pd_enable_review_rating' => false,
        'nbcore_services_layout_intro'=>'',
        'nbcore_services_sidebar'=>'left-sidebar',
        'nbcore_services_image_banner_bottom' =>'',
        'nbcore_services_text_banner_bottom'=>'',
        'nbcore_services_image_banner_top'=>'',
        'show_service_title' => false,
        'nbcore_header_preloading' => false,
        'nbcore_header_style_preloading' => 'demo2',
        'show_service_title'=>false,

        /*dokan*/
        'nbcore_dokan_sidebar' => 'left-sidebar',
        'nbcore_storelist_loop_columns_xl' => '3',
        'nbcore_storelist_loop_columns_lg' => '3',
        'nbcore_storelist_loop_columns_md' => '2',
        'nbcore_storelist_loop_columns_sm' => '2',
        'nbcore_storelist_per_page' => '9',
        'nbcore_vendor_details_sidebar' => 'left-sidebar',
        'nbcore_vendor_details_width' => '75',
        'nbcore_vendor_sticky_sidebar' => false,
        'nbcore_vendor_loop_columns'    => '2',
        'nbcore_vendor_loop_columns_xl' => '3',
        'nbcore_vendor_loop_columns_lg' => '3',
        'nbcore_vendor_loop_columns_md' => '2',
        'nbcore_vendor_loop_columns_sm' => '2',
        'nbcore_vendor_per_page' => '9',
        'nbcore_vendor_map_height' => '200',
        'nbcore_mp_loop_columns_xl' => '4',
        'nbcore_mp_loop_columns_lg' => '4',
        'nbcore_mp_loop_columns_md' => '3',
        'nbcore_mp_loop_columns_sm' => '2',
        'nbcore_dashboard_style' => false,
        'nbcore_vendors_list' => 'default',
        'nbcore_template_designer_style'=>'style1'
        
    );
}

function teepro_get_options($option)
{
    $result = '';
    $default = teepro_default_options();

    if(class_exists('NBFW_Metaboxes')) {
        $meta = '';
        $global = '';

        if(is_single() || is_page()) {
            $id = get_the_ID();
            $global = get_post_meta($id, 'nbcore_global_setting', true);
            $meta = get_post_meta($id, $option, true);
            
        } elseif(is_tax() || is_category() || is_tag()) {
            $id = get_queried_object_id();
            $global = get_term_meta($id, 'nbcore_global_setting', true);
            $meta = get_term_meta($id, $option, true);
        }

        if( $meta !== '' && $global !== '') {
            $result = $meta;
        } else {
            $result = get_theme_mod($option, $default[$option]);
        }
    } else {
        $result = get_theme_mod($option, $default[$option]);
    }

    return $result;
}


function teepro_blog_classes()
{
    $classes = array();

    $classes['sidebar'] = teepro_get_options('nbcore_blog_sidebar');
    $classes['meta_align'] = 'meta-align-' . teepro_get_options('nbcore_blog_meta_align');
    $classes['post_style'] = teepro_get_options('nbcore_blog_archive_post_style');

    if ('masonry' === teepro_get_options('nbcore_blog_archive_layout')) {
        $classes['masonry_columns'] = 'masonry-' . teepro_get_options('nbcore_blog_masonry_columns') . '-columns';
    }


    echo implode(' ', $classes);
}

function teepro_shop_classes()
{
    $classes = array();

    if ((is_shop() || is_product_category() || is_product_tag()) && 'list-type' !== teepro_get_options('nbcore_product_list')) {
        $classes['shop_columns'] = teepro_get_options('nbcore_loop_columns');
    }
    if (is_tax('product_brand')) {
        $classes['shop_columns'] = teepro_get_options('nbcore_loop_columns');
    }

    $classes['meta_layout'] = teepro_get_options('nbcore_pd_meta_layout');

    if (function_exists('is_product') && is_product()) {
        $classes['nbcore_pd_thumb_pos'] = teepro_get_options('nbcore_pd_thumb_pos');
    }

    if ('split' === teepro_get_options('nbcore_reviews_form')) {
        $classes['nbcore_reviews_form'] = 'split-reviews-form';
    }

    if (teepro_get_options('nbcore_reviews_round_avatar')) {
        $classes['nbcore_round_avatar'] = 'round-reviewer-avatar';
    }

    $classes['wc_tab_style'] = teepro_get_options('nbcore_info_style');

    if (is_product()) {
        $classes['related_columns'] = 'related-' . teepro_get_options('nbcore_pd_related_columns') . '-columns';
        $classes['upsells_columns'] = 'upsells-' . teepro_get_options('nbcore_pd_upsells_columns') . '-columns';
        $classes['morepd_columns_xl'] = 'morepd-columns-xl-' . teepro_get_options('nbcore_mp_loop_columns_xl');
        $classes['morepd_columns_lg'] = 'morepd-columns-lg-' . teepro_get_options('nbcore_mp_loop_columns_lg');
        $classes['morepd_columns_md'] = 'morepd-columns-md-' . teepro_get_options('nbcore_mp_loop_columns_md');
        $classes['morepd_columns_sm'] = 'morepd-columns-sm-' . teepro_get_options('nbcore_mp_loop_columns_sm');
    }

    echo implode(' ', $classes);
}

add_filter('woocommerce_add_to_cart_fragments', 'teepro_header_add_to_cart_fragment');
function teepro_header_add_to_cart_fragment($fragments)
{
    global $woocommerce;

    ob_start();

    ?>
    <a class="nb-cart-section" href="<?php echo wc_get_cart_url(); ?>"
       title="<?php esc_attr_e('View cart', 'teepro'); ?>">
        <i class="icon-bag"></i>
        <span class="count-item"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
    <?php

    $fragments['a.nb-cart-section'] = ob_get_clean();

    return $fragments;

}

add_filter('woocommerce_add_to_cart_fragments', 'nb_mini_cart_fragments');
function nb_mini_cart_fragments($fragments)
{

    ob_start();

    ?>
    <div class="mini-cart-wrap">
        <?php woocommerce_mini_cart(); ?>
    </div>
    <?php

    $fragments['.mini-cart-wrap'] = ob_get_clean();

    return $fragments;
}

function teepro_back_to_top()
{
    $shape = teepro_get_options('back_top_shape');
    $style = teepro_get_options('back_top_style');
    echo '<div class="nb-back-to-top-wrap"><a id="back-to-top-button" class="' . esc_attr($shape) . ' ' . esc_attr($style) . '" href="#"><i class="icon-angle-up"></i></a></div>';
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'dokan-lite/dokan.php' ) && is_plugin_active( 'dokan-pro/dokan-pro.php' )) {

    function teepro_show_store_coupons( $store_user, $store_info ) {
       
            $seller_coupons = dokan_get_seller_coupon( $store_user->id, true );
    
            // var_dump( $seller_coupons );
            if ( ! $seller_coupons ) {
                return;
            }
            // WC 3.0 compatibility
            if ( class_exists( 'WC_DateTime' ) ) {
                $current_time = new WC_DateTime();
                $current_time = $current_time->getTimestamp();
            } else {
                $current_time = current_time( 'timestamp' );
            }
    
            echo '<div class="store-coupon-wrap teepro_show_store_coupons">';
    
            foreach ( $seller_coupons as $coupon ) {
                $coup = new WC_Coupon( $coupon->ID );
    
                $expiry_date = dokan_get_prop( $coup, 'expiry_date', 'get_date_expires' );
                $coup_exists = dokan_get_prop( $coup, 'exists', 'is_valid' );
    
                if ( class_exists( 'WC_DateTime' ) && $expiry_date ) {
                    $expiry_date = new WC_DateTime( $expiry_date );
                    $expiry_date = $expiry_date->getTimestamp();
                }
    
                if ( $expiry_date && ( $current_time > $expiry_date ) )  {
                    continue;
                }
    
                $coupon_type = version_compare( WC_VERSION, '2.7', '>' ) ? 'percent' : 'percent_product';
    
                if ( $coupon_type == dokan_get_prop( $coup, 'type', 'get_discount_type' ) ) {
                    $coupon_amount_formated = dokan_get_prop( $coup, 'amount' ) . '%';
                } else {
                    $coupon_amount_formated = wc_price( dokan_get_prop( $coup, 'amount' ) );
                }
                ?>
                    <div class="code">
                        <span class="outside">
                            <span class="inside">
                                <div class="coupon-title"><?php printf( esc_html__( '%s Discount', 'teepro' ), $coupon_amount_formated ); ?></div>
                                <div class="coupon-body">
                                    <?php if ( !empty( $coupon->post_content ) ) { ?>
                                        <span class="coupon-details"><?php echo esc_html( $coupon->post_content ); ?></span>
                                    <?php } ?>
                                    <span class="coupon-code"><strong><?php printf( esc_html__( 'Coupon Code: %s', 'teepro' ), $coupon->post_title ); ?></strong></span>
    
                                    <?php if ( $expiry_date ) {
                                        $expiry_date = is_object( $expiry_date ) ? $expiry_date->getTimestamp() : $expiry_date; ?>
                                        <span class="expiring-in">(<?php printf( esc_html__( 'Expiring in %s', 'teepro' ), human_time_diff( $current_time, $expiry_date ) ); ?>)</span>
                                    <?php } ?>
                                </div>
                            </span>
                        </span>
                    </div>
                <?php
            }
    
            echo '</div>';
        }
    }