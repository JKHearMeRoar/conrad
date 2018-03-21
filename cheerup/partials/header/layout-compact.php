<?php
/**
 * Header Layout Style 8: Top Bar + Compact Header
 */
?>

<header id="main-head" class="main-head head-nav-below search-alt compact">

	<?php Bunyad::core()->partial('partials/header/top-bar-b', array('search_icon' => true)); ?>

	<div class="inner inner-head" data-sticky-bar="<?php echo esc_attr(Bunyad::options()->topbar_sticky); ?>">	
		<div class="wrap cf">
		
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
				
				
			<div class="navigation-wrap inline">
				<?php if (has_nav_menu('cheerup-main')): ?>
				
				<nav class="navigation inline <?php echo esc_attr(Bunyad::options()->nav_style); ?>" data-sticky-bar="<?php echo esc_attr(Bunyad::options()->topbar_sticky); ?>">
					<?php wp_nav_menu(array('theme_location' => 'cheerup-main', 'fallback_cb' => '', 'walker' =>  'Bunyad_Menu_Walker')); ?>
				</nav>
				
				<?php endif; ?>
			</div>
			
		</div>
	</div>

</header> <!-- .main-head -->

<?php if (Bunyad::options()->header_ad): ?>

<div class="widget-a-wrap">
	<div class="the-wrap head">
		<?php echo Bunyad::options()->header_ad; ?>
	</div>
</div>

<?php endif; ?>