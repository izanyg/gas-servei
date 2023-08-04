jQuery(function($) {

    "use strict";

    var uniqId = (function() {
        var i = 0;
        return function() {
            return i++;
        }
    })();

    // Add fresco to galleries
    $(".wp-block-gallery").each(function() {

        var that = $(this);

        that.attr('id', 'gallery-' + uniqId());

        that.find('.blocks-gallery-item').each(function() {

            var this_gallery_item = $(this);

            var item_link = this_gallery_item.find('a').attr('href');

            if (item_link) {

                item_link = item_link.split('.').pop();

                if (item_link && (typeof item_link === 'string') && (item_link == 'jpg' || item_link == 'jpeg' || item_link == 'png' || item_link == 'gif')) {

                    this_gallery_item.find('a').addClass('fresco');

                    this_gallery_item.find('.fresco').attr('data-fresco-group', that.attr('id'));

                    if (this_gallery_item.find('figcaption').length > 0) {
                        this_gallery_item.find('.fresco').attr('data-fresco-caption', this_gallery_item.find('figcaption').text());
                    }
                }
            }
        });
    });
});
jQuery(function($) {

    "use strict";

    // RTL fix for wpbakery full width elements position
    $(window).on('resize', function() {
        if ($('body').hasClass("rtl")) {
            var $elements = $('[data-vc-full-width="true"]');
            $.each($elements, function() {
                var $el = jQuery(this);
                var $el_right = parseInt($el.css('right'));
                $el.css('right', -$el_right);
            });
        }
    });

    //product animation (thanks Sam Sehnert)

    $.fn.visible = function(partial) {

        var $t = $(this),
            $w = $(window),
            viewTop = $w.scrollTop(),
            viewBottom = viewTop + $w.height(),
            _top = $t.offset().top,
            _bottom = _top + $t.height(),
            compareTop = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

    //if is visible on screen add a class
    $("section.related").each(function(i, el) {
        if ($(el).visible(true)) {
            $(el).addClass("on_screen");
        }
    });

    //mobile menu
    $(".mobile-navigation .menu-item-has-children .sub-menu").before('<div class="more"><span class="spk-icon-down-small"></span></div>');

    $(".mobile-navigation").on("click", ".more", function(e) {
        e.stopPropagation();

        var submenus = $(this).parent().find(".sub-menu");
        $.each(submenus, function(x, y) {
            $(y).find(".sub-menu").addClass("open");
            $(y).find(".more").remove();
        });

        $(this).parent().toggleClass("current")
            .children(".sub-menu").toggleClass("open");

        $(this).parent().find('.more').html($(this).parent().find('.more').html() == '<span class="spk-icon-down-small"></span>' ? '<span class="spk-icon-up-small"></span>' : '<span class="spk-icon-down-small"></span>');
    });

    $(".mobile-navigation").on("click", "a", function(e) {
        if ($(this).attr('href') == '#' && $(this).parent('.menu-item').hasClass('menu-item-has-children')) {
            $(this).parent().find('.more').trigger('click');
        } else if ($(this).attr('href').indexOf('#') > -1) {
            $('#offCanvasRight1').foundation('close');
        }
    });

    function replace_img_source(selector) {
        var data_src = $(selector).attr('data-src');
        $(selector).one('load', function() {}).each(function() {
            $(selector).attr('src', data_src);
            $(selector).css("opacity", "1");
        });
    }

    $('#products-grid li img').each(function() {
        replace_img_source(this);
    });

    $('.related.products li img').each(function() {
        replace_img_source(this);
    });

    $('.upsells.products li img').each(function() {
        replace_img_source(this);
    });

    $('.add_to_cart_button').on('click', function() {
        $(this).parents('li.animate').addClass('product_added_to_cart')
    })

    $('.add_to_wishlist').on('click', function() {
        $(this).parents('.yith-wcwl-add-button').addClass('show_overlay');
    })

    // Login/register
    var account_tab_list = $('.account-tab-list');

    account_tab_list.on('click', '.account-tab-link', function() {

        if ($('.account-tab-link').hasClass('registration_disabled')) {
            return false;
        } else {

            var that = $(this),
                target = that.attr('href');

            that.parent().siblings().find('.account-tab-link').removeClass('current');
            that.addClass('current');

            $('.account-forms').find($(target)).siblings().stop().fadeOut(function() {
                $('.account-forms').find($(target)).fadeIn();
            });

            return false;
        }
    });

    // Login/register mobile
    $('.account-tab-link-register').on('click', function() {
        $('.login-form').stop().fadeOut(function() {
            $('.register-form').fadeIn();
        })
        return false;
    })

    $('.account-tab-link-login').on('click', function() {
        $('.register-form').stop().fadeOut(function() {
            $('.login-form').fadeIn();
        })
        return false;
    })

    // Disable fresco
    function disable_fresco() {

        if (getbowtied_scripts_vars.product_lightbox != 1) {

            $(".product-images-layout .fresco, .product-images-layout-mobile .fresco, .woocommerce-product-gallery__wrapper .fresco").on('click', function() {
                return false;
            });
        }
    }

    disable_fresco();


    //add fresco groups to images galleries
    $(".gallery").each(function() {

        var that = $(this);

        that.find('.gallery-item').each(function() {

            var this_gallery_item = $(this);

            this_gallery_item.find('.fresco').attr('data-fresco-group', that.attr('id'));

            if (this_gallery_item.find('.gallery-caption').length > 0) {
                this_gallery_item.find('.fresco').attr('data-fresco-caption', this_gallery_item.find('.gallery-caption').text());
            }

        });

    });

    function handleSelect() {
        if (typeof $.fn.selectWoo === 'function') {
            $('.woocommerce-ordering select.orderby').selectWoo({
                minimumResultsForSearch: Infinity,
                // allowClear: true,
                // width: 'auto',
                dropdownCssClass: "orderby-dropdown",
                // dropdownAutoWidth: true
            });
        }
    }

    handleSelect();

    //gallery caption

    $('.gallery-item').each(function() {

        var that = $(this);

        if (that.find('.gallery-caption').length > 0) {
            that.append('<span class="gallery-caption-trigger">i</span>')
        }

    })

    $('.gallery-caption-trigger').on('mouseenter', function() {
        $(this).siblings('.gallery-caption').addClass('show');
    });

    $('.gallery-caption-trigger').on('mouseleave', function() {
        $(this).siblings('.gallery-caption').removeClass('show');
    });

    $('.trigger-footer-widget').on('click', function() {

        var trigger = $(this).parent();

        trigger.fadeOut('1000', function() {
            trigger.remove();
            $('.site-footer-widget-area').fadeIn();
        });
    });

    //Language Switcher
    $('.topbar-language-switcher').on('change', function() {
        window.location = $(this).val();
    });

    setTimeout(function() {
        $(".product_thumbnail.with_second_image").css("background-size", "cover");
        $(".product_thumbnail.with_second_image").addClass("second_image_loaded");
    }, 300);

    if ($(window).outerWidth() > 1024) {
        $.stellar({
            horizontalScrolling: false,
            responsive: true
        });
    }

    setTimeout(function() {
        $('.parallax, .single-post-header-bkg').addClass('loaded');
    }, 150);

    $(window).on('resize', function() {

        $('.site-search-form-wrapper-inner, .site-search .widget_search .search-form').css('margin-left', -$(window).width() / 4);

    });

    $(window).on('scroll', function() {

        //animate products
        if ($(window).innerWidth() > 640) {
            $(".products li").each(function(i, el) {
                if ($(el).visible(true)) {
                    $(el).addClass("animate");
                }
            });
        }

        //mark this selector as visible
        $("section.related, #site-footer").each(function(i, el) {
            if ($(el).visible(true)) {
                $(el).addClass("on_screen");

            } else {
                $(el).removeClass("on_screen");

            }
        });

        //single post overlay -  only for large-up
        if ($(window).width() > 1024) {
            $('.single-post-header-overlay').css('opacity', 0.3 + ($(window).scrollTop()) / (($(window).height()) * 1.4));
        }

    });

    $('.widget_layered_nav span.count, .widget_product_categories span.count').each(function() {
        var count = $(this).html();
        count = count.substring(1, count.length - 1);
        $(this).html(count);
    })

    /******************** average rating widget ****************************/
    $('.widget_rating_filter ul li a').each(function() {
        var count = $(this).contents().filter(function() {
            return this.nodeType == 3;
        })[0].nodeValue;

        $(this).contents().filter(function() {
            return this.nodeType == 3;
        })[0].nodeValue = '';

        count = count.slice(2, -1);

        $(this).append('<span class="count">' + count + '</span>');
    })

    /********************** my account tabs by url **************************/
    if (('form#register').length > 0) {
        var hash = window.location.hash;
        if (hash) {
            $('.account-tab-link').removeClass('current');
            $('a[href="' + hash + '"]').addClass('current');

            hash = hash.substring(1);
            $('.account-forms > form').hide();
            $('form#' + hash).show();
        }
    }

    /* BACK TO TOP */
    if (getbowtied_scripts_vars.back_to_top_button && $('.progress-wrap').length > 0) {
        var progressPath = document.querySelector('.progress-wrap path');
        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
        progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
        var updateProgress = function() {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength / height);
            progressPath.style.strokeDashoffset = progress;
        }
        updateProgress();
        $(window).on('scroll', updateProgress);
        var offset = 50;
        var duration = 550;
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > offset) {
                $('.progress-wrap').addClass('active-progress');
            } else {
                $('.progress-wrap').removeClass('active-progress');
            }
        });
        $('.progress-wrap').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, duration);
            return false;
        });
    }

    // wpbakery
    function bs_fix_vc_full_width_row() {

        var elements = $('[data-vc-full-width="true"]');
        $.each(elements, function() {
            var el = jQuery(this);
            el.css('right', el.css('left')).css('left', '');
        });

    }

    // Fixes rows in RTL
    if ($('body').hasClass("rtl")) {
        $(document).on('vc-full-width-row', function() {
            bs_fix_vc_full_width_row();
        });
    }

    // Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
    if ($('body').hasClass("rtl")) {
        bs_fix_vc_full_width_row();
    }

    // Checkout expand forms
    $('.woocommerce-checkout').on('click', '.showlogin', function() {
        $('form.woocommerce-form-login').toggleClass('fade');
    });

    $('.woocommerce-checkout').on('click', '.showcoupon, .checkout_coupon_inner .button', function() {
        $('form.woocommerce-form-coupon').toggleClass('fade');
    });

    $(".vc_images_carousel").each(function() {
        var height = $(this).find(".vc_item.vc_active").height();
        $(this).css("height", height);
    });

    $(".vc_images_carousel").on('click', '.vc_right, .vc_left, .vc_carousel-indicators li', function() {

        var that = $(this);

        setTimeout(function() {
            var height = that.parents(".vc_images_carousel").find(".vc_item.vc_active").height();
            that.parents(".vc_images_carousel").css("height", height);
        }, 600);


    });

    // set focus on search input field in off-canvas
    $(document).on('click touchend', 'header .site-tools .search-button .spk-icon-search', function() {
        setTimeout(function() {
            $(".off-canvas .woocommerce-product-search .search-field").focus();
        }, 800);
    });

    // close off-canvas when 'ESC' is pressed
    $(document).on('keyup', function(event) {
        //check if user has pressed 'Esc'
        if ((event.which == '27') && ($('.off-canvas').length) && ($('.off-canvas').hasClass('is-open'))) {
            $('.off-canvas').foundation('close');
        }
    });

    // When Viewport Height is equal with 768, make the minicart image smaller
    var windowHeight = $(window).height();
    var minicart_product_img = $('.shopkeeper-mini-cart .widget.woocommerce.widget_shopping_cart .widget_shopping_cart_content .cart_list.product_list_widget li.mini_cart_item .product-item-bg');

    if (windowHeight == 768) {
        minicart_product_img.addClass('smaller-vh');
    } else {
        minicart_product_img.removeClass('smaller-vh');
    }

    // If both facebook messenger and get this theme plugins exists, make them look nice
    if ($('#fbmsg').length) {

        if ($('.getbowtied_get_this_theme').length) {
            $('#fbmsg').addClass('gbt_plugin_installed');
        } else {
            $('#fbmsg').removeClass('gbt_plugin_installed');
        }
    }

    $("body.single-product form.cart").on("change", "input.qty, input.custom-qty", function() {
        $('button.single_add_to_cart_button.ajax_add_to_cart').attr("data-quantity", this.value);
    });

    $('.cd-quick-view form.cart input[name="quantity"]').trigger('change');

    // overlay for loader on ajax add to cart and wishlist
    $('body').on("click", ".products .ajax_add_to_cart", function() {
        $(this).parents('.column').find('.product_thumbnail').prepend('<div class="overlay"></div>');
    });
    $('body').on('added_to_cart', function() {
        $('.product_thumbnail .overlay').remove();
    });

    //progress add to cart button
    $("button.single_add_to_cart_button.ajax_add_to_cart.progress-btn").on("click", function(e) {
        var progressBtn = $(this);

        if (!progressBtn.hasClass("active")) {
            progressBtn.addClass("active");
            setTimeout(function() {
                progressBtn.addClass("check");
            }, 1500);
            setTimeout(function() {
                progressBtn.removeClass("active");
                progressBtn.removeClass("check");
            }, 3500);
        }
    });

    //my account order add class to order header
    $('.woocommerce-MyAccount-content .woocommerce-order-details').siblings('p').addClass('order-info');

    $(document).foundation();
});

jQuery(function($) {

    "use strict";

    // sticky header
    if (getbowtied_scripts_vars.sticky_header) {

        var headerHeight = $('.top-headers-wrapper').length ? $('.top-headers-wrapper').outerHeight() : 0;
        var totalHeaderHeight = $('.site-header').length ? $('.site-header').outerHeight() : 0;
        if ($('#site-top-bar').length) {
            totalHeaderHeight += $('#site-top-bar').outerHeight();
        }

        $(window).on('scroll', function() {
            if (getbowtied_scripts_vars.mobile_sticky_header || ($(window).width() >= 1024)) {
                var that = $('.site-header-sticky');

                if ($(this).scrollTop() > totalHeaderHeight && !that.hasClass('sticky')) {
                    that.hide();
                    setTimeout(function() {
                        that.show();
                    }, 100);
                    $('.st-content').css('padding-top', headerHeight);
                    that.addClass('sticky');
                } else if ($(this).scrollTop() <= totalHeaderHeight) {
                    that.removeClass('sticky');
                    $('.st-content').css('padding-top', '');
                }
            }
        });
    }

    // menu dropdown apply scrollbar when longer than the screen
    if ($('.site-header .main-navigation').length && $('.site-header .main-navigation > ul > li > .sub-menu').length) {
        var menu_height = $(window).height() - $('.site-header .main-navigation > ul > li > .sub-menu').offset().top;
        $('.site-header .main-navigation > ul > li > .sub-menu').each(function() {
            if ($(this).outerHeight() > menu_height) {
                $(this).css({ 'max-height': menu_height - 100, 'overflow-y': 'auto' });
            }
        });
    }

    // adjust dropdowns' position to avoid offscreen display
    function adjust_dropdown_position() {
        if ($(window).width() >= 1024) {
            $('.top-headers-wrapper .main-navigation > ul li.menu-item-has-children').each(function() {

                var submenuWidth = $(this).find('> .sub-menu').outerWidth();

                var submenuOffset = $(this).find('> .sub-menu').offset().left;
                var totalSubMenuWidth = submenuWidth + submenuOffset;
                if ((totalSubMenuWidth - $(window).width()) > 0) {
                    if ($(this).hasClass('mega-menu')) {
                        var position = totalSubMenuWidth - $(window).width();
                        $(this).find('> .sub-menu').css('left', '-' + position + 'px');
                    } else {
                        $(this).find('> .sub-menu').addClass('reverse');
                    }
                }
            });
        } else {
            $('.top-headers-wrapper .main-navigation > ul li.menu-item-has-children').each(function() {
                $(this).children('ul').removeClass('reverse');
                if ($(this).hasClass('mega-menu')) {
                    $(this).children('ul').css('left', 0);
                }
            });
        }
    }

    adjust_dropdown_position();
    var resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        $('.top-headers-wrapper .main-navigation > ul li.menu-item-has-children.mega-menu > .sub-menu').css('left', 0);
        resizeTimer = setTimeout(function() {
            adjust_dropdown_position();
        }, 250);
    });

    // close search offcanvas
    $(document).on('click', '.site-search .close-button', function() {
        $(document).find('#offCanvasTop1').removeAttr("style");
    });

    // dropdown levels
    $('.main-navigation > ul > li').on({
        mouseenter: function() {
            $(this).addClass('active');
        },
        mouseleave: function() {
            $(this).removeClass('active');
        }
    });

    $('.main-navigation > ul > li ul li').on({
        mouseenter: function() {
            clearTimeout($(this).data('timeoutId'));
            $(this).addClass('active');
        },
        mouseleave: function() {
            var that = $(this);
            var timeoutId = setTimeout(function() {
                that.removeClass('active');
            }, 200);
            that.data('timeoutId', timeoutId);
        }
    });

});

jQuery(function($) {

    "use strict";

    // smooth transition
    if (getbowtied_scripts_vars.smooth_transition) {

        if ($('#header-loader-under-bar').length) {
            NProgress.configure({
                template: '<div class="bar" role="bar"></div>',
                parent: '#header-loader',
                showSpinner: false,
                easing: 'ease',
                minimum: 0.3,
                speed: 500,
            });
        }

        $('#st-container').addClass('fade_in').removeClass('fade_out');
        $('#header-loader-under-bar').addClass('hidden');
        NProgress.start();
        NProgress.done();

        $(window).on('beforeunload', function() {
            $('#st-container').addClass('fade_out').removeClass('fade_in');
            $('#header-loader-under-bar').removeClass('hidden');
        });
    }
});

jQuery(function($) {

    "use strict";

    var classes = $(".custom-layout .mobile_gallery .woocommerce-product-gallery").attr("class");
    var ol_classes = $(".custom-layout .mobile_gallery .flex-control-thumbs").attr("class");

    $(window).on('resize', function() {
        if ($(window).width() <= 1024) {
            $(".custom-layout .mobile_gallery > div").addClass(classes);
            $(".custom-layout .mobile_gallery ol").addClass(ol_classes);
        } else {
            $(".custom-layout .mobile_gallery .woocommerce-product-gallery").removeClass(classes);
            $(".custom-layout .mobile_gallery .flex-control-thumbs").removeClass(ol_classes);
        }
    });

    $(window).on('load', function() {
        if ($(window).width() >= 1025) {
            $(".custom-layout .mobile_gallery .woocommerce-product-gallery").removeClass(classes);
            $(".custom-layout .mobile_gallery .flex-control-thumbs").removeClass(ol_classes);
        }
    });

    // Fresco Lightbox
    if (getbowtied_scripts_vars.product_lightbox == 1) {

        // Add fresco to default gallery
        $(".product_layout_classic .woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image").each(function() {

            $(this).attr('id', 'product-gallery');
            $(this).find('a').addClass('fresco');
            $(this).find('.fresco').attr('data-fresco-group', $(this).attr('id'));
            $(this).find('.fresco').attr('data-fresco-group-options', "overflow: true, thumbnails: 'vertical', onClick: 'close'");
            $(this).find('.fresco img').addClass('fresco-img');

            if (!$(this).find('.fresco').hasClass('video')) {
                if ($(this).find('.fresco img').attr('data-caption').length > 0) {
                    $(this).find('.fresco').attr('data-fresco-caption', $(this).find('.fresco img').attr('data-caption'));
                }
            }
        });

        // Add fresco to mobile gallery
        $(".woocommerce-product-gallery__wrapper.mobile-gallery .woocommerce-product-gallery__image").each(function() {

            $(this).attr('id', 'product-mobile-gallery');
            $(this).find('a').addClass('fresco');
            $(this).find('.fresco').attr('data-fresco-group', $(this).attr('id'));
            $(this).find('.fresco').attr('data-fresco-group-options', "overflow: true, thumbnails: 'horizontal', onClick: 'close'");
            $(this).find('.fresco img').addClass('fresco-img');

            $(this).find('.fresco').each(function() {
                if ($(this).find('img').length > 0) {
                    $(this).attr('data-fresco-options', "thumbnail: '" + $(this).find('img').attr('src') + "'");
                }
            });

            if (getbowtied_scripts_vars.product_gallery_zoom) {
                $(this).find('.fresco').addClass('zoom');
            }

            if (!$(this).find('.fresco').hasClass('video')) {
                if ($(this).find('.fresco img').attr('data-caption').length > 0) {
                    $(this).find('.fresco').attr('data-fresco-caption', $(this).find('.fresco img').attr('data-caption'));
                }
            }
        });

        // Trigger fresco lightbox
        $('.product_layout_classic, .custom-layout').on('click', '.fresco-img, .zoomImg', function() {
            if ($(window).width() >= 1025) {
                $(this).siblings('.fresco').trigger('click');
            }
        });

        $('.custom-layout .easyzoom').on('click', '.easyzoom-flyout', function() {
            if ($(window).width() >= 1025) {
                $(this).siblings('.fresco.zoom').trigger('click');
            }
        });

        $('.product_layout_classic, .mobile_gallery').on('click touchend', '.mobile_gallery-zoom-button', function() {
            if ($(window).width() < 1025) {
                $(this).siblings('.woocommerce-product-gallery').find('.woocommerce-product-gallery__image.flex-active-slide .fresco').first().trigger('click');
            }
        });
    }

    // Default Gallery - Scroll thumbnails
    $(document).on('click touchend', '.product_layout_classic ol.flex-control-thumbs li img', function() {
        if ($(window).width() >= 1025) {

            var product_thumbnails = $('ol.flex-control-thumbs');
            var product_thumbnails_cells = product_thumbnails.find('li');
            var product_thumbnails_height = product_thumbnails.height();
            var product_thumbnails_cells_height = product_thumbnails_cells.length ? product_thumbnails_cells.outerHeight() : 0;
            var product_images = $('.woocommerce-product-gallery__wrapper');
            var index = $('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image.flex-active-slide').index();

            var scrollY = (index * product_thumbnails_cells_height) - ((product_thumbnails_height - product_thumbnails_cells_height) / 2) - 10;

            product_thumbnails.animate({
                scrollTop: scrollY
            }, 300);
        }
    });
});

jQuery(function($) {

    "use strict";

    //final width --> this is the quick view image slider width
    //maxQuickWidth --> this is the max-width of the quick-view panel
    var sliderFinalWidth = 480,
        maxQuickWidth = 960;

    var allowClicks = true;

    //open the quick view panel
    $(document).on('click', '.product_quickview_button', function(event) {

        event.preventDefault();

        var $this = $(this);

        $this.parent().find('.product_thumbnail').prepend('<div class="overlay"></div>');

        var product_id = $(this).data('product_id');
        var selectedImage = $(this).parents('li').find('.product_thumbnail img');

        $.ajax({
            url: getbowtied_scripts_vars.ajax_url,
            data: {
                "action": "getbowtied_product_quick_view",
                'product_id': product_id
            },
            success: function(results) {

                $('.cd-quick-view').empty().html(results);

                animateQuickView(selectedImage, sliderFinalWidth, maxQuickWidth, 'open');

                if ($('.cd-quick-view .product_infos .woocommerce-product-details__short-description').outerHeight() >= $('.cd-quick-view').outerHeight()) {
                    $('.cd-quick-view').find('.cd-close').css('right', '40px');
                } else {
                    $('.cd-quick-view').find('.cd-close').css('right', '28px');
                }

                $(".cd-quick-view form.cart").on("change", "input.qty, input.custom-qty", function() {
                    $('.cd-quick-view button.single_add_to_cart_button.ajax_add_to_cart').data("quantity", this.value);
                });

                $('.cd-quick-view form.cart input[name="quantity"]').trigger('change');

                $(".cd-quick-view button.single_add_to_cart_button.ajax_add_to_cart.progress-btn").on("click", function(e) {
                    var progressBtn = $(this);

                    if (!progressBtn.hasClass("active")) {
                        progressBtn.addClass("active");
                        setTimeout(function() {
                            progressBtn.addClass("check");
                        }, 1500);
                        setTimeout(function() {
                            progressBtn.removeClass("active");
                            progressBtn.removeClass("check");
                        }, 3500);
                    }
                });

                $('.cd-quick-view .variations td select.wcva-single-select').css('display', '');

            },
            error: function(errorThrown) { console.log(errorThrown); },

        }).done(function() {

            $this.parent().find('.product_thumbnail .overlay').remove();
        });

    });

    //close the quick view panel
    $('body').on('click', function(event) {
        if (($(event.target).is('.cd-close') || $(event.target).is('body.overlay-layer')) && allowClicks === true) {
            closeQuickView(sliderFinalWidth, maxQuickWidth);
        }
    });
    $(document).on('keyup', function(event) {
        //check if user has pressed 'Esc'
        if ((event.which == '27') && ($('.cd-quick-view').hasClass('is-visible'))) {
            closeQuickView(sliderFinalWidth, maxQuickWidth);
        }
    });
    $(document).on('click', '.cd-quick-view .cd-item-info .product_infos .single_add_to_cart_button.progress-btn', function() {
        setTimeout(function() {
            closeQuickView(sliderFinalWidth, maxQuickWidth);
        }, 1200);
    });

    //center quick-view on window resize
    $(window).on('resize', function() {
        if ($('.cd-quick-view').hasClass('is-visible')) {
            window.requestAnimationFrame(resizeQuickView);
        }
    });

    function resizeQuickView() {
        var quickViewLeft = ($(window).width() - $('.cd-quick-view').width()) / 2,
            quickViewTop = ($(window).height() - $('.cd-quick-view').height()) / 2;
        $('.cd-quick-view').css({
            "top": quickViewTop,
            "left": quickViewLeft,
        });
    }

    function closeQuickView(finalWidth, maxQuickWidth) {
        var close = $('.cd-close'),
            selectedImage = $('.empty-box .product_thumbnail img');

        //update the image in the gallery
        if (!$('.cd-quick-view').hasClass('velocity-animating') && $('.cd-quick-view').hasClass('add-content')) {
            animateQuickView(selectedImage, finalWidth, maxQuickWidth, 'close');
        } else {
            closeNoAnimation(selectedImage, finalWidth, maxQuickWidth);
        }
    }

    function animateQuickView(image, finalWidth, maxQuickWidth, animationType) {
        //store some image data (width, top position, ...)
        //store window data to calculate quick view panel position
        var parentListItem = image.parents('li'),
            topSelected = image.offset().top - $(window).scrollTop(),
            leftSelected = image.offset().left,
            widthSelected = image.width(),
            heightSelected = image.height(),
            windowWidth = $(window).width(),
            windowHeight = $(window).height(),
            finalLeft = (windowWidth - finalWidth) / 2,
            finalHeight = 596,
            halfHeight = finalWidth * heightSelected / widthSelected,
            finalTop = (windowHeight - finalHeight) / 2,
            quickViewWidth = (windowWidth * .8 < maxQuickWidth) ? windowWidth * .8 : maxQuickWidth,
            quickViewLeft = (windowWidth - quickViewWidth) / 2;

        if (halfHeight > finalHeight) {
            halfHeight = finalHeight;
        }

        if (animationType == 'open') {
            $('body').addClass('overlay-layer');
            //hide the image in the gallery
            parentListItem.addClass('empty-box');
            parentListItem.css({ 'animation': '', 'opacity': '' });
            //place the quick view over the image gallery and give it the dimension of the gallery image
            $('.cd-quick-view .cd-slider-wrapper').velocity({ 'width': sliderFinalWidth }, 1000, [400, 20]);
            $('.cd-quick-view').css({
                "top": topSelected,
                "left": leftSelected,
                "width": widthSelected,
                "height": halfHeight,
            });
            $('.cd-quick-view').velocity({
                //animate the quick view: animate its width and center it in the viewport
                //during this animation, only the slider image is visible
                'top': finalTop + 'px',
                'left': finalLeft + 'px',
                'width': finalWidth + 'px',
            }, 1000, [400, 20], function() {
                //animate the quick view: animate its width to the final value
                $('.cd-quick-view').addClass('animate-width').velocity({
                    'left': quickViewLeft + 'px',
                    'width': quickViewWidth + 'px',
                    'height': finalHeight + 'px',
                }, 300, 'ease', function() {
                    //show quick view content
                    $('.cd-quick-view').addClass('add-content');

                    var swiper_next = '.cd-quick-view .cd-slider-wrapper .swiper-button-next';
                    var swiper_prev = '.cd-quick-view .cd-slider-wrapper .swiper-button-prev';

                    if ($('body').hasClass('rtl')) {
                        swiper_next = '.cd-quick-view .cd-slider-wrapper .swiper-button-prev';
                        swiper_prev = '.cd-quick-view .cd-slider-wrapper .swiper-button-next';
                    }

                    var qvSlider = new Swiper('.cd-quick-view .swiper-container', {
                        preventClick: true,
                        preventClicksPropagation: true,
                        grabCursor: true,
                        loop: false,
                        onTouchStart: function() {
                            allowClicks = false;
                        },
                        onTouchMove: function() {
                            allowClicks = false;
                        },
                        onTouchEnd: function() {
                            setTimeout(function() { allowClicks = true; }, 300);
                        },
                        navigation: {
                            nextEl: swiper_next,
                            prevEl: swiper_prev,
                        },
                        pagination: {
                            el: '.cd-quick-view .swiper-container .swiper-pagination',
                        },
                    });

                    var form_variation = $(".cd-quick-view").find('.variations_form');
                    var form_variation_select = $(".cd-quick-view").find('.variations_form .variations select');

                    form_variation.wc_variation_form();
                    form_variation_select.change();

                    form_variation.on('change', 'select', function() {
                        qvSlider.slideTo(0);
                    });

                });
            });
            $('.cd-quick-view').addClass('is-visible');
        } else {
            //close the quick view reverting the animation
            $('.cd-quick-view').removeClass('add-content').velocity({
                'top': finalTop + 'px',
                'left': finalLeft + 'px',
                'width': finalWidth + 'px',
                'height': halfHeight,
            }, 300, 'ease', function() {
                $('body').removeClass('overlay-layer');
                $('.cd-quick-view').removeClass('animate-width').velocity({
                    'top': topSelected,
                    'left': leftSelected,
                    'width': widthSelected,
                    'height': halfHeight,
                }, 500, 'ease', function() {
                    $('.cd-quick-view').removeClass('is-visible');
                    parentListItem.removeClass('empty-box');
                    parentListItem.css({ 'animation': 'none', 'opacity': '1' });
                });
            });
        }
    }

    function closeNoAnimation(image, finalWidth, maxQuickWidth) {
        var parentListItem = image.parents('li'),
            topSelected = image.offset().top - $(window).scrollTop(),
            leftSelected = image.offset().left,
            widthSelected = image.width();

        //close the quick view reverting the animation
        $('body').removeClass('overlay-layer');
        parentListItem.removeClass('empty-box');
        parentListItem.css({ 'animation': 'none', 'opacity': '1' });
        $('.cd-quick-view').velocity("stop").removeClass('add-content animate-width is-visible').css({
            "top": topSelected,
            "left": leftSelected,
            "width": widthSelected,
        });
    }
});

jQuery(function($) {

    "use strict";

    /* open minicart on click */
    if (getbowtied_scripts_vars.option_minicart == 1 && getbowtied_scripts_vars.option_minicart_open == 1) {

        $('body').on('click', '.shopping-bag-button .tools_button', function(e) {

            if ($('body').hasClass('gbt_custom_notif')) {
                $('.gbt-custom-notification-notice').removeClass('open-notice').removeAttr('style').addClass('fade-out-notice');
            }

            if ($(window).width() >= 1024) {

                e.preventDefault();
                $('.shopkeeper-mini-cart').toggleClass('open');
                e.stopPropagation();

            } else {
                e.stopPropagation();
            }
        });

        /* close minicart */
        $('body').on('click', function(event) {
            if ($('.shopkeeper-mini-cart').hasClass('open')) {
                if (!$(event.target).is('.shopkeeper-mini-cart') && !$(event.target).is('.shopping-bags-button .tools-button') && !$(event.target).is('.woocommerce-message') &&
                    ($('.shopkeeper-mini-cart').has(event.target).length === 0)) {
                    $('.shopkeeper-mini-cart').removeClass('open');
                }
            }
        });
    }

    /* open minicart on hover */
    if ($(window).width() >= 1024) {
        if (getbowtied_scripts_vars.option_minicart == 1 && getbowtied_scripts_vars.option_minicart_open == 2) {

            $('.shopping-bag-button').on({
                mouseenter: function(e) {
                    if (!($('.shopkeeper-mini-cart').hasClass('open'))) {
                        window.setTimeout(function() {

                            if ($('body').hasClass('gbt_custom_notif')) {
                                $('.gbt-custom-notification-notice').removeClass('open-notice').removeAttr('style').addClass('fade-out-notice');
                            }

                            e.preventDefault();
                            $('.shopkeeper-mini-cart').addClass('open');
                            e.stopPropagation();

                        }, 350);
                    }
                },
                mouseleave: function() {
                    window.setTimeout(function() {
                        if ($('.shopkeeper-mini-cart').hasClass('open') && !$('.shopkeeper-mini-cart').is(':hover')) {
                            $('.shopkeeper-mini-cart').removeClass('open');
                        }
                    }, 500);
                }
            });

            $('.shopkeeper-mini-cart').on({
                mouseleave: function(e) {
                    window.setTimeout(function() {
                        if (($('.shopkeeper-mini-cart').hasClass('open'))) {
                            $('.shopkeeper-mini-cart').removeClass('open');
                        }
                    }, 500);
                }
            });
        }
    }

});

jQuery(function($) {

    "use strict";

    //woocommerce tabs
    $('.woocommerce-tabs .row + .panel').addClass('current');
    $('.woocommerce-tabs ul.tabs li a').off('click').on('click', function() {
        var that = $(this);
        var currentPanel = that.attr('href');

        that.parent().siblings().removeClass('active')
            .end()
            .addClass('active');

        if ($('.woocommerce-tabs').find(currentPanel).siblings('.panel').filter(':visible').length > 0) {
            $('.woocommerce-tabs').find(currentPanel).siblings('.panel').filter(':visible').fadeOut(500, function() {
                $('.woocommerce-tabs').find(currentPanel).siblings('.panel').removeClass('current');
                $('.woocommerce-tabs').find(currentPanel).addClass('current').fadeIn(500);
            });
        } else {
            $('.woocommerce-tabs').find(currentPanel).siblings('.panel').removeClass('current');
            $('.woocommerce-tabs').find(currentPanel).addClass('current').fadeIn(500);
        }

        return false;
    });

    //scroll on reviews tab
    $('.woocommerce-review-link').off('click').on('click', function() {

        $('.tabs li a').each(function() {
            if ($(this).attr('href') == '#tab-reviews') {
                $(this).trigger('click');
            }
        });

        var elem_on_screen_height = 0;

        if ($('body').hasClass('admin-bar')) {
            elem_on_screen_height += 32;
        }

        var tab_reviews_topPos = $('.woocommerce-tabs').offset().top - elem_on_screen_height;

        $('html, body').animate({
            scrollTop: tab_reviews_topPos
        }, 1000);

        return false;
    });

});

jQuery(function($) {

    "use strict";

    //Product Gallery zoom

    if ($(".easyzoom").length) {

        if ($(window).width() > 1024) {

            var $easyzoom = $(".easyzoom").easyZoom({
                loadingNotice: '',
                errorNotice: '',
                preventClicks: false,
                linkAttribute: "href",
            });

            var easyzoom_api = $easyzoom.data('easyZoom');

            $(".variations").on('change', 'select', function() {
                easyzoom_api.teardown();
                easyzoom_api._init();
            });

        } else {

            $(".easyzoom a").on('click', function(event) {
                event.preventDefault();
            });
        }
    }

});

jQuery(function($) {

    'use strict';

    // Products Dot Navigation [ Product Version 2 & 3 ]

    var productImagesController = $('.product-images-controller');
    var productImages = $('.product-images-style-2 .product_images .product-image:not(.mobile), .product-images-style-3 .product_images .product-image:not(.mobile)');
    var navigationItems = $('.product-images-style-2 .product-images-controller li a span.dot, .product-images-style-3 .product-images-controller li a span.dot');
    var productImagesContainer = $('.product-images-wrapper');
    var headerHeight = $('.site-header-sticky').length ? $('.site-header-sticky').outerHeight() : 0;

    // set position of the product images controller layout 2

    if ($('.product_layout_2').length > 0) {

        var controllerLayout2 = $('.product_layout_2 .product-images-controller');
        controllerLayout2.css('top', productImagesContainer.offset().top);
    }


    $(window).on('scroll', function() {

        navigationItems.addClass('current');

        productImages.each(function() {

            var $this = $(this);

            var activeImage = $(' a[href="#' + $this.attr('id') + '"]').data('number');


            if ($this.offset().top + $this.outerHeight() <= productImagesController.offset().top - headerHeight) {

                navigationItems.removeClass('current');

                navigationItems.eq(activeImage).addClass('current');

            } else {
                navigationItems.eq(activeImage).removeClass('current');
            }

        });

        // set youtube vide icon current

        var youtubeVideo = $('.product_layout_2 .fluid-width-video-wrapper, .product_layout_3 .fluid-width-video-wrapper');

        if (youtubeVideo.length > 0) {

            if (youtubeVideo.offset().top <= productImagesController.offset().top - headerHeight) {
                $('li.video-icon span.dot').addClass('current');
            } else {
                $('.product-images-controller .video-icon .dot').removeClass('current');
            }

            if (youtubeVideo.offset().top + youtubeVideo.outerHeight() <= productImagesController.offset().top) {

                $('.product-images-controller .video-icon .dot').removeClass('current');
            }

        }

    });


    // navigationItem smooth scroll
    if ($('.single-product').length > 0) {

        $('a[href*="#controller-navigation-image"]:not([href="#"])').on('click', function() {

            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                // if wordpress admin bar exists take care of that
                var adminBarHeight = 0;
                if ($('body').hasClass('admin-bar')) {
                    var adminBarHeight = 32;
                }

                var header_height = $('.site-header-sticky').length ? $('.site-header-sticky').outerHeight() : 0;

                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - header_height - adminBarHeight
                    }, 500);
                    return false;
                }
            }

        });

    }

    // Video Autoplay on click
    if ($('.product-image.video iframe')) {

        $('.product_layout_2 .product-images-controller .video-icon > a, .product_layout_3 .product-images-controller .video-icon > a').on('click', function(e) {
            $('.product-image.video iframe')[0].src += "&autoplay=1";
            e.preventDefault();
        });

    }
});

jQuery(function($) {

    'use strict';

    // Stops Products_infos at Footer

    setTimeout(function() {
        if ($(".single-product .product .product_infos .cart .StripeElement").children().length > 0) {
            $(".single-product .product .product_infos .cart").addClass("stripe-button");
        }
    }, 1000);

    function product_infos_adjust() {
        // if product description is too long
        var productInfosHeight = $('.product .product_content_wrapper .product_infos').length ? $('.product .product_content_wrapper .product_infos').outerHeight() : 0;
        var productInfosPos = $('.product .product_content_wrapper .product_infos').position().top;
        var productInfosWidth = $('.product .product_content_wrapper .product_infos').length ? $('.product .product_content_wrapper .product_infos').outerWidth() : 0;
        var productContentWrapperOff = $('.product_content_wrapper').offset().top;

        if ((productInfosHeight > $(window).innerHeight() - productContentWrapperOff) && ($(window).width() >= 1024)) {
            $('.product_infos').addClass('long-description'); // product description is longer than actual viewport
        } else {
            $('.product_infos').css({ top: productContentWrapperOff });
        }
    }

    if (($('.product_layout_2').length > 0) || ($('.product_layout_3').length > 0) || ($('.product_layout_4').length > 0)) {

        product_infos_adjust();

        // if product_infos is at at footer, stop it.
        $(window).on('scroll', function() {

            var windowTop = $(window).scrollTop();
            var footerTop = $("#site-footer").length ? $("#site-footer").offset().top : 0;
            var productInfosOff = $('.product_infos.fixed').offset().top;
            var productInfosH = $(".product_infos.fixed").length ? $(".product_infos.fixed").height() : 0;
            var padding = 40; // let a distance between the product_infos and the footer
            var productContentWrapperOff = $('.product_content_wrapper').length ? $('.product_content_wrapper').offset().top : 0;

            if (windowTop + productInfosH + 200 > footerTop - padding) {

                $('.product_infos.fixed:not(.long-description)').css({
                    top: (windowTop + productInfosH - footerTop + padding) * -1
                });

            } else {
                $('.product_infos.fixed:not(.long-description)').css({
                    top: productContentWrapperOff
                });
            }

        });

        $(window).on('orientationchange', function() {
            product_infos_adjust();
        });
    }

    // only for product layout 3
    function product_layout_3() {

        if ($('.product_layout_3').length > 0) {

            var productImagesWrapperWidth = $('.product_layout_3 .product-images-wrapper').width();
            var productImagesWrapper = $('.product_layout_3 .product-images-wrapper');
            var productTitle = $('.product_layout_3 .product_title');
            var widthPercent = $('.product_layout_3 .product-images-wrapper').width() / $(window).width() * 100;

            // set product title width 100% for mobile and tablet
            productTitle.css({
                width: $(window).width(),
                left: 'auto'
            });

            if ($(window).width() >= 1024) {

                if ($(window).width() >= 1201) {
                    // set position of the product title to be equal with the product images offset left
                    productTitle.css({
                        left: $('.product_layout_3 .product-images-controller').offset().left
                    });
                } else {
                    productTitle.css({
                        left: '25px'
                    });
                }

                // add class for desktop for product title
                productTitle.addClass('for-desktop');
                // set product title width to be 75% of the product images wrapper width
                productTitle.css({ width: widthPercent * 0.75 + '%' });

                // set position of the product images controller layout 3
                var controllerLayout3 = $('.product_layout_3 .product-images-controller');
                var productBadges = $('.product_layout_3 .product-badges');
                var productTitleHeight = productTitle.length ? productTitle.outerHeight() : 0;
                controllerLayout3.css('top', productImagesWrapper.offset().top + productTitleHeight + 40);
                productBadges.css('top', productTitleHeight + 40);
            } else {
                productTitle.removeClass('for-desktop');
                $('.product_layout_3 .product-badges').css('top', '');
            }
        }
    }

    product_layout_3();

    $(window).on('resize orientationchange', function() {
        product_layout_3();
    });
});

jQuery(function($) {

    'use strict';

    // Product Ratings Tooltip

    if ($(window).width() > 1024) {

        var woocommerce_review_link_hover = $('.product .woocommerce-product-rating .woocommerce-review-link').html();
        var woocommerce_review_link = $('.product .woocommerce_review_link_hover');
        var woocommerce_product_rating = $('.product .woocommerce-product-rating');
        var rating_tooltip = '<div class="woocommerce_review_link_hover">' + woocommerce_review_link_hover + '</div>';

        // check to see if the woocommerce reviews tab is enabled
        if (woocommerce_review_link_hover != undefined) {

            woocommerce_product_rating.before(rating_tooltip);

            woocommerce_product_rating.on({
                mouseenter: function() {

                    $('.woocommerce_review_link_hover').addClass('hovered')
                },
                mouseleave: function() {

                    $('.woocommerce_review_link_hover').removeClass('hovered')
                }

            });
        }
    }
});

jQuery(function($) {

    'use strict';

    // Product Quantity Custom Buttons

    $(document).on('click', '.plus-btn', function(e) {

        var input = $(this).prev('input.custom-qty');

        if ($('body').hasClass('rtl')) {
            input = $(this).next('input.custom-qty');
        }

        var val = parseInt(input.val());
        if (!val) { val = 0; }
        var max = parseInt(input.attr('max'));
        var step = parseInt(input.attr('step')) || 1;

        if (!isNaN(max)) {
            if (max > val) {
                input.val(val + step).change();
            }
        } else {
            input.val(val + step).change();
        }

        return false;
    });

    $(document).on('click', '.minus-btn', function(e) {

        var input = $(this).next('input.custom-qty');

        if ($('body').hasClass('rtl')) {
            input = $(this).prev('input.custom-qty');
        }

        var val = parseInt(input.val());
        if (!val) { val = 0; }
        var min = parseInt(input.attr('min'));
        var step = parseInt(input.attr('step')) || 1;

        if (!isNaN(min)) {
            if (min < val) {
                input.val(val - step).change();
            }
        } else {
            input.val(val - step).change();
        }

        return false;
    });

    var windowWidth = $(window).width();

    // Input Quantity Long Press

    if (windowWidth > 1024) {

        var timer;

        $(document).on('mousedown', '.plus-btn', function(e) {

            var input = $(this).prev('input.custom-qty');
            var val = parseInt(input.val());

            timer = setInterval(function() {

                val++;
                input.val(val);

            }, 250);

        });

        $(document).on('mousedown', '.minus-btn', function(e) {

            var input = $(this).next('input.custom-qty');
            var val = parseInt(input.val());

            timer = setInterval(function() {

                if (val > 1) {
                    val--;
                    input.val(val);
                }

            }, 250);
        });


        document.addEventListener("mouseup", function() {
            if (timer) clearInterval(timer)
        });

    }
});

jQuery(function($) {

    "use strict";

    //  yith wishlist counter
    function getCookie(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);
        if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
        } else {
            begin += 2;
            var end = document.cookie.indexOf(";", begin);
            if (end == -1) {
                end = dc.length;
            }
        }
        // because unescape has been deprecated, replaced with decodeURI
        //return unescape(dc.substring(begin + prefix.length, end));
        return decodeURIComponent(decodeURIComponent((dc.substring(begin + prefix.length, end))));
    }

    function getbowtied_update_wishlist_count(count) {
        if ((typeof count === "number" && isFinite(count) && Math.floor(count) === count) && count >= 0) {
            $('.wishlist_items_number').html(count);
        }
    }

    if ($('.wishlist_items_number').length) {

        var wishlistCounter = 0;

        /*
         **	Check for Yith cookie
         */
        var wlCookie = getCookie("yith_wcwl_products");

        if (wlCookie != null) {
            wlCookie = wlCookie.slice(0, wlCookie.indexOf(']') + 1);
            var products = JSON.parse(wlCookie);
            wishlistCounter = Object.keys(products).length;
        } else {
            wishlistCounter = Number($('.wishlist_items_number').html());
        }

        /*
         **	Increment counter on add
         */
        $('body').on('added_to_wishlist', function() {
            wishlistCounter++;
            getbowtied_update_wishlist_count(wishlistCounter);
        });

        /*
         **	Decrement counter on remove
         */
        $('body').on('removed_from_wishlist', function() {
            wishlistCounter--;
            getbowtied_update_wishlist_count(wishlistCounter);
        });

        getbowtied_update_wishlist_count(wishlistCounter);
    }
});

jQuery(function($) {

    "use strict";

    //shopkeeper_catalogMode
    function shopkeeper_catalog_mode() {
        if (getbowtied_scripts_vars.catalog_mode) {
            $("form.cart div.quantity").empty();
            $("form.cart button.single_add_to_cart_button").remove();
        }
    }

    shopkeeper_catalog_mode();
});

jQuery(function($) {

    "use strict";

    var pagination_type = getbowtied_scripts_vars.shop_pagination_type;
    var load_more_text = getbowtied_scripts_vars.ajax_load_more_locale;
    var load_more_loading_text = getbowtied_scripts_vars.ajax_loading_locale;
    var no_more_items_text = getbowtied_scripts_vars.ajax_no_more_items_locale;

    if (pagination_type == 'load_more_button' || pagination_type == 'infinite_scroll') {

        if ($('.woocommerce-pagination').length && $('body').hasClass('archive')) {

            $('.woocommerce-pagination').before('<div class="getbowtied_ajax_load_button"><a getbowtied_ajax_load_more_processing="0">' + load_more_text + '</a></div>');

            if (pagination_type == 'infinite_scroll') {
                $('.getbowtied_ajax_load_button').addClass('getbowtied_ajax_load_more_hidden');
            }

            if ($('.woocommerce-pagination a.next').length == 0) {
                $('.getbowtied_ajax_load_button').addClass('getbowtied_ajax_load_more_hidden');
            }

            $('.woocommerce-pagination').hide();
        }

        $('body').on('click', '.getbowtied_ajax_load_button a', function(e) {

            e.preventDefault();

            if ($('.woocommerce-pagination a.next').length) {

                $('.getbowtied_ajax_load_button a').attr('getbowtied_ajax_load_more_processing', 1);
                var href = $('.woocommerce-pagination a.next').attr('href');

                $('.getbowtied_ajax_load_button').fadeOut(200, function() {
                    $('.woocommerce-pagination').before('<div class="getbowtied_ajax_load_more_loader"><span>' + load_more_loading_text + '</span></div>');
                });

                $.get(href, function(response) {

                    $('.woocommerce-pagination').html($(response).find('.woocommerce-pagination').html());

                    var i = 0;

                    $(response).find('.site-content ul.products > li').each(function() {

                        i++;
                        $(this).find(".product_thumbnail.with_second_image").css("background-size", "cover");
                        $(this).find(".product_thumbnail.with_second_image").addClass("second_image_loaded");
                        $(this).addClass("ajax-loaded delay-" + i);
                        $('.site-content ul.products > li:last').after($(this));
                    });

                    $('.getbowtied_ajax_load_more_loader').fadeOut(200, function() {
                        $('.getbowtied_ajax_load_button').fadeIn(200);
                        $('.getbowtied_ajax_load_button a').attr('getbowtied_ajax_load_more_processing', 0);
                    });

                    setTimeout(function() {
                        $('.getbowtied_ajax_load_more_loader').remove();
                    }, 250);

                    $(document).trigger('post-load');

                    setTimeout(function() {

                        $('.site-content ul.products > li').each(function() {
                            //lazy loading tweak
                            var image = $(this).find('.product_thumbnail > img.jetpack-lazy-image');
                            if (image) {
                                if (image.attr('data-lazy-srcset')) {
                                    image.attr('srcset', image.attr('data-lazy-srcset'));
                                } else {
                                    image.attr('srcset', image.attr('src'));
                                }
                            }
                        });

                        $('.site-content ul.products > li.hidden').removeClass('hidden').addClass('animate');
                    }, 500);

                    if ($('.woocommerce-pagination a.next').length == 0) {
                        $('.getbowtied_ajax_load_button').addClass('finished').removeClass('getbowtied_ajax_load_more_hidden');
                        $('.getbowtied_ajax_load_button a').show().html(no_more_items_text).addClass('disabled');
                    }

                });

            } else {

                $('.getbowtied_ajax_load_button').addClass('finished').removeClass('getbowtied_ajax_load_more_hidden');
                $('.getbowtied_ajax_load_button a').show().html(no_more_items_text).addClass('disabled');
            }
        });
    }

    if (pagination_type == 'infinite_scroll') {

        var buffer_pixels = Math.abs(0);

        $(window).on('scroll', function() {

            if ($('.site-content ul.products:not(.product-categories)').length) {

                var a = $('.site-content ul.products:not(.product-categories)').offset().top + $('.site-content ul.products:not(.product-categories)').outerHeight();
                var b = a - $(window).scrollTop();

                if ((b - buffer_pixels) < $(window).height()) {
                    if ($('.getbowtied_ajax_load_button a').attr('getbowtied_ajax_load_more_processing') == 0) {
                        $('.getbowtied_ajax_load_button a').trigger('click');
                    }
                }

            }

        });
    }

    $('section.related.products').addClass('mobile-columns-' + getbowtied_scripts_vars.mobile_product_columns);
    $('section.upsells.products').addClass('mobile-columns-' + getbowtied_scripts_vars.mobile_product_columns);
});

jQuery(function($) {

    "use strict";

    $('#masonry_grid').addClass('fade-in');

    if (!$('body').hasClass('search')) {

        if (getbowtied_scripts_vars.pagination_blog == 'load_more_button' || getbowtied_scripts_vars.pagination_blog == 'infinite_scroll') {

            if ($('.posts-navigation').length) {

                $('.posts-navigation').before('<div class="getbowtied_blog_ajax_load_button"><a getbowtied_blog_ajax_load_more_processing="0">' + getbowtied_scripts_vars.ajax_load_more_locale + '</a></div>');

                if (getbowtied_scripts_vars.pagination_blog == 'infinite_scroll') {
                    $('.getbowtied_blog_ajax_load_button').addClass('getbowtied_blog_ajax_load_more_hidden');
                }

                if ($('.posts-navigation a.next').length == 0) {
                    $('.getbowtied_blog_ajax_load_button').addClass('getbowtied_blog_ajax_load_more_hidden');
                }
            }

            $('.posts-navigation').hide();
            $('.blog-posts > .blog-post').addClass('getbowtied_blog_ajax_load_more_item_visible');


            $('body').on('click', '.getbowtied_blog_ajax_load_button a', function(e) {

                e.preventDefault();

                if ($('.posts-navigation a.next').length) {

                    $('.getbowtied_blog_ajax_load_button a').attr('getbowtied_blog_ajax_load_more_processing', 1);
                    var href = $('.posts-navigation a.next').attr('href');

                    $('.getbowtied_blog_ajax_load_button').fadeOut(200, function() {
                        $('.posts-navigation').before('<div class="getbowtied_blog_ajax_load_more_loader"><span>' + getbowtied_scripts_vars.ajax_loading_locale + '</span></div>');
                    });

                    $.get(href, function(response) {

                        $('.posts-navigation').html($(response).find('.posts-navigation').html());

                        var i = 0;

                        $(response).find('.blog-posts > .blog-post').each(function() {

                            if (getbowtied_scripts_vars.layout_blog == "layout-1") {
                                i++;
                                $(this).addClass('loaded delay-' + i);

                                var grid = document.querySelector('#masonry_grid');
                                var item = document.createElement('li');


                                salvattore.appendElements(grid, [item]);
                                item.outerHTML = $(this).prop('outerHTML');

                            } else {

                                i++;
                                $(this).addClass('loaded delay-' + i);

                                $('.blog-posts > .blog-post:last').after($(this));

                            }

                        });

                        $('.getbowtied_blog_ajax_load_more_loader').fadeOut(200, function() {
                            $(this).remove();
                            $('.getbowtied_blog_ajax_load_button').show();
                            $('.getbowtied_blog_ajax_load_button a').attr('getbowtied_blog_ajax_load_more_processing', 0);
                        });

                        if ($('.posts-navigation a.next').length == 0) {
                            $('.getbowtied_blog_ajax_load_button').addClass('finished').removeClass('getbowtied_blog_ajax_load_more_hidden');
                            $('.getbowtied_blog_ajax_load_button a').show().html(getbowtied_scripts_vars.ajax_no_more_items_locale).addClass('disabled');
                        }
                    });

                } else {

                    $('.getbowtied_blog_ajax_load_button').addClass('finished').removeClass('getbowtied_blog_ajax_load_more_hidden');
                    $('.getbowtied_blog_ajax_load_button a').show().html(getbowtied_scripts_vars.ajax_no_more_items_locale).addClass('disabled');
                }
            });
        }

        if (getbowtied_scripts_vars.pagination_blog == 'infinite_scroll') {

            var buffer_pixels = Math.abs(0);

            $(window).on('scroll', function() {

                if ($('.blog-posts').length) {

                    var a = $('.blog-posts').offset().top + $('.blog-posts').outerHeight();
                    var b = a - $(window).scrollTop();

                    if ((b - buffer_pixels) < $(window).height()) {
                        if ($('.getbowtied_blog_ajax_load_button a').attr('getbowtied_blog_ajax_load_more_processing') == 0) {
                            $('.getbowtied_blog_ajax_load_button a').trigger('click');
                        }
                    }
                }
            });
        }
    }
});

//@prepros-prepend components/gutenberg.js
//@prepros-prepend components/scripts.js
//@prepros-prepend components/header.js
//@prepros-prepend components/smooth-transition.js
//@prepros-prepend components/wc-product-gallery.js
//@prepros-prepend components/wc-quickview.js
//@prepros-prepend components/wc-minicart.js
//@prepros-prepend components/wc-product-tabs.js
//@prepros-prepend components/wc-easyzoom.js
//@prepros-prepend components/wc-product-navigation.js
//@prepros-prepend components/wc-product-infos.js
//@prepros-prepend components/wc-product-ratings.js
//@prepros-prepend components/wc-product-quantity.js
//@prepros-prepend components/wc-counters.js
//@prepros-prepend components/wc-catalog-mode.js
//@prepros-prepend components/wc-products-ajax.js
//@prepros-prepend components/wp-blog-ajax.js