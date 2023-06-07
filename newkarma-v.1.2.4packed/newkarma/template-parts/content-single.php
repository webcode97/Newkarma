<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Disable thumbnail options via customizer.
$thumbnail = get_theme_mod( 'gmr_active-singlethumb', 0 );

// Disable meta data options via customizer.
$metadata = get_theme_mod( 'gmr_active-metasingle', 0 );

// Disable only view meta data options via customizer.
$viewdata = get_theme_mod( 'gmr_active-viewdata', 0 );

// Disable Social Share via customizer.
$socialshare = get_theme_mod( 'gmr_active-socialshare', 0 );

// Disable post navigation options via customizer.
$postnav = get_theme_mod( 'gmr_active-prevnext-post', 0 );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo newkarma_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div class="site-main gmr-single hentry">
		<div class="gmr-box-content-single">
			<?php
			if ( 0 === $metadata ) :
				gmr_posted_on();
			endif;
			?>
			<?php
			if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
				$termlist = get_the_term_list( $post->ID, 'newstopic' );
				if ( ! empty( $termlist ) ) {
					echo '<div class="gmr-meta-topic">';
					echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
					echo '</div>';
				}
			}
			?>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title" ' . newkarma_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
				<?php
				if ( 0 === $metadata ) :
					echo '<div class="gmr-metacontent-single">';
						$posted_by = sprintf(
							'%s',
							'<span class="entry-author vcard" ' . newkarma_itemprop_schema( 'author' ) . ' ' . newkarma_itemtype_schema( 'person' ) . '><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . __( 'Permalink to: ', 'newkarma' ) . esc_html( get_the_author() ) . '" ' . newkarma_itemprop_schema( 'url' ) . '><span ' . newkarma_itemprop_schema( 'name' ) . '>' . esc_html( get_the_author() ) . '</span></a></span>'
						);
					if ( is_single() ) {
						echo '<span class="posted-on">' . $posted_by . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					}
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( esc_html__( ', ', 'newkarma' ) );
						$posted_in       = '';
					if ( $categories_list ) {
						$posted_in = '<span class="meta-separator">-</span><span class="cat-links">' . $categories_list . '</span>';
					}
						echo $posted_in; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						if ( 0 === $viewdata ) {
							if ( class_exists( 'Post_Views_Counter' ) ) {
								$number = pvc_get_post_views( $post->ID );
								echo '<span class="meta-separator">-</span><span class="view-single">' . absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' ) . '</spans>';
							} elseif ( function_exists( 'the_views' ) ) {
								echo '<span class="meta-separator">-</span><span class="view-single">';
								the_views();
								echo '</span>';
							}
						}
					echo '</div>';

				endif;
				?>
			</header><!-- .entry-header -->

			<?php
			if ( 0 === $socialshare ) :
				do_action( 'newkarma_add_share_top_in_single' );
			endif;
			?>
		</div>

		<div class="gmr-featured-wrap">
			<?php
			// custom field using oembed https://codex.wordpress.org/Embeds.
			$majpro_oembed = get_post_meta( $post->ID, 'MAJPRO_Oembed', true );
			$majpro_iframe = get_post_meta( $post->ID, 'MAJPRO_Iframe', true );
			if ( ! empty( $majpro_oembed ) ) {
				echo '<div class="gmr-embed-responsive gmr-embed-responsive-16by9">';
				echo wp_oembed_get( $majpro_oembed ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';

			} elseif ( ! empty( $majpro_iframe ) ) {
				echo '<div class="gmr-embed-responsive gmr-embed-responsive-16by9">';
				$var = do_shortcode( $majpro_iframe );
				echo $var; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '</div>';

			} else {
				// displaying thumbnail.
				if ( 0 === $thumbnail ) :
					if ( has_post_thumbnail() ) {
						?>
						<figure class="wp-caption alignnone gmr-attachment-img">
							<?php the_post_thumbnail(); ?>
							<?php
							if ( has_post_format( 'gallery' ) ) {
								$attachment_url = get_attachment_link( get_post_thumbnail_id() );
								echo '<a href="' . esc_url( $attachment_url ) . '" rel="nofollow"><span class="next-image"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z" fill="currentColor"/></svg></span></a>';
							}
							?>
							<?php if ( $caption = get_post( get_post_thumbnail_id() )->post_excerpt ) : ?>
								<figcaption class="wp-caption-text"><?php echo $caption; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></figcaption>
							<?php endif; ?>
						</figure>
						<?php
					}
				endif; // endif thumbnail.
			}
			?>
		</div>

		<div class="gmr-box-content-single">
			<div class="row">
				<?php
				if ( 0 === $socialshare && ! newkarma_is_amp() ) {
					echo '<div class="col-md-sgl-l pos-sticky">';
						do_action( 'newkarma_add_share_in_single' );
					echo '</div>';
				}
				if ( is_active_sidebar( 'sidebar-3' ) && ! newkarma_is_amp() ) {
					if ( 0 === $socialshare ) {
						$class = 'col-md-sgl-c';
					} else {
						$class = 'col-md-sgl-c-nosocial';
					}
				} else {
					if ( 0 === $socialshare ) {
						$class = 'col-md-sgl-c-no-r';
					} else {
						$class = 'col-md-main';
					}
				}
				?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<div class="entry-content entry-content-single" <?php echo newkarma_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php
							the_content();
						?>
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<?php
						gmr_entry_footer();

						$majpro_source = get_post_meta( $post->ID, 'MAJPRO_Source', true );
						$majpro_writer = get_post_meta( $post->ID, 'MAJPRO_Writer', true );
						$majpro_editor = get_post_meta( $post->ID, 'MAJPRO_Editor', true );
						echo '<div class="gmr-cf-metacontent heading-text meta-content">';
						if ( ! empty( $majpro_writer ) ) {
							echo '<span>';
							echo esc_attr__( 'Writer: ', 'newkarma-core' ) . esc_attr( $majpro_writer );
							echo '</span>';
						}
						if ( ! empty( $majpro_editor ) ) {
							echo '<span>';
							echo esc_attr__( 'Editor: ', 'newkarma-core' ) . esc_attr( $majpro_editor );
							echo '</span>';
						}
						if ( ! empty( $majpro_source ) ) {
							echo '<span>';
							echo '<a href="' . esc_url( $majpro_source ) . '" target="_blank" rel="nofollow">' . esc_attr__( 'Source News', 'newkarma-core' ) . '</a>';
							echo '</span>';
						}
						echo '</div>';

						if ( is_singular( 'post' ) ) {
							if ( 0 === $postnav ) :
								the_post_navigation(
									array(
										'prev_text' => __( '<span>Previous post</span> %title', 'newkarma' ),
										'next_text' => __( '<span>Next post</span> %title', 'newkarma' ),
									)
								);
							endif;
						}
						?>
					</footer><!-- .entry-footer -->
				</div>
				<?php
				if ( is_active_sidebar( 'sidebar-3' ) && ! newkarma_is_amp() ) {
					echo '<div class="col-md-sgl-r pos-sticky">';
					get_sidebar( 'left-single' );
					echo '</div>';
				}
				?>
			</div>
		</div>

	</div>

	<div class="gmr-box-content-single">
		<?php
		// Author box.
		do_action( 'newkarma_core_author_box' );
		// Add first related post.
		do_action( 'newkarma_core_add_related_the_content' );
		// Add banner before second related posts.
		do_action( 'newkarma_core_banner_before_dontmiss' );
		// Add second related post.
		do_action( 'newkarma_core_add_second_related_the_content' );
		?>

	</div>
</article><!-- #post-## -->
