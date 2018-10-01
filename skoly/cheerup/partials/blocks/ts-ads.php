<?php
/**
 * Call CheerUo Advertisement widget
 */

if (!empty($code)) {
	$atts['ad_code'] =  rawurldecode(base64_decode($code));
}

$type = 'Bunyad_Ads_Widget';
$args = array();

?>

<div class="block">
	<?php the_widget($type, $atts, $args); ?>
</div>

