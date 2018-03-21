<?php
/**
 * CheerUp Bold Blog Skin setup
 */
class Bunyad_Skins_Bold
{
	public function __construct() 
	{
		// Special thumbs for this skin
		add_filter('bunyad_image_sizes', array($this, 'image_sizes'));
		
		// Add additional options
		$this->change_options();
		
		add_action('after_setup_theme', array($this, 'theme_init'), 13);
		
		// Options are re-initialzed by init_preview, so need to be added again
		// @see Bunyad_Theme_Customizer::init_preview() 
		add_action('customize_preview_init', array($this, 'change_options'), 11);
	}
	
	/**
	 * Add extra selectors needed for the skin
	 */
	public function change_options()
	{
		
		$opts = Bunyad::options()->defaults;
		/*$opts['css_main_color']['css']['selectors'] += array(
			'.navigation.dark .menu li:hover > a,
			.navigation.dark .menu li li:hover > a,
			.navigation.dark .menu li:hover > a:after' 
				=> 'color: %s',
				
			'.sidebar .widget-title:after,
			.comment-respond .section-head .title:after'
				=> 'background: %s',
				
			'.section-head .title'
				=> 'border-bottom-color: %s'
		);*/
		
		// commit to options memory
		Bunyad::options()->defaults = $opts;
	}
	
	/**
	 * Run after main functions.php theme_init has run
	 */
	public function theme_init() 
	{
		Bunyad::posts()->more_text = esc_html__('Read More', 'cheerup');
	}

	/**
	 * Filter callback: Modify image sizes for this skin
	 * 
	 * @see Bunyad_Theme_Cheerup::theme_init()
	 */
	public function image_sizes($sizes) 
	{
		$modified = array(
 			'cheerup-grid'  => array('width' => 370, 'height' => 247),
			'cheerup-carousel-b' => array('width' => 370, 'height' => 247), // Re-do Alias
// 			'cheerup-thumb' => array('width' => 110, 'height' => 73),
		);
		
		return array_merge($sizes, $modified);
	}
}

// init and make available in Bunyad::get('skins_bold')
Bunyad::register('skins_bold', array(
	'class' => 'Bunyad_Skins_Bold',
	'init' => true
));