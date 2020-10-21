	<?php 
		$cerio_settings = cerio_global_settings();
		$cart_style = cerio_get_config('cart-style','popup');
		$show_minicart = (isset($cerio_settings['show-minicart']) && $cerio_settings['show-minicart']) ? ($cerio_settings['show-minicart']) : false;
		$show_compare = (isset($cerio_settings['show-compare']) && $cerio_settings['show-compare']) ? ($cerio_settings['show-compare']) : false;
		$enable_sticky_header = ( isset($cerio_settings['enable-sticky-header']) && $cerio_settings['enable-sticky-header'] ) ? ($cerio_settings['enable-sticky-header']) : false;
		$show_searchform = (isset($cerio_settings['show-searchform']) && $cerio_settings['show-searchform']) ? ($cerio_settings['show-searchform']) : false;
		$show_wishlist = (isset($cerio_settings['show-wishlist']) && $cerio_settings['show-wishlist']) ? ($cerio_settings['show-wishlist']) : false;
		$show_currency = (isset($cerio_settings['show-currency']) && $cerio_settings['show-currency']) ? ($cerio_settings['show-currency']) : false;
		$show_menutop = (isset($cerio_settings['show-menutop']) && $cerio_settings['show-menutop']) ? ($cerio_settings['show-menutop']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v10">
		<?php cerio_menu_mobile(); ?>
		<div class="header-desktop">
			<?php if(($show_minicart || $show_wishlist || $show_searchform || is_active_sidebar('top-link')) && class_exists( 'WooCommerce' ) ){ ?>
			<div class='header-wrapper' data-sticky_header="<?php echo esc_attr($cerio_settings['enable-sticky-header']); ?>">
				<div class="container">
					<div class="row">
						<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 header-left content-header">
							<?php cerio_header_logo(); ?>
							<div class="wpbingo-menu-mobile header-menu">
								<div class="header-menu-bg">
									<?php cerio_top_menu(); ?>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 header-right">
							<div class="header-page-link">
								<!-- Begin Search -->
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
								<div class="search-box">
									<div class="search-toggle"><i class="icon-search"></i></div>
								</div>
								<?php } ?>
								<?php if(is_active_sidebar('top-link')){ ?>
									<div class="block-top-link">
										<?php dynamic_sidebar( 'top-link' ); ?>
									</div>
								<?php } ?>
								<!-- End Search -->						
								<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
								<div class="wishlist-box">
									<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="icon-heart"></i></a>
								</div>
								<?php } ?>
								<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
								<div class="cerio-topcart <?php echo esc_attr($cart_style); ?>">
									<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- End header-wrapper -->
			<?php }else{ ?>
				<div class="header-normal">
					<div class='header-wrapper' data-sticky_header="<?php echo esc_attr($cerio_settings['enable-sticky-header']); ?>">
						<div class="container">
							<div class="row">
								<div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 header-left">
									<?php cerio_header_logo(); ?>
								</div>
								<div class="col-xl-10 col-lg-9 col-md-6 col-sm-6 col-6 wpbingo-menu-mobile header-main">
									<div class="header-menu-bg">
										<?php cerio_top_menu(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php cerio_login_form(); ?>
		</div>
	</header><!-- End #bwp-header -->