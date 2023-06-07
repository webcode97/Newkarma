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

if ( ! newkarma_is_amp() ) {
	if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) {
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
	<?php
	}
}
?>


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
				<?php
				if ( newkarma_is_amp() ) {
					/* Add Non AMP Version using <div id="site-version-switcher"> and id="version-switch-link" */
					$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
					echo '<div id="site-version-switcher"><a id="version-switch-link" href="' . esc_url( $nonamp_link ) . '" class="amp-wp-canonical-link" title="' . __( 'Non AMP Version', 'newkarma' ) . '" rel="noamphtml">' . __( 'Non AMP Version', 'newkarma' ) . '</a></div>';
				}
				?>
			</div>
		</div>
	</footer><!-- #colophon -->

<?php
	if ( ! newkarma_is_amp() ) {
		do_action( 'newkarma_core_floating_footer' );
		echo '<div class="gmr-ontop gmr-hide"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M12 22V7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M5 14l7-7l7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 2h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg></div>';
	}
?>

<?php if ( newkarma_is_amp() ) { ?>
	<amp-sidebar id="navigationamp" layout="nodisplay" side="left">
		<div id="gmr-logoamp">
			<?php do_action( 'gmr_the_custom_logo' ); ?>
		</div>
		<button on="tap:navigationamp.close" class="close-topnavmenu-wrap"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M685.4 354.8c0-4.4-3.6-8-8-8l-66 .3L512 465.6l-99.3-118.4l-66.1-.3c-4.4 0-8 3.5-8 8c0 1.9.7 3.7 1.9 5.2l130.1 155L340.5 670a8.32 8.32 0 0 0-1.9 5.2c0 4.4 3.6 8 8 8l66.1-.3L512 564.4l99.3 118.4l66 .3c4.4 0 8-3.5 8-8c0-1.9-.7-3.7-1.9-5.2L553.5 515l130.1-155c1.2-1.4 1.8-3.3 1.8-5.2z" fill="currentColor"/><path d="M512 65C264.6 65 64 265.6 64 513s200.6 448 448 448s448-200.6 448-448S759.4 65 512 65zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/></svg></button>
		<div class="wrapmenu">
			<?php
			// Option remove search button.
			$setting    = 'gmr_active-searchbutton';
			$mod_search = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( 0 === $mod_search ) :
				?>
				<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="text" name="s" id="s" placeholder="<?php echo esc_html__( 'Search News', 'newkarma' ); ?>" />
				</form>
			<?php endif; ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => 'ul',
					'menu_id'        => 'amp-primary-menu',
					'link_before'    => '<span itemprop="name">',
					'link_after'     => '</span>',
				)
			);
			?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'secondary',
					'container'      => 'ul',
					'menu_id'        => 'amp-primary-menu',
					'link_before'    => '<span itemprop="name">',
					'link_after'     => '</span>',
				)
			);
			?>
		</div>
	</amp-sidebar>
<?php } ?>

<?php wp_footer(); ?>

</body>
</html>
