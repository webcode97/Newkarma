<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

	<?php
	echo '<h1 class="page-title" ' . newkarma_itemprop_schema( 'headline' ) . '><span>'; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
	the_archive_title();
	echo '</span></h1>';
	?>

	<main id="main" class="site-main site-main-archive gmr-infinite-selector" role="main">

	<?php
	if ( have_posts() ) {
		echo '<div id="gmr-main-load">';

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();
			/**
			 * Include the Post-Format-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_format() );
			do_action( 'newkarma_core_banner_between_posts' );

		endwhile;

		echo '</div>';
		echo gmr_get_pagination(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
	} else {
		get_template_part( 'template-parts/content', 'none' );

	}
	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php

get_footer( 'amp' );
