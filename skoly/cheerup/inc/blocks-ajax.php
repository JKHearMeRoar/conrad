<?php
/**
 * Blocks & Listings AJAX handlers
 */
class Bunyad_Theme_Blocks_Ajax
{
	public function __construct() 
	{
		
		add_action('shutdown', array($this, 'update_data'));
		add_action('wp_enqueue_scripts', array($this, 'register_script'), 11);
		
		// Load bunyad blocks data
		
		//print_r(Bunyad::registry()->blocks_data);

		if (!empty($_GET['_bunyad_act'])) {
			$this->ajax();
		}
		
	}
	
	/**
	 * Custom AJAX Implementation that supports cache plugins
	 */
	public function ajax() 
	{
		global $wp_rewrite;
		
		// Remove GET parameters from REQUEST_URL to prevent un-necessary vars
		$remove = array('_bunyad_act', 'block_id');
		
		if ($wp_rewrite->using_permalinks()) {
			$remove = array_merge($remove, array('page_id', 'paged'));
		}
		
		$_SERVER['REQUEST_URI'] = remove_query_arg($remove);

		// Emulate
		define('DOING_AJAX', true);
		
		// Render block 
		if ($_GET['_bunyad_act'] == 'block') {
			
			// Don't auto-redirect
			remove_action('template_redirect', 'redirect_canonical');
			
			// Using on template_redirect to ensure everything's loaded
			add_action('template_redirect', array($this, 'process_block'), 20);
		}
	}
	
	public function register_script()
	{
		global $wp;
		
		// Add custom ajax handler URL
		// Link to current page as WordPress pagination can get messed up if using root url
		wp_localize_script('cheerup-theme', 'Bunyad', array('custom_ajax_url' =>  remove_query_arg(array('page_id', 'paged')) ));
	}
	

	/**
	 * Process AJAX request to render the block
	 */
	public function process_block()
	{
		
		if (empty($_GET['page_id']) OR empty($_GET['block_id'])) {
			wp_die('0');
		}

		/**
		 * Sets Layout
		 * 
		 * Bunyad_Core does it after header hook but we need it for realative_width calculation
		 * much before that happens.
		 */
		$layout = Bunyad::posts()->meta('layout_style', $_GET['page_id']);
		if ($layout) {
			Bunyad::core()->set_sidebar(($layout == 'full' ? 'none' : $layout));
		}
		
		// Get blocks for specified page id
		$blocks = $this->get_blocks($_GET['page_id']);
		
		// Block data missing?
		if (empty($blocks[ $_GET['block_id'] ])) {
			wp_die('0');
		}
		
		// Set page manually as paged is in URL regardless of front or not
		if (!empty($_GET['paged'])) {
			set_query_var(
				(is_front_page() ? 'page' : 'paged'),
				$_GET['paged']
			);
		}
		
		// Set required vars for block
		$atts = $blocks[ $_GET['block_id'] ];
		$tag  = $atts['_block_tag'];
		
		// For VC Support - See inc/block.php
		if (!empty($atts['_col_relative_width'])) {
			Bunyad::registry()->layout = array_merge(
				(array) Bunyad::registry()->layout, 
				array('col_relative_width' => $atts['_col_relative_width'])
			); 
		}
		
		extract($atts, EXTR_SKIP);
		
		include $atts['block_file'];
		
		wp_die();
	}
	
	/**
	 * Get blocks data
	 * 
	 * @param integer $post_id  Page ID
	 */
	public function get_blocks($post_id = null) 
	{
		
		$blocks = get_option('_bunyad_blocks_data');
		
		if (!$post_id) {
			return $blocks;
		}
		
		return (array) $blocks[$post_id];
	}
	
	/**
	 * Store the in-memory data created by blocks, only needed for AJAX
	 * 
	 * @see Bunyad_Theme_Block::process()
	 */
	public function update_data() 
	{
	
		$page_blocks = Bunyad::registry()->page_blocks;
		if (empty($page_blocks)) {
			return;
		}
		
		// Cache blocks
		$blocks_data = $this->get_blocks();
		if (empty($blocks_data)) {
			$blocks_data = array();
		}
		
		// Prevent buggy plugins
		wp_reset_query();
		$post = get_queried_object_id();
		
		$blocks_data[$post] = $page_blocks;
		
		// Store data
		update_option('_bunyad_blocks_data', $blocks_data);
	}
}

// init and make available in Bunyad::get('blocks-ajax')
Bunyad::register('blocks-ajax', array(
	'class' => 'Bunyad_Theme_Blocks_Ajax',
	'init' => true
));