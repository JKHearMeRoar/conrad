<?php 
/**
 * Partial: Post content part of the layout
 */

extract(array(
	'author_box'   => 'partials/author-box',
	'share_float' => Bunyad::options()->single_share_float,
), EXTR_SKIP);


$classes = array('post-content description cf');

if ($share_float) {
	$classes[] = 'has-share-float';
}

?>
		<div <?php 
			Bunyad::markup()->attribs('post-content', array(
				'class' => $classes,
			)); 
			?>>
			
			<?php if ($share_float): ?>
				<?php get_template_part('partials/single/social-share-float'); ?>
			<?php endif; ?>
			
			
			<?php
	
			// Excerpts or main content?
			if (is_single() OR Bunyad::options()->post_body == 'full'):
	
				/**
				 * A wrapper for the_content() for some of our magic.
				 * 
				 * Note: the_content filter is applied.
				 * 
				 * @see the_content()
				 */
				Bunyad::posts()->the_content(null, false);
				
			else:
			
				// Show the excerpt,  always add Keep Reading button (more button), and respect <!--more--> (teaser) 
				echo Bunyad::posts()->excerpt(null, Bunyad::options()->post_excerpt_blog, array('force_more' => true, 'use_teaser' => true));
			
			endif;
			
			?>
				
		</div><!-- .post-content -->
		
		<div class="the-post-foot cf">
		
			<?php 
				wp_link_pages(array(
					'before' => '<div class="page-links post-pagination">', 
					'after' => '</div>', 
					'link_before' => '<span>',
					'link_after' => '</span>'
				));
			?>
			
			<?php if (has_tag() && Bunyad::options()->single_tags): ?>
			
			<div class="tag-share cf">
						
				<?php the_tags('<div class="post-tags">', '', '</div>'); ?>
				
				<?php get_template_part('partials/single/social-share'); ?>
					
			</div>
			
			<?php endif; ?>
			
		</div>
		
		<?php if (Bunyad::options()->author_box): ?>
		
			<?php get_template_part($author_box); ?>
			
		<?php endif; ?>
		
		
		<?php

		if (Bunyad::options()->single_navigation):
			get_template_part('partials/single/post-navigation');
		endif;

		?>
		
		<?php get_template_part('partials/single/related-posts'); ?>
		
		<div class="comments">
			<?php comments_template('', true); ?>
		</div>