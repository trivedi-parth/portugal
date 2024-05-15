<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

	<?php
	// Elementor `single` location.
	if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single')) {

		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action('woocommerce_before_single_product_summary');
		?>

		<div class="summary entry-summary">
			<div class="single-product-title-add-to-cart">
				<div> <?php echo woocommerce_template_single_title() ?> </div>

				<div>
					<div class="product-cart-btn-stock"> <?php echo woocommerce_template_single_add_to_cart() ?>
						<p class="stock in-stock"></p>
						<!-- <div class="stock-details"><p>14 vorrätig</p></div> -->
					</div>
				</div>

			</div>
			<div class="single-product-location-details">
				<div class="single-product-title">
					<h3>Stammt aus:</h3>
				</div>
				<?php
                    $location_html = '';
                    $location_terms = get_the_terms($product->get_id(), 'location');
                    if ($location_terms && !is_wp_error($location_terms))
                    {
                        foreach ($location_terms as $term)
                        {
                            $location_color = get_term_meta($term->term_id, 'location_color', true);
                            $location_html .= '<div class="single-location">
                                                <a href="javascript:void(0);" style="border:1px solid '.$location_color.'">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path
                                                            d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" style="fill:'.$location_color.'">
                                                        </path>
                                                    </svg>
                                                    <span>'.$term->name.'</span>
                                                </a>
                                            </div>';
                        }
                        echo $location_html;
                    }
                ?>
			</div>
			<div class="single-product-vendor-details">
				<div class="single-product-title">
					<h3>Produziert von:</h3>
				</div>
				<?php
                    $seller_html = '';
                    $seller_terms = get_the_terms($product->get_id(), 'seller');
                    if ($seller_terms && !is_wp_error($seller_terms))
                    {
                        foreach ($seller_terms as $term)
                        {
                            $sellers_selected_location_color = ''; // Initialize location color variable
                            // Check if the seller term has the custom field "sellers_location"
                            if (get_field('sellers_location', 'seller_' . $term->term_id))
                            {
                                // Get the location color from the custom field
                                $sellers_selected_location_color = get_field('sellers_location', 'seller_' . $term->term_id);
                                // print_r($sellers_selected_location_color);
                            }
                            else
                            {
                                $sellers_selected_location_color = $location_color ; // Default color
                            }
                            $seller_html .= '<div class="single-location">
                                                <a href="javascript:void(0);" style="border:1px solid '.$sellers_selected_location_color.'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path
                                                            d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" style="fill:'.$sellers_selected_location_color.'">
                                                        </path>
                                                    </svg>
                                                    <span>'. $term->name .'</span>
                                                </a>
                                            </div>';
                        }
                        echo $seller_html;
                    }
                ?>
			</div>

			<div class="product-price">
				<?php echo woocommerce_template_single_price() ?>
			</div>

			<div class="product-vat-details">
				<p>
					Enthält 19% MwSt. <br />
					zzgl. Versand, Lieferzeit:
					<?php
                        $delivery_time = '';
                        $delivery_time_terms = get_the_terms($product->get_id(), 'product_delivery_times');
						
                        if ($delivery_time_terms && !is_wp_error($delivery_time_terms)) {
                            foreach ($delivery_time_terms as $index => $term) {
                                $delivery_time .= $term->name;
                                // Add comma if it's not the last term
                                if ($index < count($delivery_time_terms) - 1) {
                                    $delivery_time .= ', ';
                                }
                            }
                            // If delivery time is still empty, set it to "-"
                            if (empty($delivery_time)) {
                                $delivery_time = '-';
                            }
                            echo $delivery_time;
                        } else {
                            echo '-';
                        }
                    ?>
				</p>
			</div>


			<?php

			// print_r($product);
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			// do_action( 'woocommerce_single_product_summary' );
			?>
		</div>

		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action('woocommerce_after_single_product_summary');

	}
	?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>