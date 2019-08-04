jQuery(window).trigger('resize').trigger('scroll');
// ---------------------------------------------- //
// Global Read-Only Variables (DO NOT CHANGE!)
// ---------------------------------------------- //
var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);

var wow_enable = false,
    fullwidth = 1200,
    iOS = check_iOS(),
    _event = (iOS) ? 'click, mousemove' : 'click',
    globalTimeout = null,
    load_flag = false,
    page_load = 1,
    shop_load = false,
    archive_page = 1,
    infinitiAjax = false,
    _single_variations = [],
    _lightbox_variations = [];

/* =========== Document ready ==================== */
jQuery(document).ready(function($){
"use strict";

var _nasa_in_mobile = $('input[name="nasa_mobile_layout"]').length ? true : false;

$(window).stellar();

// Init Wow effect
if($('input[name="nasa-enable-wow"]').length === 1 && $('input[name="nasa-enable-wow"]').val() === '1') {
    wow_enable = true;
    $('body').addClass('nasa-enable-wow');
    new WOW({mobile: false}).init();
}

$('body #nasa-before-load').fadeOut(1000);
$('body').addClass('nasa-body-loaded');

/**
 * Delay Click wishlist
 */
if($('.nasa_yith_wishlist_premium-wrap').length && $('.nasa-wishlist-count.wishlist-number').length) {
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            $('.nasa_yith_wishlist_premium-wrap').each(function () {
                var _this = $(this);
                if(!$(_this).parents('.wishlist_sidebar').length) {
                    var _countWishlist = $(_this).find('.wishlist_table tbody tr .wishlist-empty').length ? '0' : $(_this).find('.wishlist_table tbody tr').length;
                    $('.nasa-wishlist-count.wishlist-number .nasa-sl').html(_countWishlist);

                    if(_countWishlist === '0') {
                        $('.nasa-wishlist-count.wishlist-number').addClass('nasa-product-empty');
                    }
                }
            });
        }, 300);
    }).ajaxError(function() {
        
    });
}
var _urlAjaxStaticContent = null;
if(
    typeof wc_add_to_cart_params !== 'undefined' &&
    typeof wc_add_to_cart_params.wc_ajax_url !== 'undefined'
) {
    _urlAjaxStaticContent = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_static_content');
}

if(_urlAjaxStaticContent) {

    var _data_static_content = {};
    if($('#nasa-view-compare-product').length === 1) {
        _data_static_content.compare = true;
    }
    
    if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
        $('.nasa-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data_static_content[_key] = _val;
        });
    }

    $.ajax({
        url: _urlAjaxStaticContent,
        type: 'post',
        data: _data_static_content,
        cache: false,
        success: function(result){
            if(typeof result !== 'undefined' && result.success === '1') {
                $.each(result.content, function (key, value) {
                    if($(key).length > 0) {
                        $(key).replaceWith(value);
                        
                        if(key === '#nasa-wishlist-sidebar-content') {
                            initWishlistIcons($);
                        }

                        if(key === '#nasa-compare-sidebar-content') {
                            initCompareIcons($);
                        }
                    }
                });
            }
        }
    });
}

/**
 * Check wpadminbar
 */
if($('#wpadminbar').length > 0) {
    $("head").append('<style type="text/css" media="screen">#wpadminbar {position: fixed !important;}</style>');
    var height_adminbar = $('#wpadminbar').height();
    $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .col-sidebar, .nasa-top-cat-filter-wrap-mobile').css({'top' : height_adminbar});
    
    $(window).resize(function() {
        height_adminbar = $('#wpadminbar').height();
        $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .col-sidebar, .nasa-top-cat-filter-wrap-mobile').css({'top' : height_adminbar});
    });
}

// Fix vertical mega menu
if($('.vertical-menu-wrapper').length > 0){
    $('.vertical-menu-wrapper').attr('data-over', '0');

    var width_default = 200;
    
    $('.vertical-menu-container').each(function() {
        var _this = $(this);
        var _h_vertical = $(_this).height();
        $(_this).find('.nasa-megamenu >.nav-dropdown').each(function(){
            // $(this).css({'width': 0});
            $(this).find('>.sub-menu').css({'min-height': _h_vertical});
        });
    });

    $('body').on('mousemove', '.vertical-menu-container .nasa-megamenu', function(){
        var _wrap = $(this).parents('.vertical-menu-wrapper');
        $(_wrap).find('.nasa-megamenu').removeClass('nasa-curent-hover');
        $(_wrap).addClass('nasa-curent-hover');

        var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');
        var _w_mega, _w_mega_df, _w_ss;
        var total_w = $(_row).length ? $(_row).width() : 900;
        
        $(_wrap).find('.nasa-megamenu').each(function(){
            var _this = $(this);
            
            var current_w = $(_this).outerWidth();
            _w_mega = _w_mega_df = total_w - current_w;
        
            if($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')){
                _w_mega = _w_mega - 20;
            } else {
                if($(_this).hasClass('cols-2')){
                    _w_mega = _w_mega / 5 * 2 + 50;
                    _w_ss = width_default * 2;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if($(_this).hasClass('cols-3')){
                    _w_mega = _w_mega / 5 * 3 + 50;
                    _w_ss = width_default * 3;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if($(_this).hasClass('cols-4')){
                    _w_mega = _w_mega / 5 * 4 + 50;
                    _w_ss = width_default * 4;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
            }
            
            $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        });
    });

    $('body').on('mouseover', '.vertical-menu-wrapper .menu-item-has-children.default-menu', function(){
        var _wrap = $(this).parents('.vertical-menu-wrapper');
        $(this).find('> .nav-dropdown > .sub-menu').css({'width': width_default});
        
        var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');

        var _w_mega, _w_mega_df, _w_ss;
        var total_w = $(_row).length ? $(_row).width() : 900;
        
        $(_wrap).find('.nasa-megamenu').each(function(){
            var _this = $(this);
            
            var current_w = $(_this).outerWidth();
            _w_mega = _w_mega_df = total_w - current_w;
            
            if($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')){
                _w_mega = _w_mega - 20;
            } else {
                if($(_this).hasClass('cols-2')){
                    _w_mega = _w_mega / 5 * 2 + 50;
                    _w_ss = width_default * 2;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if($(_this).hasClass('cols-3')){
                    _w_mega = _w_mega / 5 * 3 + 50;
                    _w_ss = width_default * 3;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if($(_this).hasClass('cols-4')){
                    _w_mega = _w_mega / 5 * 4 + 50;
                    _w_ss = width_default * 4;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
            }
            
            $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        });
    });
    
    $('body').on('mouseleave', '.vertical-menu-wrapper', function(){
        $(this).attr('data-over', '0');
    });
}

$('body').on('click', '.nasa-mobile-menu_toggle', function(){
    initMainMenuVertical($);
    
    if($('#mobile-navigation').length) {
        if($('#mobile-navigation').attr('data-show') !== '1') {
            if ($('#nasa-menu-sidebar-content').hasClass('nasa-dark')) {
                $('.black-window').addClass('nasa-transparent');
            }
            
            $('.black-window').show().addClass('desk-window');
            
            if ($('#nasa-menu-sidebar-content').length && !$('#nasa-menu-sidebar-content').hasClass('nasa-active')) {
                $('#nasa-menu-sidebar-content').addClass('nasa-active');
            }
            
            $('#mobile-navigation').attr('data-show', '1');
        } else {
            $('.black-window').trigger('click');
        }
    }
});

// Accordion menu
$('body').on('click', '.nasa-menu-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    var ths = $(this).parent();
    var cha = $(ths).parent();
    if(!$(ths).hasClass('active')) {
        var c = $(cha).children('li.active');
        $(c).removeClass('active').children('.nav-dropdown-mobile').css({height:'auto'}).slideUp(300);
        $(ths).children('.nav-dropdown-mobile').slideDown(300).parent().addClass('active');
    } else {
        $(ths).find('>.nav-dropdown-mobile').slideUp(300).parent().removeClass('active');
    }
    return false;
});

/**
 * Accordion Element
 */
if($('.nasa-accordion .li_accordion > a.accordion').length > 0){
    $('body').on('click', '.nasa-accordion .li_accordion > a.accordion', function() {
        var _show = $(this).attr('data-class_show'); // 'pe-7s-plus'
        var _hide = $(this).attr('data-class_hide'); // 'pe-7s-less'
        var ths = $(this).parent();
        var cha = $(ths).parent();
        if(!$(ths).hasClass('active')) {
            $(cha).removeClass('current-cat-parent').removeClass('current-cat');
            var c = $(cha).children('li.active');
            $(c).removeClass('active').children('.children').slideUp(300);
            $(ths).addClass('active').children('.children').slideDown(300);
            $(c).find('>a.accordion>span').removeClass(_hide).addClass(_show);
            $(this).find('span').removeClass(_show).addClass(_hide);
        } else {
            $(ths).removeClass('active').children('.children').slideUp(300);
            $(this).find('span').removeClass(_hide).addClass(_show);
        }
        return false;
    });
}

/*
 * Quick view
 */
var setMaxHeightQVPU;
$('body').on('click', '.quick-view', function(e){
    $.magnificPopup.close();
    
    var _urlAjax = null;
    if(
        typeof wc_add_to_cart_params !== 'undefined' &&
        typeof wc_add_to_cart_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quick_view');
    }
    
    if(_urlAjax) {
        var _this = $(this);

        var _product_type = $(_this).attr('data-product_type');

        if($(_this).parents('.product-item').length) {
            if(_product_type !== 'woosb') {
                var _product_item = $(_this).parents('.product-item');
                if(!$(_product_item).hasClass('nasa-quickview-special')) {
                    $(_product_item).find('.product-inner').css({opacity: 0.3});
                    $(_product_item).find('.product-inner').after('<div class="nasa-loader"></div>');
                } else {
                    $(_product_item).append('<div class="nasa-loader" style="top:50%"></div>');
                }
            }
        }

        if($(_this).parents('.item-product-widget').length) {
            if(_product_type !== 'woosb') {
                $(_this).parents('.item-product-widget').append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
            }
        }

        if(_product_type === 'woosb' && typeof $(_this).attr('data-href') !== 'undefined') {
            window.location.href = $(_this).attr('data-href');
        } else {
            var _wrap = $(_this).parents('.product-item'),
                product_item = $(_wrap).find('.product-inner'),
                product_img = $(product_item).find('.product-img'),
                product_id = $(_this).attr('data-prod'),
                _wishlist = ($(_this).attr('data-from_wishlist') === '1') ? '1' : '0';

            if($(_wrap).length <= 0) {
                _wrap = $(_this).parents('.item-product-widget');
            }

            if($(_wrap).length <= 0) {
                _wrap = $(_this).parents('.wishlist-item-warper');
            }

            var _data = {
                product: product_id,
                nasa_wishlist: _wishlist
            };

            if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
                $('.nasa-value-gets').find('input').each(function() {
                    var _key = $(this).attr('name');
                    var _val = $(this).val();
                    _data[_key] = _val;
                });
            }

            var sidebar_holder = $('#nasa-quickview-sidebar').length === 1 ? true : false;
            _data.quickview = $('#nasa-quickview-sidebar').length === 1 ? 'sidebar' : 'popup';

            $.ajax({
                url : _urlAjax,
                type: 'post',
                dataType: 'json',
                data: _data,
                cache: false,
                beforeSend: function(){
                    if(sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html(
                            '<div class="nasa-loader"></div>'
                        );
                        $('.black-window').fadeIn(200).addClass('desk-window');
                        $('#nasa-viewed-sidebar').removeClass('nasa-active');
                        
                        if ($('#nasa-quickview-sidebar').length && !$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                            $('#nasa-quickview-sidebar').addClass('nasa-active');
                        }
                    }

                    if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                        $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                    }
                    
                    if (typeof setMaxHeightQVPU !== 'undefined') {
                        clearInterval(setMaxHeightQVPU);
                    }
                },
                success: function(response){
                    // Sidebar hoder
                    if(sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox hidden-tag">' + response.content + '</div>');
                        setTimeout(function() {
                            $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').fadeIn(1000);
                        }, 600);
                    }

                    // Popup classical
                    else {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-zoom-in',
                            items: {
                                src: '<div class="product-lightbox">' + response.content + '</div>',
                                type: 'inline'
                            },
                            tClose: $('input[name="nasa-close-string"]').val(),
                            callbacks: {
                                beforeClose: function() {
                                    this.st.removalDelay = 350;
                                },
                                afterClose: function() {
                                    var buttons = $(_this).parents('.product-interactions');
                                    $(buttons).addClass('hidden-tag');
                                    
                                    setTimeout(function(){
                                        $(buttons).removeClass('hidden-tag');
                                    }, 100);
                                    
                                    if (typeof setMaxHeightQVPU !== 'undefined') {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }
                            }
                        });

                        $('.black-window').trigger('click');
                    }

                    _lightbox_variations[0] = {
                        'quickview_gallery': $('.product-lightbox').find('.nasa-product-gallery-lightbox').html()
                    };

                    if($(_this).hasClass('nasa-view-from-wishlist')){
                        $('.wishlist-item').animate({opacity: 1}, 500);
                        if(!sidebar_holder) {
                            $('.wishlist-close a').trigger('click');
                        }
                    }

                    $(_wrap).find('.nasa-loader, .please-wait, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                    if($(product_img).length > 0 && $(product_item).length > 0) {
                        $(product_img).removeAttr('style');
                        $(product_item).animate({opacity: 1}, 500);
                    }

                    var formLightBox = $('.product-lightbox').find('.variations_form');
                    if($(formLightBox).find('.single_variation_wrap').length === 1) {
                        $(formLightBox).find('.single_variation_wrap').hide();
                        $(formLightBox).wc_variation_form_lightbox(response.mess_unavailable);
                        $(formLightBox).find('select').change();
                        if($(formLightBox).find('.variations select option[selected="selected"]').length) {
                            $(formLightBox).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                        }
                        if($('input[name="nasa_attr_ux"]').length === 1 && $('input[name="nasa_attr_ux"]').val() === '1') {
                            $(formLightBox).nasa_attr_ux_variation_form();
                        }
                    }

                    setTimeout(function() {
                        loadLightboxCarousel($);
                        loadTipTop($);
                    }, 600);

                    setTimeout(function() {
                        $(window).resize();
                    }, 800);

                    if(!sidebar_holder) {
                        setMaxHeightQVPU = setInterval(function() {
                            var _h_l = $('.product-lightbox .product-img').outerHeight();
                            
                            $('.product-lightbox .product-quickview-info').css({
                                'max-height': _h_l,
                                'overflow-y': 'auto'
                            });
                            
                            if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                            }
                            
                            if (_nasa_in_mobile) {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }, 1000);
                    }

                    // loadingCarousel($);
                    if ($('.nasa-quickview-product-deal-countdown').length) {
                        loadCountDown($);
                    }
                }
            });
        }
    }
    
    e.preventDefault();
});

$(".gallery a[href$='.jpg'], .gallery a[href$='.jpeg'], .featured-item a[href$='.jpeg'], .featured-item a[href$='.gif'], .featured-item a[href$='.jpg'], .page-featured-item .slider > a, .page-featured-item .page-inner a > img, .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").parent().magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: '<div class="please-wait dark"><span></span><span></span><span></span></div>',
    tClose: $('input[name="nasa-close-string"]').val(),
    mainClass: 'my-mfp-zoom-in',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
});

var _loadingBeforeResize = setTimeout(function() {
    /**
     * Fix height for full width to side
     */
    loadHeightFullWidthToSide($);

    /**
     * Main menu Reponsive
     */
    loadResponsiveMainMenu($);
}, 100);

var _load_equal_height_columns = setTimeout(function() {
    /**
     * Equal height columns
     */
    row_equal_height_columns($);
}, 100);

var _load_equal_height_columns_scroll;

// **********************************************************************// 
// ! Fixed header
// **********************************************************************//
var headerHeight = $('.header-wrapper').height() + 50;
$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();
    
    if($('input[name="nasa_fixed_single_add_to_cart"]').length) {
        if($('.nasa-product-details-page .single_add_to_cart_button').length) {
            var addToCart = $('.nasa-product-details-page .product-details') || $('.nasa-product-details-page .single_add_to_cart_button');
            if ($(addToCart).length) {
                var addToCartOffset = $(addToCart).offset();

                if(scrollTop >= addToCartOffset.top) {
                    if(!$('body').hasClass('has-nasa-cart-fixed')) {
                        $('body').addClass('has-nasa-cart-fixed');
                    }
                } else {
                    $('body').removeClass('has-nasa-cart-fixed');
                }
            }
        }
    }
    
    if(
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').length > 0 &&
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').length === 1
    ) {
        var infinitiOffset = $('#nasa-wrap-archive-loadmore').offset();
        
        if(!infinitiAjax) {
            if(scrollTop + $(window).height() >= infinitiOffset.top) {
                infinitiAjax = true;
                $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').trigger('click');
            }
        }
    }
    
    var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    if ($('body').find('.nasa-header-sticky').length > 0) {
        var fixedHeader = $('.sticky-wrapper');
        var fix_top = 0;
        if($('#wpadminbar').length > 0) {
            fix_top = $('#wpadminbar').height();
        }
        var _heightFixed = fixedHeader.outerHeight();
        
        if(scrollTop > headerHeight){
            if(!fixedHeader.hasClass('fixed-already')) {
                fixedHeader.stop().addClass('fixed-already');
                $('.nasa-header-sticky').css({'margin-bottom': _heightFixed});
                if(!fixedHeader.hasClass('fixed-trasition')) {
                    setTimeout(function() {
                        fixedHeader.css({top: fix_top});
                        fixedHeader.addClass('fixed-trasition');
                    }, 10);
                }
            }
        } else {
            if(fixedHeader.hasClass('fixed-already')) {
                fixedHeader.stop().removeClass('fixed-already');
                fixedHeader.removeAttr('style');
                $('.nasa-header-sticky').removeAttr('style');
            }
            
            if(fixedHeader.hasClass('fixed-trasition')) {
                fixedHeader.stop().removeClass('fixed-trasition');
            }
            
            _heightFixed = fixedHeader.outerHeight();
        }
    }
    
    if($('.nasa-nav-extra-warp').length > 0) {
        if(scrollTop > headerHeight){
            if(!$('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').addClass('nasa-show');
            }
        } else {
            if($('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').removeClass('nasa-show');
            }
        }
    }
    
    if(scrollTop <= headerHeight && $('#mobile-navigation').attr('data-show') === '1' && !_inMobile){
        $('.black-window').trigger('click');
    }
    
    /* Back to Top */
    if ($('#nasa-back-to-top').length > 0) {
        if (typeof intervalBTT !== 'undefined' && intervalBTT) {
            clearInterval(intervalBTT);
        }
        var intervalBTT = setInterval(function(){
            var _height_win = $(window).height() / 2;
            if(scrollTop > _height_win){
                var _animate = $('#nasa-back-to-top').attr('data-wow');
                $('#nasa-back-to-top').show().css({'visibility': 'visible', 'animation-name': _animate}).removeClass('animated').addClass('animated');
            } else {
                $('#nasa-back-to-top').hide();
            }
            
            clearInterval(intervalBTT);
        }, 100);
    }
    
    /**
     * Equal height columns
     */
    clearTimeout(_load_equal_height_columns_scroll);
    _load_equal_height_columns_scroll = setTimeout(function() {
        row_equal_height_columns($, true);
    }, 100);
});

/**
 * Back to Top
 */
$('body').on('click', '#nasa-back-to-top', function() {
    $('html, body').animate({scrollTop: 0}, 800);
});

// **********************************************************************// 
// ! Header slider overlap for Transparent
// **********************************************************************//
$(window).resize(function() {
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;

    // Fix Sidebar Mobile, Search Mobile display switch to desktop
    var desk = $('.black-window').hasClass('desk-window');
    if(!_mobileView && !desk) {
        if($('.col-sidebar').length){
            $('.col-sidebar').removeClass('nasa-active');
        }
        if($('.warpper-mobile-search').length > 0 && !$('.warpper-mobile-search').hasClass('show-in-desk')){
            $('.warpper-mobile-search').removeClass('nasa-active');
        }
        if($('.black-window').length > 0){
            $('.black-window').hide();
        }
    }
    
    /**
     * Active Filter cat top
     */
    initTopCategoriesFilter($);

    /* Fix width menu vertical */
    if($('.wide-nav .nasa-vertical-header').length > 0) {
        var _v_width = $('.wide-nav .nasa-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    }
    
    var _height_adminbar = $('#wpadminbar').length > 0 ? $('#wpadminbar').height() : 0;
    if(_height_adminbar > 0 && $('#mobile-navigation').length === 1) {
        $('#nasa-menu-sidebar-content').css({'top': _height_adminbar});
        
        if($('#mobile-navigation').attr('data-show') === '1' && !_mobileView) {
            var _scrollTop = $(window).scrollTop();
            var _headerHeight = $('.header-wrapper').height() + 50;
            if(_scrollTop <= _headerHeight){
                $('.black-window').trigger('click');
            }
        }
    }
    
    /* Fix scroll single product */
    loadScrollSingleProduct($);
    
    clearTimeout(_loadingBeforeResize);
    _loadingBeforeResize = setTimeout(function() {
        /**
         * Fix height for full width to side
         */
        loadHeightFullWidthToSide($);
        
        /**
         * Main menu Reponsive
         */
        loadResponsiveMainMenu($);
    }, 1100);
    
    clearTimeout(_load_equal_height_columns);
    _load_equal_height_columns = setTimeout(function() {
        /**
         * Equal height columns
         */
        row_equal_height_columns($, false);
    }, 1150);
    
    clearTimeout(_positionMobileMenu);
    _positionMobileMenu = setTimeout(function() {
        positionMenuMobile($);
    }, 100);
});

var _positionMobileMenu = setTimeout(function() {
    positionMenuMobile($);
}, 100);

/* Fix width menu vertical =============================================== */
if($('.wide-nav .nasa-vertical-header').length > 0){
    var _v_width = $('.wide-nav .nasa-vertical-header').width();
    _v_width = _v_width < 280 ? 280: _v_width;
    $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    if($('.wide-nav .vertical-menu-container').hasClass('nasa-allways-show')) {
        $('.wide-nav .vertical-menu-container').addClass('nasa-active');
    }
}

/***** Progress Bar *****/
if ($('.progress-bar').length > 0) {
    $('.progress-bar').each(function(){
        var meter = $(this).find('.bar-meter');
        var number = $(this).find('.bar-number');
        var _per = $(meter).attr('data-meter');
        $(this).waypoint(function() {
            $(meter).css({'width': 0, 'max-width': _per + '%'});
            $(meter).delay(50).animate({width : _per + '%'}, 400);
            $(number).delay(400).show();
            setTimeout(function(){
                $(number).css('opacity', 1);
            }, 400);
        },
        {
            offset : _per + '%',
            triggerOnce : true
        });
    });
}

if($('.nasa-accordions-content .nasa-accordion-title a').length > 0){
    $('.nasa-accordions-content').each(function() {
        if($(this).hasClass('nasa-accodion-first-hide')) {
            $(this).find('.nasa-accordion.first').removeClass('active');
            $(this).find('.nasa-panel.first').removeClass('active');
            $(this).removeClass('nasa-accodion-first-hide');
        } else {
            $(this).find('.nasa-panel.first.active').slideDown(200);
        }
    });
    
    $('body').on(_event, '.nasa-accordions-content .nasa-accordion-title a', function() {
        var warp = $(this).parents('.nasa-accordions-content');
        var _global = $(warp).hasClass('nasa-no-global') ? true : false;
        $(warp).removeClass('nasa-accodion-first-show');
        var _id = $(this).attr('data-id');
        if(!$(this).hasClass('active')){
            if (!_global) {
                $(warp).find('.nasa-accordion-title a').removeClass('active');
                $(warp).find('.nasa-panel.active').removeClass('active').slideUp(200);
            }
            $('#nasa-secion-' + _id).addClass('active').slideDown(200);
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
            $('#nasa-secion-' + _id).removeClass('active').slideUp(200);
        }
        return false;
    });
}

// Tabable
if($('.nasa-tabs-content ul.nasa-tabs li a').length > 0){
    $('body').on(_event, '.nasa-tabs-content ul.nasa-tabs li a', function(e){
        e.preventDefault();
        var _this = $(this);
        if(!$(_this).parent().hasClass('active')){
            var _root = $(_this).parents('.nasa-tabs-content');
            var currentTab = $(_this).attr('data-id');
            var show = $(_this).parent().attr('data-show');
            $(_root).find('ul li').removeClass('active');
            $(_this).parent().addClass('active');
            $(_root).find('div.nasa-panel').removeClass('active').hide();
            $(currentTab).addClass('active').show();
            if($(currentTab).parents('.vc_tta-panel').length) {
                $(currentTab).parents('.nasa-panels').find('.vc_tta-panel').hide();
                $(currentTab).parents('.vc_tta-panel').show();
            }
            
            if($(_root).hasClass('nasa-slide-style')) {
                nasa_tab_slide_style($, _root, 500);
            }
            
            var nasa_slider = $(currentTab).find('.nasa-slider');
            var nasa_deal = $(currentTab).find('.nasa-row-deal-3');

            if(wow_enable){
                if($(currentTab).find('.product-item').length > 0 || $(currentTab).find('.item-product-widget').length > 0){
                    $(currentTab).css({'opacity': '0.9'}).append('<div class="nasa-loader"></div>');
                    $(_root).find('.wow').css({
                        'visibility': 'hidden',
                        'animation-name': 'none',
                        'opacity': '0'
                    });
                    
                    if ($(_root).find('.wow').length <= 0) {
                        $(currentTab).css({'opacity': '1'});
                        $(currentTab).find('.nasa-loader, .please-wait').remove();
                    }

                    if($(nasa_slider).length < 1){
                        $(currentTab).find('.wow').removeClass('animated').css({'animation-name': 'fadeInUp'});
                        $(currentTab).find('.wow').each(function(){
                            var _wow = $(this);
                            var _delay = parseInt($(_wow).attr('data-wow-delay'));

                            setTimeout(function(){
                                $(_wow).css({'visibility': 'visible'});
                                $(_wow).animate({'opacity': 1}, _delay);
                                if($(currentTab).find('.nasa-loader, .please-wait').length > 0){
                                    $(currentTab).css({'opacity': 1});
                                    $(currentTab).find('.nasa-loader, .please-wait').remove();
                                }
                            }, _delay);
                        });
                    } else {
                        if (!$(currentTab).hasClass('first-inited') && !$(currentTab).hasClass('first')) {
                            $(nasa_slider).trigger('destroy.owl.carousel');
                            loadingCarousel($);
                            
                            $(currentTab).addClass('first-inited');
                        }
                        
                        $(currentTab).find('.owl-stage').css({'opacity': '0'});
                        setTimeout(function(){
                            $(currentTab).find('.owl-stage').css({'opacity': '1'});
                        }, 500);

                        $(currentTab).find('.wow').each(function(){
                            var _wow = $(this);
                            $(_wow).css({
                                'animation-name': 'fadeInUp',
                                'visibility': 'visible',
                                'opacity': 0
                            });
                            var _delay = parseInt($(_wow).attr('data-wow-delay'));
                            _delay += (show === '0') ? 500 : 0;
                            setTimeout(function(){
                                $(_wow).animate({'opacity': 1}, _delay);
                                if($(currentTab).find('.nasa-loader, .please-wait').length > 0){
                                    $(currentTab).css({'opacity': 1});
                                    $(currentTab).find('.nasa-loader, .please-wait').remove();
                                }
                            }, _delay);
                        });
                    }
                }
            } else {
                if ($(nasa_slider).length > 0) {
                    if (!$(currentTab).hasClass('first-inited') && !$(currentTab).hasClass('first')) {
                        $(nasa_slider).trigger('destroy.owl.carousel');
                        loadingCarousel($);

                        $(currentTab).addClass('first-inited');
                    }
                    
                    $(currentTab).css({'opacity': '0.9'}).append('<div class="nasa-loader"></div>');
                    $(currentTab).find('.owl-stage').css({'opacity': '0'});
                    setTimeout(function(){
                        $(currentTab).find('.owl-stage').css({'opacity': '1'});
                        if($(currentTab).find('.nasa-loader, .please-wait').length > 0){
                            $(currentTab).css({'opacity': 1});
                            $(currentTab).find('.nasa-loader, .please-wait').remove();
                        }
                    }, 300);
                } else {
                    $(currentTab).css({'opacity': '1'});
                    $(currentTab).find('.nasa-loader, .please-wait').remove();
                }
            }
            
            if ($(nasa_deal).length > 0) {
                loadHeightDeal($);
            }
        }

        return false;
    });
    
    if ($('.nasa-tabs-content.nasa-slide-style').length > 0) {
        $('.nasa-slide-style').each(function (){
            var _this = $(this);
            nasa_tab_slide_style($, _this, 500);
        });
        
        $(window).resize(function() {
            $('.nasa-slide-style').each(function (){
                var _this = $(this);
                nasa_tab_slide_style($, _this, 50);
            });
        });
    }
}

if(typeof nasa_countdown_l10n !== 'undefined' && (typeof nasa_countdown_init === 'undefined' || nasa_countdown_init === '0')) {
    var nasa_countdown_init = '1';
    // Countdown
    $.countdown.regionalOptions[''] = {
        labels: [
            nasa_countdown_l10n.years,
            nasa_countdown_l10n.months,
            nasa_countdown_l10n.weeks,
            nasa_countdown_l10n.days,
            nasa_countdown_l10n.hours,
            nasa_countdown_l10n.minutes,
            nasa_countdown_l10n.seconds
        ],
        labels1: [
            nasa_countdown_l10n.year,
            nasa_countdown_l10n.month,
            nasa_countdown_l10n.week,
            nasa_countdown_l10n.day,
            nasa_countdown_l10n.hour,
            nasa_countdown_l10n.minute,
            nasa_countdown_l10n.second
        ],
        compactLabels: ['y', 'm', 'w', 'd'],
        whichLabels: null,
        digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        timeSeparator: ':',
        isRTL: true
    };

    $.countdown.setDefaults($.countdown.regionalOptions['']);
    loadCountDown($);
}

if(! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
    $('.yith-wcwl-wishlistexistsbrowse.show').each(function(){
        var tip_message = $(this).find('a').text();
        $(this).find('a').attr('data-tip', tip_message).addClass('tip-top');
    });

    loadTipTop($);
}

if($('.nasa_banner .center').length > 0){
    $('.nasa_banner .center').vAlign();
    $(window).resize(function() {
        $('.nasa_banner .center').vAlign();
    });
}

if($('.col_hover_focus').length > 0){
    $('body').on('hover', '.col_hover_focus', function(){
        $(this).parent().find('.columns > *').css('opacity','0.5');
    }, function() {
        $(this).parent().find('.columns > *').css('opacity','1');
    });
}

if($('.add-to-cart-grid.product_type_simple').length > 0){
    $('body').on('click', '.add-to-cart-grid.product_type_simple', function(){
        $('.mini-cart').addClass('active cart-active');
        $('.mini-cart').hover(function(){$('.cart-active').removeClass('cart-active');});
        setTimeout(function(){$('.cart-active').removeClass('active');}, 5000);
    });
}

$('.row ~ br, .columns ~ br, .columns ~ p').remove(); 
$('select.ninja-forms-field, select.addon-select').wrap('<div class="custom select-wrapper"/>');

/* Carousel */
loadingCarousel($);
loadingSCCarosel($);

/*********************************************************************
// ! Promo popup
/ *******************************************************************/
var et_popup_closed = $.cookie('nasatheme_popup_closed');

if(et_popup_closed !== 'do-not-show' && $('.nasa-popup').length > 0 && $('body').hasClass('open-popup')) {
    var _delayremoVal = parseInt($('.nasa-popup').attr('data-delay'));
    _delayremoVal = !_delayremoVal ? 300 : _delayremoVal * 1000;
    var _disableMobile = $('.nasa-popup').attr('data-disable_mobile') === 'true' ? true : false;
    
    $('.nasa-popup').magnificPopup({
        items: {
            src: '#nasa-popup',
            type: 'inline'
        },
        tClose: $('input[name="nasa-close-string"]').val(),
        removalDelay: 300, //delay removal by X to allow out-animation
        fixedContentPos: true,
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = 'my-mfp-slide-bottom';
            },
            beforeClose: function() {
                var showagain = $('#showagain:checked').val();
                if(showagain === 'do-not-show'){
                    $.cookie('nasatheme_popup_closed', 'do-not-show', {expires: 7, path: '/'});
                }
            }
        },
        disableOn: function() {
            if(_disableMobile && $(window).width() <= 640) {
                return false;
            }
            
            return true;
        }
        // (optionally) other options
    });
    
    setTimeout(function() {
        $('.nasa-popup').magnificPopup('open');
    }, _delayremoVal);
    
    $('body').on('click', '#nasa-popup input[type="submit"]', function() {
        $(this).ajaxSuccess(function(event, request, settings) {
            if(typeof request === 'object' && request.responseJSON.status === 'mail_sent') {
                $('body').append('<div id="nasa-newsletter-alert" class="hidden-tag"><div class="wpcf7-response-output wpcf7-mail-sent-ok">' + request.responseJSON.message + '</div></div>');

                $.cookie('nasatheme_popup_closed', 'do-not-show', {expires: 7, path: '/'});
                $.magnificPopup.close();

                setTimeout(function() {
                    $('#nasa-newsletter-alert').fadeIn(300);

                    setTimeout(function() {
                        $('#nasa-newsletter-alert').fadeOut(500);
                    }, 2000);
                }, 300);
            }
        });
    });
}

/*
 * Compare products
 */
$('body').on('click', '.product-interactions .btn-compare', function(){
    var _this = $(this);
    if(!$(_this).hasClass('nasa-compare')) {
        var $button = $(_this).parents('.product-interactions');
        $button.find('.compare-button .compare').trigger('click');
    } else {
        var _id = $(_this).attr('data-prod');
        if(_id) {
            add_compare_product(_id, $);
        }
    }
    
    return false;
});
$('body').on('click', '.nasa-remove-compare', function(){
    var _id = $(this).attr('data-prod');
    if(_id) {
        remove_compare_product(_id, $);
    }
    
    return false;
});
$('body').on('click', '.nasa-compare-clear-all', function(){
    removeAll_compare_product($);
    
    return false;
});
$('body').on('click', '.nasa-show-compare', function(){
    if(!$(this).hasClass('nasa-showed')) {
        showCompare($);
    } else {
        hideCompare($);
    }
    
    return false;
});

/*
 * Wishlist products
 */
$('body').on('click', '.product-interactions .btn-wishlist', function(){
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disabled')) {
        $('.btn-wishlist').addClass('nasa-disabled');
        if(!$(_this).hasClass('nasa-added')) {
            $(_this).addClass('nasa-added');
            var $button = $(_this).parents('.product-interactions');
            $button.find('.add_to_wishlist').trigger('click');
        } else {
            var _pid = $(_this).attr('data-prod');
            if(_pid && $('#yith-wcwl-row-' + _pid).length && $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').length) {
                $(_this).removeClass('nasa-added');
                $(_this).addClass('nasa-unliked');
                $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').trigger('click');
                
                setTimeout(function() {
                    $(_this).removeClass('nasa-unliked');
                }, 1000);
            } else {
                $('.btn-wishlist').removeClass('nasa-disabled');
            }
        }
    }
    
    return false;
});

/* ADD PRODUCT WISHLIST NUMBER */
$('body').on('added_to_wishlist', function() {
    var _data = {};
    _data.action = 'nasa_update_wishlist';
    
    if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
        $('.nasa-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data[_key] = _val;
        });
    }
    
    $.ajax({
        url: ajaxurl,
        type: 'post',
        dataType: 'json',
        cache: false,
        data: _data,
        beforeSend: function(){

        },
        success: function(res){
            $('.wishlist_sidebar').replaceWith(res.list);
            var _sl_wishlist = (res.count).toString().replace('+', '');
            var sl_wislist = parseInt(_sl_wishlist);
            $('.wishlist-number .nasa-sl').html(res.count);
            
            if (sl_wislist > 0) {
                $('.wishlist-number').removeClass('nasa-product-empty');
            } else if(sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')){
                $('.wishlist-number').addClass('nasa-product-empty');
            }

            setTimeout(function() {
                initWishlistIcons($, true);
                $('.btn-wishlist').removeClass('nasa-disabled');
            }, 350);
        }
    });
});

/* REMOVE PRODUCT WISHLIST NUMBER */
$('body').on('click', '.nasa-remove_from_wishlist', function(){
    var _data = {};
    _data.action = 'nasa_remove_from_wishlist';
    
    if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
        $('.nasa-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data[_key] = _val;
        });
    }
    
    var _pid = $(this).attr('data-prod_id');
    _data.pid = _pid;
    _data.wishlist_id = $('.wishlist_table').attr('data-id');
    _data.pagination = $('.wishlist_table').attr('data-pagination');
    _data.per_page = $('.wishlist_table').attr('data-per-page');
    _data.current_page = $('.wishlist_table').attr('data-page');
    
    var _wrap_item = $(this).parents('.nasa-tr-wishlist-item');
    
    $.ajax({
        url: ajaxurl,
        type: 'post',
        dataType: 'json',
        cache: false,
        data: _data,
        beforeSend: function(){
            $.magnificPopup.close();
            if ($(_wrap_item).length) {
                $(_wrap_item).css({opacity: 0.5});
            }
        },
        success: function(res){
            if(res.error === '0'){
                $('.wishlist_sidebar').replaceWith(res.list);
                var _sl_wishlist = (res.count).toString().replace('+', '');
                var sl_wislist = parseInt(_sl_wishlist);
                $('.wishlist-number .nasa-sl').html(res.count);
                if (sl_wislist > 0) {
                    $('.wishlist-number').removeClass('nasa-product-empty');
                } else if(sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')){
                    $('.wishlist-number').addClass('nasa-product-empty');
                    $('.black-window').trigger('click');
                }
                
                if($('.btn-wishlist[data-prod="' + _pid + '"]').length) {
                    $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('nasa-added');
                    
                    if($('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').length) {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').removeClass('added');
                    }
                }
                
                if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                    $('#yith-wcwl-popup-message').html(res.mess);
                    
                    $('#yith-wcwl-popup-message').fadeIn();
                    setTimeout( function() {
                        $('#yith-wcwl-popup-message').fadeOut();
                    }, 2000 );
                }
            }
            
            $('.btn-wishlist').removeClass('nasa-disabled');
        }
    });
    
    return false;
});

// Target quantity inputs on product pages
$('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
    var min = parseFloat($(this).attr('min'));
    if (min && min > 0 && parseFloat($(this).val()) < min) {
        $(this).val(min);
    }
});

$('body').on('click', '.plus, .minus', function() {
    // Get values
    var $qty = $(this).parents('.quantity').find('.qty'),
        button_add = $(this).parent().parent().find('.single_add_to_cart_button'),
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');
        
    // Format values
    currentVal = !currentVal ? 0 : currentVal;
    max = !max ? '' : max;
    min = !min ? 1 : min;
    if (step === 'any' || step === '' || typeof step === 'undefined' || parseFloat(step) === 'NaN') step = 1;
    // Change the value
    if ($(this).is('.plus')) {
        if (max && (max == currentVal || currentVal > max)) {
            $qty.val(max);
            if(button_add.length > 0){
                button_add.attr('data-quantity', max);
            }
        } else {
            $qty.val(currentVal + parseFloat(step));
            if(button_add.length > 0){
                button_add.attr('data-quantity', currentVal + parseFloat(step));
            }
        }
    } else {
        if (min && (min == currentVal || currentVal < min)) {
            $qty.val(min);
            if(button_add.length > 0){
                button_add.attr('data-quantity', min);
            }
        } else if (currentVal > 0) {
            $qty.val(currentVal - parseFloat(step));
            if(button_add.length > 0){
                button_add.attr('data-quantity', currentVal - parseFloat(step));
            }
        }
    }
    // Trigger change event
    $qty.trigger('change');
});

/*
 * Ajax search
 */
if($('input.live-search-input').length && typeof search_options.enable_live_search !== 'undefined' && search_options.enable_live_search == '1') {
    var empty_mess = $('#nasa-empty-result-search').html();
    
    var searchProducts = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: ajaxurl + '?action=live_search_products',
        limit: search_options.limit_results,
        remote: {
            url: ajaxurl + '?action=live_search_products&s=%QUERY',
            ajax: {
                data:{cat: $('.nasa-cats-search').val()},
                beforeSend: function () {
                    if($('.live-search-input').parent().find('.loader-search').length === 0){
                        $('.live-search-input').parent().append('<div class="nasa-loader nasa-live-search-loader"></div>');
                    }
                },
                success: function () {
                    $('.nasa-live-search-loader').remove();
                },
                error: function () {
                    $('.nasa-live-search-loader').remove();
                }
            }
        }
    });
    
    var initSearch = false;
    $('body').on('focus', 'input.live-search-input', function (){
        if(!initSearch) {
            searchProducts.initialize();
            initSearch = true;
        }
    });

    $('.live-search-input').typeahead({
        minLength: 3,
        hint: true,
        highlight: false,
        backdrop: {
            "opacity": 0.8,
            "filter": "alpha(opacity=80)",
            "background-color": "#eaf3ff"
        },
        backdropOnFocus: true,
        callback: {
            onInit: function () {
                searchProducts.initialize();
            },
            onSubmit: function(node, form, item, event) {
                form.submit();
            }
        }
    },
    {
        name: 'search',
        source: searchProducts.ttAdapter(),
        displayKey: 'title',
        templates: {
            empty : '<p class="empty-message" style="padding:0;margin:0;font-size:100%;">' + empty_mess + '</p>',
            suggestion: Handlebars.compile(search_options.live_search_template)
        }
    });
}

/*
 * Banner Lax
 */
if ($('.hover-lax').length) {
    var windowWidth = $(window).width();
    $(window).resize(function() {
        windowWidth = $(window).width();
        if(windowWidth <= 768){
            $('.hover-lax').css('background-position', 'center center');
        }
    });

    $('body').on('mousemove', '.hover-lax', function(e){
        var lax_bg = $(this);
        var minWidth = $(lax_bg).attr('data-minwidth') ? $(lax_bg).attr('data-minwidth') : 768;

        if(windowWidth > minWidth){
            var amountMovedX = (e.pageX * -1 / 6);
            var amountMovedY = (e.pageY * -1 / 6);
            $(lax_bg).css('background-position', amountMovedX + 'px ' + amountMovedY + 'px');
        }else{
            $(lax_bg).css('background-position', 'center center');
        }
    });
}

$('body').on('click', '.botbar-mobile-search', function(){
    if ($('.mobile-search').length) {
        $('.mobile-search').trigger('click');
    }
});

$('body').on('click', '.mobile-search', function(){
    $('.black-window').fadeIn(200);
    var height_adminbar = $('#wpadminbar').length > 0 ? $('#wpadminbar').height() : 0;
    $('.warpper-mobile-search').addClass('nasa-active').css({'margin-top': height_adminbar});
    setTimeout(function() {
        $('.warpper-mobile-search').find('input[name="s"]').focus();
    }, 1000);
});

var _hotkeyInit = false;
$('body').on('click', '.desk-search', function(e){
    var _this_click = $(this);
    
    if(!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        var _focus_input = $(_this_click).parents('.nasa-wrap-event-search').find('.nasa-show-search-form');
        var _opened = $(_this_click).attr('data-open');
        
        if(_opened === '0') {
            $('.header-wrapper').find('.nasa-show-search-form').after('<div class="nasa-tranparent" />');
        } else {
            $('.header-wrapper').find('.nasa-tranparent').remove();
        }
        
        $('.desk-search').each(function() {
            var _this = $(this);
            var _root_wrap = $(_this).parents('.nasa-wrap-event-search');
            var _elements = $(_root_wrap).find('.nasa-elements-wrap');
            var _search = $(_root_wrap).find('.nasa-show-search-form');

            if(typeof _opened === 'undefined' || _opened === '0') {
                $(_this).attr('data-open', '1');
                if(!$(_search).hasClass('nasa-show')) {
                    $(_search).addClass('nasa-show');
                }

                $(_elements).addClass('nasa-invisible');
            } else {
                $(_this).attr('data-open', '0');
                if($(_search).hasClass('nasa-show')) {
                    $(_search).removeClass('nasa-show');
                }

                $(_elements).removeClass('nasa-invisible');
            }
        });
        
        if (_hotkeyInit) {
            setTimeout(function() {
                $(_this_click).removeClass('nasa-disable');
                $(_focus_input).find('input[name="s"]').focus();
            }, 1000);
        } else {
            setTimeout(function() {
                $(_focus_input).find('input[name="s"]').focus();
            }, 1000);
            $(_this_click).removeClass('nasa-disable');
            
            /**
             * Hot keywords search
             */
            setTimeout(function() {
                _hotkeyInit = true;
                var _oldStr = '';

                if ($(_focus_input).find('input[name="s"]').length) {
                    var _inputCurrent = $(_focus_input).find('input[name="s"]');
                    _oldStr = $(_inputCurrent).val();

                    if (_oldStr !== '') {
                        $(_inputCurrent).val(_oldStr).focus();
                    }

                    autoFillInputPlaceHolder($, _inputCurrent);
                }
            }, 1000);
        }
    }
    
    e.preventDefault();
});

$('body').on('click', '.nasa-close-search, .nasa-tranparent', function(){
    $(this).parents('.nasa-wrap-event-search').find('.desk-search').trigger('click');
});

$('body').on('click', '.toggle-sidebar-shop', function(){
    $('.transparent-window').fadeIn(200);
    if(!$('.nasa-side-sidebar').hasClass('nasa-show')){
        $('.nasa-side-sidebar').addClass('nasa-show');
    }
});

/**
 * For topbar type 1 Mobile
 */
$('body').on('click', '.toggle-topbar-shop-mobile', function(){
    $('.transparent-mobile').fadeIn(200);
    if(!$('.nasa-top-sidebar').hasClass('nasa-active')){
        $('.nasa-top-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.toggle-sidebar', function(){
    $('.black-window').fadeIn(200);
    if ($('.col-sidebar').length && !$('.col-sidebar').hasClass('nasa-active')){
        $('.col-sidebar').addClass('nasa-active');
    }
});

if ($('input[name="nasa_cart_sidebar_show"]').length && $('input[name="nasa_cart_sidebar_show"]').val() === '1') {
    setTimeout(function() {
        $('.cart-link').trigger('click');
    }, 300);
}

$('body').on('click', '.botbar-cart-link', function(){
    if ($('.cart-link').length) {
        $('.cart-link').trigger('click');
    }
});

/**
 * Show mini Cart sidebar
 */
$('body').on('click', '.cart-link', function(){
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        return false;
    } else {
        if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
            $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
        }
        else {
            if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
                $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
            }
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
            $('#cart-sidebar').addClass('nasa-active');

            if ($('#cart-sidebar').find('input[name="nasa-mini-cart-empty-content"]').length) {
                $('#cart-sidebar').append('<div class="nasa-loader"></div>');

                reloadMiniCart($);
            } else {
                /**
                 * notification free shipping
                 */
                init_shipping_free_notification($);
            }
        }
    }
});

$('body').on('click', '.wishlist-link', function(){
    if($(this).hasClass('wishlist-link-premium')) {
        return;
    } else {
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#nasa-wishlist-sidebar').length && !$('#nasa-wishlist-sidebar').hasClass('nasa-active')) {
            $('#nasa-wishlist-sidebar').addClass('nasa-active');
        }
    }
});

$('body').on('click', '#nasa-init-viewed', function(){
    $('.black-window').fadeIn(200).addClass('desk-window');
    if ($('#nasa-viewed-sidebar').length && !$('#nasa-viewed-sidebar').hasClass('nasa-active')) {
        if ($('#nasa-viewed-sidebar').find('.item-product-widget').length) {
            $('#nasa-viewed-sidebar').find('.nasa-sidebar-tit').removeClass('text-center');
        }
        $('#nasa-viewed-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .nasa-sidebar-return-shop, .login-register-close a', function(){
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    $('.black-window').removeClass('desk-window');
    
    if($('#mobile-navigation').length === 1 && $('#mobile-navigation').attr('data-show') === '1') {
        if ($('#nasa-menu-sidebar-content').length) {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
        }
        
        $('#mobile-navigation').attr('data-show', '0');
        setTimeout(function() {
            $('.black-window').removeClass('nasa-transparent');
        }, 1000);
    }
    
    if($('.warpper-mobile-search').length){
        $('.warpper-mobile-search').removeClass('nasa-active');
        if($('.warpper-mobile-search').hasClass('show-in-desk')){
            setTimeout(function () {
                $('.warpper-mobile-search').removeClass('show-in-desk');
            }, 600);
        }
    }
    
    /**
     * Close sidebar
     */
    if($('.col-sidebar').length && _mobileView){
        $('.col-sidebar').removeClass('nasa-active');
    }

    /**
     * Close cart sidebar
     */
    if($('#cart-sidebar').length){
        $('#cart-sidebar').removeClass('nasa-active');
    }

    /**
     * Close wishlist sidebar
     */
    if($('#nasa-wishlist-sidebar').length){
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close viewed sidebar
     */
    if($('#nasa-viewed-sidebar').length){
        $('#nasa-viewed-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close quick view sidebar
     */
    if($('#nasa-quickview-sidebar').length){
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close filter categories sidebar in mobile
     */
    if($('.nasa-top-cat-filter-wrap-mobile').length) {
        $('.nasa-top-cat-filter-wrap-mobile').removeClass('nasa-show');
    }
    
    /**
     * Close sidebar
     */
    if($('.nasa-side-sidebar').length) {
        $('.nasa-side-sidebar').removeClass('nasa-show');
    }
    
    if($('.nasa-top-sidebar').length){
        $('.nasa-top-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close login or register
     */
    if($('.nasa-login-register-warper').length){
        $('.nasa-login-register-warper').removeClass('nasa-active');
    }
    
    /**
     * Languages
     */
    if($('.nasa-current-lang').length) {
        var _wrapLangs = $('.nasa-current-lang').parents('.nasa-select-languages');
        if ($(_wrapLangs).length) {
            $(_wrapLangs).removeClass('nasa-active');
        }
    }
    
    /**
     * Currencies
     */
    if($('.wcml-cs-item-toggle').length) {
        var _wrapCurrs = $('.wcml-cs-item-toggle').parents('.nasa-select-currencies');
        if ($(_wrapCurrs).length) {
            $(_wrapCurrs).removeClass('nasa-active');
        }
    }
    
    /**
     * Hide compare product
     */
    hideCompare($);

    $('.black-window, .white-window, .transparent-mobile, .transparent-window, .transparent-desktop').fadeOut(1000);
});

$(document).on('keyup', function(e){
    if (e.keyCode === 27){
        $('.nasa-tranparent').trigger('click');
        $('.nasa-tranparent-filter').trigger('click');
        $('.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .login-register-close a, .nasa-transparent-topbar, .nasa-close-filter-cat').trigger('click');
        $.magnificPopup.close();
    }
});

$('body').on('click', '.add_to_cart_button', function() {
    if(!$(this).hasClass('product_type_simple')) {
        var _href = $(this).attr('href');
        window.location.href = _href;
    }
});

/*
 * Single add to cart from wishlist
 */
$('body').on('click', '.nasa_add_to_cart_from_wishlist', function(){
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if(_id && !$(_this).hasClass('loading')){
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _data_wislist = {};
        if($('.wishlist_table').length > 0 && $('.wishlist_table').find('#yith-wcwl-row-' + _id).length > 0) {
            _data_wislist = {
                from_wishlist: '1',
                wishlist_id: $('.wishlist_table').attr('data-id'),
                pagination: $('.wishlist_table').attr('data-pagination'),
                per_page: $('.wishlist_table').attr('data-per-page'),
                current_page: $('.wishlist_table').attr('data-page')
            };
        }
        
        nasa_single_add_to_cart($, _this, _id, _quantity, _type, null, null, _data_wislist);
    }
    
    return false;
});

/*
 * Add to cart in quick-view Or ditail product
 */
$('body').on('click', 'form.cart .single_add_to_cart_button', function() {
    var _flag_adding = true;
    var _this = $(this);
    var _form = $(_this).parents('form.cart');
    
    if($(_form).find('#yith_wapo_groups_container').length) {
        $(_form).find('input[name="nasa-enable-addtocart-ajax"]').remove();
        
        if($(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length) {
            $(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val('1');
        } else {
            $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="nasa_cart_sidebar" value="1" />');
        }
    }
    
    var _enable_ajax = $(_form).find('input[name="nasa-enable-addtocart-ajax"]');
    if($(_enable_ajax).length <= 0 || $(_enable_ajax).val() !== '1') {
        _flag_adding = false;
        return;
    } else {
        var _id = !$(_this).hasClass('disabled') ? $(_form).find('input[name="data-product_id"]').val() : false;
        if(_id && !$(_this).hasClass('loading')) {
            var _type = $(_form).find('input[name="data-type"]').val(),
                _quantity = $(_form).find('.quantity input[name="quantity"]').val(),
                _variation_id = $(_form).find('input[name="variation_id"]').length > 0 ? parseInt($(_form).find('input[name="variation_id"]').val()) : 0,
                _variation = {},
                _data_wislist = {},
                _from_wishlist = (
                    $(_form).find('input[name="data-from_wishlist"]').length === 1 &&
                    $(_form).find('input[name="data-from_wishlist"]').val() === '1'
                ) ? '1' : '0';
                
            if(_type === 'variable' && !_variation_id) {
                _flag_adding = false;
                return false;
            } else {
                if(_variation_id > 0 && $(_form).find('.variations').length > 0){
                    $(_form).find('.variations').find('select').each(function(){
                        _variation[$(this).attr('name')] = $(this).val();
                    });
                    
                    if($('.wishlist_table').length > 0 && $('.wishlist_table').find('tr#yith-wcwl-row-' + _id).length > 0) {
                        _data_wislist = {
                            from_wishlist: _from_wishlist,
                            wishlist_id: $('.wishlist_table').attr('data-id'),
                            pagination: $('.wishlist_table').attr('data-pagination'),
                            per_page: $('.wishlist_table').attr('data-per-page'),
                            current_page: $('.wishlist_table').attr('data-page')
                        };
                    }
                }
            }
            
            if(_flag_adding) {
                nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
            }
        }
        
        return false;
    }
});

$('body').on('click', '.nasa_bundle_add_to_cart', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if(_id){
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _variation_id = 0,
            _variation = {},
            _data_wislist = {};
        
        nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
    }
    
    return false;
});

$('body').on('click', '.product_type_variation.add-to-cart-grid', function() {
    var _this = $(this);
    if(!$(_this).hasClass('nasa-disable-ajax')) {
        if (!$(_this).hasClass('loading')) {
            var _id = $(_this).attr('data-product_id');
            if(_id){
                var _type = 'variation',
                    _quantity = $(_this).attr('data-quantity'),
                    _variation_id = 0,
                    _variation = null,
                    _data_wislist = {};

                    if(typeof $(this).attr('data-variation') !== 'undefined') {
                        _variation = JSON.parse($(this).attr('data-variation'));
                    }
                if(_variation) {
                    nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
                }
            }
        }

        return false;
    }
});

$('body').on('click', '.product_type_variable', function(){
    if($('input[name="nasa-disable-quickview-ux"]').length <= 0 || $('input[name="nasa-disable-quickview-ux"]').val() === '0') {
        var _this = $(this);

        if($(_this).parents('.compare-list').length > 0) {
            return;
        }

        else {
            if(!$(_this).hasClass('btn-from-wishlist')) {
                var _parent = $(_this).parents('.product-interactions');
                if($(_parent).length < 1){
                    _parent = $(_this).parents('.item-product-widget');
                }
                $(_parent).find('.quick-view').trigger('click');
            }
            // From Wishlist
            else {
                var _parent = $(_this).parents('.add-to-cart-wishlist');
                var product_item = $(_this).parents('.product-wishlist-info').find('.wishlist-item');
                $(product_item).css({opacity: 0.3});
                $(product_item).after('<div class="nasa-loader"></div>');

                $(_parent).find('.quick-view').trigger('click');
            }

            return false;
        }
    } else {
        return;
    }
});

/**
 * After remove cart item in mini cart
 */
$('body').on('wc_fragments_loaded', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length <= 0) {
        $('.black-window').trigger('click');
    }
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

$('body').on('wc_fragments_refreshed', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

$('body').on('updated_wc_div', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

/**
 * After Add To Cart
 */
$('body').on('added_to_cart', function() {
    /**
     * Close quick-view
     */
    if ($('.nasa-after-add-to-cart-popup').length <= 0) {
        $.magnificPopup.close();
    }
    
    var _sidebarCart = true;
    
    /* Loading content After Add To Cart */
    if ($('input[name="nasa-after-add-to-cart"]').length && $('form.nasa-shopping-cart-form').length <= 0 && $('form.woocommerce-checkout').length <= 0) {
        _sidebarCart = false;
        
        after_added_to_cart($);
    }
    
    /**
     * Not show sidebar in cart or checkout page
     */
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        _sidebarCart = false;
    }
   
    /**
     * Show Mini Cart Sidebar
     */
    if (_sidebarCart) {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
        
        setTimeout(function () {
            if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
                $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
            }
            else {
                if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
                    $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
                }
            }
            
            $('.black-window').fadeIn(200).addClass('desk-window');
            $('#nasa-wishlist-sidebar').removeClass('nasa-active');
            if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
                $('#cart-sidebar').addClass('nasa-active');
            }
            
            /**
             * notification free shipping
             */
            init_shipping_free_notification($);
        }, 200);
    }
});

$('body').on(_event, '.nasa-close-magnificPopup', function() {
    $.magnificPopup.close();
});

$('body').on('change', '.nasa-after-add-to-cart-popup input.qty', function() {
    $('.nasa-after-add-to-cart-popup .nasa-update-cart-popup').removeClass('nasa-disable');
});

$('body').on('click', '.remove_from_cart_popup', function() {
    if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        nasa_block($('.nasa-after-add-to-cart-wrap'));
        
        var _id = $(this).attr('data-product_id');
        if ($('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').length) {
            $('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').trigger('click');
        } else {
            window.location.href = $(this).attt('href');
        }
    }
    
    return false;
});

$('body').on('removed_from_cart', function() {
    if ($('.nasa-after-add-to-cart-popup').length) {
        after_added_to_cart($);
    }
    
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
                    
    return false;
});

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var nasa_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var nasa_block = function($node) {
    if (!nasa_is_blocked($node)) {
        $node.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
    }
};

/**
 * Unblock a node after processing is complete.
 *
 * @param {JQuery Object} $node
 */
var nasa_unblock = function($node) {
    $node.removeClass('processing').unblock();
};

/**
 * Update cart in popup
 */
$('body').on('click', '.nasa-update-cart-popup', function() {
    var _this = $(this);
    if ($('.nasa-after-add-to-cart-popup').length && !$(_this).hasClass('nasa-disable')) {
        var _form = $(this).parents('form');
        if ($(_form).find('input[name=""]').length <= 0) {
            $(_form).append('<input type="hidden" name="update_cart" value="Update Cart" />');
        }
        $.ajax({
            type: $(_form).attr('method'),
            url: $(_form).attr('action'),
            data: $(_form).serialize(),
            dataType: 'html',
            beforeSend: function() {
                nasa_block($('.nasa-after-add-to-cart-wrap'));
            },
            success: function(res) {
                $(_form).find('input[name="update_cart"]').remove();
                $(_this).addClass('nasa-disable');
            },
            complete: function() {
                reloadMiniCart($);
                after_added_to_cart($);
            }
        });
    }
    
    return false;
});

// shortcode post to top
if($('.nasa-post-slider').length > 0){
    var _items = parseInt($('.nasa-post-slider').attr('data-show'));
    $('.nasa-post-slider').owlCarousel({
        items: _items,
        loop: true,
        nav: false,
        autoplay: true,
        dots: false,
        autoHeight: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        navText: ["", ""],
        navSpeed: 600,
        responsive:{
            "0": {
                items: 1,
                nav: false
            },
            "600": {
                items: 1,
                nav: false
            },
            "1000": {
                items: _items,
                nav: false
            }
        }
    });
};

if($('.nasa-promotion-close').length > 0){
    var height = $('.nasa-promotion-news').outerHeight();
    if($.cookie('promotion') !== 'hide'){
        $('.nasa-position-relative').animate({'height': height+'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
    }
    
    $('body').on('click', '.nasa-promotion-close', function(){
        $.cookie('promotion', 'hide', {expires: 7, path: '/'});
        $('.nasa-promotion-show').show();
        $('.nasa-position-relative').animate({'height': '0px'}, 500);
        $('.nasa-promotion-news').fadeOut(500);
    });
    
    $('body').on('click', '.nasa-promotion-show', function(){
        $.cookie('promotion', 'show', {expires: 7, path: '/'});
        $('.nasa-promotion-show').hide();
        $('.nasa-position-relative').animate({'height': height+'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
    });
};

/* ===================== Filter by sidebar =============================== */
var min_price = 0, max_price = 0, hasPrice = '0';
if($('.price_slider_wrapper').length > 0){
    $('.price_slider_wrapper').find('input').attr('readonly', true);
    min_price = parseFloat($('.price_slider_wrapper').find('input[name="min_price"]').val()),
    max_price = parseFloat($('.price_slider_wrapper').find('input[name="max_price"]').val());
    hasPrice = ($('.nasa_hasPrice').length > 0) ? $('.nasa_hasPrice').val() : '0';

    if(hasPrice === '1'){
        $('.reset_price').attr('data-has_price', "1").show();
        if($('.price_slider_wrapper').find('button').length) {
            $('.price_slider_wrapper').find('button').show();
        }
    }
}

$('body').on('click', '.price_slider_wrapper button', function(e) {
    e.preventDefault();
    if(hasPrice === '1' && $('.nasa-has-filter-ajax').length < 1){
        var _obj = $(this).parents('form');
        $('input[name="nasa_hasPrice"]').remove();
        $(_obj).submit();
    }
});

// Filter by Price
$('body').on("slidestop", ".price_slider", function(){
    var _obj = $(this).parents('form');
    if($('.nasa-has-filter-ajax').length < 1){
        if($(_obj).find('button').length) {
            $(_obj).find('button').show();
            if($(_obj).find('.nasa_hasPrice').length > 0){
                $(_obj).find('.nasa_hasPrice').val('1');
                $(_obj).find('.reset_price').attr('data-has_price', "1").fadeIn(200);
            }
            
            $(_obj).find('button').click(function() {
                $('input[name="nasa_hasPrice"]').remove();
                $(_obj).submit();
            });
        } else {
            $(_obj).submit();
        }
    } else {
        var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
            max = parseFloat($(_obj).find('input[name="max_price"]').val());
        if(min < 0){
            min = 0;
        }
        if(max < min){
            max = min;
        }

        if(min != min_price || max != max_price){
            if($(_obj).find('button').length) {
                $(_obj).find('button').show();
            }
            
            min_price = min;
            max_price = max;
            hasPrice = '1';
            if($('.nasa_hasPrice').length > 0){
                $('.nasa_hasPrice').val('1');
                $('.reset_price').attr('data-has_price', "1").fadeIn(200);
            }

            // Call filter by price
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _catid = null,
                _taxonomy = '',
                _url = '';

            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);
            var _hasSearch = ($('input#nasa_hasSearch').length > 0 && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            if($(_obj).find('button').length) {
                $(_obj).find('button').click(function() {
                    nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
                });
            } else {
                nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            }
        }

        return false;
    }
});

// Reset filter price
$('body').on('click', '.reset_price', function(){
    if($('.nasa_hasPrice').length > 0 && $('.nasa_hasPrice').val() === '1'){
        var _obj = $(this).parents('form');
        if($('.nasa-has-filter-ajax').length < 1){
            $('#min_price').remove();
            $('#max_price').remove();
            $('input[name="nasa_hasPrice"]').remove();
            $(_obj).append('<input type="hidden" name="reset-price" value="true" />');
            $(_obj).submit();
        } else {
            if(!shop_load) {
                shop_load = true;
                var _min = $('#min_price').attr('data-min');
                var _max = $('#max_price').attr('data-max');
                $('.price_slider').slider('values', 0, _min);
                $('.price_slider').slider('values', 1, _max);
                $('#min_price').val(_min);
                $('#max_price').val(_max);

                var currency_pos = $('input[name="nasa_currency_pos"]').val(),
                    full_price_min = _min,
                    full_price_max = _max;
                switch (currency_pos) {
                    case 'left':
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + _max;
                        break;
                    case 'right':
                        full_price_min = _min + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                    case 'left_space' :
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + ' ' + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + ' ' + _max;
                        break;
                    case 'right_space' :
                        full_price_min = _min + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                }

                $('.price_slider_amount .price_label span.from').html(full_price_min);
                $('.price_slider_amount .price_label span.to').html(full_price_max);

                var min = 0,
                    max = 0;

                hasPrice = '0';
                if($('.nasa_hasPrice').length > 0){
                    $('.nasa_hasPrice').val('0');
                    $('.reset_price').attr('data-has_price', "0").fadeOut(200);
                }

                // Call filter by price
                var _this = $('.current-cat > .nasa-filter-by-cat'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _catid = null,
                    _taxonomy = '',
                    _url = '';

                if($(_this).length > 0){
                    _catid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = nasa_setVariations($, [], []);
                var _hasSearch = ($('input#nasa_hasSearch').length > 0 && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            }
        }
    
        return false;
    }
});

/**
 * Filter price list
 */
$('body').on('click', '.nasa-filter-by-price-list', function() {
    if($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            var _url = $(this).attr('href');
            var min = $(this).attr('data-min') ? $(this).attr('data-min') : null,
                max = $(this).attr('data-max') ? $(this).attr('data-max') : null;
                
            if(min < 0){
                min = 0;
            }
            if(max < min){
                max = min;
            }

            if(min != min_price || max != max_price){
                hasPrice = '1';
            }
            
            // Call filter by price
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _catid = null,
                _taxonomy = '';

            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
            }
            
            var _variations = [];
            
            var _s = $('input#nasa_hasSearch').val(),
                _hasSearch = _s ? 1 : 0;
            
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false, false);
        }
        
        return false;
    }
});

/**
 * Tag clouds
 */
renderTagClouds($);

// Reset filter
$('body').on('click', '.nasa-reset-filters-btn', function() {
    if($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            var _this = $(this),
            _catid = $(_this).attr('data-id'),
            _taxonomy = $(_this).attr('data-taxonomy'),
            _order = false,
            _url = $(_this).attr('href'),
            _page = false;
            
            var _variations = [];
            var min = null,
                max = null;
            $('input#nasa_hasSearch').val('');
            hasPrice = '0';
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy);
        }
        
        return false;
    }
});

// Filter by Category
$('body').on('click', '.nasa-filter-by-cat', function(){
    if($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if(!shop_load) {
            if(!$(this).hasClass('nasa-disable') && !$(this).hasClass('nasa-active')){
                shop_load = true;
                // $('li.cat-item').removeClass('current-cat');
                var _this = $(this),
                    _catid = $(_this).attr('data-id'),
                    _taxonomy = $(_this).attr('data-taxonomy'),
                    _order = $('select[name="orderby"]').val(),
                    _url = $(_this).attr('href'),
                    _page = false;

                if(_catid){
                    var _variations = [];
                    $('.nasa-filter-by-variations').each(function(){
                        if($(this).hasClass('nasa-filter-var-chosen')){
                            $(this).parent().removeClass('chosen nasa-chosen');
                            $(this).removeClass('nasa-filter-var-chosen');
                        }
                    });

                    var min = null,
                        max = null;
                    $('input#nasa_hasSearch').val('');
                    hasPrice = '0';
                    /**
                     * Fix filter cat push in mobile.
                     */
                    if($('.black-window-mobile.nasa-push-cat-show').width()) {
                        $('.black-window-mobile.nasa-push-cat-show').trigger('click');
                    }
                    nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy);

                    if (
                        $(_this).parents('.nasa-filter-cat-no-top-icon').length === 1 &&
                        $('.nasa-tab-filter-topbar-categories').length > 0
                    ) {
                        $('.nasa-tab-filter-topbar-categories').trigger('click');
                    }
                }
            }
        }

        return false;
    }
});

if($('.woocommerce-ordering').length > 0 && $('.nasa-has-filter-ajax').length > 0){
    var _parent = $('.woocommerce-ordering').parent(),
        _order = $('.woocommerce-ordering').html();
    $(_parent).html(_order);
}

// Filter by ORDER BY
$('body').on('change', 'select[name="orderby"]', function(){
    if($('.nasa-has-filter-ajax').length <= 0) {
        $(this).parents('form').submit();
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $(this).val(),
                _page = false,
                _catid = null,
                _taxonomy = '',
                _url = '';

            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if(hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if($(_obj).length > 0){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if(min < 0){
                        min = 0;
                    }
                    if(max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length > 0 && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';
            
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Paging
$('body').on('click', '.nasa-pagination-ajax .page-numbers', function(){
    if($(this).hasClass('nasa-current')){
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = $(this).attr('data-page'),
                _catid = null,
                _taxonomy = '',
                _url = '';
            if(_page === '1'){
                _page = false;
            }
            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if(hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if($(_obj).length > 0){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if(min < 0){
                        min = 0;
                    }
                    if(max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length > 0  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, true);
        }

        return false;
    }
});

// Filter by Loadmore
$('body').on('click', '.nasa-archive-loadmore', function() {
    if($('.nasa-has-filter-ajax').length < 1){
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            $(this).addClass('nasa-disabled');
            archive_page = archive_page + 1;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = archive_page,
                _catid = null,
                _taxonomy = '',
                _url = '';
            if(_page == 1){
                _page = false;
            }
            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if(hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if($(_obj).length > 0){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if(min < 0){
                        min = 0;
                    }
                    if(max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length > 0  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, true);
        }

        return false;
    }
});

// Filter by variations
$('body').on('click', '.nasa-filter-by-variations', function(){
    if($('.nasa-has-filter-ajax').length < 1){
        return;
    } else {
        if(!shop_load) {
            shop_load = true;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _catid = null,
                _taxonomy = '',
                _url = '';

            if($(_this).length > 0){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = [], 
                _keys = [],
                flag = false;
            if($(this).hasClass('nasa-filter-var-chosen')){
                $(this).parent().removeClass('chosen nasa-chosen').show();
                $(this).removeClass('nasa-filter-var-chosen');
            }else{
                $(this).parent().addClass('chosen nasa-chosen');
                $(this).addClass('nasa-filter-var-chosen');
            }
            flag = true;

            if(flag){
                _variations = nasa_setVariations($, _variations, _keys);
            }

            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if($(_obj).length > 0 && hasPrice === '1'){
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
                if(min < 0){
                    min = 0;
                }
                if(max < min){
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length > 0  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
    
});

/**
 * nasa-change-layout Change layout
 */
$('body').on('click', '.nasa-change-layout', function(){
    var _this = $(this);
    if($(_this).hasClass('active')){
        return false;
    } else {
        changeLayoutShopPage($, _this);
    }
});

var _cookie_change_layout = $.cookie('gridcookie');
if(typeof _cookie_change_layout !== 'undefined') {
    $('.nasa-change-layout.' + _cookie_change_layout).trigger('click');
}

// Logout click
$('body').on('click', '.nasa_logout_menu a', function(){
    if($('input[name="nasa_logout_menu"]').length > 0){
        window.location.href = $('input[name="nasa_logout_menu"]').val();
    }
});

// Show more | Show less
$('body').on('click', '.nasa_show_manual > a', function(){
    var _this = $(this),
        _val = $(_this).attr('data-show'),
        _li = $(_this).parent(),
        _delay = $(_li).attr('data-delay') ? parseInt($(_li).attr('data-delay')) : 100,
        _fade = $(_li).attr('data-fadein') === '1' ? true : false;

    if(_val === '1'){
        $(_li).parent().find('.nasa-show-less').each(function(){
            if(!_fade) {
                $(this).slideDown(_delay);
            } else {
                $(this).fadeIn(_delay);
            }
        });
        
        $(_this).fadeOut(350);
        $(_li).find('.nasa-hidden').fadeIn(350);
        
    } else {
        $(_li).parent().find('.nasa-show-less').each(function(){
            if(!$(this).hasClass('nasa-chosen') && !$(this).find('.nasa-active').length > 0){
                if(!_fade) {
                    $(this).slideUp(_delay);
                } else {
                    $(this).fadeOut(_delay);
                }
            }
        });
        
        $(_this).fadeOut(350);
        $(_li).find('.nasa-show').fadeIn(350);
    }
});

// Login Register Form
$('body').on('click', '.nasa-switch-register', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '0'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '-100%'}, 350);
    
    setTimeout(function (){
        $('.nasa_register-form, .register-form').css({'position': 'relative'});
        $('.nasa_login-form, .login-form').css({'position': 'absolute'});
    }, 350);
});

$('body').on('click', '.nasa-switch-login', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '100%'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '0'}, 350);
    
    setTimeout(function (){
        $('.nasa_register-form, .register-form').css({'position': 'absolute'});
        $('.nasa_login-form, .login-form').css({'position': 'relative'});
    }, 350);
});

if($('.nasa-login-register-ajax').length && $('#nasa-login-register-form').length) {
    $('body').on('click', '.nasa-login-register-ajax', function() {
        if ($(this).attr('data-enable') === '1' && $('#customer_login').length <= 0) {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
            $('#mobile-navigation').attr('data-show', '0');
            
            $('.black-window').fadeIn(200).removeClass('nasa-transparent').addClass('desk-window');
            if (!$('.nasa-login-register-warper').hasClass('nasa-active')) {
                $('.nasa-login-register-warper').addClass('nasa-active');
            }
            
            return false;
        }
    });
    
    // Login
    $('body').on('click', '.nasa_login-form input[type="submit"][name="nasa_login"]', function() {
        var _form = $(this).parents('form.login');
        var _data = $(_form).serializeArray();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'action': 'nasa_process_login',
                'data': _data,
                'login': true
            },
            beforeSend: function(){
                $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
            },
            success: function(res){
                $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                $('#nasa-login-register-form').find('.nasa-loader, .please-wait').remove();
                var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                if(res.error === '0') {
                    $('#nasa-login-register-form .nasa-form-content').remove();
                    window.location.href = res.redirect;
                } else {
                    if(res._wpnonce === 'error') {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            }
        });
        
        return false;
    });

    // Register
    $('body').on('click', '.nasa_register-form input[type="submit"][name="nasa_register"]', function() {
        var _form = $(this).parents('form.register');
        var _data = $(_form).serializeArray();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'action': 'nasa_process_register',
                'data': _data,
                'register': true
            },
            beforeSend: function(){
                $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
            },
            success: function(res){
                $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                $('#nasa-login-register-form').find('.nasa-loader, .please-wait').remove();
                var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');
                
                if(res.error === '0') {
                    $('#nasa-login-register-form .nasa-form-content').remove();
                    window.location.href = res.redirect;
                } else {
                    if(res._wpnonce === 'error') {
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            }
        });
        
        return false;
    });
}

$('body').on('click', '.btn-combo-link', function(){
    var _width = $(window).outerWidth();
    var _this = $(this);
    var show_type = $(_this).attr('data-show_type');
    var wrap_item = $(_this).parents('.products.list');
    if (_width < 946 || $(wrap_item).length === 1) {
        show_type = 'popup';
    }
    
    switch (show_type) {
        default :
            loadComboPopup($, _this);
            break;
    }
    
    return false;
});

if($('.nasa-upsell-product-detail').find('.nasa-upsell-slider').length > 0) {
    $('.nasa-upsell-product-detail').find('.nasa-upsell-slider').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 600,
        navSpeed: 600,
        autoplayHoverPause: true,
        navText: ["", ""],
        responsive:{
            0:{
                items: 1
            }
        }
    });
}

if ($('.nasa-active').length > 0) {
    $('.nasa-active').each(function() {
        if ($(this).parents('.nasa-show-less').length === 1) {
            $(this).parents('.nasa-show-less').show();
        }
    });
}

/* 
 * custom widget top bar
 * 
 */
if($('.nasa-top-sidebar').length > 0) {
    initNasaTopSidebar($);
    
    $('body').on('click', '.nasa-tab-filter-topbar-categories', function() {
        var _this = $(this);
        $('.filter-cat-icon-mobile').trigger('click');
        
        if($(_this).attr('data-top_icon') === '0') {
            var _obj = $(_this).attr('data-widget');
            var _wrap_content = $('.nasa-top-sidebar');

            var _act = $(_obj).hasClass('nasa-active') ? true : false;
            $(_this).parents('.nasa-top-row-filter').find('> li').removeClass('nasa-active');
            $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(300);
            
            if(!_act) {
                $(_obj).addClass('nasa-active').slideDown(300);
                $(_this).parents('li').addClass('nasa-active');
            }
        }
        
        else {
            $('.site-header').find('.filter-cat-icon').trigger('click');
            if($('.nasa-header-sticky').length <= 0 || ($('.sticky-wrapper').length && !$('.sticky-wrapper').hasClass('fixed-already'))) {
                $('html, body').animate({scrollTop: 0}, 700);
            }
        }
        
        initTopCategoriesFilter($);
    });
    
    $('body').on('click', '.nasa-top-row-filter a.nasa-tab-filter-topbar', function() {
        var _this = $(this);
        topFilterClick($, _this, 'animate');
    });
    
    $('body').on('click', '.nasa-ignore-variation-item', function() {
        var term_id = $(this).attr('data-term_id');
        if($('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').length > 0) {
            if($('.nasa-has-filter-ajax').length < 1){
                window.location.href = $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').attr('href');
            } else {
                $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').trigger('click');
            }
        }
    });
}

if($('.nasa-top-sidebar-2').length > 0) {
    initNasaTopSidebar2($);
    
    $('body').on('click', '.nasa-toggle-top-bar-click', function() {
        var _this = $(this);
        topFilterClick2($, _this, 'animate');
    });
}

// Next | Prev slider
if(typeof nasa_next_prev === 'undefined') {
    $('body').on('click', '.nasa-nav-icon-slider', function(){
        var _this = $(this);
        var _wrap = $(_this).parents('.nasa-nav-carousel-wrap');
        var _do = $(_this).attr('data-do');
        var _id = $(_wrap).attr('data-id');
        if ($(_id).length === 1) {
            switch (_do) {
                case 'next':
                    $(_id).find('.owl-nav .owl-next').trigger('click');
                    break;
                case 'prev':
                    $(_id).find('.owl-nav .owl-prev').trigger('click');
                    break;
                default: break;
            }
        }
    });
}
/*
 * Init nasa git featured
 */
initThemeNasaGiftFeatured($);

/*
 * Event nasa git featured
 */
$('body').on('click', '.nasa-gift-featured-event', function() {
    var _wrap = $(this).parents('.product-item');
    if($(_wrap).find('.nasa-product-grid .btn-combo-link').length === 1) {
        $(_wrap).find('.nasa-product-grid .btn-combo-link').trigger('click');
    } else {
        if($(_wrap).find('.nasa-product-list .btn-combo-link').length === 1) {
            $(_wrap).find('.nasa-product-list .btn-combo-link').trigger('click');
        }
    }
});

/**
 * Carousel combo gift product single summary
 */
if($('.nasa-content-combo-gift .nasa-combo-slider').length > 0) {
    var _carousel = $('.nasa-content-combo-gift .nasa-combo-slider');
    loadCarouselCombo($, _carousel, 4);
}

/**
 * static-block-wrapper => SUPPORT
 */
if($('.site-header .static-block-wrapper').find('.support-show').length === 1) {
    $('body').on('click', '.site-header .static-block-wrapper .support-show', function() {
        if($('.site-header .static-block-wrapper').find('.nasa-transparent-topbar').length <= 0) {
            $('.site-header .static-block-wrapper').append('<div class="nasa-transparent-topbar"></div>');
        }
        
        if($('.site-header .static-block-wrapper').find('.support-hide').length === 1) {
            if(!$('.site-header .static-block-wrapper .support-hide').hasClass('active')) {
                $('.static-block-wrapper .support-hide').addClass('active').fadeIn(300);
                $('.site-header .static-block-wrapper .nasa-transparent-topbar').show();
            } else {
                $('.static-block-wrapper .support-hide').removeClass('active').fadeOut(300);
                $('.site-header .static-block-wrapper .nasa-transparent-topbar').hide();
            }
        }
    });
    
    $('body').on('click', '.site-header .static-block-wrapper .nasa-transparent-topbar', function() {
        $('.static-block-wrapper .support-hide').removeClass('active').fadeOut(300);
        $('.site-header .static-block-wrapper .nasa-transparent-topbar').hide();
    });
}

/**
 * Change language
 */
if($('.nasa-current-lang').length) {
    $('body').on(_event, '.nasa-current-lang', function() {
        var _wrap = $(this).parents('.nasa-select-languages');
        if ($(_wrap).length) {
            if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
                if ($('.static-position').find('.transparent-desktop').length === 0) {
                    $('.static-position').append('<div class="transparent-desktop"></div>');
                }
                
                $('.transparent-desktop').fadeIn(200);
            }
            $(_wrap).toggleClass('nasa-active');
            $('.nasa-select-currencies').removeClass('nasa-active');
        }
        
        return false;
    });
}

/**
 * Change Currencies
 */
if($('.wcml-cs-item-toggle').length) {
    $('body').on(_event, '.wcml-cs-item-toggle', function() {
        var _wrap = $(this).parents('.nasa-select-currencies');
        if ($(_wrap).length) {
            if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
                if ($('.static-position').find('.transparent-desktop').length === 0) {
                    $('.static-position').append('<div class="transparent-desktop"></div>');
                }
                
                $('.transparent-desktop').fadeIn(200);
            }
            $(_wrap).toggleClass('nasa-active');
            $('.nasa-select-languages').removeClass('nasa-active');
        }
        
        return false;
    });
}

/**
 * Tab reviewes
 */
var _scrollFirst = false;
$('body').on(_event, '.nasa-product-details-page .woocommerce-review-link', function() {
    if (
        $('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab > a').length === 1 ||
        $('.nasa-product-details-page .product-details .nasa-accordions-content .nasa-accordion-reviews').length === 1
    ) {
        var _obj = $('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab > a');
        if ($(_obj).length <= 0) {
            _obj = $('.nasa-product-details-page .product-details .nasa-accordions-content .nasa-accordion-reviews');
        }
        
        if ($(_obj).length) {
            var _pos_top = $(_obj).offset().top;
            $('html, body').animate({scrollTop: (_pos_top - 200)}, 500);

            setTimeout(function () {
                if (!$(_obj).hasClass('active')) {
                    $(_obj).trigger('click');
                    $(_obj).mousemove();
                }
            }, 500);
        }
    }
    
    return false;
});

var _hash = location.hash || null;
if (_hash) {
    if ($('a[href="' + _hash + '"]').length) {
        setTimeout(function() {
            $('a[href="' + _hash + '"]').trigger(_event);
        }, 500);
    }
    
    if ($(_hash).length) {
        setTimeout(function() {
            if (!_scrollFirst) {
                var _pos_top = $(_hash).offset().top;
                $('html, body').animate({scrollTop: (_pos_top - 200)}, 500);
            }
        }, 1000);
    }
}

/**
 * Retina logo
 */
if($('.nasa-logo-retina').length > 0) {
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
    if(pixelRatio > 1) {
        var _image_width, _image_height;
        var _src_retina = '';
        
        var _init_retina = setInterval(function () {
            $('.nasa-logo-retina img').each(function() {
                var _this = $(this);
                
                if (!$(_this).hasClass('nasa-inited') && $(_this).width() && $(_this).height()) {
                    if(typeof _src_retina === 'undefined' || _src_retina === '') {
                        _src_retina = $(_this).attr('data-src-retina');
                    }

                    if(typeof _src_retina !== 'undefined' && _src_retina !== '') {
                        var _fix_size = $(_this).parents('.nasa-no-fix-size-retina').length === 1 ? false : true;
                        _image_width = _image_height = 'auto';

                        if(_fix_size) {
                            var _w = parseInt($(_this).attr('width'));
                            _image_width = _w ? _w : $(_this).width();

                            var _h = parseInt($(this).attr('height'));
                            _image_height = _h ? _h : $(_this).height();
                        }

                        if((_image_width && _image_height) || _image_width === 'auto') {
                            $(_this).css("width", _image_width);
                            $(_this).css("height", _image_height);

                            $(_this).attr('src', _src_retina);
                            $(_this).removeAttr('srcset');
                        }
                        
                        $(_this).addClass('nasa-inited');
                    }
                }
                
                if ($('.nasa-logo-retina img').length === $('.nasa-logo-retina img.nasa-inited').length) {
                    clearInterval(_init_retina);
                }
            });
        }, 50);
    }
}

/**
 * nasa-top-cat-filter
 */
initTopCategoriesFilter($);
hoverTopCategoriesFilter($);
hoverChilrenTopCatogoriesFilter($);
$('body').on('click', '.filter-cat-icon', function() {
    var _this_click = $(this);
    
    if(!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        $('.nasa-elements-wrap').addClass('nasa-invisible');
        $('#header-content .nasa-top-cat-filter-wrap').addClass('nasa-show');
        if($('.nasa-has-filter-ajax').length <= 0) {
            $('.header-wrapper .nasa-top-cat-filter-wrap').before('<div class="nasa-tranparent-filter nasa-hide-for-mobile" />');
        }
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
    }
});

$('body').on('click', '.filter-cat-icon-mobile', function() {
    var _this_click = $(this);
    var _mobileDetect = $('body').hasClass('nasa-in-mobile') || $('input[name="nasa_mobile_layout"]').length ? true : false;
    
    if(!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        $('.nasa-top-cat-filter-wrap-mobile').addClass('nasa-show');
        $('.transparent-mobile').fadeIn(300);
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
        
        var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        
        if ((_mobileView || _mobileDetect) && $('.nasa-top-cat-filter-wrap-mobile').find('.nasa-top-cat-filter').length <= 0) {
            if ($('#nasa-main-cat-filter').length && $('#nasa-mobile-cat-filter').length) {
                var _mobile_cats_filter = $('#nasa-main-cat-filter').clone().html();
                $('#nasa-mobile-cat-filter').html(_mobile_cats_filter);
                
                if (_mobileDetect) {
                    $('#nasa-main-cat-filter').remove();
                }
            }
        }
    }
});

$('body').on('click', '.nasa-close-filter-cat, .nasa-tranparent-filter', function(){
    $('.nasa-elements-wrap').removeClass('nasa-invisible');
    $('#header-content .nasa-top-cat-filter-wrap').removeClass('nasa-show');
    $('.nasa-tranparent-filter').remove();
});

/**
 * Show coupon in shopping cart
 */
$('body').on('click', '.nasa-show-coupon', function() {
    if($('.nasa-coupon-wrap').length === 1) {
        $('.nasa-coupon-wrap').toggleClass('nasa-active');
        setTimeout(function() {
            $('.nasa-coupon-wrap.nasa-active input[name="coupon_code"]').focus();
        }, 100);
    }
});

/**
 * Clone group btn for list layout
 */
cloneGroupBtnsProductItem($);

/**
 * Scroll single product
 */
loadScrollSingleProduct($);

/**
 * nasa-products-masonry-isotope
 */
loadProductsMasonryIsotope($, false, true);

/**
 * nasa-posts-masonry-isotope
 */
loadPostsMasonryIsotope($);

/**
 * init wishlist icon
 */
initWishlistIcons($);

/**
 * init Compare icons
 */
initCompareIcons($);

/**
 * Topbar toggle
 */
if($('.nasa-topbar-wrap.nasa-topbar-toggle').length) {
    $('body').on('click', '.nasa-topbar-wrap .nasa-icon-toggle', function() {
        var _wrap = $(this).parents('.nasa-topbar-wrap');
        $(_wrap).toggleClass('nasa-topbar-hide');
    });
}

$('body').on('click', '.black-window-mobile', function() {
    $(this).removeClass('nasa-push-cat-show');
    $('.nasa-push-cat-filter').removeClass('nasa-push-cat-show');
    $('.nasa-products-page-wrap').removeClass('nasa-push-cat-show');
});

$('body').on('click', '.nasa-widget-show-more a.nasa-widget-toggle-show', function() {
    var _showed = $(this).attr('data-show');
    var _text = '';
    
    if(_showed === '0') {
        _text = $('input[name="nasa-widget-show-less-text"]').length ? $('input[name="nasa-widget-show-less-text"]').val() : 'Less -';
        $(this).attr('data-show', '1');
        $('.nasa-widget-toggle.nasa-widget-show-less').addClass('nasa-widget-show');
    } else {
        _text = $('input[name="nasa-widget-show-more-text"]').length ? $('input[name="nasa-widget-show-more-text"]').val() : 'More +';
        $(this).attr('data-show', '0');
        $('.nasa-widget-toggle.nasa-widget-show-less').removeClass('nasa-widget-show');
    }
    
    $(this).html(_text);
});

$('body').on('click', '.nasa-mobile-icons-wrap .nasa-toggle-mobile_icons', function() {
    $(this).parents('.nasa-mobile-icons-wrap').toggleClass('nasa-hide-icons');
});

/**
 * Single Product
 * Variable change image
 */
if($('.nasa-product-details-page .nasa-gallery-variation-supported').length === 1) {
    changeGalleryVariableSingleProduct($);
} else {
    /**
     * Load single product image
     */
    loadSlickSingleProduct($);
    /* Product Gallery Popup */
    loadGalleryPopup($);
    changeImageVariableSingleProduct($);
}

/* Product Gallery Popup */
$('body').on('click', '.product-lightbox-btn', function(e){
    if ($('.nasa-single-product-slide').length > 0) {
        $('.product-images-slider').find('.slick-current.slick-active a').trigger('click');
    }

    else if ($('.nasa-single-product-scroll').length > 0) {
        $('#nasa-main-image-0 a').trigger('click');
    }

    e.preventDefault();
});

/* Product Video Popup */
$('body').on('click', "a.product-video-popup", function(e){
    if (! $('body').hasClass('nasa-disable-lightbox-image')) {
        $('.product-images-slider').find('.first a').trigger('click');
        var galeryPopup = $.magnificPopup.instance;
        galeryPopup.prev();
    }
    
    else {
        var productVideo = $(this).attr('href');
        $.magnificPopup.open({
            items: {
                src: productVideo
            },
            type: 'iframe',
            tLoading: '<div class="nasa-loader"></div>'
        }, 0);
    }
    
    e.preventDefault();
});

/**
 * Fixed Single form add to cart
 */
if (
    $('input[name="nasa_fixed_single_add_to_cart"]').length && 
    $('.nasa-product-details-page').length
) {
    var _mobile_fixed_addToCart = 'no';
    if ($('input[name="nasa_fixed_mobile_single_add_to_cart_layout"]').length) {
        _mobile_fixed_addToCart = $('input[name="nasa_fixed_mobile_single_add_to_cart_layout"]').val();
    }
    var _can_render = true;
    if (_nasa_in_mobile && (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn')) {
        _can_render = false;
        $('body').addClass('nasa-cart-fixed-desktop');
    }
    if (_mobile_fixed_addToCart === 'btn') {
        $('body').addClass('nasa-cart-fixed-mobile-btn');
        
        if ($('.nasa-buy-now').length) {
            $('body').addClass('nasa-has-buy-now');
        }
    }
    
    /**
     * Render in desktop
     */
    if(_can_render && $('.nasa-add-to-cart-fixed').length <= 0) {
        $('body').append('<div class="nasa-add-to-cart-fixed"><div class="nasa-wrap-content-inner"><div class="nasa-wrap-content"></div></div></div>');

        if (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn') {
            $('.nasa-add-to-cart-fixed').addClass('nasa-not-show-mobile');
            $('body').addClass('nasa-cart-fixed-desktop');
        }

        var _addToCartWrap = $('.nasa-add-to-cart-fixed .nasa-wrap-content');

        /**
         * Main Image clone
         */
        $(_addToCartWrap).append('<div class="nasa-fixed-product-info"></div>');

        if($('.nasa-product-details-page .product-thumbnails').length) {
            var _src = $('.nasa-product-details-page .product-thumbnails .nasa-wrap-item-thumb:eq(0)').attr('data-thumb_org') || $('.nasa-product-details-page .product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src');

            $('.nasa-fixed-product-info').append('<div class="nasa-thumb-clone"><img src="' + _src + '" /></div>');
        }

        /**
         * Title clone
         */
        if($('.nasa-product-details-page .product-info .product_title').length) {
            var _title = $('.nasa-product-details-page .product-info .product_title').html();

            $('.nasa-fixed-product-info').append('<div class="nasa-title-clone"><h3>' + _title +'</h3></div>');
        }

        /**
         * Price clone
         */
        if($('.nasa-product-details-page .product-info .price').length) {
            var _price = $('.nasa-product-details-page .product-info .price').html();
            if($('.nasa-title-clone').length) {
                $('.nasa-title-clone').append('<span class="price">' + _price + '</span>');
            }
            else {
                $('.nasa-fixed-product-info').append('<div class="nasa-title-clone"><span class="price">' + _price + '</span></div>');
            }
        }

        /**
         * Variations clone
         */
        if($('.nasa-product-details-page .variations_form').length) {
            $(_addToCartWrap).append('<div class="nasa-fixed-product-variations-wrap"><div class="nasa-fixed-product-variations"></div><a class="nasa-close-wrap" href="javascript:void(0);"></a></div>');

            /**
             * Variations
             * 
             * @type type
             */
            var _k = 1,
                _item = 1;
            $('.nasa-product-details-page .variations_form .variations tr').each(function() {
                var _this = $(this);
                var _classWrap = 'nasa-attr-wrap-' + _k.toString();
                var _type = $(_this).find('select').attr('data-attribute_name') || $(_this).find('select').attr('name');

                if($(_this).find('.nasa-attr-ux_wrap').length) {
                    $('.nasa-fixed-product-variations').append('<div class="nasa-attr-ux_wrap-clone ' + _classWrap + '"></div>');

                    $(_this).find('.nasa-attr-ux').each(function () {
                        var _obj = $(this);
                        var _classItem = 'nasa-attr-ux-' + _item.toString();
                        var _classItemClone = 'nasa-attr-ux-clone-' + _item.toString();
                        var _classItemClone_target = _classItemClone;

                        if($(_obj).hasClass('nasa-attr-ux-image')) {
                            _classItemClone += ' nasa-attr-ux-image-clone';
                        }

                        if($(_obj).hasClass('nasa-attr-ux-color')) {
                            _classItemClone += ' nasa-attr-ux-color-clone';
                        }

                        if($(_obj).hasClass('nasa-attr-ux-label')) {
                            _classItemClone += ' nasa-attr-ux-label-clone';
                        }

                        var _selected = $(_obj).hasClass('selected') ? ' selected' : '';
                        var _contentItem = $(_obj).html();

                        $(_obj).addClass(_classItem);
                        $(_obj).attr('data-target', '.' + _classItemClone_target);

                        $('.nasa-attr-ux_wrap-clone.' + _classWrap).append('<a href="javascript:void(0);" class="nasa-attr-ux-clone' + _selected + ' ' + _classItemClone + ' nasa-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</a>');

                        _item++;
                    });
                } else {
                    $('.nasa-fixed-product-variations').append('<div class="nasa-attr-select_wrap-clone ' + _classWrap + '"></div>');

                    var _obj = $(_this).find('select');

                    var _label = $(_this).find('.label').length ? $(_this).find('.label').html() : '';

                    var _classItem = 'nasa-attr-select-' + _item.toString();
                    var _classItemClone = 'nasa-attr-select-clone-' + _item.toString();

                    var _contentItem = $(_obj).html();

                    $(_obj).addClass(_classItem).addClass('nasa-attr-select');
                    $(_obj).attr('data-target', '.' + _classItemClone);

                    $('.nasa-attr-select_wrap-clone.' + _classWrap).append(_label + '<select name="' + _type + '" class="nasa-attr-select-clone ' + _classItemClone + ' nasa-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</select>');

                    _item++;
                }

                _k++;
            });
        }
        /**
         * Class wrap simple product
         */
        else {
            $(_addToCartWrap).addClass('nasa-fixed-single-simple');
        }

        /**
         * Add to cart button
         */
        setTimeout(function() {
            var _button_wrap = nasa_clone_add_to_cart($);
            $(_addToCartWrap).append('<div class="nasa-fixed-product-btn"></div>');
            $('.nasa-fixed-product-btn').html(_button_wrap);
            var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
            $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
        }, 250);

        setTimeout(function() {
            if($('.nasa-attr-ux').length) {
                $('.nasa-attr-ux').each(function() {
                    var _this = $(this);
                    var _targetThis = $(_this).attr('data-target');

                    if($(_targetThis).length) {
                        var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                        if(_disable) {
                            if(!$(_targetThis).hasClass('nasa-disable')) {
                                $(_targetThis).addClass('nasa-disable');
                            }
                        } else {
                            $(_targetThis).removeClass('nasa-disable');
                        }
                    }
                });
            }
        }, 550);

        /**
         * Change Ux
         */
        $('body').on('click', '.nasa-attr-ux', function() {
            var _target = $(this).attr('data-target');
            if($(_target).length) {
                var _wrap = $(_target).parents('.nasa-attr-ux_wrap-clone');
                $(_wrap).find('.nasa-attr-ux-clone').removeClass('selected');
                if($(this).hasClass('selected')) {
                    $(_target).addClass('selected');
                }

                if($('.nasa-fixed-product-btn').length) {
                    setTimeout(function() {
                        var _button_wrap = nasa_clone_add_to_cart($);
                        $('.nasa-fixed-product-btn').html(_button_wrap);
                        var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                        $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
                    }, 250);
                }

                setTimeout(function() {
                    if($('.nasa-attr-ux').length) {
                        $('.nasa-attr-ux').each(function() {
                            var _this = $(this);
                            var _targetThis = $(_this).attr('data-target');

                            if($(_targetThis).length) {
                                var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                                if(_disable) {
                                    if(!$(_targetThis).hasClass('nasa-disable')) {
                                        $(_targetThis).addClass('nasa-disable');
                                    }
                                } else {
                                    $(_targetThis).removeClass('nasa-disable');
                                }
                            }
                        });
                    }
                }, 250);
            }
        });

        /**
         * Change Ux clone
         */
        $('body').on('click', '.nasa-attr-ux-clone', function() {
            var _target = $(this).attr('data-target');
            if($(_target).length) {
                $(_target).trigger('click');
            }
        });

        /**
         * Change select
         */
        $('body').on('change', '.nasa-attr-select', function() {
            var _this = $(this);
            var _target = $(_this).attr('data-target');
            var _value = $(_this).val();

            if($(_target).length) {
                setTimeout(function() {
                    var _html = $(_this).html();
                    $(_target).html(_html);
                    $(_target).val(_value);
                }, 100);

                setTimeout(function() {
                    var _button_wrap = nasa_clone_add_to_cart($);
                    $('.nasa-fixed-product-btn').html(_button_wrap);
                    var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                    $('.nasa-single-btn-clone input[name="quantity"]').val(_val);

                    if($('.nasa-attr-ux').length) {
                        $('.nasa-attr-ux').each(function() {
                            var _this = $(this);
                            var _targetThis = $(_this).attr('data-target');

                            if($(_targetThis).length) {
                                var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                                if(_disable) {
                                    if(!$(_targetThis).hasClass('nasa-disable')) {
                                        $(_targetThis).addClass('nasa-disable');
                                    }
                                } else {
                                    $(_targetThis).removeClass('nasa-disable');
                                }
                            }
                        });
                    }
                }, 250);
            }
        });

        /**
         * Change select clone
         */
        $('body').on('change', '.nasa-attr-select-clone', function() {
            var _target = $(this).attr('data-target');
            var _value = $(this).val();
            if($(_target).length) {
                $(_target).val(_value).change();
            }
        });

        /**
         * Reset variations
         */
        $('body').on('click', '.reset_variations', function() {
            $(_addToCartWrap).find('.selected').removeClass('selected');

            setTimeout(function() {
                var _button_wrap = nasa_clone_add_to_cart($);
                $('.nasa-fixed-product-btn').html(_button_wrap);
                var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                $('.nasa-single-btn-clone input[name="quantity"]').val(_val);

                if($('.nasa-attr-ux').length) {
                    $('.nasa-attr-ux').each(function() {
                        var _this = $(this);
                        var _targetThis = $(_this).attr('data-target');

                        if($(_targetThis).length) {
                            var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                            if(_disable) {
                                if(!$(_targetThis).hasClass('nasa-disable')) {
                                    $(_targetThis).addClass('nasa-disable');
                                }
                            } else {
                                $(_targetThis).removeClass('nasa-disable');
                            }
                        }
                    });
                }
            }, 250);
        });

        /**
         * Plus, Minus button
         */
        $('body').on('click', '.nasa-product-details-page form.cart .quantity .plus, .nasa-product-details-page form.cart .quantity .minus', function() {
            if($('.nasa-single-btn-clone input[name="quantity"]').length) {
                var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
            }
        });

        /**
         * Plus clone button
         */
        $('body').on('click', '.nasa-single-btn-clone .plus', function() {
            if($('.nasa-product-details-page form.cart .quantity .plus').length) {
                $('.nasa-product-details-page form.cart .quantity .plus').trigger('click');
            }
        });

        /**
         * Minus clone button
         */
        $('body').on('click', '.nasa-single-btn-clone .minus', function() {
            if($('.nasa-product-details-page form.cart .quantity .minus').length) {
                $('.nasa-product-details-page form.cart .quantity .minus').trigger('click');
            }
        });

        /**
         * Quantily input
         */
        $('body').on('keyup', '.nasa-product-details-page form.cart input[name="quantity"]', function() {
            var _val = $(this).val();
            $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
        });

        /**
         * Quantily input clone
         */
        $('body').on('keyup', '.nasa-single-btn-clone input[name="quantity"]', function() {
            var _val = $(this).val();
            $('.nasa-product-details-page form.cart input[name="quantity"]').val(_val);
        });

        /**
         * Add to cart click
         */
        $('body').on('click', '.nasa-single-btn-clone .single_add_to_cart_button', function(){
            if($('.nasa-product-details-page form.cart .single_add_to_cart_button').length) {
                $('.nasa-product-details-page form.cart .single_add_to_cart_button').trigger('click');
            }
        });

        /**
         * Toggle Select Options
         */
        $('body').on(_event, '.nasa-toggle-variation_wrap-clone', function() {
            if ($('.nasa-fixed-product-variations-wrap').length) {
                $('.nasa-fixed-product-variations-wrap').toggleClass('nasa-active');
            }
        });
        $('body').on(_event, '.nasa-close-wrap', function() {
            if ($('.nasa-fixed-product-variations-wrap').length) {
                $('.nasa-fixed-product-variations-wrap').removeClass('nasa-active');
            }
        });
    }
}

/**
 * Buy Now
 */
$('body').on('click', '.nasa-buy-now', function() {
    if(!$(this).hasClass('nasa-waiting')) {
        $(this).addClass('nasa-waiting');
        
        var _form = $(this).parents('form.cart');
        if($(_form).find('.single_add_to_cart_button.disabled').length) {
            $(_form).find('.single_add_to_cart_button.disabled').trigger('click');
            $(this).removeClass('nasa-waiting');
        } else {
            if($(_form).find('input[name="nasa_buy_now"]').length) {
                if($('input[name="nasa-enable-addtocart-ajax"]').length) {
                    $('input[name="nasa-enable-addtocart-ajax"]').val('0');
                }
                $(_form).find('input[name="nasa_buy_now"]').val('1');
                $(_form).find('.single_add_to_cart_button').trigger('click');
            }
        }
    }
    
    return false;
});

/**
 * Check accessories product
 */
$('body').on('change', '.nasa-check-accessories-product', function () {
    var _urlAjax = null;
    if(
        typeof wc_add_to_cart_params !== 'undefined' &&
        typeof wc_add_to_cart_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_refresh_accessories_price');
    }
    
    if(_urlAjax) {
        var _this = $(this);
        
        var _wrap = $(_this).parents('.nasa-accessories-check');

        var _id = $(_this).val();
        var _isChecked = $(_this).is(':checked');
        
        var _price = $(_wrap).find('.nasa-check-main-product').length ? parseInt($(_wrap).find('.nasa-check-main-product').attr('data-price')) : 0;
        if ($(_wrap).find('.nasa-check-accessories-product').length) {
            $(_wrap).find('.nasa-check-accessories-product').each(function() {
                if($(this).is(':checked')) {
                    _price += parseInt($(this).attr('data-price'));
                }
            });
        }
        
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                total_price: _price
            },
            beforeSend: function () {
                $(_wrap).append('<div class="nasa-disable-wrap"></div><div class="nasa-loader"></div>');
            },
            success: function (res) {
                if (typeof res.total_price !== 'undefined') {
                    $('.nasa-accessories-total-price .price').html(res.total_price);
                    
                    if (!_isChecked) {
                        $('.nasa-accessories-' + _id).fadeOut(200);
                    } else {
                        $('.nasa-accessories-' + _id).fadeIn(200);
                    }
                }

                $(_wrap).find('.nasa-loader, .nasa-disable-wrap').remove();
            },
            error: function () {

            }
        });
    }
});

/**
 * Add To cart accessories
 */
$('body').on('click', '.add_to_cart_accessories', function() {
    var _urlAjax = null;
    if(
        typeof wc_add_to_cart_params !== 'undefined' &&
        typeof wc_add_to_cart_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_add_to_cart_accessories');
    }
    
    if(_urlAjax) {
        var _this = $(this);
        
        var _wrap = $(_this).parents('#nasa-tab-accessories_content');
        if ($(_wrap).length <= 0) {
            _wrap = $(_this).parents('#nasa-secion-accordion-accessories_content');
        }
        if ($(_wrap).length) {
            var _wrapCheck = $(_wrap).find('.nasa-accessories-check');

            if ($(_wrapCheck).length) {
                var _pid = [];

                // nasa-check-main-product
                if ($(_wrapCheck).find('.nasa-check-main-product').length) {
                    _pid.push($(_wrapCheck).find('.nasa-check-main-product').val());
                }

                // nasa-check-accessories-product
                if ($(_wrapCheck).find('.nasa-check-accessories-product').length) {
                    $(_wrapCheck).find('.nasa-check-accessories-product').each(function() {
                        if($(this).is(':checked')) {
                            _pid.push($(this).val());
                        }
                    });
                }

                if (_pid.length) {
                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            product_ids: _pid
                        },
                        beforeSend: function () {
                            $('.nasa-message-error').hide();
                            $(_wrap).append('<div class="nasa-disable-wrap"></div><div class="nasa-loader"></div>');
                        },
                        success: function (data) {
                            if (data && data.fragments) {
                                $.each(data.fragments, function(key, value) {
                                    $(key).replaceWith(value);
                                });

                                $('.cart-link').trigger('click');
                            } else {
                                if (data && data.error) {
                                    $('.nasa-message-error').html(data.message);
                                    $('.nasa-message-error').show();
                                }
                            }

                            $(_wrap).find('.nasa-loader, .nasa-disable-wrap').remove();
                        },
                        error: function () {

                        }
                    });
                }
            }
        }
    }
    
    return false;
});

/**
 * Lightbox image Single product page
 */
$('body').on('click', '.easyzoom-flyout', function() {
    if (!$('body').hasClass('nasa-disable-lightbox-image')) {
        var _click = $(this).parents('.easyzoom');
        if ($(_click).length && $(_click).find('a.product-image').length) {
            $(_click).find('a.product-image').trigger('click');
        }
    }
});

/**
 * Notice Woocommerce
 */
if (!$('body').hasClass('woocommerce-cart')) {
    $('.woocommerce-notices-wrapper').each(function() {
        var _this = $(this);
        setTimeout(function() {
            if ($(_this).find('a').length <= 0) {
                $(_this).html('');
            }
        }, 3000);
    });
    
    $('body').on(_event, '.woocommerce-notices-wrapper', function() {
        $('.woocommerce-notices-wrapper').html('');
    });
}

var _toggle = $('input[name="nasa-toggle-width-product-content"]').length ? parseInt($('input[name="nasa-toggle-width-product-content"]').val()) : 180;
$('body').on('mouseover', '.product-item', function() {
    var _this = $(this);
    if ($(_this).outerWidth() < _toggle) {
        if (
            $(_this).find('.add-to-cart-btn').length &&
            !$(_this).find('.add-to-cart-btn').hasClass('nasa-disabled-hover')
        ) {
            $(_this).find('.add-to-cart-btn').addClass('nasa-disabled-hover');
        }
        
        if (
            $(_this).find('.nasa-sc-pdeal-countdown')  &&
            !$(_this).find('.nasa-sc-pdeal-countdown').hasClass('nasa-countdown-small')) {
            $(_this).find('.nasa-sc-pdeal-countdown').addClass('nasa-countdown-small')
        }
    } else {
        if ($(_this).find('.add-to-cart-btn').length) {
            $(_this).find('.add-to-cart-btn').removeClass('nasa-disabled-hover');
        }
        
        if ($(_this).find('.nasa-sc-pdeal-countdown')) {
            $(_this).find('.nasa-sc-pdeal-countdown').removeClass('nasa-countdown-small');
        }
    }
});

/**
 * Bar icons bottom in mobile detect
 */
if ($('.nasa-bottom-bar-icons').length) {
    if ($('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').length) {
        $('.nasa-bot-item.nasa-bot-item-sidebar').removeClass('hidden-tag');
    } else {
        $('.nasa-bot-item.nasa-bot-item-search').removeClass('hidden-tag');
    }
    
    $('.nasa-bottom-bar-icons').addClass('nasa-active');
    
    $('body').css({'padding-bottom': $('.nasa-bottom-bar-icons').outerHeight()});
    
    $('body').on('click', '.nasa-bot-icon-sidebar', function() {
        $('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').trigger('click');
    });
}

/**
 * init Select2
 */
init_select2($);

/**
 * notification free shipping
 */
init_shipping_free_notification($);

/* End Document Ready */
});
