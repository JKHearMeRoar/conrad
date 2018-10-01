<?php

/**
 * CheerUp Theme!
 * 
 * This is the typical theme initialization file. Sets up the Bunyad Framework
 * and the theme functionality.
 * 
 * ----
 * 
 * Code Locations:
 * 
 *  /          -  WordPress default template files.
 *  lib/       -  Contains the Bunyad Framework files.
 *  inc/       -  Theme related functionality and some HTML helpers.
 *  admin/     -  Admin-only content.
 *  partials/  -  Template parts (partials) called via get_template_part().
 *  
 * Note: If you're looking to edit HTML, look for default WordPress templates in
 * top-level / and in partials/ folder.
 * 
 */

// Already initialized?
if (class_exists('Bunyad_Core')) {
	return;
}

// Initialize Framework
require_once get_template_directory() . '/lib/bunyad.php';
require_once get_template_directory() . '/inc/bunyad.php';

// Fire up the theme - make available in Bunyad::get('cheerup')
Bunyad::register('cheerup', array(
	'class' => 'Bunyad_Theme_Cheerup',
	'init' => true
));

/**
 * Main Framework Configuration
 */

$bunyad_core = Bunyad::core()->init(apply_filters('bunyad_init_config', array(

	'theme_name'    => 'cheerup',
	'meta_prefix'   => '_bunyad',    // Keep meta framework prefix for data interoperability 
	'theme_version' => '5.0.0',

	// widgets enabled
	'widgets'      => array('about', 'posts', 'cta', 'ads', 'social', 'subscribe', 'social-follow', 'twitter', 'slider'),
	'widgets_type' => 'embed',
	'post_formats' => array('gallery', 'image', 'video', 'audio'),
	'customizer'   => true,
	
	// Enabled metaboxes and prefs - id is prefixed with _bunyad_ in init() method of lib/admin/meta-boxes.php
	'meta_boxes' => array(
		array('id' => 'post-options', 'title' => esc_html_x('Post Options', 'Admin: Meta', 'cheerup'), 'priority' => 'high', 'page' => array('post')),
		array('id' => 'page-options', 'title' => esc_html_x('Page Options', 'Admin: Meta', 'cheerup'), 'priority' => 'high', 'page' => array('page')),
	)
)));


/**
 * CheerUp Theme!
 * 
 * Anything theme-specific that won't go into the core framework goes here.
 */
class Bunyad_Theme_Cheerup
{

	public function __construct() 
	{
		// Setup plugins before init
		$this->setup_plugins();
		
		// Perform the after_setup_theme 
		add_action('after_setup_theme', array($this, 'theme_init'), 12);
		
		// Init skins
		add_action('bunyad_core_post_init', array($this, 'init_skins'));
		
		/**
		 * Load theme functions and helpers.
		 * 
		 * Note: Bunyad::options() isn't ready yet. Bunyad_Core::init() enables it later.
		 * Use filters:
		 *   'bunyad_core_post_init' OR 'after_setup_theme'
		 */
		
		// Ready up the custom css handlers
		include get_template_directory() . '/inc/custom-css.php';
		
		// Customizer features
		include get_template_directory() . '/inc/customizer.php';
		
		// Likes / heart functionality
		include get_template_directory() . '/inc/likes.php';
		
		// Social sharing buttons
		include get_template_directory() . '/inc/social.php';
		
		// Template tags related to general layout
		include get_template_directory() . '/inc/helpers.php';
		include get_template_directory() . '/inc/media.php';
		include get_template_directory() . '/inc/lazyload.php';
		
		// Special galleries
		include get_template_directory() . '/inc/galleries.php';
		
		// Blocks and shortcodes for VC
		include get_template_directory() . '/inc/shortcodes.php';
		include get_template_directory() . '/inc/block.php';
		include get_template_directory() . '/inc/blocks-ajax.php';
		
		// Optimizations and plugins compat
		include get_template_directory() . '/inc/optimize.php';
		
		if (class_exists('Vc_Manager')) {
			include get_template_directory() . '/inc/visual-composer.php';
		}
		
		// Have WooCommerce?
		if (function_exists('is_woocommerce')) {
			include get_template_directory() . '/inc/woocommerce.php';
		}
		
		include get_template_directory() . '/inc/admin/theme-updates.php';
		
		// Admin only
		if (is_admin()) {
		
			// Admin (backend) functionality 
			include get_template_directory() . '/inc/admin.php';
		}
		
	}
	
	/**
	 * Setup enque data and actions
	 */
	public function theme_init()
	{
		
		/**
		 * Enqueue assets (css, js)
		 * 
		 * Register Custom CSS at a lower priority for CSS specificity
		 */
		add_action('wp_enqueue_scripts', array($this, 'register_assets'));
		
		/**
		 * Set theme image sizes used in different areas, blocks and posts
		 * 
		 * cheerup-main        -  Used for main featured images
		 * cheerup-main-full   -  Featured image for the full width posts
		 * cheerup-grid        -  Used on the grid posts layout
		 * cheerup-list        -  Used on list posts layout
		 * cheerup-list-b      -  For list layout in alt style
		 * cheerup-thumb       -  Smaller thumbnail for widgets
		 * 
		 * NOTE: 
		 * 	 - All these images are NOT ALWAYS generated - some are simply Aliases.
		 */
		
		$image_sizes = apply_filters('bunyad_image_sizes', array(
				
			'post-thumbnail' => array('width'=> 270, 'height' => 180),
			
			// Single, large, and overlay posts
			'cheerup-main'   => array('width'=> 770, 'height' => 515),
			'cheerup-main-full'=>  array('width' => 1170, 'height' => 508),
			
			// Slider images
			'cheerup-slider-alt'      => array('width' => 1170, 'height' => 508), // Alias for cheerup-main-full
			'cheerup-slider-trendy'   => array('width' => 960, 'height' => 508),
			'cheerup-slider-stylish'  => array('width' => 900, 'height' => 515),
			'cheerup-slider-grid'     => array('width' => 870, 'height' => 600),
			'cheerup-slider-grid-sm'  => array('width' => 300, 'height' => 300),  // Alias for medium
			'cheerup-slider-carousel'  => array('width' => 370, 'height' => 370),
			'cheerup-slider-grid-b'    => array('width' => 554, 'height' => 466),
			'cheerup-slider-grid-b-sm' => array('width' => 306, 'height' => 466),
			'cheerup-slider-bold-sm'   => array('width' => 150, 'height' => 150), // Alias for thumbnail
			
			// Grid Posts
			'cheerup-grid'    => array('width' => 370, 'height' => 285),

			// Carousel - Aliases
			'cheerup-carousel'     => array('width' => 370, 'height' => 305),  // Alias for cheerup-list-b
			'cheerup-carousel-b'   => array('width' => 370, 'height' => 285),  // Alias for cheerup-grid

			// List Posts
			'cheerup-list'   => array('width' => 260, 'height' => 200),
			'cheerup-list-b' => array('width' => 370, 'height' => 305),

			// Thumbs for sidebar
			'cheerup-thumb'  => array('width' => 87, 'height' => 67),
			'cheerup-thumb-alt' => array('width' => 150, 'height' => 150), // Alias for thumbnail
			
		));
		
		foreach ($image_sizes as $key => $size) {
			
			// Set default crop to true
			$size['crop'] = (!isset($size['crop']) ? true : $size['crop']);
			
			add_image_size($key, $size['width'], $size['height'], $size['crop']);
			
		}

		// i18n
		load_theme_textdomain('cheerup', get_template_directory() . '/languages');
		
		// Setup navigation menu
		register_nav_menu('cheerup-main', esc_html_x('Main Navigation', 'Admin', 'cheerup'));
		register_nav_menu('cheerup-mobile', esc_html_x('Mobile Menu (Optional)', 'Admin', 'cheerup'));
		
		// Optional topbar menu if enabled
		if (Bunyad::options()->topbar_top_menu) {
			register_nav_menu('cheerup-top-menu', esc_html_x('Topbar Menu (Optional)', 'Admin', 'cheerup'));
		}
		
		// Optional footer menu
		if (Bunyad::options()->footer_links) {
			register_nav_menu('cheerup-footer-links', esc_html_x('Footer Links (Bold Footer Only)', 'Admin', 'cheerup'));
		}
		
		// Additional HTML5 support not previously activated by Bunyad core
		add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
		add_theme_support('title-tag');
		add_theme_support('custom-background');
			
		// Add content width for oEmbed and similar
		global $content_width;
		
		if (!isset($content_width)) {
			$content_width = 770;
		}
		
		/**
		 * Register Sidebars and relevant filters
		 */
		add_action('widgets_init', array($this, 'register_sidebars'));
		
		// Category widget settings
		add_filter('widget_categories_args', array($this, 'category_widget_query'));
		
		/**
		 * Posts related filter
		 */
		
		// Add the orig_offset for offset support in blocks
		add_filter('bunyad_block_query_args', array(Bunyad::posts(), 'add_query_offset'), 10, 1);
		
		// Video format auto-embed
		add_filter('bunyad_featured_video', array($this, 'video_auto_embed'));
		add_filter('embed_defaults', array($this, 'soundcloud_embed'), 10, 2);
		
		// Remove hentry microformat, we use schema.org/Article
		add_action('post_class', array($this, 'fix_post_class'));
		
		// Fix content_width for full-width posts
		add_filter('wp_head', array($this, 'content_width_fix'));
		
		// Limit search to posts?
		if (Bunyad::options()->search_posts_only) {
			add_filter('pre_get_posts', array($this, 'limit_search'));
		}
		
		// Limit number of posts on homepage via a separate setting 
		// Additionally, fix hanging posts for assorted layout
		add_filter('pre_get_posts', array($this, 'home_posts_limit'));
		
		// Read more common html
		Bunyad::posts()->more_text = esc_html__('Keep Reading', 'cheerup');
		Bunyad::posts()->more_html = ' ';
		
		if (in_array(Bunyad::options()->predefined_style, array('miranda', 'travel'))) {
			Bunyad::posts()->more_text = esc_html__('Continue Reading', 'cheerup');
		}

		if (in_array(Bunyad::options()->predefined_style, array('fashion', 'fitness'))) {
			Bunyad::posts()->more_text = esc_html__('Read More', 'cheerup');
		}

		// Default comment fields re-order
		add_filter('comment_form_fields', array($this, 'comment_form_order'), 20);
		
		/**
		 * Admin And editor styling
		 */
		if (is_admin()) {
			
			// Add editor styles
			$styles = array(get_stylesheet_uri());
			$skin   = $this->get_style();
			
			// Add skin css second
			if (isset($skin['css'])) {
				array_push($styles, get_template_directory_uri() . '/css/' . $skin['css'] . '.css');
			}
			
			$styles = array_merge($styles, array(
				get_template_directory_uri() . '/css/admin/editor-style.css',
				$this->get_fonts_enqueue()
			));
						
			add_editor_style($styles);
		}
		

		/**
		 * Mega menu and navigation
		 */
		add_filter('bunyad_custom_menu_fields', array($this, 'custom_menu_fields'));
		add_filter('bunyad_mega_menu_end_lvl', array($this, 'attach_mega_menu'));
		
		add_filter('wp_nav_menu_items', array($this, 'add_navigation_icons'), 10, 2);
		//add_filter('wp_nav_menu_items', array($this, 'add_navigation_logo'), 10, 2);
		
		add_action('wp_footer', array($this, 'add_pinterest'), 2);
		
		
		/**
		 * Misc
		 */
		add_filter('body_class', array($this, 'the_body_class'));
		
		/**
		 * Setup multi-weight post titles
		 */
		if (!is_admin()) {
			
			add_filter('the_title', array($this, 'title_styling'));
						
			// Apply at priority 8 so wp_kses() filter strips the tags
			add_filter('single_post_title', array($this, 'title_styling'), 8);
		}
		
		// Setup the home blocks
		$this->register_blocks();
		
			
		/**
		 * Sphere Core aliases
		 */
		if (class_exists('Sphere_Plugin_Core')) {
			Bunyad::register('social-follow', array('object' => Sphere_Plugin_Core::get('social-follow')));
		}
		
		
		/**
		 * 3rd Party plugins fixes
		 */
		add_action('init', array($this, 'jetpack_fix'));
		add_filter('jp_carousel_force_enable', '__return_true');
		
		// Activate Jetpack module if missing
		add_action('admin_init', array($this, 'jetpack_modules_fix'));
		
	}
	

	/**
	 * Setup any skin data and configs
	 */
	public function init_skins()
	{
		// Include our skins constructs
		if (Bunyad::options()->predefined_style) {
			
			$style = $this->get_style();
			
			if (!empty($style['bootstrap'])) {
				locate_template($style['bootstrap'], true);
			}
		}
	}

	/**
	 * Register and enqueue theme CSS and JS files
	 */
	public function register_assets()
	{
		// Theme version
		$version = Bunyad::options()->get_config('theme_version');
		
		// Only add to front-end
		if (!is_admin()) {
			
			/**
			 * Add CSS styles
			 */
			
			// Get style configs for current style
			$style = $this->get_style(Bunyad::options()->predefined_style);
			
			// Add Typekit Kit - ignore our default kit
			if (Bunyad::options()->typekit_id) {
				
				//wp_enqueue_script('cheerup-typekit', esc_url( (is_ssl() ? 'https' : 'http') . '://use.typekit.net/' . Bunyad::options()->typekit_id . '.js' ));
				
				// add filter for typekit kit initialization
				add_filter('wp_head', array($this, 'add_typekit_code'));
			}
	
			// Add Google fonts
			if (!empty($style['font_args'])) {
				wp_enqueue_style('cheerup-fonts', $this->get_fonts_enqueue(), array(), null);
			}
			
			// Add extra CSS if any
			if (!empty($style['extra_css'])) {
				foreach ($style['extra_css'] as $id => $file) {
					wp_enqueue_style($id, get_template_directory_uri() . $file);
				}
			}
				
			// Add core css
			if (apply_filters('bunyad_enqueue_core_css', true)) {
				wp_enqueue_style('cheerup-core', get_stylesheet_uri(), array(), $version);
			}

			// Add lightbox to pages and single posts
			if (Bunyad::options()->enable_lightbox) {
				wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/js/jquery.mfp-lightbox.js', array(), false, true);
				wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/css/lightbox.css', array(), $version);
			}
			
			// Add FontAwesome - added prefix to handle conflict with plugins adding outdated versions
			wp_enqueue_style('cheerup-font-awesome', get_template_directory_uri() . '/css/fontawesome/css/font-awesome.min.css', array(), $version);
			
			// Load the theme scripts to footer, except for jquery
			wp_enqueue_script('cheerup-theme', get_template_directory_uri() . '/js/bunyad-theme.js', array('jquery'), $version, true);
			wp_enqueue_script('slick-slider', get_template_directory_uri() . '/js/jquery.slick.js', array('jquery'), $version, true);
			wp_enqueue_script('jarallax', get_template_directory_uri() . '/js/jarallax.js', array('jquery'), $version, true);
			
			// Sticky sidebar script
			wp_enqueue_script('cheerup-sticky-sidebar', get_template_directory_uri() . '/js/jquery.sticky-sidebar.js', array('jquery'), $version, true);
			
			// Masonry if needed - loading custom one due to outdated masonry in core
			if (Bunyad::options()->post_grid_masonry) {
				wp_enqueue_script('cheerup-masonry', get_template_directory_uri() . '/js/jquery.masonry.js', array('jquery'), $version, true);
			}
			
		
			/**
			 * Enqueue pre-defined skin and 
			 */
		
			// Pre-defined scheme / skin CSS - add it below others
			if (!empty($style['css'])) {
				
				// Enqueue with WooCommerce dependency if it exists
				wp_enqueue_style(
					'cheerup-skin', 
					get_template_directory_uri() . '/css/' . $style['css'] . '.css', 
					array((function_exists('is_woocommerce') ? 'cheerup-woocommerce' : 'cheerup-core')),
					$version
				);
			}
		}
	}
	
	/**
	 * Setup the sidebars
	 */
	public function register_sidebars()
	{
	
		// register dynamic sidebar
		register_sidebar(array(
			'name' => esc_html_x('Main Sidebar', 'Admin', 'cheerup'),
			'id'   => 'cheerup-primary',
			'description' => esc_html_x('Widgets in this area will be shown in the default sidebar.', 'Admin', 'cheerup'),
			'before_title' => '<h5 class="widget-title"><span>',
			'after_title'  => '</span></h5>',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => "</li>\n"
		));

		// register dynamic sidebar
		register_sidebar(array(
			'name' => esc_html_x('Split Sidebar - Top', 'Admin', 'cheerup'),
			'id'   => 'cheerup-split-top',
			'description' => esc_html_x('For when using Assorted home-page only - top part of the split.', 'Admin', 'cheerup'),
			'before_title' => '<h5 class="widget-title"><span>',
			'after_title'  => '</span></h5>',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => "</li>\n"
		));
		
		// register dynamic sidebar
		register_sidebar(array(
			'name' => esc_html_x('Home Call To Action Boxes', 'Admin', 'cheerup'),
			'id'   => 'cheerup-home-cta',
			'description' => esc_html_x('Use the "CheerUp - Call To Action" in this area to show CTAs below slider.', 'Admin', 'cheerup'),
			'before_title' => '<h5 class="widget-title">',
			'after_title'  => '</h5>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => "</div>\n"
		));

		// register dynamic sidebar
		register_sidebar(array(
			'name' => esc_html_x('Footer Widgets', 'Admin', 'cheerup'),
			'id'   => 'cheerup-footer',
			'description' => esc_html_x('Add three widgets for the footer area. (Optional)', 'Admin', 'cheerup'),
			'before_title' => '<h5 class="widget-title">',
			'after_title'  => '</h5>',
			'before_widget' => '<li id="%1$s" class="widget column col-4 %2$s">',
			'after_widget' => '</li>'
		));
		
		// register dynamic sidebar
		register_sidebar(array(
			'name' => esc_html_x('Footer Instagram', 'Admin', 'cheerup'),
			'id'   => 'cheerup-instagram',
			'description' => esc_html_x('Simply add a single widget using "WP Instagram Widget" plugin. (Optional)', 'Admin', 'cheerup'),
			'before_title' => '',
			'after_title'  => '',
			'before_widget' => '',
			'after_widget' => ''
		));
	}
	
	/**
	 * Register page builder blocks and shortcodes
	 */
	public function register_blocks()
	{
		
		// Default attributes shared amongst blocks
		$attribs = apply_filters('bunyad_default_block_attribs', array(
			'posts'   => 4,
			'offset'  => '',
			'heading' => '',
			'heading_type' => '',
			'link'    => '',
			'cat'     => '',
			'cats'    => '', 
			'tags'    => '',
			'terms'   => '',
			'pagination' => '',
			'pagination_type' => '',
			'view_all'   => '',
			'taxonomy'   => '',
			'sort_order' => '',
			'sort_by'    => '',
			'post_format' => '',
			'post_type'   => '',
			'filters' => false
		));
		
		$attribs_blog = array_merge(
			$attribs,
			array(
				'type' => '', 
				'show_excerpt' => 1,
				'show_footer'  => ''
			)
		);
		
		
		/**
		 * Setup loop blocks - aliases for blog shortcode
		 */
		$listings = array(
			'loop-default',
			'loop-1st-large',
			'loop-1st-large-list',
			'loop-1st-overlay',
			'loop-1st-overlay-list',
			'loop-1-2',
			'loop-1-2-list',
			'loop-1-2-overlay',
			'loop-1-2-overlay-list',
			'loop-list',
			'loop-grid',
			'loop-grid-3'
		);
		
		$loop_blocks = array();
		$loop_params = array(
			'render'  => locate_template('partials/blocks/blog.php'), 
			'attribs' => $attribs_blog,
		);
		
		foreach ($listings as $block) {
			$loop_blocks[$block] = $loop_params;
		}
		
		
		/**
		 * Register all the blocks
		 */
		Bunyad::get('shortcodes')->add(array_merge($loop_blocks, array(
			'blog' => array(
				'render'  => locate_template('partials/blocks/blog.php'), 
				'attribs' => $attribs_blog,
			),
				
			'highlights' => array(
				'render'  => locate_template('partials/blocks/highlights.php'), 
				'attribs' => $attribs
			),
			
			'news_grid' => array(
				'render'  => locate_template('partials/blocks/news-grid.php'), 
				'attribs' => $attribs
			),
				
			'ts_ads' => array(
				'render'  => locate_template('partials/blocks/ts-ads.php'),
				'attribs' => array(
					'code'  => '', 
					'title' => ''		
				)
			)
		)));
	}
	
	/**
	 * Setup and recommend plugins
	 */
	public function setup_plugins()
	{
		if (!is_admin()) {
			return;
		}
		
		// Load the plugin activation class and plugin updater
		require_once get_template_directory() . '/lib/vendor/tgm-activation.php';
		
		// Recommended and required plugins
		$plugins = array(
			array(
				'name'     => esc_html_x('Sphere Core', 'Admin', 'cheerup'),
				'slug'     => 'sphere-core',
				'required' => true,
				'source'   => get_template_directory() . '/lib/vendor/plugins/sphere-core.zip', // The plugin source
				'version'  => '1.0.4'
			),
		
			array(
				'name'     => esc_html_x('WP Retina 2x', 'Admin', 'cheerup'),
				'slug'     => 'wp-retina-2x',
				'required' => false,
			),
			
			array(
				'name'     => esc_html_x('Contact Form 7', 'Admin', 'cheerup'),
				'slug'     => 'contact-form-7',
				'required' => false,
			),

			array(
				'name'     => esc_html_x('WP Instagram Widget', 'Admin', 'cheerup'),
				'slug'     => 'wp-instagram-widget',
				'required' => false,
			),
				
			array(
				'name'     => esc_html_x('WPBakery Page Builder (Magazine Skin Only)', 'Admin', 'cheerup'),
				'slug'     => 'js_composer',
				'required' => false,
				'source'   => get_template_directory() . '/lib/vendor/plugins/js_composer.zip', // The plugin source
				'version'  => '5.4.5'
			),
		);
		
		// Set for update checking
		Bunyad::registry()->set('packaged_plugins', $plugins);

		tgmpa($plugins, array(
			'parent_slug' => 'sphere-dash'
		));
		
	}
	
	/**
	 * Styles and skins
	 */
	public function get_style($style = '')
	{
		// Get from settings
		if (empty($style)) {
			$style = Bunyad::options()->predefined_style;
		}
		
		if (empty($style)) {
			$style = 'default';
		}
		
		$styles = array(
						
			'default' => array(
				'font_args' => array('family' => 'Poppins:400,500,600,700|Merriweather:300italic,400,400italic,700'),
				'css' => 'skin-general'
			),

			'beauty' => array(
				'font_args' => array('family' => 'Lato:400,500,700,900|Merriweather:300italic'),
				'css' => 'skin-beauty',
			),
			 
			'trendy' => array(
				'font_args' => array('family' => 'Lato:400,500,700,900|Lora:400,400italic,700,700italic'),
				'css' => 'skin-trendy',
			),
				
			'miranda' => array(
				'font_args' => array('family' => 'Playfair Display:400,400i,700i|Source Sans Pro:400,400i,600,700|Noto Sans:400,700|Lora:400i'),
				'css' => 'skin-miranda',
			),
				
			'rovella' => array(
				'font_args' => array('family' => 'Lato:400,700,900|Noto Sans:400,400i,700|Lora:400i'),
				'css' => 'skin-rovella',
				'bootstrap' => 'inc/skins/rovella.php',
			),
				
			'travel' => array(
				'font_args' => array('family' => 'Lato:400,700,900|Roboto:400,400i,500,700|Lora:400i|Rancho:400'),
				'css' => 'skin-travel',
				'bootstrap' => 'inc/skins/travel.php',
			),
			
			'magazine' => array(
				'font_args' => array('family' => 'Lato:400,400i,700,900|Open Sans:400,600,700,800'),
				'css' => 'skin-magazine',
				'bootstrap' => 'inc/skins/magazine.php',
			),
			
			'bold' => array(
				'font_args' => array('family' => 'Open Sans:400,400i,600,700|Lora:400i'),
				'css' => 'skin-bold',
				'bootstrap' => 'inc/skins/bold.php',
			),

			'fashion' => array(
				'font_args' => array('family' => 'Cormorant:600,700,700i'),
				'css' => 'skin-fashion',
				'bootstrap' => 'inc/skins/fashion.php',
			),

			'mom' => array(
				'font_args' => array('family' => 'Arima Madurai:500,700|Lato:400,400i,700,900|Montserrat:500,600'),
				'css' => 'skin-mom',
				'bootstrap' => 'inc/skins/mom.php',
			),

			'fitness' => array(
				'font_args' => array('family' => 'Karla:400,400i,600|Lora:400i'),
				'css' => 'skin-fitness',
				'bootstrap' => 'inc/skins/fitness.php',
			),
		);
		
		//Bunyad::options()->typekit_id = '';
		
		if (!Bunyad::options()->typekit_id) {
			$styles['bold']['extra_css'] = array('cheerup-skin-font' => '/css/skin-bold-raleway.css');
		}
		
		// Load up TypeKit modifications for default if it's active and disable google fonts
		if ($style == 'default' && Bunyad::options()->typekit_id) {
			$styles['default'] = array(
				'font_args' => '',
				'css' => 'skin-typekit'
			);
		}
		
		if (empty($styles[$style])) {
			return array();
		}
		
		return $styles[$style];
	}
	
	/**
	 * Get Google Fonts Embed URL
	 * 
	 * @return string URL for enqueue
	 */
	public function get_fonts_enqueue()
	{
		// Add google fonts
		$style = $this->get_style(Bunyad::options()->predefined_style);
		$args  = $style['font_args'];
	
		if (Bunyad::options()->font_charset) {
			$args['subset'] = implode(',', array_filter(Bunyad::options()->font_charset));
		}

		return add_query_arg(
			urlencode_deep($args), 
			(is_ssl() ? 'https' : 'http') . '://fonts.googleapis.com/css'
		);
	}
	
	/**
	 * Action callback: Add Typekit code to header
	 */
	public function add_typekit_code() 
	{
		//echo '<script>try{Typekit.load({ async: false });}catch(e){}</script>';

		// Using async loader instead
		?>
			<script>
			  (function(d) {
			    var config = {
			      kitId: '<?php echo esc_js(Bunyad::options()->typekit_id); ?>',
			      scriptTimeout: 3000,
			      async: true
			    },
			    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
			  })(document);
			</script>
		<?php		

	}
	
	/**
	 * Filter callback: Modify category widget for only top-level categories, if 
	 * enabled in customizer.
	 * 
	 * @param array $query
	 */
	public function category_widget_query($query)
	{
		if (!Bunyad::options()->widget_cats_parents) {
			return $query;
		}
		
		// Set to display top-level only
		$query['parent'] = 0;
		
		return $query;
	}
	
	/**
	 * Filter callback: Auto-embed video using a link
	 * 
	 * @param string $content
	 */
	public function video_auto_embed($content) 
	{
		global $wp_embed;
		
		if (!is_object($wp_embed)) {
			return $content;
		}
		
		return $wp_embed->autoembed($content);
	}
	
	/**
	 * Filter callback: Adjust dimensions for soundcloud auto-embed. A height of 
	 * width * 1.5 isn't ideal for the theme.
	 * 
	 * @param array  $dimensions
	 * @param string $url
	 * @see wp_embed_defaults()
	 */
	public function soundcloud_embed($dimensions, $url)
	{
		if (!strstr($url, 'soundcloud.com')) {
			return $dimensions;
		}
		
		$dimensions['height'] = 300;
		
		return $dimensions;
	}

	/**
	 * Filter callback: Remove unnecessary classes
	 */
	public function fix_post_class($classes = array())
	{
		// remove hentry, we use schema.org
		$classes = array_diff($classes, array('hentry'));
		
		return $classes;
	}
	
	/**
	 * Adjust content width for full-width posts
	 */
	public function content_width_fix()
	{
		global $content_width;
	
		if (Bunyad::core()->get_sidebar() == 'none') {
			$content_width = 1170;
		}
	}	
	
	/**
	 * Filter callback: Fix search by limiting to posts
	 * 
	 * @param object $query
	 */
	public function limit_search($query)
	{
		if (!$query->is_search OR !$query->is_main_query()) {
			return $query;
		}

		// ignore if on bbpress and woocommerce - is_woocommerce() cause 404 due to using get_queried_object()
		if (is_admin() OR (function_exists('is_bbpress') && is_bbpress()) OR (function_exists('is_shop') && is_shop())) {
			return $query;
		}
		
		// limit it to posts
		$query->set('post_type', 'post');
		
		return $query;
	}
	
	/**
	 * Limit number of posts shown on the home-page
	 * 
	 * @param object $query
	 */
	public function home_posts_limit($query)
	{
		// bail out if incorrect query
		if (is_admin() OR !$query->is_home() OR !$query->is_main_query()) {
			return $query;
		}
		
		$posts_per_page = Bunyad::options()->home_posts_limit;
		
		// Reduce one post for subsequent pages when using assorted, to account
		// for one large post on main home.
		if ($query->is_paged() && Bunyad::options()->home_layout == 'assorted') {
			$posts_per_page--;
		}

		$query->set('posts_per_page', $posts_per_page);
		
		return $query;
	}
	
	/**
	 * Adjust comment form fields order 
	 * 
	 * @param array $fields
	 */
	public function comment_form_order($fields)
	{

		// Un-necessary for WooCommerce
		if (function_exists('is_woocommerce') && is_woocommerce()) {
			return $fields;
		}
		
		// From Justin Tadlock's plugin
		if (isset($fields['comment'])) {
			
			// Grab the comment field.
			$comment_field = $fields['comment'];
			
			// Remove the comment field from its current position.
			unset($fields['comment']);
			
			// Put the comment field at the end.
			$fields['comment'] = $comment_field;
		}
		
		return $fields;
	}
	
	/**
	 * Filter callback: Custom menu fields.
	 *
	 * Required for both back-end and front-end.
	 *
	 * @see Bunyad_Menus::init()
	 */
	public function custom_menu_fields($fields)
	{
		$fields = array(
			'mega_menu' => array(
				'label' => esc_html_x('Mega Menu', 'Admin', 'cheerup'),
				'element' => array(
					'type' => 'select',
					'class' => 'widefat',
					'options' => array(
						0 => esc_html_x('Disabled', 'Admin', 'cheerup'),
						'category' => esc_html_x('Enabled', 'Admin', 'cheerup'),
					)
				),
				'parent_only' => true,
				//'locations' => array('cheerup-main'),
			)
		);
	
		return $fields;
	}
	
	/**
	 * Filter Callback: Add our custom mega-menus
	 *
	 * @param array $args
	 */
	public function attach_mega_menu($args)
	{
		extract($args);

		// Have a mega menu?
		if (empty($item->mega_menu)) {
			return $sub_menu;
		}
		
		ob_start();
		
		// Get our partial
		Bunyad::core()->partial('partials/mega-menu', compact('item', 'sub_menu', 'sub_items'));
		
		// Return template output
		return ob_get_clean();
	}
	
	/**
	 * Add icons for header nav-below-b
	 * 
	 * @param string $items
	 * @param array  $args
	 */
	public function add_navigation_icons($items, $args)
	{
		if (!in_array(Bunyad::options()->header_layout, array('nav-below-b', 'compact')) OR $args->theme_location != 'cheerup-main') {
			return $items;
		}
		
		ob_start();
		?>
		
		<li class="nav-icons">
			<?php if (Bunyad::options()->topbar_cart && class_exists('Bunyad_Theme_WooCommerce')): ?>
			
			<div class="cart-action cf">
				<?php echo Bunyad::get('woocommerce')->cart_link(); ?>
			</div>
			
			<?php endif; ?>
			
			<?php if (Bunyad::options()->topbar_search): ?>
			
			<a href="#" title="<?php esc_attr_e('Search', 'bunyad'); ?>" class="search-link"><i class="fa fa-search"></i></a>
			
			<div class="search-box-overlay">
				<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
				
					<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
					<input type="search" class="search-field" name="s" placeholder="<?php esc_attr_e('Type and press enter', 'cheerup'); ?>" value="<?php 
							echo esc_attr(get_search_query()); ?>" required />
							
				</form>
			</div>
			
			<?php endif; ?>
		</li>
		
		<?php
		
		$items .= ob_get_clean();
		
		return $items;
	}
	
	/**
	 * Filter callback: Add logo to the sticky navigation
	 */
	public function add_navigation_logo($items, $args)
	{
		if (!Bunyad::options()->topbar_sticky OR $args->theme_location != 'cheerup-main') {
			return $items;
		}
		
		if (Bunyad::options()->image_logo) {
			$logo = '<img src="' . esc_attr(Bunyad::options()->image_logo) .'" />'; 
		}
		
		$items = '<li class="sticky-logo"><a href="'. esc_url(home_url('/')) .'">' . $logo . '</a></li>' . $items;
		
		return $items;
	}
	
	/**
	 * Filter callback: Add slider and home to the body if activated on home
	 * 
	 * @param array $classes
	 */
	public function the_body_class($classes) 
	{
		
		if (Bunyad::options()->predefined_style) {
			$classes[] = 'skin-' . Bunyad::options()->predefined_style;	
		}
		
		/**
		 * The classes below are only for home
		 */
		if (!is_home() && !is_front_page()) {
			return $classes; 
		}
		
		if (Bunyad::options()->home_slider OR (is_page() && Bunyad::posts()->meta('featured_slider'))) {
			
			$slider = Bunyad::posts()->meta('featured_slider') ? Bunyad::posts()->meta('featured_slider') : Bunyad::options()->home_slider;
			
			$classes[] = 'has-slider';
			$classes[] = 'has-slider-' . $slider;
		}
		
		// Add home layout class
		if (Bunyad::options()->home_layout) {
			$classes[] = 'home-' . Bunyad::options()->home_layout;
		}
		
		return $classes;
	}
	
	/**
	 * Filter callback: Add support or bold and emphasis in markdown format.
	 * 
	 * Example:
	 * 
	 * __bold__ OR **bold** is converted to <strong>bold</strong>
	 * _text_  OR *text*  is converted to <em>text</em>
	 * 
	 * @param string $title
	 */
	public function title_styling($title)
	{
		$title = preg_replace(
			array('/(\*\*|__)(.*?)\1/', '/(\*|_)(.*?)\1/'),
			array('<strong>\2</strong>', '<em>\2</em>'),
			$title
		);
		
		return $title;
	}
	
	/**
	 * Add Pinterest hover button template
	 */
	public function add_pinterest()
	{
		if (!Bunyad::options()->pinit_button) {
			return;
		}
		
		$title = Bunyad::options()->pinit_button_text;
		$show_on = implode(',', Bunyad::options()->pinit_show_on);
		
		?>
		
		<a href="http://www.pinterest.com/pin/create/bookmarklet/?url=%url%&media=%media%" class="pinit-btn" target="_blank" title="<?php 
			echo esc_html($title); ?>" data-show-on="<?php echo esc_attr($show_on); ?>">
			<i class="fa fa-pinterest-p"></i>
			
			<?php if (Bunyad::options()->pinit_button_label): ?>
				<span class="label"><?php echo esc_html($title); ?></span>
			<?php endif; ?>
			
		</a>
		<?php
	}
	
	/**
	 * Fix JetPack polluting the excerpts
	 */
	public function jetpack_fix()
	{
		// Fix JetPack adding sharing to widgets and small posts
		remove_filter('the_excerpt', 'sharing_display', 19);
	}

	/**
	 * Jetpack tiled galleries need to be activated if not already active
	 */
	public function jetpack_modules_fix()
	{
		if (!class_exists('Jetpack') OR !is_callable(array('Jetpack', 'is_module_active'))) {
			return;
		}

		// Activate tiled galleries if not active
		if (!Jetpack::is_module_active('tiled-gallery')) {
			Jetpack::activate_module('tiled-gallery', false, false);
		}
	}
}
