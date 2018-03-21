<?php 
/**
 * Footer template for the site footer
 * 
 * The footer is split into three sections:
 * 
 *  - Upper footer with widgets
 *  - Instagram section
 *  - Copyright and Back to top button
 */

do_action('bunyad_pre_footer');

?>

	<?php 
		/**
		 * Default Light Footer
		 */
		if (!Bunyad::options()->footer_layout): 
	?>

	<footer class="main-footer">

		<?php if (Bunyad::options()->footer_upper && is_active_sidebar('cheerup-footer')): ?>	
		
		<section class="upper-footer">
			<div class="wrap">
				
				<ul class="widgets ts-row cf">
					<?php dynamic_sidebar('cheerup-footer'); ?>
				</ul>

			</div>
		</section>
		
		<?php endif; ?>
		
		
		<?php if (is_active_sidebar('cheerup-instagram')): ?>
		
		<section class="mid-footer cf">
			<?php dynamic_sidebar('cheerup-instagram'); ?>
		</section>
		
		<?php endif; ?>
		

		<?php if (Bunyad::options()->footer_lower): ?>
		
		<section class="lower-footer cf">
			<div class="wrap">
				<p class="copyright"><?php 
					echo do_shortcode(
						wp_kses_post(Bunyad::options()->footer_copyright) 
					); ?>
				</p>
				
				<?php if (Bunyad::options()->footer_back_top): ?>
				<div class="to-top">
					<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i> <?php esc_html_e('Top', 'cheerup'); ?></a>
				</div>
				<?php endif; ?>
			</div>
		</section>
		
		<?php endif; ?>
	
	</footer>
	
	
	<?php 
		/**
		 * Contrast/Dark Footer OR Alternate Footer Style  
		 */
		else: 
		
			get_template_part('partials/footer/layout-' . sanitize_file_name(Bunyad::options()->footer_layout));
		
		endif;
	?>
	
	
</div> <!-- .main-wrap -->



<div class="mobile-menu-container off-canvas">

	<a href="#" class="close"><i class="fa fa-times"></i></a>
	
	<div class="logo">
		<?php Bunyad::get('helpers')->mobile_logo(); ?>
	</div>
	
	<?php if (has_nav_menu('cheerup-mobile')): ?>

		<?php wp_nav_menu(array('container' => '', 'menu_class' => 'mobile-menu', 'theme_location' => 'cheerup-mobile')); ?>

	<?php else: ?>
	
		<ul class="mobile-menu"></ul>

	<?php endif;?>
</div>

<?php wp_footer(); ?>

</body>
</html>