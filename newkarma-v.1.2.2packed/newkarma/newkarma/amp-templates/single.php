<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'amp' );

?>

<div id="primary" class="content-area col-md-content">
	<main id="main" class="site-main-single" role="main">

	<div class="gmr-list-table single-head-wrap">
		<div class="gmr-table-row">
			<div class="gmr-table-cell">
			<?php
				// Breadcrumb.
				do_action( 'newkarma_core_view_breadcrumbs' );
			?>
			</div>
			<div class="gmr-table-cell">
			<?php
				// Social.
				do_action( 'gmr_single_social' );
			?>
			</div>
		</div>
	</div>

	<?php
	while ( have_posts() ) :
		the_post();

		if ( is_attachment() ) {
			get_template_part( 'amp-templates/content', 'attachment-amp' );
		} else {
			get_template_part( 'amp-templates/content', 'single-amp' );
		}

	endwhile; // End of the loop.
	?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php

get_footer( 'amp' );
