<?php
/**
 * Partial Template: Home Carousel to be shown at top below slider
 */
	
$args = array('posts_per_page' => Bunyad::options()->home_carousel_posts, 'ignore_sticky_posts' => 1);

// Sort posts by liked
if (Bunyad::options()->home_carousel_type == 'liked') {
	$args = array_merge($args, array(
		 'meta_key' => '_sphere_user_likes_count', 'orderby' => 'meta_value'
	));
} 

// Use a tag?
$tags = trim(Bunyad::options()->home_carousel_tag);
if ($tags) {
	$args['tag_slug__in'] = array_map('trim', explode(',', $tags));
}

// Setup the home carousel query
$query = new WP_Query(apply_filters('bunyad_block_query_args', $args, 'carousel'));

if (!$query->have_posts()) {
	return;
}

// Image style - only applies to default style
//if (in_array(Bunyad::options()->predefined_style, array('rovella', 'travel'))) {
//	$image = 'cheerup-list-b';
//}

$image = 'cheerup-carousel';

?>


<?php if (Bunyad::options()->home_carousel_style == 'style-b'): ?>

	<section class="block posts-carousel-b">

		<div class="the-carousel">
		
			<h3 class="block-heading"><span class="title"><?php echo esc_html(Bunyad::options()->home_carousel_title); ?></span></h3>
		
			<div class="posts" data-slides="3">
			
			<?php while ($query->have_posts()): $query->the_post(); ?>
			
				<article class="post">
				
					<a href="<?php the_permalink(); ?>" class="post-link"><?php 
						the_post_thumbnail('cheerup-carousel-b', array('alt' => strip_tags(get_the_title()), 'title' => '')); 
					?></a>
					
					<?php Bunyad::core()->partial('partials/post-meta-b', array('title_class' => 'post-title')); ?>
					
				</article>
			
			<?php endwhile; wp_reset_postdata(); ?>
			
			</div>
			
			<div class="navigate"></div>
		</div>
	</section>

<?php else: ?>

	<?php

	$class = array('block', 'posts-carousel');

	if (Bunyad::options()->home_carousel_sep) {
		$class[] = 'has-sep';
	}

	?>

	<section <?php Bunyad::markup()->attribs('posts-carousel-wrap', array('class' => $class)); ?>>

		<h3 class="block-heading"><span class="title"><?php echo esc_html(Bunyad::options()->home_carousel_title); ?></span></h3>

		<div class="the-carousel">
		
			<div class="posts">
			
			<?php while ($query->have_posts()): $query->the_post(); ?>
			
				<article class="post">
				
					<a href="<?php the_permalink(); ?>" class="post-link"><?php 
						the_post_thumbnail($image, array('alt' => strip_tags(get_the_title()), 'title' => '')); 
					?></a>
					
					<?php get_template_part('partials/post-meta-alt'); ?>
					
				</article>
			
			<?php endwhile; wp_reset_postdata(); ?>
			
			</div>
			
			<div class="navigate"></div>
		</div>
	</section>

<?php endif; ?>