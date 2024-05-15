<?php
/**
 * The template for displaying the page header.
 *
 * @package OceanWP WordPress theme
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

// Return if page header is disabled.
if (!oceanwp_has_page_header()) {
	return;
}

// Classes.
$classes = array('page-header');

// Get header style.
$style = oceanwp_page_header_style();

// Add classes for title style.
if ($style) {
	$classes[$style . '-page-header'] = $style . '-page-header';
}

// Visibility.
$visibility = get_theme_mod('ocean_page_header_visibility', 'all-devices');
if ('all-devices' !== $visibility) {
	$classes[] = $visibility;
}

// Turn into space seperated list.
$classes = implode(' ', $classes);

// Heading tag.
$heading = get_theme_mod('ocean_page_header_heading_tag', 'h1');
$heading = $heading ? $heading : 'h1';
$heading = apply_filters('ocean_page_header_heading', $heading);

?>

<?php do_action('ocean_before_page_header'); ?>

<header class="<?php echo esc_attr($classes); ?>">

	<?php do_action('ocean_before_page_header_inner'); ?>


	<div class="product-breadcrumb-header">
		<div class="header-nreadcrumbs">
			<?php do_action('ocean_breadcrumbs_main'); ?>
			
		</div>
		<div class="header-img">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="">

		</div><!-- .page-header-inner -->
	</div>

	<?php oceanwp_page_header_overlay(); ?>

	<?php do_action('ocean_after_page_header_inner'); ?>

</header><!-- .page-header -->

<?php do_action('ocean_after_page_header'); ?>