<?php
add_action('init', 'elessi_promo_popup_heading');
if (!function_exists('elessi_promo_popup_heading')) {

    function elessi_promo_popup_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }

        $of_options[] = array(
            "name" => esc_html__("Newsletter Popup", 'elessi-theme'),
            "target" => 'promo-popup',
            "type" => "heading"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Newsletter", 'elessi-theme'),
            "id" => "promo_popup",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide in Mobile (width site small less 640px OR Mobile Layout)", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_popup_mobile",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Width", 'elessi-theme'),
            "id" => "pp_width",
            "std" => "734",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Height", 'elessi-theme'),
            "id" => "pp_height",
            "std" => "501",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Content", 'elessi-theme'),
            "id" => "pp_content",
            "std" => '<h3>Newsletter</h3><p>Be the first to know about our new arrivals, exclusive offers and the latest fashion update.</p>',
            "type" => "textarea"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Select Contact Form", 'elessi-theme'),
            "id" => "pp_contact_form",
            "type" => "select",
            'override_numberic' => true,
            "options" => elessi_get_contactForm7Items()
        );
        
        $of_options[] = array(
            "name" => esc_html__("Content Width", 'elessi-theme'),
            "id" => "pp_style",
            "std" => "simple",
            "type" => "select",
            "options" => array(
                "simple" => esc_html__("50%", 'elessi-theme'),
                "full" => esc_html__("Full Width", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background Color", 'elessi-theme'),
            "id" => "pp_background_color",
            "std" => "#fff",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Popup Background", 'elessi-theme'),
            "id" => "pp_background_image",
            "std" => ELESSI_THEME_URI . '/assets/images/newsletter_bg.jpg',
            "type" => "media"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay time to show", 'elessi-theme'),
            "id" => "delay_promo_popup",
            "std" => 0,
            "type" => "text"
        );
    }
}

/**
 * Get list Contact Form 7
 * @return type
 */
function elessi_get_contactForm7Items() {
    $items = array('default' => esc_html__('Select the Contact form', 'elessi-theme'));
    $contacts = array();
    
    if (class_exists('WPCF7_ContactForm')) {
        $contacts = get_posts(array(
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post_type' => WPCF7_ContactForm::post_type
        ));

        if (!empty($contacts)) {
            foreach ($contacts as $value) {
                $items[$value->ID] = $value->post_title;
            }
        }
    }
    
    if (empty($contacts)) {
        $items = array('default' => esc_html__('You need install plugin Contact Form 7 and Create Newsletter form', 'elessi-theme'));
    }
    
    return $items;
}
