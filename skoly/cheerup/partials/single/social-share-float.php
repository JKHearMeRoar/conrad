<?php
/**
 * Partial template for Alternate Social share buttons on single page
 */

// Post and media URL
$services = Bunyad::get('social')->share_services();
$active   = array('facebook', 'twitter', 'pinterest', 'email');

$services['pinterest']['icon'] = 'pinterest-p';

?>

<?php if (is_single() && Bunyad::options()->single_share): ?>
	
	<div class="post-share-float cf">
		
		<div class="services">
		
		<?php 
			foreach ($active as $key): 
				$service = $services[$key];
		?>
		
			<a href="<?php echo esc_url($service['url']); ?>" class="cf service <?php echo esc_attr($key); ?>" target="_blank" title="<?php echo esc_attr($service['label'])?>">
				<i class="fa fa-<?php echo esc_attr($service['icon']); ?>"></i>
				<span class="label"><?php echo esc_html($service['label']); ?></span>
			</a>
				
		<?php endforeach; ?>
		
		</div>
		
	</div>
	
<?php endif; ?>