<?php
/**
 * CheerUp Fitness Skin setup
 */
class Bunyad_Skins_Fitness
{
	public function __construct() 
	{
		// Add additional options
		$this->change_options();
		
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
		$opts['css_main_color']['css']['selectors'] += array(
			'.navigation.dark .menu li:hover > a,
			.navigation.dark .menu li li:hover > a,
			.navigation.dark .menu li:hover > a:after' 
				=> 'color: %s',
				
			'.sidebar .widget-title'
				=> 'border-top-color: %s',
		);
		
		// commit to options memory
		Bunyad::options()->defaults = $opts;
	}
}

// init and make available in Bunyad::get('skins_fitness')
Bunyad::register('skins_fitness', array(
	'class' => 'Bunyad_Skins_Fitness',
	'init' => true
));