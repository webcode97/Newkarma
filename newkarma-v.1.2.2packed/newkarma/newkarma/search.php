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

get_header();

?>

<div id="primary" class="content-area col-md-content">

	<?php
	$class = '';
	if ( is_active_sidebar( 'sidebar-2' ) ) {
		echo '<div class="row">';
		get_sidebar( 'left' );
		echo '<div class="col-md-content-c">';
	}
	?>

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

			$loadmore = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
			if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) && ! newkarma_is_amp() ) {
				$class = 'inf-pagination';
			} else {
				$class = 'pagination';
			}
			echo '<div class="' . esc_html( $class ) . '">';
			echo gmr_get_pagination(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
			if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) && ! newkarma_is_amp() ) :
				echo '
				<div class="text-center gmr-newinfinite">
					<div class="page-load-status">
						<div class="loader-ellips infinite-scroll-request gmr-ajax-load-wrapper gmr-loader">
							<div class="gmr-ajax-wrap">
								<div class="gmr-ajax-loader">
									<div></div>
									<div></div>
								</div>
							</div>
						</div>
						<p class="infinite-scroll-last">' . esc_attr__( 'No More Posts Available.', 'newkarma' ) . '</p>
						<p class="infinite-scroll-error">' . esc_attr__( 'No more pages to load.', 'newkarma' ) . '</p>
					</div>';
					if ( 'gmr-more' === $loadmore ) {
						echo '<p><button class="view-more-button heading-text">' . esc_attr__( 'View More', 'newkarma' ) . '</button></p>';
					}
				echo '
				</div>
				';
			endif;

		} else {
			get_template_part( 'template-parts/content', 'none' );

		}
		?>

		</main><!-- #main -->

	<?php
	if ( is_active_sidebar( 'sidebar-2' ) ) {
		echo '</div>
		</div>';
	}
	?>
</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
