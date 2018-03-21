/**
 * Customizer postMessage handlers for frontend
 */

(function($) {
	 "use strict";
	
	var api = wp.customize;
	
	
	/**
	 * Live update Custom CSS
	 */
	api('cheerup_theme_options[css_custom]', function(value) {
		
		value.bind(function(change) {

			var custom_css = $('#cheerup-custom-css');
			
			if (!custom_css.length) {
				
				// add the style to preview
				$('<style id="cheerup-custom-css" />').appendTo('head');
				
				// remove existing custom styles
				//$('#cheerup-skin-inline-css, #cheerup-core-inline-css').remove();
			}
			
			custom_css.text(change);

		});
	});
	
})(jQuery);