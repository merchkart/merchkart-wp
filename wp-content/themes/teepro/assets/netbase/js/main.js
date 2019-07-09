/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var container, button, menu, links, i, len;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( container ) );
} )();

/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

(function ($) {
	var screenHeight = $(document).height();
	var screenWidth = $(window).width();
    var $rtl = false;

	if (jQuery("html").attr("dir") == 'rtl'){
		$rtl = true;
	}
    var header1El = $('.site-header.teepro-header-1.fixed .middle-section-wrap');
    if(header1El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-1.fixed .middle-section-wrap')[0],
        })
    }

    var header2El = $('.site-header.teepro-header-2.fixed .middle-section-wrap');
    if(header2El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-2.fixed .middle-section-wrap')[0],
        })
    }

    var header3El = $('.site-header.teepro-header-3.fixed .middle-section-wrap');
    if(header3El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-3.fixed .middle-section-wrap')[0],
        })
    }

    var  header4El = $('.site-header.teepro-header-4.fixed .middle-section-wrap');
    if(header4El.length > 0) {
        var sticky = new Waypoint.Sticky({
            element: $('.site-header.teepro-header-4.fixed .middle-section-wrap')[0],
        })
	}

    	$('.site-header .top-section-wrap .header_top_right_menu .data_user > a').on('click', function(e) {
		$('.site-header .top-section-wrap .header_top_right_menu .data_user').toggleClass('open');
    });
	

    $('.widget_nav_menu .menu-item-has-children > a').on('click', function(e) {
        e.preventDefault();
        $(this).next('.sub-menu').first().slideToggle('fast');
    });
	
	function menuPosition() {
		if ($('#main-menu ul.sub-menu').length) {
			$('#main-menu ul.sub-menu').each(function () {
				$(this).removeAttr("style");
				var $containerWidth = $("body").outerWidth();
				var $menuwidth = $(this).outerWidth();
				var $parentleft = $(this).parent().offset().left;
				var $parentright = $(this).parent().offset().left + $(this).parent().outerWidth();
				if ($(this).parents('.sub-menu').length) {
					var $menuleft = $parentleft - $(this).outerWidth();
					var $menuright = $parentright + $(this).outerWidth();
					if ($rtl){
						if ($menuleft < 0) {
							if ($menuright > $containerWidth) {
								if ($parentleft > ($containerWidth - $parentright)) {
									$(this).css({
										'width': $parentleft + 'px',
										'left': 'auto',
										'right': '100%'
									});
								} else {
									$(this).css({
										'width': ($containerWidth - $parentright) + 'px',
										'left': '100%',
										'right': 'auto'
									});
								}
							} else {
								$(this).css({
									'left': '100%',
									'right': 'auto'
								});
							}
						} else {
							$(this).css({
								'left': '-100%'
							});
						}
					} else {
						if ($menuright > $containerWidth) {
							if ($menuleft < 0) {
								if ($parentleft > ($containerWidth - $parentright)) {
									$(this).css({
										'width': $parentleft + 'px',
										'left': 'auto',
										'right': '100%'
									});
								} else {
									$(this).css({
										'width': ($containerWidth - $parentright) + 'px',
										'left': '100%',
										'right': 'auto'
									});
								}
							} else {
								$(this).offset({
									'left': $menuleft
								});
							}
						} else {
							$(this).css({
								'left': '100%'
							});
						}
					}
				} else {
					var $menuleft = $parentright - $(this).outerWidth();
					var $menuright = $parentleft + $(this).outerWidth();
					if ($rtl){
						if ($menuleft < 0) {
							if ($menuright > $containerWidth) {
								$(this).offset({
									'left': ($containerWidth - $menuwidth) / 2
								});
							} else {
								$(this).offset({
									'left': $parentleft
								});
							}
						} else {
							$(this).offset({
								'left': $menuleft
							});
						}
					} else {
						if ($menuright > $containerWidth) {
							if ($menuleft < 0) {
								$(this).offset({
									'left': ($containerWidth - $menuwidth) / 2
								});
							} else {
								$(this).offset({
									'left': $menuleft
								});
							}
						} else {
							$(this).offset({
								'left': $parentleft
							});
						}
					}
				}
			});
		}
	}
	function menuShow() {
		$('.main-navigation .menu-main-menu-wrap').toggleClass('active');
	}
	function menuHide() {
		$('.main-navigation .menu-main-menu-wrap').removeClass('active');
        $('.main-navigation .menu-item-has-children').removeClass('open');
	}
	function menuResponsive() {
        var screenHeight = jQuery(window).height();
        var screenWidth = jQuery(window).width();
        if ($('.navigation_right .menu-sub-menu-container').length) {
            if (screenWidth < teepro.menu_resp) {
                $('.navigation_right #menu-sub-menu').appendTo('.navigation_left .menu-main-menu-container');
                $('.main-navigation').appendTo('.navigation_right');
            } else {
                $('.main-navigation').appendTo('.navigation_left');
                $('.navigation_left #menu-sub-menu').appendTo('.navigation_right .menu-sub-menu-container');
            }
        } else {
            if ($('.main-menu-section .nb-header-sub-menu').length) {
                $('.main-menu-section .nb-header-sub-menu > li').appendTo('.nb-navbar');
                $('.main-menu-section .sub-navigation').remove();
            }
        }
        if (screenWidth < teepro.menu_resp) {
            $('.site-header').removeClass('header-desktop');
            $('.site-header').addClass('header-mobile');
            $('.main-navigation').removeClass('main-desktop-navigation');
            $('.main-navigation').addClass('main-mobile-navigation');
			if ($('.admin-bar').length > 0){
				if (screenWidth > 782) {
					$('.main-navigation .menu-main-menu-wrap').css({'height': (screenHeight - 32) + 'px',})
				} else if (screenWidth > 600) {
					$('.main-navigation .menu-main-menu-wrap').css({'height': (screenHeight - 46) + 'px',})
				} else {
					$('.main-navigation .menu-main-menu-wrap').css({'height': screenHeight + 'px',})
				}
			} else {
				$('.main-navigation .menu-main-menu-wrap').css({'height': screenHeight + 'px',})
			}
        } else {
			$('.main-navigation .menu-main-menu-wrap').removeAttr('style');
            $('.site-header').removeClass('header-mobile');
            $('.site-header').addClass('header-desktop');
            $('.main-navigation').removeClass('main-mobile-navigation');
            $('.main-navigation').addClass('main-desktop-navigation');
            $('.main-navigation .menu-main-menu-wrap').removeAttr('style');
            $('.main-navigation .menu-item-has-children').removeClass('open');
            menuPosition();
        }
	}
	
	menuResponsive();
	$('.main-navigation .mobile-toggle-button').on('click', function () {
        menuShow();
    });
    $('.main-navigation .icon-cancel-circle').on('click', function () {
        menuHide();
    });
    $('.main-navigation .menu-item-has-children').on('click', function () {

        $(this).toggleClass('open');
    });
    $('.main-navigation .menu-item-has-children > *').on('click', function (e) {
        e.stopPropagation();
    });
	$(window).on('resize', function () {
        menuResponsive();
    });

	
    if($().imagesLoaded) {
        var $blog_masonry = $('.blog .masonry').imagesLoaded( function() {
            // init Isotope after all images have loaded
            $blog_masonry.isotope({
                itemSelector: '.post',
            });
        });
    }

    var d = 0;
    var $numbertype = null;

    var quantityButton = function() {
        $(".quantity-plus, .quantity-minus").mousedown(function () {
            $el = $(this).closest('.nb-quantity').find('.qty');
            $numbertype = parseInt($el.val());
            d = $(this).is(".quantity-minus") ? -1 : 1;
            $numbertype = $numbertype + d;
            if($numbertype > 0) {
                $el.val($numbertype)
            }

            $( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );

        });
    };
    quantityButton();

    if (jQuery().magnificPopup) {
        $('.featured-gallery').magnificPopup({
            delegate: 'img',
            type: 'image',
            gallery: {
                enabled: true
            },
            callbacks: {
                elementParse: function (item) {
                    item.src = item.el.attr('src');
                }
            }
        });
        $('.popup-search').magnificPopup({
            type: 'inline',
            focus: '.search-field',
            // modal: true,
            // midClick: true
            mainClass: 'mfp-search',
            callbacks: {
                beforeOpen: function () {
                    if ($(window).width() < 700) {
                        this.st.focus = false;
                    } else {
                        this.st.focus = '.search-field';
                    }
                }
            }
        });
        $(document).on('click', '.popup-modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });


    }

    if (jQuery().accordion) {
        $('.shop-main.accordion-tabs .wc-tabs').accordion({
            header: ".accordion-title-wrap",
            heightStyle: "content",
        });
    }

    $('.header-cart-wrap').on({
        mouseenter: function () {
            $(this).find('.mini-cart-section').stop().fadeIn('fast');
        },
        mouseleave: function () {
            $(this).find('.mini-cart-section').stop().fadeOut('fast');
        }
    });

    $('.header-account-wrap').on({
        mouseenter: function () {
            $(this).find('.nb-account-dropdown').stop().fadeIn('fast');
        },
        mouseleave: function () {
            $(this).find('.nb-account-dropdown').stop().fadeOut('fast');
        }
    });

    $(document.body).on('added_to_cart', function () {
        $(".cart-notice-wrap").addClass("active").delay(5000).queue(function(next){
            $(this).removeClass("active");
            next();
        });
    });

    $('.cart-notice-wrap span').on('click', function() {
        $(this).closest('.cart-notice-wrap').removeClass('active');
    });

    var $sticky = $('.sticky-wrapper.sticky-sidebar');

    if($sticky.length > 0) {
        $($sticky).stick_in_parent({
            offset_top: 45
        });

        $(window).on('resize', function() {
            $($sticky).trigger('sticky_kit:detach');
        });
    }

    if ($('#back-to-top-button').length) {
        var scrollTrigger = 500; // px
        var backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top-button').addClass('show');
                } else {
                    $('#back-to-top-button').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back-to-top-button').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
	if ($('.related .swiper-container').length){
		var slidesm = 2;
		var slidemd = 3;
		if(teepro.related_columns==2){
			slidesm = 1;
			slidemd = 2;
		}
		var related = new Swiper('.related .swiper-container', {
			slidesPerView: teepro.related_columns,
			pagination: {
				el: '.related .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				991: {
					slidesPerView: slidemd
				},
				767: {
					slidesPerView: slidesm
				},
				575: {
					slidesPerView: 1
				}
			}
		});
	}
	if ($('.upsells .swiper-container').length){
		var slidesm = 2;
		var slidemd = 3;
		if(teepro.upsells_columns==2){
			slidesm = 1;
			slidemd = 2;
		}
		var upsells = new Swiper('.upsells .swiper-container', {
			slidesPerView: teepro.upsells_columns,
			pagination: {
				el: '.upsells .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				991: {
					slidesPerView: slidemd
				},
				767: {
					slidesPerView: slidesm
				},
				575: {
					slidesPerView: 1
				}
			}
		});
	}
	if ($('.cross-sells .swiper-container').length){
		var slidemd = 3;
		var slidelg = 4;
		if(teepro.cross_sells_columns==3){
			slidemd = 2;
			slidelg = 3
		}
		var crossSells = new Swiper('.cross-sells .swiper-container', {
			slidesPerView: teepro.cross_sells_columns,
			pagination: {
				el: '.cross-sells .swiper-pagination',
				clickable: true,
		  	},
			breakpoints: {
				1199: {
					slidesPerView: slidelg,
				},
				991: {
					slidesPerView: slidemd,
				},
				767: {
					slidesPerView: 2,
				},
				575: {
					slidesPerView: 1,
				}
			}
		});
    }
    
    var swiperInit = function() {
    	if ($('.featured-gallery').length && $('.thumb-gallery').length){
    		var featuredObj = {
				navigation: {
			        nextEl: '.featured-gallery .swiper-button-next',
			        prevEl: '.featured-gallery .swiper-button-prev',
                },
                autoHeight: true
    		};

			var galleryTop = new Swiper('.featured-gallery', featuredObj);

			var thumbObj = {
				spaceBetween: 10,
				centeredSlides: true,
				slidesPerView: 4,
				touchRatio: 0.2,
                slideToClickedSlide: true
			}

			if(teepro.thumb_pos === 'left-thumb' || teepro.thumb_pos === 'inside-thumb') {
				thumbObj.direction = 'vertical'
			}

			var galleryThumbs = new Swiper('.thumb-gallery', thumbObj);
			
			galleryTop.on( 'slideChange', function () {

				var currentIndex = galleryTop.activeIndex;
			  	galleryThumbs.slideTo( currentIndex, 300, false );

			});

			galleryThumbs.on('slideChange', function () {

				var currentIndex = galleryThumbs.activeIndex;		
			  	galleryTop.slideTo( currentIndex, 300, false );

            });

            $('.single-product-wrap .featured-gallery .woocommerce-product-gallery__image').each(function(index){
                $(this).attr('data-index',index);
            })

            $( '.variations_form' ).on( 'show_variation', function ( event, variation){
                var currentindex = 0;
                $('.single-product-wrap .featured-gallery .woocommerce-product-gallery__image').each(function(){
                    var image = $(this).children('img').attr('src');
                    if(image === variation.image.src){
                        currentindex = $(this).data('index');
                    }
                })
                galleryTop.slideTo( currentindex, 300, false );
            })
            
        }
        
    };
    swiperInit();    
	
	var isMobile = false;
	var $variation_form = $('.variations_form');
	var $product_variations = $variation_form.data( 'product_variations' );
	$('body').on('click touchstart','li.swatch-item',function(){
		var current = $(this);
		var value = current.attr('option-value');
		var selector_name = current.closest('ul').attr('data-id');
		if($("select#"+selector_name).find('option[value="'+value+'"]').length > 0)
		{
			$(this).closest('ul').children('li').each(function(){
				$(this).removeClass('selected');
				$(this).removeClass('disable');
			});
			if(!$(this).hasClass('selected'))
			{
				current.addClass('selected');
				$("select#"+selector_name).val(value).change();
				$("select#"+selector_name).trigger('change');
				$variation_form.trigger( 'wc_variation_form' );
				$variation_form
					.trigger( 'woocommerce_variation_select_change' )
					.trigger( 'check_variations', [ '', false ] );
			}
		}else{
			current.addClass('disable');
		}
	});

	$variation_form.on('wc_variation_form', function() {
		$( this ).on( 'click', '.reset_variations', function( event ) {
			$(this).parents('.variations').eq(0).find('ul.swatch li').removeClass('selected');
		});
	});
	var $single_variation_wrap = $variation_form.find( '.single_variation_wrap' );
	$single_variation_wrap.on('show_variation', function(event,variation) {
		var $product = $variation_form.closest('.product');
		if(variation.image_link)
		{
			var variation_image = variation.image_link;
			$product.find('.main-image a').attr('href',variation_image);
			$product.find('.main-image a img').attr('src',variation.image_src);
			$product.find('.main-image a img').attr('srcset',variation.image_srcset);
			$product.find('.main-image a img').attr('alt',variation.image_alt);
			$product.find('.main-image a img').attr('title',variation.image_title);
			$product.find('.main-image a img').attr('sizes',variation.image_sizes);
			$product.find('.main-image img').attr('data-large',variation_image);
		}
	});

    var qv_modal    = $(document).find( '#yith-quick-view-modal' ),
        qv_overlay  = qv_modal.find( '.yith-quick-view-overlay'),
        qv_content  = qv_modal.find( '#yith-quick-view-content' ),
        qv_close    = qv_modal.find( '#yith-quick-view-close' ),
        qv_wrapper  = qv_modal.find( '.yith-wcqv-wrapper'),
        qv_wrapper_w = qv_wrapper.width(),
        qv_wrapper_h = qv_wrapper.height(),
        center_modal = function() {

            var window_w = $(window).width(),
                window_h = $(window).height(),
                width    = ( ( window_w - 60 ) > qv_wrapper_w ) ? qv_wrapper_w : ( window_w - 60 ),
                height   = ( ( window_h - 120 ) > qv_wrapper_h ) ? qv_wrapper_h : ( window_h - 120 );

            qv_wrapper.css({
                'left' : (( window_w/2 ) - ( width/2 )),
                'top' : (( window_h/2 ) - ( height/2 )),
                'width'     : width + 'px',
                'height'    : height + 'px'
            });
        };


    /*==================
     *MAIN BUTTON OPEN
     ==================*/

    $.fn.yith_quick_view = function() {

        $(document).off( 'click', '.yith-wcqv-button' ).on( 'click', '.yith-wcqv-button', function(e){
            e.preventDefault();

            var t           = $(this),
                product_id  = t.data( 'product_id' );
                
            t.block({
                message: null,
                overlayCSS  : {
                    background: '#fff url(' + teepro.loader + ') no-repeat center',
                    opacity   : 0.5,
                    cursor    : 'none'
                }
            });

            t.addClass('loading');

            setTimeout(function() {
                t.removeClass('loading');
            }, 3000);

            if( ! qv_modal.hasClass( 'loading' ) ) {
                qv_modal.addClass('loading')
            }

            // stop loader
            $(document).trigger( 'qv_loading' );
            ajax_call( t, product_id, true );
        });
    };

    /*================
     * MAIN AJAX CALL
     ================*/

    var ajax_call = function( t, product_id, is_blocked ) {

        $.ajax({
            url: teepro.ajaxurl,
            data: {
                action: 'yith_load_product_quick_view',
                product_id: product_id
            },
            dataType: 'html',
            type: 'POST',
            success: function (data) {

                qv_content.html(data);

                // quantity fields for WC 2.2
                if (teepro.is2_2) {
                    qv_content.find('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<input type="button" value="+" class="plus" />').prepend('<input type="button" value="-" class="minus" />');
                }

                // Variation Form
                var form_variation = qv_content.find('.variations_form');

                form_variation.wc_variation_form();
                form_variation.trigger('check_variations');

                if (typeof $.fn.yith_wccl !== 'undefined') {
                    form_variation.yith_wccl();
                }

                // Init prettyPhoto
                if (typeof $.fn.prettyPhoto !== 'undefined') {
                    qv_content.find("a[data-rel^='prettyPhoto'], a.zoom").prettyPhoto({
                        hook: 'data-rel',
                        social_tools: false,
                        theme: 'pp_woocommerce',
                        horizontal_padding: 20,
                        opacity: 0.8,
                        deeplinking: false
                    });
                }

                if (!qv_modal.hasClass('open')) {
                    qv_modal.removeClass('loading').addClass('open');
                    if (is_blocked)
                        t.unblock();
                }

                // stop loader
                $(document).trigger('qv_loader_stop');
                swiperInit();
                quantityButton();
            }
        });
    };

    /*===================
     * CLOSE QUICK VIEW
     ===================*/

    var close_modal_qv = function() {

        // Close box by click overlay
        qv_overlay.on( 'click', function(e){
            close_qv();
        });
        // Close box with esc key
        $(document).keyup(function(e){
            if( e.keyCode === 27 )
                close_qv();
        });
        // Close box by click close button
        qv_close.on( 'click', function(e) {
            e.preventDefault();
            close_qv();
        });

        var close_qv = function() {
            qv_modal.removeClass('open').removeClass('loading');

            setTimeout(function () {
                qv_content.html('');
            }, 1000);
        }
    };

    close_modal_qv();


    center_modal();
    $( window ).on( 'resize', center_modal );

    // START
    $.fn.yith_quick_view();

    $( document ).on( 'yith_infs_adding_elem yith-wcan-ajax-filtered', function(){
        // RESTART
        $.fn.yith_quick_view();
    });

    $(document).on('click', '.add_to_wishlist', function() {
        $(this).find('.icon-heart').css('visibility', 'hidden');
    });

    $(document).on('click', '.compare.button', function() {
        $(this).find('.icon-compare').css('visibility', 'hidden');
    });

    $('.widget.shop-sidebar ul.menu .menu-item-has-children.current-menu-parent').addClass('dot');

    $('.widget.shop-sidebar ul.menu .menu-item-has-children > a').click(function(){
        $(this).parent().toggleClass('dot');
    })
    
    jQuery(window).load(function() {
        
        jQuery(".loading").fadeOut();
        
        var $window = jQuery(window).innerHeight();
        var $html = jQuery('html').innerHeight();
        if($html < $window){
            $('#colophon').css({position:'fixed',width:'100%',bottom:'0',left:'0'})
        }

        jQuery('#secondary #cat-drop-stack').each(function(){
            jQuery(this).parent('.widget').addClass('background');
        })

        jQuery('.shop-main .woof .woof_redraw_zone .woof_container > .woof_container_inner').each(function(){
            var height = jQuery(this).innerHeight();
            jQuery(this).css({height:height,overflowX:'hidden'});
        })

        jQuery('.shop-main .woof_redraw_zone').isotope({
            itemSelector: '.woof_container,.woof_submit_search_form_container',
        })
    })

    $('.woocommerce-cart tbody tr.cart_item td[data-title],.woocommerce-checkout tbody tr.cart_item td[data-title]').each(function(){
        var attr = $(this).attr('data-title');
        $(this).prepend("<span class='title'>"+ attr +"</span>");
    })

    //open popup size guide

    var size_guide_popup = $( '.teepro-open-popup' );

    size_guide_popup.magnificPopup({
        type: 'inline',      
        removalDelay: 500,
        mainClass: 'mfp-fade'
    });

})(jQuery);