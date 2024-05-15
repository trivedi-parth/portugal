<?php
/**
 * After Container template.
 *
 * @package OceanWP WordPress theme
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
} ?>

<?php do_action('ocean_before_content_wrap'); 
			$category_name = single_term_title('', false); // Get the current category name

?>

<div id="content-wrap" class="container clr">

	<?php do_action('ocean_before_primary'); ?>

	<div id="primary" class="content-area clr">

		<?php do_action('ocean_before_content'); ?>

		<div id="content" class="clr site-content">

			<?php do_action('ocean_before_content_inner'); ?>
			<?php
            $category_name = single_term_title('', false); // Get the current category name
            if (!empty($category_name)) :
            ?>
                <h1 class="product-sub-cat-header">Unsere <?php echo esc_html($category_name); ?></h1>
            <?php endif; ?>			
			<article class="entry-content entry clr ">