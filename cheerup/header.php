<?php
/**
 * The template for displaying theme header
 * 
 * Parts: Top bar, Logo, Navigation
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php do_action('bunyad_begin_body'); ?>

<div class="main-wrap">

	<?php
		/**
		 * Determine the current header layout
		 */
		$is_default = (!Bunyad::options()->header_layout OR in_array(Bunyad::options()->header_layout, array('logo-ad', 'full-top', 'alt')));
		
		// Bugfix: Change header class for logo-ad as AdBlock Plus blocks it 
		$header_class = Bunyad::options()->header_layout == 'logo-ad' ? 'logo-left' : Bunyad::options()->header_layout;
		
		// Has full-width background image?
		if (Bunyad::options()->css_header_bg_full) {
			$header_class .= ' has-bg';
		}
		
		if (Bunyad::options()->header_layout == 'alt') {
			$header_class .= ' search-alt';
		}
		
		
	?>

	<?php if ($is_default): // Default header layout with certain variations ?>

	<header id="main-head" class="main-head <?php echo esc_attr($header_class); ?>">
	
		<?php get_template_part('partials/header/top-bar'); ?>
	
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
				
				<?php if (Bunyad::options()->header_layout == 'logo-ad' && Bunyad::options()->header_ad): ?>
				
				<div class="a-right"><?php echo Bunyad::options()->header_ad; ?></div>
				
				<?php endif; ?>
			
			</div>
		</div>
		
	</header> <!-- .main-head -->
	
	<?php else: // Other header layouts with markup changes ?>
	
		<?php get_template_part('partials/header/layout-' . Bunyad::options()->header_layout); ?>
	
	<?php endif; ?>
	
<?php do_action('bunyad_pre_main_content'); ?>
	