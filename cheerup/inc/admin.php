<?php
/**
 * General Admin functionality - hooks, methods.
 *  
 * This file serves to be the functions.php for admin functionality. Any
 * non-specific functionality is contained here.
 * 
 * Also see admin/ folder in the root.
 *
 */
class Bunyad_Theme_Admin
{
	public function __construct()
	{
		// Set up hooks
		add_action('bunyad_theme_init', array($this, 'init'));
		
		// Educate on theme check
		add_action('themecheck_checks_loaded', array($this, 'notice_themecheck'));
		
		// Compatability warning
		if (class_exists('Endurance_Page_Cache')) {
			add_action('admin_notices', array($this, 'notice_cache'));
		}
		
		
		/**
		 * Include relevant admin files
		 */
		
		// Dashboard, importer and editor
		include get_template_directory() . '/inc/admin/dashboard.php';
		include get_template_directory() . '/inc/admin/import.php';
		include get_template_directory() . '/inc/admin/editor.php';

		// Packaged plugin updates
		include get_template_directory() . '/inc/admin/plugins-update.php';
	}
	
	public function init()
	{
		// User fields
		add_filter('user_contactmethods', array($this, 'add_profile_fields'));

		// Add image sizes to the editor
		add_filter('image_size_names_choose', array($this, 'add_image_sizes_editor'));
	}

    /**
	 * Filter callback: Add theme-specific profile fields
	 */
	public function add_profile_fields($fields)
	{
		$fields = array_merge((array) $fields, array(
			'bunyad_facebook'  => esc_html_x('Facebook URL', 'Admin', 'cheerup'),	
			'bunyad_twitter'   => esc_html_x('Twitter URL', 'Admin', 'cheerup'),
			'bunyad_gplus'     => esc_html_x('Google+ URL', 'Admin', 'cheerup'),
			'bunyad_instagram' => esc_html_x('Instagram URL', 'Admin', 'cheerup'),
			'bunyad_pinterest' => esc_html_x('Pinterest URL', 'Admin', 'cheerup'),
			'bunyad_bloglovin' => esc_html_x('BlogLovin URL', 'Admin', 'cheerup'),
			'bunyad_dribble'   => esc_html_x('Dribble URL', 'Admin', 'cheerup'),
			'bunyad_linkedin'  => esc_html_x('LinkedIn URL', 'Admin', 'cheerup'),
			'bunyad_tumblr'    => esc_html_x('Tumblr URL', 'Admin', 'cheerup'),
		));
		
		return $fields;
	}
	
	/**
	 * Filter callback: Add custom image sizes to the editor image size selection
	 * 
	 * @param array $sizes
	 */
	public function add_image_sizes_editor($sizes) 
	{
		global $_wp_additional_image_sizes;
		
		if (empty($_wp_additional_image_sizes)) {
			return $sizes;
		}

		$images = array('cheerup-main', 'cheerup-main-full', 'cheerup-grid', 'cheerup-list');
		foreach ($_wp_additional_image_sizes as $id => $data) {

			if (in_array($id, $images) && !isset($sizes[$id])) {
				$sizes[$id] = esc_html_x('Theme - ', 'Admin', 'cheerup') . ucwords(str_replace('-', ' ', $id));
			}
		}
		
		return $sizes;
	}
	
	/**
	 * Educate new users about theme check 
	 */
	public function notice_themecheck() 
	{
		if (!isset($_GET['page']) OR $_GET['page'] != 'themecheck') {
			return;
		}
		
		?>
		
		<div class="error">
			<h3>Theme Check Invalid for Premium Themes!</h3>
			<p>
			Theme Check plugin was created for WordPress.org repository to automate submission checks. Please note that theme check rules DO NOT apply to premium themes. 
			</p>
		</div>
		<?php 
	}
	
	
	/**
	 * Compatibility Issue notice
	 * 
	 * - BlueHost Endurance Cache plugin
	 */
	public function notice_cache()
	{
		$cache = get_option('mm_cache_settings');
		if (!empty($cache['page']) && $cache['page'] == 'disabled') {
			return;
		}
		
		if (!empty($_GET['page']) && strstr($_GET['page'], 'sphere-')) {
			return;
		}
		
		?>
		
		<div class="error">
			<p>
			<strong>Incompatible Plugin:</strong> Endurance Cache Plugin does not follow best practices for cache and is not recommended. 
				Please disable it now. Go to <a href="<?php echo esc_url(admin_url('options-general.php#epc_settings')); ?>">Settings > General</a>, set Cache Level to Off and Save.
				After your site is setup, consider a better cache plugin like W3 Total Cache  (<a href="http://cheerup.theme-sphere.com/documentation/#performance" target="_blank">more info</a>).
			</p> 
		</div>
		<?php 
	}
}

// init and make available in Bunyad::get('admin')
Bunyad::register('admin', array(
	'class' => 'Bunyad_Theme_Admin',
	'init' => true
));