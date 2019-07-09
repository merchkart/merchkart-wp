<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package core-wp
 */
?><!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="<?php bloginfo('charset');?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class();?>>

<?php 
if(teepro_get_options('nbcore_header_preloading')){
	get_template_part('/template-parts/preloading/preloading');
} 
?>
<div id="page" class="site">

	<div id="site-wrapper" <?php if(teepro_get_options('nbcore_page_fullbox')) { echo 'class="container"'; } ?>>


		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'teepro');?></a>

		<header class="site-header <?php teepro_header_class(); ?>" role="banner">

			<?php
			do_action('nb_core_before_header');

			teepro_get_header();



			// teepro_get_nav_mobile();

			do_action('nb_core_after_header');
			?>

		</header>

		<div id="content" class="site-content">