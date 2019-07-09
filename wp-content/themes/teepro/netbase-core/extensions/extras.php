<?php
function add_attribute($option){

    $attributes = array();
    if ( class_exists( 'WooCommerce' ) ) {
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $attributes = array();
        foreach($attribute_taxonomies as $attr)
        {
            $attributes[$attr->attribute_name] = $attr->attribute_label;
        }
    }

    $option['nbcore_pa_swatch_intro']= array(
        'settings' => array(),
        'controls' => array(
            'label' => esc_html__('Swatch style Attributes', 'teepro'),
            'section' => 'product_category',
            'type' => 'Teepro_Customize_Control_Heading',
        ),
    );

    $option['nbcore_wc_attr']= array(
        'settings' => array(
            'default' => true,
            'sanitize_callback' => array('Teepro_Customize_Sanitize', 'sanitize_checkbox')
        ),
        'controls' => array(
            'label' => esc_html__('Show Attribute ?', 'teepro'),
            'description' => esc_html__('This options also effect for product attributes in product archive', 'teepro'),
            'section' => 'product_category',
            'type' => 'Teepro_Customize_Control_Switch',
        ),
    );

    $option['nbcore_pa_swatch_style' ]= array(
        'settings' => array('sanitize_callback' => '',),
        'controls' => array(
            'label' => esc_html__('Swatch style Attributes', 'teepro'),
            'description' => esc_html__('This options also effect for product attributes', 'teepro'),
            'section' => 'product_category',
            'type' => 'Teepro_Customize_Control_Checkbox_List',
            'choices' => $attributes,
            'condition' => array(
                'element' => 'nbcore_wc_attr',
                'value'   => 1,
            )
        ),
    );
    return $option;
}
add_filter('attribute_hook','add_attribute');