<?php
/**
 * Content Template is used for every post format and used on single posts
 * 
 * It is also used on archives called via loop.php
 */

$classes = array('the-post');

// Dynamic style for full-width posts only
if (Bunyad::core()->get_sidebar() == 'none' && Bunyad::posts()->meta('layout_template') == 'dynamic') {
	array_push($classes, 'the-post-modern');
}


/**
 * Content container configs
 */
$content_classes = array('post-content description cf');
$share_float     = Bunyad::options()->single_share_float;

if ($share_float) {
	$content_classes[] = 'has-share-float';
}

?>

<article <?php
	// Setup article attributes
	Bunyad::markup()->attribs('post-wrapper', array(
		'id'        => 'post-' . get_the_ID(),
		'class'     => join(' ', get_post_class($classes)),
	)); ?>>
	
	<header class="post-header the-post-header cf">
			
		<?php 
			Bunyad::helpers()->post_meta(
				'single', 
				array(
					'enable_cat' => 1, 
					'is_single'  => 1,
					'add_class'  => 'the-post-meta'
				)
			); 
		?>

		<?php get_template_part('partials/single/featured'); ?>
		
	</header><!-- .post-header -->


	<div <?php 
		Bunyad::markup()->attribs('post-content', array(
			'class' => $content_classes
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
			echo Bunyad::posts()->excerpt(
				null, 
				Bunyad::options()->post_excerpt_blog, 
				array(
					'force_more' => true, 
					'use_teaser' => true
				)
			);
		
		endif;
		
		?>
			
	</div><!-- .post-content -->

	
	<?php if (is_single()): // Single post ?>
		
	<div class="the-post-foot cf">
	
		<?php 
			wp_link_pages(array(
				'before' => '<div class="page-links post-pagination">', 
				'after' => '</div>', 
				'link_before' => '<span>',
				'link_after' => '</span>'
			));
		?>
		
		<div class="tag-share cf">
		
			<?php if (Bunyad::options()->single_tags): ?>

				<?php the_tags('<div class="post-tags">', '', '</div>'); ?>
			
			<?php endif; ?>
		
			<?php get_template_part('partials/single/social-share'); ?>
				
		</div>
		
	</div>
	
		<?php if (Bunyad::options()->author_box): ?>
		
			<?php get_template_part('partials/author-box'); ?>
			
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

	<?php endif; ?>
	
		
</article> <!-- .the-post -->