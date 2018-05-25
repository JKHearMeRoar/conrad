<?php
/**
 * CheerUp Child Theme functions.php
 *
 * Please refer to cheerup/functions.php about framework setup.
 */

/**
 * Enqueue the GA Tracking code separately for head and body tag
 */

function google_analytics_tracking_code_head(){ ?>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NCSH2JR');</script>
	<!-- End Google Tag Manager -->

<?php }

function google_analytics_tracking_code_body(){ ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NCSH2JR"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

<?php }

// include GA tracking code before the closing head tag
add_action('wp_head', 'google_analytics_tracking_code_head', 1);

// include GA tracking code before the closing body tag
add_action('bunyad_begin_body', 'google_analytics_tracking_code_body', 1);

// include OneSignal Push notification integration
function onesignal_integration_code_head(){ ?>

<link rel="manifest" href="/manifest.json" />
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "38edddb2-398a-4583-9474-7b93f2f31fc7",
    });
  });
</script>

<?php }

add_action('wp_head', 'onesignal_integration_code_head', 5);

// include UTM Tracking for links going to Conrad Eshop
function add_analytics_tracking_to_urls($content) {
	return preg_replace_callback('#(<a.*?href=")([^"]*)("[^>]*?>)#i', function($match) {
		// UTM Settings
		$source = 'blog.conrad.cz';
		$medium = 'blog';
		$content = 'link';
		// Get the queried object and sanitize it
		$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
		// Get the page slug
		$campaign = $current_page->post_name;
		
		$url = preg_replace('/[&?]utm_.+?(&|$)$/','', $match[2]);

		// only target links going outside to conrad.cz and exclude links going to blog
		if (strpos($url, 'conrad.cz') !== false && strpos($url, 'blog.conrad.cz') === false) {
			if (strpos($url, '?') === false) {
				$url .= '?';
			} else {
				$url .= '&';
			}
			
			$url .= 'utm_source=' . $source . '&utm_medium=' . $medium . '&utm_campaign=' . urlencode($campaign) . '&utm_content=' . $content;
			return $match[1] . $url . $match[3];
		}

		return $match[1] . $match[2] . $match[3];
	}, $content);
}

// seperate UTM appending function for Visual Composer due to different formatting
function add_analytics_tracking_to_urls_vc($content) {
	return preg_replace_callback('/(link=\"url:)(.*)(\|title)/', function($match) {
		$source = 'blog.conrad.cz';
		$medium = 'blog';
		$content = 'button';
		// Get the queried object and sanitize it
		$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
		// Get the page slug
		$campaign = $current_page->post_name;
		$url = preg_replace('/[&?]utm_.+?(&|$)$/','', urldecode($match[2]));

		// only target links going outside to conrad.cz and exclude links going to blog
		if (strpos($url, 'conrad.cz') !== false && strpos($url, 'blog.conrad.cz') === false) {
			if (strpos($url, '?') === false) {
				$url .= '?';
			} else {
				$url .= '&';
			}
			
			$url .= 'utm_source=' . $source . '&utm_medium=' . $medium . '&utm_campaign=' . $campaign . '&utm_content=' . $content;
			return $match[1] . urlencode($url) . $match[3];
		}

		return $match[0];
	}, $content);
}

add_filter('the_content', 'add_analytics_tracking_to_urls');
add_filter('the_content', 'add_analytics_tracking_to_urls_vc');

// Add 100x100 thumbnail for newsletter use
add_image_size('newsletter', 100, 100, true);

/**
 * Enqueue the CSS. Please note the CSS order is as follows:
 *
 *  - cheerup/style.css
 *  - cheerup/css/skin-XYZ.css
 *  - cheerup-child/style.css
 *  - Inline Custom CSS from Customize
 */
function my_cheerup_enqueue_parent() {

	wp_enqueue_style(
		'cheerup-core', 
		get_template_directory_uri() . '/style.css', 
		array(), 
		Bunyad::options()->get_config('theme_version')
	);
}

function my_cheerup_enqueue_child() {

	wp_enqueue_style(
		'cheerup-child', 
		get_stylesheet_uri(),
		Bunyad::options()->get_config('theme_version')
	);
}

// Enqueue parent CSS at priority 9 as skin and other CSS generates at priority 10
add_action('wp_enqueue_scripts', 'my_cheerup_enqueue_parent', 9);

// Change 11 to 100 to make it enqueue AFTER Custom CSS from Customize
add_action('wp_enqueue_scripts', 'my_cheerup_enqueue_child', 11);

// Disable parent CSS enqueue
add_filter('bunyad_enqueue_core_css', '__return_false');