<?php
    /*
    *
    *	Wpbingo Framework Menu Functions
    *	------------------------------------------------
    *	Wpbingo Framework v3.0
    * 	Copyright Wpbingo Ideas 2017 - http://wpbingosite.com/
    *
    *	cerio_setup_menus()
    *
    */
    /* CUSTOM MENU SETUP
    ================================================== */
    register_nav_menus( array(
        'main_navigation' => esc_html__( 'Main Menu', 'cerio' ),
		'vertical_menu'     => esc_html__( 'Vertical Menu', 'cerio' ),
		'currency_menu'     => esc_html__( 'Currency Menu', 'cerio' ),   
        'language_menu'     => esc_html__( 'Language Menu', 'cerio' ),
		'topbar_menu'     => esc_html__( 'Topbar Menu', 'cerio' )
    ) );
?>