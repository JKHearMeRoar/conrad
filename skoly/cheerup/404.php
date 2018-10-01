<?php

/**
 * Default 404 Page
 */


get_header();

?>

<div class="main wrap">
	<div class="ts-row cf">
		<div class="col-12 main-content cf">
	
		<div class="the-post the-page page-404 cf">
		
			<header class="post-title-alt">
				<h1 class="main-heading"><?php esc_html_e('Page Not Found!', 'cheerup'); ?></h1>
			</header>
		
			<div class="post-content error-page row">
				
				<div class="col-3 text-404 main-color"><?php esc_html_e('404', 'cheerup'); ?></div>
				
				<div class="col-8 post-content">
					<p>
					<?php esc_html_e("We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try one of these options:", 'cheerup'); ?>
					</p>
					<ul class="links fa-ul">
						<li> <a href="#" class="go-back"><?php esc_html_e('Go to Previous Page', 'cheerup'); ?></a></li>
						<li> <a href="<?php echo esc_url(home_url()); ?>"><?php esc_html_e('Go to Homepage', 'cheerup'); ?></a></li>
					</ul>
					
					<?php get_search_form(); ?>
				</div>
				
			</div>

		</div>

		</div> <!-- .main-content -->
		
	</div> <!-- .ts-row -->
</div> <!-- .main -->

<?php get_footer(); ?>