<?php
/**
 * Theme related configuration and modifiers for Visual Composer page builder
 */
class Bunyad_Theme_Visual_Composer
{
	public $official = false;
	
	public function __construct()
	{
		add_action('vc_before_init', array($this, 'vc_setup'));
		add_action('vc_after_init', array($this, 'after_setup'));
		
		add_filter('vc_shortcodes_css_class', array($this, 'custom_classes'), 10, 3);
		
		// Row filters
		add_filter('vc_theme_after_vc_row', array($this, 'after_vc_row'), 10, 2);
		add_filter('vc_theme_after_vc_row_inner', array($this, 'after_vc_row'), 10, 2);
		
		// Add correct markup for widgets
		add_filter('vc_shortcode_output', array($this, 'fix_widget_titles'), 10, 2);
		add_filter('wpb_widget_title', array($this, 'vc_widget_titles'), 10, 2);
		
		Bunyad::registry()->layout = array(
			'row_depth' => 0,
			'row_open'  => false,
			'row_cols'  => array(),
			'row_parent_open' => false
		);
		
		// Fix page template for visual composer
		add_action('save_post', array($this, 'set_page_template'));
		
		// Load pre-made templates
		add_filter('vc_load_default_templates', array($this, 'load_templates'));
	}
	
	/**
	 * Action callback: Setup at VC init
	 */
	public function vc_setup()
	{
		add_filter('template_include',  array($this, 'set_template_front'));

		// Set as theme and disable update nag - use local updates
		vc_set_as_theme(true);
		
		// Using official copy?
		if (function_exists('vc_license')) {
			$license = vc_license();
			
			if (method_exists($license, 'isActivated')) {
				$this->official = $license->isActivated();
			}
		}
		
		/* Disables product activation as a side effect
		if (function_exists('vc_manager')) {
			$vc = vc_manager();
			$not_update_page = (empty($_GET['page']) OR $_GET['page'] != 'vc-updater');
			
			if (!$this->official && method_exists($vc, 'disableUpdater') && $not_update_page) {
				//$vc->disableUpdater(true);
			}
		}*/
		
		// Set shortcode directory
		vc_set_shortcodes_templates_dir(locate_template('partials/blocks/vc-templates'));
		
		// Register blocks
		add_action('init', array($this, 'register_blocks'));
		
		
		// Remove un-necessary unless official copy
		if (!$this->official) {
			// Remove non-supported blocks
			add_action('admin_init', array($this, 'remove_unsupported'));
		
			// Remove un-needed menu items
			add_action('admin_menu', array($this, 'remove_admin_menu'), 99);
		}
		
		if (is_admin()) {
			// Activation cta
			add_action('gettext', array($this, 'vc_cta'), 99, 3);
			
			// Remove confusing welcome on theme plugin activation
			remove_action('admin_init', 'vc_page_welcome_redirect');
		}
		
		// No edit with visual composer link in admin bar
		remove_action('admin_bar_menu', array(vc_frontend_editor(), 'adminBarEditLink'), 1000);
	}
	
	/**
	 * Action callback:  Run after VC is setup
	 */
	public function after_setup()
	{
		remove_action('wp_head', array(visual_composer(), 'addMetaData'));
		// wpb-js-composer class is needed by accordions and so on
		//remove_action('body_class', array(visual_composer(), 'bodyClass'));

		// Remove some auto-update feature unless official activated
		if (!$this->official && function_exists('vc_manager')) {
			$updater = vc_manager()->updater();
			
			if (method_exists($updater, 'updateManager')) {
				$update_manager = $updater->updateManager();
			}
			
			if (is_object($update_manager)) {
				remove_filter('pre_set_site_transient_update_plugins', array($update_manager, 'check_update'));
				
				if (function_exists('vc_plugin_name')) {
					remove_action('in_plugin_update_message-' . vc_plugin_name(), array($update_manager, 'addUpgradeMessageLink'));
				}
			}
		}
	}
	
	/**
	 * Filter callback: Modify default WP widget titles output from VC
	 * 
	 * @param unknown_type $content
	 */
	public function fix_widget_titles($content, $shortcode)
	{
		// only work on vc_wp_* shortcodes - ignore the rest
		if (is_object($shortcode) && method_exists($shortcode, 'settings') && !strstr($shortcode->settings('base'), 'vc_wp_')) {
			return $content;
		}
		
		return preg_replace('#<h2 class="widgettitle">(.+?)</h2>#', '<h5 class="widget-title"><span>\\1</span></h5>', $content);
	}
	
	/**
	 * Filter callback: Modify default VC widgets title output
	 * 
	 * @param string $output
	 * @param array $params
	 */
	public function vc_widget_titles($output, $params = array()) 
	{
		if (empty($params['title'])) {
			return $output;
		}

		$output = '<div class="block-head-b"><h5 class="wpb_heading title ' . $params['extraclass'] . '">' . $params['title'] . '</h3></div>';
		
		return $output;
	}
	
	/**
	 * Action callback: Set proper page template on save for Visual Composer pages
	 * 
	 * @param integer $post_id
	 */
	public function set_page_template($post_id)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}
		
		// Only if can edit page
		if (!current_user_can('edit_page', $post_id)) {
			return;
		}
		
		// Has visual composer content? wpb_vc_js_status=true would be limiting
		if (!empty($_POST['post_type']) && $_POST['post_type'] == 'page' && strstr($_POST['post_content'], '[vc_row')) {
			
			// set page template
			update_post_meta($post_id, '_wp_page_template', 'page-blocks.php');
		}
	}

	/**
	 * Filter callback: Set page template from VC frontend
	 */
	public function set_template_front($template) 
	{
		if (function_exists('vc_is_inline') && vc_is_inline()) {
			
			$post = get_post();

			if (is_page()) {
				$current = basename($template);

				if ($current !== 'page-blocks.php') {
					$template = locate_template('page-blocks.php');
				}
			}
		}

		return $template;
	}
	
	/**
	 * Register blocks with Visual Composer
	 */
	public function register_blocks()
	{		
		// only enable in admin or when front-end editor is called
		if (!is_admin() && !vc_is_frontend_editor() && !vc_is_page_editable()) {
			return;
		}
		
		/**
		 * Get categories list for dropdown options in VC 
		 */
		$categories = get_terms('category', array(
			'hide_empty' => 0,
			'hide_if_empty' => false,
			'hierarchical' => 1, 
			'order_by' => 'name' 
		));
	
		$categories = array_merge(
			array(__('-- None / Not Limited --', 'bunyad') => ''), 
			$this->_recurse_terms_array(0, $categories)
		);
		
		/**
		 * The default options generally shared between blocks 
		 */
		$common = array(
	
			'posts' => array(
				'type' => 'textfield',
				'heading' => __('Number of Posts', 'bunyad'),
				'value'  => 5,
				'param_name' => 'posts',
				'admin_label' => false,
			),
			
			'sort_by' => array(
				'type' => 'dropdown',
				'heading' => __('Sort By', 'bunyad'),
				'value'  => array(
					__('Published Date', 'bunyad') => '',
					__('Modified Date', 'bunyad') => 'modified',
					__('Random', 'bunyad') => 'random',
					__('Comment Count', 'bunyad') => 'comments',
					__('Alphabetical', 'bunyad') => 'alphabetical',
					esc_html_x('Most Liked', 'Admin', 'cheerup') => 'liked'
				),
				'param_name' => 'sort_by',
				'admin_label' => false,
			),
			
			'sort_order' => array(
				'type' => 'dropdown',
				'heading' => __('Sort Order', 'bunyad'),
				'value'  => array(
					__('Descending - Higher to lower (Latest First)', 'bunyad') => 'desc',
					__('Ascending - Lower to Higher (Oldest First)', 'bunyad')  => 'asc',
				),
				'param_name' => 'sort_order',
				'admin_label' => false,
			),
			
			'heading' => array(
				'type' => 'textfield',
				'heading' => __('Heading  (Optional)', 'bunyad'),
				'description' => __('By default, the main selected category\'s name is used as the title.', 'bunyad'),
				'value'  => '',
				'param_name' => 'heading',
				'admin_label' => true,
			),
			
			'heading_type' => array(
				'type' => 'dropdown',
				'heading' => __('Heading Type', 'bunyad'),
				'description' => __('Use Small Headings for 1/3 columns. Default headings are good for full-width and half column blocks.', 'bunyad'),
				'value'  => array(
					esc_html_x('Magazine Block', 'Admin', 'cheerup') => 'modern',
					esc_html_x('Blog Style', 'Admin', 'cheerup') => 'blog',
					esc_html_x('Disabled', 'Admin', 'cheerup') => 'none',
				),
				'param_name' => 'heading_type',
			),
			
			'view_all' => array(
				'type' => 'textfield',
				'heading' => __('View All Text (Optional)', 'bunyad'),
				'description' => __('If not empty, this text will show with heading link.', 'bunyad'),
				'value' => '',
				'param_name' => 'view_all',
			),
			
			'link' => array(
				'type' => 'textfield',
				'heading' => __('Heading Link (Optional)', 'bunyad'),
				'description' => __('By default, the main selected category\'s link is used.', 'bunyad'),
				'value'  => '',
				'param_name' => 'link',
			),
				
			'offset' => array(
				'type' => 'textfield',
				'heading' => __('Advanced: Offset', 'bunyad'),
				'description' => __('An offset can be used to skip first X posts from the results.', 'bunyad'),
				'value'  => '',
				'param_name' => 'offset',
			),
				
			'cat' => array(
				'type' => 'dropdown',
				'heading' => esc_html_x('From Category', 'Admin', 'cheerup'),
				'description' => __('Posts will be limited to this category', 'cheerup'),
				'value'  => $categories,
				'param_name' => 'cat',
				'admin_label' => true,
				'group' => esc_html_x('Refine Posts', 'Admin', 'cheerup'),
			),
				
			'terms' => array(
				'type' => 'textfield',
				'heading' => __('From Multiple Categories', 'bunyad'),
				'description' => __('If you need posts from more categories. Enter cat slugs separated by commas. Example: beauty,world-news', 'bunyad'),
				'value'  => '',
				'param_name' => 'terms',
				'group' => esc_html_x('Refine Posts', 'Admin', 'cheerup'),
			),
				
			'tags' => array(
				'type' => 'textfield',
				'heading' => __('Posts From Tags', 'bunyad'),
				'description' => __('A single or multiple tags. Enter tag slugs separated by commas. Example: food,sports', 'bunyad'),
				'value'  => '',
				'param_name' => 'tags',
				'group' => esc_html_x('Refine Posts', 'Admin', 'cheerup'),
			),

			
			'post_format' => array(
				'type' => 'dropdown',
				'heading' => __('Post Format', 'bunyad'),
				'description' => __('', 'bunyad'),
				'value'  => array(
					__('All', 'bunyad') => '',
					__('Video', 'bunyad') => 'video',
					__('Gallery', 'bunyad') => 'gallery',
					__('Image', 'bunyad') => 'image',
				),
				'param_name' => 'post_format',
				'group' => esc_html_x('Refine Posts', 'Admin', 'cheerup'),
			),
				
			'post_type' => array(
				'type' => 'posttypes',
				'heading' => __('Advanced: Post Types', 'bunyad'),
				'description' => __('Use this feature if Custom Post Types are needed.', 'bunyad'),
				'value'  => '',
				'param_name' => 'post_type',
				'group' => esc_html_x('Refine Posts', 'Admin', 'cheerup'),
			),
		);
		
		$common = apply_filters('bunyad_vc_map_common', $common);
		
		// Pagination types for the blocks
		$pagination_types = array(
			'load-more' => esc_html_x('Load More (AJAX)', 'Admin', 'cheerup'),
			'numbers' => esc_html_x('Page Numbers (AJAX)', 'Admin', 'cheerup'),
			''  => esc_html_x('Older / Newer (Only if one or last block)', 'Admin', 'cheerup'),
		);
		
		
		/**
		 * Highlights block
		 */
		vc_map(array(
			'name' => __('Highlights Block', 'bunyad'),
			'base' => 'highlights',
			'description' => __('Run-down of news from a category.', 'bunyad'),
			'class' => 'sphere-icon',
			'icon' => 'tsb-highlights',
			'category' => esc_html_x('Home Blocks', 'Admin', 'cheerup'),
			'weight' => 1,
			'params' => $common,
		));
		
		
		/**
		 * News Grid block
		 */
		vc_map(array(
			'name' => __('News Grid Block', 'bunyad'),
			'base' => 'news_grid',
			'description' => __('News in a compact grid.', 'bunyad'),
			'class' => 'sphere-icon',
			'icon' => 'tsb-news-grid',
			'category' => esc_html_x('Home Blocks', 'Admin', 'cheerup'),
			'weight' => 1,
			'params' => $common,
		));
		
		
		/**
		 * Blog/Listing block
		 */	
		
		// Blog listing types
		$listings = array(
			'' => esc_html_x('Classic Large Posts', 'Admin', 'cheerup'),
			'loop-1st-large' => esc_html_x('One Large Post + Grid', 'Admin', 'cheerup'),
			'loop-1st-large-list' => esc_html_x('One Large Post + List', 'Admin', 'cheerup'),
			'loop-1st-overlay' => esc_html_x('One Overlay Post + Grid', 'Admin', 'cheerup'),
			'loop-1st-overlay-list' => esc_html_x('One Overlay Post + List', 'Admin', 'cheerup'),
				
			'loop-1-2' => esc_html_x('Mixed: Large Post + 2 Grid ', 'Admin', 'cheerup'),
			'loop-1-2-list' => esc_html_x('Mixed: Large Post + 2 List ', 'Admin', 'cheerup'),

			'loop-1-2-overlay' => esc_html_x('Mixed: Overlay Post + 2 Grid ', 'Admin', 'cheerup'),
			'loop-1-2-overlay-list' => esc_html_x('Mixed: Overlay Post + 2 List ', 'Admin', 'cheerup'),
				
			'loop-list' => esc_html_x('List Posts', 'Admin', 'cheerup'),
			'loop-grid' => esc_html_x('Grid Posts', 'Admin', 'cheerup'),
			'loop-grid-3' => esc_html_x('Grid Posts (3 Columns)', 'Admin', 'cheerup'),
		);
		

		// Block settings
		$blog = array_merge(array(
				'type' => array(
					'type' => 'dropdown',
					'heading' => __('Listing Type', 'bunyad'),
					'description' => __('', 'bunyad'),
					'value'  => array_flip($listings),
					'param_name' => 'type',
				),
				
				'show_excerpt' => array(
					'type' => 'checkbox',
					'heading' => esc_html_x('Show Excerpts?', 'Admin', 'bunyad'),
					'param_name' => 'show_excerpt',
					'value' => array(
						esc_html_x('Yes', 'Admin', 'cheerup') => 1
					),
					'std' => 1,
					'dependency' => array(
						'element' => 'type',
						'value'   => array_values(array_diff(
							array_keys($listings), 
							array('loop-1st-overlay', 'loop-1st-overlay-list', 'loop-1-2-overlay', 'loop-1-2-overlay-list')
						)),
					)
				),

				'show_footer' => array(
					'type' => 'dropdown',
					'heading' => esc_html_x('Show Posts Footer?', 'Admin', 'bunyad'),
					'description' => esc_html_x('Enable to show Social icons or Read More depending on grid post style chosen in customizer.', 'bunyad'),
					'param_name' => 'show_footer',
					'value' => array(
						esc_html_x('Yes', 'Admin', 'cheerup') => 1,
					),
					'std' => 1,
					'dependency' => array(
						'element' => 'type',
						'value'   => array('loop-grid', 'loop-grid-3', 'loop-1st-large'),
					)
				),
				
				'pagination' => array(
					'type' => 'dropdown',
					'heading' => __('Pagination', 'bunyad'),
					'value'  => array(
						__('Disabled', 'bunyad') => '',
						__('Enabled', 'bunyad') => '1',
					),
					'param_name' => 'pagination',
				),
				
				'pagination_type' => array(
					'type' => 'dropdown',
					'heading' => __('Pagination Type', 'bunyad'),
					'value'  => array_flip($pagination_types),
					'param_name' => 'pagination_type',
					'dependency' => array(
						'element' => 'pagination',
						'value'   => array('1')
					),
				),
			), $common
		);

		$blog['posts']['value'] = 6;
		
		vc_map(array(
			'name' => sprintf(esc_html_x('Post Listings', 'Admin', 'cheerup'), count($listings)),
			'description' => __('For blog/category style listings.', 'bunyad'),
			'base' => 'blog',
			'icon' => 'tsb-post-listings',
			'class' => 'sphere-icon',
			'weight' => 1,
			'category' => esc_html_x('Home Blocks', 'Admin', 'cheerup'),
			'params' => $blog,
		));
		
		foreach ($listings as $id => $text) {
			
			if (empty($id)) {
				$id = 'loop-default';
			}
			
			$params = $blog;
			$params['type'] = array_merge($params['type'], array(
				'value' => $id,
				'type'  => 'hidden'
			));
			
			vc_map(array(
				'name' => $text,
				'description' => '',
				'base' => $id,
				'icon' => 'tsb-' . $id . '',
				'class' => 'sphere-icon',
				'weight' => 1,
				'category' => esc_html_x('Home Blocks', 'Admin', 'cheerup'),
				'params' => $params,
			));
			
		}
		
		/**
		 * Ads block
		 */
		vc_map(array(
			'name' => __('Advertisement Block', 'bunyad'),
			'description' => __('Advertisement code block.', 'bunyad'),
			'base' => 'ts_ads',
			'icon' => 'icon-wpb-wp',
			'category' => esc_html_x('Home Blocks', 'Admin', 'cheerup'),
			'weight' => 0,
			'params' => array(
				'code' => array(
					'type' => 'textarea_raw_html',
					'heading' => __('Ad Code', 'bunyad'),
					'description' => __('Enter your ad code here.', 'bunyad'),
					'param_name' => 'code',
				),
			),
		));
		
		/**
		 * Modify default Visual Composer elements to behave correctly
		 */
		
		// change weight of VC row to be highest in order
		vc_map_update('vc_row', array('weight' => 50));
		
		// Main Sidebar + sticky
		vc_add_param('vc_widget_sidebar', array(
			'type' => 'checkbox',
			'heading' => esc_html_x('Is Sidebar?', 'Admin', 'cheerup'),
			'param_name' => 'is_sidebar',
			'value' => array(
				esc_html_x('Yes', 'Admin', 'cheerup') => 1
			),
			'std' => 1
		));
		
		vc_add_param('vc_widget_sidebar', array(
			'type' => 'checkbox',
			'heading' => esc_html_x('Sticky Sidebar?', 'Admin', 'cheerup'),
			'param_name' => 'is_sticky',
			'value' => array(
				esc_html_x('Yes', 'Admin', 'cheerup') => 1
			),
			'std' => 1
		));
		
	}
	
	/**
	 * Remove unsupported elements from Visual Composer
	 */
	public function remove_unsupported()
	{	
		// Remove elements
		vc_remove_element('vc_posts_slider');
		vc_remove_element('vc_gallery');

		// Remove params
		//vc_remove_param('vc_column', 'offset');
	}
	
	/**
	 * Remove unsupported menu items
	 */
	public function remove_admin_menu()
	{
		remove_submenu_page(VC_PAGE_MAIN_SLUG, 'edit.php?post_type=' . rawurlencode( Vc_Grid_Item_Editor::postType() ), '');
	}
	
	/**
	 * Add a translated message
	 */
	public function vc_cta($translated, $text, $domain)
	{
		if ($domain !== 'js_composer') {
			return $translated;
		}
		
		if (strstr($text, 'automatic updates and unlock premium support')) {
			$translated = 'WPBakery Page Builder plugin in this theme has updates & support offered by <strong>ThemeSphere</strong>. But if you like the plugin and want automatic updates/premium support from WPBakery, please <a href="%s">buy a copy</a>.';
		}
		
		if (strstr($text, 'In order to receive all benefits of')) {
			$translated = 'WPBakery Page Builder plugin in this theme has updates & support offered by <strong>ThemeSphere</strong>. But if you like the plugin and want automatic updates/premium support & template library from WPBakery, please buy a copy and then Activate below.';
		}
			
		return $translated;
	}
	
	/**
	 * Create category drop-down via recursion on parent-child relationship
	 * 
	 * @param integer  $parent
	 * @param object   $terms
	 * @param integer  $depth
	 */
	public function _recurse_terms_array($parent, $terms, $depth = 0)
	{	
		$the_terms = array();
			
		$output = array();
		foreach ($terms as $term) {
			
			// add tab to children
			if ($term->parent == $parent) {
				$output[str_repeat(" - ", $depth) . $term->name] = $term->term_id;			
				$output = array_merge($output, $this->_recurse_terms_array($term->term_id, $terms, $depth+1));
			}
		}
		
		return $output;
	}
	
	/**
	 * Store VC Row info
	 * 
	 * @param array $atts
	 * @param string|null $content
	 */
	public function after_vc_row($atts, $content = null)
	{
		$layout = Bunyad::registry()->layout;
									
		$layout['row_open'] = false;

		// Reduce depth each time a row is closed - at depth=0 is the parent row
		$layout['row_depth']--;
		
		$row_id = $layout['row_depth'];
		
		// Inner row closed, update relative widths to the last column of currently open row
		if ($row_id) {
			$layout['col_relative_width'] = $layout[$row_id]['col_relative_width'];
		}
				
		if ($layout['row_parent_open'] && $layout['row_depth'] == 0) {
			$layout['row_parent_open'] = false;
			$layout['row_cols'] = array();
			$layout['row_depth'] = 0;
		}
				
		Bunyad::registry()->layout = $layout;
	}

	
	/**
	 * Filter callback: Change default classes for vc_row and vc_column to be 
	 * compatible with the CSS classes used in the theme. 
	 * 
	 * @param string $classes
	 * @param string $tag
	 * @param array $atts
	 */
	public function custom_classes($classes, $tag, $atts = array())
	{
		$layout = Bunyad::registry()->layout;
		
		if ($tag == 'vc_row' OR $tag == 'vc_row_inner') {
			
			// increase depth if inside a parent row
			if ($layout['row_parent_open']) {
				$layout['row_depth']++;
			}
			
			// parent row
			if ($tag == 'vc_row') {
				$layout['row_parent_open'] = true;
				$layout['row_depth']++;
			}
			
			$layout['row_open'] = true;
			Bunyad::registry()->layout = $layout;

		}
		
		// Front-end editing in process?
		if (vc_is_frontend_editor() OR vc_is_page_editable()) {
			
			if ($tag == 'vc_row' OR $tag == 'vc_row_inner') {
				$classes = str_replace('vc_row-fluid', 'ts-row blocks', $classes);
			}
		}
		else {
			// Replacemenets for rows - add block too
			if ($tag == 'vc_row' OR $tag == 'vc_row_inner') {
				$classes = trim(str_replace(array('vc_row-fluid', 'vc_row'), array('', 'ts-row blocks cf'), $classes));
			}
		}
		
		/**
		 * Change column classes and store column info
		 */
		if ($tag == 'vc_column' OR $tag == 'vc_column_inner') {
			
			/**
			 * Change the class
			 */
			preg_match('/vc_col-sm-(\d{1,2})/', $classes, $matches);
			
			// Change the class
			$classes = str_replace($matches[0], $matches[0] . ' col-' . $matches[1], $classes);
			

			/**
			 * Store current column width - relative to a parent if any
			 */

			// A row is open?
			if ($layout['row_open']) {
				
				// Set column width relative to the top-parent column - in grid format
				$layout['col_width'] = $matches[1];
				
				$row_id = $layout['row_depth'];
				
				// Column of top-level row?
				if ($layout['row_depth'] == 1) {
					
					$layout['col_relative_width'] = ($layout['col_width'] / 12);
				}
				else {
					// Column of a row_inner
					
					// Add to current row columns
					if ($layout['row_open']) {
						array_push($layout['row_cols'], $matches[1]);
					}

					
					// Calculate relative to the parent column
					$layout['col_relative_width'] = ($layout[$row_id - 1]['col_parent_width'] / 12) * ($layout['col_width'] / 12);
				}
									
				// Save top-level column width for inner rows
				$layout[$row_id]['col_parent_width']   = $layout['col_width'];
				$layout[$row_id]['col_relative_width'] = $layout['col_relative_width'];
				
				// Save layout array in registry
				Bunyad::registry()->layout = $layout;
			}
			
		}
		
		return $classes;
	}
	
	/**
	 * Load premade layouts for visual composer
	 */
	public function load_templates($data)
	{
		$templates = include locate_template('inc/vc-templates.php');
		
		return array_merge($templates, (array) $data);
	}
	
}

/**
 * Compat functions to turn VC after_ functions - for rows - into proper filters
 */

if (!function_exists('vc_theme_after_vc_row')) {
	function vc_theme_after_vc_row($atts, $content = null) {
		$content = apply_filters('vc_theme_after_vc_row', $content, $atts);
		
		if (!empty($content)) {
			return $content;
		}
	}
}

if (!function_exists('vc_theme_after_vc_row_inner')) {
	function vc_theme_after_vc_row_inner($atts, $content = null) {
		$content = apply_filters('vc_theme_after_vc_row_inner', $content, $atts);
		
		if (!empty($content)) {
			return $content;
		}
	}
}

// generic Class for Widgets mapping as VC elements
if (!class_exists('Bunyad_VC_Widget')) {
	class Bunyad_VC_Widget extends WPBakeryShortCode {}
}

// init and make available in Bunyad::get('vc')
Bunyad::register('vc', array(
	'class' => 'Bunyad_Theme_Visual_Composer',
	'init' => true
));
