<?php
/**
 * Partial: Common post meta template
 */

// Defaults - can be overridden
extract(array(
	'is_single'  => false,
	'show_title' => true,
	'show_cat'   => Bunyad::options()->meta_category,
	'show_date'  => Bunyad::options()->meta_date,
	'show_comments' => Bunyad::options()->post_comments,
	'title_class' => 'post-title-alt',
	'add_class'   => ''
), EXTR_SKIP);

$class = array('post-meta', 'post-meta-b', $add_class);

?>
	<div <?php Bunyad::markup()->attribs('post-meta-wrap', array('class' => $class)); ?>>
		
		<?php if ($show_cat): ?>
		
			<span class="post-cat">	
				<span class="text-in"><?php esc_html_e('In', 'cheerup'); ?></span> 
				<?php Bunyad::get('helpers')->meta_cats(); ?>
			</span>
			
		<?php endif; ?>
	
		
		<?php 
			// Show title? Choose heading tag for SEO
			if ($show_title): 
		
				$tag = 'h2';
				if ($is_single) {
					$tag = 'h1';
				}
		?>			
			
			<<?php echo $tag; ?> class="<?php echo esc_attr($title_class); ?>">
				<?php 
				if ($is_single): 
					the_title(); 
				else: ?>
			
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					
				<?php endif; ?>
			</<?php echo $tag; ?>>
			
		<?php endif; ?>
		
		<div class="below">
		
			<?php if ($show_date): ?>
				<a href="<?php the_permalink(); ?>" class="date-link"><time class="post-date" datetime="<?php 
					echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date()); ?></time></a>
			<?php endif; ?>
			
			<span class="meta-sep"></span>
			
			<?php if ($show_comments): ?>
				<span class="comments"><a href="<?php echo esc_url(get_comments_link()); ?>"><?php comments_number(); ?></a></span>
			<?php endif; ?>
		
		</div>
		
	</div>