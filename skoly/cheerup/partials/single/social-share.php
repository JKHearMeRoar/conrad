<?php
/**
 * Partial: Social Share Counters for Single Page
 */

// Nothing to show?
if (!Bunyad::options()->posts_likes && !Bunyad::options()->single_share) {
	return;
}

?>
		<div class="post-share">
					
			<?php if (Bunyad::options()->single_share): ?>
			
			<div class="post-share-icons cf">
			
				<span class="counters">

					<?php if (Bunyad::options()->posts_likes): ?>
						<?php Bunyad::get('likes')->heart_link(); ?>
					<?php endif; ?>
					
				</span>
			
				<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="link" title="<?php 
					esc_attr_e('Share on Facebook', 'cheerup'); ?>"><i class="fa fa-facebook"></i></a>
					
				<a href="http://twitter.com/home?status=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="link" title="<?php 
					esc_attr_e('Share on Twitter', 'cheerup'); ?>"><i class="fa fa-twitter"></i></a>
					
				<a href="http://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="link" title="<?php 
					esc_attr_e('Share on Google+', 'cheerup'); ?>"><i class="fa fa-google-plus"></i></a>
					
				<a href="http://pinterest.com/pin/create/button/?url=<?php 
					echo urlencode(get_permalink()); ?>&amp;media=<?php echo urlencode(wp_get_attachment_url(get_post_thumbnail_id($post->ID))); 
					?>" target="_blank" class="link" title="<?php esc_attr_e('Share on Pinterest', 'cheerup'); ?>"><i class="fa fa-pinterest-p"></i></a>
					
				<?php 
				/**
				 * A filter to programmatically add more icons
				 */
				do_action('bunyad_post_social_icons'); 
				?>
				
			</div>
			
			<?php endif; ?>
			
		</div>