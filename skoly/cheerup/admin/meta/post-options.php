<?php
/**
 * Meta box for post options
 */

$options = array(
	array(
		'label' => esc_html_x('Layout Style', 'Admin', 'cheerup'),
		'name'  => 'layout_style', // will be _bunyad_layout_style
		'desc'  => esc_html_x('Default uses the site-wide general layout setting set in Appearance > Customize.', 'Admin', 'cheerup'),
		'type'  => 'radio',
		'options' => array(
			'' => esc_html_x('Default', 'Admin', 'cheerup'),
			'right' => esc_html_x('Right Sidebar', 'Admin', 'cheerup'),
			'full' => esc_html_x('Full Width', 'Admin', 'cheerup')),
		'value' => '' // default
	),
	
	array(
		'label' => esc_html_x('Post Style', 'Admin', 'cheerup'),
		'name'  => 'layout_template', // will be _bunyad_featured_slider
		'desc'  => esc_html_x('Default uses the global settings set in Appearance > Customize', 'Admin', 'cheerup'),
		'type'  => 'radio',
		'options' => array(
			''  => esc_html_x('Default', 'Admin', 'cheerup'),
			'creative' => esc_html_x('Creative - Large Style', 'Admin', 'cheerup'),
			'cover' => esc_html_x('Creative - Overlay Style ', 'Admin', 'cheerup'),
			'dynamic'  => esc_html_x('Dynamic (Affects Full Width Layout Only)', 'Admin', 'cheerup'),
			'classic'  => esc_html_x('Classic', 'Admin', 'cheerup'),
			'magazine' => esc_html_x('Magazine/News Style', 'Admin', 'cheerup'),
		),
		'value' => '' // default
	),
		
	array(
		'label' => esc_html_x('Sub Title', 'Admin', 'cheerup'),
		'name'  => 'sub_title',
		'type'  => 'text',
		'input_size' => 90,
		'desc' => esc_html_x('Optional Sub-title/text thats displayed below main post title.', 'Admin', 'cheerup')
	),
	
	array(
		'label' => esc_html_x('Primary Category', 'Admin', 'cheerup'),
		'name'  => 'cat_label',
		'type'  => 'html',
		'html' =>  wp_dropdown_categories(array(
			'show_option_all' => esc_html_x('-- Auto Detect--', 'Admin', 'cheerup'), 
			'hierarchical' => 1, 'order_by' => 'name', 'class' => '', 
			'name' => '_bunyad_cat_label', 'echo' => false,
			'selected' => Bunyad::posts()->meta('cat_label')
		)),
		'desc' => esc_html_x('When you have multiple categories for a post, auto detection chooses one in alphabetical order. This setting is used for selecting the correct category in post meta.', 'Admin', 'cheerup')
	),
		
	array(
		'label_left' => esc_html_x('Disable Featured?', 'Admin', 'cheerup'),
		'label' => esc_html_x('Do not show featured Image, Video, or Gallery at the top for this post, on post page.', 'Admin', 'cheerup'),
		'name'  => 'featured_disable', // _bunyad_featured_post
		'type'  => 'checkbox',
		'value' => 0
	),

	array(
		'label' => esc_html_x('Featured Video/Audio Link', 'Admin', 'cheerup'),
		'name'  => 'featured_video', 
		'type'  => 'text',
		'input_size' => 90,
		'value' => '',
		'desc'  => esc_html_x('When using Video or Audio post format, enter a link of the video or audio from a service like YouTube, Vimeo, SoundCloud. ', 'Admin', 'cheerup'),
	),
);

$options = $this->options($options);

?>

<div class="bunyad-meta cf">

	<input type="hidden" name="bunyad_meta_box" value="post">

<?php foreach ($options as $element): ?> 
	
	<div class="option <?php echo esc_attr($element['name']); ?>">
		<span class="label"><?php echo esc_html(isset($element['label_left']) ? $element['label_left'] : $element['label']); ?></span>
		<span class="field">

			<?php echo $this->render($element); // Bunyad_Admin_OptionRenderer::render() ?>
		
			<?php if (!empty($element['desc'])): ?>
			
			<p class="description"><?php echo esc_html($element['desc']); ?></p>
		
			<?php endif;?>
		
		</span>
	</div>
	
<?php endforeach; ?>

</div>


<script>
/**
 * Conditional show/hide 
 */
jQuery(function($) {
	$('[name=_bunyad_layout_template]').on('change', function() {

		if ($(this).filter(':checked').val() == 'magazine') {
			$('._bunyad_sub_title').show();
		}
		else {
			$('._bunyad_sub_title').hide();
		}

		return;
	})
	 .trigger('change');
		
});
</script>