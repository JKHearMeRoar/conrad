<?php
/**
 * The template for displaying product widget entries
 *
 * This template overrides woocommerce/templates/content-widget-product.php.
 * 
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @version 3.3.0
 */

global $product;

?>

<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<span class="image"><?php echo $product->get_image(); // safe html from WooCommerce ?></span>
		<span class="product-title"><?php echo $product->get_name(); ?></span>
	</a>

	<?php if ( ! empty( $show_rating ) ) : ?>
		<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
	<?php endif; ?>

	<?php echo $product->get_price_html(); // safe html from WooCommerce ?>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

</li>

