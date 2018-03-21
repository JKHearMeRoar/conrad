<?php
/**
 * Partial: Social Share Buttons for Archives
 */

// External options
$options = array_merge(
	array(
		'heart' => Bunyad::options()->posts_likes,  
		'share' => 1
	),
	(!empty($options) ? $options : array())
);

?>

<?php if ($options['share']): ?>	
	
	<ul class="social-share">
		
		<?php if ($options['heart']): ?>
			<li><?php Bunyad::get('likes')->heart_link(); ?></li>
		<?php endif; ?>
		
		<li>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="fa fa-facebook" target="_blank" title="<?php 
				esc_attr_e('Share on Facebook', 'cheerup'); ?>"></a>
		</li>
		
		<li>
			<a href="http://twitter.com/home?status=<?php echo urlencode(get_permalink()); ?>" class="fa fa-twitter" target="_blank" title="<?php 
				esc_attr_e('Share on Twitter', 'cheerup'); ?>"></a>
		</li>
		
		<li>
			<a href="http://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" class="fa fa-google-plus" target="_blank" title="<?php 
				esc_attr_e('Share on Google+', 'cheerup'); ?>"></a>
		</li>
		
		<li>
			<a href="http://pinterest.com/pin/create/button/?url=<?php 
				echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode(wp_get_attachment_url(get_post_thumbnail_id($post->ID))); 
				?>" class="fa fa-pinterest-p" target="_blank" title="<?php esc_attr_e('Share on Pinterest', 'cheerup'); ?>"></a>
		</li>

		<?php 
		/**
		 * A filter to programmatically add more share links
		 * 
		 * @param string 'archive' value denotes its an archive
		 */
		do_action('bunyad_post_social_icons', 'archive'); 
		?>

	</ul>

<?php endif; ?>
