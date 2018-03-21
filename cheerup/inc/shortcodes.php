<?php
/**
 * Methods for shortcodes
 */
class Bunyad_Theme_ShortCodes 
{
	public $blocks = array();
	
	/**
	 * Add a special kind of shortcode that's handled by an included php file
	 * 
	 * @param array|string $shortcodes
	 */
	public function add($shortcodes)
	{
		$shortcodes   = (array) $shortcodes;
		$this->blocks = array_merge($this->blocks, $shortcodes);
		
		foreach ($shortcodes as $tag => $shortcode) {
			add_shortcode($tag, array($this, '_render'));
		}
		
		return $this;
	}
	
	/**
	 * Callback: Render a shortcode
	 */
	public function _render($atts = array(), $content = '', $tag)
	{
		$block = $this->blocks[$tag];
		
		// Extract attributes
		if (isset($block['attribs']) && is_array($block['attribs'])) {
			$atts = shortcode_atts($block['attribs'], $atts);
		}

		extract($atts, EXTR_SKIP);
		
		// Block file
		$block_file = $block['render'];
		
		// No file?
		if (!is_array($block) OR !file_exists($block_file)) {
			return false;
		}
		
		$atts['block_file'] = $block_file;
		
		// save the current block in registry
		if (class_exists('Bunyad_Registry')) {
			Bunyad::registry()
				->set('block', $block)
				->set('block_atts', $atts);
		}
		
		// get file content
		ob_start();
		
		include apply_filters('bunyad_block_file', $block_file, $block);
		
		$block_content = ob_get_clean();
		
		return do_shortcode($block_content);
	}
}

// init and make available in Bunyad::get('shortcodes')
Bunyad::register('shortcodes', array(
	'class' => 'Bunyad_Theme_ShortCodes',
	'init' => true
));