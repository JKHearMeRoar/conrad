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

$html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';

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

	if(isset($getCategory) && ($getCategory == "review" || $getCategory == "mix")) {
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
		$num = 2;
	} else {
		$num = 2;
	}

	if($category == "mix") {
		fetchPosts("review", $num);
		// fetchPosts("test", $num);
		// review and test categories were merged
	} else {
		fetchPosts($category, $num);
	}


}

function fetchPosts($category, $num) {

	global $html, $campaign, $fontFamily, $blacklist;
	
	// blog categories by ID
	$categories = array(
		'review' => 78
	);

	// utm settings
	$utmSource = "newsletter";
	$utmMedium = "email";
	$utmCampaign = "btcreviews";

	$utm = '?utm_source=' . $utmSource . '&utm_medium=' . $utmMedium . '&utm_campaign=' . $utmCampaign;

	// arguments for WordPress query
	// https://codex.wordpress.org/Class_Reference/WP_Query
	$args = array(
		'posts_per_page' => $num, 
		'cat' => $categories[$category],
		'post__not_in' => $blacklist
	);

	$html.='<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;"><tr><td bgcolor="#0098dd" align="left" style="padding: 12px 17px 10px 17px; width: 195px;" class="stretch"><a href="https://blog.conrad.cz/'.$utm.'"><img src="https://www.conrad.cz/new/elements/template/conradblog.png" width="121" height="21" style="display: inline-block;" alt="Conrad Blog"/></a></td><td bgcolor="#0098dd" align="left" style="padding: 12px 10px 10px 10px; font-family: Tahoma,Arial,Helvetica,sans-serif; color: #ffffff; font-size: 15px; line-height: 17px;" class="stretch"><strong>Aktuální recenze a testy</strong></td></tr>';

	$q = new WP_Query($args);

	if ($q->have_posts()) {
		while ($q->have_posts()) {
		$q->the_post();        
		    $blacklist[] = get_the_ID();
		    $post_excerpt = preg_replace('/\[.*?\]/','', get_the_excerpt());
		    $url = get_the_permalink().$utm;
		    $html.='
			<tr>
				<td bgcolor="#ffffff" align="left" valign="top" style="padding: 20px 17px 20px 17px; width: 195px;" class="stretch">
					<a href="'.$url.'"><img src="'.get_the_post_thumbnail_url($post->ID, "newsletter170").'" width="170" height="170" alt="'.get_the_title().'" style="display: inline-block;" /></a>
				</td>
				<td bgcolor="#ffffff" align="left" style="padding: 20px 17px 20px 10px; font-family: Tahoma,Arial,Helvetica,sans-serif; color: #ffffff; font-size: 15px; line-height: 17px;" class="stretch">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="2" align="left" style="padding: 0px 0px 5px 0px; font-family: Tahoma,Arial,Helvetica,sans-serif; color: #000000; font-size: 18px; line-height: 20px;">
								<a href="'.$url.'" style="color: #000000; color: #000000 !important; text-decoration: none; text-decoration: none !important;">'.get_the_title().'</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="left" style="padding: 10px 0px 5px 0px; font-family: Tahoma,Arial,Helvetica,sans-serif; color: #232323; font-size: 12px; line-height: 15px;">
								'.$post_excerpt.'
							</td>
						</tr>
						<tr>
							<td align="left" style=" padding: 15px 0px 0px 0px;" class="stretch">
								<!--[if (gte mso 9)|(IE)]> <v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.$url.'" style="height:28px;v-text-anchor:middle;width:115px;" strokecolor="#0098dd" fillcolor="#0098dd"> <w:anchorlock></w:anchorlock> <center style="color:#ffffff;font-family:sans-serif;font-size:12px;font-weight:bold;">Číst více</center> </v:rect> <![endif]--> <a href="'.$url.'" style="background-color:#0098dd;border:1px solid #0098dd;color:#ffffff;display:inline-block;font-family:Tahoma,Arial,Helvetica,sans-serif;font-size:12px;text-decoration:underline;font-weight:bold;line-height:28px;text-align:center;text-decoration:none;width:115px;-webkit-text-size-adjust:none;mso-hide:all;">Číst více</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" bgcolor="#f7f7f7" style="height: 3px; line-height: 3px; font-size: 3px;">
					<img src="https://www.conrad.cz/new/elements/template/spacer.png" width="3" height="3" style="display: inline-block;" alt=""/>
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