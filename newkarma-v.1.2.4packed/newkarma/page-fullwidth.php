<?php
/**
 * Template Name: Fullwidth
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div id="primary" class="content-area col-md-main">

	<main id="main" class="site-main site-main-single" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

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

	</main><!-- #main -->

</div><!-- #primary -->

<?php
get_footer();
