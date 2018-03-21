<?php
/**
 * Demo Importer - Requires Bunyad Demo Import plugin
 * 
 * @see Bunyad_Demo_Import
 */
class Bunyad_Theme_Admin_Import
{
	public $demos = array();
	public $admin_page;
	public $importer;
	
	public function __construct()
	{
		
		add_filter('bunyad_import_demos', array($this, 'import_source'));
		add_filter('pt-ocdi/importer_options', array($this, 'importer_options'));
		add_action('tgmpa_register', array($this, 'register_plugins'));
		
		// Demo configs
		$this->demos = array(
			'miranda' => array(
				'demo_name'             => "Miranda/Life",
				'demo_description'      => 'Miranda CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/miranda/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/miranda.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/miranda.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/miranda-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/miranda-customizer.dat',
			),

			'fashion' => array(
				'demo_name'             => "Fashion",
				'demo_description'      => 'Fashion CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/fashion/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/fashion.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/fashion.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/fashion-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/fashion-customizer.dat',
			),
				
			'bold' => array(
				'demo_name'             => "Bold Blog",
				'demo_description'      => 'Bold Blog CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/bold/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/bold.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/bold.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/bold-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/bold-customizer.dat',
			),
			
			'rovella' => array(
				'demo_name'             => "Rovella",
				'demo_description'      => 'Rovella CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/rovella/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/rovella.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/rovella.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/rovella-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/rovella-customizer.dat',
			),
				
			'general' => array(
				'demo_name'             => "General",
				'demo_description'      => 'General Purpose CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/general.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/general.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/general-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/general-customizer.dat',
			),
				
			'magazine' => array(
				'demo_name'             => "Magazine",
				'demo_description'      => 'Magazine CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/magazine/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/magazine.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/magazine.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/magazine-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/magazine-customizer.dat',
			),

			'beauty' => array(
				'demo_name'             => "Beauty",
				'demo_description'      => 'Beauty CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/beauty/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/beauty.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/beauty.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/beauty-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/beauty-customizer.dat',
			),
				
			'trendy' => array(
				'demo_name'             => "Trendy",
				'demo_description'      => 'Trendy CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/trendy/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/trendy.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/trendy.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/trendy-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/trendy-customizer.dat',
			),

			'fitness' => array(
				'demo_name'             => "Fitness",
				'demo_description'      => 'Fitness CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/fitness/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/fitness.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/fitness.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/fitness-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/fitness-customizer.dat',
			),

			'mom' => array(
				'demo_name'             => "Mom/Parents",
				'demo_description'      => 'Mom / Parenting Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/mom/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/mom.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/mom.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/mom-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/mom-customizer.dat',
			),
				
			'travel' => array(
				'demo_name'             => "Travel",
				'demo_description'      => 'Travel CheerUp Demo.',
				'demo_url'              => 'https://cheerup.theme-sphere.com/travel/',
				'demo_image'			=> get_template_directory_uri() . '/inc/demos/travel.jpg',
				'local_import_file'            => get_template_directory() . '/inc/demos/travel.xml',
				'local_import_widget_file'     => get_template_directory() . '/inc/demos/travel-widgets.json',
				'local_import_customizer_file' => get_template_directory() . '/inc/demos/travel-customizer.dat',
			),

		);
		
		// Disable thumbnail creation to be done at the end
		add_filter('pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false');
		add_action('bunyad_import_done', array($this, 'post_import'), 10, 2);
		
		// Register an informational section on customizer
		add_action('customize_register', array($this, 'customizer_info'), 12);
	}

	public function import_source() {
		return $this->demos;
	}
	
	public function importer_options($options) {
		//$options['aggressive_url_search'] = true;
		return $options;
	}
	
	/**
	 * Register a few extra plugins with TGMPA
	 */
	public function register_plugins()
	{	
		tgmpa(array(
			array(
				'name'     => esc_html_x('Bunyad Demo Import', 'Admin', 'cheerup'),
				'slug'     => 'bunyad-demo-import',
				'required' => false,
				'source'   => get_template_directory() . '/lib/vendor/plugins/bunyad-demo-import.zip', // The plugin source
			),
		
			array(
				'name'     => esc_html_x('Regenerate Thumbnails', 'Admin', 'cheerup'),
				'slug'     => 'regenerate-thumbnails',
				'required' => false,
				'force_activation' => (!empty($_GET['importer']) ? true : false)  // auto activate when user clicks install & activate button from importer
			),
		), array('is_automatic' => true));
	}
	
	/**
	 * Post-import
	 * 
	 * @param string $demo_id
	 * @param OCDI_WXR_Importer $import
	 */
	public function post_import($demo_id, $import)
	{
		// Set main menu
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		
		set_theme_mod('nav_menu_locations', array(
			'cheerup-main' => $main_menu->term_id
		));
		
		// General demo changes
		if ($demo_id == 'general') {
			// Reinit options as they're stale after import
			Bunyad::options()->init();
			
			// Change predefined style
			Bunyad::options()->update('predefined_style', '');
		}
		
		// For magazine, we set homepage from imported content
		if ($demo_id == 'magazine') {
			
			$home = get_page_by_title('Homepage');

			if (is_object($home)) {
				update_option('show_on_front', 'page');
				update_option('page_on_front', $home->ID);
				
				
				// Visual Composer home changes
				$this->post_process_vc($home->ID, $import);
			}
		}
		
	}
	
	/**
	 * Remap Visual Composer block categories
	 * 
	 * @param integer  $page_id
	 * @param OCDI_WXR_Importer $import
	 */
	public function post_process_vc($page_id, $import) 
	{
		$import_data = $import->get_importer_data();
		$mapping     = $import_data['mapping'];
		
		// Get page content
		$page = get_page($page_id);
		$content = $page->post_content;
		
		// Find all instances of cat="1" and replace as necessary
		preg_match_all('/cat="(\d+)"/', $content, $match);
		foreach ($match[1] as $key => $cat) {
			$new_id = $mapping['term_id'][$cat];
			
			if (empty($new_id)) {
				continue;
			}
			
			$content = str_replace($match[0][$key], 'cat="'. $new_id .'"', $content);
		}
		
		// Update the home
		wp_update_post(array(
			'ID' => $page_id,
			'post_content' => $content
		));
	}
	
	/**
	 * Customizer information
	 */
	public function customizer_info($wp_customizer)
	{
				
		/* @var $wp_customizer WP_Customize_Manager */
		$control = $wp_customizer->get_control('import_info');
		
		// Plugin active
		if (class_exists('Bunyad_Demo_Import')) {
			$control->text = sprintf(
				esc_html_x('You can import demo settings or full demo content from %1$s this page %2$s.', 'Admin', 'cheerup'), 
				'<a href="' . esc_url(admin_url('themes.php?page=bunyad-demo-import')) .'">',
				'</a>'
			);
			
			return;
		}
		
		// Prompt for plugin activation
		$control->text = sprintf(
			esc_html_x('Please install and activate the required plugin "Bunyad Demo Import" from %1$sthis page%2$s.', 'Admin', 'cheerup'), 
			'<a href="' . esc_url(admin_url('themes.php?page=tgmpa-install-plugins')) .'">',
			'</a>'
		);
	}
		
}


// init and make available in Bunyad::get('admin_import')
Bunyad::register('admin_import', array(
	'class' => 'Bunyad_Theme_Admin_Import',
	'init' => true
));