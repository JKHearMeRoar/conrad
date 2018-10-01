<?php

/**
 * Determine the listing style to use
 */
if (empty($type) OR $type == 'loop-default') {
	$type = Bunyad::options()->category_loop;
}

// loop template
$template = empty($type) ? 'loop' : $type;

/**
 * Process the block and setup the query
 * 
 * @var array  $atts  Shortcode attribs by Bunyad_Theme_ShortCodes::_render()
 * @var string $tag   Shortcode used, example: highlights
 * 
 * @see Bunyad_ShortCodes::__call()
 */
$block = new Bunyad_Theme_Block($atts, $tag);
$query = $block->process()->query;


?>

	<section <?php Bunyad::markup()->attribs('blog-block', array('class' => array('cf block', $tag), 'data-id' => $block->block_id)); ?>>
	
		<?php echo $block->output_heading(); ?>
		
		<div class="block-content">
		<?php
		
			// Get our loop template with include to preserve local variable scope
			$data = compact('block', 'query', 'atts', 'grid_cols', 'pagination', 'pagination_type', 'show_excerpt', 'show_footer');
			Bunyad::get('helpers')->loop($template, $data);
		
		?>
		</div>
	
	</section>

<?php wp_reset_postdata(); ?>