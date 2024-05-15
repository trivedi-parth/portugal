<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );?>

<!--Heli's search within category in elementor code start -->
<!-- <div class="elementor-element elementor-element-1c2e8c4 e-con-full e-flex e-con e-parent e-lazyloaded" data-id="1c2e8c4" data-element_type="container" data-settings='{"background_background":"classic"}'>
    <div class="elementor-element elementor-element-9560b96 e-con-full e-flex e-con e-child" data-id="9560b96" data-element_type="container">
        <div class="elementor-element elementor-element-92b5943 elementor-widget elementor-widget-heading" data-id="92b5943" data-element_type="widget" data-widget_type="heading.default">
            <div class="elementor-widget-container">
                <h2 class="elementor-heading-title elementor-size-default">FILTER?</h2>
            </div>
        </div>
    </div>
    <div class="elementor-element elementor-element-34134e6 e-con-full e-flex e-con e-child" data-id="34134e6" data-element_type="container">
        <div class="elementor-element elementor-element-b148262 search-in-category elementor-widget elementor-widget-wp-widget-search" data-id="b148262" data-element_type="widget" data-widget_type="wp-widget-search.default">
            <div class="elementor-widget-container">
                <form aria-label="Search this website" role="search" method="get" class="searchform" action="http://localhost/wp-demo/">
                    <input aria-label="Insert search query" type="search" id="ocean-search-form-4" class="field" autocomplete="off" placeholder="Search" name="s" />
                </form>
            </div>
        </div>
    </div>
</div> -->
<section class="product-searchbar">
<div class="search-bar-product">
    <div class="search-bar-heding">
        <h3 class="search-bar-heding-title">FILTER?</h3>
    </div>
    <div class="search-bar-input search-in-category">
        <form method="get" class="searchform" action="">
			<button></button>
            <input class="search" type="search" placeholder="Suche..." id="ocean-search-form-4"  autocomplete="off" name="s">
        </form>
    </div>
</div>
</section>
<!-- search within category in elementor code END -->

<?php

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
