<?php
/**
 * Grid posts style used for several loops
 */

extract(array(
	'show_excerpt' => true,
	'show_footer'  => true
), EXTR_SKIP);

$image = 'cheerup-grid';
if ($grid_cols !== 3 && Bunyad::helpers()->relative_width() == 100) {
	$image = 'cheerup-main';
}

if (Bunyad::options()->post_grid_masonry) {
	
	$image = Bunyad::media()->image_size('cheerup-masonry', 'large');
	
	if ($grid_cols !== 3 && Bunyad::helpers()->relative_width() == 100) {
		$image = 'large';
	}
}

?>

<article <?php
	// hreview has to be first class because of rich snippet classes limit 
	Bunyad::markup()->attribs('grid-post-wrapper', array(
		'id'     => 'post-' . get_the_ID(),
		'class'  => array_merge(get_post_class('grid-post'), array($show_excerpt ? 'has-excerpt' : 'no-excerpt')) 
	)); ?>>
	
	<div class="post-header cf">
			
		<div class="post-thumb">
			<a href="<?php echo esc_url(get_permalink()); ?>" class="image-link">
			
				<?php the_post_thumbnail(
					$image,
					array('title' => strip_tags(get_the_title()))
				); ?>
					
				<?php get_template_part('partials/post-format'); ?>
			</a>
			
			<?php Bunyad::helpers()->meta_cat_label(); ?>
		</div>
		
		<div class="meta-title">
		
			<?php Bunyad::helpers()->post_meta('grid'); ?>
		
		</div>
		
	</div><!-- .post-header -->

	<?php if (!empty($show_excerpt)): ?>
	<div class="post-content post-excerpt cf">
		<?php

		// Excerpts or main content?
		echo Bunyad::posts()->excerpt(null, Bunyad::options()->post_excerpt_grid, array('add_more' => false));
		 
		?>
			
	</div><!-- .post-content -->
	<?php endif; ?>
	
	<?php if ($show_footer): ?>
	<div class="post-footer">
		
		<?php get_template_part('partials/content/social-share'); ?>
		
	</div>
	<?php endif; ?>
	
		
</article>
