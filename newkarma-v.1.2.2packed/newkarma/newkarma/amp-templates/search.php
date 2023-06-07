<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
		echo esc_html__( 'Search Results For: ', 'newkarma' ) . ' ' . esc_attr( apply_filters( 'the_search_query', get_search_query( false ) ) );
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
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-__.php and that will be used instead.
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
