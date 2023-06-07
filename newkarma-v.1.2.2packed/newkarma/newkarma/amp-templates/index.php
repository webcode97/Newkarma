<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
	echo '<h2 class="page-title" ' . newkarma_itemprop_schema( 'headline' ) . '><span>'; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
		$textnewsfeed = get_theme_mod( 'gmr_textnewsfeed' );
	if ( $textnewsfeed ) :
		// sanitize html output.
		echo esc_html( $textnewsfeed );
	else :
		echo esc_html__( 'News Feed', 'newkarma' );
	endif;
	echo '</span></h2>';
	?>

	<main id="main" class="site-main site-main-archive gmr-infinite-selector" role="main">

		<?php
		if ( have_posts() ) {
			$count = 0;
			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text" <?php echo newkarma_itemprop_schema( 'headline' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			if ( is_front_page() && is_home() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
				</header>
				<?php
			endif;

			echo '<div id="gmr-main-load">';

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				$count++;
				$navpaged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

				/*
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
