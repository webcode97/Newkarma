<?php
/**
 * Template part for displaying page content in page.php.
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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php echo newkarma_itemtype_schema( 'CreativeWork' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

	<div class="gmr-single">
		<div class="gmr-box-content-single">
		<header class="entry-header">
			<?php the_title( '<h1 class="title" ' . newkarma_itemprop_schema( 'headline' ) . '>', '</h1>' ); ?>
			<div class="screen-reader-text">
				<?php gmr_posted_on(); ?>
			</div>
		</header><!-- .entry-header -->

		<div class="entry-content entry-content-single" <?php echo newkarma_itemprop_schema( 'text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
				the_content();
			?>
		</div><!-- .entry-content -->

		<?php edit_post_link( __( 'Edit', 'newkarma' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>
		</div><!-- .gmr-box-content -->
	</div><!-- .gmr-single -->
</article><!-- #post-## -->
