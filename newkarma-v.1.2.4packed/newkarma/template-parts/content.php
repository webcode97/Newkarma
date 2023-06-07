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

$focus_display = get_post_meta( $post->ID, '_gmr_focus_key', true );

// Disable thumbnail options via customizer.
$thumbnail = get_theme_mod( 'gmr_active-blogthumb', 0 );

// Disable excerpt options via customizer.
$excerpt_opsi = get_theme_mod( 'gmr_active-excerptarchive', 0 );

// Blog Content options via customizer.
$blog_content = get_theme_mod( 'gmr_blog_content', 'excerpt' );

$focus = '';
if ( $focus_display ) {
	$focus = ' gmr-focus-news';
}

if ( $focus_display ) {
	$image_size = 'large';
} else {
	$image_size = 'medium';
}

$classes = array(
	'gmr-smallthumb',
	'clearfix',
	'item-infinite',
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?> <?php echo newkarma_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div class="gmr-box-content hentry gmr-archive clearfix<?php echo $focus; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">

		<?php
		// Add thumnail.
		if ( 0 === $thumbnail ) :
			$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

			if ( ! empty( $featured_image_url ) ) :
				echo '<div class="content-thumbnail">';
					echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
					the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'newkarma' ),
							'after'  => '',
							'echo'   => false,
						)
					);
					echo '" rel="bookmark">';
					the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
					echo '</a>';
				if ( has_post_format( 'gallery' ) ) {
					echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="currentColor"/></svg>';
				} elseif ( has_post_format( 'video' ) ) {
					echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/><path d="M719.4 499.1l-296.1-215A15.9 15.9 0 0 0 398 297v430c0 13.1 14.8 20.5 25.3 12.9l296.1-215a15.9 15.9 0 0 0 0-25.8zm-257.6 134V390.9L628.5 512L461.8 633.1z" fill="currentColor"/></svg>';
					$h = get_post_meta( $post->ID, '_durh', true );
					$m = get_post_meta( $post->ID, '_durm', true );
					$s = get_post_meta( $post->ID, '_durs', true );
					if ( ! empty( $h ) || ! empty( $m ) || ! empty( $s ) ) {
						echo '<div class="duration">';
						if ( ! empty( $h ) && 0 !== $h ) {
							echo esc_html( str_pad( absint( $h ), 2, '0', STR_PAD_LEFT ) . ':' );
						}
						if ( ! empty( $m ) ) {
							echo esc_html( str_pad( absint( $m ), 2, '0', STR_PAD_LEFT ) . ':' );
						} else {
							echo '00';
						}
						if ( ! empty( $s ) ) {
							echo esc_html( str_pad( absint( $s ), 2, '0', STR_PAD_LEFT ) );
						} else {
							echo '00';
						}
						echo '</div>';
					}

				}
				echo '</div>';

			endif; // endif has_post_thumbnail.
		endif; // endif thumbnail.
		?>

		<div class="item-article">
			<?php
			if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
				$termlist = get_the_term_list( $post->ID, 'newstopic' );
				if ( ! empty( $termlist ) ) {
					echo '<span class="gmr-meta-topic">';
					echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
					echo '</span>';
				}
			}
			?>

			<header class="entry-header">
				<h2 class="entry-title" <?php echo newkarma_itemprop_schema( 'headline' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php
					echo '<a href="' . esc_url( get_permalink() ) . '" ' . newkarma_itemtype_schema( 'url' ) /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ . ' title="';
					the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'newkarma' ),
							'after'  => '',
						)
					);
					echo '" rel="bookmark">' . esc_html( get_the_title() ) . '</a>';
					?>
				</h2>

			</header><!-- .entry-header -->

			<div class="entry-meta">
				<?php gmr_posted_on(); ?>
			</div><!-- .entry-meta -->

			<div class="entry-content entry-content-archive" <?php echo newkarma_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				if ( 0 === $excerpt_opsi ) :
					if ( 'fullcontent' === $blog_content ) :
						the_content();

					else :
						the_excerpt();

					endif;
				endif;
				?>
			</div><!-- .entry-content -->

		</div><!-- .item-article -->

	<?php if ( is_sticky() ) { ?>
		<kbd class="kbd-sticky"><?php esc_html_e( 'Sticky', 'newkarma' ); ?></kbd>
	<?php } ?>

	</div><!-- .gmr-box-content -->

</article><!-- #post-## -->
