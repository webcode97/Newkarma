<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div id="primary" class="content-area col-md-content">
	<?php
	$class = '';
	if ( is_active_sidebar( 'sidebar-2' ) && ! newkarma_is_amp() ) {
		echo '<div class="row">';
		get_sidebar( 'left' );
		echo '<div class="col-md-content-c">';
	}
	?>
		<h1 class="page-title"><span><?php esc_html_e( 'Error 404', 'newkarma' ); ?></span></h1>
		<main id="main" class="site-main site-main-archive" role="main">
			<section class="gmr-box-content gmr-archive error-404 not-found">

				<header class="entry-header">
					<h2 <?php newkarma_itemprop_schema( 'headline' ); ?>><?php esc_html_e( 'Nothing Found', 'newkarma' ); ?></h2>
				</header><!-- .entry-header -->

				<div class="page-content" <?php newkarma_itemprop_schema( 'text' ); ?>>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'newkarma' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #main -->
	<?php
	if ( is_active_sidebar( 'sidebar-2' ) && ! newkarma_is_amp() ) {
		echo '</div>
		</div>';
	}
	?>
</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
