<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gmr_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_posted_on() {
		$time_string = '<time class="entry-date published updated" ' . newkarma_itemprop_schema( 'dateModified' ) . ' datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" ' . newkarma_itemprop_schema( 'datePublished' ) . ' datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'newkarma' ) );
		$posted_in       = '';
		if ( $categories_list ) {
			$posted_in = sprintf( '<span class="cat-links">%1$s</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on   = sprintf( '%s', $time_string );
		$filtertitle = str_replace( ' ', '%20', get_the_title() );
		$url         = rawurlencode( get_permalink() );

		$posted_by = sprintf(
			esc_html__( 'by', 'newkarma' ) . ' %s',
			'<span class="entry-author vcard screen-reader-text" ' . newkarma_itemprop_schema( 'author' ) . ' ' . newkarma_itemtype_schema( 'person' ) . '><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . __( 'Permalink to: ', 'newkarma' ) . esc_html( get_the_author() ) . '" ' . newkarma_itemprop_schema( 'url' ) . '><span ' . newkarma_itemprop_schema( 'name' ) . '>' . esc_html( get_the_author() ) . '</span></a></span>'
		);
		if ( is_single() ) {
			echo '<div class="gmr-metacontent"><span class="posted-on">' . $posted_on . '</span><span class="screen-reader-text">' . $posted_by . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		} else {
			echo '<div class="gmr-metacontent">' . $posted_in . '<span class="posted-on"><span class="byline">|</span>' . $posted_on . '</span><span class="screen-reader-text">' . $posted_by . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif; // endif gmr_posted_on.

if ( ! function_exists( 'gmr_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list ) {
				printf( '<span class="tags-links">%1$s</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'newkarma' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif; // endif gmr_entry_footer.

if ( ! function_exists( 'gmr_single_social' ) ) :
	/**
	 * This function add social icon in single footer.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function gmr_single_social() {

		// Option remove search button.
		$setting    = 'gmr_active-footersocial';
		$mod_social = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		// Social settings.
		$fb_url          = get_theme_mod( 'gmr_fb_url_icon' );
		$twitter_url     = get_theme_mod( 'gmr_twitter_url_icon' );
		$pinterest_url   = get_theme_mod( 'gmr_pinterest_url_icon' );
		$tumblr_url      = get_theme_mod( 'gmr_tumblr_url_icon' );
		$stumbleupon_url = get_theme_mod( 'gmr_stumbleupon_url_icon' );
		$wordpress_url   = get_theme_mod( 'gmr_wordpress_url_icon' );
		$instagram_url   = get_theme_mod( 'gmr_instagram_url_icon' );
		$dribbble_url    = get_theme_mod( 'gmr_dribbble_url_icon' );
		$vimeo_url       = get_theme_mod( 'gmr_vimeo_url_icon' );
		$linkedin_url    = get_theme_mod( 'gmr_linkedin_url_icon' );
		$deviantart_url  = get_theme_mod( 'gmr_deviantart_url_icon' );
		$skype_url       = get_theme_mod( 'gmr_skype_url_icon' );
		$youtube_url     = get_theme_mod( 'gmr_youtube_url_icon' );
		$myspace_url     = get_theme_mod( 'gmr_myspace_url_icon' );
		$picassa_url     = get_theme_mod( 'gmr_picassa_url_icon' );
		$flickr_url      = get_theme_mod( 'gmr_flickr_url_icon' );
		$blogger_url     = get_theme_mod( 'gmr_blogger_url_icon' );
		$spotify_url     = get_theme_mod( 'gmr_spotify_url_icon' );
		$rssicon         = get_theme_mod( 'gmr_active-rssicon', 0 );

		if ( $fb_url || $twitter_url || $pinterest_url || $tumblr_url || $stumbleupon_url || $wordpress_url || $instagram_url || $dribbble_url || $vimeo_url ||
		$linkedin_url || $deviantart_url || $skype_url || $youtube_url || $myspace_url || $picassa_url || $flickr_url || $blogger_url || $spotify_url || 0 === $rssicon ) :
			if ( 0 === $mod_social ) :
				echo '<ul class="single-social-icon pull-right">';
				echo '<li class="social-text">' . esc_html__( 'Follow Us', 'newkarma' ) . '</li>';
				if ( $fb_url ) :
					echo '<li class="facebook"><a href="' . esc_url( $fb_url ) . '" title="' . esc_html__( 'Facebook', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_facebook"></span></a></li>';
				endif;

				if ( $twitter_url ) :
					echo '<li class="twitter"><a href="' . esc_url( $twitter_url ) . '" title="' . esc_html__( 'Twitter', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_twitter"></span></a></li>';
				endif;

				if ( $pinterest_url ) :
					echo '<li class="pinterest"><a href="' . esc_url( $pinterest_url ) . '" title="' . esc_html__( 'Pinterest', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_pinterest"></span></a></li>';
				endif;

				if ( $tumblr_url ) :
					echo '<li class="tumblr"><a href="' . esc_url( $tumblr_url ) . '" title="' . esc_html__( 'Tumblr', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_tumblr"></span></a></li>';
				endif;

				if ( $stumbleupon_url ) :
					echo '<li class="stumbleupon"><a href="' . esc_url( $stumbleupon_url ) . '" title="' . esc_html__( 'Stumbleupon', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_tumbleupon"></span></a></li>';
				endif;

				if ( $wordpress_url ) :
					echo '<li class="wordpress"><a href="' . esc_url( $wordpress_url ) . '" title="' . esc_html__( 'WordPress', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_wordpress"></span></a></li>';
				endif;

				if ( $instagram_url ) :
					echo '<li class="instagram"><a href="' . esc_url( $instagram_url ) . '" title="' . esc_html__( 'Instagram', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_instagram"></span></a></li>';
				endif;

				if ( $dribbble_url ) :
					echo '<li class="dribble"><a href="' . esc_url( $dribbble_url ) . '" title="' . esc_html__( 'Dribbble', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_dribbble"></span></a></li>';
				endif;

				if ( $vimeo_url ) :
					echo '<li class="vimeo"><a href="' . esc_url( $vimeo_url ) . '" title="' . esc_html__( 'Vimeo', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_vimeo"></span></a></li>';
				endif;

				if ( $linkedin_url ) :
					echo '<li class="linkedin"><a href="' . esc_url( $linkedin_url ) . '" title="' . esc_html__( 'Linkedin', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_linkedin"></span></a></li>';
				endif;

				if ( $deviantart_url ) :
					echo '<li class="devianart"><a href="' . esc_url( $deviantart_url ) . '" title="' . esc_html__( 'Deviantart', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_deviantart"></span></a></li>';
				endif;

				if ( $myspace_url ) :
					echo '<li class="myspace"><a href="' . esc_url( $myspace_url ) . '" title="' . esc_html__( 'Myspace', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_myspace"></span></a></li>';
				endif;

				if ( $skype_url ) :
					echo '<li class="skype"><a href="' . esc_url( $skype_url ) . '" title="' . esc_html__( 'Skype', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_skype"></span></a></li>';
				endif;

				if ( $youtube_url ) :
					echo '<li class="youtube"><a href="' . esc_url( $youtube_url ) . '" title="' . esc_html__( 'Youtube', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_youtube"></span></a></li>';
				endif;

				if ( $picassa_url ) :
					echo '<li class="picassa"><a href="' . esc_url( $picassa_url ) . '" title="' . esc_html__( 'Picassa', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_picassa"></span></a></li>';
				endif;

				if ( $flickr_url ) :
					echo '<li class="flickr"><a href="' . esc_url( $flickr_url ) . '" title="' . esc_html__( 'Flickr', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_flickr"></span></a></li>';
				endif;

				if ( $blogger_url ) :
					echo '<li class="blogger"><a href="' . esc_url( $blogger_url ) . '" title="' . esc_html__( 'Blogger', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_blogger"></span></a></li>';
				endif;

				if ( $spotify_url ) :
					echo '<li class="spotify"><a href="' . esc_url( $spotify_url ) . '" title="' . esc_html__( 'Spotify', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_spotify"></span></a></li>';
				endif;

				$delicious_url = get_theme_mod( 'gmr_delicious_url_icon' );
				if ( $delicious_url ) :
					echo '<li class="delicious"><a href="' . esc_url( $delicious_url ) . '" title="' . esc_html__( 'Delicious', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_delicious"></span></a></li>';
				endif;

				if ( 0 === $rssicon ) :
					echo '<li class="rssicon"><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_html__( 'RSS', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_rss"></span></a></li>';
				endif;

				echo '</ul>';
			endif;
		endif;
	}
endif; // endif gmr_gmr_single_social.
add_filter( 'gmr_single_social', 'gmr_single_social', 15, 2 );

if ( ! function_exists( 'gmr_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 22 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function gmr_custom_excerpt_length( $length ) {
		$length = get_theme_mod( 'gmr_excerpt_number', '22' );
		// absint sanitize int non minus.
		return absint( $length );
	}
endif; // endif gmr_custom_excerpt_length.
add_filter( 'excerpt_length', 'gmr_custom_excerpt_length', 999 );

if ( ! function_exists( 'gmr_custom_readmore' ) ) :
	/**
	 * Filter the except length to 20 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more HTML more.
	 * @return string read more.
	 */
	function gmr_custom_readmore( $more ) {
		$more = get_theme_mod( 'gmr_read_more' );
		if ( '' === $more ) {
			return '';
		} else {
			return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '" title="' . get_the_title( get_the_ID() ) . '" ' . newkarma_itemprop_schema( 'url' ) . '>' . esc_html( $more ) . '</a>';
		}
	}
endif; // endif gmr_custom_readmore.
add_filter( 'excerpt_more', 'gmr_custom_readmore' );

if ( ! function_exists( 'gmr_get_pagination' ) ) :
	/**
	 * Retrieve paginated link for archive post pages.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function gmr_get_pagination() {
		global $wp_rewrite;
		global $wp_query;
		return paginate_links(
			apply_filters(
				'gmr_get_pagination_args',
				array(
					'base'      => str_replace( '99999', '%#%', esc_url( get_pagenum_link( 99999 ) ) ),
					'format'    => $wp_rewrite->using_permalinks() ? 'page/%#%' : '?paged=%#%',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'prev_text' => __( 'Prev', 'newkarma' ),
					'next_text' => __( 'Next', 'newkarma' ),
					'type'      => 'list',
				)
			)
		);
	}
endif; // endif gmr_get_pagination.

if ( ! function_exists( 'gmr_footer_social' ) ) :
	/**
	 * This function add social in footer
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_footer_social() {
		// Option remove search button.
		$setting    = 'gmr_active-socialnetwork';
		$mod_social = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		// Social settings.
		$fb_url          = get_theme_mod( 'gmr_fb_url_icon' );
		$twitter_url     = get_theme_mod( 'gmr_twitter_url_icon' );
		$pinterest_url   = get_theme_mod( 'gmr_pinterest_url_icon' );
		$tumblr_url      = get_theme_mod( 'gmr_tumblr_url_icon' );
		$stumbleupon_url = get_theme_mod( 'gmr_stumbleupon_url_icon' );
		$wordpress_url   = get_theme_mod( 'gmr_wordpress_url_icon' );
		$instagram_url   = get_theme_mod( 'gmr_instagram_url_icon' );
		$dribbble_url    = get_theme_mod( 'gmr_dribbble_url_icon' );
		$vimeo_url       = get_theme_mod( 'gmr_vimeo_url_icon' );
		$linkedin_url    = get_theme_mod( 'gmr_linkedin_url_icon' );
		$deviantart_url  = get_theme_mod( 'gmr_deviantart_url_icon' );
		$skype_url       = get_theme_mod( 'gmr_skype_url_icon' );
		$youtube_url     = get_theme_mod( 'gmr_youtube_url_icon' );
		$myspace_url     = get_theme_mod( 'gmr_myspace_url_icon' );
		$picassa_url     = get_theme_mod( 'gmr_picassa_url_icon' );
		$flickr_url      = get_theme_mod( 'gmr_flickr_url_icon' );
		$blogger_url     = get_theme_mod( 'gmr_blogger_url_icon' );
		$spotify_url     = get_theme_mod( 'gmr_spotify_url_icon' );
		$rssicon         = get_theme_mod( 'gmr_active-rssicon', 0 );

		if ( $fb_url || $twitter_url || $pinterest_url || $tumblr_url || $stumbleupon_url || $wordpress_url || $instagram_url || $dribbble_url || $vimeo_url ||
		$linkedin_url || $deviantart_url || $skype_url || $youtube_url || $myspace_url || $picassa_url || $flickr_url || $blogger_url || $spotify_url || 0 === $rssicon ) :
			if ( 0 === $mod_social ) :
				echo '<ul class="footer-social-icon pull-right">';
				if ( $fb_url ) :
					echo '<li class="facebook"><a href="' . esc_url( $fb_url ) . '" title="' . esc_html__( 'Facebook', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_facebook"></span></a></li>';
				endif;

				if ( $twitter_url ) :
					echo '<li class="twitter"><a href="' . esc_url( $twitter_url ) . '" title="' . esc_html__( 'Twitter', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_twitter"></span></a></li>';
				endif;

				if ( $pinterest_url ) :
					echo '<li class="pinterest"><a href="' . esc_url( $pinterest_url ) . '" title="' . esc_html__( 'Pinterest', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_pinterest"></span></a></li>';
				endif;

				if ( $tumblr_url ) :
					echo '<li class="tumblr"><a href="' . esc_url( $tumblr_url ) . '" title="' . esc_html__( 'Tumblr', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_tumblr"></span></a></li>';
				endif;

				if ( $stumbleupon_url ) :
					echo '<li class="stumbleupon"><a href="' . esc_url( $stumbleupon_url ) . '" title="' . esc_html__( 'Stumbleupon', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_tumbleupon"></span></a></li>';
				endif;

				if ( $wordpress_url ) :
					echo '<li class="wordpress"><a href="' . esc_url( $wordpress_url ) . '" title="' . esc_html__( 'WordPress', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_wordpress"></span></a></li>';
				endif;

				if ( $instagram_url ) :
					echo '<li class="instagram"><a href="' . esc_url( $instagram_url ) . '" title="' . esc_html__( 'Instagram', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_instagram"></span></a></li>';
				endif;

				if ( $dribbble_url ) :
					echo '<li class="dribble"><a href="' . esc_url( $dribbble_url ) . '" title="' . esc_html__( 'Dribbble', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_dribbble"></span></a></li>';
				endif;

				if ( $vimeo_url ) :
					echo '<li class="vimeo"><a href="' . esc_url( $vimeo_url ) . '" title="' . esc_html__( 'Vimeo', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_vimeo"></span></a></li>';
				endif;

				if ( $linkedin_url ) :
					echo '<li class="linkedin"><a href="' . esc_url( $linkedin_url ) . '" title="' . esc_html__( 'Linkedin', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_linkedin"></span></a></li>';
				endif;

				if ( $deviantart_url ) :
					echo '<li class="devianart"><a href="' . esc_url( $deviantart_url ) . '" title="' . esc_html__( 'Deviantart', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_deviantart"></span></a></li>';
				endif;

				if ( $myspace_url ) :
					echo '<li class="myspace"><a href="' . esc_url( $myspace_url ) . '" title="' . esc_html__( 'Myspace', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_myspace"></span></a></li>';
				endif;

				if ( $skype_url ) :
					echo '<li class="skype"><a href="' . esc_url( $skype_url ) . '" title="' . esc_html__( 'Skype', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_skype"></span></a></li>';
				endif;

				if ( $youtube_url ) :
					echo '<li class="youtube"><a href="' . esc_url( $youtube_url ) . '" title="' . esc_html__( 'Youtube', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_youtube"></span></a></li>';
				endif;

				if ( $picassa_url ) :
					echo '<li class="picassa"><a href="' . esc_url( $picassa_url ) . '" title="' . esc_html__( 'Picassa', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_picassa"></span></a></li>';
				endif;

				if ( $flickr_url ) :
					echo '<li class="flickr"><a href="' . esc_url( $flickr_url ) . '" title="' . esc_html__( 'Flickr', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_flickr"></span></a></li>';
				endif;

				if ( $blogger_url ) :
					echo '<li class="blogger"><a href="' . esc_url( $blogger_url ) . '" title="' . esc_html__( 'Blogger', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_blogger"></span></a></li>';
				endif;

				if ( $spotify_url ) :
					echo '<li class="spotify"><a href="' . esc_url( $spotify_url ) . '" title="' . esc_html__( 'Spotify', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_spotify"></span></a></li>';
				endif;

				$delicious_url = get_theme_mod( 'gmr_delicious_url_icon' );
				if ( $delicious_url ) :
					echo '<li class="delicious"><a href="' . esc_url( $delicious_url ) . '" title="' . esc_html__( 'Delicious', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_delicious"></span></a></li>';
				endif;

				if ( 0 === $rssicon ) :
					echo '<li class="rssicon"><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_html__( 'RSS', 'newkarma' ) . '" target="_blank" rel="nofollow"><span class="social_rss"></span></a></li>';
				endif;

				echo '</ul>';
			endif;
		endif;
	}
endif; // endif gmr_footer_social.
add_filter( 'gmr_footer_social', 'gmr_footer_social', 15, 2 );

if ( ! function_exists( 'newkarma_add_menu_attribute' ) ) :
	/**
	 * Add attribute itemprop="url" to menu link
	 *
	 * @since 1.0.0
	 *
	 * @param string $atts Attribute.
	 * @param string $item Items.
	 * @param array  $args Arguments.
	 * @return string
	 */
	function newkarma_add_menu_attribute( $atts, $item, $args ) {
		$atts['itemprop'] = 'url';
		return $atts;
	}
endif; // endif newkarma_add_menu_attribute.
add_filter( 'nav_menu_link_attributes', 'newkarma_add_menu_attribute', 10, 3 );

if ( ! function_exists( 'newkarma_add_link_adminmenu' ) ) :
	/**
	 * Add default menu for fallback top menu
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function newkarma_add_link_adminmenu() {
		echo '<ul id="primary-menu">';
			echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" style="border: none !important;">' . esc_html__( 'Add a Menu', 'newkarma' ) . '</a></li>';
		echo '</ul>';
	}
endif; // endif newkarma_add_link_adminmenu.

if ( ! function_exists( 'gmr_the_custom_logo' ) ) :
	/**
	 * Print custom logo.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_the_custom_logo() {
		echo '<div class="gmr-logo">';
		// if get value from customizer gmr_logoimage.
		$setting = 'gmr_logoimage';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			// get url image from value gmr_logoimage.
			$image = esc_url_raw( $mod );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" ' . newkarma_itemprop_schema( 'url' ) . ' title="' . esc_html( get_bloginfo( 'name' ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<img src="' . $image . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '" title="' . esc_html( get_bloginfo( 'name' ) ) . '" />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</a>';

		} else {
			// if get value from customizer blogname.
			if ( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) {
				echo '<div class="site-title" ' . newkarma_itemprop_schema( 'headline' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<a href="' . esc_url( home_url( '/' ) ) . '" ' . newkarma_itemprop_schema( 'url' ) . ' title="' . esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo esc_html( get_theme_mod( 'blogname', get_bloginfo( 'name' ) ) );
					echo '</a>';
				echo '</div>';

			}
			// if get value from customizer blogdescription.
			if ( get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) ) ) {
				echo '<span class="site-description" ' . newkarma_itemprop_schema( 'description' ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo esc_html( get_theme_mod( 'blogdescription', get_bloginfo( 'description' ) ) );
				echo '</span>';

			}
		}
		echo '</div>';
	}
endif; // endif gmr_the_custom_logo.
add_action( 'gmr_the_custom_logo', 'gmr_the_custom_logo', 5 );

if ( ! function_exists( 'gmr_infooter_logo' ) ) :
	/**
	 * Print footer logo.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_infooter_logo() {
		echo '<div class="gmr-footer-logo pull-left">';
		// if get value from customizer gmr_logoimage.
		$setting = 'gmr_footer_logo';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			// get url image from value gmr_logoimage.
			$image = esc_url_raw( $mod );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-footerlogo-link" ' . newkarma_itemprop_schema( 'url' ) . ' title="' . esc_html( get_bloginfo( 'name' ) ) . '">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo '<img src="' . $image . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '" title="' . esc_html( get_bloginfo( 'name' ) ) . '" ' . newkarma_itemprop_schema( 'image' ) . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</a>';

		}
		echo '</div>';
	}
endif; // endif gmr_infooter_logo.
add_action( 'gmr_infooter_logo', 'gmr_infooter_logo', 5 );

if ( ! function_exists( 'gmr_move_post_navigation' ) ) :
	/**
	 * Move post navigation in top after content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Content.
	 * @return string $content
	 */
	function gmr_move_post_navigation( $content ) {
		if ( is_singular() && in_the_loop() ) {
			$pagination = wp_link_pages(
				array(
					'before'      => '<div class="page-links clearfix"><span class="page-text">' . esc_html__( 'Pages:', 'newkarma' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span class="page-link-number">',
					'link_after'  => '</span>',
					'echo'        => 0,
				)
			);
			$content   .= $pagination;
			return $content;
		}
		return $content;
	}
endif; // endif gmr_move_post_navigation.
add_filter( 'the_content', 'gmr_move_post_navigation', 35 );

if ( ! function_exists( 'gmr_move_post_navigation_second' ) ) :
	/**
	 * Move post navigation in top after content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Content.
	 * @return string $content
	 */
	function gmr_move_post_navigation_second( $content ) {
		if ( is_singular() && in_the_loop() ) {
			$pagination_nextprev = wp_link_pages(
				array(
					'before'         => '<div class="prevnextpost-links clearfix">',
					'after'          => '</div>',
					'next_or_number' => 'next',
					'link_before'    => '<span class="prevnextpost">',
					'link_after'     => '</span>',
					'echo'           => 0,
				)
			);
			$content            .= $pagination_nextprev;
			return $content;
		}
		return $content;
	}
endif; // endif gmr_move_post_navigation_second.
add_filter( 'the_content', 'gmr_move_post_navigation_second', 2 );

if ( ! function_exists( 'gmr_embed_oembed_html' ) ) :
	/**
	 * Add responsive oembed class only for youtube and vimeo.
	 *
	 * @add_filter embed_oembed_html
	 * @class gmr_embed_oembed_html
	 * @param string $html HTML.
	 * @param string $url url.
	 * @param string $attr Attribute.
	 * @param int    $post_id Post ID.
	 * @link https://developer.wordpress.org/reference/hooks/embed_oembed_html/
	 */
	function gmr_embed_oembed_html( $html, $url, $attr, $post_id ) {
		$classes = array();

		// Add these classes to all embeds.
		$classes_all = array(
			'gmr-video-responsive',
		);

		// Check for different providers and add appropriate classes.

		if ( false !== strpos( $url, 'vimeo.com' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		if ( false !== strpos( $url, 'youtube.com' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		if ( false !== strpos( $url, 'youtu.be' ) ) {
			$classes[] = 'gmr-embed-responsive gmr-embed-responsive-16by9';
		}

		$classes = array_merge( $classes, $classes_all );

		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $html . '</div>';
	}
endif; // endif gmr_embed_oembed_html.
add_filter( 'embed_oembed_html', 'gmr_embed_oembed_html', 99, 4 );

if ( ! function_exists( 'newkarma_prepend_attachment' ) ) :
	/**
	 * Callback for WordPress 'prepend_attachment' filter.
	 *
	 * Change the attachment page image size to 'large'
	 *
	 * @package WordPress
	 * @category Attachment
	 * @see wp-includes/post-template.php
	 *
	 * @param string $attachment_content the attachment html.
	 * @return string $attachment_content the attachment html
	 */
	function newkarma_prepend_attachment( $attachment_content ) {
		$post = get_post();
		if ( wp_attachment_is( 'image', $post ) ) {
			// set the attachment image size to 'large'.
			$attachment_content = sprintf( '<p class="img-center">%s</p>', wp_get_attachment_link( 0, 'full', false ) );

			// return the attachment content.
			return $attachment_content;
		} else {
			// return the attachment content.
			return $attachment_content;
		}
	}
endif; // endif newkarma_prepend_attachment.
add_filter( 'prepend_attachment', 'newkarma_prepend_attachment' );

if ( ! function_exists( 'newkarma_share_default' ) ) :
	/**
	 * Insert social share
	 *
	 * @since 1.0.0
	 * @param string $output Output.
	 * @return string @output
	 */
	function newkarma_share_default( $output = null ) {
		global $post;

		$filter_title = wp_strip_all_tags( rawurlencode( get_the_title() ) );

		$url = rawurlencode( esc_url( get_permalink() ) );

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		if ( ! empty( $image ) ) {
			$thumb = $image[0];
		} else {
			$thumb = '';
		}

		$output          = '';
		$output         .= '<ul class="gmr-socialicon-share">';
		$output         .= '<li class="facebook">';
			$output     .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" class="gmr-share-facebook" rel="nofollow" title="' . __( 'Share this', 'newkarma' ) . '">';
				$output .= '<span class="social_facebook"></span>';
			$output     .= '</a>';
		$output         .= '</li>';
		$output         .= '<li class="twitter">';
			$output     .= '<a href="https://twitter.com/share?url=' . $url . '&amp;text=' . $filter_title . '" class="gmr-share-twitter" rel="nofollow" title="' . __( 'Tweet this', 'newkarma' ) . '">';
				$output .= '<span class="social_twitter"></span>';
			$output     .= '</a>';
		$output         .= '</li>';
		$output         .= '<li class="pinterest">';
			$output     .= '<a href="https://pinterest.com/pin/create/button/?url=' . $url . '&amp;media=' . $thumb . '&amp;description=' . $filter_title . '" class="gmr-share-pinit" rel="nofollow" title="' . __( 'Pin this', 'newkarma' ) . '">';
				$output .= '<span class="social_pinterest"></span>';
			$output     .= '</a>';
		$output         .= '</li>';
		$output         .= '<li class="whatsapp">';
			$output     .= '<a href="https://api.whatsapp.com/send?text=' . $url . '" class="gmr-share-whatsapp" rel="nofollow" title="' . __( 'Whatsapp', 'newkarma' ) . '">';
				$output .= '<img src="' . get_template_directory_uri() . '/images/whatsapp.png" alt="' . __( 'Whatsapp', 'newkarma' ) . '" title="' . __( 'Whatsapp', 'newkarma' ) . '" />';
			$output     .= '</a>';
		$output         .= '</li>';
		$output         .= '<li class="comment-icon">';
			$output     .= '<a href="#comment-wrap" class="gmr-share-comment" rel="nofollow" title="' . __( 'Comment', 'newkarma' ) . '">';
				$output .= '<span class="icon_comment_alt"></span>';
			$output     .= '</a>';
		$output         .= '</li>';

		$output .= '</ul>';

		return $output;

	}
endif; // endif newkarma_share_default.

if ( ! function_exists( 'newkarma_add_share_in_single' ) ) :
	/**
	 * Insert social share in single
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function newkarma_add_share_in_single() {
		if ( is_single() && in_the_loop() ) {
			echo '<div class="gmr-social-share">';
				echo newkarma_share_default(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}
	}
endif; // endif newkarma_add_share_in_single.
add_action( 'newkarma_add_share_in_single', 'newkarma_add_share_in_single', 40 );

if ( ! function_exists( 'newkarma_add_share_top_in_single' ) ) :
	/**
	 * Insert social share in single
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function newkarma_add_share_top_in_single() {
		if ( is_single() && in_the_loop() ) {
			echo '<div class="gmr-social-share-intop">';
				echo newkarma_share_default(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '</div>';
		}
	}
endif; // endif newkarma_share_top_single.
add_action( 'newkarma_add_share_top_in_single', 'newkarma_add_share_top_in_single', 40 );
