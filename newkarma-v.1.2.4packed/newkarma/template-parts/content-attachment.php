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

// Disable post navigation options via customizer.
$postnav = get_theme_mod( 'gmr_active-prevnext-post', 0 );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo newkarma_itemtype_schema( 'CreativeWork' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>

	<div class="site-main hentry gmr-single">
		<div class="gmr-box-content-single">
			<?php
			if ( 0 === $metadata ) :
				gmr_posted_on();
			endif;
			?>
			<?php
			if ( ! is_wp_error( get_the_term_list( $post->post_parent, 'newstopic' ) ) ) {
				$termlist = get_the_term_list( $post->post_parent, 'newstopic' );
				if ( ! empty( $termlist ) ) {
					echo '<div class="gmr-meta-topic">';
					echo get_the_term_list( $post->post_parent, 'newstopic', '', ', ', '' );
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
						echo '<span class="posted-on">' . $posted_by . '</span>'; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */

					}
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( esc_html__( ', ', 'newkarma' ), '', $post->post_parent );
						$posted_in       = '';
					if ( $categories_list ) {
						$posted_in = '<span class="meta-separator">-</span><span class="cat-links">' . $categories_list . '</span>';
					}

						echo $posted_in; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
					echo '</div>';

				endif;
				?>
			</header><!-- .entry-header -->
			<?php do_action( 'newkarma_add_share_top_in_single' ); ?>
		</div>

		<div class="gmr-featured-wrap">
			<?php
				$attachments = array_values(
					get_children(
						array(
							'post_parent'    => $post->post_parent,
							'post_status'    => 'inherit',
							'post_type'      => 'attachment',
							'post_mime_type' => 'image',
							'order'          => 'ASC',
							'orderby'        => 'menu_order ID',
						)
					)
				);
				foreach ( $attachments as $k => $attachment ) {
					if ( $attachment->ID === $post->ID ) {
						break;
					}
				}
				$k++;
				if ( count( $attachments ) > 1 ) {
					if ( isset( $attachments[ $k ] ) ) {
						$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
					} else {
						$next_attachment_url = get_attachment_link( $attachments[0]->ID );
					}
				} else {
					$next_attachment_url = wp_get_attachment_url();
				}

				// displaying thumbnail attachments.
				if ( $attachments ) :
					do_action( 'newkarma_core_banner_before_content_attachment' );
					?>
						<figure class="wp-caption alignnone gmr-attachment-img">
							<?php echo wp_get_attachment_image( $post->ID, 'full' ); // Filterable image width with, essentially, no limit for image height. ?>
							<?php previous_image_link( false, '<span class="previous-image"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M17.77 3.77L16 2L6 12l10 10l1.77-1.77L9.54 12z" fill="currentColor"/></svg></span>' ); ?>
							<?php next_image_link( false, '<span class="next-image"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M6.23 20.23L8 22l10-10L8 2L6.23 3.77L14.46 12z" fill="currentColor"/></svg></span>' ); ?>
						</figure>
						<?php
						$get_description = get_post( get_post_thumbnail_id() )->post_content;
						if ( ! empty( $get_description ) ) :
							?>
							<div class="gmr-box-content-single"><?php echo wp_kses_post( $get_description ); ?></div>
						<?php endif; ?>
					<?php
					do_action( 'newkarma_core_banner_after_content_attachment' );
				endif; // endif attachments.
				?>
		</div>

	</div>

	<div class="gmr-box-content-single">
		<?php
		// Author box.
		do_action( 'newkarma_core_author_box' );
		// Add first related post.
		do_action( 'newkarma_core_add_related_the_content' );
		// Add second related post.
		do_action( 'newkarma_core_add_second_related_the_content' );
		?>

	</div>

</article><!-- #post-## -->
