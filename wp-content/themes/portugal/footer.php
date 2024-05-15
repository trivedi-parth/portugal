<?php
/**
 * The template for displaying the footer.
 *
 * @package OceanWP WordPress theme
 */

?>

</main><!-- #main -->

<?php do_action('ocean_after_main'); ?>

<?php do_action('ocean_before_footer'); ?>

<?php
// Elementor `footer` location.
if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('footer')) {
    ?>

    <?php do_action('ocean_footer'); ?>

<?php } ?>

<?php do_action('ocean_after_footer'); ?>

</div><!-- #wrap -->

<?php do_action('ocean_after_wrap'); ?>

</div><!-- #outer-wrap -->

<?php do_action('ocean_after_outer_wrap'); ?>

<?php
// If is not sticky footer.
if (!class_exists('Ocean_Sticky_Footer')) {
    get_template_part('partials/scroll-top');
}
?>

<?php
// Search overlay style.
if ('overlay' === oceanwp_menu_search_style()) {
    get_template_part('partials/header/search-overlay');
}
?>

<?php
// If sidebar mobile menu style.
if ('sidebar' === oceanwp_mobile_menu_style()) {

    // Mobile panel close button.
    if (get_theme_mod('ocean_mobile_menu_close_btn', true)) {
        get_template_part('partials/mobile/mobile-sidr-close');
    }
    ?>

    <?php
    // Mobile Menu (if defined).
    get_template_part('partials/mobile/mobile-nav');
    ?>

    <?php
    // Mobile search form.
    if (get_theme_mod('ocean_mobile_menu_search', true)) {
        ob_start();
        get_template_part('partials/mobile/mobile-search');
        echo ob_get_clean();
    }
}
?>

<?php
// If full screen mobile menu style.
if ('fullscreen' === oceanwp_mobile_menu_style()) {
    get_template_part('partials/mobile/mobile-fullscreen');
}
?>

<?php wp_footer(); ?>
<!-- <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/script.js"></script> -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/jquery.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/plugin.js"></script>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/slick.min.js"></script>


<script <?php echo get_stylesheet_directory_uri(); ?>>
    $('.home-slider-product').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        focusOnSelect: true,
        dots: true,
        infinite: false,
        nextArrow: $(".next-doctor"),
        prevArrow: $(".prev-doctor"),
        responsive: [
            
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerPadding: '0px',
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    dots: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    dots: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]

    });

    $('.slider-product').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        focusOnSelect: true,
        dots: true,
        infinite: false,
        // nextArrow: $(".next-doctor"),
        // prevArrow: $(".prev-doctor"),
        responsive: [
            
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerPadding: '0px',
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    dots: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 2,
                    slidesToScroll: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    dots: false,
                    centerMode: true,
                    centerPadding: '0px',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]

    });

</script>




</body>

</html>