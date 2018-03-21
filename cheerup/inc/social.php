<?php
/**
 * Functions relating to the social functionality.
 */
class Bunyad_Theme_Social
{	
	
	public function __construct() 
	{
		add_filter('sphere_social_follow_options', array($this, 'follow_options'));
		add_filter('sphere_theme_docs_url', array($this, 'docs_url'));
	}
	
	/**
	 * Filter: Modify default customizer options for social follow
	 * 
	 * @see Sphere_Plugin_SocialFollow::add_theme_options()
	 */
	public function follow_options($options)
	{
		$options['title'] = esc_html_x('Social Counters', 'Admin', 'cheerup');
		$options['desc']  = sprintf(
			'Note: These settings are for Social Follow widget. For normal social settings, go to %sGeneral Settings%s',
			'<a href="#" class="focus-link" data-section="general-social">', '</a>'
		);
		$options['sections']['general']['fields']['sf_counters']['value'] = 0;
	
		// Change default labels
		$labels = $this->get_services();
		foreach (array_keys($options['sections']) as $id) {
			
			if (!array_key_exists($id, $labels)) {
				continue;
			}
			
			$options['sections'][$id]['fields']["sf_{$id}_label"]['value'] = $labels[$id]['label'];
		}
		
		return $options;
	}
	
	public function docs_url($url) {
		return 'http://cheerup.theme-sphere.com/documentation/';
	}
	
	/**
	 * Get an array of services supported at different locations
	 * such as Top bar social icons.
	 */
	public function get_services()
	{
		$services = array(
			'facebook' => array(
				'icon' => 'facebook',
				'label' => esc_html__('Facebook', 'cheerup')
			),
			
			'twitter' => array(
				'icon' => 'twitter',
				'label' => esc_html__('Twitter', 'cheerup')
			),
			
			'instagram' => array(
				'icon' => 'instagram',
				'label' => esc_html__('Instagram', 'cheerup')
			),
			
			'pinterest' => array(
				'icon' => 'pinterest-p',
				'label' => esc_html__('Pinterest', 'cheerup')
			),
			
			'bloglovin' => array(
				'icon' => 'heart',
				'label' => esc_html__('BlogLovin', 'cheerup')
			),
			
			'rss' => array(
				'icon' => 'rss',
				'label' => esc_html__('RSS', 'cheerup')
			),
			
			'gplus' => array(
				'icon' => 'google-plus',
				'label' => esc_html__('Google Plus', 'cheerup')
			),
			
			'youtube' => array(
				'icon' => 'youtube',
				'label' => esc_html__('YouTube', 'cheerup')
			),
			
			'dribbble' => array(
				'icon' => 'dribbble',
				'label' => esc_html__('Dribbble', 'cheerup')
			),
			
			'tumblr' => array(
				'icon' => 'tumblr',
				'label' => esc_html__('Tumblr', 'cheerup')
			),
			
			'linkedin' => array(
				'icon' => 'linkedin',
				'label' => esc_html__('LinkedIn', 'cheerup')
			),
			
			'flickr' => array(
				'icon' => 'flickr',
				'label' => esc_html__('Flickr', 'cheerup')
			),
			
			'soundcloud' => array(
				'icon' => 'soundcloud',
				'label' => esc_html__('SoundCloud', 'cheerup')
			),
			
			'vimeo' => array(
				'icon' => 'vimeo',
				'label' => esc_html__('Vimeo', 'cheerup')
			),
				
			'lastfm' => array(
				'icon' => 'lastfm',
				'label' => esc_html__('Last.fm', 'cheerup')
			),
				
			'steam' => array(
				'icon' => 'steam',
				'label' => esc_html__('Steam', 'cheerup')
			),
				
			'vk' => array(
				'icon' => 'vk',
				'label' => esc_html__('VKontakte', 'cheerup')
			),
		);
		
		return apply_filters('bunyad_social_services', $services);
	}
	
	/**
	 * Get an array of sharing services with links
	 */
	public function share_services($post_id = '') 
	{
		if (empty($post_id)) {
			$post_id = get_the_ID();
		}
		
		// Post and media URL
		$url   = urlencode(get_permalink($post_id));
		$media = urlencode(wp_get_attachment_url(get_post_thumbnail_id($post_id)));
		$title = get_the_title($post_id);
		
		// Social Services
		$services = array(
			'facebook' => array(
				'label' => __('Share on Facebook', 'cheerup'),
				'icon'  => 'facebook',
				'url'   => 'http://www.facebook.com/sharer.php?u=' . $url,
			),
				
			'twitter' => array(
				'label' => __('Share on Twitter', 'cheerup'), 
				'icon'  => 'twitter',
				'url'   => 'http://twitter.com/home?status=' . $url,
			),
				
			'gplus' => array(
				'label' => __('Google+', 'cheerup'), 
				'icon'  => 'google-plus',
				'url'   => 'http://plus.google.com/share?url=' . $url,
			),
				
			'pinterest' => array(
				'label' => __('Pinterest', 'cheerup'), 
				'icon'  => 'pinterest',
				'url'   => 'http://pinterest.com/pin/create/button/?url='. $url . '&media=' . $media,
				'key'   => 'sf_instagram_id',
			),
			
			'linkedin' => array(
				'label' => __('LinkedIn', 'cheerup'), 
				'icon'  => 'linkedin',
				'url'   => 'http://www.linkedin.com/shareArticle?mini=true&url=' . $url,
			),
				
			'tumblr' => array(
				'label' => __('Tumblr', 'cheerup'), 
				'icon'  => 'tumblr',
				'url'   => 'http://www.tumblr.com/share/link?url=' . $url . '&name=' . urlencode($title),
			),
				
			'email' => array(
				'label' => __('Email', 'cheerup'), 
				'icon'  => 'envelope-o',
				'url'   => 'mailto:?subject='. rawurlencode($title) .'&body=' . $url,
			),
		);
		
		return $services;
	}
}

// init and make available in Bunyad::get('social')
Bunyad::register('social', array(
	'class' => 'Bunyad_Theme_Social',
	'init' => true
));