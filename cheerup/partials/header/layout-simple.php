<?php
/**
 * Header Layout Style 9: Simple Full Width header
 */
?>

<header id="main-head" class="main-head head-nav-below search-alt simple">

	<div class="inner inner-head" data-sticky-bar="<?php echo esc_attr(Bunyad::options()->topbar_sticky); ?>">
	
		<div class="wrap cf">
		
			<div class="left-contain">
				<span class="mobile-nav"><i class="fa fa-bars"></i></span>	
			
				<span class="title">
				
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
				
				</span>
			
			</div>
				
				
			<div class="navigation-wrap inline">
				<?php if (has_nav_menu('cheerup-main')): ?>
				
				<nav class="navigation inline simple <?php echo esc_attr(Bunyad::options()->nav_style); ?>" data-sticky-bar="<?php echo esc_attr(Bunyad::options()->topbar_sticky); ?>">
					<?php wp_nav_menu(array('theme_location' => 'cheerup-main', 'fallback_cb' => '', 'walker' =>  'Bunyad_Menu_Walker')); ?>
				</nav>
				
				<?php endif; ?>
			</div>
			
			<div class="actions">
			
				<?php 
				
				// Output social icons from paritals/header/social-icons.php if enabled
				Bunyad::core()->partial('partials/header/social-icons', array('social_icons' => true)); 
				
				?>
				
				<?php if (Bunyad::options()->topbar_search): ?>
				
					<a href="#" title="<?php esc_attr_e('Search', 'bunyad'); ?>" class="search-link"><i class="fa fa-search"></i></a>
					
					<div class="search-box-overlay">
						<form method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
						
							<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
							<input type="search" class="search-field" name="s" placeholder="<?php esc_attr_e('Type and press enter', 'cheerup'); ?>" value="<?php 
									echo esc_attr(get_search_query()); ?>" required />
									
						</form>
					</div>
				
				<?php endif; ?>
				
				<?php if (Bunyad::options()->topbar_cart && class_exists('Bunyad_Theme_WooCommerce')): ?>
				
					<div class="cart-action cf">
						<?php echo Bunyad::get('woocommerce')->cart_link(); ?>
					</div>
				
				<?php endif; ?>
			
			</div>

		</div>
	</div>

</header> <!-- .main-head -->