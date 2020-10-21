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
	<header id='bwp-header' class="bwp-header header-v7">
		<?php if(isset($cerio_settings['show-header-top']) && $cerio_settings['show-header-top']){ ?>
		<div id="bwp-topbar" class="topbar-v1 hidden-sm hidden-xs">
			<div class="topbar-inner">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 topbar-left hidden-sm hidden-xs">
							<?php if( isset($cerio_settings['address']) && $cerio_settings['address'] ) : ?>
							<div class="email hidden-xs">
								<i class="icon_pin_alt"></i><?php echo esc_html($cerio_settings['address']); ?>
							</div>
							<?php endif; ?>
							<?php if( isset($cerio_settings['email']) && $cerio_settings['email'] ) : ?>
							<div class="email hidden-xs">
								<i class="icon-mail"></i><a href="mailto:<?php echo esc_attr($cerio_settings['email']); ?>"><?php echo esc_html($cerio_settings['email']); ?></a>
							</div>
							<?php endif; ?>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 topbar-right">
							<?php if($show_menutop){ ?>
								<?php wp_nav_menu( 
								  array( 
									  'theme_location' => 'topbar_menu', 
									  'container' => 'false', 
									  'menu_id' => 'topbar_menu', 
									  'menu_class' => 'menu'
								   ) 
								); ?>
							<?php } ?>
							<?php echo do_shortcode( "[social_link]" ) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if(($show_minicart || $show_wishlist || $show_compare || $show_searchform || is_active_sidebar('top-link')) && class_exists( 'WooCommerce' ) ){ ?>
			<?php cerio_menu_mobile(true); ?>
			<div class="header-desktop">
				<div class='header-wrapper' data-sticky_header="<?php echo esc_attr($cerio_settings['enable-sticky-header']); ?>">
					<div class="container">
						<div class="row">
							<div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12 header-left content-header">
								<?php cerio_header_logo(); ?>
								<div class="wpbingo-menu-mobile header-menu">
									<div class="header-menu-bg">
										<?php cerio_top_menu(); ?>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 header-right">
								<div class="header-page-link">
									<?php if( isset($cerio_settings['phone']) && $cerio_settings['phone'] ) : ?>
									<div class="phone hidden-xs hidden-sm hidden-md ">
										<i class="icon-headset"></i>
										<div class="content">
											<label class="font-bold"><?php echo esc_html__("CALL US FREE ","cerio") ?></label>
											<a href="tel:<?php echo esc_html($cerio_settings['phone']); ?>"><?php echo esc_html($cerio_settings['phone']); ?></a>
										</div>
									</div>
									<?php endif; ?>
									<!-- Begin Search -->
									<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<div class="search-box hidden-lg hidden-md">
										<div class="search-toggle"><i class="icon-search"></i></div>
									</div>
									<?php } ?>
									<!-- End Search -->
									<?php if(is_active_sidebar('top-link')){ ?>
										<div class="block-top-link">
											<?php dynamic_sidebar( 'top-link' ); ?>
										</div>
									<?php } ?>								
									<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
									<div class="wishlist-box">
										<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="icon-heart"></i></a>
									</div>
									<?php } ?>
									<?php if($show_compare && class_exists( 'YITH_WOOCOMPARE' )){ ?>
									<div class="compare-box hidden-sm hidden-xs">        
										<a href="/?action=yith-woocompare-view-table&iframe=yes" class="yith-woocompare-open"><?php echo esc_html__('Compare', 'cerio')?></a>
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
				<div class="header-bottom">
					<div class="container">
						<div class="content-header-bottom">
							<?php $class_vertical = cerio_dropdown_vertical_menu(); ?>
							<div class="header-vertical-menu">
								<div class="categories-vertical-menu hidden-sm hidden-xs <?php echo esc_attr($class_vertical); ?>"
									data-textmore="<?php echo esc_html__("Other","cerio"); ?>" 
									data-textclose="<?php echo esc_html__("Close","cerio"); ?>" 
									data-max_number_1530="<?php echo esc_attr(cerio_limit_verticalmenu()->max_number_1530); ?>" 
									data-max_number_1200="<?php echo esc_attr(cerio_limit_verticalmenu()->max_number_1200); ?>" 
									data-max_number_991="<?php echo esc_attr(cerio_limit_verticalmenu()->max_number_991); ?>">
									<?php echo cerio_vertical_menu(); ?>
								</div>
							</div>
							<div class="header-search-form">
								<!-- Begin Search -->
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<?php get_template_part( 'search-form' ); ?>
								<?php } ?>
								<!-- End Search -->	
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<?php cerio_menu_mobile(); ?>
			<div class="header-desktop">
				<div class="header-normal">
					<div class='header-wrapper' data-sticky_header="<?php echo esc_attr($cerio_settings['enable-sticky-header']); ?>">
						<div class="container">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 header-left">
									<?php cerio_header_logo(); ?>
								</div>
								<div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-6 wpbingo-menu-mobile header-main">
									<div class="header-menu-bg">
										<?php cerio_top_menu(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php cerio_login_form(); ?>
	</header><!-- End #bwp-header -->