<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gmr_body_classes' ) ) :
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function gmr_body_classes( $classes ) {

		$classes[] = 'gmr-theme';

		$sticky_menu = get_theme_mod( 'gmr_sticky_menu', 'sticky' );

		// Disable thumbnail options via customizer.
		$thumbnail = get_theme_mod( 'gmr_active-blogthumb', 0 );

		if ( 'sticky' === $sticky_menu ) {
			$classes[] = 'gmr-sticky';
		} else {
			$classes[] = 'gmr-no-sticky';
		}

		if ( 0 !== $thumbnail ) {
			$classes[] = 'gmr-disable-thumbnail';
		}

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}
		
		if ( newkarma_is_amp() ) {
			if ( wp_is_mobile() ) {
				if ( has_nav_menu( 'mobilemenu' ) ) {
					$classes[] = 'has-menumobile';
				}
			}
		}

		$layout = get_theme_mod( 'gmr_active-sticky-sidebar', 0 );

		if ( 0 !== $layout ) {
			$classes[] = 'gmr-disable-sticky';
		}

		return $classes;
	}
endif; // endif gmr_body_classes.
add_filter( 'body_class', 'gmr_body_classes' );

if ( ! function_exists( 'gmr_remove_hentry' ) ) :
	/**
	 * Remove Remove 'hentry' from post_class()
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the article element.
	 * @return array
	 */
	function gmr_remove_hentry( $classes ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		return $classes;
	}
endif; // endif gmr_remove_hentry.
add_filter( 'post_class', 'gmr_remove_hentry' );

if ( ! function_exists( 'gmr_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for singularly identifiable articles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
		}
	}
endif;
add_action( 'wp_head', 'gmr_pingback_header' );

if ( ! function_exists( 'gmr_add_img_title' ) ) :
	/**
	 * Add a image title tag.
	 *
	 * @since 1.0.0
	 * @param array $attr attribute image.
	 * @param array $attachment returning attacment.
	 * @return array
	 */
	function gmr_add_img_title( $attr, $attachment = null ) {
		$attr['title'] = trim( wp_strip_all_tags( $attachment->post_title ) );
		return $attr;
	}
endif;
add_filter( 'wp_get_attachment_image_attributes', 'gmr_add_img_title', 10, 2 );

if ( ! function_exists( 'gmr_add_title_alt_gravatar' ) ) :
	/**
	 * Add a gravatar title and alt tag.
	 *
	 * @since 1.0.0
	 * @param string $text Text attribute gravatar.
	 * @return string
	 */
	function gmr_add_title_alt_gravatar( $text ) {
		$text = str_replace( 'alt=\'\'', 'alt=\'' . __( 'Gravatar Image', 'newkarma' ) . '\' title=\'' . __( 'Gravatar', 'newkarma' ) . '\'', $text );
		return $text;
	}
endif;
add_filter('get_avatar', 'gmr_add_title_alt_gravatar');

if ( ! function_exists( 'gmr_thumbnail_upscale' ) ) :
	/**
	 * Thumbnail upscale
	 *
	 * @since 1.0.0
	 *
	 * @Source http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail
	 * @param array $default for image sizes.
	 * @param array $orig_w for width orginal.
	 * @param array $orig_h for height sizes image original.
	 * @param array $new_w new width image sizes.
	 * @param array $new_h new height image sizes.
	 * @param bool  $crop croping for image sizes.
	 * @return array
	 */
	function gmr_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		if ( ! $crop ) {
			return null; // let the WordPress default function handle this.
		}
		$size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

		$crop_w = round( $new_w / $size_ratio );
		$crop_h = round( $new_h / $size_ratio );

		$s_x = floor( ( $orig_w - $crop_w ) / 2 );
		$s_y = floor( ( $orig_h - $crop_h ) / 2 );

		if ( is_array( $crop ) ) {

			// Handles left, right and center (no change).
			if ( 'left' === $crop[0] ) {
				$s_x = 0;
			} elseif ( 'right' === $crop[0] ) {
				$s_x = $orig_w - $crop_w;
			}

			// Handles top, bottom and center (no change).
			if ( 'top' === $crop[1] ) {
				$s_y = 0;
			} elseif ( 'bottom' === $crop[1] ) {
				$s_y = $orig_h - $crop_h;
			}
		}
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
endif; // endif gmr_thumbnail_upscale.
add_filter( 'image_resize_dimensions', 'gmr_thumbnail_upscale', 10, 6 );

if ( ! function_exists( 'newkarma_itemtype_schema' ) ) :
	/**
	 * Figure out which schema tags to apply to the <article> element
	 * The function determines the itemtype: newkarma_itemtype_schema( 'CreativeWork' )
	 *
	 * @since 1.0.0
	 * @param string $type Text attributes for scheme.
	 * @return string
	 */
	function newkarma_itemtype_schema( $type = 'CreativeWork' ) {
		$schema = 'https://schema.org/';

		// Get the itemtype.
		$itemtype = apply_filters( 'newkarma_article_itemtype', $type );

		// Print the results.
		$scope = 'itemscope="itemscope" itemtype="' . $schema . $itemtype . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'newkarma_itemprop_schema' ) ) :
	/**
	 * Figure out which schema tags itemprop=""
	 * The function determines the itemprop: newkarma_itemprop_schema( 'headline' )
	 *
	 * @since 1.0.0
	 * @param string $type Text attributes for scheme.
	 * @return string
	 */
	function newkarma_itemprop_schema( $type = 'headline' ) {
		// Get the itemprop.
		$itemprop = apply_filters( 'newkarma_itemprop_filter', $type );

		// Print the results.
		$scope = 'itemprop="' . $itemprop . '"';
		return $scope;
	}
endif;

if ( ! function_exists( 'newkarma_custom_js' ) ) :
	/**
	 * Add custom js to footer
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function newkarma_custom_js() {
		if ( ! newkarma_is_amp() ) {
			// Slider.
			$slider         = get_theme_mod( 'gmr_active-headline', 0 );
			$slider_archive = get_theme_mod( 'gmr_active-headlinearchive', 0 );
			if ( ( 0 === $slider ) || ( 0 === $slider_archive ) ) {
				if ( is_home() || is_archive() ) {
					echo '<script id="newkarma-slide-js">';
					echo '(function( slider ) {';
					echo '"use strict";';
						echo 'var slider = tns({';
							echo 'container: \'.gmr-owl-carousel\',';
							echo 'loop: true,';
							echo 'gutter: 0,';
							echo 'edgePadding: 0,';
							echo 'controlsText: [\'&laquo;\', \'&raquo;\'],';
							echo 'items: 3,';
							echo 'swipeAngle: false,';
							echo 'mouseDrag: true,';
							echo 'nav: false,';
							echo 'autoplay: true,';
							echo 'autoplayButtonOutput: false,';
							echo 'responsive : {';
								echo '0 : {';
									echo 'items : 1,';
								echo '},';
								echo '250 : {';
									echo 'items : 1,';
								echo '},';
								echo '400 : {';
									echo 'items : 1,';
								echo '},';
								echo '600 : {';
									echo 'items : 2,';
								echo '},';
								echo '1000 : {';
									echo 'items : 3,';
								echo '}';
							echo '}';
						echo '});';
					echo '})( window.slider );';
					echo '</script>';
				}
			}
			
			// load More.
			$loadmore   = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
			if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) ) {
				echo '<script id="newkarma-loadmore-js">';
				echo '(function( infScroll ) {';
					echo '"use strict";';
					echo 'var elem = document.getElementById( \'gmr-main-load\' );';
					echo 'var elempag = document.querySelector( \'.inf-pagination .next\' );';
					echo 'if ( ( typeof( elem ) != \'undefined\' && elem != null ) && ( typeof( elempag ) != \'undefined\' && elempag != null ) ) {';
						echo 'var infScroll = new InfiniteScroll( elem, {';
							echo 'path: \'.inf-pagination .next\',';
							echo 'append: \'.item-infinite\',';
							echo 'history: false,';
							if ( 'gmr-more' === $loadmore ) {
								echo 'scrollThreshold: false,';
								echo 'button: \'.view-more-button\',';
							}
							echo 'status: \'.page-load-status\',';
						echo '});';
					echo '} else {';
						echo 'var elembtn = document.querySelector( \'.view-more-button\' );';
						echo 'if ( typeof( elembtn ) != \'undefined\' && elembtn != null ) {';
							echo 'elembtn.style.display = \'none\';';
						echo '}';
					echo '}';
				echo '})( window.infScroll );';
				echo '</script>';
			}
			
		}
	}
endif;
add_action( 'wp_footer', 'newkarma_custom_js', 25 );
