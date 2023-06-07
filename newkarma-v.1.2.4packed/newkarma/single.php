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

get_header();

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
			get_template_part( 'template-parts/content', 'attachment' );
		} else {
			get_template_part( 'template-parts/content', 'single' );
		}

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			if ( newkarma_is_amp() ) {
				/* Add Non AMP Version using <div id="site-version-switcher"> and id="version-switch-link" */
				$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
				echo '<div class="site-main gmr-box-content text-center"><div id="site-version-switcher"><a id="version-switch-link" class="button" href="' . esc_url( $nonamp_link ) . '#comments" class="amp-wp-canonical-link" title="' . __( 'Add Comment', 'newkarma' ) . '" rel="noamphtml nofollow">' . __( 'Add Comment', 'newkarma' ) . '</a></div></div>';
			} else {	
				comments_template();
			}
		endif;

	endwhile; // End of the loop.
	?>
	<?php if ( ! newkarma_is_amp() ) { do_action( 'newkarma_core_add_related_post_infinite' ); } ?>

	</main><!-- #main -->

</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
