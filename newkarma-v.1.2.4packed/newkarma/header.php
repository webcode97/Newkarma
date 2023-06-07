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
					if ( ! newkarma_is_amp() ) {
						$setting  = 'gmr_active-date';
						$mod_date = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
						if ( 0 === $mod_date ) {
							?>
							<div class="gmr-table-cell gmr-table-date">
								<span class="gmr-top-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ) ) ); ?></span>
							</div>
							<?php
						}
					}
					?>
					<div class="gmr-table-cell gmr-table-search">
						<?php
						if ( newkarma_is_amp() ) {
							do_action( 'gmr_the_custom_logo' );
						} else {
							echo '<div class="only-mobile gmr-mobilelogo">';
								do_action( 'gmr_the_custom_logo' );
							echo '</div>';
							// Option remove search button.
							$setting    = 'gmr_active-searchbutton';
							$mod_search = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
							if ( 0 === $mod_search ) {
								?>
							<div class="gmr-search">
								<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
									<input type="text" name="s" id="s" placeholder="<?php echo esc_html__( 'Search News', 'newkarma' ); ?>" />
									<button type="submit" class="gmr-search-submit"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></g></svg></button>
								</form>
							</div>
							<?php
							}
						}
						?>
					</div>

					<div class="gmr-table-cell gmr-table-menu">
						<?php if ( ! newkarma_is_amp() ) { ?>
						<a id="gmr-topnavresponsive-menu" href="#menus" title="Menus" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" fill="currentColor"/></svg></a>
						<div class="close-topnavmenu-wrap"><a id="close-topnavmenu-button" rel="nofollow" href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M685.4 354.8c0-4.4-3.6-8-8-8l-66 .3L512 465.6l-99.3-118.4l-66.1-.3c-4.4 0-8 3.5-8 8c0 1.9.7 3.7 1.9 5.2l130.1 155L340.5 670a8.32 8.32 0 0 0-1.9 5.2c0 4.4 3.6 8 8 8l66.1-.3L512 564.4l99.3 118.4l66 .3c4.4 0 8-3.5 8-8c0-1.9-.7-3.7-1.9-5.2L553.5 515l130.1-155c1.2-1.4 1.8-3.3 1.8-5.2z" fill="currentColor"/><path d="M512 65C264.6 65 64 265.6 64 513s200.6 448 448 448s448-200.6 448-448S759.4 65 512 65zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/></svg></a></div>
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
						<?php } else { ?>
							<button id="gmr-topnavresponsive-menu" on='tap:navigationamp.toggle' title="Menus" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z" fill="currentColor"/></svg></button>
						<?php } ?>
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
<?php if ( ! newkarma_is_amp() ) { ?>
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
<?php } ?>


<div class="site inner-wrap" id="site-container">
	<?php
	if ( ! newkarma_is_amp() ) {
		do_action( 'newkarma_core_floating_banner_left' );
		do_action( 'newkarma_core_floating_banner_right' );
	}
	?>
	<div id="content" class="gmr-content">
		<?php do_action( 'newkarma_core_top_banner_after_menu' ); ?>
		<div class="container">
			<div class="row">
