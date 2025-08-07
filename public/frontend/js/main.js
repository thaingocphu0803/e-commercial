!function(s) {
    "use strict";
    var e = "rtl" === s("body").prop("dir");
    s(window).on("load", (function() {
        s("#preloader-active").fadeOut(),
        s("body").css({
            overflow: "visible"
        }),
        s(".home-slider .single-hero-slider").show(),
        s("#news-flash ul li").show()
    }
    ));
    var i = s(".sticky-bar")
      , t = s(window)
      , a = s("header.header-area");
    t.on("scroll", (function() {
        t.scrollTop() < 200 ? (i.removeClass("stick"),
        s(".header-style-2 .categories-dropdown-active-large").removeClass("open"),
        s(".header-style-2 .categories-button-active").removeClass("open")) : i.addClass("stick")
    }
    )),
    s.scrollUp({
        scrollText: '<i class="fi-rs-arrow-small-up"></i>',
        easingType: "linear",
        scrollSpeed: 900,
        animation: "fade"
    }),
    s(".sticky-sidebar").length && s(".sticky-sidebar").theiaStickySidebar(),
    Number.prototype.format_price = function(s, e) {
        var i = window.currencies || {};
        s || (s = null != i.number_after_dot ? i.number_after_dot : 2);
        var t = "\\d(?=(\\d{" + (e || 3) + "})+$)"
          , a = ""
          , o = this;
        return i.show_symbol_or_title && (a = i.symbol || i.title),
        i.display_big_money && (o >= 1e6 && o < 1e9 ? (o /= 1e6,
        a = i.million + (a ? " " + a : "")) : o >= 1e9 && (o /= 1e9,
        a = i.billion + (a ? " " + a : ""))),
        o = (o = (o = o.toFixed(Math.max(0, ~~s))).toString().split("."))[0].toString().replace(new RegExp(t,"g"), "$&" + i.thousands_separator) + (o[1] ? i.decimal_separator + o[1] : ""),
        i.show_symbol_or_title && (i.is_prefix_symbol ? o = a + o : o += a),
        o
    }
    ;
    var o = function() {
        s(".slider-range").length && s(".slider-range").map((function(e, i) {
            var t = s(i)
              , a = t.closest(".range")
              , o = a.find("input.min-range")
              , r = a.find("input.max-range");
            t.slider({
                range: !0,
                min: o.data("min") || 0,
                max: r.data("max") || 500,
                values: [o.val() || 0, r.val() || 500],
                slide: function(s, e) {
                    l(a, e.values[0], e.values[1])
                },
                change: function(s, e) {
                    l(a, e.values[0], e.values[1]),
                    a.find("input.min-range").trigger("change"),
                    a.find("input.max-range").trigger("change")
                }
            }),
            l(a, t.slider("values", 0), t.slider("values", 1))
        }
        ))
    };
    function l(s, e, i) {
        var t = s.closest(".widget-filter-item")
          , a = e
          , o = i;
        t.length && "price" === t.data("type") && (a = a.format_price(),
        o = o.format_price());
        var l = s.find(".from")
          , r = s.find(".to");
        s.find("input.min-range").val(e),
        s.find("input.max-range").val(i),
        l.text(a),
        r.text(o)
    }
    o(),
    s(".hero-slider-1").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: e,
        fade: !0,
        loop: !0,
        dots: !0,
        arrows: !0,
        prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-angle-left"></i></span>',
        nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-angle-right"></i></span>',
        appendArrows: ".hero-slider-1-arrow",
        autoplay: !0
    }),
    s(".carousel-8-columns").each((function() {
        var i = s(this).attr("id")
          , t = "#" + i
          , a = "#" + i + "-arrows"
          , o = Object.assign({
            dots: !1,
            infinite: !0,
            rtl: e,
            speed: 1e3,
            arrows: !0,
            autoplay: !0,
            slidesToShow: (s(t).data("items-xxl") ? s(t).data("items-xxl") : s(t).data("items-xl")) || 8,
            slidesToScroll: 1,
            loop: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: s(t).data("items-xl") || 6,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 1025,
                settings: {
                    slidesToShow: s(t).data("items-lg") || 5,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: s(t).data("items-md") || 4,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: s(t).data("items-sm") || 2,
                    slidesToScroll: 1
                }
            }],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-arrow-small-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-arrow-small-right"></i></span>',
            appendArrows: a
        }, s(t).data("slick") || {});
        s(t).slick(o)
    }
    )),
    s(".carousel-10-columns").each((function() {
        var i = s(this).attr("id")
          , t = "#" + i
          , a = "#" + i + "-arrows"
          , o = Object.assign({
            dots: !1,
            infinite: !0,
            rtl: e,
            speed: 1e3,
            arrows: !0,
            autoplay: !1,
            slidesToShow: (s(t).data("items-xxl") ? s(t).data("items-xxl") : s(t).data("items-xl")) || 10,
            slidesToScroll: 1,
            loop: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: s(t).data("items-xl") || 6,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 1025,
                settings: {
                    slidesToShow: s(t).data("items-lg") || 5,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: s(t).data("items-md") || 4,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: s(t).data("items-sm") || 2,
                    slidesToScroll: 1
                }
            }],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-arrow-small-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-arrow-small-right"></i></span>',
            appendArrows: a
        }, s(t).data("slick") || {});
        s(t).slick(o)
    }
    )),
    s(".carousel-4-columns").each((function() {
        var i = s(this).attr("id")
          , t = "#" + i
          , a = "#" + i + "-arrows"
          , o = Object.assign({
            dots: !1,
            infinite: !0,
            rtl: e,
            speed: 1e3,
            arrows: !0,
            autoplay: !0,
            slidesToShow: 4,
            slidesToScroll: 1,
            loop: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-arrow-small-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-arrow-small-right"></i></span>',
            appendArrows: a
        }, s(t).data("slick") || {});
        s(t).slick(o)
    }
    )),
    s(".carousel-6-columns").each((function() {
        var e = s(this)
          , i = e.attr("id")
          , t = "#" + i
          , a = "#" + i + "-arrows"
          , o = Object.assign({}, {
            dots: !1,
            infinite: !0,
            rtl: "rtl" === s("body").prop("dir"),
            arrows: !0,
            autoplay: !1,
            slidesToShow: e.data("items-xxl") ? e.data("items-xxl") : e.data("items-xl"),
            slidesToScroll: 1,
            loop: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1600,
                settings: {
                    slidesToShow: e.data("items-xl") ? e.data("items-xl") : e.data("items-xxl"),
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 1025,
                settings: {
                    slidesToShow: e.data("items-lg"),
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: e.data("items-md"),
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: e.data("items-sm"),
                    slidesToScroll: 1
                }
            }],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-arrow-small-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-arrow-small-right"></i></span>',
            appendArrows: a
        }, s(t).data("slick") || {});
        s(t).slick(o)
    }
    )),
    s(".carousel-3-columns").each((function() {
        var i = s(this).attr("id")
          , t = "#" + i
          , a = "#" + i + "-arrows"
          , o = Object.assign({
            dots: !1,
            infinite: !0,
            rtl: e,
            speed: 1e3,
            arrows: !0,
            autoplay: !0,
            slidesToShow: 3,
            slidesToScroll: 1,
            loop: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }],
            prevArrow: '<span class="slider-btn slider-prev"><i class="fi-rs-arrow-small-left"></i></span>',
            nextArrow: '<span class="slider-btn slider-next"><i class="fi-rs-arrow-small-right"></i></span>',
            appendArrows: a
        }, s(t).data("slick") || {});
        s(t).slick(o)
    }
    )),
    s('button[data-bs-toggle="tab"]').on("shown.bs.tab", (function() {
        s(".carousel-4-columns").slick("setPosition")
    }
    ));
    var r = function(s) {
        return window.trans = window.trans || {},
        "undefined" !== window.trans[s] && window.trans[s] ? window.trans[s] : s
    };
    s("[data-countdown]").each((function() {
        var e = s(this)
          , i = s(this).data("countdown");
        e.countdown(i, (function(e) {
            s(this).html(e.strftime('<span class="countdown-section"><span class="countdown-amount hover-up">%D</span><span class="countdown-period"> ' + r("days") + ' </span></span><span class="countdown-section"><span class="countdown-amount hover-up">%H</span><span class="countdown-period"> ' + r("hours") + ' </span></span><span class="countdown-section"><span class="countdown-amount hover-up">%M</span><span class="countdown-period"> ' + r("mins") + ' </span></span><span class="countdown-section"><span class="countdown-amount hover-up">%S</span><span class="countdown-period"> ' + r("sec") + " </span></span>"))
        }
        ))
    }
    )),
    s(".product-slider-active-1").slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        rtl: e,
        autoplay: !0,
        fade: !1,
        loop: !0,
        dots: !1,
        arrows: !0,
        prevArrow: '<span class="pro-icon-1-prev"><i class="fi-rs-angle-small-left"></i></span>',
        nextArrow: '<span class="pro-icon-1-next"><i class="fi-rs-angle-small-right"></i></span>',
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 1
            }
        }]
    }),
    s(".testimonial-active-1").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: e,
        fade: !1,
        loop: !0,
        dots: !1,
        arrows: !0,
        prevArrow: '<span class="pro-icon-1-prev"><i class="fi-rs-angle-small-left"></i></span>',
        nextArrow: '<span class="pro-icon-1-next"><i class="fi-rs-angle-small-right"></i></span>',
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 1
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 1
            }
        }]
    }),
    s(".testimonial-active-3").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: e,
        fade: !1,
        loop: !0,
        dots: !0,
        arrows: !1,
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 1
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 1
            }
        }]
    }),
    s(".categories-slider-1").slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        rtl: e,
        fade: !1,
        loop: !0,
        dots: !1,
        arrows: !1,
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 1
            }
        }]
    }),
    s(".categories-button-active").on("click", (function(e) {
        if (e.preventDefault(),
        a.find(".categories-button-active").hasClass("cant-close") && !i.hasClass("stick"))
            return !1;
        s(this).hasClass("open") ? (s(this).removeClass("open"),
        s(this).siblings(".categories-dropdown-active-large").removeClass("open"),
        a.find(".categories-button-active").hasClass("cant-close") || s(this).siblings(".categories-dropdown-active-large").removeClass("default-open")) : (s(this).addClass("open"),
        s(this).siblings(".categories-dropdown-active-large").addClass("open"))
    }
    ));
    var n, d, c, p = s(".pagingInfo"), u = s(".testimonial-active-2");
    if (u.on("init reInit afterChange", (function(s, e, i) {
        var t = (i || 0) + 1;
        p.text("0" + t + " ------ 0" + e.slideCount)
    }
    )),
    u.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: e,
        fade: !1,
        loop: !0,
        dots: !1,
        arrows: !0,
        prevArrow: '<span class="testimonial-icon-2-prev"><i class="fi-rs-angle-small-left"></i></span>',
        nextArrow: '<span class="testimonial-icon-2-next"><i class="fi-rs-angle-small-right"></i></span>'
    }),
    s(".sort-by-product-area").length) {
        var h = s("body")
          , g = s(".sort-by-product-area")
          , m = g.find(".sort-by-dropdown");
        h.on("click", ".sort-by-product-area .sort-by-product-wrap", (function(e) {
            e.preventDefault();
            var i = s(this);
            i.parent().hasClass("show") ? i.siblings(".sort-by-dropdown").removeClass("show").closest(".sort-by-product-area").removeClass("show") : i.siblings(".sort-by-dropdown").addClass("show").closest(".sort-by-product-area").addClass("show")
        }
        )),
        h.on("click", (function(e) {
            var i = e.target;
            s(i).is(".sort-by-product-area") || s(i).parents().is(".sort-by-product-area") || !g.hasClass("show") || (g.removeClass("show"),
            m.removeClass("show"))
        }
        ))
    }
    s(".shop-filter-toggle").on("click", (function(e) {
        e.preventDefault(),
        s(".shop-product-filter-header").slideToggle(),
        s(".shop-filter-toggle").toggleClass("active")
    }
    )),
    window.closeShopFilterSection = function() {
        s(".shop-filter-toggle").hasClass("active") && (s(".shop-product-filter-header").slideToggle(),
        s(".shop-filter-toggle").removeClass("active"))
    }
    ,
    s(".pro-dec-big-img-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: e,
        arrows: !1,
        draggable: !1,
        fade: !1,
        asNavFor: ".product-dec-slider-small , .product-dec-slider-small-2"
    }),
    s(".product-dec-slider-small").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: e,
        asNavFor: ".pro-dec-big-img-slider",
        dots: !1,
        focusOnSelect: !0,
        fade: !1,
        arrows: !1,
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 2
            }
        }]
    }),
    s(".img-popup").length && s(".img-popup").each((function() {
        s(this).magnificPopup({
            delegate: "a",
            type: "image",
            gallery: {
                enabled: !0
            }
        })
    }
    )),
    s(".grid").length && s(".grid").imagesLoaded((function() {
        s(".grid").isotope({
            itemSelector: ".grid-item",
            percentPosition: !0,
            layoutMode: "masonry",
            masonry: {
                columnWidth: ".grid-item"
            }
        })
    }
    )),
    n = s(".search-active"),
    d = s(".search-close"),
    c = s(".main-search-active"),
    n.on("click", (function(s) {
        s.preventDefault(),
        c.addClass("search-visible")
    }
    )),
    d.on("click", (function() {
        c.removeClass("search-visible")
    }
    )),
    function() {
        var e = s(".burger-icon")
          , i = s(".mobile-menu-close")
          , t = s(".mobile-header-active")
          , a = s("body");
        a.prepend('<div class="body-overlay-1"></div>'),
        e.on("click", (function(s) {
            s.preventDefault(),
            t.addClass("sidebar-visible"),
            a.addClass("mobile-menu-active")
        }
        )),
        i.on("click", (function() {
            t.removeClass("sidebar-visible"),
            a.removeClass("mobile-menu-active")
        }
        )),
        s(".body-overlay-1").on("click", (function() {
            t.removeClass("sidebar-visible"),
            a.removeClass("mobile-menu-active")
        }
        ))
    }();
    var w = s(".mobile-menu")
      , f = w.find(".dropdown");
    function v() {
        var e = s(window).width();
        s.each(s(".single-hero-slider"), (function(i, t) {
            e >= 1200 ? s(t).data("original-image") && s(t).css({
                "background-image": 'url("' + encodeURI(s(t).data("original-image")) + '")'
            }) : e > 768 ? s(t).data("tablet-image") && s(t).css({
                "background-image": 'url("' + encodeURI(s(t).data("tablet-image")) + '")'
            }) : e <= 768 && s(t).data("mobile-image") && s(t).css({
                "background-image": 'url("' + encodeURI(s(t).data("mobile-image")) + '")'
            })
        }
        ))
    }
    f.parent().prepend('<span class="menu-expand"><i class="fi-rs-angle-down"></i></span>'),
    f.slideUp(),
    w.on("click", "li a, li .menu-expand", (function(e) {
        var i = s(this);
        i.parent().attr("class").match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/) && ("#" === i.attr("href") || i.hasClass("menu-expand")) && (e.preventDefault(),
        i.siblings("ul:visible").length ? (i.parent("li").removeClass("active"),
        i.siblings("ul").slideUp()) : (i.parent("li").addClass("active"),
        i.closest("li").siblings("li").removeClass("active").find("li").removeClass("active"),
        i.closest("li").siblings("li").find("ul:visible").slideUp(),
        i.siblings("ul").slideDown()))
    }
    )),
    s(".mobile-language-active").on("click", (function(e) {
        e.preventDefault(),
        s(this).closest(".single-mobile-header-info").find(".lang-dropdown-active").slideToggle(900)
    }
    )),
    s(".categories-button-active-2").on("click", (function(e) {
        e.preventDefault(),
        s(".categories-dropdown-active-small").slideToggle(900)
    }
    )),
    s(".more_slide_open").slideUp(),
    s(".more_categories").on("click", (function() {
        s(this).toggleClass("show"),
        s(".more_slide_open").slideToggle(),
        s(this).hasClass("show") ? s(this).find("span.heading-sm-1").text(s(this).data("text-show-less")) : s(this).find("span.heading-sm-1").text(s(this).data("text-show-more"))
    }
    )),
    s("#news-flash").vTicker({
        speed: 500,
        pause: 3e3,
        animation: "fade",
        mousePause: !1,
        showItems: 1
    }),
    "undefined" != typeof WOW && (new WOW).init(),
    s(document).ready((function() {
        !function() {
            s(".product-image-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: e,
                arrows: !1,
                fade: !1,
                asNavFor: ".slider-nav-thumbnails"
            }),
            s(".slider-nav-thumbnails").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                rtl: e,
                asNavFor: ".product-image-slider",
                dots: !1,
                focusOnSelect: !0,
                infinite: !1,
                prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>'
            }),
            s(".slider-nav-thumbnails .slick-slide").removeClass("slick-active"),
            s(".slider-nav-thumbnails .slick-slide").eq(0).addClass("slick-active"),
            s(".product-image-slider").on("beforeChange", (function(e, i, t, a) {
                var o = a;
                s(".slider-nav-thumbnails .slick-slide").removeClass("slick-active"),
                s(".slider-nav-thumbnails .slick-slide").eq(o).addClass("slick-active")
            }
            ));
            var i = s(".product-image-slider");
            i.length && i.map((function(e, i) {
                s(i).magnificPopup({
                    delegate: ".slick-slide:not(.slick-cloned) a",
                    type: "image",
                    gallery: {
                        enabled: !0
                    }
                })
            }
            )),
            s(".list-filter").each((function() {
                s(this).find("a").on("click", (function(e) {
                    e.preventDefault(),
                    s(this).parent().siblings().removeClass("active"),
                    s(this).parent().toggleClass("active"),
                    s(this).parents(".attr-detail").find(".current-size").text(s(this).text()),
                    s(this).parents(".attr-detail").find(".current-color").text(s(this).attr("data-color"))
                }
                ))
            }
            )),
            s(document).on("click", ".dropdown-menu .cart_list", (function(s) {
                s.stopPropagation()
            }
            ))
        }(),
        v(),
        s(window).resize((function() {
            v()
        }
        )),
        s(".product-detail-rating > a").on("click", (function(e) {
            e.preventDefault();
            var i = s(this).attr("href");
            s(".product-info .nav-tabs li a").removeClass("active"),
            s('.product-info .nav-tabs a[href="' + i + '"]').addClass("active"),
            s(i).addClass("active show"),
            s(i).siblings(".tab-pane").removeClass("active show"),
            s("html, body").animate({
                scrollTop: s(i).offset().top - s(".header-bottom.sticky-bar").height() - 220 + "px"
            }, 800)
        }
        ))
    }
    )),
    document.addEventListener("ecommerce.product-filter.success", (function(s) {
        o()
    }
    )),
    document.addEventListener("ecommerce.cart.added", (function(e) {
        var i = e.detail
          , t = i.data;
        i.message,
        t && void 0 !== t.count && (s(".mini-cart-icon span").text(t.count),
        s(".cart-dropdown-wrap .header-cart-count").text(t.count)),
        t && t.additional && t.additional.html && s(".cart-dropdown-panel").html(t.additional.html),
        t && !t.additional && window.siteUrl && s.ajax({
            url: window.siteUrl + "/ajax/cart",
            type: "GET",
            success: function(e) {
                if (!e.error) {
                    var i = s(".cart-dropdown-panel");
                    i.length && e.data.html && i.html(e.data.html);
                    var t = s(".cart-dropdown-wrap .header-cart-count");
                    t.length && void 0 !== e.data.count && t.text(e.data.count)
                }
            }
        })
    }
    )),
    document.addEventListener("ecommerce.quick-shop.completed", (function(e) {
        var i = e.detail.modal;
        if (i && i.length) {
            var t = i.find(".product-attributes");
            t.length && t.attr("data-quick-shop", "true"),
            i.find(".qty-up, .qty-down").each((function() {
                var e = s(this);
                "#" === e.attr("href") && e.attr("href", "javascript:void(0)")
            }
            ));
            var a = i.find(".add-to-cart-form");
            a.length && "#" === a.attr("action") && a.attr("action", a.data("url") || '{{ route("public.ajax.cart.store") }}')
        }
    }
    ));
    var b = window.history.pushState
      , S = window.history.replaceState
      , k = !1;
    function T() {
        "undefined" != typeof ChangeProductSwatches && (ChangeProductSwatches.prototype._originalCallAjax || (ChangeProductSwatches.prototype._originalCallAjax = ChangeProductSwatches.prototype.callAjax,
        ChangeProductSwatches.prototype._originalHandleResponse = ChangeProductSwatches.prototype.handleResponse,
        ChangeProductSwatches.prototype.callAjax = function(s, e, i, t, a) {
            return (e.closest("#quick-shop-modal").length || "true" === e.attr("data-quick-shop")) && (t = !1),
            this._originalCallAjax.call(this, s, e, i, t, a)
        }
        ,
        ChangeProductSwatches.prototype.handleResponse = function(s, e, i) {
            return (e.closest("#quick-shop-modal").length || "true" === e.attr("data-quick-shop")) && (i = !1),
            this._originalHandleResponse.call(this, s, e, i)
        }
        ))
    }
    window.history.pushState = function() {
        if (!k)
            return b.apply(window.history, arguments)
    }
    ,
    window.history.replaceState = function() {
        if (!k)
            return S.apply(window.history, arguments)
    }
    ,
    s(document).on("show.bs.modal", "#quick-shop-modal", (function() {
        k = !0
    }
    )),
    s(document).on("hidden.bs.modal", "#quick-shop-modal", (function() {
        k = !1
    }
    )),
    T(),
    s(document).ready((function() {
        T()
    }
    )),
    setTimeout(T, 100)
}(jQuery);
