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
	$focus = ' gmr-focus-news gmr-focus-gallery';
}

if ( $focus_display ) {
	$image_size = 'idt-bigger-thumb';
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
					echo '<span class="icon_camera"></span>';
				} elseif ( has_post_format( 'video' ) ) {
					echo '<span class="arrow_triangle-right_alt2"></span>';
				}
				echo '</div>';

			endif; // endif has_post_thumbnail.
		endif; // endif; thumbnail.
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
					echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
					the_title_attribute(
						array(
							'before' => __( 'Permalink to: ', 'newkarma' ),
							'after'  => '',
							'echo'   => false,
						)
					);
					echo '" rel="bookmark">';
					the_title();
					echo '</a>';
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
