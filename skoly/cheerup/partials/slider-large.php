<?php
/**
 * Partial: Slider for the featured area
 */

$attrs = array(
	'class'          => 'slides',
	'data-slider'    => 'large',
	'data-autoplay'  => Bunyad::options()->slider_autoplay,
	'data-speed'     => Bunyad::options()->slider_delay,
	'data-animation' => Bunyad::options()->slider_animation,
	'data-parallax'  => Bunyad::options()->slider_parallax
);

$image = Bunyad::media()->image_size('cheerup-large-cover', 'full');

?>
	
	<section class="common-slider large-slider">
	
		<div <?php Bunyad::markup()->attribs('slider-slides', $attrs); ?>>
		
			<?php while ($query->have_posts()): $query->the_post(); ?>
		
				<div class="item">
					<a href="<?php the_permalink(); ?>"><?php 
						the_post_thumbnail($image, array('alt' => strip_tags(get_the_title()), 'title' => '', 'sizes' => '100vw')); 
					?></a>
					
					<div class="overlay cf">
					
						<span class="category"><?php Bunyad::get('helpers')->meta_cats(); ?></span>
						
						<h2 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						
						<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Continue Reading', 'cheerup'); ?></a>
						
					</div>
					
				</div>
				
			<?php endwhile; ?>
		</div>

	</section>
	
	<?php wp_reset_postdata(); ?>