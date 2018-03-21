<?php
/**
 * CheerUp Rovella Skin setup
 */
class Bunyad_Skins_Rovella
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

// init and make available in Bunyad::get('skins_rovella')
Bunyad::register('skins_rovella', array(
	'class' => 'Bunyad_Skins_Rovella',
	'init' => true
));