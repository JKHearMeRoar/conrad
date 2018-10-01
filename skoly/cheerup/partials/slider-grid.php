<?php
/**
 * Partial: Grid Slider for the featured area
 */

$attrs = array(
	'class'          => 'slides wrap',
	'data-slider'    => 'grid',
	'data-autoplay'  => Bunyad::options()->slider_autoplay,
	'data-speed'     => Bunyad::options()->slider_delay,
//	'data-animation' => Bunyad::options()->slider_animation,
	'data-parallax'  => Bunyad::options()->slider_parallax
);

// Number of slides
$slides = 1;

if ($query->post_count) {
	$slides = ceil($query->post_count / 3);
}

$count = 1;

?>
	
	<section class="common-slider grid-slider">
	
		<div <?php Bunyad::markup()->attribs('slider-slides', $attrs); ?>>
		
			<?php while ($count <= $slides): $count++; ?>
		
				<div class="item">
				
				<?php 
					$i = $is_large = 0;
					while ($query->have_posts()): $query->the_post(); 
						$i++;
						
						$class = 'item-small';
						$image = 'cheerup-slider-grid-sm';
						
						if ($i == 1) {
							$is_large = true;
							$class = 'item-large';
							$image = 'cheerup-slider-grid';
						}
				?>
					
					<div class="<?php echo esc_attr($class); ?>">
						<div class="inner">
							<a href="<?php the_permalink(); ?>" class="image-link"><?php 
								the_post_thumbnail($image, array('alt' => strip_tags(get_the_title()), 'title' => '')); 
							?></a>
							
							<div class="overlay">
								<?php Bunyad::get('helpers')->meta_cats(); ?>
								
								<h2 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									
							</div>
						</div>
							
					</div>
								
					<?php 
						// 3 Items per slide
						if ($i === 3):
							break;
						endif;
					?>
					
				<?php endwhile; ?>
					
				</div>
				
			<?php endwhile; ?>
		</div>

	</section>
	
	<?php wp_reset_postdata(); ?>