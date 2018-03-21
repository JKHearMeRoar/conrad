<?php
/**
 * Theme Settings - All the relevant options!
 * 
 * @see Bunyad_Options
 * @see Bunyad_Theme_Customizer
 */


$info = <<<EOF
	
	<p>To get up and running with the theme, start with <a href="http://cheerup.theme-sphere.com/documentation/" target="_blank">theme documentation</a>.</p>
	
	<p>Resources:</p>
	<ul>
		<li>- <a href="http://cheerup.theme-sphere.com/documentation/" target="_blank">Documentation</a></li>
		<li>- <a href="http://theme-sphere.com" target="_blank">Theme Support</a></li>
		<li>- <a href="http://theme-sphere.com/feedback/" target="_blank">Suggestions & Feedback?</a> (We want to know if your experience has been pleasant)</li>
	</ul>
	
EOF;

return apply_filters('bunyad_theme_options', array(

	array(
		'sections' => array(
			array(
				'id' => 'welcome',
				'title'  => esc_html_x('Theme Intro & Help', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => '',
						'type' => 'content',
						'text' => $info
					),
				) // fields
				
			) // section
			
		) // sections
		
	), // pseudo panel
	
	array(
		'sections' => array(
			array(
				'id' => 'select-skin',
				'title'  => esc_html_x('Change Skin', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'predefined_style',
						'label'   => esc_html_x('Select the Skin', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => esc_html_x('NOTE: Changing from or to Magazine skin REQUIRES installing Regenerate Thumbnails plugin and running it from Tools > Regen. Thumbnails.', 'Admin', 'cheerup'),
						'type'    => 'radio',
						'options' => array(
							'' => esc_html_x('General', 'Admin', 'cheerup'),
							'beauty'  => esc_html_x('Beauty', 'Admin', 'cheerup'),
							'trendy'  => esc_html_x('Trendy', 'Admin', 'cheerup'),
							'miranda' => esc_html_x('Miranda / Lifestyle', 'Admin', 'cheerup'),
							'rovella' => esc_html_x('Rovella', 'Admin', 'cheerup'),
							'travel'  => esc_html_x('Travel', 'Admin', 'cheerup'),
							'magazine' => esc_html_x('Magazine', 'Admin', 'cheerup'),
							'bold'    => esc_html_x('Bold Blog', 'Admin', 'cheerup'),
							'fashion' => esc_html_x('Fashion', 'Admin', 'cheerup'),
							'mom'     => esc_html_x('Mom / Parents', 'Admin', 'cheerup'),
							'fitness' => esc_html_x('Fitness', 'Admin', 'cheerup'),
						),
					),
				) // fields
				
			) // section
			
		) // sections
		
	), // pseudo panel
	
	array(
		'title' => esc_html_x('Homepage', 'Admin', 'cheerup'),
		'id'    => 'options-homepage',
		'sections' => array(
				
			array(
				'id' => 'home-layout',
				'title'  => esc_html_x('Home Layout', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'home_layout',
						'label'   => esc_html_x('Home Layout', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'radio',
						'options' => array(
							'' => esc_html_x('Classic Large Posts', 'Admin', 'cheerup'),
							'assorted' => esc_html_x('Assorted - (Large Post + Sidebar, Shop, Grid + Sidebar)', 'Admin', 'cheerup'),
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
						),
					),
						
					array(
						'name'  => 'home_grid_large_info',
						'label' => esc_html_x('Grid / Large Post Style | Pagination', 'Admin', 'cheerup'),
						'type'  => 'content',
						'text'  => sprintf(
							esc_html_x('There are multiple Grid Posts, Large Posts, and Pagination styles available. Make your choice by going back and to %1$sPosts & Listings > Post Listings%2$s.', 'Admin', 'cheerup'),
							'<a href="#" class="focus-link" data-section="posts-listings">', '</a>'
						)
					),
					
					array(
						'name' => 'home_sidebar',
						'label'   => esc_html_x('Home Sidebar', 'Admin', 'cheerup'),
						'value'   => 'right',
						'desc'    => '',
						'type'    => 'radio',
						'options' => array(
							'none'  => esc_html_x('No Sidebar', 'Admin', 'cheerup'),
							'right' => esc_html_x('Right Sidebar', 'Admin', 'cheerup') 
						),
					),
						
					array(
						'name'  => 'home_posts_limit',
						'label' => esc_html_x('Number of Posts', 'Admin', 'cheerup'),
						'value' => get_option('posts_per_page'),
						'desc'  => esc_html_x('When you wish to use different posts per page from global setting in Settings > Reading which applies to all archives too.', 'Admin', 'cheerup'),
						'type'  => 'number'
					),
					
				), // fields
				
			), // section
			
			array(
				'id' => 'home-slider',
				'title' => esc_html_x('Home Slider', 'Admin', 'cheerup'),
				'fields' => array(
					array(
						'name' => 'home_slider',
						'label'   => esc_html_x('Slider on Home', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							''        => esc_html_x('Disabled', 'Admin', 'cheerup'),
							'stylish' => esc_html_x('Stylish (3 images)', 'Admin', 'cheerup'),
							'default' => esc_html_x('Classic Slider (3 Images)', 'Admin', 'cheerup'),
							'beauty'  => esc_html_x('Beauty (Single Image)', 'Admin', 'cheerup'),
							'fashion' => esc_html_x('Fashion (Single Image)', 'Admin', 'cheerup'),
							'trendy'  => esc_html_x('Trendy (2 Images)', 'Admin', 'cheerup'),
							'large'   => esc_html_x('Large Full Width', 'Admin', 'cheerup'),
							'grid'    => esc_html_x('Grid (1 Large + 2 small)', 'Admin', 'cheerup'),
							'grid-tall' => esc_html_x('Tall Grid (1 Large + 2 small)', 'Admin', 'cheerup'),
							'carousel'  => esc_html_x('Carousel (3 Small Posts)', 'Admin', 'cheerup'),
							'bold'    => esc_html_x('Bold Full Width', 'Admin', 'cheerup'),
						),
					),
					
					
					array(
						'name' => 'slider_posts',
						'label'   => esc_html_x('Slider Post Count', 'Admin', 'cheerup'),
						'value'   => 6,
						'desc'    => esc_html_x('Total number of posts for slider.', 'Admin', 'cheerup'),
						'type'    => 'number',
					),
					
					array(
						'name' => 'slider_tag',
						'label'   => esc_html_x('Slider Posts Tag', 'Admin', 'cheerup'),
						'value'   => 'featured',
						'desc'    => esc_html_x('Posts with this tag will be shown in the slider. Leaving it empty will show latest posts.', 'Admin', 'cheerup'),
						'type'    => 'text',
					),
						
					array(
						'name' => 'slider_post_ids',
						'label'   => esc_html_x('Slider Post IDs', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => esc_html_x('Advance Usage: Enter post ids separated by comma you wish to show in the slider, in order you wish to show them in. Example: 11, 105, 2', 'Admin', 'cheerup'),
						'type'    => 'text',
					),
						
					array(
						'name'    => 'slider_parallax',
						'label'   => esc_html_x('Enable Parallax Effect?', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => '',
						'type'    => 'checkbox',
					),
					
					array(
						'name'    => 'slider_autoplay',
						'label'   => esc_html_x('Slider Autoplay', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => '',
						'type'    => 'checkbox',
					),
					
					array(
						'name'    => 'slider_animation',
						'label'   => esc_html_x('Slider Animation', 'Admin', 'cheerup'),
						'value'   => 'fade',
						'desc'    => '',
						'type'    => 'radio',
						'options' => array(
							'fade'  => esc_html_x('Fade Animation', 'Admin', 'cheerup'),
							'slide' => esc_html_x('Slide Animation', 'Admin', 'cheerup'),
						),
						'context' => array('control' => array('key' => 'home_slider', 'value' => array('beauty', 'fashion', 'large', 'bold')))
					),
					
					array(
						'name'    => 'slider_delay',
						'label'   => esc_html_x('Slide Autoplay Delay', 'Admin', 'cheerup'),
						'value'   => 5000,
						'desc'    => '',
						'type'    => 'number',
						'input_attrs' => array('min' => 500, 'max' => 50000, 'step' => 500),
					),
						
				), // fields
			), // section

			
			array(
				'id' => 'home-carousel',
				'title' => esc_html_x('Home Carousel', 'Admin', 'cheerup'),
				'fields' => array(
					
					array(
						'name' => 'home_carousel',
						'label'   => esc_html_x('Enable Posts Carousel On Home', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('Will show a posts carousel below main slider.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'home_carousel_style',
						'label'   => esc_html_x('Carousel Style', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							'' => esc_html_x('Default - 4 Images', 'Admin', 'cheerup'),
							'style-b'   => esc_html_x('Style B - 3 Images and Boxed', 'Admin', 'cheerup'),
						),
					),
					
					array(
						'name' => 'home_carousel_posts',
						'label'   => esc_html_x('Home Carousel Posts', 'Admin', 'cheerup'),
						'value'   => 8,
						'desc'    => '',
						'type'    => 'number',
					),
					
					array(
						'name' => 'home_carousel_title',
						'label'   => esc_html_x('Home Carousel Title', 'Admin', 'cheerup'),
						'value'   => esc_html__('Most Popular', 'cheerup'),
						'desc'    => '',
						'type'    => 'text',
					),
					
					array(
						'name' => 'home_carousel_type',
						'label'   => esc_html_x('Home Carousel Type', 'Admin', 'cheerup'),
						'value'   => 'posts',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							'liked' => esc_html_x('Most Liked', 'Admin', 'cheerup'),
							'posts'   => esc_html_x('Latest / By Tag', 'Admin', 'cheerup'),
						),
					),
					
					array(
						'name' => 'home_carousel_tag',
						'label'   => esc_html_x('Home Carousel Tag - Optional', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'text',
						'content' => array('control' => array('key' => 'home_carousel_type', 'value' => 'posts'))
					),

					array(
						'name' => 'home_carousel_sep',
						'label'   => esc_html_x('Add Separator Below?', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
						'content' => array('control' => array('key' => 'home_carousel_style', 'value' => ''))
					),
						
				), // fields
			), // section
			
				
				
			array(
				'id' => 'home-subscribe',
				'title' => esc_html_x('Home Subscribe', 'Admin', 'cheerup'),
				'desc'  => 
					sprintf(
						esc_html_x('Enable a Mailchimp subscribe box below the slider on home. IMPORTANT: Setup your form first by following %sthis guide%s.', 'Admin', 'cheerup'),
						'<a href="http://cheerup.theme-sphere.com/documentation/#widget-subscribe" target="_blank">', '</a>'
					),
				'fields' => array(
					array(
						'name'  => 'home_subscribe',
						'label' => esc_html_x('Enable Subscribe Box?', 'Admin', 'cheerup'),
						'value' => 0,
						'desc' => '',
						'type'  => 'checkbox',
					),
						
					array(
						'name' => 'home_subscribe_url',
						'label' => esc_html_x('Mailchimp Form URL', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text',
					),
						
					array(
						'name' => 'home_subscribe_label',
						'label' => esc_html_x('Subscribe Message', 'Admin', 'cheerup'),
						'value' => esc_html__('Subscribe to my newsletter to get updates in your inbox!', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),

					array(
						'name' => 'home_subscribe_btn_label',
						'label' => esc_html_x('Button Label', 'Admin', 'cheerup'),
						'value' => esc_html__('Subscribe Now', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
						
				)
			), // section
					
			
				
		) // sections
	), // panel

			
	array(
		'title' => esc_html_x('Header/Logo & Nav', 'Admin', 'cheerup'),
		'id'    => 'sphere-header',
		'sections' => array(
			array(
				'id' => 'header-topbar',
				'title'  => esc_html_x('General & Top Bar', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'header_layout',
						'label'   => esc_html_x('Header Layout Style', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							'' => esc_html_x('Style 1: Default', 'Admin', 'cheerup'),
							'nav-below' => esc_html_x('Style 2: Nav Below Logo', 'Admin', 'cheerup'),
							'full-top'  => esc_html_x('Style 3: Full-width Top', 'Admin', 'cheerup'),
							'logo-ad'   => esc_html_x('Style 4: Logo Left + Ad', 'Admin', 'cheerup'),
							'nav-below-b' => esc_html_x('Style 5: Special Topbar + Nav Below Logo', 'Admin', 'cheerup'),
							'alt' => esc_html_x('Style 6: Default + Social Icons + Search Icon', 'Admin', 'cheerup'),
							'top-below' => esc_html_x('Style 7: Nav Below Logo with Social Icons', 'Admin', 'cheerup'),
							'compact' => esc_html_x('Style 8: Topbar + Logo & Nav (Compact)', 'Admin', 'cheerup'),
							'simple' => esc_html_x('Style 9: Logo + Nav + Icons (Full-width)', 'Admin', 'cheerup'),
						),
					),
					
					array(
						'name' => 'header_ad',
						'label'   => esc_html_x('Header Ad Code', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'textarea',
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('logo-ad', 'compact'))),
						'sanitize_callback' => ''
					),
	
					array(
						'name' => 'css_header_bg_image',
						'label'   => esc_html_x('Header Background', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'upload',
						'options' => array('type' => 'image'),
						'bg_type' => array('value' => 'no-repeat'),
						'css' => array(
							'selectors' => array(
								'.main-head .logo-wrap' => 'background-image: url(%s); background-position: top center;'
							),
						),
					),
						
					array(
						'name' => 'css_header_bg_full',
						'label'   => esc_html_x('Header Background Full Width', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'upload',
						'options' => array('type' => 'image'),
						'bg_type' => array('value' => 'cover-nonfixed'),
						'css' => array(
							'selectors' => array(
								'.main-head > .inner' => 'background-image: url(%s); background-position: top center;'
							),
						),
					),

					array(
						'name' => 'topbar_style',
						'label'   => esc_html_x('Topbar Style', 'Admin', 'cheerup'),
						'value'   => 'light',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							'light' => esc_html_x('Light', 'Admin', 'cheerup'),
							'dark'  => esc_html_x('Dark / Contrast', 'Admin', 'cheerup')
						),
							
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('simple'), 'compare' => '!=')),
					),
						
					array(
						'name' => 'nav_style',
						'label'   => esc_html_x('Navigation Style', 'Admin', 'cheerup'),
						'value'   => 'light',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							'light' => esc_html_x('Light', 'Admin', 'cheerup'),
							'dark'  => esc_html_x('Dark', 'Admin', 'cheerup')
						),
							
						// Only show this setting if header_layout is nav_below type
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('nav-below', 'nav-below-b'))),
					),
						
					array(
						'name' => 'topbar_ticker_text',
						'label'   => esc_html_x('Topbar Latest Posts Label', 'Admin', 'cheerup'),
						'value'   => 'Latest Posts:',
						'desc'    => '',
						'type'    => 'text',
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('nav-below-b', 'compact'))),
					),
						
					array(
						'name' => 'topbar_top_menu',
						'label'   => esc_html_x('Enable Topbar Navigation', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('Enabling this will disable topbar latest posts.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('nav-below-b', 'compact'))),
					),

					array(
						'name' => 'topbar_search',
						'label'   => esc_html_x('Show Search', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),
						

					array(
						'name' => 'topbar_cart',
						'label'   => esc_html_x('Shopping Cart Icon', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Only works when WooCommerce is installed.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
					
					array(
						'name' => 'topbar_sticky',
						'label'   => esc_html_x('Sticky Top Bar/Navigation', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Make topbar or navigation sticky on scrolling.', 'Admin', 'cheerup'),
						'type'    => 'select',
						'options' => array(
							'' => esc_html_x('Disabled', 'Admin', 'cheerup'),
							1 => esc_html_x('Enabled - Normal', 'Admin', 'cheerup'),
							'smart' => esc_html_x('Enabled - Smart (Show when scrolling to top)', 'Admin', 'cheerup'),
						)
					),

					array(
						'label'   => esc_html_x('Top Bar Social Icons', 'Admin', 'cheerup'),
						'name'    => 'topbar_social',
						'value'   => array('facebook', 'twitter', 'instagram'),
						'desc'    => esc_html_x('NOTE: Configure these icons URLs from General Settings > Social Media.', 'Admin', 'cheerup'),
						'type'    => 'checkboxes',
					
						// Show only if header layout is default
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('nav-below', 'full-top', 'nav-below-b', 'alt', 'top-below', 'compact', 'simple'))),
						'options' => array(
							'facebook'  => esc_html_x('Facebook', 'Admin', 'cheerup'),
							'twitter'   => esc_html_x('Twitter', 'Admin', 'cheerup'),
							'gplus'     => esc_html_x('Google Plus', 'Admin', 'cheerup'),
							'instagram' => esc_html_x('Instagram', 'Admin', 'cheerup'),
							'pinterest' => esc_html_x('Pinterest', 'Admin', 'cheerup'),
							'vimeo'     => esc_html_x('Vimeo', 'Admin', 'cheerup'),
							'bloglovin' => esc_html_x('BlogLovin', 'Admin', 'cheerup'),
							'rss'       => esc_html_x('RSS', 'Admin', 'cheerup'),
							'youtube'   => esc_html_x('Youtube', 'Admin', 'cheerup'),
							'dribbble'  => esc_html_x('Dribbble', 'Admin', 'cheerup'),
							'tumblr'    => esc_html_x('Tumblr', 'Admin', 'cheerup'),
							'linkedin'  => esc_html_x('LinkedIn', 'Admin', 'cheerup'),
							'flickr'    => esc_html_x('Flickr', 'Admin', 'cheerup'),
							'soundcloud' => esc_html_x('SoundCloud', 'Admin', 'cheerup'),
							'lastfm'     => esc_html_x('Last.fm', 'Admin', 'cheerup'),
							'vk'         => esc_html_x('VKontakte', 'Admin', 'cheerup'),
							'steam'      => esc_html_x('Steam', 'Admin', 'cheerup'),
								
						),
					),
					
				), // fields
			
			), // section
			
			array(
				'id' => 'header-logo',
				'title'  => esc_html_x('Logos', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'    => 'image_logo',
						'value'   => '',
						'label'   => esc_html_x('Logo Image', 'Admin', 'cheerup'),
						'desc'    => esc_html_x('Highly recommended to use a logo image in PNG format.', 'Admin', 'cheerup'),
						'type'    => 'upload',
						'options' => array(
							'type'  => 'image',
						),
					),
					
					array(
						'name'    => 'image_logo_2x',
						'label'   => esc_html_x('Logo Image Retina (2x)', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => esc_html_x('This will be used for higher resolution devices like iPhone/Macbook.', 'Admin', 'cheerup'),
						'type'    => 'upload',
						'options' => array(
							'type'  => 'image',
						),
					),
					
					array(
						'name'    => 'mobile_logo_2x',
						'value'   => '',
						'label'   => esc_html_x('Mobile Logo Retina (2x - Optional)', 'Admin', 'cheerup'),
						'desc'    => esc_html_x('Use a different logo for mobile devices. Upload a logo twice the normal width and height.', 'Admin', 'cheerup'),
						'type'    => 'upload',
						'options' => array(
							'type'  => 'media',
						),
					),
			
				), // fields
			
			), // section
						
		), // sections
		
	),	// panel		

	array(
		'title' => esc_html_x('Posts & Listings', 'Admin', 'cheerup'),
		'id'    => 'sphere-posts',
		'sections' => array(
			array(
				'id' => 'posts-general',
				'title'  => esc_html_x('Common Post Settings', 'Admin', 'cheerup'),
				'fields' => array(
						
					array(
						'name' => 'featured_crop',
						'label'   => esc_html_x('Crop Featured Images?', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Crop featured image for consistent sizing and least bandwidth usage. Applies to: Classic Style listings, Single Post.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name'  => 'meta_style',
						'label' => esc_html_x('Meta Style', 'Admin', 'cheerup'),
						'value' => '',
						'type'  => 'radio',
						'desc'  => esc_html_x('Affects grid and large posts only.', 'Admin', 'cheerup'),
						'options' => array(
							'' => esc_html_x('Style 1: Category and Date', 'Admin', 'cheerup'),
							'style-b' => esc_html_x('Style 2: Category, Date, Comments', 'Admin', 'cheerup'),
							'style-c' => esc_html_x('Style 3: Magazine - Left, Author, Date', 'Admin', 'cheerup'),
						)
					),

					array(
						'name' => 'meta_date',
						'label'   => esc_html_x('Post Meta: Show Date', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),

					array(
						'name' => 'meta_category',
						'label'   => esc_html_x('Post Meta: Show Category', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'meta_cat_labels',
						'label'   => esc_html_x('Post Image: Category Overlay', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => '',
						'type'    => 'checkbox',
					),

					array(
						'name' => 'posts_likes',
						'label'   => esc_html_x('Enable Post Likes', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),

					array(
						'name' => 'post_comments',
						'label'   => esc_html_x('Show Comment Count', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
						'context' => array('control' => array('key' => 'meta_style', 'value' => 'style-b'))
					),
						
				), // fields
			), // section
			
			array(
				'id' => 'posts-single',
				'title'  => esc_html_x('Single Post', 'Admin', 'cheerup'),
				'fields' => array(

					array(
						'name'  => 'post_layout_template',
						'label' => esc_html_x('Default Post Style', 'Admin', 'cheerup'),
						'value' => 'classic',
						'type'  => 'radio',
						'options' => array(
							'classic' => esc_html_x('Classic', 'Admin', 'cheerup'),
							'creative' => esc_html_x('Creative - Large Style', 'Admin', 'cheerup'),
							'cover' => esc_html_x('Creative - Overlay Style', 'Admin', 'cheerup'),
							'dynamic'  => esc_html_x('Dynamic (Affects Full Width Layout Only)', 'Admin', 'cheerup'),
							'magazine' => esc_html_x('Magazine/News Style', 'Admin', 'cheerup'),
						)
							
					),
						
					array(
						'name' => 'single_share_float',
						'label'   => esc_html_x('Social: Floating/Sticky Buttons', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => '',
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'single_share',
						'label'   => esc_html_x('Social: Show Post Share', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),
					
					array(
						'name' => 'single_tags',
						'label'   => esc_html_x('Show Post Tags', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),
					
					array(
						'name' => 'show_featured',
						'label'   => esc_html_x('Show Featured Image Area', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Stops displaying the featured image in large posts. Can also be set per set while adding/edit a post.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',	
					),
					
					array(
						'name' => 'single_all_cats',
						'label'   => esc_html_x('All Categories in Meta', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('If unchecked, only the Primary Category is displayed.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',	
					),
					
					array(
						'name' => 'author_box',
						'label'   => esc_html_x('Show Author Box', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',	
					),
						
					array(
						'name' => 'single_navigation',
						'label'   => esc_html_x('Show Next/Previous Post', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => '',
						'type'    => 'checkbox',	
					),	

					array(
						'name' => 'related_posts',
						'label'   => esc_html_x('Show Related Posts', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',	
					),
					
					array(
						'name' => 'related_posts_by',
						'label'   => esc_html_x('Related Posts Match By', 'Admin', 'cheerup'),
						'value'   => 'cat_tags',
						'desc'    => '',
						'type'    => 'radio',
						'options' => array(
							''     => esc_html_x('Categories', 'Admin', 'cheerup'),
							'tags' => esc_html_x('Tags', 'Admin', 'cheerup'),
							'cat_tags' => esc_html_x('Both', 'Admin', 'cheerup'),
							 
						),
					),
						
					array(
						'name' => 'related_posts_number',
						'label'   => esc_html_x('Related Posts Number', 'Admin', 'cheerup'),
						'value'   => 3,
						'desc'    => '',
						'type'    => 'number',
					),
						
					array(
						'name' => 'related_posts_grid',
						'label'   => esc_html_x('Related Posts Columns', 'Admin', 'cheerup'),
						'value'   => 3,
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
							3 => esc_html_x('3 Columns', 'Admin', 'cheerup'),
							2 => esc_html_x('2 Columns', 'Admin', 'cheerup'),
						)
						
					),

				), // fields
			), // section
			
			array(
				'id' => 'posts-listings',
				'title'  => esc_html_x('Post Listings', 'Admin', 'cheerup'),
				'fields' => array(
						
					array(
						'name' => 'post_grid_style',
						'label'   => esc_html_x('Grid Posts Style', 'Admin', 'cheerup'),
						'value'   => 'grid',
						'desc'    => esc_html_x('When using a layout that uses grid posts, there are two types of grid posts to choose from', 'Admin', 'cheerup'),
						'type'    => 'select',
						'options' => array(
							'grid' => esc_html_x('Style 1: Default - With Social', 'Admin', 'cheerup'),
							'grid-b' => esc_html_x('Style 2: Centered Text & Read More', 'Admin', 'cheerup')
						),
					),
						
					array(
						'name' => 'post_grid_masonry',
						'label'   => esc_html_x('Masonry Grid Posts', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('When using a layout that uses grid posts, you can use a masonry layout.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name'  => 'post_grid_meta_style',
						'label' => esc_html_x('Grid Posts: Meta Style', 'Admin', 'cheerup'),
						'value' => '',
						'type'  => 'select',
						'desc'  => esc_html_x('Default uses global setting from Common Post Settings.', 'Admin', 'cheerup'),
						'options' => array(
							'' => esc_html_x('Default - Global', 'Admin', 'cheerup'),
							'style-a' => esc_html_x('Style 1: Category and Date', 'Admin', 'cheerup'),
							'style-b' => esc_html_x('Style 2: Category, Date, Comments', 'Admin', 'cheerup'),
							'style-c' => esc_html_x('Style 3: Magazine - Left, Author, Date', 'Admin', 'cheerup'),
						)
					),
					
					array(
						'name' => 'post_large_style',
						'label'   => esc_html_x('Large Posts Style', 'Admin', 'cheerup'),
						'value'   => 'large',
						'desc'    => esc_html_x('When using a layout that uses large post, there are two styles to choose from.', 'Admin', 'cheerup'),
						'type'    => 'select',
						'options' => array(
							'large' => esc_html_x('Style 1: Default - Title Below', 'Admin', 'cheerup'),
							'large-b' => esc_html_x('Style 2: Title Above', 'Admin', 'cheerup'),
							'large-c' => esc_html_x('Style 3: Overlay Bottom & No Excerpt', 'Admin', 'cheerup'),
						),
					),
						
					array(
						'name' => 'post_list_style',
						'label'   => esc_html_x('List Posts Style', 'Admin', 'cheerup'),
						'value'   => 'list',
						'desc'    => esc_html_x('When using a layout that uses list posts, there are two types of grid posts to choose from', 'Admin', 'cheerup'),
						'type'    => 'select',
						'options' => array(
							'list' => esc_html_x('Style 1: Default - With Social', 'Admin', 'cheerup'),
							'list-b' => esc_html_x('Style 2: Spacious & Read More', 'Admin', 'cheerup')
						),
					),

					array(
						'name' => 'pagination_style',
						'label'   => esc_html_x('Pagination Style', 'Admin', 'cheerup'),
						'value'   => '',
						'type'    => 'radio',
						'options' => array(
							''     => esc_html_x('Older / Newer', 'Admin', 'cheerup'),
							'numbers' => esc_html_x('Page Numbers', 'Admin', 'cheerup'),
							'load-more' => esc_html_x('Load More', 'Admin', 'cheerup'),
						),
					),
						
					array(
						'name' => 'post_format_icons',
						'label'   => esc_html_x('Show Post Format Icons?', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Post format icons (video, gallery) can be enabled on a few listing styles such as list and grid.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'post_footer_blog',
						'label'   => esc_html_x('Large Post: Show Post Footer', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Post footer is the extar info shown below post such as author, read more, and social icons.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'post_footer_author',
						'label'   => esc_html_x('Large Post: Show Author', 'Admin', 'cheerup'),
						'value'   => 1,
						'type'    => 'checkbox',
					),
						
						
					array(
						'name' => 'post_footer_read_more',
						'label'   => esc_html_x('Large Post: Show Read More', 'Admin', 'cheerup'),
						'value'   => 1,
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'post_footer_social',
						'label'   => esc_html_x('Large Post: Show Social', 'Admin', 'cheerup'),
						'value'   => 1,
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'post_footer_grid',
						'label'   => esc_html_x('Grid: Show Post Footer', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Area below posts for Social Icons or Read More depending on chosen style.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
					array(
						'name' => 'post_footer_list',
						'label'   => esc_html_x('List: Show Post Footer', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => esc_html_x('Area below posts that shows likes count & social icons.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
					
					array(
						'name'    => 'post_body',
						'label'   => esc_html_x('Post Body', 'Admin', 'cheerup'),
						'value'   => 'full',
						'type'    => 'radio',
						'desc'    => esc_html_x('Note: Only applies to Blog Listing style. Both support WordPress <!--more--> teaser.', 'Admin', 'cheerup'),
						'options' => array(
							'full' => esc_html_x('Full Post', 'Admin', 'cheerup'),
							'excerpt' => esc_html_x('Excerpts', 'Admin', 'cheerup'),
						),
					),
					
					array(
						'name'    => 'post_excerpt_blog',
						'label'   => esc_html_x('Excerpt Words: Classic Style', 'Admin', 'cheerup'),
						'value'   => 150,
						'type'    => 'number',
						'desc'    => '',
					),
					
					array(
						'name'    => 'post_excerpt_grid',
						'label'   => esc_html_x('Excerpt Words: Grid Style', 'Admin', 'cheerup'),
						'value'   => 28,
						'type'    => 'number',
						'desc'    => '',
					),
					
					
					array(
						'name'    => 'post_excerpt_list',
						'label'   => esc_html_x('Excerpt Words: List Style', 'Admin', 'cheerup'),
						'value'   => 24,
						'type'    => 'number',
						'desc'    => '',
					),
			
				), // fields
			), // section
			
			array(
				'id' => 'posts-pinterest',
				'title'  => esc_html_x('Pinterest on Images', 'Admin', 'cheerup'),
				'fields' => array(
						
					array(
						'name' => 'pinit_button',
						'label'   => esc_html_x('Show Pin It On Hover?', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('When enabled, on single posts and large posts body, pin it button will show on hover (only works on non-touch devices).', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),
						
	
					array(
						'name'    => 'pinit_button_label',
						'label'   => esc_html_x('Show Label', 'Admin', 'cheerup'),
						'value'   => 0,
						'type'    => 'checkbox',
					),
						
					array( 
						'name'    => 'pinit_button_text',
						'label'   => esc_html_x('Button Label', 'Admin', 'cheerup'),
						'value'   => esc_html__('Pin It', 'cheerup'),
						'type'    => 'input',
					),
						
					array(
						'name'    => 'pinit_show_on',
						'label'   => esc_html_x('Show On:', 'Admin', 'cheerup'),
						'value'   => array('single'),
						'type'    => 'checkboxes',
						'options' => array(
							'single' => esc_html_x('Single Post Images', 'Admin', 'cheerup'),
							'listing' => esc_html_x('Listings/Categories: Featured Images', 'Admin', 'cheerup'), 
						)
					)
					
						
				), // fields
			), // section
			
		) // sections
			
	), // panel
	
	

	array(
		'title' => esc_html_x('Footer Settings', 'Admin', 'cheerup'),
		'id'    => 'sphere-footer',
		'desc'  => esc_html_x('Middle footer is activated by adding an instagram widget.', 'Admin', 'cheerup'),
		'sections' => array(
						
			array(
				'id' => 'footer-upper',
				'title'  => esc_html_x('General & Upper Footer', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'footer_layout',
						'value' => '',
						'label' => esc_html_x('Select layout', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'select',
						'options' => array(
							'' => esc_html_x('Default Light', 'Admin', 'cheerup'),
							'contrast' => esc_html_x('Dark Contrast', 'Admin', 'cheerup'),
							'alt' => esc_html_x('Alternate Light', 'Admin', 'cheerup'),
							'stylish' => esc_html_x('Stylish Dark', 'Admin', 'cheerup'),
							'stylish-b' => esc_html_x('Stylish Dark Alt', 'Admin', 'cheerup'),
							'classic' => esc_html_x('Magazine / Classic Dark', 'Admin', 'cheerup'),
							'bold' => esc_html_x('Bold Dark (Footer Links Supported)', 'Admin', 'cheerup')
						)
					),
						
					array(
						'name'  => 'footer_upper',
						'value' => 1,
						'label' => esc_html_x('Enable Upper Footer', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'checkbox'
					),
					
					array(
						'name'  => 'footer_logo',
						'value' => '',
						'label' => esc_html_x('Footer Logo', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'upload',
						'options' => array(
							'type' => 'image'
						),
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('contrast', 'stylish', 'stylish-b'))),
					),
					
					array(
						'name'  => 'footer_logo_2x',
						'value' => '',
						'label' => esc_html_x('Footer Logo Retina (2x)', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'upload',
						'options' => array(
							'type' => 'image'
						),
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('contrast', 'stylish', 'stylish-b'))),
					),
					
					array(
						'name'  => 'css_footer_bg',
						'value' => '',
						'label' => esc_html_x('Footer Background Image', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'upload',
						'options' => array(
							'type' => 'image'
						),
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('stylish', 'stylish-b'))),
						'bg_type' => array('value' => 'cover-nonfixed'),
						'css' => array(
							'selectors' => array(
								'.main-footer .bg-wrap:before' => 'background-image: url(%s)'
							),
						),
						
					),
						
					array(
						'name' => 'css_footer_bg_opacity',
						'label'   => esc_html_x('Footer Bg Image Opacity', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('An opacity of 0.2 is recommended.', 'Admin', 'cheerup'),
						'type'    => 'number',
						'input_attrs' => array('min' => 0, 'max' => 1, 'step' => 0.1),
						'css' => array(
							'selectors' => array(
								'.main-footer .bg-wrap:before' => 'opacity: %s'
							)
						),
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('stylish', 'stylish-b'))),
					),
			
				), // fields
			), // section
			
			array(
				'id' => 'footer-lower',
				'title'  => esc_html_x('Lower Footer', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'footer_lower',
						'value' => 1,
						'label' => esc_html_x('Enable Lower Footer', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'checkbox'
					),

					array(
						'name'  => 'footer_links',
						'value' => 0,
						'label' => esc_html_x('Enable Footer Links', 'Admin', 'cheerup'),
						'desc'  => esc_html_x('After ticking here, save and add a menu from Appearance > Menus and assign it to footer links.', 'Admin', 'cheerup'),
						'type'  => 'checkbox',
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('bold'))),
					),
					
					array(
						'name'  => 'footer_copyright',
						'value' => '&copy; 2018 ThemeSphere. Designed by <a href="http://theme-sphere.com">ThemeSphere</a>.', // Example copyright message in Customizer
						'label' => esc_html_x('Copyright Message', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'  => 'footer_back_top',
						'value' => 1,
						'label' => esc_html_x('Show Back to Top', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'checkbox',
						'context' => array('control' => array('key' => 'footer_layout', 'value' => ''))
					),
						
					array(
						'label'   => esc_html_x('Footer Social Icons', 'Admin', 'cheerup'),
						'name'    => 'footer_social',
						'value'   => array('facebook', 'twitter', 'instagram'),
						'desc'    => esc_html_x('NOTE: Configure these icons URLs from General Settings > Social Media.', 'Admin', 'cheerup'),
						'type'    => 'checkboxes',
					
						// Show only if header layout is default
						'context' => array('control' => array('key' => 'footer_layout', 'value' => array('contrast', 'alt', 'stylish', 'stylish-b', 'bold'))),
						'options' => array(
							'facebook'  => esc_html_x('Facebook', 'Admin', 'cheerup'),
							'twitter'   => esc_html_x('Twitter', 'Admin', 'cheerup'),
							'gplus'     => esc_html_x('Google Plus', 'Admin', 'cheerup'),
							'instagram' => esc_html_x('Instagram', 'Admin', 'cheerup'),
							'pinterest' => esc_html_x('Pinterest', 'Admin', 'cheerup'),
							'vimeo'     => esc_html_x('Vimeo', 'Admin', 'cheerup'),
							'bloglovin' => esc_html_x('BlogLovin', 'Admin', 'cheerup'),
							'rss'       => esc_html_x('RSS', 'Admin', 'cheerup'),
							'youtube'   => esc_html_x('Youtube', 'Admin', 'cheerup'),
							'dribbble'  => esc_html_x('Dribbble', 'Admin', 'cheerup'),
							'tumblr'    => esc_html_x('Tumblr', 'Admin', 'cheerup'),
							'linkedin'  => esc_html_x('LinkedIn', 'Admin', 'cheerup'),
							'flickr'    => esc_html_x('Flickr', 'Admin', 'cheerup'),
							'soundcloud' => esc_html_x('SoundCloud', 'Admin', 'cheerup'),
							'lastfm'     => esc_html_x('Last.fm', 'Admin', 'cheerup'),
							'vk'         => esc_html_x('VKontakte', 'Admin', 'cheerup'),
							'steam'      => esc_html_x('Steam', 'Admin', 'cheerup'),
						),
					),
			
				), // fields
			), // section
				
		) // sections
			
	), // panel
	
	'sphere-general' => array(
		'title' => esc_html_x('General Settings', 'Admin', 'cheerup'),
		'id'    => 'sphere-general',
		'sections' => array(
			
			array(
				'id' => 'general-archives',
				'title'  => esc_html_x('Categories & Archives', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'archive_sidebar',
						'label'   => esc_html_x('Listings Sidebar', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => esc_html_x('Applies to all type of archives except home.', 'Admin', 'cheerup'),
						'type'    => 'radio',
						'options' => array(
							''  => esc_html_x('Default', 'Admin', 'cheerup'),
							'none'  => esc_html_x('No Sidebar', 'Admin', 'cheerup'),
							'right' => esc_html_x('Right Sidebar', 'Admin', 'cheerup') 
						),
					),
			
					array(
						'name' => 'category_loop',
						'label'   => esc_html_x('Category Listing Style', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
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
						),
					),
					
					array(
						'name' => 'archive_loop',
						'label'   => esc_html_x('Archive Listing Style', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(
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
						),
					),
					
					array(
						'name' => 'search_loop',
						'label'   => esc_html_x('Search Listing Style', 'Admin', 'cheerup'),
						'value'   => '',
						'desc'    => '',
						'type'    => 'select',
						'options' => array(

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
						),
					),
					
					array(
						'name'  => 'archive_descriptions',
						'value' => 0,
						'label' => esc_html_x('Show Category Descriptions?', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'checkbox'
					),
					
				) // fields
			
			), // section
			
			array(
				'id' => 'general-social',
				'title'  => esc_html_x('Social Media Links', 'Admin', 'cheerup'),
				'desc'   => esc_html_x('Enter full URLs to your social media profiles. These are used in Top Bar social icons.', 'Admin', 'cheerup'),
				'fields' => array(

					array(
						'name'   => 'social_profiles[facebook]',
						'value' => '',
						'label' => esc_html_x('Facebook', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[twitter]',
						'value' => '',
						'label' => esc_html_x('Twitter', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[instagram]',
						'value' => '',
						'label' => esc_html_x('Instagram', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),	
					
					array(
						'name'   => 'social_profiles[pinterest]',
						'value' => '',
						'label' => esc_html_x('Pinterest', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[bloglovin]',
						'value' => '',
						'label' => esc_html_x('BlogLovin', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[bloglovin]',
						'value' => '',
						'label' => esc_html_x('BlogLovin', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[gplus]',
						'value' => '',
						'label' => esc_html_x('Google+', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[youtube]',
						'value' => '',
						'label' => esc_html_x('YouTube', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[dribbble]',
						'value' => '',
						'label' => esc_html_x('Dribbble', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[tumblr]',
						'value' => '',
						'label' => esc_html_x('Tumblr', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[linkedin]',
						'value' => '',
						'label' => esc_html_x('LinkedIn', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[flickr]',
						'value' => '',
						'label' => esc_html_x('Flickr', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[soundcloud]',
						'value' => '',
						'label' => esc_html_x('SoundCloud', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[vimeo]',
						'value' => '',
						'label' => esc_html_x('Vimeo', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[rss]',
						'value' => get_bloginfo('rss2_url'),
						'label' => esc_html_x('RSS', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
					
					array(
						'name'   => 'social_profiles[vk]',
						'value' => '',
						'label' => esc_html_x('VKontakte', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
						
					array(
						'name'   => 'social_profiles[lastfm]',
						'value' => '',
						'label' => esc_html_x('Last.fm', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
						
					array(
						'name'   => 'social_profiles[steam]',
						'value' => '',
						'label' => esc_html_x('Steam', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'text'
					),
			
				) // fields
			
			), // section
			
						
			array(
				'id' => 'general-misc',
				'title'  => esc_html_x('Layout & Misc', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'default_sidebar',
						'label'   => esc_html_x('Default Sidebar', 'Admin', 'cheerup'),
						'value'   => 'right',
						'desc'    => esc_html_x('This setting can be changed per post or page.', 'Admin', 'cheerup'),
						'type'    => 'radio',
						'options' => array(
							'none'  => esc_html_x('No Sidebar', 'Admin', 'cheerup'),
							'right' => esc_html_x('Right Sidebar', 'Admin', 'cheerup') 
						),
					),
						
					array(
						'name' => 'sidebar_sticky',
						'label'   => esc_html_x('Sticky Sidebar', 'Admin', 'cheerup'),
						'value'   => 0,
						'desc'    => esc_html_x('Make the sidebar always stick around while scrolling.', 'Admin', 'cheerup'),
						'type'    => 'checkbox',
					),

					array(
						'name'   => 'search_posts_only',
						'value' => 1,
						'label' => esc_html_x('Limit Search To Posts', 'Admin', 'cheerup'),
						'desc'  => esc_html_x('Enabling this feature will exclude pages from WordPress search.', 'Admin', 'cheerup'),
						'type'  => 'checkbox'
					),
					
					array(
						'name' => 'enable_lightbox',
						'label'   => esc_html_x('Enable Lightbox for Images', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox',
					),
					
					
				) // fields
				
			), // section
			
				
			array(
				'id' => 'general-woocommerce',
				'title'  => esc_html_x('WooCommerce/Shop', 'Admin', 'cheerup'),
				'desc'   => esc_html_x('Settings here only apply if you have WooCommerce installed.', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name' => 'woocommerce_per_page',
						'label'   => esc_html_x('Shop Products / Page', 'Admin', 'cheerup'),
						'value'   => 9,
						'desc'    => '',
						'type'    => 'number'
					),
						
					array(
						'name' => 'woocommerce_image_zoom',
						'label'   => esc_html_x('Product Page - Image Zoom', 'Admin', 'cheerup'),
						'value'   => 1,
						'desc'    => '',
						'type'    => 'checkbox'
					),
				),
			),
			
		) // sections
		
	), // panel
	
	array(
		'title' => esc_html_x('Colors & Style', 'Admin', 'cheerup'),
		'id'    => 'sphere-style',
		'sections' => array(
			array(
				'id' => 'style-general',
				'title'  => esc_html_x('General', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_main_color',
						'value' => '#318892',
						'label' => esc_html_x('Main Theme Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(

							'selectors' => array(
					
								'::selection' => 'background: rgba(%s, 0.4)',
								'::-moz-selection' => 'background: rgba(%s, 0.4)',

								'input[type="submit"],
								button,
								input[type="button"],
								.button,
								.cart-action .cart-link .counter,
								.main-head.compact .posts-ticker .heading,
								.single-cover .overlay .post-cat a,
								.comments-list .bypostauthor .post-author,
								.cat-label a:hover,
								.cat-label.color a,
								.post-thumb:hover .cat-label a,
								.products-block .more-link:hover,
								.beauty-slider .slick-dots .slick-active button,
								.carousel-slider .category,
								.grid-b-slider .category,
								.page-links .current,
								.page-links a:hover,
								.page-links > span,
								.widget-posts .posts.full .counter:before,
								.woocommerce span.onsale,
								.woocommerce a.button,
								.woocommerce button.button,
								.woocommerce input.button,
								.woocommerce #respond input#submit,
								.woocommerce a.button.alt,
								.woocommerce a.button.alt:hover,
								.woocommerce button.button.alt,
								.woocommerce button.button.alt:hover,
								.woocommerce input.button.alt,
								.woocommerce input.button.alt:hover,
								.woocommerce #respond input#submit.alt,
								.woocommerce #respond input#submit.alt:hover,
								.woocommerce a.button:hover,
								.woocommerce button.button:hover,
								.woocommerce input.button:hover,
								.woocommerce #respond input#submit:hover,
								.woocommerce nav.woocommerce-pagination ul li span.current,
								.woocommerce nav.woocommerce-pagination ul li a:hover,
								.woocommerce ul.products .add_to_cart_button,
								.woocommerce ul.products .added_to_cart,
								.woocommerce .widget_price_filter .price_slider_amount .button,
								.woocommerce .widget_price_filter .ui-slider .ui-slider-handle'
									=> 'background: %s',
									
								'blockquote:before,
								.main-color,
								.top-bar .social-icons a:hover,
								.navigation .menu > li:hover > a,
								.navigation .menu > .current-menu-item > a,
								.navigation .menu > .current-menu-parent > a,
								.navigation .menu > .current-menu-ancestor > a,
								.navigation li:hover > a:after,
								.navigation .current-menu-item > a:after,
								.navigation .current-menu-parent > a:after,
								.navigation .current-menu-ancestor > a:after,
								.navigation .menu li li:hover > a,
								.navigation .menu li li.current-menu-item > a,
								.tag-share .post-tags a:hover,
								.post-share-icons a:hover,
								.post-share-icons .likes-count,
								.author-box .author > span,
								.comments-area .section-head .number,
								.comments-list .comment-reply-link,
								.main-footer.dark .social-link:hover,
								.lower-footer .social-icons .fa,
								.archive-head .sub-title,
								.social-share a:hover,
								.social-icons a:hover,
								.post-meta .post-cat > a,
								.post-meta-c .post-author > a,
								.large-post-b .post-footer .author a,
								.trendy-slider .post-cat a,
								.main-pagination .next a:hover,
								.main-pagination .previous a:hover,
								.main-pagination.number .current,
								.post-content a,
								.widget-about .more,
								.widget-about .social-icons .social-btn:hover,
								.widget-social .social-link:hover,
								.woocommerce .star-rating:before,
								.woocommerce .star-rating span:before,
								.woocommerce .amount,
								.woocommerce .order-select .drop a:hover,
								.woocommerce .order-select .drop li.active,
								.woocommerce-page .order-select .drop a:hover,
								.woocommerce-page .order-select .drop li.active,
								.woocommerce .widget_price_filter .price_label .from,
								.woocommerce .widget_price_filter .price_label .to,
								.woocommerce div.product div.summary p.price,
								.woocommerce div.product div.summary span.price,
								.woocommerce #content div.product div.summary p.price,
								.woocommerce #content div.product div.summary span.price'
									=> 'color: %s',
									
								'.products-block .more-link:hover,
								.beauty-slider .slick-dots .slick-active button,
								.page-links .current,
								.page-links a:hover,
								.page-links > span,
								.woocommerce nav.woocommerce-pagination ul li span.current,
								.woocommerce nav.woocommerce-pagination ul li a:hover'
									=> 'border-color: %s',
									
								'.post-title-alt:after,
								.block-head-b .title' 
									=> 'border-bottom: 1px solid %s',
									
								'.widget_categories a:before,
								.widget_product_categories a:before,
								.widget_archive a:before'
									=> 'border: 1px solid %s',
									
								// Beauty / Miranda
								'.skin-miranda .sidebar .widget-title,
								.skin-beauty .sidebar .widget-title' 
									=> 'border-top-color: %s',
									
								// For Rovella
								'.skin-rovella .navigation.dark .menu li:hover > a,
								.skin-rovella .navigation.dark .menu li li:hover > a,
								.skin-rovella .navigation.dark .menu li:hover > a:after,
								.skin-rovella .main-footer.stylish .copyright a'
									=> 'color: %s',

								// Travel
								'.skin-travel .navigation.dark .menu li:hover > a,
								.skin-travel .navigation.dark .menu li li:hover > a,
								.skin-travel .navigation.dark .menu li:hover > a:after,
								.skin-travel .posts-carousel .block-heading .title,
								.skin-travel .post-content .read-more a,
								.skin-travel .sidebar .widget-title,
								.skin-travel .grid-post-b .read-more-btn'
									=> 'color: %s',
									
								'.skin-travel .sidebar .widget-title:after,
								.skin-travel .post-content .read-more a:before,
								.skin-travel .grid-post-b .read-more-btn' 
									=> 'border-color: %s',
									
								'.skin-travel .grid-post-b .read-more-btn:hover,
								.skin-travel .posts-carousel .block-heading:after' 
									=> 'background-color: %s',
								
							)
						)
					),
					
					array(
						'name'  => 'css_body_color',
						'value' => '#494949',
						'label' => esc_html_x('Post Body Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.post-content' => 'color: %s'
							)
						)
					),
					
					array(
						'name'  => 'css_site_bg',
						'value' => '#ffffff',
						'label' => esc_html_x('Site Background Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'body' => 'background-color: %s'
							)
						)
					),

					array(
						'name'  => 'css_footer_upper_bg',
						'value' => '#f7f7f7',
						'label' => esc_html_x('Upper Footer Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.upper-footer' => 'background-color: %s; border-top: 0'
							)
						)
					),
						
					array(
						'name'  => 'css_footer_lower_bg',
						'value' => '#f7f7f7',
						'label' => esc_html_x('Lower Footer Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.lower-footer' => 'background-color: %s; border-top: 0'
							)
						)
					),
						


				), // fields
			), // section
			
			array(
				'id' => 'style-header',
				'title'  => esc_html_x('Header', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_topbar_bg',
						'value' => '#fff',
						'label' => esc_html_x('Top Bar Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.top-bar-content, .top-bar.dark .top-bar-content' => 'background-color: %1$s; border-color: %1$s',
								'.top-bar .navigation' => 'background: transparent',
							)
						)
					),
						
					array(
						'name'  => 'css_topbar_social',
						'value' => '#fff',
						'label' => esc_html_x('Social Icons Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.main-head .social-icons a' => 'color: %s !important',
							)
						)
					),
						
					array(
						'name'  => 'css_topbar_search',
						'value' => '#fff',
						'label' => esc_html_x('Search Icon Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.main-head .search-submit' => 'color: %s !important',
							)
						)
					),

					array(
						'name'  => 'css_logo_padding_top',
						'value' => 70,
						'label' => esc_html_x('Logo Padding Top', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'number',
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('simple', 'compact'), 'compare' => '!=')),
						'css'   => array(
							'selectors' => array(
								'.main-head:not(.simple):not(.compact):not(.logo-left) .title' => 'padding-top: %spx !important'
							)
						)
					),
					

					array(
						'name'  => 'css_logo_padding_bottom',
						'value' => 70,
						'label' => esc_html_x('Logo Padding Bottom', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'number',
						'context' => array('control' => array('key' => 'header_layout', 'value' => array('simple', 'compact'), 'compare' => '!=')),
						'css'   => array(
							'selectors' => array(
								'.main-head:not(.simple):not(.compact):not(.logo-left) .title' => 'padding-bottom: %spx !important'
							)
						)
					),

				), // fields
			), // section
			
			
			array(
				'id' => 'style-navigation',
				'title'  => esc_html_x('Navigation', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_nav_color',
						'value' => '#494949',
						'label' => esc_html_x('Top-level Links Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.navigation .menu > li > a, .navigation.dark .menu > li > a' => 'color: %s'
							)
						)
					),
					
					array(
						'name'  => 'css_nav_hover',
						'value' => '#318892',
						'label' => esc_html_x('Top-level Hover/Active', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.navigation .menu > li:hover > a, 
								.navigation .menu > .current-menu-item > a, 
								.navigation .menu > .current-menu-parent > a, 
								.navigation .menu > .current-menu-ancestor > a' 
									=> 'color: %s !important'
							)
						)
					),
					
					array(
						'name'  => 'css_nav_drop_bg',
						'value' => '#fff',
						'label' => esc_html_x('Dropdown Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.navigation .menu ul, .navigation .menu .sub-menu' => 'border-color: transparent; background: %s !important',

								// Use transparent borders to adapt to background
								'.navigation .menu > li li a' => 'border-color: rgba(255, 255, 255, 0.07)'
							)
						)
					),

					array(
						'name'  => 'css_nav_drop_color',
						'value' => '#535353',
						'label' => esc_html_x('Dropdown Links Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.navigation .menu > li li a' => 'color: %s !important'
							)
						)
					),
					
					array(
						'name'  => 'css_nav_drop_hover',
						'value' => '#318892',
						'label' => esc_html_x('Dropdown Links Hover/Active', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.navigation .menu li li:hover > a, .navigation .menu li li.current-menu-item > a' => 'color: %s !important'
							)
						)
					),

				), // fields
			), // section
			
			
			array(
				'id' => 'style-slider',
				'title'  => esc_html_x('Featured Slider', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_beauty_overlay_bg',
						'value' => '#fff',
						'label' => esc_html_x('Beauty: Overlay Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.beauty-slider .overlay' => 'background-color: %s'
							)
						)
					),
					
					array(
						'name'  => 'css_beauty_overlay_opacity',
						'value' => 1,
						'label' => esc_html_x('Beauty: Overlay Opacity', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'number',
						'input_attrs' => array('max' => 1, 'min' => 0, 'step' => 0.1),
						'css'   => array(
							'selectors' => array(
								'.beauty-slider .overlay' => 'background-color: rgba({css_beauty_overlay_bg}, %s)'
							)
						)
					),
						
					array(
						'name'  => 'css_trendy_overlay_bg',
						'value' => '#000',
						'label' => esc_html_x('Trendy: Overlay Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.trendy-slider .overlay' => 'background-color: %s'
							)
						)
					),
					
					array(
						'name'  => 'css_trendy_overlay_opacity',
						'value' => 0.15,
						'label' => esc_html_x('Trendy: Overlay Opacity', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'input',
						'css'   => array(
							'selectors' => array(
								'.trendy-slider .overlay' => 'background-color: rgba({css_trendy_overlay_bg}, %s)'
							)
						)
					),

				), // fields
			), // section
			
			array(
				'id' => 'style-posts',
				'title'  => esc_html_x('Posts & Listings', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_posts_title_color',
						'value' => '',
						'label' => esc_html_x('Post Titles Color', 'Admin', 'cheerup'),
						'desc'  => esc_html_x('Changing this affects post title colors globally. May require adjusting post titles in other areas below.', 'Admin', 'cheerup'),
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.post-title, 
								.post-title-alt, 
								.post-title a, 
								.post-title-alt a' 
									=> 'color: %s !important'
							)
						)
					),
						
					array(
						'name'  => 'css_posts_title_footer',
						'value' => '',
						'label' => esc_html_x('Footer: Post Titles', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.main-footer .post-title, 
								.main-footer .product-title' 
									=> 'color: %s !important'
							)
						)
					),
						
					array(
						'name'  => 'css_posts_title_footer',
						'value' => '',
						'label' => esc_html_x('Footer: Post Titles', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.main-footer .post-title, 
								.main-footer .product-title' 
									=> 'color: %s !important'
							)
						)
					),
						
					array(
						'name'  => 'css_posts_title_menu',
						'value' => '',
						'label' => esc_html_x('Mega Menu: Post Titles', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.mega-menu .recent-posts .post-title' 
									=> 'color: %s !important'
							)
						)
					),

					array(
						'name'  => 'css_posts_content_color',
						'value' => '',
						'label' => esc_html_x('Post Content Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.post-content' => 'color: %s'
							)
						)
					),
						
						
					array(
						'name'  => 'css_post_meta',
						'value' => '',
						'label' => esc_html_x('Post Meta Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.post-meta, 
								.post-meta-b .date-link, 
								.post-meta-b .comments' => 'color: %s'
							)
						)
					),
						
						
					array(
						'name'  => 'css_post_meta',
						'value' => '',
						'label' => esc_html_x('Meta Category Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.post-meta .post-cat > a' => 'color: %s'
							)
						)
					),

				), // fields
			), // section
			
				
			array(
				'id' => 'style-sidebar',
				'title'  => esc_html_x('Sidebar', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_sidebar_widget_title',
						'value' => '',
						'label' => esc_html_x('Widget Titles Background', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.sidebar .widget:not(.widget_mc4wp_form_widget):not(.widget-subscribe) .widget-title' => 'background-color: %s',
							)
						)
					),
						
					array(
						'name'  => 'css_sidebar_title_color',
						'value' => '',
						'label' => esc_html_x('Widget Titles Color', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'color',
						'css'   => array(
							'selectors' => array(
								'.sidebar .widget:not(.widget_mc4wp_form_widget):not(.widget-subscribe) .widget-title' => 'color: %s',
							)
						)
					),

					array(
						'name'  => 'css_sidebar_widget_margin',
						'value' => 45,
						'label' => esc_html_x('Widget Bottom Spacing', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'number',
						'css'   => array(
							'selectors' => array(
								'.sidebar .widget' => 'margin-bottom: %spx'
							)
						)
					),

				), // fields
			), // section
			

				
		) // sections
	), // panel
	
	

	array(
		'title' => esc_html_x('Typography & Fonts', 'Admin', 'cheerup'),
		'id'    => 'sphere-typography',
		'desc'  => esc_html_x('All the typography fonts are from Google Fonts. You can either select one from the list or click and type the name of any font from Google Fonts directory.', 'Admin', 'cheerup'),
		'sections' => array(
			array(
				'id' => 'typography-fonts',
				'title'  => esc_html_x('Fonts & Sizes', 'Admin', 'cheerup'),
				'fields' => array(
					array(
						'name' => 'css_font_text',
						'label' => esc_html_x('Primary Font', 'Admin', 'cheerup'),
						'value' => array('font_name' => ''),
						'desc'  => esc_html_x('Used for text mainly. Select from list or click and type your own Google Font name (or TypeKit if you have configured it).', 'Admin', 'cheerup'),
						'type'  => 'typography',
						'typeface' => true, // is family
						'css'   => array(
							'selectors' => '
								body,
								input,
								textarea,
								select,
								blockquote,
								.archive-head .description,
								.text,
								.post-content,
								.textwidget,
								.post-meta .post-cat > span,
								.widget_categories a,
								.widget_product_categories a,
								.widget_archive a,
								.woocommerce .woocommerce-message,
								.woocommerce .woocommerce-error,
								.woocommerce .woocommerce-info,
								.woocommerce form .form-row,
								.woocommerce .woocommerce-noreviews,
								.woocommerce #reviews #comments ol.commentlist .description,
								.woocommerce-cart .cart-empty,
								.woocommerce-cart .cart-collaterals .cart_totals table',
						)
					),
					
					array(
						'name' => 'css_font_secondary',
						'label' => esc_html_x('Secondary Font', 'Admin', 'cheerup'),
						'value' => array('font_name' => ''),
						'desc'  => esc_html_x('Used for headings, meta, navigation and so on.', 'Admin', 'cheerup'),
						'type'  => 'typography',
						'typeface' => true, // is family
						'css'   => array(
							'selectors' => '
								h1,
								h2,
								h3,
								h4,
								h5,
								h6,
								input[type="submit"],
								button,
								input[type="button"],
								.button,
								.modern-quote cite,
								.top-bar-content,
								.search-action .search-field,
								.main-head .title,
								.navigation,
								.tag-share,
								.post-share-b .service,
								.author-box,
								.comments-list .comment-content,
								.post-nav .label,
								.main-footer.dark .back-to-top,
								.lower-footer .social-icons,
								.main-footer .social-strip .social-link,
								.main-footer.bold .links .menu-item,
								.main-footer.bold .copyright,
								.archive-head,
								.cat-label a,
								.section-head,
								.post-title-alt,
								.post-title,
								.block-heading,
								.block-head-b,
								.small-post .post-title,
								.likes-count .number,
								.post-meta,
								.grid-post-b .read-more-btn,
								.list-post-b .read-more-btn,
								.post-footer .read-more,
								.post-footer .social-share,
								.post-footer .social-icons,
								.large-post-b .post-footer .author a,
								.products-block .more-link,
								.main-slider,
								.slider-overlay .heading,
								.large-slider,
								.large-slider .heading,
								.grid-slider .category,
								.grid-slider .heading,
								.carousel-slider .category,
								.carousel-slider .heading,
								.grid-b-slider .heading,
								.bold-slider,
								.bold-slider .heading,
								.main-pagination,
								.main-pagination .load-button,
								.page-links,
								.post-content .read-more,
								.widget-about .more,
								.widget-posts .post-title,
								.widget-posts .posts.full .counter:before,
								.widget-cta .label,
								.social-follow .service-link,
								.widget-twitter .meta .date,
								.widget-twitter .follow,
								.widget_categories,
								.widget_product_categories,
								.widget_archive,
								.mobile-menu,
								.woocommerce .main .button,
								.woocommerce .quantity .qty,
								.woocommerce nav.woocommerce-pagination,
								.woocommerce-cart .post-content,
								.woocommerce .woocommerce-ordering,
								.woocommerce-page .woocommerce-ordering,
								.woocommerce ul.products,
								.woocommerce.widget,
								.woocommerce div.product,
								.woocommerce #content div.product,
								.woocommerce-cart .cart-collaterals .cart_totals .button,
								.woocommerce .checkout .shop_table thead th,
								.woocommerce .checkout .shop_table .amount,
								.woocommerce-checkout #payment #place_order,
								.top-bar .posts-ticker,
								.post-content h1,
								.post-content h2,
								.post-content h3,
								.post-content h4,
								.post-content h5,
								.post-content h6,
								
								.related-posts.grid-2 .post-title,
								.related-posts .post-title,
								.block-heading .title,
								.single-cover .featured .post-title,
								.single-creative .featured .post-title,
								.single-magazine .post-top .post-title,
								.author-box .author > a,
								.section-head .title,
								.comments-list .comment-author,
								.sidebar .widget-title,
								.upper-footer .widget .widget-title
								',
						)
					),
					
					array(
						'name' => 'css_font_sidebar_title',
						'label' => esc_html_x('Widget Titles', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '12'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.sidebar .widget-title',
						)
					),
					
					
					array(
						'name' => 'css_font_nav_links',
						'label' => esc_html_x('Navigation Links', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '11'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.navigation .menu > li > a',
						)
					),
					
					array(
						'name' => 'css_font_nav_drops',
						'label' => esc_html_x('Navigation Dropdowns', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '11'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.navigation .menu > li li a',
						)
					),
					
					array(
						'name' => 'css_font_titles_large',
						'label' => esc_html_x('Large Post Titles', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '25'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.post-title-alt',
						)
					),
					
					array(
						'name' => 'css_font_titles_grid',
						'label' => esc_html_x('Grid: Post Titles', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '23'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.grid-post .post-title-alt',
						)
					),
						
					array(
						'name' => 'css_font_titles_list',
						'label' => esc_html_x('List: Post Titles', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '600', 'font_size' => '23'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.list-post .post-tite',
						)
					),
					
					array(
						'name' => 'css_font_post_body',
						'label' => esc_html_x('Post Body Content', 'Admin', 'cheerup'),
						'value' => array('font_name' => '', 'font_weight' => '400', 'font_size' => '14'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => '.post-content',
						)
					),
					
					array(
						'name' => 'css_font_post_h1',
						'label' => esc_html_x('Post Body H1', 'Admin', 'cheerup'),
						'value' => array('font_size' => '25'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h1',
						)
					),
					
					array(
						'name' => 'css_font_post_h2',
						'label' => esc_html_x('Post Body H2', 'Admin', 'cheerup'),
						'value' => array('font_size' => '23'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h2',
						)
					),
					
					array(
						'name' => 'css_font_post_h3',
						'label' => esc_html_x('Post Body H3', 'Admin', 'cheerup'),
						'value' => array('font_size' => '20'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h3',
						)
					),
					
					array(
						'name' => 'css_font_post_h4',
						'label' => esc_html_x('Post Body H4', 'Admin', 'cheerup'),
						'value' => array('font_size' => '18'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h4',
						)
					),
										
					array(
						'name' => 'css_font_post_h5',
						'label' => esc_html_x('Post Body H5', 'Admin', 'cheerup'),
						'value' => array('font_size' => '16'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h5',
						)
					),
					
					array(
						'name' => 'css_font_post_h6',
						'label' => esc_html_x('Post Body H6', 'Admin', 'cheerup'),
						'value' => array('font_size' => '14'),
						'desc'  => '',
						'type'  => 'typography',
						'css'   => array(
							'selectors' => 'h6',
						)
					),
				) // fields
			), // section
			
			array(
				'id' => 'typography-advanced',
				'title'  => esc_html_x('Typekit / Advanced', 'Admin', 'cheerup'),
				'fields' => array(
						
					array(
						'name' => 'typekit_id',
						'label' => esc_html_x('Typekit Kit ID', 'Admin', 'cheerup'),
						'value' => '',
						'desc'  => esc_html_x('Refer to the documentation to learn about using Typekit.', 'Admin', 'cheerup'),
						'type'  => 'text'
					),
						
					array(
						'name' => 'font_charset',
						'label' => esc_html_x('Google Font Charsets', 'Admin', 'cheerup'),
						'value' => array(),
						'type'  => 'checkboxes',
						'options' => array(
							'latin' => 'Latin',
							'latin-ext' => 'Latin Extended',
							'cyrillic'  => 'Cyrillic',
							'cyrillic-ext'  => 'Cyrillic Extended', 
							'greek'  => 'Greek',
							'greek-ext' => 'Greek Extended',
							'vietnamese' => 'Vietnamese'
						),
					),
					
				), // fields	
			), // section
			
		), // sections
	), // panel
	
	array(
		'sections' => array(
			array(
				'id' => 'import-demos',
				'title'  => esc_html_x('Import Demos', 'Admin', 'cheerup'),
				'fields' => array(
					array(
						'name'  => 'import_info',
						'label' => esc_html_x('Import Theme Demos', 'Admin', 'cheerup'),
						'type'  => 'content',
						'text'  => '',
					)
						
				),
			), // section
		
		) // sections
		
	), // panel

	array(
		'sections' => array(
			array(
				'id' => 'performance',
				'title'  => esc_html_x('Performance', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'lazyload_enabled',
						'label' => esc_html_x('LazyLoad Images', 'Admin', 'cheerup'),
						'value' => 0,
						'desc'  => '',
						'type'  => 'checkbox',
					),
						
					array(
						'name'  => 'lazyload_type',
						'label' => esc_html_x('Lazy Loader Type', 'Admin', 'cheerup'),
						'value' => 'normal',
						'desc'  => '',
						'type'  => 'radio',
						'options' => array(
							'normal' => esc_html_x('Normal - Load Images on scroll', 'Admin', 'cheerup'),
							'smart' => esc_html_x('Smart - Preload Images on Desktops', 'Admin', 'cheerup')
						)
					),
						
					array(
						'name'  => 'lazyload_aggressive',
						'label' => esc_html_x('Aggressive Lazy Load', 'Admin', 'cheerup'),
						'value' => 0,
						'desc'  => esc_html_x('By default, only featured images are preloaded. Aggressive enables lazyloading on all sidebar widgets and footer as well.', 'Admin', 'cheerup'),
						'type'  => 'checkbox',
					),
						
					array(
						'name'  => 'perf_additional_sizes',
						'label' => esc_html_x('Generate Extra Image Sizes', 'Admin', 'cheerup'),
						'value' => 0,
						'desc'  => esc_html_x('Create additional image crops for more devices. WARNING: Requires powerful webhost, disable if you get HTTP ERROR on uploading images.', 'Admin', 'cheerup'),
						'type'  => 'checkbox',
					),						
					
				) // fields
			), // section
			
			array(
				'id' => 'reset-customizer',
				'title'  => esc_html_x('Reset Settings', 'Admin', 'cheerup'),
				'fields' => array(
					array(
						'name' => 'reset_customizer',
						'value' => esc_html_x('Reset All Settings', 'Admin', 'cheerup'),
						'desc'  => esc_html_x('Clicking the Reset button will revert all settings in the customizer except for menus, widgets and site identity.', 'Admin', 'cheerup'),
						'type'  => 'button',
						'input_attrs' => array(
							'class' => 'button reset-customizer',
						),
					)
					
				) // fields
			), // section
		
		) // sections
		
	), // panel
		
	array(
		'sections' => array(
			array(
				'id' => 'custom-css',
				'title'  => esc_html_x('Custom CSS', 'Admin', 'cheerup'),
				'fields' => array(
			
					array(
						'name'  => 'css_custom',
						'value' => '',
						'label' => esc_html_x('Custom CSS', 'Admin', 'cheerup'),
						'desc'  => '',
						'type'  => 'textarea',
						'transport' => 'postMessage'
					),
					
				) // fields
			), // section
			
			array(
				'id' => 'reset-customizer',
				'title'  => esc_html_x('Reset Settings', 'Admin', 'cheerup'),
				'fields' => array(
					array(
						'name' => 'reset_customizer',
						'value' => esc_html_x('Reset All Settings', 'Admin', 'cheerup'),
						'desc'  => esc_html_x('Clicking the Reset button will revert all settings in the customizer except for menus, widgets and site identity.', 'Admin', 'cheerup'),
						'type'  => 'button',
						'input_attrs' => array(
							'class' => 'button reset-customizer',
						),
					)
					
				) // fields
			), // section
		
		) // sections
		
	), // panel
	
));