<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-sb-l pos-sticky" role="complementary" <?php newkarma_itemtype_schema( 'WPSideBar' ); ?>>
	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</aside><!-- #secondary -->
