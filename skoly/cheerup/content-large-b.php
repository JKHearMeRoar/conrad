<?php
/**
 * Content template to be used for large posts in listings - Style 2 for large posts
 */

?>

<article <?php
	// Setup article attributes
	Bunyad::markup()->attribs('large-post-wrapper', array(
		'id'     => 'post-' . get_the_ID(),
		'class'  => join(' ', get_post_class('post-main large-post large-post-b')), 
	)); ?>>
	
	<header class="post-header cf">

		<?php Bunyad::get('helpers')->post_meta(null, array('enable_cat' => true)); ?>

		<?php get_template_part('partials/content/featured'); ?>
		
	</header><!-- .post-header -->

	<div <?php Bunyad::markup()->attribs('post-content', array('class' => 'post-content description cf')); ?>>
		
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
			Bunyad::posts()->the_content(null, true);
			
		else:
		
			// Show the excerpt,  always add Keep Reading button (more button), and respect <!--more--> (teaser) 
			echo Bunyad::posts()->excerpt(null, Bunyad::options()->post_excerpt_blog, array('add_more' => false, 'use_teaser' => true));
		
		endif;
		
		?>
		
		<?php if (Bunyad::options()->post_footer_read_more): ?>
		
			<div class="read-more"><a href="<?php the_permalink(); ?>"><span><?php echo esc_html(Bunyad::posts()->more_text); ?></span></a></div>
			
		<?php endif; ?>
			
	</div><!-- .post-content -->
	
	
	<?php if (Bunyad::options()->post_footer_blog): ?>
			
	<div class="post-footer">
	
		<?php if (Bunyad::options()->post_footer_author): ?>
		
			<div class="col col-6 author"><?php printf(esc_html_x('%1$sBy%2$s %3$s', 'Post Meta', 'cheerup'), '<span>', '</span>', get_the_author_posts_link()); ?></div>
			
		<?php endif; ?>
		
		
		<?php if (Bunyad::options()->post_footer_social): ?>
			<div class="col col-6 social-icons">
		
			<?php get_template_part('partials/content/social-share'); ?>
		
			</div>
		<?php endif; ?>
		
	</div>
	
	<?php endif; ?>
		
</article>
