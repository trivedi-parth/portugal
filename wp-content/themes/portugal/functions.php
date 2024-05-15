<?php
    function my_theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ), wp_get_theme('OceanWP')->get('Version'));
    }
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles');    


    function oceanwp_enqueue_custom_script() {
        wp_enqueue_script('my-ajax-handle', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true);
        wp_localize_script('my-ajax-handle', 'my_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));

    }
    add_action('wp_enqueue_scripts', 'oceanwp_enqueue_custom_script');
    

    /* Custom function for get reccomanded and featured products:START */
    function get_products_custom_shortcode($atts) {


        $args = array(
            'limit' => isset($atts['limit']) ? $atts['limit'] : 10,  // Limit to specified number of products
            'featured' => isset($atts['featured']) ? $atts['featured'] : false, // Get only featured products
            'status' => 'publish',
        );
        // Get products using wc_get_products function
        $products = wc_get_products($args);
        
        // Initialize HTML variable
        $html = '<div class="product-slider">
                    <div class="offer-slider';
        $html .= '">';
        $product_html = '';
    
        // Loop through the products
        foreach ($products as $product) {
            // Get product details
            $product_html = get_product_html($product);
    
            // Append to HTML
            $html .= $product_html;
        }
    
        $html .= '</div></div>';
    
        // Output HTML
        return $html;
    }
    add_shortcode('products_custom_code', 'get_products_custom_shortcode');
    
    
    
    
    
    // Function to generate HTML for a product
    function get_product_html($product) {
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
            /* $product_html .= '<div class="col-lg-4 col-md-6 col-sm-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-9 card-text">
                                                <p>' . implode(', ', $category_links) . '</p>
                                                <h5>' . $product->get_title() . '</h5>
                                                <div class="card-btn">';
                                                    $location_terms = get_the_terms($product->get_id(), 'location');
                                                    // print_r($location_terms);
                                                    if ($location_terms && !is_wp_error($location_terms)) {
                                                        foreach ($location_terms as $term) {
                                                            $location_color = get_term_meta($term->term_id, 'location_color', true);
    
                                                            $product_html .= '<button type="card-button" class="card-button" style="border:1px solid '.$location_color.'">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                                <path
                                                                                    d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" style="fill:'.$location_color.'" />
                                                                            </svg> <Span>'.$term->name.'</Span>
                                                                        </button>';
                                                            
                                                        }
                                                    }
                                                    else{
                                                        $product_html .= '<button type="card-button" class="card-button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                                <path
                                                                                    d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                                                            </svg> <Span>no</Span>
                                                                        </button>';
                                                    }
                                                    $seller_terms = get_the_terms($product->get_id(), 'seller');
                                                    if ($seller_terms && !is_wp_error($seller_terms)) {
                                                        foreach ($seller_terms as $term) {
                                                            $product_html .= '<button type="card-button" class="card-button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                                <path
                                                                                    d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                                                            </svg> <Span>'. $term->name .'</Span>
                                                                        </button>';
                                                            
                                                        }
                                                    }else{
                                                        $product_html .= '<button type="card-button" class="card-button">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                                                <path
                                                                                    d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                                                            </svg> <Span>No seller</Span>
                                                                        </button>';
                                                    }
                                                    $product_html .='</div>
    
                                                <div class="card-price">
                                                    <h2>' . $product->get_price_html() . '</h2>
                                                    <p>Enthält 19 % MwSt. (17,27 / 1L)</p>
                                                </div>
                                                <a class="card-cart-button" href="' . $product->add_to_cart_url() . '">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path
                                                            d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
                                                    </svg><span>In den Warenkorb</span></a>
                                            </div>
                                            <div class="col-3 card-img">
                                                <img src="' . $image_url . '" alt="' . $product->get_title() . '">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
    
            return $product_html; */
    
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
        return $product_html;
    }
    
    function get_sale_product_custom_code($atts) {
        // Default attributes for the shortcode
        $atts = shortcode_atts(array(
            'limit' => 6,
            'on_sale' => false,
        ), $atts, 'products_custom_code');
    
        // Arguments for the WP_Query to get sale products
        $query_args = array(
            'posts_per_page'    => $atts['limit'],
            'no_found_rows'     => 1,
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'meta_query'        => WC()->query->get_meta_query(),
            'post__in'          => array_merge(array(0), wc_get_product_ids_on_sale())
        );
    
        // Get sale products using WP_Query
        $products_query = new WP_Query($query_args);
    
        // Initialize HTML variable
        $html = '<div class="product-slider ">
                    <div class="offer-slider';
    
        // Check if on_sale is true to add the slider-product class
        if ($atts['on_sale']) {
            $html .= ' home-slider-product';
        }
    
        $html .= '">';
    
        // Loop through the sale products
            // Loop through the sale products
            if ($products_query->have_posts()) {
                while ($products_query->have_posts()) {
                    $products_query->the_post();
                    $product = wc_get_product(get_the_ID());
                    // Get product HTML
                    $product_html = get_product_html($product);
                    // Append product HTML to the main HTML variable
                    $html .= $product_html;
                }
                wp_reset_postdata();
            } else {
                // If no sale products found, display a message
                $html .= '<p>No sale products found.</p>';
            }
        
            $html .= '</div></div>';
        
            // Output HTML
            return $html;
    }
    add_shortcode('sale_products_custom_code', 'get_sale_product_custom_code');
    
    /* Custom function for get reccomanded and featured products:END */

    /* Custom search within category:START */
    add_action('wp_ajax_custom_search_action', 'custom_search_action');
    add_action('wp_ajax_nopriv_custom_search_action', 'custom_search_action');
    function custom_search_action() {
        $searchTerm = isset($_POST['searchTerm']) ? sanitize_text_field($_POST['searchTerm']) : '';
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 9, // Change to 5 to load 5 products at a time
            'paged' => $paged,
            's' => $searchTerm,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category,
                ),
            ),
        );
        $query = new WP_Query($args);
        // Initialize an empty array to store the HTML content and pagination
        $response = array(
            'html' => '',
            'has_more' => false, // Flag to indicate if there are more products beyond the initial load
        );
        ob_start(); // Start output buffering
        if ($query->have_posts()) {
            woocommerce_product_loop_start();
            while ($query->have_posts()) {
                $query->the_post();
                wc_get_template_part('content', 'product');
            }
            woocommerce_product_loop_end();
            // Check if there are more pages beyond the current page
            $response['has_more'] = $query->max_num_pages > $paged;
        } else {
            wc_get_template('loop/no-products-found.php');
        }
        $response['html'] = ob_get_clean(); // Get buffered output and store in response
        wp_send_json($response);
    }
    /* Custom search within category:END */
    
    /* Add custom fields into woocommerce product general tab:START */
    // Add custom fields to product general tab
    add_action('woocommerce_product_options_general_product_data', 'add_custom_fields_to_general_tab');

    function add_custom_fields_to_general_tab() {
        
        echo '<div class="options_group">';

        // Delivery Time
        $delivery_time_terms = get_terms(array(
            'taxonomy' => 'product_delivery_times',
            'hide_empty' => false,
        ));
        
        $delivery_time_options = array('-1' => __('Select', 'text-domain'));

        if (!empty($delivery_time_terms) && !is_wp_error($delivery_time_terms)) {
            foreach ($delivery_time_terms as $term) {
                $delivery_time_options[$term->term_id] = $term->name;
            }
        }

        woocommerce_wp_select(array(
            'id' => '_lieferzeit',
            'label' => __('Delivery Time', 'text-domain'),
            'desc_tip' => true,
            'options' => $delivery_time_options,
            'description' => __('Choose the delivery time for this product.', 'text-domain'),
            'value' => '584', // Set default value to 'Select'
        ));



        // Alternative Shipping Information
        woocommerce_wp_text_input(array(
            'id' => '_alternative_shipping_information',
            'label' => __('Alternative Shipping Information', 'text-domain'),
            'desc_tip' => true,
            'description' => __('Instead of the general shipping information, you can enter special information just for this product.', 'text-domain'),
            
        ));
        // Disable Shipping Information
        woocommerce_wp_checkbox(array(
            'id' => '_suppress_shipping_notice',
            'label' => __('Disable Shipping Information', 'text-domain'),
            'desc_tip' => true,
            'description' => __('Don"t display shipping information for this product (e.g., if it is virtual/digital).', 'text-domain'),
        ));
        
        echo '</div>';

    }

    // Save custom fields
    add_action('woocommerce_process_product_meta', 'save_custom_fields');

    function save_custom_fields($post_id) {
        // Save Delivery Time
        $lieferzeit = isset($_POST['_lieferzeit']) ? sanitize_text_field($_POST['_lieferzeit']) : '-1';
        update_post_meta($post_id, '_lieferzeit', $lieferzeit);

        // Save Alternative Shipping Information
        $alternative_shipping_info = isset($_POST['_alternative_shipping_information']) ? sanitize_text_field($_POST['_alternative_shipping_information']) : '';
        update_post_meta($post_id, '_alternative_shipping_information', $alternative_shipping_info);

        // Save Disable Shipping Information
        $suppress_shipping_notice = isset($_POST['_suppress_shipping_notice']) ? 'yes' : 'no';
        update_post_meta($post_id, '_suppress_shipping_notice', $suppress_shipping_notice);
    }

    /* ----------------------------------------------------------------------------------------------------------- */


    add_action('woocommerce_product_options_general_product_data', 'add_sale_label_field_to_general_tab');

    function add_sale_label_field_to_general_tab() {
        echo '<div class="options_group">';

        // Sale Label
        $sale_labels = get_terms(array(
            'taxonomy' => 'product_sale_labels',
            'hide_empty' => false,
        ));
        
        $sale_label_option = array('-1' => __('Select', 'text-domain'));

        if (!empty($sale_labels) && !is_wp_error($sale_labels)) {
            foreach ($sale_labels as $term) {
                $sale_label_option[$term->term_id] = $term->name;
            }
        }

        woocommerce_wp_select(array(
            'id' => '_sale_label',
            'label' => __('Sale Label', 'text-domain'),
            'desc_tip' => true,
            'options' => $sale_label_option,
            'value' => '-1', // Set default value to 'Select'
        ));
        echo '</div>';
    }

    // Save sale label field when product is saved or updated
    add_action('woocommerce_process_product_meta', 'save_sale_label_field');

    function save_sale_label_field($post_id) {
        // Check if the field is set
        if (isset($_POST['_sale_label'])) {
            // Sanitize the selected value
            $sale_label = sanitize_text_field($_POST['_sale_label']);
            // Update the post meta
            update_post_meta($post_id, '_sale_label', $sale_label);
        }
    }

    /* Add custom fields into woocommerce product general tab:END */

 ?>

