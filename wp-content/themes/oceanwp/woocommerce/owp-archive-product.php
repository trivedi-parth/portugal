<?php
/**
 * Archive product template.
 *
 * @package OceanWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product, $post;

// Get price and Add to Cart button conditional display state.
$ocean_woo_cond = get_theme_mod( 'ocean_shop_conditional', false );

// Conditional vars.
$show_woo_cond = '';
$show_woo_cond = ( is_user_logged_in() && true === $ocean_woo_cond );

// Get links conditional mod.
$ocean_woo_disable_links = get_theme_mod( 'ocean_shop_woo_disable_links', false );
$ocean_woo_disable_links_cond = get_theme_mod( 'ocean_shop_woo_disable_links_cond', 'no' );

$disable_links = '';
$disable_links = ( true === $ocean_woo_disable_links && 'yes' === $ocean_woo_disable_links_cond );

/**
 * Display shop and product archive items
 */
do_action( 'ocean_before_archive_product_item' );
$elements = oceanwp_woo_product_elements_positioning();
// print_r($product);

// Get categories for the product
$categories = get_the_terms($product->get_id(), 'product_cat');
$category_links = array();
if ($categories) {
	foreach ($categories as $category) {
		$category_links[] = '<a href="' . get_term_link($category) . '">' . $category->name . '</a>';
	}
}

// Generate HTML for category links
$category_links_html = '';
if (!empty($category_links)) {
	$category_links_html = '<div class="category-main">' . implode(', ', $category_links) . '</div>';
}

// Get product image URL
$image_url = wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_single');



$product_html = '';

	// Generate HTML for product
	$product_html.= '<div class="card">
						<div class="card-body">
							<div class="card-text">
								<p>' . implode(', ', $category_links) . '</p>
								<h3 class="product-name">' . $product->get_title() . '</h3>';
								$location_terms = get_the_terms($product->get_id(), 'location');
								// print_r($location_terms);
								if ($location_terms && !is_wp_error($location_terms)) {
									foreach ($location_terms as $term) 
									{
										$location_color = get_term_meta($term->term_id, 'location_color', true);

										$product_html .= '<div class="location-btn">
															<a href="javascript:void(0);" class="product-location" style="border:1px solid '.$location_color.'">
																<svg xmlns="http://www.w3.org/2000/svg"
																	viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
																	<path
																		d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" style="fill:'.$location_color.'" />
																</svg> <Span>'.$term->name.'</Span>
															</a>
														</div>';
									}
								}
								$seller_terms = get_the_terms($product->get_id(), 'seller');
								if ($seller_terms && !is_wp_error($seller_terms)) {
									foreach ($seller_terms as $term) 
									{
										$sellers_selected_location_color = ''; // Initialize location color variable
	
										// Check if the seller term has the custom field "sellers_location"
										if (get_field('sellers_location', 'seller_' . $term->term_id)) 
										{
											// Get the location color from the custom field
											$sellers_selected_location_color = get_field('sellers_location', 'seller_' . $term->term_id);
										}
										else
										{
											$sellers_selected_location_color = $location_color ; // Default color
										}
										$product_html .= '<div class="location-btn">
															<a href="javascript:void(0);" class="product-dealer" style="border:1px solid '.$sellers_selected_location_color.'">
																<svg xmlns="http://www.w3.org/2000/svg"
																	viewBox="0 0 576 512">
																	<path
																		d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" style="fill:'.$sellers_selected_location_color.'"/>
																</svg> <span>'. $term->name .'</span></a>
														</div>';
									}
								}
	$product_html .='<h1 class="product-price">' . $product->get_price_html() . '</h1>
					<p class="product-price-per-unit">Enthält 19 % MwSt. (17,27 / 1L)</p>
					<div class="product-cart-btn">
						<a href="' . $product->add_to_cart_url() . '" class="product-cart">
							<svg xmlns="http://www.w3.org/2000/svg"
								viewBox="0 0 576 512">
								<path
									d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
							</svg>
							<span>In den Warenkorb</span></a>
					</div>
				</div>
				<div class="card-img">
					<a href="' . esc_url(get_permalink($product->get_id())) . '">
					<img class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" width="300" height="300" src="' . $image_url . '" alt="' . $product->get_title() . '"  sizes="(max-width: 300px) 100vw, 300px">
					</a>
				</div>
			</div>
		</div>';

	echo $product_html;

do_action( 'ocean_after_archive_product_item' );
