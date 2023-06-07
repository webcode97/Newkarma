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

<div class="top-header-second">
	<div class="gmr-topnavwrap clearfix">
		<div class="container-topnav">
			<div class="gmr-list-table">
				<div class="gmr-table-row">
					<div class="gmr-table-cell gmr-table-search">
						<?php do_action( 'gmr_the_custom_logo' ); ?>
					</div>
					<div class="gmr-table-cell gmr-table-menu">
						<button id="gmr-topnavresponsive-menu" on='tap:navigationamp.toggle' title="Menus" rel="nofollow"></button>
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

<div class="site inner-wrap" id="site-container">
	<div id="content" class="gmr-content">
		<?php do_action( 'newkarma_core_top_banner_after_menu' ); ?>
		<div class="container">
			<div class="row">
