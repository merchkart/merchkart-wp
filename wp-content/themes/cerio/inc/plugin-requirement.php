<?php
/***** Active Plugin ********/
add_action( 'tgmpa_register', 'cerio_register_required_plugins' );
function cerio_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__('Woocommerce', 'cerio'), 
            'slug'               => 'woocommerce', 
            'required'           => false
        ),
		array(
            'name'      		 => esc_html__('Elementor', 'cerio'),
            'slug'     			 => 'elementor',
            'required' 			 => false
        ),		
		array(
            'name'               => esc_html__('Revolution Slider', 'cerio'), 
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip', 
			'required'           => true, 
        ),
		array(
            'name'               => esc_html__('Wpbingo Core', 'cerio'), 
            'slug'               => 'wpbingo', 
            'source'             => get_template_directory() . '/plugins/wpbingo.zip',
            'required'           => true, 
        ),			
		array(
            'name'               => esc_html__('Redux Framework', 'cerio'), 
            'slug'               => 'redux-framework', 
            'required'           => false
        ),			
		array(
            'name'      		 => esc_html__('Contact Form 7', 'cerio'),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false
        ),	
		array(
            'name'     			 => esc_html__('YITH Woocommerce Wishlist', 'cerio'),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ),
		array(
            'name'      		 => esc_html__('YITH Woocommerce Compare', 'cerio'),
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),		
		array(
            'name'     			 => esc_html__('WooCommerce Variation Swatches', 'cerio'),
            'slug'      		 => 'variation-swatches-for-woocommerce',
            'required' 			 => false
        ),
    );
    $config = array();
    tgmpa( $plugins, $config );
}