<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head <?php echo newkarma_itemtype_schema( 'WebSite' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$chrome_color = get_theme_mod( 'gmr_chrome_mobile_color' );
if ( $chrome_color ) :
	$color = sanitize_hex_color( $chrome_color );
	?>
<meta name="theme-color" content="<?php echo esc_html( $color ); ?>" />
	<?php
endif;
?>
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo newkarma_itemtype_schema( 'WebPage' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
<?php do_action( 'wp_body_open' ); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'newkarma' ); ?></a>

<?php
	// Menu style via customizer.
	$menu_style = get_theme_mod( 'gmr_menu_style', 'gmr-boxmenu' );
?>

<div class="top-header-second">
	<div class="gmr-topnavwrap clearfix">
		<div class="container-topnav">
			<div class="gmr-list-table">
				<div class="gmr-table-row">
					<?php
					// Date.
					// Option remove date.
					$setting  = 'gmr_active-date';
					$mod_date = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
					if ( 0 === $mod_date ) :
						?>
						<div class="gmr-table-cell gmr-table-date">
							<span class="gmr-top-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ) ) ); ?></span>
						</div>
					<?php endif; ?>
						<div class="gmr-table-cell gmr-table-search">
							<div class="only-mobile gmr-mobilelogo">
								<?php do_action( 'gmr_the_custom_logo' ); ?>
							</div>
							<?php
							// Option remove search button.
							$setting    = 'gmr_active-searchbutton';
							$mod_search = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
							if ( 0 === $mod_search ) :
								?>
							<div class="gmr-search">
								<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input type="text" name="s" id="s" placeholder="<?php echo esc_html__( 'Search News', 'newkarma' ); ?>" />
									<button type="submit" class="gmr-search-submit"><span class="icon_search"></span></button>
								</form>
							</div>
							<?php endif; ?>
						</div>

					<div class="gmr-table-cell gmr-table-menu">
						<a id="gmr-topnavresponsive-menu" href="#menus" title="Menus" rel="nofollow"></a>
						<div class="close-topnavmenu-wrap"><a id="close-topnavmenu-button" rel="nofollow" href="#"><span class="icon_close_alt2"></span></a></div>
						<nav id="site-navigation" class="gmr-topnavmenu pull-right" role="navigation" <?php echo newkarma_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
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
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
			<?php
			if ( wp_is_mobile() ) {
				if ( has_nav_menu( 'mobilemenu' ) ) {
					echo '<div class="gmr-mobilemenu clearfix">';
					wp_nav_menu(
						array(
							'theme_location' => 'mobilemenu',
							'fallback_cb'    => false,
							'container'      => 'ul',
							'menu_id'        => 'mobile-menu',
							'depth'          => 1,
							'link_before'    => '<span itemprop="name">',
							'link_after'     => '</span>',
						)
					);
					echo '</div>';
				}
			}
			?>
		</div>
	</div>
</div>

<div class="container">
	<div class="clearfix gmr-headwrapper">
		<?php do_action( 'gmr_the_custom_logo' ); ?>
		<?php do_action( 'newkarma_core_top_banner' ); ?>
	</div>
</div>

<header id="masthead" class="site-header" role="banner" <?php echo newkarma_itemtype_schema( 'WPHeader' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
	<div class="top-header">
		<div class="container">
			<div class="gmr-menuwrap clearfix">
				<nav id="site-navigation" class="gmr-mainmenu" role="navigation" <?php echo newkarma_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
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
				</nav><!-- #site-navigation -->
			</div>
			<?php
			// Second top menu.
			if ( has_nav_menu( 'secondary' ) ) {
				?>
						<div class="gmr-secondmenuwrap clearfix">
							<nav id="site-navigation" class="gmr-secondmenu" role="navigation" <?php echo newkarma_itemtype_schema( 'SiteNavigationElement' ); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>>
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
							</nav><!-- #site-navigation -->
						</div>
				<?php
			}
			?>
		</div>
	</div><!-- .top-header -->
</header><!-- #masthead -->


<div class="site inner-wrap" id="site-container">
	<?php do_action( 'newkarma_core_floating_banner_left' ); ?>
	<?php do_action( 'newkarma_core_floating_banner_right' ); ?>
	<div id="content" class="gmr-content">
		<?php do_action( 'newkarma_core_top_banner_after_menu' ); ?>
		<div class="container">
			<div class="row">
