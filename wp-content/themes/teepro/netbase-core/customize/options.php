<?php

/*
* One value *

'condition' => array(
    'element' => 'element',
    'value'   => 'value',
)

* Array *

'condition' => array(
    'element' => array('element1', 'element2'),
    'value'   => array('value1', 'value2'),
)

* Not Value *

'condition' => array(
    'element' => 'element',
    'value'   => '!value',
)


*/

class Teepro_Customize_Options
{
    public function footer()
    {
        return array(
            'title' => esc_html__('Footer', 'teepro'),
            'priority' => 17,
            'options' => array(
                'nbcore_footer_top_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Footer top section', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_show_footer_top' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show this section', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_footer_top_layout' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Columns', 'teepro'),
                        'section' => 'footer',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'layout-1' => get_template_directory_uri() . '/assets/images/options/footers/footer-1.png',
                            'layout-2' => get_template_directory_uri() . '/assets/images/options/footers/footer-2.png',
                            'layout-3' => get_template_directory_uri() . '/assets/images/options/footers/footer-3.png',
                            'layout-4' => get_template_directory_uri() . '/assets/images/options/footers/footer-4.png',
                            'layout-5' => get_template_directory_uri() . '/assets/images/options/footers/footer-5.png',
                            'layout-6' => get_template_directory_uri() . '/assets/images/options/footers/footer-6.png',
                            'layout-7' => get_template_directory_uri() . '/assets/images/options/footers/footer-7.png',
                            'layout-8' => get_template_directory_uri() . '/assets/images/options/footers/footer-8.png',
                            'layout-9' => get_template_directory_uri() . '/assets/images/options/footers/footer-9.png',
                        ),
                    ),
                ),
                'nbcore_footer_top_padding_top' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding top', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '100',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_footer_top_padding_bottom' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding bottom', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '100',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_footer_top_border_bot_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border Bottom Color', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_bot_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Footer bottom section', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_show_footer_bot' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show this section', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_footer_bot_layout' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Columns', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'layout-1' => get_template_directory_uri() . '/assets/images/options/footers/footer-1.png',
                            'layout-2' => get_template_directory_uri() . '/assets/images/options/footers/footer-2.png',
                            'layout-3' => get_template_directory_uri() . '/assets/images/options/footers/footer-3.png',
                            'layout-4' => get_template_directory_uri() . '/assets/images/options/footers/footer-4.png',
                            'layout-5' => get_template_directory_uri() . '/assets/images/options/footers/footer-5.png',
                            'layout-6' => get_template_directory_uri() . '/assets/images/options/footers/footer-6.png',
                            'layout-7' => get_template_directory_uri() . '/assets/images/options/footers/footer-7.png',
                            'layout-8' => get_template_directory_uri() . '/assets/images/options/footers/footer-8.png',
                            'layout-9' => get_template_directory_uri() . '/assets/images/options/footers/footer-9.png',
                        ),
                    ),
                ),
                'nbcore_footer_bot_padding_top' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding top', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '100',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_footer_bot_padding_bottom' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding bottom', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '100',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_footer_bot_border_bot_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border Bottom Color', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_enable_colorful_widget_title' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Enable colorful widget title', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_footer_abs_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Absolute Footer', 'teepro'),
                        'description' => esc_html__('These area take text and HTML code for its content', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_footer_abs_left_content' => array(
                    'settings' => array(
                        'sanitize_callback' => ''
                    ),
                    'controls' => array(
                        'label' => esc_html__('Left content', 'teepro'),
                        'type' => 'textarea',
                    ),
                ),
                'nbcore_footer_abs_right_content' => array(
                    'settings' => array(
                        'sanitize_callback' => ''
                    ),
                    'controls' => array(
                        'label' => esc_html__('Right content', 'teepro'),
                        'type' => 'textarea',
                    ),
                ),
                'nbcore_footer_abs_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding top and bottom', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '5',
                            'max' => '60',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_footer_color_focus' => array(
                    'settings' => array(),
                    'controls' => array(
                        'type' => 'Teepro_Customize_Control_Focus',
                        'choices' => array(
                            'footer_colors' => esc_html__('Edit color', 'teepro'),
                        ),
                    ),
                ),
            ),
        );
    }

    public function blog()
    {
        return array(
            'title' => esc_html__('Blog', 'teepro'),
            'priority' => 16,
            'sections' => array(
                'blog_general' => array(
                    'title' => esc_html__('General', 'teepro')
                ),
                'blog_archive' => array(
                    'title' => esc_html__('Blog Archive', 'teepro'),
                ),
                'blog_single' => array(
                    'title' => esc_html__('Blog Single', 'teepro')
                ),
            ),
            'options' => array(
                'nbcore_blog_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_blog_sidebar' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sidebar position', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),
                'nbcore_blog_width' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Blog width', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => '%',
                            'min' => '60',
                            'max' => '80',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element' => 'nbcore_blog_sidebar',
                            'value'   => '!no-sidebar',
                        )
                    ),
                ),
                'nbcore_blog_meta_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Post meta', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_blog_meta_date' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show date', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_meta_read_time' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show time to read', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_meta_author' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show author', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_meta_category' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show categories', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_meta_tag' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Tags', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                        'condition' => array(
                            'element' => 'nbcore_blog_archive_layout',
                            'value'   => 'classic',
                        )
                    ),
                ),
                'nbcore_blog_other_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Other', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_blog_sticky_sidebar' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sticky sidebar', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_meta_align' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Meta align', 'teepro'),
                        'section' => 'blog_general',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left' => get_template_directory_uri() . '/assets/images/options/meta-left.png',
                            'center' =>get_template_directory_uri() . '/assets/images/options/meta-center.png',
                            'right' => get_template_directory_uri() . '/assets/images/options/meta-right.png',
                        ),
                    ),
                ),
                'nbcore_blog_archive_layout' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Blog Archive Layout', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'classic' => get_template_directory_uri() . '/assets/images/options/classic.png',
                            'masonry' => get_template_directory_uri() . '/assets/images/options/masonry.png',
                        ),
                    ),
                ),
                'nbcore_blog_masonry_columns' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Masonry Columns', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                        ),
                        'condition' => array(
                            'element' => 'nbcore_blog_archive_layout',
                            'value'   => 'masonry',
                        )
                    ),
                ),
                'nbcore_blog_archive_post_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Archive Post style', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'style-1' => get_template_directory_uri() . '/assets/images/options/post-style-1.png',
                            'style-2' => get_template_directory_uri() . '/assets/images/options/post-style-2.png',
                        ),
                    ),
                ),
                'nbcore_blog_archive_summary' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Post summary', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_excerpt_only' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Excerpt Only', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Switch',
                        'condition' => array(
                            'element' => array('nbcore_blog_archive_layout', 'nbcore_blog_archive_summary'),
                            'value'   => array('classic', 1),
                        )
                    ),
                ),
                'nbcore_excerpt_length' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Excerpt Length', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'min' => '20',
                            'max' => '100',
                            'step' => '1',
                        ),
                        'condition' => array(
                            'element' => 'nbcore_excerpt_only',
                            'value'   => 1,
                        )
                    ),
                ),
                'nbcore_blog_archive_comments' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Comments number', 'teepro'),
                        'section' => 'blog_archive',
                        'type' => 'Teepro_Customize_Control_Switch',
                        'condition' => array(
                            'element' => 'nbcore_blog_archive_layout',
                            'value'   => 'classic',
                        )
                    ),
                ),
                'nbcore_blog_single_title_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Post title', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_blog_single_title_position' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Post title style', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'position-1' => get_template_directory_uri() . '/assets/images/options/post-title-1.png',
                            'position-2' => get_template_directory_uri() . '/assets/images/options/post-title-2.png',
                        ),
                    ),
                ),
                'nbcore_blog_bg_single_title' => array(
                    'settings' => array(
                        'default' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background Blog Single Title', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                        'condition' => array(
                            'element' => 'nbcore_blog_single_title_position',
                            'value'   => 'position-1',
                        )
                    ),
                ),
                'nbcore_blog_single_title_size' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Font size', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '16',
                            'max' => '70',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_blog_single_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_blog_single_show_thumb' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('featured thumbnail', 'teepro'),
                        'description' => esc_html__('Show featured thumbnail of this post on top of its content', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Switch',
                    )
                ),
                'nbcore_blog_single_show_social' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show social button', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_single_show_author' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show author info', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_single_show_nav' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show post navigation', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_blog_single_show_comments' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show post comments', 'teepro'),
                        'section' => 'blog_single',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                )
            ),
        );
    }

    public static function pages()
    {
        return array(
            'title' => esc_html__('Pages', 'teepro'),
            'priority' => 18,
            'sections' => array(
                'pages_general' => array(
                    'title' => esc_html__('General', 'teepro')
                ),
               
                
            ),
            'options' => array(
                'nbcore_pages_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_page_title_image' => array(
                    'settings' => array(
                        'default'=>''
                        //'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_file_image')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Image Background Title Pages', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                    ),
                ),
                'nbcore_pages_sidebar' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sidebar position', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),
                'nbcore_pages_image_banner_bottom' => array(
                    'settings' => array(
                       // 'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_file_image')
                       'default' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Image Banner Pages', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                    ),
                ),
                'nbcore_page_text_banner_bottom' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text banner bottom section', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'textarea',
                    ),
                ),                   
                'nbcore_page_content_width' => array(
                    'settings' => array(
                        'default' => '70',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Page content width', 'teepro'),
                        'section' => 'pages_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => '%',
                            'min' => '60',
                            'max' => '80',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element' => 'nbcore_pages_sidebar',
                            'value'   => '!no-sidebar',
                        )
                    ),
                ), 
                
            ),
        );
    }

    public static function dokan()
    {
        return array(
            'title' => esc_html__('Dokan', 'teepro'),
            'priority' => 18,
            'sections' => array(
                'dokan_general' => array(
                    'title' => esc_html__('General', 'teepro')
                ),
                'dokan_dashboard' => array(
                    'title' => esc_html__('Dashboard', 'teepro'),
                ),

                'nbcore_storelist' => array(
                    'title' => esc_html__('Store listing', 'teepro')
                ),

                'nbcore_vendor' => array(
                    'title' => esc_html__('Vendor detail', 'teepro')
                ),
                
                'nbcore_product' => array(
                    'title' => esc_html__('Single Product', 'teepro')
                ),               
                
            ),
            'options' => array(
                'nbcore_dokan_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'dokan_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_dokan_sidebar' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sidebar position', 'teepro'),
                        'section' => 'dokan_general',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),

                'nbcore_dashboard_style' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox'),
                    ),
                    'controls' => array(
                        'label' => esc_html__('Light style', 'teepro'),
                        'section' => 'dokan_dashboard',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),

                /*nbcore_vendor_store_listing*/
                
                'nbcore_vendor_listing_layout_intro' => array(
                    'settings' =>  array(),
                    'controls' => array(
                        'label' => esc_html__('Vendor listing Layout', 'teepro'),
                        'section' => 'nbcore_storelist',
                        'type' => 'Teepro_Customize_Control_Heading',
                        
                    ),
                ),

                'nbcore_vendors_list' => array(
                    'settings' => array(
                        'default' => 'default',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose style store listing', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            'default' => esc_html__('Default', 'teepro'),
                            'style-1' => esc_html__('Style 1', 'teepro'),
                            'style-2' => esc_html__('Style 2', 'teepro'),
                            'style-3' => esc_html__('Style 3', 'teepro'),
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),
                
                'nbcore_storelist_per_page' => array(
                    'settings' => array(
                        'default' => '9',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors per Page', 'teepro'),
                        'type' => 'number',
                        'input_attrs' => array(
                            'min'   => 1,
                            'step'  => 1,
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),

                'nbcore_storelist_loop_columns_xl' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors per row (Large Desktops)', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            '1' => esc_html__('1', 'teepro'),
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                            '4' => esc_html__('4', 'teepro'),
                            '6' => esc_html__('6', 'teepro'),
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),

                'nbcore_storelist_loop_columns_lg' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors per row (Desktops)', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            '1' => esc_html__('1', 'teepro'),
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                            '4' => esc_html__('4', 'teepro'),
                            '6' => esc_html__('6', 'teepro'),
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),

                'nbcore_storelist_loop_columns_md' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors per row (Tablets)', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            '1' => esc_html__('1', 'teepro'),
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                            '4' => esc_html__('4', 'teepro'),
                            '6' => esc_html__('6', 'teepro'),
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),
                'nbcore_storelist_loop_columns_sm' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors per row (Mobile Landscape)', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            '1' => esc_html__('1', 'teepro'),
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                            '4' => esc_html__('4', 'teepro'),
                            '6' => esc_html__('6', 'teepro'),
                        ),
                        'section' => 'nbcore_storelist',
                    ),
                ),
                /*end_nbcore_vendor_store_listing*/

                /*nbcore_vendor*/
                'nbcore_vendor_layout_intro' => array(
                    'settings' =>  array(),
                    'controls' => array(
                        'label' => esc_html__('Vendor Layout', 'teepro'),
                        'section' => 'nbcore_vendor',
                        'type' => 'Teepro_Customize_Control_Heading',
                        
                    ),
                ),
                'nbcore_vendor_details_sidebar' => array(
                    'settings' => array(
                        'default' => 'right-sidebar',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors sidebar', 'teepro'),
                        'section' => 'nbcore_vendor',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),

                'nbcore_vendor_details_width' => array(
                    'settings' => array(
                        'default' => '75',
                            'transport' => 'postMessage',
                            'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Vendors content width', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                                'unit' => '%',
                                'min' => '60',
                                'max' => '80',
                                'step' => '1'
                            ),
                            'section' => 'nbcore_vendor',
                    ),
                ),
                'nbcore_vendor_sticky_sidebar' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sticky sidebar', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Switch',
                        'section' => 'nbcore_vendor',
                    ),
                ),
                'nbcore_vendor_map_height' => array(
                    'settings' => array(
                        'default' => '200',
                            'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Height of maps', 'teepro'),
                            'type' => 'text',
                            'section' => 'nbcore_vendor',
                    ),
                ),
                'nbcore_vendor_per_page' => array(
                    'settings' => array(
                        'default' => '12',
                            'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per Page', 'teepro'),
                            'type' => 'number',
                            'input_attrs' => array(
                                'min'   => 1,
                                'step'  => 1,
                            ),
                            'section' => 'nbcore_vendor',
                    ),
                ),        

                'nbcore_vendor_loop_columns_xl' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Large Desktops)', 'teepro'),
                        'type' => 'select',
                        'choices' => array(
                            '1' => esc_html__('1', 'teepro'),
                            '2' => esc_html__('2', 'teepro'),
                            '3' => esc_html__('3', 'teepro'),
                            '4' => esc_html__('4', 'teepro'),
                            '6' => esc_html__('6', 'teepro'),
                        ),
                        'section' => 'nbcore_vendor',
                    ),
                ),

                'nbcore_vendor_loop_columns_lg' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Desktops)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                                '6' => esc_html__('6', 'teepro'),
                            ),
                            'section' => 'nbcore_vendor',
                    ),
                ),

                'nbcore_vendor_loop_columns_md' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Tablets)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                                '6' => esc_html__('6', 'teepro'),
                            ),
                            'section' => 'nbcore_vendor',
                    ),
                ),
                'nbcore_vendor_loop_columns_sm' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Mobile Landscape)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                                '6' => esc_html__('6', 'teepro'),
                            ),
                            'section' => 'nbcore_vendor',
                    ),
                ),
                /*end_nbcore_vendor*/

                /*nbcore_product*/
                'nbcore_mp_layout_intro' => array(
                    'settings' =>  array(),
                    'controls' => array(
                        'label' => esc_html__('More Product Layout', 'teepro'),
                            'description' => esc_html__('If enable \'More product\' tab on product single page view', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                        'section' => 'nbcore_product',
                        
                    ),
                ),
                'nbcore_mp_loop_columns_xl' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Large Desktops)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                            ),
                            'section' => 'nbcore_product',
                        ),
                    ),
                
                'nbcore_mp_loop_columns_lg' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Desktops)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                            ),
                            'section' => 'nbcore_product',
                    ),
                ),
                'nbcore_mp_loop_columns_md' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Tablets)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                            ),
                            'section' => 'nbcore_product',
                    ),
                ),
                'nbcore_mp_loop_columns_sm' => array(
                    'settings' => array(
                        'default' => '2',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row (Mobile Landscape)', 'teepro'),
                            'type' => 'select',
                            'choices' => array(
                                '1' => esc_html__('1', 'teepro'),
                                '2' => esc_html__('2', 'teepro'),
                                '3' => esc_html__('3', 'teepro'),
                                '4' => esc_html__('4', 'teepro'),
                            ),
                            'section' => 'nbcore_product',
                    ),
                ),
                /*end_nbcore_product*/
            ),
        );
    }

    public static function services()
    {
        return array(
            'title' => esc_html__('Services', 'teepro'),
            'priority' => 18,
            'sections' => array(
                'services_general' => array(
                    'title' => esc_html__('General', 'teepro')
                ),
               
                
            ),
            'options' => array(
                'nbcore_services_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'show_service_title' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show title service', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_services_image_banner_top' => array(
                    'settings' => array(
                       // 'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_file_image')
                       'default' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Image Banner Title Service', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                    ),
                    'condition' => array(
                        'element' => 'show_service_title',
                        'value'   => 1,
                    )
                ),
                'nbcore_services_sidebar' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sidebar position', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),
                'nbcore_services_image_banner_bottom' => array(
                    'settings' => array(
                       // 'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_file_image')
                       'default' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Image Banner Bottom Service', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                    ),
                ),
                'nbcore_services_text_banner_bottom' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text banner bottom section', 'teepro'),
                        'section' => 'services_general',
                        'type' => 'textarea',
                    ),
                ),                   
               
                
            ),
        );
    }

    public function nblayout()
    {
        return array(
            'title' => esc_html__('Layout', 'teepro'),
            'priority' => 15,
            'sections' => array(
                'site_layout' => array(
                    'title' => esc_html__('Layout', 'teepro'),
                ),

            ),
            'options' => array(

                'nbcore_container_width' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Container Width', 'teepro'),
                        'section' => 'site_layout',
                        'type' => 'select',
                        'choices' => array(
                            '1170' => esc_html__('Standard (1170px)', 'teepro'),
                            '1470' => esc_html__('Wide (1470px)', 'teepro'),
                        ),
                        'default' => '1170',
                        'description' => 'Wide option only works on screen resolution >= 1920px'
                    ),
                ),
            ),
        );
    }

    public function color()
    {
        return array(
            'title' => esc_html__('Color', 'teepro'),
            'priority' => 13,
            'sections' => array(
                'general_color' => array(
                    'title' => esc_html__('General', 'teepro')
                ),
                'type_color' => array(
                    'title' => esc_html__('Type', 'teepro')
                ),
                'header_colors' => array(
                    'title' => esc_html__('Header', 'teepro')
                ),
                'footer_colors' => array(
                    'title' => esc_html__('Footer', 'teepro')
                ),
                'button_colors' => array(
                    'title' => esc_html__('Buttons', 'teepro')
                ),
                'other_colors' => array(
                    'title' => esc_html__('Other', 'teepro')
                ),
            ),
            'options' => array(
                'nbcore_main_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Main Colors', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_primary_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Primary Color', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_secondary_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Secondary Color', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_background_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Background', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_background_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Site Background Color', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_inner_background' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Inner Background Color', 'teepro'),
                        'section' => 'general_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_text_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Text', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_heading_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Heading Color', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_body_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Body Color', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_link_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Link', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_link_color' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Link Color', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_link_hover_color' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Link Hover Color', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_divider_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Divider', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_divider_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Divider Color', 'teepro'),
                        'section' => 'type_color',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_top_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header Top', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_header_top_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('background color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_top_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_top_color_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color hover', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_middle_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header Middle', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_header_middle_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('background color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_middle_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_middle_color_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color hover', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_bottom_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header Bottom', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_header_bot_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('background color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_bot_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_mainmn_colors_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Main Menu', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_header_mainmn_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_mainmn_bor' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border color', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_mainmnhover_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text hover', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_header_mainmnhover_bor' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('border hover', 'teepro'),
                        'section' => 'header_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_top_color_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Footer top', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_footer_top_heading' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Heading color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_top_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_top_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_bot_color_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Footer bottom', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_footer_bot_heading' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Heading color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_bot_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_bot_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_abs_color_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Footer Absolute Bottom', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_footer_abs_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_footer_abs_bg' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background color', 'teepro'),
                        'section' => 'footer_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Primary button', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_pb_background' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_background_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background Hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_text' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_text_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_border' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_pb_border_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Secondary button', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_sb_background' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_background_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Background Hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_text' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_text_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_border' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_sb_border_hover' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border hover', 'teepro'),
                        'section' => 'button_colors',
                        'type' => 'Teepro_Customize_Control_Color',
                    ),
                ),
                'nbcore_page_title_color_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Page title', 'teepro'),
                        'section' => 'other_colors',
                        'type' => 'Teepro_Customize_Control_Heading'
                    ),
                ),
                'nbcore_page_title_color' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text color', 'teepro'),
                        'section' => 'other_colors',
                        'type' => 'Teepro_Customize_Control_Color'
                    ),
                ),
            ),
        );
    }

    public function elements()
    {
        return array(
            'title' => esc_html__('Elements', 'teepro'),
            'priority' => 12,
            'sections' => array(
                'title_section_element' => array(
                    'title' => esc_html__('Title Section', 'teepro')
                ),
                'button_element' => array(
                    'title' => esc_html__('Button', 'teepro')
                ),
                'share_buttons_element' => array(
                    'title' => esc_html__('Social Share', 'teepro')
                ),
                'pagination_element' => array(
                    'title' => esc_html__('Pagination', 'teepro')
                ),
                'back_top_element' => array(
                    'title' => esc_html__('Back to Top Button', 'teepro')
                ),
                'preloading_element' => array(
                    'title' => esc_html__('Preloading', 'teepro')
                ),
            ),
            'options' => array(
                'show_title_section' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show title section', 'teepro'),
                        'section' => 'title_section_element',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'home_page_title_section' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Homepage title', 'teepro'),
                        'description' => esc_html__('Turn this off to not display the title section for only homepage', 'teepro'),
                        'section' => 'title_section_element',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_page_title_size' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Font size', 'teepro'),
                        'section' => 'title_section_element',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '16',
                            'max' => '70',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_page_title_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding top and bottom', 'teepro'),
                        'section' => 'title_section_element',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '15',
                            'max' => '105',
                            'step' => '1'
                        ),
                    ),
                ),
               
                'nbcore_page_title_color_focus' => array(
                    'settings' => array(),
                    'controls' => array(
                        'section' => 'title_section_element',
                        'type' => 'Teepro_Customize_Control_Focus',
                        'choices' => array(
                            'other_colors' => esc_html__('Edit color', 'teepro')
                        ),
                    ),
                ),
                'nbcore_button_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Padding left & right', 'teepro'),
                        'section' => 'button_element',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '5',
                            'max' => '60',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_button_border_radius' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border Radius', 'teepro'),
                        'section' => 'button_element',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '50',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_button_border_width' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Border Width', 'teepro'),
                        'section' => 'button_element',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '10',
                            'step' => '1'
                        ),
                    ),
                ),
                'share_buttons_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Style','teepro'),
                        'section' => 'share_buttons_element',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'style-1' => esc_html__('Style 1', 'teepro'),
                            'style-2' => esc_html__('Style 2', 'teepro'),
                        ),
                    ),
                ),
                'share_buttons_position' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Buttons position','teepro'),
                        'section' => 'share_buttons_element',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'inside-content' => get_template_directory_uri() . '/assets/images/options/ss-inside.png',
                            'floating' => get_template_directory_uri() . '/assets/images/options/ss-floating.png',
                        ),
                    ),
                ),
                'pagination_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Style', 'teepro'),
                        'section' => 'pagination_element',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'pagination-style-1' => esc_html__('Style 1','teepro'),
                            'pagination-style-2' => esc_html__('Style 2','teepro'),
                        ),
                    ),
                ),
                'show_back_top' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show button', 'teepro'),
                        'section' => 'back_top_element',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'back_top_shape' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show button', 'teepro'),
                        'section' => 'back_top_element',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'circle' => esc_html__('Circle','teepro'),
                            'square' => esc_html__('Square','teepro'),
                        ),
                    ),
                ),
                'back_top_style' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show button', 'teepro'),
                        'section' => 'back_top_element',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'light' => esc_html__('Light','teepro'),
                            'dark' => esc_html__('Dark','teepro'),
                        ),
                    ),
                ),
                'nbcore_header_preloading' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Preloading', 'teepro'),
                        'section' => 'preloading_element',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_header_style_preloading' => array(
                    'settings' => array(
                        'transport' => 'refresh',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose style preloading', 'teepro'),
                        'section' => 'preloading_element',
                        'type' => 'Teepro_Customize_Control_Select',
                        'condition' => array(
                            'element' => 'nbcore_header_preloading',
                            'value' => 1,
                        ),
                        'choices' => array(
                            'demo1' => 'Square',
                            'demo2' => 'Square Zoom',
                            'demo3' => 'Square Rotate',
                            'demo4' => 'square Scale',
                            'demo5' => 'Square Shape',
                            'demo6' => 'Square Double Rotate',
                            'demo7' => 'Square Zoom & Rotate',
                            'demo8' => 'Square Dance',
                            'demo9' => 'Square Interleaved',
                            'demo10' => 'Circle Toggle',
                            'demo11' => 'Circle Zoom',
                            'demo12' => 'Circle Scroll',
                            'demo13' => 'Circle Dance',
                            'demo14' => 'Twisted',
                            'demo15' => 'Twisted Sporadic',
                        ),
                        
                    ),
                ),
            ),
        );
    }

    public function header()
    {
        return array(
            'title' => esc_html__('Header Options', 'teepro'),
            'description' => esc_html__('header description', 'teepro'),
            'priority' => 11,
            'sections' => array(
                'header_presets' => array(
                    'title' => esc_html__('Presets', 'teepro'),
                ),
                'header_general' => array(
                    'title' => esc_html__('Sections', 'teepro'),
                ),
            ),
            'options' => array(
                'header_heading' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header style', 'teepro'),
                        'description' => esc_html__('Quickly select a preset to change your header layout.', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                        'section' => 'header_presets',
                    ),
                ),
                'nbcore_header_style' => array(
                    'settings' => array(
                        'transport' => 'refresh',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'section' => 'header_presets',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'teepro-header-1' => get_template_directory_uri() . '/assets/images/options/headers/left-inline.png',
                            'teepro-header-2' => get_template_directory_uri() . '/assets/images/options/headers/left-inline.png',
                            'teepro-header-3' => get_template_directory_uri() . '/assets/images/options/headers/left-inline.png',
                            'teepro-header-4' => get_template_directory_uri() . '/assets/images/options/headers/left-inline.png',
                        ),
                    ),
                ),
                'nbcore_general_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('General', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                
                'nbcore_logo_upload' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_file_image')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Site Logo', 'teepro'),
                        'section' => 'header_general',
                        'description' => esc_html__('If you don\'t upload logo image, your site\'s logo will be the Site Title ', 'teepro'),
                        'type' => 'WP_Customize_Upload_Control'
                    ),
                ),
                'nbcore_logo_width' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Logo Area Width', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '100',
                            'max' => '600',
                            'step' => '10',
                        ),
                    ),
                ),
                'nbcore_logo_currency_width' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Logo Currency', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '10',
                            'max' => '64',
                            'step' => '1',
                        ),
                    ),
                ),
                'nbcore_menu_resp' => array(
                    'settings' => array(
                        'default' => '768',
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Menu Responsive', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'select',
                        'choices' => array(
                            '576' => esc_html__('576 px', 'teepro'),
                            '768' => esc_html__('768 px', 'teepro'),
                            '992' => esc_html__('992 px', 'teepro'),
                            '1200' => esc_html__('1200 px', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_header_fixed' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Fixed header', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_header_text_section' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Text section', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'textarea',
                    ),
                ),
                'nbcore_header_top_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header topbar', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_top_section_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Top & bottom padding', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '45',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_header_middle_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header Middle', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_middle_section_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Top & bottom padding', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '45',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_header_bot_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Header bottom', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_bot_section_padding' => array(
                    'settings' => array(
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Top & bottom padding', 'teepro'),
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '0',
                            'max' => '45',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_header_color_focus' => array(
                    'settings' => array(),
                    'controls' => array(
                        'section' => 'header_general',
                        'type' => 'Teepro_Customize_Control_Focus',
                        'choices' => array(
                            'header_colors' => esc_html__('Edit color', 'teepro'),
                        ),
                    ),
                ),

            ),
        );
    }

    public function typo()
    {
        return array(
            'title' => esc_html__('Typography', 'teepro'),
            'priority' => 14,
            'options' => array(
                'body_font_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Body Font', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'body_font_family' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label'   => esc_html__( 'Font Family', 'teepro' ),
                        'dependency' => 'body_font_style',
                        'type'    => 'Teepro_Customize_Control_Typography',
                    ),
                ),
                'body_font_style' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Font Styles', 'teepro'),
                        'type'    => 'Teepro_Customize_Control_Font_Style',
                        'choices' => array(
                            'italic' => true,
                            'underline' => true,
                            'uppercase' => true,
                            'weight' => true,
                        )
                    ),
                ),
                'body_font_size' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Font Size', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '8',
                            'max' => '30',
                            'step' => '1',
                        ),
                    ),
                ),
                'heading_font_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Heading Font', 'teepro'),
                        'section' => 'typography',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'heading_font_family' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label'   => esc_html__( 'Heading font', 'teepro' ),
                        'dependency' => 'heading_font_style',
                        'type'    => 'Teepro_Customize_Control_Typography',
                    ),
                ),
                'heading_font_style' => array(
                    'settings' => array(
                        'sanitize_callback' => 'wp_filter_nohtml_kses',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Font Styles', 'teepro'),
                        'type'    => 'Teepro_Customize_Control_Font_Style',
                        'choices' => array(
                            'italic' => true,
                            'underline' => true,
                            'uppercase' => true,
                            'weight' => true,
                        ),
                    ),
                ),
                'heading_base_size' => array(
                    'settings' => array(
                        'sanitize_callback' => 'absint',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Heading base size', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => 'px',
                            'min' => '10',
                            'max' => '40',
                            'step' => '1',
                        ),
                    ),
                ),
                'subset_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Font subset', 'teepro'),
                        'description' => esc_html__('Turn these settings on if you have to support these scripts', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'subset_cyrillic' => array(
                    'settings' => array(
                        'transport' => 'refresh',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox'),
                    ),
                    'controls' => array(
                        'label'   => esc_html__( 'Cyrillic subset', 'teepro' ),
                        'type'    => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'subset_greek' => array(
                    'settings' => array(
                        'transport' => 'refresh',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox'),
                    ),
                    'controls' => array(
                        'label'   => esc_html__( 'Greek subset', 'teepro' ),
                        'type'    => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'subset_vietnamese' => array(
                    'settings' => array(
                        'transport' => 'refresh',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox'),
                    ),
                    'controls' => array(
                        'label'   => esc_html__( 'Vietnamese subset', 'teepro' ),
                        'type'    => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'font_color_focus' => array(
                    'settings' => array(),
                    'controls' => array(
                        'type'    => 'Teepro_Customize_Control_Focus',
                        'choices' => array(
                            'type_color' => esc_html__('Edit font color', 'teepro'),
                        ),
                    ),
                ),
            ),
        );
    }

    public function woocommerce()
    {
        return array(
            'title' => esc_html__('Shop', 'teepro'),
            'priority' => 15,
            'sections' => array(
                'product_category' => array(
                    'title' => esc_html__('Product Category', 'teepro'),
                ),
                'product_details' => array(
                    'title' => esc_html__('Product Details', 'teepro'),
                ),
                'other_wc_pages' => array(
                    'title' => esc_html__('Other Pages', 'teepro'),
                ),
            ),
            'options' => apply_filters('attribute_hook', array(
                'nbcore_pa_title_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Product category title', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_shop_title' => array(
                    'settings' => array(
                        'default' => esc_html__('Shop', 'teepro'),
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'wp_filter_nohtml_kses'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Shop page title', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'text',
                    ),
                ),
                'nbcore_wc_breadcrumb' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show breadcrumb ?', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pa_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Product category layout', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_shop_sidebar' => array(
                    'settings' => array(
                        'default' => 'right-sidebar',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sidebar Layout', 'teepro'),
                        'section' => 'product_category',
                        'description' => esc_html__('Sidebar Position for product category and shop page', 'teepro'),
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),
                'nbcore_shop_content_width' => array(
                    'settings' => array(
                        'default' => '70',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Woocommerce content width', 'teepro'),
                        'description' => esc_html__('This options also effect Cart page', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => '%',
                            'min' => '60',
                            'max' => '80',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element' => 'nbcore_shop_sidebar',
                            'value'   => '!no-sidebar',
                        )
                    ),
                ),
                'shop_sticky_sidebar' => array(
                    'settings' => array(
                        'default' => 'right-sidebar',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sticky Sidebar', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),

                'nbcore_product_meta_align' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose product meta align', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'select',
                        'choices' => array(
                            'left' => esc_html__('Left', 'teepro'),
                            'center' => esc_html__('Center', 'teepro'),
                            'right' => esc_html__('Right', 'teepro'),
                        ),
                        'default' => 'left'
                    ),
                ),

                'nbcore_product_price_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose product price style', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'select',
                        'choices' => array(
                            'default_woo' => esc_html__('Default Woocommerce', 'teepro'),
                            'space_between' => esc_html__('Space Between', 'teepro'),
                            'no_strike' => esc_html__('No Strike', 'teepro'),
                        ),
                        'default' => 'default_woo'
                    ),
                ),

                'nbcore_product_hover' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose product hover', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'select',
                        'choices' => array(
                            'image' => esc_html__('Display box shadow only product image', 'teepro'),
                            'full_block' => esc_html__('Display box shadow whole product block', 'teepro'),
                        ),
                        'default' => 'horizontal'
                    ),
                ),

                'nbcore_product_list' => array(
                    'settings' => array(
                        'default' => 'grid-type',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product List Style', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'grid-type' => get_template_directory_uri() . '/assets/images/options/grid.png',
                            'list-type' => get_template_directory_uri() . '/assets/images/options/list.png',
                        ),
                    ),
                ),


                'nbcore_enable_product_title_bold' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Enable Product Title Bold', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch'
                    ),
                ),
                
                'nbcore_grid_product_description' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product Description', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                        'condition' => array(
                            'element' => 'nbcore_product_list',
                            'value'   => 'grid-type',
                        )
                    ),
                ),
                'nbcore_loop_columns' => array(
                    'settings' => array(
                        'default' => 'three-columns',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'two-columns' => get_template_directory_uri() . '/assets/images/options/2-columns.png',
                            'three-columns' => get_template_directory_uri() . '/assets/images/options/3-columns.png',
                            'four-columns' => get_template_directory_uri() . '/assets/images/options/4-columns.png',
                        ),
                        'condition' => array(
                            'element' => 'nbcore_product_list',
                            'value'   => 'grid-type',
                        )
                    ),
                ),
                'nbcore_pa_other_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Other', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_shop_banner' => array(
                    'settings' => array(
                        'default' => '',
                    ),
                    'controls' => array(
                        'label' => esc_html__('Shop Banner', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'WP_Customize_Cropped_Image_Control',
                        'flex_width'  => true,
                        'flex_height' => true,
                        'width' => 2000,
                        'height' => 1000,
                    ),
                ),
                'nbcore_shop_action' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show shop action', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch'
                    ),
                ),

                'nbcore_product_image_mask' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show opacity when hover', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch'
                    ),
                ),

                'nbcore_product_rating' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show product rating', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch'
                    ),
                ),

                'nbcore_product_action_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose product action style', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'select',
                        'choices' => array(
                            'center' => esc_html__('Center', 'teepro'),
                            'vertical' => esc_html__('Vertical', 'teepro'),
                            'horizontal' => esc_html__('Horizontal', 'teepro'),
                        ),
                        'default' => 'horizontal'
                    ),
                ),

                'nbcore_products_per_page' => array(
                    'settings' => array(
                        'default' => '12',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per Page', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Number',
                        'input_attrs' => array(
                            'min'   => 1,
                            'step'  => 1,
                        ),
                    ),
                ),
                'nbcore_wc_sale' => array(
                    'settings' => array(
                        'default' => 'style-1',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose sale tag style', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'style-1' => esc_html__('Style 1', 'teepro'),
                            'style-2' => esc_html__('Style 2', 'teepro'),
                            'style-3' => esc_html__('Style 3', 'teepro'),
                        ),
                    ),
                ),
                'product_category_wishlist' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Wishlist button', 'teepro'),
                        'description' => esc_html__('This feature need YITH Woocommerce Wishlist plugin to be installed and activated', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'product_category_compare' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Compare button', 'teepro'),
                        'description' => esc_html__('This feature need YITH Woocommerce Compare plugin to be installed and activated', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'product_category_quickview' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Quickview button', 'teepro'),
                        'description' => esc_html__('This feature need YITH Woocommerce Quick View plugin to be installed and activated', 'teepro'),
                        'section' => 'product_category',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_layout_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Layout', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_pd_details_title' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Enable Product title', 'teepro'),
                        'description' => esc_html__('Default product title is not display if the Page title is showing. Enable this to displaying both.', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_enable_review_rating' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Enable Review Rating', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_details_sidebar' => array(
                    'settings' => array(
                        'default' => 'right-sidebar',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product details sidebar', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-sidebar' => get_template_directory_uri() . '/assets/images/options/2cl.png',
                            'no-sidebar' => get_template_directory_uri() . '/assets/images/options/1c.png',
                            'right-sidebar' => get_template_directory_uri() . '/assets/images/options/2cr.png',
                        ),
                    ),
                ),
                'nbcore_pd_details_width' => array(
                    'settings' => array(
                        'default' => '70',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product details content width', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => '%',
                            'min' => '60',
                            'max' => '80',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element'   => 'nbcore_pd_details_sidebar',
                            'value'     => '!no-sidebar',
                        )
                    ),
                ),
                'product_sticky_sidebar' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Sticky sidebar', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_meta_layout' => array(
                    'settings' => array(
                        'default' => 'left-images',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product meta layout', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'left-images' => get_template_directory_uri() . '/assets/images/options/left-image.png',
                            'right-images' => get_template_directory_uri() . '/assets/images/options/right-image.png',
                            'wide' => get_template_directory_uri() . '/assets/images/options/wide.png',
                        ),
                    ),
                ),
                'nbcore_add_cart_style' => array(
                    'settings' => array(
                        'default' => 'style-1',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Add to cart input style', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'style-1' => esc_html__('Style 1', 'teepro'),
                            'style-2' => esc_html__('Style 2', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_pd_show_social' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show social share?', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_show_size_guide' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show size guide', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_gallery_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Product Gallery', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_pd_images_width' => array(
                    'settings' => array(
                        'default' => '50',
                        'transport' => 'postMessage',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Product images width', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Slider',
                        'choices' => array(
                            'unit' => '%',
                            'min' => '30',
                            'max' => '60',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element' => 'nbcore_pd_meta_layout',
                            'value'   => '!wide',
                        )
                    ),
                ),
                'nbcore_pd_featured_autoplay' => array(
                    'settings' => array(
                        'default' => false,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Featured Images Autoplay', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_thumb_pos' => array(
                    'settings' => array(
                        'default' => 'bottom-thumb',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Small thumb position', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'bottom-thumb' => get_template_directory_uri() . '/assets/images/options/bottom-thumb.png',
                            'left-thumb' => get_template_directory_uri() . '/assets/images/options/left-thumb.png',
                            'inside-thumb' => get_template_directory_uri() . '/assets/images/options/inside-thumb.png',
                        ),
                    ),
                ),
                'nbcore_pd_info_tab_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Information tab', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_info_style' => array(
                    'settings' => array(
                        'default' => 'accordion-tabs',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Tabs style', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'horizontal-tabs' => esc_html__('Horizontal', 'teepro'),
                            'accordion-tabs' => esc_html__('Accordion', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_reviews_form' => array(
                    'settings' => array(
                        'default' => 'split',
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Reviews form style', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            'split' => esc_html__('Split', 'teepro'),
                            'full-width' => esc_html__('Full Width', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_reviews_round_avatar' => array(
                    'settings' => array(
                        'default' => false,
                        'transport' => 'postMessage',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Round reviewer avatar', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_other_products_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Related & Cross-sells products', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Heading',
                    ),
                ),
                'nbcore_show_upsells' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show upsells products?', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_upsells_columns' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Upsells Products per row', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            '2' => esc_html__('2 Products', 'teepro'),
                            '3' => esc_html__('3 Products', 'teepro'),
                            '4' => esc_html__('4 Products', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_upsells_limit' => array(
                    'settings' => array(
                        'default' => '6',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Upsells Products limit', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Number',
                        'input_attrs' => array(
                            'min' => '2',
                            'step' => '1'
                        ),
                    ),
                ),
                'nbcore_show_related' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show related product?', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_pd_related_columns' => array(
                    'settings' => array(
                        'default' => '3',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Related Products per row', 'teepro'),
                        'section' => 'product_details',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            '2' => esc_html__('2 Products', 'teepro'),
                            '3' => esc_html__('3 Products', 'teepro'),
                            '4' => esc_html__('4 Products', 'teepro'),
                        ),
                    ),
                ),
                'nbcore_cart_intro' => array(
                    'settings' => array(),
                    'controls' => array(
                        'label' => esc_html__('Cart', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Heading'
                    ),
                ),
                'nbcore_cart_layout' => array(
                    'settings' => array(
                        'default' => 'cart-layout-1',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Cart page layout', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Radio_Image',
                        'choices' => array(
                            'cart-layout-1' => get_template_directory_uri() . '/assets/images/options/cart-style-1.png',
                            'cart-layout-2' => get_template_directory_uri() . '/assets/images/options/cart-style-2.png',
                        ),
                    ),
                ),
                'nbcore_show_to_shop' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show Continue shopping button', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Switch',
                    ),
                ),
                'nbcore_show_cross_sells' => array(
                    'settings' => array(
                        'default' => true,
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Show cross sells', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Switch'
                    ),
                ),
                'nbcore_cross_sells_per_row' => array(
                    'settings' => array(
                        'default' => '4',
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Products per row', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Select',
                        'choices' => array(
                            '3' => esc_html__('3 products', 'teepro'),
                            '4' => esc_html__('4 products', 'teepro'),
                            '5' => esc_html__('5 products', 'teepro'),
                        ),
                        'condition' => array(
                            'element' => 'nbcore_show_cross_sells',
                            'value'   => 1,
                        )
                    ),
                ),
                'nbcore_cross_sells_limit' => array(
                    'settings' => array(
                        'default' => '6',
                        'sanitize_callback' => 'absint'
                    ),
                    'controls' => array(
                        'label' => esc_html__('Cross sells Products limit', 'teepro'),
                        'section' => 'other_wc_pages',
                        'type' => 'Teepro_Customize_Control_Number',
                        'input_attrs' => array(
                            'min' => '3',
                            'step' => '1'
                        ),
                        'condition' => array(
                            'element' => 'nbcore_show_cross_sells',
                            'value'   => 1,
                        )
                    ),
                ),
            )),
        );
    }
    public function onlinedesign()
    {
        return array(
            'title' => esc_html__('Online Design', 'teepro'),
            'priority' => 15,
            'sections' => array(
                'online_design' => array(
                    'title' => esc_html__('Online Design', 'teepro'),
                ),
            ),
            'options' => array(
                'nbcore_template_designer_style' => array(
                    'settings' => array(
                        'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_selection')
                    ),
                    'controls' => array(
                        'label' => esc_html__('Choose template designer style', 'teepro'),
                        'section' => 'online_design',
                        'type' => 'select',
                        'choices' => array(
                            'style1' => esc_html__('Style 1', 'teepro'),
                            'style2' => esc_html__('Style 2', 'teepro'),
                            'style3' => esc_html__('Style 3', 'teepro'),
                        ),
                        'default' => 'style1'
                    ),
                ),
            ),
        ); 
    }
}