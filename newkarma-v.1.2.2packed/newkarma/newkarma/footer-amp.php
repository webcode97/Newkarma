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
				/* Add Non AMP Version using <div id="site-version-switcher"> and id="version-switch-link" */
				$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
				echo '<div id="site-version-switcher"><a id="version-switch-link" href="' . esc_url( $nonamp_link ) . '" class="amp-wp-canonical-link" title="' . __( 'Non AMP Version', 'newkarma' ) . '" rel="noamphtml">' . __( 'Non AMP Version', 'newkarma' ) . '</a></div>';			
			?>
		</div>
	</div>
</footer><!-- #colophon -->

<amp-sidebar id="navigationamp" layout="nodisplay" side="left">
	<div id="gmr-logoamp">
		<?php do_action( 'gmr_the_custom_logo' ); ?>
	</div>
	<button on="tap:navigationamp.close" class="close-topnavmenu-wrap"><span class="icon_close_alt2"></span></button>
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
			'menu_id'        => 'primary-menu',
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
			'menu_id'        => 'primary-menu',
			'link_before'    => '<span itemprop="name">',
			'link_after'     => '</span>',
		)
	);
	?>
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'topnav',
			'fallback_cb'    => 'newkarma_add_link_adminmenu',
			'container'      => 'ul',
			'menu_id'        => 'primary-menu',
			'link_before'    => '<span itemprop="name">',
			'link_after'     => '</span>',
		)
	);
	?>
</amp-sidebar>

<?php wp_footer(); ?>

</body>
</html>
