<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<section class="no-results not-found">
	<div class="site-main gmr-single">
		<div class="gmr-box-content-single">
			<header class="entry-header">
				<h2 class="page-title-none" <?php echo newkarma_itemprop_schema( 'headline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><span><?php esc_html_e( 'Nothing Found', 'newkarma' ); ?></span></h2>
			</header><!-- .page-header -->

			<div class="entry-content" <?php echo newkarma_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				if ( is_home() && current_user_can( 'publish_posts' ) ) :
					?>
					<p><?php printf( wp_kses( esc_html__( 'Ready to publish your first post?', 'newkarma' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

				<?php elseif ( is_search() ) : ?>

					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'newkarma' ); ?></p>
					<?php
						get_search_form();

				else :
					?>

					<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'newkarma' ); ?></p>
					<?php
						get_search_form();

				endif;
				?>
			</div><!-- .page-content -->
		</div>
	</div><!-- .gmr-box-content -->
</section><!-- .no-results -->
