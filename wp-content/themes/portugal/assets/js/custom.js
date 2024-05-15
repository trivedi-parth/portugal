/* jQuery(document).ready(function($) {
    console.log('dddffdfdfdf');
    // Find the menu item with the class 'menu-item-433' (user icon)
    var userIcon = $('li.menu-item-433');
    // Find the menu item with the class 'woo-menu-icon' (cart icon)
    var cartIcon = $('li.woo-menu-icon.wcmenucart-toggle-drop_down.toggle-cart-widget');
    // Append the cart icon before the user icon
    userIcon.before(cartIcon);
}); */

function getCategorySlugFromUrl() {
    var url = window.location.href;
    var parts = url.split('/');
    // console.log(parts, 'parts');
    if (parts.length > 1) {
        // Extract the last two segments of the URL
        var lastSegment = parts[parts.length - 1];
        var secondLastSegment = parts[parts.length - 2];
        // Check if the last segment contains pagination query parameter
        if (lastSegment.includes('?product-page=')) {
            // If pagination query parameter is present, consider the second last segment
            var categorySlug = secondLastSegment;
        } else {
            // If pagination query parameter is not present, use the last two segments
            var categorySlug = secondLastSegment + '/' + lastSegment;
        }
        // Remove the trailing slash, if present
        categorySlug = categorySlug.replace(/\/$/, '');
        return categorySlug;
    }
    return ''; // Return an empty string if no category slug is found in the URL
}

jQuery(document).ready(function($) {
    /* custom class add:START */
    $('div.sib-form').addClass('newsletter-form');
    /* custom class add:END */


    // Find the menu item with the class 'menu-item-433' (user icon)
    var userIcon = $('li.menu-item-433');
    // Find all cart icons
    var cartIcons = $('li.woo-menu-icon.wcmenucart-toggle-drop_down.toggle-cart-widget');

    // Check if userIcon and cartIcons are found
    if (userIcon.length && cartIcons.length) {
        // Append the first cart icon before the user icon
        userIcon.before(cartIcons.first());
        // Remove any other cart icons
        cartIcons.slice(1).remove();
    } else {
        // console.log('User icon or cart icon not found!');
    }

    jQuery('.slider-product').slick({
        // centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        focusOnSelect: true,
        dots: true,
        infinite: true,
        nextArrow: jQuery(".next-doctor"),
        prevArrow: jQuery(".prev-doctor"),
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    dots: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: true,
                    dots: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
        ]

    });

    /* search Ajax:start */
    var currentPage = 1; // Keep track of the current page
    var isLoading = false; // Flag to prevent multiple simultaneous requests
    $('.search-in-category form').attr('id', 'search_form');

        $('#search_form').on('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        var categorySlug = getCategorySlugFromUrl();
        var searchTerm = $('#ocean-search-form-4').val()?.trim();
        // Check if search term is empty
        if (!searchTerm) {
            window.location.reload();
            return;
        }
        // AJAX request to search script
        loadProducts(categorySlug, searchTerm, currentPage);
    });

    $('.search').on('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent the default form submission behavior
            var categorySlug = getCategorySlugFromUrl();
            var searchTerm = $('#ocean-search-form-4').val()?.trim();
            // Check if search term is empty
            if (!searchTerm) {
                window.location.reload();
                return;
            }
            // AJAX request to search script
            loadProducts(categorySlug, searchTerm, currentPage);
        }
    });
    // Function to load products via AJAX
    function loadProducts(categorySlug, searchTerm, page) {
        // console.log('searchTerm',searchTerm);
        // console.log('page',page);
        if (isLoading) return; // Prevent multiple simultaneous requests
        isLoading = true; // Set loading flag to true
        $.ajax({
            url: my_ajax_object.ajaxurl,
            type: 'post',
            data: {
                action: 'custom_search_action',
                searchTerm: searchTerm,
                category: categorySlug,
                page: page
            },
            success: function(response) {
                console.log('response', response);
                // Append products HTML
                // $('.products.oceanwp-row').append(response.html);
                if ($('div.search-dynamic-section').length) {
                    $('div.search-dynamic-section').html(response.html);
                } else {
                    $('.products.oceanwp-row').html(response.html);
                }
                // Update pagination HTML
                if (response.has_more) {
                    $('.woocommerce-pagination').html(response.pagination);
                    $('div.search-dynamic-section').append('<button class="load-more-button" id="load-more">Load More</button>');
                    $('.load-more-button').show(); // Show load more button
                } else {
                    $('.load-more-button').hide(); // Hide load more button if no more products
                }
                // Increment current page
                currentPage++;
            },
            complete: function() {
                isLoading = false; // Reset loading flag
            }
        });
    }
    // Load more button click event
    $(document).on('click','.load-more-button',function(){
        var categorySlug = getCategorySlugFromUrl();
        var searchTerm = $('#ocean-search-form-4').val()?.trim();
        loadProducts(categorySlug, searchTerm, currentPage);
    });
    /* search Ajax:end */
});

