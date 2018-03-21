<?php
/**
 * CheerUp Travel Skin setup
 */
class Bunyad_Skins_Travel
{
	public function __construct() 
	{
		// Special thumbs for this skin
		add_filter('bunyad_image_sizes', array($this, 'image_sizes'));
	}
	
	/**
	 * Filter callback: Modify image sizes for this skin
	 * 
	 * @see Bunyad_Theme_Cheerup::theme_init()
	 */
	public function image_sizes($sizes) 
	{
		$modified = array(
 			'cheerup-carousel'   => array('width' => 370, 'height' => 305), // Alias to cheerup-list-b
		);
		
		return array_merge($sizes, $modified);
	}
}

// init and make available in Bunyad::get('skins_travel')
Bunyad::register('skins_travel', array(
	'class' => 'Bunyad_Skins_Travel',
	'init' => true
));