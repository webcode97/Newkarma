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

get_header();

?>

<div id="primary" class="content-area col-md-content">

	<?php if ( ! newkarma_is_amp() ) { ?>
		<?php
		// Slider.
		$carousel = get_theme_mod( 'gmr_active-headline', 0 );
		if ( 0 === $carousel ) :
			do_action( 'newkarma_display_carousel' );
		endif;
		?>

		<?php
		$modulehome = get_theme_mod( 'gmr_active-module-home', 0 );
		if ( 0 === $modulehome ) {
			do_action( 'newkarma_display_modulehome' );
		}
		?>

		<?php
		if ( is_active_sidebar( 'sidebar-2' ) ) {
			echo '<div class="row">';
			get_sidebar( 'left' );
			echo '<div class="col-md-content-c">';
		}

		?>
	<?php } ?>

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

					if ( 6 === $count && 1 === $navpaged ) {
						// Home module.
						if ( is_active_sidebar( 'module-after-1' ) ) {
							echo '<div class="gmr-box-content item-infinite home-module">';
							dynamic_sidebar( 'module-after-1' );
							echo '</div>';
						}
					}

					if ( 9 === $count && 1 === $navpaged ) {
						// Home module 2.
						if ( is_active_sidebar( 'module-after-2' ) ) {
							echo '<div class="gmr-box-content item-infinite home-module">';
							dynamic_sidebar( 'module-after-2' );
							echo '</div>';
						}
					}

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
	if ( is_active_sidebar( 'sidebar-2' ) && ! newkarma_is_amp() ) {
		echo '</div>
		</div>';
	}
	?>
</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
