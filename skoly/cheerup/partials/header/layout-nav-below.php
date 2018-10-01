<?php
/**
 * Header Layout: Navigation Below Logo
 */

$top_bar = (!empty($top_bar) ? $top_bar : 'top-bar');
$classes = (!empty($classes) ? $classes : 'nav-below');

?>

<header id="main-head" class="main-head head-nav-below <?php echo esc_attr($classes); ?>">

<?php 
	// Get Top Bar - top-bar.php or top-bar-b.php depending on setting
	Bunyad::core()->partial(
			'partials/header/' . sanitize_file_name($top_bar), 
			array('navigation' => false, 'social_icons' => true)
	); 
?>
	<div class="inner">
		<div class="wrap logo-wrap cf">
		
			<div class="title">
			
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
				
				<?php if (Bunyad::options()->image_logo): // custom logo ?>
					
					<?php Bunyad::get('helpers')->mobile_logo(); ?>
					
					<img <?php
						/**
						 * Get escaped attributes and add optionally add srcset for retina
						 */ 
						Bunyad::markup()->attribs('image-logo', array(
							'src'    => Bunyad::options()->image_logo,
							'class'  => 'logo-image',
							'alt'    => get_bloginfo('name', 'display'),
							'srcset' => array(Bunyad::options()->image_logo => '', Bunyad::options()->image_logo_2x => '2x')
						)); ?> />

				<?php else: ?>
					
					<span class="text-logo"><?php echo esc_html(get_bloginfo('name', 'display')); ?></span>
					
				<?php endif; ?>
				
				</a>
			
			</div>
	
		</div>
	</div>
	
	<div class="navigation-wrap">
		<?php if (has_nav_menu('cheerup-main')): ?>
		
		<nav class="navigation below <?php echo esc_attr(Bunyad::options()->nav_style); ?>" data-sticky-bar="<?php echo esc_attr(Bunyad::options()->topbar_sticky); ?>">					
			<div class="wrap">
				<?php wp_nav_menu(array('theme_location' => 'cheerup-main', 'fallback_cb' => '', 'walker' =>  'Bunyad_Menu_Walker')); ?>
			</div>
		</nav>
		
		<?php endif; ?>
	</div>
	
</header> <!-- .main-head -->