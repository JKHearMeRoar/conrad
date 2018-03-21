<?php
/**
 * Initialize internal widgets that are embedded within the theme
 * 
 * @package Bunyad
 */

class Bunyad_WidgetsEmbed
{
	public function __construct()
	{
		add_action('widgets_init', array($this, 'setup'));
	}
	
	/**
	 * Initialize the widgets
	 */
	public function setup() 
	{
		$widgets = apply_filters('bunyad_active_widgets', array());

		// Activate widgets
		foreach ($widgets as $widget) 
		{
			$file  = locate_template('inc/widgets/widget-'. sanitize_file_name($widget) .'.php');
			$class = 'Bunyad_' . implode('', array_map('ucfirst', explode('-', $widget))) . '_Widget';
			
			// Skip if already included or if file is missing
			if (class_exists($class) OR !file_exists($file)) {
				continue;
			}
			
			// Include the widget class
			require_once $file;
			
			if (!class_exists($class)) {
				continue;
			}
			
			/**
			 * Use register widget method of the Bunyad_XYZ_Widget class if available.
			 * Fallback to register_widget.
			 * 
			 * @see register_widget()
			 */
			if (method_exists($class, 'register_widget')) {
				$caller = new $class;
				$caller->register_widget(); 
			}
			else {
				register_widget($class);
			}
		}
	}
}