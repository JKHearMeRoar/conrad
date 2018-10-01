/**
 * CheerUp Theme Utilities
 * 
 * Copyright (c) 2018 ThemeSphere.
 */
var Bunyad_Theme = (function($) {
	"use strict";
	
	var has_touch = false,
		responsive_menu = false,
		search_active = false,
		has_sticky_nav = false,
		sticky_bar_active = false
	
	// module
	var self = {
		
		init: function() 
		{	
			// Reflow bug fix for webkit
			var nav = $('.navigation .menu ul').css('-webkit-box-sizing', 'border-box');
			requestAnimationFrame(function() {
				nav.css('-webkit-box-sizing', '');
			});
			
			/**
			 * Woocommerce
			 */ 
			$('.woocommerce-ordering .drop li a').on('click', function(e) {
				var form = $(this).closest('form');
				
				form.find('[name=orderby]').val($(this).parent().data('value'));
				form.submit();
				
				e.preventDefault();
			});	
			
			$('.woocommerce .related > h2, .woocommerce .upsells > h2')
				.addClass('block-heading').wrapInner('<span class="title" />');
			
			
			// Fit videos to container
			$('.featured-vid, .post-content').fitVids();
			
			// Add overlays to footer instagram
			if ($('.mid-footer .instagram-pics').length) {
				var link = $('.mid-footer .clear a');
				link.addClass('overlay').html('<i class="fa fa-instagram"></i>' + link.text());
			}
			
			// Back to top handler
			$('.back-to-top').on('click', function() {
				
				// Using both html, body until scrollingElement has more support
				$('html, body').animate({scrollTop: 0}, 800);
				return false;
			});
			
			// Go back handler
			$('.go-back').on('click', function() { 
				window.history.back();
				return false;
			});
			
			// Post ticker
			$('.posts-ticker ul').each(function() {
				
				if (!$(this).find('li.active').length) {
					$(this).find('li:first').addClass('active');
				}
				
				var ticker = $(this);
				
				window.setInterval(function() {
					
					var active = ticker.find('li.active');
					active.fadeOut(function() {
						
						var next = active.next();
						if (!next.length) {
							next = ticker.find('li:first');
						}
						
						next.addClass('active').fadeIn();
						active.removeClass('active');
					});
					
				}, 8000);
			});
			
			if (navigator.platform.toLowerCase().indexOf('win') !== -1) {
				$('html').addClass('is-win');
			}
			
			// Fix Firefox Bug #1149357
			if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
				
				var logo = $('.logo-image');
				if ($('.logo-image').length) {
					
					// order maters - attach event first
					$('<img />').on('load', function() {
						
						// picked 2x logo? set 1x dimension to prevent firefox overflowing
						if (logo.prop('currentSrc') !== logo.prop('src')) {
							logo.prop('width', $(this)[0].naturalWidth).prop('height', $(this)[0].naturalHeight);
						}
						
					}).attr('src', logo.attr('src'));
				}
			}
			
			/**
			 * Header Parallax - for style 7
			 */
			var header = $('.main-head.top-below .inner'),
				bg = header.css('background-image');
			
			if ($(window).width() > 940 && (bg && bg != 'none')) {
				var parallax = $('<div class="parallax" />').css('background-image', bg);
				header.append(parallax);
				header.css('background-image', 'none');
				
				var bottom = parallax.offset().top + parallax.outerHeight(),
					top = parallax.offset().top;
				
				$(window).on('scroll', function() {
					
					var scroll = $(window).scrollTop();
					
					// Already scrolled enough
					if (scroll > bottom) {
						return;
					}
					
					var distance = scroll * 0.4;
					
					requestAnimationFrame(function() {
						parallax.css('transform', 'translate3d(0,' + distance + 'px, 0)');
					});
				});
			}
			
			// VC Blocks fix
			$('.blocks .block').last().addClass('last-block');
			
			// Setup search
			this.search();
			
			// Setup all sliders
			this.sliders();

			// Setup mobile & touch navigation
			this.responsive_nav();
			
			// Setup mega menus
			this.mega_menus();
			
			// Setup sticky top-bar
			this.sticky_bar();
			
			// Sticky sidebar
			this.sticky_sidebar();
						
			// Lightbox for images
			this.lightbox();
			
			// Likes system
			this.likes();
			
			// Single post functionality
			this.single();
			
			// Lazyload setup
			this.lazy_load();
			
			// Masonry layouts setup
			this.masonry();

			// add support for placeholder in IE9
			$('input, textarea').placeholder();
			
			// Pin buttons
			this.pin_it();
		},

		/**
		 * Setup responsive and touch
		 */
		responsive_nav: function()
		{
			// detect touch capability dynamically
			$(window).on('touchstart', function() {
				has_touch = true;
				$('body').addClass('touch');
			});
			
			this.init_responsive_nav();
			this.touch_nav();
			var that = this;

			$(window).on('resize orientationchange', function() {
				that.init_responsive_nav();
			});		
		},
		
		/**
		 * Setup the responsive nav events and markup
		 */
		init_responsive_nav: function() {
			
			if ($(window).width() > 940 || responsive_menu) {
				return;
			}
			
			// Set responsive initialized
			responsive_menu = true;
			
			// Create off-canvas container
			var menu_contain = $('.mobile-menu-container');
			
			// No items for mobile menu? Grab from others
			if (!menu_contain.find('.mobile-menu').children().length) {
				
				// Merge existing menus
				var mobile_menu = menu_contain.find('.mobile-menu'),
				    main_menu = $('.navigation .menu');
				
				var menu = main_menu.children().clone();
				
				if (!main_menu.length) {
					return;
				}
				
				// add category mega menu links
				menu.find('.mega-menu .sub-cats').each(function() {
					var container = $(this).closest('.menu-item');
					
					container.append($(this).find('.sub-nav'));
					container.find('.sub-nav').replaceWith(function() {
						return $('<ul />', {html: $(this).html()});
					});
					
					$(this).remove();
					
				});
				
				mobile_menu.append(menu);
			}
			
			$('body').addClass('nav-off-canvas');
			
			// Setup mobile menu click handlers
			$('.mobile-menu li > a').each(function() {
				
				if ($(this).parent().children('ul').length) {
					$('<span class="chevron"><i class="fa fa-chevron-down"></i></span>').appendTo($(this));
				}
			});
			
			$('.mobile-menu li .chevron').click(function() {
					$(this).closest('li').find('ul').first().slideToggle().parent().toggleClass('active item-active');
					return false;
			});
			
			// Menu open handler
			$('.top-bar .mobile-nav, .main-head .mobile-nav').on('click', function() {
				$('.mobile-menu').addClass('active');
            	$('body').toggleClass('off-canvas-active');
            	$('html').toggleClass('hide-scroll');
			});
			
			// Off-canvas close
			$('.off-canvas .close').click(function() {
				$('body').toggleClass('off-canvas-active');
			});
		},

		/**
		 * Setup touch for touch devices
		 */
		touch_nav: function() {
			
			var targets = $('.menu:not(.mobile-menu) a'),
				open_class = 'item-active',
				child_tag = 'ul, .mega-menu';
			
			targets.each(function() {
				
				var $this = $(this),
					$parent = $this.parent('li'),
					$siblings = $parent.siblings().find('a');
				
				$this.click(function(e) {
					
					if (!has_touch) {
						return;
					}
					
					var $this = $(this);
					e.stopPropagation();
					
					$siblings.parent('li').removeClass(open_class);
					
					// has a child? open the menu on tap
					if (!$this.parent().hasClass(open_class) && $this.next(child_tag).length > 0 && !$this.parents('.mega-menu.links').length) {
						e.preventDefault();
						$this.parent().addClass(open_class);
					}
				});
			});
			
			// close all menus
			$(document).click(function(e) {
				if (!$(e.target).is('.menu') && !$(e.target).parents('.menu').length) {
					targets.parent('li').removeClass(open_class);
				}
			});
		},
		
		/**
		 * Search setup
		 */
		search: function() 
		{
			// Nav Search
			$('.main-head .search-link').on('click', function() {
				
				var overlay = $(this).parent().find('.search-box-overlay');
				
				search_active = true;
				if (overlay.hasClass('active')) {
					search_active = false;
				}
				
				overlay.toggleClass('active');
				
				return false;
			});
			
			// Search bar for alt header
			var search_active_alt = false;
			$('.search-alt .top-bar .search-submit').on('click', function() {
				if (!search_active_alt) {
					$(this).closest('form').find('.search-field').addClass('active').focus();
					search_active_alt = true;
					
					return false;
				} 
			});
			
			// Hide search on outside clicks
			$(document).on('click', function(e) {
				if (search_active && !$(e.target).parents('.search-box-overlay').length) {
					$('.main-head .search-link').click();
				}
				
				// Hide alt header search
				if (search_active_alt && !$(e.target).parents('.top-bar').length) {
					search_active_alt = false;
					
					$('.main-head.search-alt .search-submit')
						.closest('form').find('.search-field').removeClass('active');
				}
			});
		},
		
		/**
		 * Mega Menus
		 */
		mega_menus: function()
		{
			// Bind events for mega menus
			$('.navigation .mega-menu').each(function() {
				
				var menu = $(this),
				    number = 4;
				
				if (menu.find('.one-fifth').length) {
					number = 5;
				}
				
				var slick_vars = {
					draggable: false,
					infinite: true,
					slidesToShow: number,
					slidesToScroll: number,
					arrows: false
				};
				
				// Helper to re-init
				var slick_init = function(posts) {
					if (!posts.hasClass('slick-initialized')) {
						posts.slick(slick_vars);
					}
					// Race condition? Might have calculated while hiding - recalc pos
					else if (posts.find('.slick-track').width() == 0) {
						posts.slick('setPosition');
					}
				};
				
				// Init mega menus
				var default_mega_menu = function f() {
					slick_init( menu.find('.posts').last().addClass('active') );
					return f;
				}();

				// Mega-menu sub-cats handling
				menu.find('.menu-item').on('mouseenter', function() {

					var id = parseInt( $(this).attr('class').match(/menu-cat-(\d+)/)[1] || 0 ),
					    menu = $(this).parents('.mega-menu'),
					    view_all = $(this).hasClass('view-all');
				
					if (!view_all && !id) {
						return;
					}
					
					// remove other actives
					menu.find('.active, .current-menu-item').removeClass('active current-menu-item');

					// activate current
					$(this).addClass('current-menu-item');
					var posts = menu.find('[data-id=' + id + ']').addClass('active');
				
					slick_init(posts);
					
					if (posts.find('.post').length < 5) {
						posts.parent().find('.navigate').hide();
					}
					else {
						posts.parent().find('.navigate').show();
					}
					
					return false;
				});
				
				// Reset mega menu state on fresh hover
				menu.parent().on('mouseenter', function() {
					
					var menu = $(this).find('.mega-menu');
					
					// reset at beginning
					menu.find('.active, .current-menu-item')
						.removeClass('active current-menu-item');

					$(this)[0].offsetWidth; // reflow
					default_mega_menu();
				});
				
			});
			
			// Mega menu pagination
			$('.mega-menu .show-next, .mega-menu .show-prev').on('click', function() {
				
				var current = $(this).parents('.mega-menu').find('.posts.active'),
				    action  = $(this).hasClass('show-prev') ? 'slickPrev' : 'slickNext';
				
				current.slick(action);
				
				return false;
			});	
		},

		/**
		 * Setup sticky bar if enabled
		 */
		sticky_bar: function()
		{
			var nav,
			    top_bar = $('.top-bar-content'),
			    is_smart = false,
			    is_sticky = false,
			    is_static = false,
			    prev_scroll = 0,
			    cur_scroll = 0,
			    extra_top = 0,
			    nav_top,
			    hide_at,
				head = $('.main-head');
			

			// Set height for container
			var set_size = function() {
				
				// Don't reset if it's stuck
				if (sticky_bar_active) {
					return;
				}

				// in raf to throttle resize events
				requestAnimationFrame(function() {
					var new_height = head.css('min-height', 0).height();
					head.css('min-height', new_height);
				});
			};
			
			$(window).on('load resize', set_size);
			
			var init = function() {
				
				// Reset vars - might be a re-init
				is_static = false;
				
				// Android fix on addr bar hide
				if (is_smart && !sticky_bar_active) {
					prev_scroll = 0;
				}
				
				if ($('.admin-bar').length) {
					extra_top = $('#wpadminbar').height();
				}

				// Enable smart at responsive
				if ($(window).width() < 940) {
					is_smart = true;
				}
				else {
					is_smart = false;
				}
				//is_smart = true;
				
				// Target sticky based on header layout
				if (head.is('.nav-below, .top-below')) {
					
					// Top bar below or nav-below-logo types
					nav = head.hasClass('nav-below') ? $('.navigation.below') : top_bar;
					
					nav_top = nav.offset().top - extra_top;
					hide_at = nav_top + 1;
				}
				// Compact has a sticky topbar configured below
				else if (head.is('.simple') || (head.is('.compact') && $(window).width() >= 940)) {
					
					// Top bar below or nav below logo types
					nav = head.find('.inner').first();
					
					nav_top = head.offset().top + (head.height()/2) - extra_top;
					hide_at = nav_top + 200;
				}
				else if (top_bar.length) {
				
					// static sticky via CSS unless it's smart sticky
					if (!is_smart && top_bar.data('sticky-bar')) {
						top_bar.addClass('sticky-bar');
						is_static = true;
					}
					
					nav = top_bar;
					
					// default 
					var pos_ele  = $('.top-bar');
					
					nav_top  = pos_ele.offset().top - extra_top,
					hide_at  = nav_top + 1;
				}
				
				// Is smart?
				if (nav.data('sticky-bar') == 'smart') {
					is_smart = true;
				}
			};
			
			// Init and calculate defaults
			init();
			
			if (!nav) {
				return;
			}
			
			// not enabled?
			if (!nav.data('sticky-bar')) {
				return;
			}
		
			has_sticky_nav = true;
			
			if (nav.find('.sticky-logo').length) {
				nav.addClass('has-logo');
			}
			
			// disable the sticky nav
			var remove_sticky = function() {
				
				// check before dom modification 
				if (is_sticky) {
					
					sticky_bar_active = 0;
					nav.removeClass('sticky-bar');
					set_size();
					
					$(document).trigger('sticky-bar-hide');
				}
			};
			
			// Check and apply sticky - separated writes
			var sticky_writes = writeRaf(function() {
				
				// make it sticky when viewport is scrolled beyond the navigation
				if (cur_scroll > nav_top) {
					
					// for smart sticky, test for scroll change
					if (is_smart && (!prev_scroll || cur_scroll > prev_scroll)) {
						remove_sticky();
					}
					else {
						sticky_bar_active = 1;
						
						if (!nav.hasClass('sticky-bar')) {
							nav.addClass('sticky-bar no-transition');
						
							setTimeout(function() { 
								nav.removeClass('no-transition'); 
							}, 100);
							
							$(document).trigger('sticky-bar-show');
						}
					}
					
					prev_scroll = cur_scroll;
					
				} else {
					
					// hide at a certain point
					if (cur_scroll <= hide_at) {
						remove_sticky();
					}
				}
			});
			
			// Make the nav sticky
			var sticky = function() {

				if (!nav.data('sticky-bar') || is_static) {
					return;
				}

				cur_scroll = $(window).scrollTop();
				is_sticky  = nav.hasClass('sticky-bar');
				
				sticky_writes();
			};

			sticky();

			$(window).on('scroll', function() {
				sticky();
			});
			
			// Re-initialize on resize
			$(window).on('resize orientationchange', function() {
				init();
				sticky();
			});
		},
		
		/**
		 * Setup sticky sidebar
		 */
		sticky_sidebar: function() 
		{
			
			// Sidebar class on the widget element? Move it up
			$('.main .sidebar').each(function() {
				if ($(this).hasClass('wpb_content_element')) {
					var parent = $(this).closest('.wpb_column'),
						classes = 'sidebar';
					
					if ($(this).hasClass('sticky-col')) {
						classes += ' sticky-col';
					}
					
					parent.addClass(classes);
					$(this).removeClass(classes);
				}
			});
			
			var sticky = $('.main .sticky-col, .main .sidebar[data-sticky=1]');
			
			if (!sticky.length) {
				return;
			}
			
			var add = 20;
			if ($('.admin-bar').length) {
				add += 32;
			}
			
			if (has_sticky_nav) {
				add += 50;
			}
			
			sticky.each(function() {
			
				var parent_col = $(this);
				
				// Add wrapper class if missing
				if (!parent_col.find('.theiaStickySidebar').length) {
					parent_col.find('.wpb_wrapper').first().addClass('theiaStickySidebar');
				}
				
				parent_col.theiaStickySidebar({
					minWidth: 940, 
					updateSidebarHeight: false,
					additionalMarginTop: add
				});
			});
			
			// for iframe loads in sidebar
			$(window).on('load', function() {
				setTimeout(function() {
					$(window).trigger('resize.TSS');
				}, 2500);
			});
		},
		
		/**
		 * Single post functionality
		 */
		single: function()
		{
			if (!$('body').hasClass('single-post')) {
				return;
			}

			/**
			 * Social sharing
			 */
			// Single top social sharing view all buttons
			$('.post-share-b .show-more').on('click', function() {
				$(this).parent().addClass('all');
				return false;
			});
			
			var float_share = function() {
				// Floating social sharing
				var add = 20;
				add += $('.admin-bar').length ? 32 : 0;
				add += has_sticky_nav ? 50 : 0;
				var width = $(window).width();
				
				$('.post-share-float').each(function() {
					
					if (width > 767) {
						var post_foot = $('.the-post-foot').outerHeight(true) + 50;
						$(this).css('height', $('.post-content').height() + (width > 1500 ? post_foot : 0) + 'px');
					}
					
					$(this).theiaStickySidebar({
						minWidth: 768, 
						updateSidebarHeight: false,
						defaultPosition: 'absolute',
						additionalMarginTop: add
					});
				});
			};

			$(window).on('resize', float_share);
			float_share();
			
			// Paralax for creative
			var creative = $('.single-creative .featured');
			if (creative.length) {

				var img = creative.find('.wp-post-image'),
				    src = img.prop('src');
				
				if (img.prop('currentSrc')) {
					src = img.prop('currentSrc');
				}
				
				if ($(window).width() < 940) {
					creative.removeClass('parallax');
					return;
				}
				
				creative.addClass('parallax');
				creative.find('.image-link').jarallax({	
					imgSrc: src,
					speed: 0.4,
					noIos: false
				});
			}

			$(window).on('resize', this.post_navigation);
			this.post_navigation();
			
		},
		
		/**
		 * Post Naviation
		 */
		post_navigation: function() 
		{
			var initialized = false,
			    post_nav = $('.post-nav');
			
			if (!post_nav.length || $(window).width() < 1300) {
				post_nav.removeClass('post-nav-float').addClass('post-nav-inline');
				return;
			}
			
			// Already setup or shouldn't be init?
			if (initialized) {
				return;
			}
			
			initialized = true;
			post_nav.addClass('post-nav-float');
			post_nav = post_nav.find('.post');
			
			// Show when post-content is in viewport and hide when footer 
			// becomes visible in view. 
			var ele = $('.the-post .post-content'), 
				scroll, offset, win_height, show_at, hide_at;
				
			var calc = function() {
			    offset     = ele.offset();
				win_height = $(window).height();

			    show_at = offset.top + (win_height / 2) + 56;
			    hide_at = $('.main-footer').offset().top + (win_height / 3);
			};

			calc();
			self._wait_load(calc, {'ready': true});

			// Lazyload fires this
			$(window).on('resize.TSS', calc);
			
			// Show at certain scroll
			$(window).on('scroll', function() {
				
				if ($(window).width() < 940) {
					return;
				}
				
				// Add viewport height to scrollTop
				scroll = $(window).scrollTop() + win_height;
				
				requestAnimationFrame(function() {
					if (scroll > show_at && scroll < hide_at) {
						
						if (!post_nav.hasClass('active')) {
							post_nav.addClass('active');
						}
					}
					else {
						post_nav.removeClass('active');
					}
				});
			});
		},
		
		/**
		 * Util to wait for until async CSS has been applied - waits for async font load
		 * too by default.
		 */
		_wait_load: function(cb, options) {

			options = $.extend({
				'fonts': true,
				'ready': false
			}, options);

			var sel = options.fonts ? '.wf-loading, .ld' : '.ld';

			if ($('html').is(sel) || (options.ready && document.readyState !== 'complete')) {
				setTimeout(self._wait_load.bind(null, cb, options), 30);
			}
			else {
				cb();
			}
		},
		
		/**
		 * Setup sliders and carousels
		 */
		sliders: function()
		{
			/**
			 * Parallax extend 
			 */
			if (window.jarallax) {
				var Jarallax = window.jarallax.constructor;
				var orig = Jarallax.prototype.onScroll;
				Jarallax.prototype.onScroll = function(force) {
					
					if (!force) {
						var ele = $(this.options.elementInViewport);
						if (ele && ele.data('active-only') && !ele.is('.slick-active, .active')) {
							return;
						}
					}
					
					orig.apply(this, arguments);
				};
			}
			
			// Enable parallax
			var add_parallax = function(slider, parallax_one) {
				
				var do_parallax = function() {
					
					if ($(window).width() < 940) {
						slider.removeClass('parallax');
						return;
					}
				
					slider.addClass('parallax');
					
					var slides = slider.find('.slick-slide');
	
					if (slider.parent().is('.grid-slider, .grid-b-slider')) {
						slides = slider.find('.item-large, .item-small').find('.image-link');
					}
					
					slides.each(function() {
						
						var img = $(this).find('img'),
						    src = img.prop('src');
						
						if (img.prop('currentSrc')) {
							src = img.prop('currentSrc');
						}
						
						if (parallax_one) {
							$(this).data('active-only', true);
						}
						
						$(this).jarallax({	
							imgSrc: src,
							speed: 0.4,
							elementInViewport: parallax_one ? $(this) : $(this).closest('.slick-slider'),
							noIos: false
						});
					});
				};
				
				$(window).on('resize', do_parallax);
				do_parallax();
			};
			
			/**
			 * Slider setup object
			 */
			var setup = {};

			/**
			 * Main featured post slider
			 */
			setup.main_slider = function(slider) {
				
				slider.slick({
					centerMode: true,
					variableWidth: true,
					slidesToShow: 1,
	            	slidesToScroll: 1,
					autoplay: slider.data('autoplay') ? true : false,
					autoplaySpeed: slider.data('speed'),
					arrows: true,
					prevArrow: '<a href="#" class="prev-arrow"><i class="fa fa-angle-left"></i></a>',
					nextArrow: '<a href="#" class="next-arrow"><i class="fa fa-angle-right"></i></a>',
					touchThreshold: 50,
					dots: false,
					infinite: true,
					responsive: [{
						breakpoint: 940,
						settings: {
							slidesToShow: 1,
							centerMode: false,
							variableWidth: false
						}
					}]
				});
				
				// Arrow positions
				slider.on('setPosition', function() {
					
					// not for responsive
					if ($(window).width() < 940) {
						return;
					}
					
					var center = $(this).find('.slick-active.slick-center'),
						pos   = center.offset(),
						right = pos.left + center.width();
					
					$(this).find('.prev-arrow').css('left', pos.left + 'px');
					$(this).find('.next-arrow').css('left', right + 'px');
				});
				
				slider.find('[data-slick-index=0]').addClass('active');
				
				// Force our active class by first removing it from clones
				slider.on('beforeChange', function(e, slick, prev, current) {
					
					$(this).find('.active').removeClass('active');
					var ele = $(this);
					
					requestAnimationFrame(function() {
						ele.find('[data-slick-index=' + current + ']').addClass('active');
					}, 1);
				});
				
			}; // main slider

			/**
			 * Beauty Slider
			 */
			setup.beauty_slider = function(slider, vars) {

				slider.slick($.extend(vars, {
					arrows: true,
					dots: true,
					infinite: true,
					cssEase: 'ease-in'
				}));
			};

			/**
			 * Fashion Slider
			 */
			setup.fashion_slider = function(slider, vars) {

				slider.on('init', function(e, slick) {
					self._wait_load(function() {
						$(slick.$slides[0]).addClass('active');
					});
				});

				slider.slick($.extend(vars, {
					arrows: true,
					infinite: true,
					cssEase: 'cubic-bezier(0.4, 0.03, 0, 0.83)',
					speed: 700
				}));

				slider.on('beforeChange', function(e, slick, prev, current) {
					var ele = $(this);

					requestAnimationFrame(function() {

						ele.find('.active').removeClass('active');
						ele.find('[data-slick-index=' + current + ']').addClass('active');
						
					});
					
				});
			};
			
			/**
			 * Trendy Slider
			 */
			setup.trendy_slider = function(slider, vars) {
				
				slider.slick($.extend(vars, {
					arrows: true,
					slidesToShow: 2,
					infinite: true,
					cssEase: 'ease',
					speed: 300,
					autoplay: slider.data('autoplay') ? true : false,
					autoplaySpeed: slider.data('speed'),
					responsive: [{
						breakpoint: 940,
						settings: {
							slidesToShow: 1
						}
					}]
				}));
			};
			
			/**
			 * Large Slider
			 */
			setup.large_slider = function(slider, vars) {
				slider.slick($.extend(vars, {
					arrows: true,
					infinite: true,
					cssEase: 'ease',
					speed: 350
				}));
			};
			
			/**
			 * Grid Slider
			 */
			setup.grid_slider = function(slider, vars) {
				slider.slick($.extend(vars, {
					arrows: true,
					infinite: true,
					cssEase: 'ease',
					speed: 300
				}));
			};
			
			/**
			 * Carousel Slider
			 */
			setup.carousel_slider = function(slider, vars) {
				
				slider.slick($.extend(vars, {
					arrows: true,
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					cssEase: 'ease-out',
					speed: 500,
					responsive: [
						{
							breakpoint: 940,
							settings: {slidesToShow: 2, slidesToScroll: 2}
						},
						{
							breakpoint: 600,
							settings: {slidesToShow: 1, slidesToScroll: 1}
						}
					]
				}));
			};
			
			// Bold slider
			setup.bold_slider = function(slider, vars) {
				
				slider.on('init', function(e, slick) {
					self._wait_load(function() {
						$(slick.$slides[0]).addClass('active');
					});
				});
				
				//var slick = instance.get(0).slick;
				slider.slick($.extend(vars, {
					arrows: true,
					infinite: true,
					cssEase: 'ease-in-out',
					speed: 500
				}));

				var nav = slider.parent().find('.post-thumb');
				
				slider.on('beforeChange', function(e, slick, prev, current) {
					
					// Current nav thumb to activate
					nav.eq(current).click();
					
					var ele = $(this);
					ele.find('.active').removeClass('active');
					
					requestAnimationFrame(function() {
						ele.find('[data-slick-index=' + current + ']').addClass('active');
					});
					
				});
				
				// Sync slider with navigation
				nav.first().addClass('active');
				nav.on('click', function() {
					var index = $(this).index();
					
					$(this)
						.addClass('active')
						.siblings().removeClass('active');
					
					slider.slick('slickGoTo', index);
					
					return false;
				});
			};
			
			
			/* Initialize home sliders */
			$('.common-slider .slides').each(function() {
			
				var slider = $(this).one('init', function() {
					$(this).addClass('loaded');
				});
				
				// Common setting
				var vars = {
					prevArrow: '<a href="#" class="prev-arrow"><i class="fa fa-angle-left"></i></a>',
					nextArrow: '<a href="#" class="next-arrow"><i class="fa fa-angle-right"></i></a>',
					autoplay: slider.data('autoplay') ? true : false,
					autoplaySpeed: slider.data('speed'),
					fade: slider.data('animation') == 'fade' ? true : false
				};
				
				var parallax = slider.data('parallax') || 0,
					parallax_one,
					slider_type = slider.data('slider');
				
				switch (slider_type) {
					case 'trendy':
						setup.trendy_slider(slider, vars);
						break;
					
					case 'beauty':
						setup.beauty_slider(slider, vars);
						break;
						
					case 'large':
						setup.large_slider(slider, vars);
						parallax_one = 1;
						break;
						
					case 'grid':
						setup.grid_slider(slider, vars);
						break;
						
					case 'carousel':
						setup.carousel_slider(slider, vars);
						break;
						
					case 'bold':
						setup.bold_slider(slider, vars);
						parallax_one = 1;
						break;
						
					default:

						var fn = setup[slider_type + '_slider'];
						if (typeof fn === 'function') {
							fn(slider, vars);
						}
						else {
							setup.main_slider(slider);
						}

						break;
				}
				
				// Has Parallax effect?
				if (parallax) {
					
					// One active slide only to parallax
					if (parallax_one) {
						slider.on('beforeChange', function(e, slick, prev, current) {
							$(this).find('.active').removeClass('active');
							var slide = $(this).find('[data-slick-index=' + current + ']');
							
							slide.addClass('active');
							slide.jarallax('onScroll');
						});
					}
					
					add_parallax(slider, parallax_one);
				}

			});

			this.post_gallery_slider();
			$(document).on('ajax-pagination', this.post_gallery_slider);

			/**
			 * Homepage carousel
			 */
			var carousel = $('.posts-carousel .posts, .posts-carousel-b .posts')
				.one('init', function() {
					$(this).addClass('loaded');
				});
			
			carousel.each(function() {
				
				$(this).slick({
					infinite: true,
					slidesToShow: $(this).data('slides') || 4,
					prevArrow: '<a class="prev-post"><i class="fa fa-angle-left"></i></a>',
					nextArrow: '<a class="next-post"><i class="fa fa-angle-right"></i></a>',
					appendArrows: $(this).parent().find('.navigate'),
					slidesToScroll: $(this).data('slides') || 4,
					
					responsive: [{
						breakpoint: 940,
						settings: {slidesToShow: 3, slidesToScroll: 3}
					},
					{
						breakpoint: 767,
						settings: {slidesToShow: 2, slidesToScroll: 2}
					},
					{
						breakpoint: 480,
						settings: {slidesToShow: 1, slidesToScroll: 1}
					}]
				});
			});
			
			// Carousel arrows
			$(window).on('load', function() {
				
				// Calculate arrow position based on image heights
				var carousel = $('.posts-carousel .posts'),
				    image = carousel.find('img').first();

				if (image && image.height() > 0) {
					carousel.parent().find('.slick-arrow').css('top', image.height()/2 + 'px');
				}
			});
			
			/**
			 * Widget: Posts slider
			 */
			$('.widget-slider .slides').each(function() {
				$(this).slick({
					prevArrow: '<a href="#" class="prev-arrow"><i class="fa fa-angle-left"></i></a>',
					nextArrow: '<a href="#" class="next-arrow"><i class="fa fa-angle-right"></i></a>',
					autoplay: $(this).data('autoplay') ? true : false,
					autoplaySpeed: 6000,
					infinite: true
				});
			});
			
			// Disable anchor jump on arrows
			$('.common-slider, .widget-slider').on('click', '.slick-arrow', function(e) {
				e.preventDefault();
			});
			

			// polyfill check for outdated browsers
			var fit_images = $('.large-slider img, .grid-slider img, .fashion-slider img, .widget-slider .wp-post-image, .bold-slider img');
			
			if (fit_images.length) {
				objectFitImages(fit_images);
			}
		},

		/**
		 * Posts featured gallery slider
		 */
		post_gallery_slider: function(e) {

			$('.gallery-slider:not(.slick-initialized)').each(function() {

				var slider = $(this);

				var init = function() {
					
					var vars = {
						infinite: true,
						slidesToShow: 1,
						prevArrow: '<a href="#" class="prev-arrow"><i class="fa fa-angle-left"></i></a>',
						nextArrow: '<a href="#" class="next-arrow"><i class="fa fa-angle-right"></i></a>',
						slidesToScroll: 1,
						adaptiveHeight: true
					};
					
					var parent = slider.closest('.single-creative .featured'),
						parallax;
					
					if (parent.length) {
						
						parent.addClass('has-gallery');
						slider.addClass('gallery-slider-lg');
						
						vars = $.extend(vars, {
							variableWidth: true,
							centerMode: true,
							adaptiveHeight: false,
							responsive: [{
								breakpoint: 940,
								settings: {centerMode: false, variableWidth: false}
							}]
						});
						
					}
					
					slider.slick(vars);
					!parallax || add_parallax(slider);
				};

				if (e) {
					slider.imagesLoaded(init);
				}
				else {
					init();
				}

			});
		},
		
		/**
		 * Setup Likes system
		 */
		likes: function()
		{
			if (typeof Sphere_Plugin == 'undefined') {
				return;
			}
			
			$('.likes-count').on('click', function() {
				
				var like = $(this);
				
				if (like.hasClass('voted')) {
					return false;
				}
				
				// Register the vote!
				$.post(Sphere_Plugin.ajaxurl, {action: 'sphere_likes', id: $(this).data('id')}, function(data) {
					
					if (data === Object(data)) {
						like.addClass('voted animate').find('.number').html(data.count);
					}
					
				}, 'json');
				
				return false;
				
			});
		},
		
		/**
		 * Setup Lightbox
		 */
		lightbox: function() 
		{
			// disabled on mobile screens
			if (!$.fn.magnificPopup || $(window).width() < 768) {
				return;
			}

			// filter to handle valid images only
			var filter_images = function() {
				
				if (!$(this).attr('href')) {
					return false;
				}
				
				return $(this).attr('href').match(/\.(jpe?g|png|bmp|gif)($|\?.+?)/); 
			};	
			
			var mfp_init = {
				type: 'image',
				tLoading: '',
				mainClass: 'mfp-fade mfp-img-mobile',
				removalDelay: 300,
				callbacks: {
					afterClose: function() {
						if (this._lastFocusedEl) {
							$(this._lastFocusedEl).addClass('blur');
						}
					}
				}
			};
			
			/**
			 * Handle Galleries in post
			 */
			
			var gal_selectors = '.gallery-slider, .post-content .gallery, .post-content .tiled-gallery';
			
			// filter to only tie valid images
			$(gal_selectors).find('a').has('img').filter(filter_images).addClass('lightbox-gallery-img');
			
			// Add WooCommerce support
			$('.woocommerce a[data-rel^="prettyPhoto"], a.zoom').addClass('lightbox-gallery-img');
			gal_selectors += ', .woocommerce .images';
			
			// attach the lightbox as gallery
			$(gal_selectors).magnificPopup($.extend({}, mfp_init, {
				delegate: '.lightbox-gallery-img',
				gallery: {enabled: true},
				image: {
					titleSrc: function(item) {
						var image = item.el.find('img'), 
						    caption = item.el.find('.caption').html();
						
						return (caption || image.attr('title') || ' ');
					}
				}
			}));
			
			// Non-gallery images in posts
			var selector = $('.post-content, .main .featured, .single-creative .featured')
				.find('a:not(.lightbox-gallery-img)').has('img');
			
			selector.add('.post-content, .main .featured, .lightbox-img')
				.filter(filter_images)
				.magnificPopup(mfp_init);
			
			
			// WooCommerce lightbox
			//$('a[data-rel^="prettyPhoto"], a.zoom').magnificPopup({hook: 'data-rel'});
		},
		
		/**
		 * Pinterest Pin It
		 */
		pin_it: function()
		{	
			var button = $('body .pinit-btn'),
			    the_button = button.prop('outerHTML'),
			    index = 1;
			
			// Only proceed if non-touch device and button exists
			if (has_touch || !the_button) {
				return;
			}
			
			var show_on = button.data('show-on').split(',');
			
			var get_image = function(ele) {
				if (!ele.is('img')) {
					ele = ele.find('img').first();
				}
				
				return ele;
			};
			
			var setup = function() {
				
				var selectors = [];
				if (show_on.indexOf('single') !== -1) {
					selectors.push('.post-content img, .single-cover .featured, .single:not(.layout-creative) .featured .image-link');
				}
				
				if (show_on.indexOf('listing') !== -1) {
					selectors.push('.posts-container .post-header .image-link, .posts-container .post-thumb .image-link');
				}
				
				selectors = selectors.join(', ');
				
				$(selectors)
					.on('mouseenter', function() {
						
						var img = get_image($(this)),
						    wrap = img.parent();
						
						if (img.hasClass('nopin') || img.width() < 200 || img.height < 200) {
							return;
						}
						
						var pos = img.position(),
						    media  = img.prop('src'),
						    url, button;
						
						// URL
						if ($('body').hasClass('single')) {
							url = window.location.href;
						}
						else {
							
							if (wrap.hasClass('image-link')) {
								url = wrap.prop('href');
							}
							else {
								url = img.closest('.post').find('.post-title-alt a, .post-title a').prop('href');
							}
						}
						
						if (!url) {
							return;
						}
						
						// Create if not already done
						if (!img.data('pinit-id')) {
							button = $(the_button).appendTo(wrap);
							var url_format = button.prop('href').replace('%media%', encodeURIComponent(media)).replace('%url%', encodeURIComponent(url))
							
							button.prop('href', url_format);
							
							button.on('click', function(e) {
								e.preventDefault();
								e.stopPropagation();
								
								window.open($(this).prop('href'), '_blank');
							});
							
							index++;
							img.attr('data-pinit-id', index);
							button.attr('data-pinit-id', index);
						}
						else {
							// Existing button
							button = wrap.find('a[data-pinit-id=' + img.data('pinit-id') +']');
						}
						
						button.addClass('show').css({
							top: pos.top + parseInt(img.css('marginTop')) + parseInt(img.css('paddingTop')),
							left: pos.left + parseInt(img.css('marginLeft')) + parseInt(img.css('paddingLeft'))
						});
				})	
				.on('mouseleave', function(e) {
						 
						var ele = get_image($(this)).parent();
						
						if ($(e.relatedTarget).hasClass('pinit-btn')) {
							return;
						}
						
						ele.find('.pinit-btn').removeClass('show');
				});
			};
			
			setup();
			$(document).on('ajax-pagination', setup);
			
		},
		
		lazy_load: function()
		{
			var type = $('body').prop('className').match(/lazy-([^\s]+)/);
			if (!type || !window.lazySizes) {
				return;
			}			
			type = type[1];
			
			// Debounced resize trigger
			var timer;
			var loaded = function() {
				clearTimeout(timer);
				timer = setTimeout(function() {
					$(window).trigger('resize.TSS');
				}, 50);
			};
			
			$(document).on('lazyloaded', '.main', function(e) {
				loaded();
			});
			
			// Only for "smart" type and large desktops
			if (type != 'smart' || $(window).width() < 1380) {
				return;
			}
			
			//window.lazySizesConfig.preloadAfterLoad = true;
			
			// Deferred preload
			var is_loaded = false;
			var defer_load = function() {

				if (is_loaded) {
					return;
				}

				$('img.lazyload').each(function() {
					lazySizes.loader.unveil($(this).get(0));
				});

				is_loaded = true;
			};
			
			// With delay or immediate on scroll (touch, mousemove other candidates)
			var events = 'scroll.ll';
			$(window).on(events, function() {
				defer_load();
				$(this).off(events);
			});

			self._wait_load(defer_load, {ready: true});
		},
		
		/**
		 * Setup masonry on archives
		 */
		masonry: function(reload, posts, grid) 
		{
			
			if ($.fn.masonry && $('.posts-dynamic').hasClass('masonry')) {
				var grid = grid || $('.posts-dynamic.masonry .posts-wrap'); 
				
				if (!grid.length) {
					return;
				}

				grid.on('layoutComplete', function() {
					requestAnimationFrame(function() {
						$(window).trigger('resize.TSS');
					});
				});
				
				// Reload masonry?
				if (reload && posts) {
		
					var posts = grid.find(posts).css({ opacity: 0 });
					
					grid.each(function() {

						$(this).imagesLoaded(function() {
							posts.css({ opacity: 1 });
							grid.masonry('appended', posts, true);
						});
					});
				}
				else {
					grid.each(function() {
						$(this).imagesLoaded(function() {
							grid.masonry();
						});
					});	
				}
			}
		}
		
	}; // end module
	
	// Utils
	function writeRaf(fn, options) {
		var running, 
		    args, 
		    that;

		var run = function() {
			running = false;
			fn.apply(that, args);
		};

		if (!options) {
			options = {};
		}

		return function() {
			args = arguments;
			that = options.that || this;

			if (!running) {
				running = true;
				requestAnimationFrame(run);
			}
		};
	}
	
	return self;
	
})(jQuery);

var Bunyad_Pagination = (function($) {
	
	// Blocks load more
	var processing = false,
	    cache = [];
	
	var self = {
			
		init: function() {
			// AJAX pagination handlers
			$('.main').on('click', '.main-pagination .load-button, .block .main-pagination.number a', this.ajax_pagination);
		},
		
		/**
		 * Initiate handling of AJAX pagination
		 */
		ajax_pagination: function(e) 
		{
			if (processing) {
				return false;
			}
			
			// Type of pagination
			var type = 'more';
			if ($(this).closest('.main-pagination').hasClass('number')) {
				type = 'number';
			}
			
			var ele = $(this),
		    	block = ele.closest('.block'),
		    	post_id = ele.closest('.page-content, .post-content').data('id'),
		    	page = ele.data('page') + 1,
		    	is_block = true;
		
			// Not a block, archives
			if (!block.length) {
				is_block = false;
				block = ele.closest('.main-content');
			}
			
			// AJAX params
			var params =  {
				'_bunyad_act': 'block',
				'page_id': post_id,
				'paged': page, 
				'block_id': block.data('id')
			};

			switch(type) {
			
				// Type: Load More
				case 'more':
					ele.addClass('loading').find('.fa').addClass('fa-spin');
					
					// Processing method for load more
					var process = self.process_load_more;
					
					break;
				
				// Type: Numbered
				case 'number':
					block.find('.block-content').addClass('loading');
					
					// Change page number
					var permalink = ele.attr('href').match(/\/page\/(\d+)\//);
					if (permalink !== null) {
						params.paged = permalink[1];
					}
					else {
						// Plain links
						var src = ele.attr('href').match(/(\?|&)paged?=(\d+)/);
						params.paged = src ? src[2] : 1;
					}
					
					// Set height
					block.css('height', block.height());
					
					var process = function(data) {
						cache[params.paged] = data;
						var content = $(data),
						    block_content = block.find('.block-content');
						
						block_content.removeClass('fade-in-down-lg')
							.html($(data).find('.block-content').html());
						
						block.css('height', 'auto');
						block_content.addClass('fade-in-down-lg').removeClass('loading');
						
						// position correctly
						$('html, body').animate({scrollTop: block.offset().top - 50}, 200);
						
						$(document).trigger('ajax-pagination');
					};
					
					// In cache?
					if (cache[params.paged]) {
						processing = false;
						process(cache[params.paged]);
						
						return false;
					}

					break;
			}

			// Process block
			if (is_block) {
				
				// Home blocks AJAX
				var ajax_url = Bunyad.custom_ajax_url;
				ajax_url += (ajax_url.indexOf('?') !== -1 ? '&' : '?');
				
				processing = $.get(ajax_url + $.param(params), function(data) {
						process(data, block, ele);
					})
					.always(function() {
						// All done
						processing = false;
					});	
			}
			else {
				
				// Archives AJAX
				var ajax_url = $(this).attr('href');
				processing = $.get(ajax_url, function(data) {
					data = $(data).find('.main-content').get(0);
					process(data, block, ele);
				})
				.always(function() {
					// All done
					processing = false;
				});
			}

			return false;
		},
		
		/**
		 * Load More Ajax callback method
		 */
		process_load_more: function(data, block, ele) 
		{
			var content = $(data),
				wrap = block.find('.posts-container'),
				posts;
			
			if (content.find('.posts-container').hasClass('mixed')) {
				posts = content.find('.posts-dynamic').children().addClass('fade-in-up-lg');
				wrap.append(posts);
			}
			else {
				// Directly below or in a .posts-wrap wrapper?
				var container = block.find('.posts-wrap').length ? '.posts-wrap' : '.posts-container';
				
		        posts = content.find(container).children().addClass('fade-in-up-lg');
		        block.find(container).append(posts);
			}
			
			// Masonry reload
			if (wrap.hasClass('masonry')) {
				//posts.removeClass('fade-in-up-lg');
				Bunyad_Theme.masonry(true, posts, wrap.find('.posts-wrap'));
			}
			
			$(document).trigger('ajax-pagination');

			block.find('.main-pagination')
				.replaceWith(content.find('.main-pagination'));
			
			ele.removeClass('loading')
				.find('.fa').removeClass('fa-spin');
		}
	};
	
	return self;
	
})(jQuery);

// load when ready
jQuery(function($) {
	
	// Init
	var init = function() {
		Bunyad_Theme.init();
		Bunyad_Pagination.init();
	};

	var rp_support = function() {
		try {
			return document.createElement("link").relList.supports("preload");
		} catch (e) {
			return false;
		}
	};
	
	if (!window.ld_skip && !rp_support() && window.loadCSS) {
		
		var link = $('link[as=style]');
		if (link.length) {
			link = link[0];
			
			var css_load = function(target) {
				if (target.prop('media') == 'all') {
					init();
					
					setTimeout(function() {
						$('html').removeClass('ld');
					}, 50);
					
					return;
				}

				setTimeout(css_load.bind(null, target), 20);
			};
			
			// find inserted - finds one
			var target = $('link[href="' + link.href + '"][as!=style]');
			if (target.length) {
				css_load(target);
			}
		}
	}
	else {
		init();
	}

});


/**
 * Required plugins and 3rd Party Libraries
 */

/**
 * Bootstrap: tooltip.js v3.2.0
 * http://getbootstrap.com/javascript/#tooltip
 * Licensed under MIT 
 */
+function(t){"use strict";function e(e){return this.each(function(){var o=t(this),n=o.data("bs.tooltip"),s="object"==typeof e&&e;(n||"destroy"!=e)&&(n||o.data("bs.tooltip",n=new i(this,s)),"string"==typeof e&&n[e]())})}var i=function(t,e){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",t,e)};i.VERSION="3.2.0",i.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},i.prototype.init=function(e,i,o){this.enabled=!0,this.type=e,this.$element=t(i),this.options=this.getOptions(o),this.$viewport=this.options.viewport&&t(this.options.viewport.selector||this.options.viewport);for(var n=this.options.trigger.split(" "),s=n.length;s--;){var r=n[s];if("click"==r)this.$element.on("click."+this.type,this.options.selector,t.proxy(this.toggle,this));else if("manual"!=r){var a="hover"==r?"mouseenter":"focusin",p="hover"==r?"mouseleave":"focusout";this.$element.on(a+"."+this.type,this.options.selector,t.proxy(this.enter,this)),this.$element.on(p+"."+this.type,this.options.selector,t.proxy(this.leave,this))}}this.options.selector?this._options=t.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},i.prototype.getDefaults=function(){return i.DEFAULTS},i.prototype.getOptions=function(e){return e=t.extend({},this.getDefaults(),this.$element.data(),e),e.delay&&"number"==typeof e.delay&&(e.delay={show:e.delay,hide:e.delay}),e},i.prototype.getDelegateOptions=function(){var e={},i=this.getDefaults();return this._options&&t.each(this._options,function(t,o){i[t]!=o&&(e[t]=o)}),e},i.prototype.enter=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),clearTimeout(i.timeout),i.hoverState="in",i.options.delay&&i.options.delay.show?void(i.timeout=setTimeout(function(){"in"==i.hoverState&&i.show()},i.options.delay.show)):i.show()},i.prototype.leave=function(e){var i=e instanceof this.constructor?e:t(e.currentTarget).data("bs."+this.type);return i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i)),clearTimeout(i.timeout),i.hoverState="out",i.options.delay&&i.options.delay.hide?void(i.timeout=setTimeout(function(){"out"==i.hoverState&&i.hide()},i.options.delay.hide)):i.hide()},i.prototype.show=function(){var e=t.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(e);var i=t.contains(document.documentElement,this.$element[0]);if(e.isDefaultPrevented()||!i)return;var o=this,n=this.tip(),s=this.getUID(this.type);this.setContent(),n.attr("id",s),this.$element.attr("aria-describedby",s),this.options.animation&&n.addClass("fade");var r="function"==typeof this.options.placement?this.options.placement.call(this,n[0],this.$element[0]):this.options.placement,a=/\s?auto?\s?/i,p=a.test(r);p&&(r=r.replace(a,"")||"top"),n.detach().css({top:0,left:0,display:"block"}).addClass(r).data("bs."+this.type,this),this.options.container?n.appendTo(this.options.container):n.insertAfter(this.$element);var l=this.getPosition(),h=n[0].offsetWidth,f=n[0].offsetHeight;if(p){var u=r,d=this.$element.parent(),c=this.getPosition(d);r="bottom"==r&&l.top+l.height+f-c.scroll>c.height?"top":"top"==r&&l.top-c.scroll-f<0?"bottom":"right"==r&&l.right+h>c.width?"left":"left"==r&&l.left-h<c.left?"right":r,n.removeClass(u).addClass(r)}var g=this.getCalculatedOffset(r,l,h,f);this.applyPlacement(g,r);var y=function(){o.$element.trigger("shown.bs."+o.type),o.hoverState=null};t.support.transition&&this.$tip.hasClass("fade")?n.one("bsTransitionEnd",y).emulateTransitionEnd(150):y()}},i.prototype.applyPlacement=function(e,i){var o=this.tip(),n=o[0].offsetWidth,s=o[0].offsetHeight,r=parseInt(o.css("margin-top"),10),a=parseInt(o.css("margin-left"),10);isNaN(r)&&(r=0),isNaN(a)&&(a=0),e.top=e.top+r,e.left=e.left+a,t.offset.setOffset(o[0],t.extend({using:function(t){o.css({top:Math.round(t.top),left:Math.round(t.left)})}},e),0),o.addClass("in");var p=o[0].offsetWidth,l=o[0].offsetHeight;"top"==i&&l!=s&&(e.top=e.top+s-l);var h=this.getViewportAdjustedDelta(i,e,p,l);h.left?e.left+=h.left:e.top+=h.top;var f=h.left?2*h.left-n+p:2*h.top-s+l,u=h.left?"left":"top",d=h.left?"offsetWidth":"offsetHeight";o.offset(e),this.replaceArrow(f,o[0][d],u)},i.prototype.replaceArrow=function(t,e,i){this.arrow().css(i,t?50*(1-t/e)+"%":"")},i.prototype.setContent=function(){var t=this.tip(),e=this.getTitle();t.find(".tooltip-inner")[this.options.html?"html":"text"](e),t.removeClass("fade in top bottom left right")},i.prototype.hide=function(){function e(){"in"!=i.hoverState&&o.detach(),i.$element.trigger("hidden.bs."+i.type)}var i=this,o=this.tip(),n=t.Event("hide.bs."+this.type);return this.$element.removeAttr("aria-describedby"),this.$element.trigger(n),n.isDefaultPrevented()?void 0:(o.removeClass("in"),t.support.transition&&this.$tip.hasClass("fade")?o.one("bsTransitionEnd",e).emulateTransitionEnd(150):e(),this.hoverState=null,this)},i.prototype.fixTitle=function(){var t=this.$element;(t.attr("title")||"string"!=typeof t.attr("data-original-title"))&&t.attr("data-original-title",t.attr("title")||"").attr("title","")},i.prototype.hasContent=function(){return this.getTitle()},i.prototype.getPosition=function(e){e=e||this.$element;var i=e[0],o="BODY"==i.tagName;return t.extend({},"function"==typeof i.getBoundingClientRect?i.getBoundingClientRect():null,{scroll:o?document.documentElement.scrollTop||document.body.scrollTop:e.scrollTop(),width:o?t(window).width():e.outerWidth(),height:o?t(window).height():e.outerHeight()},o?{top:0,left:0}:e.offset())},i.prototype.getCalculatedOffset=function(t,e,i,o){return"bottom"==t?{top:e.top+e.height,left:e.left+e.width/2-i/2}:"top"==t?{top:e.top-o,left:e.left+e.width/2-i/2}:"left"==t?{top:e.top+e.height/2-o/2,left:e.left-i}:{top:e.top+e.height/2-o/2,left:e.left+e.width}},i.prototype.getViewportAdjustedDelta=function(t,e,i,o){var n={top:0,left:0};if(!this.$viewport)return n;var s=this.options.viewport&&this.options.viewport.padding||0,r=this.getPosition(this.$viewport);if(/right|left/.test(t)){var a=e.top-s-r.scroll,p=e.top+s-r.scroll+o;a<r.top?n.top=r.top-a:p>r.top+r.height&&(n.top=r.top+r.height-p)}else{var l=e.left-s,h=e.left+s+i;l<r.left?n.left=r.left-l:h>r.width&&(n.left=r.left+r.width-h)}return n},i.prototype.getTitle=function(){var t,e=this.$element,i=this.options;return t=e.attr("data-original-title")||("function"==typeof i.title?i.title.call(e[0]):i.title)},i.prototype.getUID=function(t){do t+=~~(1e6*Math.random());while(document.getElementById(t));return t},i.prototype.tip=function(){return this.$tip=this.$tip||t(this.options.template)},i.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},i.prototype.validate=function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},i.prototype.enable=function(){this.enabled=!0},i.prototype.disable=function(){this.enabled=!1},i.prototype.toggleEnabled=function(){this.enabled=!this.enabled},i.prototype.toggle=function(e){var i=this;e&&(i=t(e.currentTarget).data("bs."+this.type),i||(i=new this.constructor(e.currentTarget,this.getDelegateOptions()),t(e.currentTarget).data("bs."+this.type,i))),i.tip().hasClass("in")?i.leave(i):i.enter(i)},i.prototype.destroy=function(){clearTimeout(this.timeout),this.hide().$element.off("."+this.type).removeData("bs."+this.type)};var o=t.fn.tooltip;t.fn.tooltip=e,t.fn.tooltip.Constructor=i,t.fn.tooltip.noConflict=function(){return t.fn.tooltip=o,this}}(jQuery),+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var i in e)if(void 0!==t.style[i])return{end:e[i]};return!1}t.fn.emulateTransitionEnd=function(e){var i=!1,o=this;t(this).one("bsTransitionEnd",function(){i=!0});var n=function(){i||t(o).trigger(t.support.transition.end)};return setTimeout(n,e),this},t(function(){t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);

/**
 *  FitVids 1.1 - https://github.com/davatron5000/FitVids.js
 */
(function($){$.fn.fitVids=function(options){var settings={customSelector:null,ignore:null};if(!document.getElementById("fit-vids-style")){var head=document.head||document.getElementsByTagName("head")[0];var css=".fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}";var div=document.createElement("div");div.innerHTML='<p>x</p><style id="fit-vids-style">'+css+"</style>";head.appendChild(div.childNodes[1])}if(options)$.extend(settings,options);return this.each(function(){var selectors=["iframe[src*='player.vimeo.com']","iframe[src*='youtube.com']","iframe[src*='youtube-nocookie.com']","iframe[src*='kickstarter.com'][src*='video.html']","object","embed"];if(settings.customSelector)selectors.push(settings.customSelector);var ignoreList=".fitvidsignore";if(settings.ignore)ignoreList=ignoreList+", "+settings.ignore;var $allVideos=$(this).find(selectors.join(","));$allVideos=$allVideos.not("object object");$allVideos=$allVideos.not(ignoreList);$allVideos.each(function(){var $this=$(this);if($this.parents(ignoreList).length>0)return;if(this.tagName.toLowerCase()==="embed"&&$this.parent("object").length||$this.parent(".fluid-width-video-wrapper").length)return;if(!$this.css("height")&&!$this.css("width")&&(isNaN($this.attr("height"))||isNaN($this.attr("width")))){$this.attr("height",9);$this.attr("width",16)}var height=this.tagName.toLowerCase()==="object"||$this.attr("height")&&!isNaN(parseInt($this.attr("height"),10))?parseInt($this.attr("height"),10):$this.height(),width=!isNaN(parseInt($this.attr("width"),10))?parseInt($this.attr("width"),10):$this.width(),aspectRatio=height/width;if(!$this.attr("id")){var videoID="fitvid"+Math.floor(Math.random()*999999);$this.attr("id",videoID)}$this.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",aspectRatio*100+"%");$this.removeAttr("height").removeAttr("width")})})}})(window.jQuery||window.Zepto);


/**
 * Plus/minus polyfill for numbers - used in WooCommerce
 * 
 * Author Bryce Adams
 */
jQuery( function( $ ) {

	// Quantity buttons
	$( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' )
		.addClass( 'buttons_added' )
		.append( '<div class="vertical-buttons"><input type="button" value="+" class="plus" /><input type="button" value="-" class="minus" /></div>' );

	$( document ).on( 'click', '.plus, .minus', function() {

		// Get values
		var $qty		= $( this ).closest( '.quantity' ).find( '.qty' ),
			currentVal	= parseFloat( $qty.val() ),
			max			= parseFloat( $qty.attr( 'max' ) ),
			min			= parseFloat( $qty.attr( 'min' ) ),
			step		= $qty.attr( 'step' );

		// Format values
		if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
		if ( max === '' || max === 'NaN' ) max = '';
		if ( min === '' || min === 'NaN' ) min = 0;
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

		// Change the value
		if ( $( this ).is( '.plus' ) ) {

			if ( max && ( max == currentVal || currentVal > max ) ) {
				$qty.val( max );
			} else {
				$qty.val( currentVal + parseFloat( step ) );
			}

		} else {

			if ( min && ( min == currentVal || currentVal < min ) ) {
				$qty.val( min );
			} else if ( currentVal > 0 ) {
				$qty.val( currentVal - parseFloat( step ) );
			}

		}

		// Trigger change event
		$qty.trigger( 'change' );

	});

});

/*! http://mths.be/placeholder v2.0.7 by @mathias */
(function(q,f,d){function r(b){var a={},c=/^jQuery\d+$/;d.each(b.attributes,function(b,d){d.specified&&!c.test(d.name)&&(a[d.name]=d.value)});return a}function g(b,a){var c=d(this);if(this.value==c.attr("placeholder")&&c.hasClass("placeholder"))if(c.data("placeholder-password")){c=c.hide().next().show().attr("id",c.removeAttr("id").data("placeholder-id"));if(!0===b)return c[0].value=a;c.focus()}else this.value="",c.removeClass("placeholder"),this==m()&&this.select()}function k(){var b,a=d(this),c=this.id;if(""==this.value){if("password"==this.type){if(!a.data("placeholder-textinput")){try{b=a.clone().attr({type:"text"})}catch(e){b=d("<input>").attr(d.extend(r(this),{type:"text"}))}b.removeAttr("name").data({"placeholder-password":a,"placeholder-id":c}).bind("focus.placeholder",g);a.data({"placeholder-textinput":b,"placeholder-id":c}).before(b)}a=a.removeAttr("id").hide().prev().attr("id",c).show()}a.addClass("placeholder");a[0].value=a.attr("placeholder")}else a.removeClass("placeholder")}function m(){try{return f.activeElement}catch(b){}}var h="placeholder"in f.createElement("input"),l="placeholder"in f.createElement("textarea"),e=d.fn,n=d.valHooks,p=d.propHooks;h&&l?(e=e.placeholder=function(){return this},e.input=e.textarea=!0):(e=e.placeholder=function(){this.filter((h?"textarea":":input")+"[placeholder]").not(".placeholder").bind({"focus.placeholder":g,"blur.placeholder":k}).data("placeholder-enabled",!0).trigger("blur.placeholder");return this},e.input=h,e.textarea=l,e={get:function(b){var a=d(b),c=a.data("placeholder-password");return c?c[0].value:a.data("placeholder-enabled")&&a.hasClass("placeholder")?"":b.value},set:function(b,a){var c=d(b),e=c.data("placeholder-password");if(e)return e[0].value=a;if(!c.data("placeholder-enabled"))return b.value=a;""==a?(b.value=a,b!=m()&&k.call(b)):c.hasClass("placeholder")?g.call(b,!0,a)||(b.value=a):b.value=a;return c}},h||(n.input=e,p.value=e),l||(n.textarea=e,p.value=e),d(function(){d(f).delegate("form","submit.placeholder",function(){var b=d(".placeholder",this).each(g);setTimeout(function(){b.each(k)},10)})}),d(q).bind("beforeunload.placeholder",function(){d(".placeholder").each(function(){this.value=""})}))})(this,document,jQuery);

/*! npm.im/object-fit-images */
var objectFitImages=function(){"use strict";function t(t){for(var e,r=getComputedStyle(t).fontFamily,i={};null!==(e=n.exec(r));)i[e[1]]=e[2];return i}function e(e,i){if(!e[c].parsingSrcset){var s=t(e);if(s["object-fit"]=s["object-fit"]||"fill",!e[c].s){if("fill"===s["object-fit"])return;if(!e[c].skipTest&&l&&!s["object-position"])return}var n=e[c].ios7src||e.currentSrc||e.src;if(i)n=i;else if(e.srcset&&!a&&window.picturefill){var o=window.picturefill._.ns;e[c].parsingSrcset=!0,e[o]&&e[o].evaled||window.picturefill._.fillImg(e,{reselect:!0}),e[o].curSrc||(e[o].supported=!1,window.picturefill._.fillImg(e,{reselect:!0})),delete e[c].parsingSrcset,n=e[o].curSrc||n}if(e[c].s)e[c].s=n,i&&(e[c].srcAttr=i);else{e[c]={s:n,srcAttr:i||f.call(e,"src"),srcsetAttr:e.srcset},e.src=c;try{e.srcset&&(e.srcset="",Object.defineProperty(e,"srcset",{value:e[c].srcsetAttr})),r(e)}catch(t){e[c].ios7src=n}}e.style.backgroundImage='url("'+n+'")',e.style.backgroundPosition=s["object-position"]||"center",e.style.backgroundRepeat="no-repeat",/scale-down/.test(s["object-fit"])?(e[c].i||(e[c].i=new Image,e[c].i.src=n),function t(){return e[c].i.naturalWidth?void(e[c].i.naturalWidth>e.width||e[c].i.naturalHeight>e.height?e.style.backgroundSize="contain":e.style.backgroundSize="auto"):void setTimeout(t,100)}()):e.style.backgroundSize=s["object-fit"].replace("none","auto").replace("fill","100% 100%")}}function r(t){var r={get:function(){return t[c].s},set:function(r){return delete t[c].i,e(t,r),r}};Object.defineProperty(t,"src",r),Object.defineProperty(t,"currentSrc",{get:r.get})}function i(){u||(HTMLImageElement.prototype.getAttribute=function(t){return!this[c]||"src"!==t&&"srcset"!==t?f.call(this,t):this[c][t+"Attr"]},HTMLImageElement.prototype.setAttribute=function(t,e){!this[c]||"src"!==t&&"srcset"!==t?g.call(this,t,e):this["src"===t?"src":t+"Attr"]=String(e)})}function s(t,r){var i=!A&&!t;if(r=r||{},t=t||"img",u&&!r.skipTest)return!1;"string"==typeof t?t=document.querySelectorAll("img"):t.length||(t=[t]);for(var n=0;n<t.length;n++)t[n][c]=t[n][c]||r,e(t[n]);i&&(document.body.addEventListener("load",function(t){"IMG"===t.target.tagName&&s(t.target,{skipTest:r.skipTest})},!0),A=!0,t="img"),r.watchMQ&&window.addEventListener("resize",s.bind(null,t,{skipTest:r.skipTest}))}var c="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",n=/(object-fit|object-position)\s*:\s*([-\w\s%]+)/g,o=new Image,l="object-fit"in o.style,u="object-position"in o.style,a="string"==typeof o.currentSrc,f=o.getAttribute,g=o.setAttribute,A=!1;return s.supportsObjectFit=l,s.supportsObjectPosition=u,i(),s}();

/*!
 * imagesLoaded PACKAGED v4.1.0
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */
!function(t,e){"function"==typeof define&&define.amd?define("ev-emitter/ev-emitter",e):"object"==typeof module&&module.exports?module.exports=e():t.EvEmitter=e()}(this,function(){function t(){}var e=t.prototype;return e.on=function(t,e){if(t&&e){var i=this._events=this._events||{},n=i[t]=i[t]||[];return-1==n.indexOf(e)&&n.push(e),this}},e.once=function(t,e){if(t&&e){this.on(t,e);var i=this._onceEvents=this._onceEvents||{},n=i[t]=i[t]||[];return n[e]=!0,this}},e.off=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=i.indexOf(e);return-1!=n&&i.splice(n,1),this}},e.emitEvent=function(t,e){var i=this._events&&this._events[t];if(i&&i.length){var n=0,o=i[n];e=e||[];for(var r=this._onceEvents&&this._onceEvents[t];o;){var s=r&&r[o];s&&(this.off(t,o),delete r[o]),o.apply(this,e),n+=s?0:1,o=i[n]}return this}},t}),function(t,e){"use strict";"function"==typeof define&&define.amd?define(["ev-emitter/ev-emitter"],function(i){return e(t,i)}):"object"==typeof module&&module.exports?module.exports=e(t,require("ev-emitter")):t.imagesLoaded=e(t,t.EvEmitter)}(window,function(t,e){function i(t,e){for(var i in e)t[i]=e[i];return t}function n(t){var e=[];if(Array.isArray(t))e=t;else if("number"==typeof t.length)for(var i=0;i<t.length;i++)e.push(t[i]);else e.push(t);return e}function o(t,e,r){return this instanceof o?("string"==typeof t&&(t=document.querySelectorAll(t)),this.elements=n(t),this.options=i({},this.options),"function"==typeof e?r=e:i(this.options,e),r&&this.on("always",r),this.getImages(),h&&(this.jqDeferred=new h.Deferred),void setTimeout(function(){this.check()}.bind(this))):new o(t,e,r)}function r(t){this.img=t}function s(t,e){this.url=t,this.element=e,this.img=new Image}var h=t.jQuery,a=t.console;o.prototype=Object.create(e.prototype),o.prototype.options={},o.prototype.getImages=function(){this.images=[],this.elements.forEach(this.addElementImages,this)},o.prototype.addElementImages=function(t){"IMG"==t.nodeName&&this.addImage(t),this.options.background===!0&&this.addElementBackgroundImages(t);var e=t.nodeType;if(e&&d[e]){for(var i=t.querySelectorAll("img"),n=0;n<i.length;n++){var o=i[n];this.addImage(o)}if("string"==typeof this.options.background){var r=t.querySelectorAll(this.options.background);for(n=0;n<r.length;n++){var s=r[n];this.addElementBackgroundImages(s)}}}};var d={1:!0,9:!0,11:!0};return o.prototype.addElementBackgroundImages=function(t){var e=getComputedStyle(t);if(e)for(var i=/url\((['"])?(.*?)\1\)/gi,n=i.exec(e.backgroundImage);null!==n;){var o=n&&n[2];o&&this.addBackground(o,t),n=i.exec(e.backgroundImage)}},o.prototype.addImage=function(t){var e=new r(t);this.images.push(e)},o.prototype.addBackground=function(t,e){var i=new s(t,e);this.images.push(i)},o.prototype.check=function(){function t(t,i,n){setTimeout(function(){e.progress(t,i,n)})}var e=this;return this.progressedCount=0,this.hasAnyBroken=!1,this.images.length?void this.images.forEach(function(e){e.once("progress",t),e.check()}):void this.complete()},o.prototype.progress=function(t,e,i){this.progressedCount++,this.hasAnyBroken=this.hasAnyBroken||!t.isLoaded,this.emitEvent("progress",[this,t,e]),this.jqDeferred&&this.jqDeferred.notify&&this.jqDeferred.notify(this,t),this.progressedCount==this.images.length&&this.complete(),this.options.debug&&a&&a.log("progress: "+i,t,e)},o.prototype.complete=function(){var t=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emitEvent(t,[this]),this.emitEvent("always",[this]),this.jqDeferred){var e=this.hasAnyBroken?"reject":"resolve";this.jqDeferred[e](this)}},r.prototype=Object.create(e.prototype),r.prototype.check=function(){var t=this.getIsImageComplete();return t?void this.confirm(0!==this.img.naturalWidth,"naturalWidth"):(this.proxyImage=new Image,this.proxyImage.addEventListener("load",this),this.proxyImage.addEventListener("error",this),this.img.addEventListener("load",this),this.img.addEventListener("error",this),void(this.proxyImage.src=this.img.src))},r.prototype.getIsImageComplete=function(){return this.img.complete&&void 0!==this.img.naturalWidth},r.prototype.confirm=function(t,e){this.isLoaded=t,this.emitEvent("progress",[this,this.img,e])},r.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},r.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindEvents()},r.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindEvents()},r.prototype.unbindEvents=function(){this.proxyImage.removeEventListener("load",this),this.proxyImage.removeEventListener("error",this),this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype=Object.create(r.prototype),s.prototype.check=function(){this.img.addEventListener("load",this),this.img.addEventListener("error",this),this.img.src=this.url;var t=this.getIsImageComplete();t&&(this.confirm(0!==this.img.naturalWidth,"naturalWidth"),this.unbindEvents())},s.prototype.unbindEvents=function(){this.img.removeEventListener("load",this),this.img.removeEventListener("error",this)},s.prototype.confirm=function(t,e){this.isLoaded=t,this.emitEvent("progress",[this,this.element,e])},o.makeJQueryPlugin=function(e){e=e||t.jQuery,e&&(h=e,h.fn.imagesLoaded=function(t,e){var i=new o(this,t,e);return i.jqDeferred.promise(h(this))})},o.makeJQueryPlugin(),o});