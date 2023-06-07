<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

			</div><!-- .row -->
		</div><!-- .container -->
		<div id="stop-container"></div>
	</div><!-- .gmr-content -->
</div><!-- #site-container -->


<?php
$mod = get_theme_mod( 'gmr_footer_column', '3col' );
if ( '4col' === $mod ) {
	$class = 'col-md-footer3';
} elseif ( '3col' === $mod ) {
	$class = 'col-md-footer4';
} elseif ( '2col' === $mod ) {
	$class = 'col-md-footer6';
} else {
	$class = 'col-md-main';
}

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) :
	?>
	<div id="footer-container">
		<div id="footer-sidebar" class="widget-footer" role="complementary">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="footer-column <?php echo esc_html( $class ); ?>">
							<?php dynamic_sidebar( 'footer-4' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div><!-- #footer-container -->
<?php endif; ?>


	<footer id="colophon" class="site-footer" role="contentinfo" <?php newkarma_itemtype_schema( 'WPFooter' ); ?>>
		<div class="container">
			<div class="row">
				<div class="clearfix footer-content">
					<?php do_action( 'gmr_infooter_logo' ); ?>
					<?php do_action( 'gmr_footer_social' ); ?>
				</div>
				<?php
				$copyright = get_theme_mod( 'gmr_copyright' );
				if ( $copyright ) :
					// Sanitize html output than convert it again using htmlspecialchars_decode.
					echo '<span class="pull-left theme-copyright">';
						echo wp_kses_post( $copyright );
					echo '</span>';
				else :
					?>
					<a href="<?php echo esc_url( __( 'https://www.idtheme.com/newkarma/', 'newkarma' ) ); ?>" class="theme-copyright pull-left" title="<?php esc_html_e( 'Theme: Newkarma', 'newkarma' ); ?>">
						<?php esc_html_e( 'Copyright &copy; Newkarma', 'newkarma' ); ?>
					</a>
				<?php endif; ?>
				<?php
				// Second top menu.
				if ( has_nav_menu( 'copyrightnav' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'copyrightnav',
							'container'      => 'ul',
							'menu_id'        => 'copyright-menu',
							'depth'          => 1,
						)
					);
				}
				?>
			</div>
		</div>
	</footer><!-- #colophon -->

<?php do_action( 'newkarma_core_floating_footer' ); ?>

<div class="gmr-ontop gmr-hide"><span class="arrow_up"></span></div>

<?php wp_footer(); ?>

</body>
</html>
