<?php
/**
 * Partial: Common post meta template
 */

// Defaults - can be overriden
extract(array(
	'is_single'   => false,
	'show_title'  => true,
	'title_class' => 'post-title-alt',
	'show_author' => true,
	'enable_cat'  => false,
	'add_class'   => ''
), EXTR_SKIP);

// Post Meta C is not supposed to show category at all, by default
if (!empty($enable_cat)) {
	$show_cat = (isset($show_cat) ? $show_cat : Bunyad::options()->meta_category);
}
else {
	$show_cat = false;
}

$class = array('post-meta', 'post-meta-c', $add_class);

?>
	<div <?php Bunyad::markup()->attribs('post-meta-wrap', array('class' => $class)); ?>>
		
		<?php if ($show_cat): ?>
		
			<span class="cat-label cf">
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
		
		
		<?php if ($show_author): ?>
		
			<span class="post-author"><?php printf(esc_html_x('%sBy%s', 'Post Meta', 'cheerup'), '<span class="by">', '</span> ' . get_the_author_posts_link()); ?></span>
			<span class="meta-sep"></span>
			
		<?php endif;?>
		
		
		<?php if (Bunyad::options()->meta_date): ?>
			<a href="<?php the_permalink(); ?>" class="date-link"><time class="post-date" datetime="<?php 
				echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date()); ?></time></a>
		<?php endif; ?>
		
	<?php /*	
		<?php if (Bunyad::options()->post_comments): ?>
			<span class="comments"><a href="<?php echo esc_url(get_comments_link()); ?>"><?php comments_number(); ?></a></span>
		<?php endif; ?>
	*/ ?>

		
	</div>