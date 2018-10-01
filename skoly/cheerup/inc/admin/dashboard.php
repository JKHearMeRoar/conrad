<?php
/**
 * Setup Theme Panel for admin
 */
class Bunyad_Theme_Admin_Dashboard
{
	public function __construct()
	{
		add_action('admin_menu', array($this, 'menu'), 10);
		add_action('admin_menu', array($this, 'menu_legacy'), 11);
		
		// Welcome screen on activate
		add_action('admin_init', array($this, 'redirect_welcome'));
		add_action('admin_init', array($this, 'redirect_actions'));
		
		// License info
		add_action('admin_notices', array($this, 'admin_notice_license'));		
	}
	
	/**
	 * Setup the menu
	 */
	public function menu()
	{
		global $submenu;
		
		// Main section
		add_menu_page('CheerUp', 'CheerUp', 'manage_options', 'sphere-dash', array($this, 'dash_welcome'), 'dashicons-admin-customizer', 2);	
		add_submenu_page('sphere-dash', 'Welcome', 'Welcome', 'manage_options', 'sphere-dash');
		
		add_submenu_page('sphere-dash', 'Customize', 'Customize', 'manage_options', 'sphere-dash-customize', array($this, 'dash_customize'));
		add_submenu_page('sphere-dash', 'Import Demos', 'Import Demos', 'manage_options', 'sphere-dash-demos', array($this, 'dash_demos'));
		add_submenu_page('sphere-dash', 'Help & Support', 'Help & Support', 'manage_options', 'sphere-dash-support', array($this, 'dash_support'));
		
		// Hidden activation callback
		add_submenu_page(null, 'Activate', 'Activate', 'manage_options', 'sphere-dash-activate', array($this, 'dash_activate'));
		
	}
	
	/**
	 * Legacy/Compat menu links
	 */
	public function menu_legacy() 
	{
		// Legacy: Show Install plugins in Appearance too
		$tgmpa = TGM_Plugin_Activation::get_instance();
		if (!empty($tgmpa->page_hook)) {
			add_theme_page('Install Plugins','Install Plugins', 'manage_options', 'sphere-plugins-redirect', array($this, 'dash_plugins'));
		}
	}
	
	/**
	 * Redirect to welcome screen on activate
	 */
	public function redirect_welcome()
	{
		global $pagenow;
		
		if (isset($_GET['activated']) && $pagenow == 'themes.php') {
			
			wp_safe_redirect(
				add_query_arg('page', 'sphere-dash', admin_url('admin.php'))
			);
			
			exit;
		}
	}
	
	/**
	 * Redirection for some aliases
	 */
	public function redirect_actions()
	{
		global $pagenow;
		
		if (empty($_GET['page']) OR !in_array($pagenow, array('themes.php', 'admin.php'))) {
			return;
		}
		
		switch ($_GET['page']) {
		
			case 'sphere-dash-demos': 
				return $this->dash_demos(true);
				
			case 'sphere-plugins-redirect':
				return $this->dash_plugins();
				
			case 'sphere-dash-customize':
				return $this->dash_customize();
		}
	}
	
	/**
	 * Activation message
	 */
	public function admin_notice_license()
	{
		if (Bunyad::core()->get_license()) {
			return;
		}
		
		if (!empty($_GET['page']) && strstr($_GET['page'], 'sphere-')) {
			return;
		}
		
		?>
		
		<div class="error">
			<p><strong>Theme Activation:</strong> Please <a href="<?php echo esc_url(admin_url('admin.php?page=sphere-dash')); ?>">activate the theme</a> to create your 
			support account, validate your site, and to be notified of security updates.</p> 
		</div>
		<?php 
	}
	
	/**
	 * Dash View: Welcome
	 */
	public function dash_welcome()
	{
		$this->get_tab_view('welcome');
	}
	
	/**
	 * Dash View: Support
	 */
	public function dash_support()
	{
		$this->get_tab_view('support');
	}
	
	
	public function get_tab_view($tab, $data = array())
	{
		extract($data);
		include locate_template('inc/admin/views/dash-layout.php');
	}
	
	
	/**
	 * Redirect to customize
	 */
	public function dash_customize()
	{
		ob_clean();
		wp_safe_redirect(admin_url('customize.php'));
		exit;
	}
	
	/**
	 * Redirect to customize
	 */
	public function dash_plugins()
	{
		ob_clean();
		wp_safe_redirect(admin_url('admin.php?page=tgmpa-install-plugins'));
		exit;
	}
	
	/**
	 * Redirect to import
	 */
	public function dash_demos($early = false)
	{
		// If importer plugin not installed, ask to activate
		if (!class_exists('Bunyad_Demo_Import')) {
			if ($early != true) {
				esc_html_e('The Bunyad Demo Import plugin is not installed. Please activate it from Appearance > Install Plugins.', 'cheerup-admin');
			}
			
			return;
		}
		
		ob_clean();
		wp_safe_redirect(admin_url('themes.php?page=bunyad-demo-import'));
		exit;		
	}
	
	/**
	 * Activate theme 
	 */
	public function dash_activate()
	{
		
		// Returning from activation
		if (!empty($_GET['code'])) {
			$data = json_decode(base64_decode($_GET['code']), true);

			if (!empty($data['key'])) {
				$activated = $this->_check_activate($data['key']);
				
				if (!$activated) {
					$error = true;
				}
			}
		}

		$this->get_tab_view('welcome', compact('activated', 'data', 'error'));
		
		// IMPORTANT: Update AFTER rendering view as license gets set immediately
		if ($activated) {
			update_option(Bunyad::options()->get_config('theme_name') . '_license', $data['key']);
		}
	}
	
	/**
	 * Check if API key is valid
	 *  
	 * @param array $key
	 */
	public function _check_activate($key)
	{				
		// Verify from system
		$resp = wp_remote_post(
			'https://system.theme-sphere.com/wp-json/api/v1/verify-key', 
			array(
				'headers' => array('X-API-KEY' => $key)
			)
		);
		
		if (is_wp_error($resp)) {
			return 0;
		}
		
		$resp = json_decode($resp['body'], true);
		if (!empty($resp['valid'])) {
			return true;
		}
		
		return false;
	}
}


// init and make available in Bunyad::get('admin_dashboard')
Bunyad::register('admin_dashboard', array(
	'class' => 'Bunyad_Theme_Admin_Dashboard',
	'init'  => true
));