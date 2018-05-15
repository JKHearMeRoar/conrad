<?php 

/*
 *	Script for generating latest reviews and tests for newsletters
 *	Author: Jan Kubiče
 */

// load WordPress
define('WP_USE_THEMES', false);
require_once('../wp-blog-header.php'); 
// send OK header - otherwise page returns 404 and content scrape is unsuccessful
header("HTTP/1.1 200 OK");

$blacklist = array();

$html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="padding: 10px 0px 10px 0px;"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center"><tr><td style="font-family: Tahoma, sans-serif; font-size: 18px; color: #ffffff; padding: 0px 10px 0px 10px; height: 35px;" bgcolor="#009fda">Aktuální recenze a testy</td></tr></table></td></tr>';

function inputParametersCheck($getCampaign, $getCategory, $getNum) {
	global $campaign, $category, $num;

	// check for passing UTM Campaign parameter

	if(isset($getCampaign)) {
		$campaign = urlencode($getCampaign);
	} else {
		$campaign = "";
	}

	// check for blog post category - if empty, show mix
	// expecting review / test / mix

	if(isset($getCategory) && ($getCategory == "review" || $getCategory == "test" || $getCategory == "mix")) {
		$category = $getCategory;
	} else {
		$category = "mix";
	}

	// define how many posts need to be generated
	// expecting number lower or equal then 10 but greater then 0
	// default value is 2 for specific category or 1 for mixed

	if(isset($getNum) && is_numeric($getNum) && $getNum <= 10 && $getNum > 0) {
		$num = $getNum;
	} elseif((!isset($getNum) || !is_numeric($getNum) || $getNum > 10 || $getNum < 1) && $category == "mix") {
		$num = 1;
	} else {
		$num = 2;
	}

	if($category == "mix") {
		fetchPosts("review", $num);
		fetchPosts("test", $num);
	} else {
		fetchPosts($category, $num);
	}


}

function fetchPosts($category, $num) {

	global $html, $campaign, $fontFamily, $blacklist;
	
	// blog categories by ID
	$categories = array(
		'review' => 77, 
		'test' => 78
	);

	// utm settings
	$utmSource = "newsletter";
	$utmMedium = "email";
	$utmCampaign = "btcreviews";

	// arguments for WordPress query
	// https://codex.wordpress.org/Class_Reference/WP_Query
	$args = array(
		'posts_per_page' => $num, 
		'cat' => $categories[$category],
		'post__not_in' => $blacklist
	);

	$q = new WP_Query($args);

	if ($q->have_posts()) {
		while ($q->have_posts()) {
		$q->the_post();        
		    $blacklist[] = get_the_ID();
		    $post_excerpt = preg_replace('/\[.*?\]/','', get_the_excerpt());
		    $url = get_the_permalink().'?utm_source=' . $utmSource . '&utm_medium=' . $utmMedium . '&utm_campaign=' . $utmCampaign;
		    $html.='
		    <tr>
				<td align="center" style="border-top: 1px solid #dddddd;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
						<tr>
							<td style="padding: 10px 5px 10px 10px;width: 80px;" valign="top" align="center">
								<a href="'.$url.'"><img width="80" height="80" src="'.get_the_post_thumbnail_url($post->ID, "newsletter").'" border="0" alt="" style="display: inline-block;"></a>
							</td>
							<td style="padding: 10px 10px 10px 5px; font-family: Tahoma, sans-serif; font-size: 11px; line-height: 15px; color: #000000;" align="left">
								<a href="'.$url.'" style="color: #0098dd; color: #0098dd !important;">'.get_the_title().'</a><br/><br/>
								'.$post_excerpt.'<br/><br/>
								<a href="'.$url.'" style="color: #0098dd; color: #0098dd !important;">Pokračovat ve čtení &raquo;</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		    ';
		}
		wp_reset_postdata();
	}

}

inputParametersCheck(htmlspecialchars($_GET["utm_campaign"], ENT_QUOTES), htmlspecialchars($_GET["category"], ENT_QUOTES), htmlspecialchars($_GET["num"], ENT_QUOTES));

$html.='
</table>
';

echo $html;

?>