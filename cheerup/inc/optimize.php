<?php
/**
 * Performance optimizations and relevant plugins compatibility.
 * 
 * Only for the adventurous - raw code ahead!
 */
class Bunyad_Theme_Optimize
{
	private $_defer_fonts = array();
	
	public function __construct()
	{
		/**
		 * Autoptimize plugin "defer" mode requires several changes to how things work
		 */
		if (defined('AUTOPTIMIZE_PLUGIN_DIR')) {
			
			$css_defer = get_option('autoptimize_css_defer');
			if ($css_defer) {
			
				add_action('wp_enqueue_scripts', array($this, 'dequeue_fonts'), 11);
				add_action('wp_head', array($this, 'defer_fonts'));
				add_action('wp_head', array($this, 'aop_defer_visibility'), -1);
				add_action('wp_head', array($this, 'aop_defer_ios_fix'), 100);
				add_action('bunyad_begin_body', array($this, 'aop_defer_loader_tag'));
		
				add_filter('autoptimize_filter_css_exclude', array($this, 'aop_exclude_merge'));
				add_filter('autoptimize_filter_css_preload_onload', array($this, 'aop_improve_preload'));
			}
		}
		
		add_action('wp_head', array($this, 'preload_typekit'));
		
		// Fix jetpack devicepx script to be deferred
		add_filter('script_loader_tag', array($this, 'jetpack_defer'), 10, 2);
		
		// After 
		add_filter('after_setup_theme', array($this, 'init'), 11);

	}
	
	/**
	 * Init when skins and theme is setup
	 */
	public function init()
	{
		// Additional image sizes
		if (Bunyad::options()->perf_additional_sizes) {
			add_filter('bunyad_image_sizes', array($this, 'add_image_sizes'), 11);
		}
		
	}
	
	/**
	 * Add additional image sizes
	 */
	public function add_image_sizes($sizes) 
	{	
		$extra = array(
			'cheerup-large-cover'   => array('width' => 1800, 'height' => 1200, 'crop' => false),
			'cheerup-masonry'       => array('width' => 370, 'height' => 0, 'crop' => false),
			'cheerup-widget-slider' => array('width' => 370, 'height' => 400),
		);
		
		// Rovella, Travel use cheerup-list-b alias - can be improved
		if ($sizes['cheerup-carousel']['width'] == 370) {
			$sizes['cheerup-carousel'] = array('width' => 270, 'height' => 223);
		}
		
		return array_merge($sizes, $extra);
	}
	
	/**
	 * Remove google font queue in the header
	 */
	public function dequeue_fonts()
	{
		// Google fonts as default
		if (wp_style_is('cheerup-fonts', 'enqueued')) {
			
			// Set flag
			$this->_defer_fonts[] = 'google';
			
			// Dequeue it for now
			wp_dequeue_style('cheerup-fonts');
		}
	}
	
	/**
	 * Add preload
	 */
	public function defer_fonts()
	{
		if (in_array('google', $this->_defer_fonts)) {
			
			$this->the_preload_tag(Bunyad::get('cheerup')->get_fonts_enqueue());
		}
	}
	
	/**
	 * Add TypeKit script to preload
	 */
	public function preload_typekit()
	{
		if (!Bunyad::options()->typekit_id) {
			return;
		}
		
		$this->the_preload_tag('https://use.typekit.net/' . Bunyad::options()->typekit_id . '.js', 'script');
	}
	
	/**
	 * Output the preload tag
	 * 
	 * @param string $url   The script/style url
	 * @param string $type  style or script
	 * @param string $apply Whether to apply the style immediately
	 */
	public function the_preload_tag($url, $type = 'style', $apply = true)
	{
		if ($type !== 'style' && $apply) {
			$apply = false;
		}
		
		$link = '<link rel="preload" as="'. esc_attr($type) .'" media="all" href="' . esc_url($url) . '"' 
		      . ($apply ? ' onload="this.onload=null;this.rel=\'stylesheet\'"' : '') 
		      . ' />';
		
		echo $link;
	}
	
	/**
	 * Exclude some CSS from autoptimize merge
	 * 
	 * @param string $exclude
	 */
	public function aop_exclude_merge($exclude)
	{
		$exclude .= ',cheerup-skin-inline-css,cheerup-child-inline-css,ts-ld';
		
		return $exclude;
	}
	
	/**
	 * Add a loader tag for AOP deferred
	 */
	public function aop_defer_loader_tag()
	{
		echo '<div class="ts_ld"></div>';
	}
	
	/**
	 * Deferred stylesheet requires temporarily hiding
	 */
	public function aop_defer_visibility()
	{
		
		/**
		 * Unique loading method by ThemeSphere
		 * 
		 * 1. CSS to keep things hidden while styles load async.
		 * 2. Enhance load if rel=preload is supported in the browser.
		 *    - And thus preload 'onload' calls ts_ld().
		 *    - Add .ld class and remove it after 32-120ms of stylesheet being applied
		 */
		$script = "
		var ts_ld, ld_done, ld_skip;
		(function(w,d) {
			
			ld_skip = /iPad|iPhone|iPod/.test(navigator.userAgent);
			if (ld_skip) return;
			
			d.head.innerHTML += '<style>.ld .ts_ld { z-index: 99999; background: #fff; position: fixed; top: 0; left: 0; right: 0; bottom: 0; }a { color: #fff; }</style>';

			var h = d.documentElement;
			
			ld_done = function() {
				var f = function() {
					h.className = h.className.replace(/\bld\b/, '');
				};

				('requestIdleCallback' in w) 
					?  requestIdleCallback(f, {timeout: 120})
					:  setTimeout(f, 64);
			};

			ts_ld = function() {
				setTimeout(ld_done, 32);
			};
			
			h.className += ' ld';
			setTimeout(ld_done, 4500);
			
		})(window, document);
		";
		
		echo '<script>' . $this->_quick_minify($script) . '</script>';
		
	  	// echo "<script>var e = document.createElement('style');e.id='ts-system-css';
	  	//	e.appendChild(document.createTextNode('body{visibility: hidden;}a{color: #fff;}'));
  		//	document.head.appendChild(e);</script>\n";
	}
	
	/**
	 * iOS doesn't play well with due to reflows
	 */
	public function aop_defer_ios_fix()
	{
		$script = "
			if (window.ld_skip) {
				var l = document.querySelectorAll('link[as=style]'), i = 0;
				for (; i < l.length; i++) {
					l[i].rel='stylesheet';
					l[i].as='';
					l[i].onload=null;
				}
			}
		";
		
		echo '<script>' . $this->_quick_minify($script) . '</script>';
	}
	
	/**
	 * Rewrite preload assets from Autoptimize to improve
	 */
	public function aop_improve_preload($content)
	{
		return "this.onload=null;this.rel='stylesheet';ts_ld()";
	}
	
	/**
	 * Quick CSS / JS minify that doesn't do much at all 
	 */
	public function _quick_minify($text)
	{
		return str_replace(array("\r", "\n", "\t"), '', $text);
	}
	
	/**
	 * Fix Jetpack not using deferred JS for devicepx 
	 */
	public function jetpack_defer($tag, $handle)
	{		
		if ($handle == 'devicepx') {
			$tag = str_replace('src=', 'defer src=', $tag);
		}
		
		return $tag;
	}
}


// init and make available in Bunyad::get('optimize')
Bunyad::register('optimize', array(
	'class' => 'Bunyad_Theme_Optimize',
	'init' => true
));