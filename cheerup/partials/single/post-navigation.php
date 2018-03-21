<?php
/**
 * Partial: Post navigation for single
 */

?>

<div class="post-nav">

<?php
	/**
	 * Previous Post
	 */
	$previous = get_previous_post();
	if (!empty($previous)):
		setup_postdata($post = $previous);
?>

	<div class="post previous cf">
		<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Prev Post', 'cheerup'); ?>" class="nav-icon">
			<i class="fa fa-angle-left"></i>
		</a>
		
		<span class="content">
			
			<a href="<?php the_permalink(); ?>" class="image-link">
				<?php the_post_thumbnail('thumbnail'); ?>
			</a>
			
			<div class="post-meta">
				<span class="label"><?php esc_html_e('Prev Post', 'cheerup'); ?></span>
			
				<?php 
					Bunyad::core()->partial(
						'partials/post-meta-b', 
						array('show_cat' => false, 'show_comments' => false, 'title_class' => 'post-title')
					); 
				?>
			</div>
		</span>
	</div>
		
	
<?php
		wp_reset_postdata(); 
	endif; 
		
?>

<?php

	$next = get_next_post();
	if (!empty($next)):
		setup_postdata($post = $next);
?>

	<div class="post next cf">
		<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Next Post', 'cheerup'); ?>" class="nav-icon">
			<i class="fa fa-angle-right"></i>
		</a>
		
		<span class="content">
			
			<a href="<?php the_permalink(); ?>" class="image-link">
				<?php the_post_thumbnail('thumbnail'); ?>
			</a>
			
			<div class="post-meta">
				<span class="label"><?php esc_html_e('Next Post', 'cheerup'); ?></span>
				
				<?php 
					Bunyad::core()->partial(
						'partials/post-meta-b', 
						array('show_cat' => false, 'show_comments' => false, 'title_class' => 'post-title')
					); 
				?>
			</div>
		</span>
	</div>
		
	
<?php
		wp_reset_postdata(); 
	endif; 
		
?>
</div>