$(window).on('load',function(){
  "use strict";
	$(window).on('load', function () {
		$('#preloader').delay(350).fadeOut('slow');
		$('body').delay(350).css({ 'overflow': 'visible' });
	})

	/*---- Bottom To Top Scroll Script ---*/
	$(window).on('scroll', function() {
		var height = $(window).scrollTop();
		if (height > 100) {
			$('#back2Top').fadeIn();
		} else {
			$('#back2Top').fadeOut();
		}
	});

	$("#back2Top").on('click', function(event) {
		event.preventDefault();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});

    // Navigation
	! function(n, e, i, a) {
		n.navigation = function(t, s) {
			var o = {
					responsive: !0,
					mobileBreakpoint:992,
					showDuration: 300,
					hideDuration: 300,
					showDelayDuration: 0,
					hideDelayDuration: 0,
					submenuTrigger: "hover",
					effect: "fade",
					submenuIndicator: !0,
					hideSubWhenGoOut: !0,
					visibleSubmenusOnMobile: !1,
					fixed: !1,
					overlay: !0,
					overlayColor: "rgba(0, 0, 0, 0.5)",
					hidden: !1,
					offCanvasSide: "left",
					onInit: function() {},
					onShowOffCanvas: function() {},
					onHideOffCanvas: function() {}
				},
				u = this,
				r = Number.MAX_VALUE,
				d = 1,
				f = "click.nav touchstart.nav",
				l = "mouseenter.nav",
				c = "mouseleave.nav";
			u.settings = {};
			var t = (n(t), t);
			n(t).find(".nav-menus-wrapper").prepend("<span class='nav-menus-wrapper-close-button'>✕</span>"), n(t).find(".nav-search").length > 0 && n(t).find(".nav-search").find("form").prepend("<span class='nav-search-close-button'>✕</span>"), u.init = function() {
				u.settings = n.extend({}, o, s), "right" == u.settings.offCanvasSide && n(t).find(".nav-menus-wrapper").addClass("nav-menus-wrapper-right"), u.settings.hidden && (n(t).addClass("navigation-hidden"), u.settings.mobileBreakpoint = 99999), v(), u.settings.fixed && n(t).addClass("navigation-fixed"), n(t).find(".nav-toggle").on("click touchstart", function(n) {
					n.stopPropagation(), n.preventDefault(), u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")
				}), n(t).find(".nav-menus-wrapper-close-button").on("click touchstart", function() {
					u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")
				}), n(t).find(".nav-search-button").on("click touchstart", function(n) {
					n.stopPropagation(), n.preventDefault(), u.toggleSearch()
				}), n(t).find(".nav-search-close-button").on("click touchstart", function() {
					u.toggleSearch()
				}), n(t).find(".megamenu-tabs").length > 0 && y(), n(e).resize(function() {
					m(), C()
				}), m(), s !== a && u.callback("onInit")
			};
			var v = function() {
				n(t).find("li").each(function() {
					n(this).children(".nav-dropdown,.megamenu-panel").length > 0 && (n(this).children(".nav-dropdown,.megamenu-panel").addClass("nav-submenu"), u.settings.submenuIndicator && n(this).children("a").append("<span class='submenu-indicator'><span class='submenu-indicator-chevron'></span></span>"))
				})
			};
			u.showSubmenu = function(e, i) {
				g() > u.settings.mobileBreakpoint && n(t).find(".nav-search").find("form").slideUp(), "fade" == i ? n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).fadeIn(u.settings.showDuration) : n(e).children(".nav-submenu").stop(!0, !0).delay(u.settings.showDelayDuration).slideDown(u.settings.showDuration), n(e).addClass("nav-submenu-open")
			}, u.hideSubmenu = function(e, i) {
				"fade" == i ? n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).fadeOut(u.settings.hideDuration) : n(e).find(".nav-submenu").stop(!0, !0).delay(u.settings.hideDelayDuration).slideUp(u.settings.hideDuration), n(e).removeClass("nav-submenu-open").find(".nav-submenu-open").removeClass("nav-submenu-open")
			};
			var h = function() {
					n("body").addClass("no-scroll"), u.settings.overlay && (n(t).append("<div class='nav-overlay-panel'></div>"), n(t).find(".nav-overlay-panel").css("background-color", u.settings.overlayColor).fadeIn(300).on("click touchstart", function(n) {
						u.hideOffcanvas()
					}))
				},
				p = function() {
					n("body").removeClass("no-scroll"), u.settings.overlay && n(t).find(".nav-overlay-panel").fadeOut(400, function() {
						n(this).remove()
					})
				};
			u.showOffcanvas = function() {
				h(), "left" == u.settings.offCanvasSide ? n(t).find(".nav-menus-wrapper").css("transition-property", "left").addClass("nav-menus-wrapper-open") : n(t).find(".nav-menus-wrapper").css("transition-property", "right").addClass("nav-menus-wrapper-open")
			}, u.hideOffcanvas = function() {
				n(t).find(".nav-menus-wrapper").removeClass("nav-menus-wrapper-open").on("webkitTransitionEnd moztransitionend transitionend oTransitionEnd", function() {
					n(t).find(".nav-menus-wrapper").css("transition-property", "none").off()
				}), p()
			}, u.toggleOffcanvas = function() {
				g() <= u.settings.mobileBreakpoint && (n(t).find(".nav-menus-wrapper").hasClass("nav-menus-wrapper-open") ? (u.hideOffcanvas(), s !== a && u.callback("onHideOffCanvas")) : (u.showOffcanvas(), s !== a && u.callback("onShowOffCanvas")))
			}, u.toggleSearch = function() {
				"none" == n(t).find(".nav-search").find("form").css("display") ? (n(t).find(".nav-search").find("form").slideDown(), n(t).find(".nav-submenu").fadeOut(200)) : n(t).find(".nav-search").find("form").slideUp()
			};
			var m = function() {
					u.settings.responsive ? (g() <= u.settings.mobileBreakpoint && r > u.settings.mobileBreakpoint && (n(t).addClass("navigation-portrait").removeClass("navigation-landscape"), D()), g() > u.settings.mobileBreakpoint && d <= u.settings.mobileBreakpoint && (n(t).addClass("navigation-landscape").removeClass("navigation-portrait"), k(), p(), u.hideOffcanvas()), r = g(), d = g()) : k()
				},
				b = function() {
					n("body").on("click.body touchstart.body", function(e) {
						0 === n(e.target).closest(".navigation").length && (n(t).find(".nav-submenu").fadeOut(), n(t).find(".nav-submenu-open").removeClass("nav-submenu-open"), n(t).find(".nav-search").find("form").slideUp())
					})
				},
				g = function() {
					return e.innerWidth || i.documentElement.clientWidth || i.body.clientWidth
				},
				w = function() {
					n(t).find(".nav-menu").find("li, a").off(f).off(l).off(c)
				},
				C = function() {
					if (g() > u.settings.mobileBreakpoint) {
						var e = n(t).outerWidth(!0);
						n(t).find(".nav-menu").children("li").children(".nav-submenu").each(function() {
							n(this).parent().position().left + n(this).outerWidth() > e ? n(this).css("right", 0) : n(this).css("right", "auto")
						})
					}
				},
				y = function() {
					function e(e) {
						var i = n(e).children(".megamenu-tabs-nav").children("li"),
							a = n(e).children(".megamenu-tabs-pane");
						n(i).on("click.tabs touchstart.tabs", function(e) {
							e.stopPropagation(), e.preventDefault(), n(i).removeClass("active"), n(this).addClass("active"), n(a).hide(0).removeClass("active"), n(a[n(this).index()]).show(0).addClass("active")
						})
					}
					if (n(t).find(".megamenu-tabs").length > 0)
						for (var i = n(t).find(".megamenu-tabs"), a = 0; a < i.length; a++) e(i[a])
				},
				k = function() {
					w(), n(t).find(".nav-submenu").hide(0), navigator.userAgent.match(/Mobi/i) || navigator.maxTouchPoints > 0 || "click" == u.settings.submenuTrigger ? n(t).find(".nav-menu, .nav-dropdown").children("li").children("a").on(f, function(i) {
						if (u.hideSubmenu(n(this).parent("li").siblings("li"), u.settings.effect), n(this).closest(".nav-menu").siblings(".nav-menu").find(".nav-submenu").fadeOut(u.settings.hideDuration), n(this).siblings(".nav-submenu").length > 0) {
							if (i.stopPropagation(), i.preventDefault(), "none" == n(this).siblings(".nav-submenu").css("display")) return u.showSubmenu(n(this).parent("li"), u.settings.effect), C(), !1;
							if (u.hideSubmenu(n(this).parent("li"), u.settings.effect), "_blank" == n(this).attr("target") || "blank" == n(this).attr("target")) e.open(n(this).attr("href"));
							else {
								if ("#" == n(this).attr("href") || "" == n(this).attr("href")) return !1;
								e.location.href = n(this).attr("href")
							}
						}
					}) : n(t).find(".nav-menu").find("li").on(l, function() {
						u.showSubmenu(this, u.settings.effect), C()
					}).on(c, function() {
						u.hideSubmenu(this, u.settings.effect)
					}), u.settings.hideSubWhenGoOut && b()
				},
				D = function() {
					w(), n(t).find(".nav-submenu").hide(0), u.settings.visibleSubmenusOnMobile ? n(t).find(".nav-submenu").show(0) : (n(t).find(".nav-submenu").hide(0), n(t).find(".submenu-indicator").removeClass("submenu-indicator-up"), u.settings.submenuIndicator ? n(t).find(".submenu-indicator").on(f, function(e) {
						return e.stopPropagation(), e.preventDefault(), u.hideSubmenu(n(this).parent("a").parent("li").siblings("li"), "slide"), u.hideSubmenu(n(this).closest(".nav-menu").siblings(".nav-menu").children("li"), "slide"), "none" == n(this).parent("a").siblings(".nav-submenu").css("display") ? (n(this).addClass("submenu-indicator-up"), n(this).parent("a").parent("li").siblings("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), n(this).closest(".nav-menu").siblings(".nav-menu").find(".submenu-indicator").removeClass("submenu-indicator-up"), u.showSubmenu(n(this).parent("a").parent("li"), "slide"), !1) : (n(this).parent("a").parent("li").find(".submenu-indicator").removeClass("submenu-indicator-up"), void u.hideSubmenu(n(this).parent("a").parent("li"), "slide"))
					}) : k())
				};
			u.callback = function(n) {
				s[n] !== a && s[n].call(t)
			}, u.init()
		}, n.fn.navigation = function(e) {
			return this.each(function() {
				if (a === n(this).data("navigation")) {
					var i = new n.navigation(this, e);
					n(this).data("navigation", i)
				}
			})
		}
	}
	(jQuery, window, document), $(document).ready(function() {
		$("#navigation").navigation()
	});

	$(window).scroll(function() {
		var scroll = $(window).scrollTop();

		if (scroll >= 50) {
			$(".header").addClass("header-fixed");
		} else {
			$(".header").removeClass("header-fixed");
		}
	});

	// Script For Select Adult & Child Number
	$(function() {

	  var guestAmount = $('#guestNo');

	  $('#cnt-up').on('click', function() {
		guestAmount.val(Math.min(parseInt($('#guestNo').val()) + 1, 20));
	  });
	  $('#cnt-down').on('click', function() {
		guestAmount.val(Math.max(parseInt($('#guestNo').val()) - 1, 1));
	  });

	});

	$(function() {

	  var guestAmount = $('#kidsNo');

	  $('#kcnt-up').on('click', function() {
		guestAmount.val(Math.min(parseInt($('#kidsNo').val()) + 1, 20));
	  });
	  $('#kcnt-down').on('click', function() {
		guestAmount.val(Math.max(parseInt($('#kidsNo').val()) - 1, 0));
	  });
	});

	// Compare Slide
	$('.csm-trigger').on('click', function() {
		$('.compare-slide-menu').toggleClass('active');
	});
	$('.compare-button').on('click', function() {
		$('.compare-slide-menu').addClass('active');
	});

	// Property Slide
  $('.lds-dual-ring').fadeOut()
  $('.property-slide').fadeIn()
  $('.property-slide').slick({
    lazyLoad: 'ondemand',
    infinite: true,
    speed: 300,
    autoplay:true,
    arrows:false,
    dots:true,
    slidesToShow: 3,
    slidesToScroll:2,
    prevArrow:'<div class="prev-slick"><span class="ti ti-arrow-left"></span><span class="sr-only">Prev</span></div>',
    nextArrow:'<div class="next-slick"><span class="ti ti-arrow-right"></span><span class="sr-only">Next</span></div>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
	// Featured Slick Slider
  $('.lds-dual-ring').fadeOut()
  $('.featured_slick_gallery-slide').fadeIn()
	$('.featured_slick_gallery-slide').slick({
		dots: false,
    arrows:false,
    infinite: true,
    autoplay:true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 4,
    prevArrow:'<i class="fa fa-angle-left"></i>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
	});

  //click slide
  $('.click').slick({
	  slidesToShow:1,
	  slidesToScroll: 1,
	  autoplay:false,
	  autoplaySpeed: 2000,
	});


	// Range Slider Script
	$(".js-range-slider").ionRangeSlider({
		type: "double",
		min: 0,
		max: 1000,
		from: 200,
		to: 500,
		grid: true
	});

	// Select Bedrooms
	if($('#bedrooms').length){
		$('#bedrooms').select2({
			placeholder: "Chambres",
			allowClear: true
		});
	}


	// Select Bathrooms
	if($('#bathrooms').length){
		$('#bathrooms').select2({
			placeholder: "Salles de bain",
			allowClear: true
		});
	}
	

	// Select Property Types
	if($('#ptypes').length){
		$('#ptypes').select2({
			placeholder: "Show All",
			allowClear: true
		});
	}
	

	// Select Property Types
	if($('#status').length){
		$('#status').select2({
			placeholder: "Show All",
			allowClear: true
		});
	}


	// specialisms
	if($('#shorty').length){
		$('#shorty').select2({
			placeholder: "Show All",
			allowClear: true
		});
	}
	

	// Select Min price
	if($('#minprice').length){
		$('#minprice').select2({
			placeholder: "No Min",
			allowClear: true
		});
	}


	// Select built
	if($('#built').length){
		$('#built').select2({
			placeholder: "Year Built",
			allowClear: true
		});
	}
	

	// Select Max Price
	if($('#maxprice').length){
		$('#maxprice').select2({
			placeholder: "No Max",
			allowClear: true
		});
	}
	

	// Select Country
	if($('#country').length){
		$('#country').select2({
			placeholder: "Country",
			allowClear: true
		});
	}
	

	// Select Town
	if($('.select').length){
		$('.select').select2({
			placeholder: "Famille de biens",
			allowClear: true
		});
	}

	if($('.cpt').length){
		$('.cpt').select2({
			placeholder: "Type de transaction",
			allowClear: true
		});
	}


	// Select Town
	if($('#location').length){
		$('#location').select2({
			placeholder: "Shaow All",
			allowClear: true
		});
	}


	// Select Cities
	if($('#cities').length){
		$('#cities').select2({
			placeholder: "All Cities",
			allowClear: true
		});
	}
	

	// Select Status
	if($('#status').length){
		$('#status').select2({
			placeholder: "Select Status",
			allowClear: true
		});
	}
	

	// Select Rooms
	if($('#rooms').length){
		$('#rooms').select2({
			placeholder: "Choose Rooms",
			allowClear: true
		});
	}


	// Select Garage
	if($('#garage').length){
		$('#garage').select2({
			placeholder: "Choose Rooms",
			allowClear: true
		});
	}
	
 

  $("#showbutton").click(function(){
      $("#showing").slideToggle("slow");
  });



	// Featured Slick Slider
  $('.featured-slick-slide').fadeIn()
  $('.featured-slick-slide').slick({
    dots: true,
    arrows:false,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 2,
    prevArrow:'<div class="prev-slick"><span class="ti ti-arrow-left"></span><span class="sr-only">Prev</span></div>',
    nextArrow:'<div class="next-slick"><span class="ti ti-arrow-right"></span><span class="sr-only">Next</span></div>',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

	// fullwidth home slider
	function inlineCSS() {
		$(".home-slider .item").each(function() {
			var attrImageBG = $(this).attr('data-background-image');
			var attrColorBG = $(this).attr('data-background-color');
			if (attrImageBG !== undefined) {
				$(this).css('background-image', 'url(' + attrImageBG + ')');
			}
			if (attrColorBG !== undefined) {
				$(this).css('background', '' + attrColorBG + '');
			}
		});
	}
	inlineCSS();

	// Search Radio
	function searchTypeButtons() {
		$('.property-search-type label.active input[type="radio"]').prop('checked', true);
		var buttonWidth = $('.property-search-type label.active').width();
		var arrowDist = $('.property-search-type label.active').position();
		$('.property-search-type-arrow').css('left', arrowDist + (buttonWidth / 2));
		$('.property-search-type label').on('change', function() {
			$('.property-search-type input[type="radio"]').parent('label').removeClass('active');
			$('.property-search-type input[type="radio"]:checked').parent('label').addClass('active');
			var buttonWidth = $('.property-search-type label.active').width();
			var arrowDist = $('.property-search-type label.active').position().left;
			$('.property-search-type-arrow').css({
				'left': arrowDist + (buttonWidth / 1.7),
				'transition': 'left 0.4s cubic-bezier(.95,-.41,.19,1.44)'
			});
		});
	}
	if ($(".hero-banner").length) {
		searchTypeButtons();
		$(window).on('load resize', function() {
			searchTypeButtons();
		});
	}

});
