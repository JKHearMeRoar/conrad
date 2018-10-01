<?php
/**
 * CheerUp Fashion Skin setup
 */
class Bunyad_Skins_Fashion
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

			'.main-footer.stylish .copyright a'
				=> 'color: %s'
		);
		
		// commit to options memory
		Bunyad::options()->defaults = $opts;
	}
}

// init and make available in Bunyad::get('skins_fashion')
Bunyad::register('skins_fashion', array(
	'class' => 'Bunyad_Skins_Fashion',
	'init' => true
));