<?php 

/*
 *	Script for generating latest blog posts for newsletters
 *	Author: Jan Kubiče
 */

// load WordPress
define('WP_USE_THEMES', false);
require_once('../wp-blog-header.php'); 

$fontFamily = "'Trebuchet MS', sans-serif";

$html = '
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding-top: 20px;padding-bottom: 20px;padding-right: 20px;">
';

function inputParametersCheck($getCampaign, $getCategory, $getNum) {
	global $campaign, $category, $num;

	// check for passing UTM Campaign parameter

	if(isset($getCampaign)) {
		$campaign = urlencode($getCampaign);
	} else {
		$campaign = "";
	}

	// check for blog post category - if empty, show general
	// expecting edu / mro / rd / ga

	if(isset($getCategory) && ($getCategory == "edu" || $getCategory == "mro" || $getCategory == "rd" || $getCategory == "ga")) {
		$category = $getCategory;
	} else {
		$category = "ga";
	}

	// define how many posts need to be generated
	// expecting number lower or equal then 10 but greater then 0

	if( isset($getNum) && is_numeric($getNum) && $getNum <= 10 && $getNum > 0) {
		$num = $getNum;
	} else {
		$num = 3;
	}

}

function fetchPosts($category, $num) {

	global $html, $campaign, $category, $fontFamily;
	
	// blog categories by ID
	$categories = array(
		'edu' => 8, 
		'mro' => 5, 
		'rd' => 6, 
		'ga' => 74 
	);

	// utm settings
	$utmSource = "newsletter";
	$utmMedium = "email";
	$utmCampain = $campaign;
	$utmContent = "blog-clanky";

	// arguments for WordPress query
	// https://codex.wordpress.org/Class_Reference/WP_Query
	$args = array(
		'posts_per_page' => $num, 
		'cat' => $categories[$category]
	);

	$q = new WP_Query($args);

	if ($q->have_posts()) {
		while ($q->have_posts()) {
		$q->the_post();        
		    $post_excerpt = preg_replace('/\[.*?\]/','', get_the_excerpt());
		    $url = get_the_permalink().'?utm_source=' . $utmSource . '&utm_medium=' . $utmMedium . '&utm_campaign=' . $campaign . '&utm_content=' . $utmContent;
		    $html.='
		    <tr>
				<td width="100" valign="top" margin="0" padding="0">
					<a href="'.$url.'"><img width="100" height="100" src="'.get_the_post_thumbnail_url($post->ID, "newsletter").'" border="0"></a>
				</td>
				<td width="25" margin="0" padding="0"></td>
				<td valign="top" margin="0" padding="0">
					<a href="'.$url.'" style="font-family: '.$fontFamily.';color: #19a8df; text-decoration: none; font-weight: bold; font-size: 18px;">'.get_the_title().'</a>
		            <br /><br />
		            <span style="font-family: '.$fontFamily.';color: #626262; font-size: 14px;">'.$post_excerpt.'</span><br />
		            <p style="text-align: right;"><a href="'.$url.'" style="font-family: '.$fontFamily.';color: #626262; font-size: 14px;text-decoration: none;font-weight: bold;">Přejít na celý článek »</a></p>
		        </td>
			</tr>
			<tr><td colspan="3" style="line-height: 8px; height: 8px; margin: 0px; padding: 0px;"></td></tr>
		    <tr><td colspan="3" style="line-height: 1px; height: 1px; background-color: #d5d5d5; margin: 0px; padding: 0px;"></td></tr>
		    <tr><td colspan="3" style="line-height: 8px; height: 8px; margin: 0px; padding: 0px;"></td></tr>
		    ';
		}
		wp_reset_postdata();
	}

}

inputParametersCheck(htmlspecialchars($_GET["utm_campaign"], ENT_QUOTES), htmlspecialchars($_GET["category"], ENT_QUOTES), htmlspecialchars($_GET["num"], ENT_QUOTES));
fetchPosts($category, $num);

$html.='
</table>
';

echo $html;

?>