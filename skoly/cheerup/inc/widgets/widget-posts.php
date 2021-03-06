<?php
/**
 * Widget to show posts in a list format in sidebar
 */
class Bunyad_Posts_Widget extends WP_Widget
{
	/**
	 * Setup the widget
	 * 
	 * @see WP_Widget::__construct()
	 */
	public function __construct()
	{
		parent::__construct(
			'bunyad-posts-widget',
			esc_html_x('Cheerup - Posts List', 'Admin', 'cheerup'),
			array('description' => esc_html_x('Popular Posts/Latest Posts widget for sidebar.', 'Admin', 'cheerup'), 'classname' => 'widget-posts')
		);
	}
	
	/**
	 * Widget output 
	 * 
	 * @see WP_Widget::widget()
	 */
	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		
		// Setup the query
		$query_args  = array('posts_per_page' => $instance['number'], 'ignore_sticky_posts' => 1);
		
		// Popular by comments
		if ($instance['type'] == 'popular') {
			$query_args = array_merge($query_args, array('orderby' => 'comment_count'));
		}
		
		// Most liked
		if ($instance['type'] == 'liked') {
			$query_args = array_merge($query_args, array(
		 		'meta_key' => '_sphere_user_likes_count', 'orderby' => 'meta_value_num'
			));
		}
		
		// Most Viewed (WP-PostViews plugin)
		if ($instance['type'] == 'views') {
			$query_args = array_merge($query_args, array(
				'meta_key' => 'views', 
				'orderby' => 'meta_value_num', 
				'order' => 'DESC'
			));
		}
		
		// Limited by tag?
		if (!empty($instance['limit_tag'])) {
			$query_args = array_merge($query_args, array('tag' => $instance['limit_tag']));
		}
		
		$query = new WP_Query(apply_filters('bunyad_widget_posts_query_args', $query_args));		
		$style = (!empty($instance['style']) ? $instance['style'] : '');
		$image = 'cheerup-thumb';
		
		// Default to showing category - for backward compatibility
		// meta_cat was true by default prior to version 4.0
		$meta_cat = (!array_key_exists('meta_cat', $instance) ? true : $instance['meta_cat']);
		$meta_date = (!array_key_exists('meta_date', $instance) ? true : $instance['meta_date']);
		
		if ($style == 'large') {
			$image = 'cheerup-thumb-alt';
		}
		
		?>

		<?php echo $args['before_widget']; ?>
		
			<?php if (!empty($title)): ?>
				
				<?php
					echo $args['before_title'] . esc_html($title) . $args['after_title']; // before_title/after_title are built-in WordPress sanitized
				?>
				
			<?php endif; ?>
			
			<ul class="posts cf<?php echo esc_attr(!empty($style) ? ' ' . $style : ''); ?>">
			<?php  while ($query->have_posts()) : $query->the_post(); ?>
			
				<?php if ($style == 'full'): // Full-width image post style?>
				
				<li class="post cf">
					<article <?php post_class('grid-post'); ?>>
							
						<div class="post-header">
							<div class="post-thumb">
								<a href="<?php the_permalink(); ?>" class="image-link">
									<?php 
										the_post_thumbnail(
											'cheerup-grid',
											array('title' => strip_tags(get_the_title()))
										); 
									?>
								</a>
								
								<span class="counter"></span>
							</div>
							
							
							<div class="meta-title">
								<?php Bunyad::get('helpers')->post_meta('grid'); ?>
							</div>
						</div>
						
						<?php if (!empty($instance['excerpt'])): // Show excerpt? ?>
							
							<div class="post-content post-excerpt cf">
							<?php
								// Excerpt
								echo Bunyad::posts()->excerpt(null, Bunyad::options()->post_excerpt_grid, array('add_more' => false));
							?>
							</div>
							
						<?php endif; ?>
			
					</article>
				</li>
				
				<?php else: ?>
				
				<li class="post cf">
				
					<a href="<?php the_permalink() ?>" class="image-link">
						<?php 
							the_post_thumbnail(	
								$image, 
								array('title' => strip_tags(get_the_title())
							)); 
						?>
					</a>
					
					<div class="content">
						
						<?php if (empty($style)): ?>
							<?php Bunyad::core()->partial('partials/post-meta', array('show_title' => false, 'show_cat' => $meta_cat, 'show_date' => $meta_date)); ?>
						<?php endif; ?>
					
					
						<a href="<?php the_permalink(); ?>" class="post-title<?php echo (!empty($instance['trim_title']) ? ' limit-line' : ''); 
							?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						
							
						<?php if ($style == 'meta-below' OR $style == 'large'): ?>
							<?php Bunyad::core()->partial('partials/post-meta', array('show_title' => false, 'show_cat' => $meta_cat, 'show_date' => $meta_date)); ?>
						<?php endif; ?>
						
							
						<?php if (!empty($instance['excerpt'])): // show excerpt? ?>
						
							<div class="excerpt"><?php echo Bunyad::posts()->excerpt(null, 15, array('add_more' => false)); ?></div>
						
						<?php endif;?>
						
					</div>
				
				</li>
				
				<?php endif; ?>
				
			<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		
		<?php echo $args['after_widget']; ?>
		
		<?php
	}
	
	/**
	 * Save widget
	 * 
	 * Strip out all HTML using wp_kses
	 * 
	 * @see wp_filter_post_kses()
	 */
	public function update($new, $old)
	{
		foreach ($new as $key => $val) {
			$new[$key] = wp_kses_post($val);
		}
		
		$new['excerpt'] = !empty($new['excerpt']) ? 1 : 0;
		$new['meta_cat'] = !empty($new['meta_cat']) ? 1 : 0;
		$new['meta_date'] = !empty($new['meta_date']) ? 1 : 0;
		
		return $new;
	}
	
	/**
	 * The widget form
	 */
	public function form($instance)
	{
		$defaults = array(
			'title'      => '', 
			'type'       => '', 
			'number'     => 4, 
			'style'      => 'meta-below', 
			'excerpt'    => 0, 
			'trim_title' => 0,
			'meta_cat'   => 0, 
			'meta_date'  => 1,
			'limit_tag'  => ''
		);
		
		$instance = array_merge($defaults, (array) $instance);
		extract($instance);
		
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_html_x('Title:', 'Admin', 'cheerup'); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('type')); ?>"><?php echo esc_html_x('Sorting:', 'Admin', 'cheerup'); ?></label>
			
			<select id="<?php echo esc_attr($this->get_field_id('type')); ?>" name="<?php echo esc_attr($this->get_field_name('type')); ?>" class="widefat">
				<option value="" <?php selected($type, ''); ?>><?php echo esc_html_x('Latest Posts', 'Admin', 'cheerup') ?></option>
				<option value="popular" <?php selected($type, 'popular'); ?>><?php echo esc_html_x('Most Commented', 'Admin', 'cheerup'); ?></option>
				<option value="liked" <?php selected($type, 'liked'); ?>><?php echo esc_html_x('Most Liked', 'Admin', 'cheerup'); ?></option>
				
				<?php if (function_exists('get_most_viewed')): ?>
					<option value="views" <?php selected($type, 'views'); ?>><?php echo esc_html_x('By Views (WP-PostViews Plugin)', 'Admin', 'cheerup'); ?></option>
				<?php endif; ?>
				
			</select>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php echo esc_html_x('Number of posts to show:', 'Admin', 'cheerup'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('style')); ?>"><?php echo esc_html_x('Style:', 'Admin', 'cheerup'); ?></label>
			
			<select id="<?php echo esc_attr($this->get_field_id('style')); ?>" name="<?php echo esc_attr($this->get_field_name('style')); ?>" class="widefat">
				<option value="" <?php selected($style, ''); ?>><?php echo esc_html_x('Default - Meta Above', 'Admin', 'cheerup'); ?></option>
				<option value="meta-below" <?php selected($style, 'meta-below'); ?>><?php echo esc_html_x('Default - Meta Below', 'Admin', 'cheerup'); ?></option>
				<option value="large" <?php selected($style, 'large'); ?>><?php echo esc_html_x('Alternate - Larger Image & Meta', 'Admin', 'cheerup'); ?></option>
				<option value="full" <?php selected($style, 'full'); ?>><?php echo esc_html_x('Full Width Image & Large Title', 'Admin', 'cheerup'); ?></option>
			</select>
			
		</p>
		
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('limit_tag')); ?>"><?php echo esc_html_x('From this Tag (Optional):', 'Admin', 'cheerup'); ?></label>
			
			<input id="<?php echo esc_attr($this->get_field_id('limit_tag')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('limit_tag')); ?>" type="text" class="widefat" value="<?php echo esc_attr($limit_tag); ?>" />
		</p>
	
		<p>
			<input id="<?php echo esc_attr($this->get_field_id('excerpt')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('excerpt')); ?>" type="checkbox" class="checkbox" <?php checked($excerpt); ?> />
				
			<label for="<?php echo esc_attr($this->get_field_id('excerpt')); ?>"><?php echo esc_html_x('Show Excerpt', 'Admin', 'cheerup'); ?></label>
		</p>
		
		<p>
			<input id="<?php echo esc_attr($this->get_field_id('meta_cat')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('meta_cat')); ?>" type="checkbox" class="checkbox" <?php checked($meta_cat); ?> />
				
			<label for="<?php echo esc_attr($this->get_field_id('meta_cat')); ?>"><?php echo esc_html_x('Show Category', 'Admin', 'cheerup'); ?></label>
		</p>
		
		
		<p>
			<input id="<?php echo esc_attr($this->get_field_id('meta_date')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('meta_date')); ?>" type="checkbox" class="checkbox" <?php checked($meta_date); ?> />
				
			<label for="<?php echo esc_attr($this->get_field_id('meta_date')); ?>"><?php echo esc_html_x('Show Date', 'Admin', 'cheerup'); ?></label>
		</p>
		
		<p>
			<input id="<?php echo esc_attr($this->get_field_id('trim_title')); ?>" name="<?php 
				echo esc_attr($this->get_field_name('trim_title')); ?>" type="checkbox" class="checkbox" value="1" <?php checked($trim_title); ?> />
				
			<label for="<?php echo esc_attr($this->get_field_id('trim_title')); ?>"><?php echo esc_html_x('Limit Title to One Line', 'Admin', 'cheerup'); ?></label>
		</p>
	
		<?php
	}
}