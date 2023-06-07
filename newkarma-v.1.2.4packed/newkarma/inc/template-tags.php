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
		$delicious_url   = get_theme_mod( 'gmr_delicious_url_icon' );
		$tiktok_url      = get_theme_mod( 'gmr_tiktok_url_icon' );
		$telegram_url    = get_theme_mod( 'gmr_telegram_url_icon' );
		$soundcloud_url  = get_theme_mod( 'gmr_soundcloud_url_icon' );
		$rssicon         = get_theme_mod( 'gmr_active-rssicon', 0 );
		if ( $fb_url || $twitter_url || $pinterest_url || $tumblr_url || $stumbleupon_url || $wordpress_url || $instagram_url || $dribbble_url || $vimeo_url ||
		$linkedin_url || $deviantart_url || $skype_url || $youtube_url || $myspace_url || $picassa_url || $flickr_url || $blogger_url || $spotify_url || $delicious_url || $telegram_url || $soundcloud_url || 0 === $rssicon ) :
			if ( 0 === $mod_social ) :
				echo '<ul class="single-social-icon pull-right">';
				echo '<li class="social-text">' . esc_html__( 'Follow Us', 'newkarma' ) . '</li>';
				if ( $fb_url ) :
					echo '<li><a href="' . esc_url( $fb_url ) . '" title="' . esc_html__( 'Facebook', 'newkarma' ) . '" class="facebook" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131c.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/></g></svg></a></li>';
				endif;

				if ( $twitter_url ) :
					echo '<li><a href="' . esc_url( $twitter_url ) . '" title="' . esc_html__( 'Twitter', 'newkarma' ) . '" class="twitter" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512t40.5-199t109-163.5T313 40.5T512 0t199 40.5t163.5 109t109 163.5t40.5 199t-40.5 199t-109 163.5t-163.5 109t-199 40.5zm301-768q-6 3-18 11l-19.5 13l-18.5 10l-21 7q-37-41-91-41q-117 0-117 98v59q-161-8-247-118q-25 26-25 57q0 66 49 100q-6 0-17 1t-17.5 0t-14.5-5q0 46 24.5 76.5T348 564q-10 12-28 12q-16 0-28-9q0 39 37.5 60.5T414 650q-18 27-52.5 40.5T288 704q-14 0-38.5-7t-25.5-7q16 32 65.5 55T415 768q67 0 125-23.5t99-62.5t70.5-89t44-103.5T768 384q0-2 12-8.5t28-17.5t24-23q-54 0-72 2q35-21 53-81z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $pinterest_url ) :
					echo '<li><a href="' . esc_url( $pinterest_url ) . '" title="' . esc_html__( 'Pinterest', 'newkarma' ) . '" class="pinterest" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297c.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943c.682 0 1.012.512 1.012 1.127c0 .686-.437 1.712-.663 2.663c-.188.796.4 1.446 1.185 1.446c1.422 0 2.515-1.5 2.515-3.664c0-1.915-1.377-3.254-3.342-3.254c-2.276 0-3.612 1.707-3.612 3.471c0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907c-.035.146-.116.177-.268.107c-1-.465-1.624-1.926-1.624-3.1c0-2.523 1.834-4.84 5.286-4.84c2.775 0 4.932 1.977 4.932 4.62c0 2.757-1.739 4.976-4.151 4.976c-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/></g></svg></a></li>';
				endif;

				if ( $tumblr_url ) :
					echo '<li><a href="' . esc_url( $tumblr_url ) . '" title="' . esc_html__( 'Tumblr', 'newkarma' ) . '" class="tumblr" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zm2.577 13.741a5.508 5.508 0 0 1-1.066.395a4.543 4.543 0 0 1-1.031.113c-.42 0-.791-.055-1.114-.162a2.373 2.373 0 0 1-.826-.459a1.651 1.651 0 0 1-.474-.633c-.088-.225-.132-.549-.132-.973V9.16H6.918V7.846c.359-.119.67-.289.927-.512c.257-.221.464-.486.619-.797c.156-.31.263-.707.322-1.185h1.307v2.35h2.18V9.16h-2.18v2.385c0 .539.028.885.085 1.037a.7.7 0 0 0 .315.367c.204.123.437.185.697.185c.466 0 .928-.154 1.388-.461v1.468z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $stumbleupon_url ) :
					echo '<li><a href="' . esc_url( $stumbleupon_url ) . '" title="' . esc_html__( 'Stumbleupon', 'newkarma' ) . '" class="stumbleupon" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zm0 7.385a.53.53 0 0 0-.531.529v3.168a2.262 2.262 0 0 1-4.522 0v-1.326h1.729v1.326a.53.53 0 0 0 .531.529a.53.53 0 0 0 .531-.529V8.314a2.262 2.262 0 0 1 4.523.001v.603l-1.04.334l-.69-.334v-.604A.53.53 0 0 0 10 7.785zm5.053 3.697a2.262 2.262 0 0 1-4.523 0v-1.354l.69.334l1.04-.334v1.354a.53.53 0 0 0 1.061 0v-1.326h1.731v1.326z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $wordpress_url ) :
					echo '<li><a href="' . esc_url( $wordpress_url ) . '" title="' . esc_html__( 'WordPress', 'newkarma' ) . '" class="wordpress" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M768 192q0 14 1 24.5t4.5 21t6 17t10 17t10.5 15t14.5 18.5t16.5 19q22 28 28.5 45.5T861 410q-7 34-16 60l-77 202l-83-188q-9-22-37-117.5T620 264q0-14 10-21q22-18 42-19v-32H384v32q9 1 14 6t9.5 11.5t7.5 9.5q14 12 33 58l32 107l-64 256l-132-349q-20-51-20-62t11-19q24-18 45-18v-32H113q71-90 175.5-141T512 0q95 0 182 33.5T850 128q-39 0-60.5 16T768 192zM66 261q25 29 60 123l194 512h64l128-384l160 384h64l151-390q6-17 24-53.5t30.5-70T957 322q3-40 3-58q64 116 64 248q0 139-68.5 257T769 955.5T512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512q0-134 66-251z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $instagram_url ) :
					echo '<li><a href="' . esc_url( $instagram_url ) . '" title="' . esc_html__( 'Instagram', 'newkarma' ) . '" class="instagram" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M8 0C5.829 0 5.556.01 4.703.048C3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7C.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297c.04.852.174 1.433.372 1.942c.205.526.478.972.923 1.417c.444.445.89.719 1.416.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046c.78.035 1.204.166 1.486.275c.373.145.64.319.92.599c.28.28.453.546.598.92c.11.281.24.705.275 1.485c.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598c-.28.11-.704.24-1.485.276c-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598a2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485c-.038-.843-.046-1.096-.046-3.233c0-2.136.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486c.145-.373.319-.64.599-.92c.28-.28.546-.453.92-.598c.282-.11.705-.24 1.485-.276c.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92a.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217a4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334a2.667 2.667 0 0 1 0-5.334z"/></g></svg></a></li>';
				endif;

				if ( $dribbble_url ) :
					echo '<li><a href="' . esc_url( $dribbble_url ) . '" title="' . esc_html__( 'Dribbble', 'newkarma' ) . '" class="dribble" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 42 42"><path d="M21 1C9.954 1 1 9.954 1 21s8.954 20 20 20s20-8.954 20-20S32.046 1 21 1zm0 2.898c4.357 0 8.334 1.63 11.354 4.312c-2.219 2.927-5.59 4.876-8.968 6.195a89.077 89.077 0 0 0-6.415-10.03a17.132 17.132 0 0 1 4.03-.477zm-7.276 1.62c2.23 3.336 4.39 6.429 6.363 9.93c-4.99 1.293-10.629 2.069-15.838 2.082c1.098-5.328 4.677-9.752 9.475-12.011zm20.527 4.67a17.034 17.034 0 0 1 3.851 10.699c-3.956-.78-7.89-.984-11.896-.58c-.45-1.123-.996-2.19-1.519-3.34c3.453-1.393 7.145-3.777 9.564-6.78zm-12.775 7.906c.428.91.924 1.876 1.39 2.863c-5.57 2.456-11.495 5.738-14.57 11.492a17.043 17.043 0 0 1-4.39-11.95c5.965-.028 11.82-.774 17.57-2.405zm16.568 4.33zm-7.53.333a29.15 29.15 0 0 1 7.375.95a17.1 17.1 0 0 1-7.347 11.487c-.918-4.175-1.793-8.17-3.34-12.198a22.966 22.966 0 0 1 3.311-.24zm7.464.31c-.012.098-.023.194-.037.29c.014-.097.026-.193.037-.29zm-13.94.71c1.576 4.073 2.813 8.583 3.643 12.972a17.045 17.045 0 0 1-6.68 1.354a17.027 17.027 0 0 1-10.495-3.6c3.097-5.024 7.894-8.826 13.531-10.725z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $vimeo_url ) :
					echo '<li><a href="' . esc_url( $vimeo_url ) . '" title="' . esc_html__( 'Vimeo', 'newkarma' ) . '" class="vimeo" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512t40.5-199t109-163.5T313 40.5T512 0t199 40.5t163.5 109t109 163.5t40.5 199t-40.5 199t-109 163.5t-163.5 109t-199 40.5zm144-768q-46 0-78.5 43.5T544 398q16-14 36-14q21 0 32.5 10.5T624 432q0 25-17.5 63.5T566 563t-38 29q-7 0-14-16t-14-47t-12-59t-12.5-70.5T464 336q-15-80-64-80q-72 0-144 128l16 32q11-13 26-22.5t22-9.5t12.5 4.5t8.5 13t5 15.5t3.5 17t2.5 14q4 18 12 66t16.5 86t22.5 79.5t37.5 65T496 768q39 0 104.5-68.5T717 538t51-154q0-128-112-128z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $linkedin_url ) :
					echo '<li><a href="' . esc_url( $linkedin_url ) . '" title="' . esc_html__( 'Linkedin', 'newkarma' ) . '" class="linkedin" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zM7.65 13.979H5.706V7.723H7.65v6.256zm-.984-7.024c-.614 0-1.011-.435-1.011-.973c0-.549.409-.971 1.036-.971s1.011.422 1.023.971c0 .538-.396.973-1.048.973zm8.084 7.024h-1.944v-3.467c0-.807-.282-1.355-.985-1.355c-.537 0-.856.371-.997.728c-.052.127-.065.307-.065.486v3.607H8.814v-4.26c0-.781-.025-1.434-.051-1.996h1.689l.089.869h.039c.256-.408.883-1.01 1.932-1.01c1.279 0 2.238.857 2.238 2.699v3.699z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $deviantart_url ) :
					echo '<li><a href="' . esc_url( $deviantart_url ) . '" title="' . esc_html__( 'Deviantart', 'newkarma' ) . '" class="deviantart" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M25.609 6.391l.308-.573V.001h-5.824l-.583.588l-2.745 5.229l-.859.584H6.103v7.989h5.391l.479.583l-5.567 10.641l-.319.573V32h5.819l.583-.588l2.761-5.229l.853-.584h9.803V17.61h-5.401l-.479-.583l5.583-10.641z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $myspace_url ) :
					echo '<li><a href="' . esc_url( $myspace_url ) . '" title="' . esc_html__( 'Myspace', 'newkarma' ) . '" class="myspace" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 100 100"><path d="M78.841 51.036c7.792 0 14.111-6.294 14.111-14.061c0-7.765-6.319-14.061-14.111-14.061c-7.798 0-14.118 6.297-14.118 14.061c-.001 7.767 6.32 14.061 14.118 14.061z" fill="currentColor"/><ellipse cx="47.046" cy="40.984" rx="12.703" ry="12.656" fill="currentColor"/><path d="M18.214 55.984c6.313 0 11.433-5.096 11.433-11.386c0-6.292-5.12-11.39-11.433-11.39c-6.315 0-11.433 5.098-11.433 11.39c0 6.291 5.117 11.386 11.433 11.386z" fill="currentColor"/><path d="M18.214 58.585c-7.25 0-12.565 6.363-12.565 12.936v4.425c0 .626.512 1.14 1.142 1.14h22.843c.632 0 1.144-.514 1.144-1.14v-4.425c0-6.573-5.315-12.936-12.564-12.936z" fill="currentColor"/><path d="M47.046 56.526c-8.055 0-13.962 7.071-13.962 14.376v4.917c0 .695.569 1.267 1.269 1.267h25.382a1.27 1.27 0 0 0 1.271-1.267v-4.917c.001-7.304-5.905-14.376-13.96-14.376z" fill="currentColor"/><path d="M78.839 54.243c-8.95 0-15.512 7.856-15.512 15.974v5.462c0 .773.632 1.407 1.41 1.407h28.2c.782 0 1.414-.635 1.414-1.407v-5.462c0-8.117-6.562-15.974-15.512-15.974z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $skype_url ) :
					echo '<li><a href="' . esc_url( $skype_url ) . '" title="' . esc_html__( 'Skype', 'newkarma' ) . '" class="skype" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M21.435 14.156a9.586 9.586 0 0 0 .211-2.027a9.477 9.477 0 0 0-9.54-9.422a9.114 9.114 0 0 0-1.625.141A5.536 5.536 0 0 0 2 7.466a5.429 5.429 0 0 0 .753 2.756a10.02 10.02 0 0 0-.189 1.884a9.339 9.339 0 0 0 9.54 9.258a8.567 8.567 0 0 0 1.743-.166a5.58 5.58 0 0 0 2.616.802a5.433 5.433 0 0 0 4.97-7.844zm-4.995 1.837a3.631 3.631 0 0 1-1.625 1.225a6.34 6.34 0 0 1-2.52.447a6.217 6.217 0 0 1-2.898-.612a3.733 3.733 0 0 1-1.32-1.178a2.574 2.574 0 0 1-.494-1.413a.88.88 0 0 1 .307-.684a1.09 1.09 0 0 1 .776-.282a.944.944 0 0 1 .637.212a1.793 1.793 0 0 1 .447.659a3.398 3.398 0 0 0 .495.873a1.79 1.79 0 0 0 .73.564a3.014 3.014 0 0 0 1.249.236a2.922 2.922 0 0 0 1.72-.447a1.332 1.332 0 0 0 .66-1.131a1.135 1.135 0 0 0-.354-.871a2.185 2.185 0 0 0-.92-.52c-.376-.117-.895-.235-1.53-.376a13.99 13.99 0 0 1-2.144-.636a3.348 3.348 0 0 1-1.366-1.013a2.474 2.474 0 0 1-.495-1.578a2.63 2.63 0 0 1 .542-1.602a3.412 3.412 0 0 1 1.53-1.084a6.652 6.652 0 0 1 2.38-.376a6.403 6.403 0 0 1 1.885.258a4.072 4.072 0 0 1 1.318.66a2.916 2.916 0 0 1 .778.872a1.803 1.803 0 0 1 .236.87a.962.962 0 0 1-.307.708a.991.991 0 0 1-.753.306a.974.974 0 0 1-.636-.189a2.382 2.382 0 0 1-.471-.611a2.937 2.937 0 0 0-.778-.967a2.376 2.376 0 0 0-1.46-.353a2.703 2.703 0 0 0-1.508.377a1.076 1.076 0 0 0-.565.896a.958.958 0 0 0 .188.565a1.419 1.419 0 0 0 .542.4a2.693 2.693 0 0 0 .683.26c.236.07.613.164 1.154.282c.66.142 1.273.306 1.815.471a5.43 5.43 0 0 1 1.389.636a2.857 2.857 0 0 1 .895.942a2.828 2.828 0 0 1 .33 1.39a2.89 2.89 0 0 1-.542 1.814z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $youtube_url ) :
					echo '<li><a href="' . esc_url( $youtube_url ) . '" title="' . esc_html__( 'Youtube', 'newkarma' ) . '" class="youtube" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1.13em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597c-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821c11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205l-142.739 81.201z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $picassa_url ) :
					echo '<li><a href="' . esc_url( $picassa_url ) . '" title="' . esc_html__( 'Picassa', 'newkarma' ) . '" class="picassa" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.96em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 464 488"><path d="M138 333h301q-26 55-76 89.5T253 462h-42q-40-3-73-19V333zM327 22Q281 2 232 2q-41 0-80 15q3 3 87.5 79.5T327 176V22zm-200 5q-58 30-91.5 85T2 232q0 28 8 60q3-2 102.5-92.5T214 107q-2-2-44-40.5T127 27zm-14 403V231q-4 4-49 45t-46 42q30 73 95 112zM351 36v272h98q13-35 13-76q0-60-29.5-112.5T351 36z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $flickr_url ) :
					echo '<li><a href="' . esc_url( $flickr_url ) . '" title="' . esc_html__( 'Flickr', 'newkarma' ) . '" class="flickrs" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path d="M8 0C3.582 0 0 3.606 0 8.055s3.582 8.055 8 8.055s8-3.606 8-8.055S12.418 0 8 0zM4.5 10.5a2.5 2.5 0 1 1 0-5a2.5 2.5 0 0 1 0 5zm7 0a2.5 2.5 0 1 1 0-5a2.5 2.5 0 0 1 0 5z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $blogger_url ) :
					echo '<li><a href="' . esc_url( $blogger_url ) . '" title="' . esc_html__( 'Blogger', 'newkarma' ) . '" class="blogger" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.593 21.96c3.48 0 6.307-2.836 6.327-6.297l.039-5.095l-.059-.278l-.167-.348l-.283-.22c-.367-.287-2.228.02-2.729-.435c-.355-.324-.41-.91-.518-1.706c-.2-1.54-.326-1.62-.568-2.142C16.76 3.585 14.382 2.193 12.75 2H8.325C4.845 2 2 4.839 2 8.307v7.356c0 3.461 2.845 6.296 6.325 6.296h7.268zM8.406 7.151h3.507c.67 0 1.212.544 1.212 1.205c0 .657-.542 1.206-1.212 1.206H8.406c-.67 0-1.21-.549-1.21-1.206c0-.661.54-1.205 1.21-1.205zm-1.21 8.418c0-.66.54-1.2 1.21-1.2h7.127c.665 0 1.205.54 1.205 1.2c0 .652-.54 1.2-1.205 1.2H8.406a1.21 1.21 0 0 1-1.21-1.2z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $spotify_url ) :
					echo '<li><a href="' . esc_url( $spotify_url ) . '" title="' . esc_html__( 'Spotify', 'newkarma' ) . '" class="spotify" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 1.2A8.798 8.798 0 0 0 1.2 10A8.8 8.8 0 1 0 10 1.2zm3.478 13.302c-.173 0-.294-.066-.421-.143c-1.189-.721-2.662-1.099-4.258-1.099c-.814 0-1.693.097-2.61.285l-.112.028c-.116.028-.235.059-.326.059a.651.651 0 0 1-.661-.656c0-.373.21-.637.562-.703a14.037 14.037 0 0 1 3.152-.372c1.855 0 3.513.43 4.931 1.279c.243.142.396.306.396.668a.655.655 0 0 1-.653.654zm.913-2.561c-.207 0-.343-.079-.463-.149c-2.143-1.271-5.333-1.693-7.961-.993a3.742 3.742 0 0 0-.12.037c-.099.031-.191.062-.321.062a.786.786 0 0 1-.783-.788c0-.419.219-.712.614-.824c1.013-.278 1.964-.462 3.333-.462c2.212 0 4.357.555 6.038 1.561c.306.175.445.414.445.771a.784.784 0 0 1-.782.785zm1.036-2.92c-.195 0-.315-.047-.495-.144c-1.453-.872-3.72-1.391-6.069-1.391c-1.224 0-2.336.135-3.306.397a2.072 2.072 0 0 0-.098.027a1.281 1.281 0 0 1-.365.068a.914.914 0 0 1-.919-.929c0-.453.254-.799.68-.925c1.171-.346 2.519-.521 4.006-.521c2.678 0 5.226.595 6.991 1.631c.332.189.495.475.495.872a.908.908 0 0 1-.92.915z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $delicious_url ) :
					echo '<li><a href="' . esc_url( $delicious_url ) . '" title="' . esc_html__( 'Delicious', 'newkarma' ) . '" class="delicious" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.96em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 464 488"><path d="M444 142q-26-62-83-101q-30-19-60-29q-31-10-69-10q-48 0-90 18q-62 26-101 83q-19 31-29 61T2 232q0 48 18 90q26 62 83 101q31 19 61 29t68 10q48 0 90-18q62-26 101-83q19-30 29-60q10-31 10-69q0-48-18-90zm-28 168q-26 56-73 87q-23 16-52 25q-27 9-59 9V232H33q0-42 15-78q26-56 73-87q23-16 52-25q27-9 59-9v199h199q0 42-15 78z" fill="currentColor"/></svg></a></li>';
				endif;
				
				if ( $tiktok_url ) :
					echo '<li><a href="' . esc_url( $tiktok_url ) . '" title="' . esc_html__( 'Tiktok', 'newkarma' ) . '" class="tiktok" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.88em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25v178.72A162.55 162.55 0 1 1 185 188.31v89.89a74.62 74.62 0 1 0 52.23 71.18V0h88a121.18 121.18 0 0 0 1.86 22.17A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $telegram_url ) :
					echo '<li><a href="' . esc_url( $telegram_url ) . '" title="' . esc_html__( 'Telegram', 'newkarma' ) . '" class="telegram" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 .5C7.437.5.5 7.438.5 16S7.438 31.5 16 31.5c8.563 0 15.5-6.938 15.5-15.5S24.562.5 16 .5zm7.613 10.619l-2.544 11.988c-.188.85-.694 1.056-1.4.656l-3.875-2.856l-1.869 1.8c-.206.206-.381.381-.781.381l.275-3.944l7.181-6.488c.313-.275-.069-.431-.482-.156l-8.875 5.587l-3.825-1.194c-.831-.262-.85-.831.175-1.231l14.944-5.763c.694-.25 1.3.169 1.075 1.219z" fill="currentColor"/></svg></a></li>';
				endif;

				if ( $soundcloud_url ) :
					echo '<li><a href="' . esc_url( $soundcloud_url ) . '" title="' . esc_html__( 'Soundcloud', 'newkarma' ) . '" class="soundcloud" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M2.971 12.188c-.041 0-.078.038-.083.082l-.194 1.797l.194 1.756c.005.049.042.082.083.082s.075-.033.084-.082l.211-1.756l-.225-1.797c0-.046-.037-.082-.074-.082m-.75.691c-.051 0-.076.03-.088.079l-.138 1.109l.138 1.092c0 .046.037.078.075.078c.039 0 .073-.038.087-.087l.176-1.1l-.176-1.112c0-.051-.037-.076-.075-.076m1.526-1.025c-.052 0-.1.039-.1.087l-.176 2.139l.188 2.051c0 .049.037.1.099.1c.052 0 .089-.051.102-.1l.211-2.064l-.211-2.126c-.013-.049-.052-.1-.102-.1m.79-.075c-.063 0-.114.051-.126.113l-.161 2.201l.177 2.123c.012.063.061.114.122.114c.064 0 .113-.051.125-.124l.201-2.113l-.201-2.187a.11.11 0 0 0-.111-.112l-.026-.015zm.962.301a.128.128 0 0 0-.133-.125a.134.134 0 0 0-.137.125l-.182 2.026l.169 2.138a.13.13 0 0 0 .132.131c.062 0 .123-.055.123-.132l.189-2.139l-.189-2.036l.028.012zm.674-1.426a.154.154 0 0 0-.148.15l-.176 3.3l.156 2.139c0 .077.066.137.15.137c.078 0 .145-.074.15-.15l.174-2.137l-.173-3.313c-.007-.088-.074-.152-.15-.152m.8-.762a.178.178 0 0 0-.17.163l-.15 4.063l.138 2.125c0 .1.075.174.163.174c.086 0 .161-.074.174-.174l.162-2.125l-.161-4.052c-.013-.1-.088-.175-.175-.175m.826-.372c-.102 0-.176.073-.188.173l-.139 4.4l.139 2.102c.012.1.086.188.188.188a.193.193 0 0 0 .187-.188l.163-2.102l-.164-4.4c0-.1-.087-.188-.188-.188m1.038.038a.196.196 0 0 0-.199-.199a.205.205 0 0 0-.201.199l-.125 4.538l.124 2.089c.015.111.101.199.214.199s.201-.088.201-.199l.136-2.089l-.136-4.55l-.014.012zm.625-.111c-.113 0-.213.1-.213.211l-.125 4.439l.125 2.063c0 .125.1.213.213.213a.221.221 0 0 0 .214-.224l.125-2.064l-.14-4.428c0-.122-.1-.225-.225-.225m.838.139a.236.236 0 0 0-.237.237l-.086 4.29l.113 2.063c0 .124.1.231.236.231c.125 0 .227-.1.237-.237l.101-2.038l-.112-4.265c-.01-.137-.113-.238-.237-.238m.988-.786a.27.27 0 0 0-.139-.037c-.05 0-.1.013-.137.037a.25.25 0 0 0-.125.214v.05l-.086 5.044l.096 2.043v.007c.006.05.024.112.06.15c.05.051.12.086.196.086a.28.28 0 0 0 .175-.074a.262.262 0 0 0 .076-.188l.013-.201l.097-1.838l-.113-5.075a.24.24 0 0 0-.111-.199l-.002-.019zm.837-.457a.155.155 0 0 0-.124-.052a.283.283 0 0 0-.174.052a.265.265 0 0 0-.1.201v.023l-.114 5.513l.063 1.014l.052.988a.274.274 0 0 0 .548-.012l.125-2.013l-.125-5.536a.273.273 0 0 0-.138-.231m7.452 3.15c-.336 0-.663.072-.949.193a4.34 4.34 0 0 0-5.902-3.651c-.188.075-.227.151-.238.301v7.812a.31.31 0 0 0 .275.29h6.827a2.428 2.428 0 0 0 2.45-2.438a2.457 2.457 0 0 0-2.45-2.463" fill="currentColor"/></svg></a></li>';
				endif;

				if ( 0 === $rssicon ) :
					echo '<li><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_html__( 'RSS', 'newkarma' ) . '" class="rss" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M14.92 18H18C18 9.32 10.82 2.25 2 2.25v3.02c7.12 0 12.92 5.71 12.92 12.73zm-5.44 0h3.08C12.56 12.27 7.82 7.6 2 7.6v3.02c2 0 3.87.77 5.29 2.16A7.292 7.292 0 0 1 9.48 18zm-5.35-.02c1.17 0 2.13-.93 2.13-2.09c0-1.15-.96-2.09-2.13-2.09c-1.18 0-2.13.94-2.13 2.09c0 1.16.95 2.09 2.13 2.09z" fill="currentColor"/></svg></a></li>';
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
		$delicious_url   = get_theme_mod( 'gmr_delicious_url_icon' );
		$tiktok_url      = get_theme_mod( 'gmr_tiktok_url_icon' );
		$telegram_url    = get_theme_mod( 'gmr_telegram_url_icon' );
		$soundcloud_url  = get_theme_mod( 'gmr_soundcloud_url_icon' );
		$rssicon         = get_theme_mod( 'gmr_active-rssicon', 0 );

		if ( $fb_url || $twitter_url || $pinterest_url || $tumblr_url || $stumbleupon_url || $wordpress_url || $instagram_url || $dribbble_url || $vimeo_url ||
		$linkedin_url || $deviantart_url || $skype_url || $youtube_url || $myspace_url || $picassa_url || $flickr_url || $blogger_url || $spotify_url || $delicious_url || $telegram_url || $soundcloud_url || 0 === $rssicon ) :
			if ( 0 === $mod_social ) :
				echo '<ul class="footer-social-icon pull-right">';
					if ( $fb_url ) :
						echo '<li><a href="' . esc_url( $fb_url ) . '" title="' . esc_html__( 'Facebook', 'majalahpro' ) . '" class="facebook" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131c.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/></g></svg></a></li>';
					endif;

					if ( $twitter_url ) :
						echo '<li><a href="' . esc_url( $twitter_url ) . '" title="' . esc_html__( 'Twitter', 'majalahpro' ) . '" class="twitter" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512t40.5-199t109-163.5T313 40.5T512 0t199 40.5t163.5 109t109 163.5t40.5 199t-40.5 199t-109 163.5t-163.5 109t-199 40.5zm301-768q-6 3-18 11l-19.5 13l-18.5 10l-21 7q-37-41-91-41q-117 0-117 98v59q-161-8-247-118q-25 26-25 57q0 66 49 100q-6 0-17 1t-17.5 0t-14.5-5q0 46 24.5 76.5T348 564q-10 12-28 12q-16 0-28-9q0 39 37.5 60.5T414 650q-18 27-52.5 40.5T288 704q-14 0-38.5-7t-25.5-7q16 32 65.5 55T415 768q67 0 125-23.5t99-62.5t70.5-89t44-103.5T768 384q0-2 12-8.5t28-17.5t24-23q-54 0-72 2q35-21 53-81z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $pinterest_url ) :
						echo '<li><a href="' . esc_url( $pinterest_url ) . '" title="' . esc_html__( 'Pinterest', 'majalahpro' ) . '" class="pinterest" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M8 0a8 8 0 0 0-2.915 15.452c-.07-.633-.134-1.606.027-2.297c.146-.625.938-3.977.938-3.977s-.239-.479-.239-1.187c0-1.113.645-1.943 1.448-1.943c.682 0 1.012.512 1.012 1.127c0 .686-.437 1.712-.663 2.663c-.188.796.4 1.446 1.185 1.446c1.422 0 2.515-1.5 2.515-3.664c0-1.915-1.377-3.254-3.342-3.254c-2.276 0-3.612 1.707-3.612 3.471c0 .688.265 1.425.595 1.826a.24.24 0 0 1 .056.23c-.061.252-.196.796-.222.907c-.035.146-.116.177-.268.107c-1-.465-1.624-1.926-1.624-3.1c0-2.523 1.834-4.84 5.286-4.84c2.775 0 4.932 1.977 4.932 4.62c0 2.757-1.739 4.976-4.151 4.976c-.811 0-1.573-.421-1.834-.919l-.498 1.902c-.181.695-.669 1.566-.995 2.097A8 8 0 1 0 8 0z"/></g></svg></a></li>';
					endif;

					if ( $tumblr_url ) :
						echo '<li><a href="' . esc_url( $tumblr_url ) . '" title="' . esc_html__( 'Tumblr', 'majalahpro' ) . '" class="tumblr" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zm2.577 13.741a5.508 5.508 0 0 1-1.066.395a4.543 4.543 0 0 1-1.031.113c-.42 0-.791-.055-1.114-.162a2.373 2.373 0 0 1-.826-.459a1.651 1.651 0 0 1-.474-.633c-.088-.225-.132-.549-.132-.973V9.16H6.918V7.846c.359-.119.67-.289.927-.512c.257-.221.464-.486.619-.797c.156-.31.263-.707.322-1.185h1.307v2.35h2.18V9.16h-2.18v2.385c0 .539.028.885.085 1.037a.7.7 0 0 0 .315.367c.204.123.437.185.697.185c.466 0 .928-.154 1.388-.461v1.468z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $stumbleupon_url ) :
						echo '<li><a href="' . esc_url( $stumbleupon_url ) . '" title="' . esc_html__( 'Stumbleupon', 'majalahpro' ) . '" class="stumbleupon" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zm0 7.385a.53.53 0 0 0-.531.529v3.168a2.262 2.262 0 0 1-4.522 0v-1.326h1.729v1.326a.53.53 0 0 0 .531.529a.53.53 0 0 0 .531-.529V8.314a2.262 2.262 0 0 1 4.523.001v.603l-1.04.334l-.69-.334v-.604A.53.53 0 0 0 10 7.785zm5.053 3.697a2.262 2.262 0 0 1-4.523 0v-1.354l.69.334l1.04-.334v1.354a.53.53 0 0 0 1.061 0v-1.326h1.731v1.326z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $wordpress_url ) :
						echo '<li><a href="' . esc_url( $wordpress_url ) . '" title="' . esc_html__( 'WordPress', 'majalahpro' ) . '" class="wordpress" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M768 192q0 14 1 24.5t4.5 21t6 17t10 17t10.5 15t14.5 18.5t16.5 19q22 28 28.5 45.5T861 410q-7 34-16 60l-77 202l-83-188q-9-22-37-117.5T620 264q0-14 10-21q22-18 42-19v-32H384v32q9 1 14 6t9.5 11.5t7.5 9.5q14 12 33 58l32 107l-64 256l-132-349q-20-51-20-62t11-19q24-18 45-18v-32H113q71-90 175.5-141T512 0q95 0 182 33.5T850 128q-39 0-60.5 16T768 192zM66 261q25 29 60 123l194 512h64l128-384l160 384h64l151-390q6-17 24-53.5t30.5-70T957 322q3-40 3-58q64 116 64 248q0 139-68.5 257T769 955.5T512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512q0-134 66-251z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $instagram_url ) :
						echo '<li><a href="' . esc_url( $instagram_url ) . '" title="' . esc_html__( 'Instagram', 'majalahpro' ) . '" class="instagram" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="currentColor"><path d="M8 0C5.829 0 5.556.01 4.703.048C3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7C.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297c.04.852.174 1.433.372 1.942c.205.526.478.972.923 1.417c.444.445.89.719 1.416.923c.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417c.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046c.78.035 1.204.166 1.486.275c.373.145.64.319.92.599c.28.28.453.546.598.92c.11.281.24.705.275 1.485c.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598c-.28.11-.704.24-1.485.276c-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598a2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485c-.038-.843-.046-1.096-.046-3.233c0-2.136.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486c.145-.373.319-.64.599-.92c.28-.28.546-.453.92-.598c.282-.11.705-.24 1.485-.276c.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92a.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217a4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334a2.667 2.667 0 0 1 0-5.334z"/></g></svg></a></li>';
					endif;

					if ( $dribbble_url ) :
						echo '<li><a href="' . esc_url( $dribbble_url ) . '" title="' . esc_html__( 'Dribbble', 'majalahpro' ) . '" class="dribble" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 42 42"><path d="M21 1C9.954 1 1 9.954 1 21s8.954 20 20 20s20-8.954 20-20S32.046 1 21 1zm0 2.898c4.357 0 8.334 1.63 11.354 4.312c-2.219 2.927-5.59 4.876-8.968 6.195a89.077 89.077 0 0 0-6.415-10.03a17.132 17.132 0 0 1 4.03-.477zm-7.276 1.62c2.23 3.336 4.39 6.429 6.363 9.93c-4.99 1.293-10.629 2.069-15.838 2.082c1.098-5.328 4.677-9.752 9.475-12.011zm20.527 4.67a17.034 17.034 0 0 1 3.851 10.699c-3.956-.78-7.89-.984-11.896-.58c-.45-1.123-.996-2.19-1.519-3.34c3.453-1.393 7.145-3.777 9.564-6.78zm-12.775 7.906c.428.91.924 1.876 1.39 2.863c-5.57 2.456-11.495 5.738-14.57 11.492a17.043 17.043 0 0 1-4.39-11.95c5.965-.028 11.82-.774 17.57-2.405zm16.568 4.33zm-7.53.333a29.15 29.15 0 0 1 7.375.95a17.1 17.1 0 0 1-7.347 11.487c-.918-4.175-1.793-8.17-3.34-12.198a22.966 22.966 0 0 1 3.311-.24zm7.464.31c-.012.098-.023.194-.037.29c.014-.097.026-.193.037-.29zm-13.94.71c1.576 4.073 2.813 8.583 3.643 12.972a17.045 17.045 0 0 1-6.68 1.354a17.027 17.027 0 0 1-10.495-3.6c3.097-5.024 7.894-8.826 13.531-10.725z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $vimeo_url ) :
						echo '<li><a href="' . esc_url( $vimeo_url ) . '" title="' . esc_html__( 'Vimeo', 'majalahpro' ) . '" class="vimeo" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 1024q-104 0-199-40.5t-163.5-109T40.5 711T0 512t40.5-199t109-163.5T313 40.5T512 0t199 40.5t163.5 109t109 163.5t40.5 199t-40.5 199t-109 163.5t-163.5 109t-199 40.5zm144-768q-46 0-78.5 43.5T544 398q16-14 36-14q21 0 32.5 10.5T624 432q0 25-17.5 63.5T566 563t-38 29q-7 0-14-16t-14-47t-12-59t-12.5-70.5T464 336q-15-80-64-80q-72 0-144 128l16 32q11-13 26-22.5t22-9.5t12.5 4.5t8.5 13t5 15.5t3.5 17t2.5 14q4 18 12 66t16.5 86t22.5 79.5t37.5 65T496 768q39 0 104.5-68.5T717 538t51-154q0-128-112-128z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $linkedin_url ) :
						echo '<li><a href="' . esc_url( $linkedin_url ) . '" title="' . esc_html__( 'Linkedin', 'majalahpro' ) . '" class="linkedin" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 .4C4.698.4.4 4.698.4 10s4.298 9.6 9.6 9.6s9.6-4.298 9.6-9.6S15.302.4 10 .4zM7.65 13.979H5.706V7.723H7.65v6.256zm-.984-7.024c-.614 0-1.011-.435-1.011-.973c0-.549.409-.971 1.036-.971s1.011.422 1.023.971c0 .538-.396.973-1.048.973zm8.084 7.024h-1.944v-3.467c0-.807-.282-1.355-.985-1.355c-.537 0-.856.371-.997.728c-.052.127-.065.307-.065.486v3.607H8.814v-4.26c0-.781-.025-1.434-.051-1.996h1.689l.089.869h.039c.256-.408.883-1.01 1.932-1.01c1.279 0 2.238.857 2.238 2.699v3.699z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $deviantart_url ) :
						echo '<li><a href="' . esc_url( $deviantart_url ) . '" title="' . esc_html__( 'Deviantart', 'majalahpro' ) . '" class="deviantart" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M25.609 6.391l.308-.573V.001h-5.824l-.583.588l-2.745 5.229l-.859.584H6.103v7.989h5.391l.479.583l-5.567 10.641l-.319.573V32h5.819l.583-.588l2.761-5.229l.853-.584h9.803V17.61h-5.401l-.479-.583l5.583-10.641z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $myspace_url ) :
						echo '<li><a href="' . esc_url( $myspace_url ) . '" title="' . esc_html__( 'Myspace', 'majalahpro' ) . '" class="myspace" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 100 100"><path d="M78.841 51.036c7.792 0 14.111-6.294 14.111-14.061c0-7.765-6.319-14.061-14.111-14.061c-7.798 0-14.118 6.297-14.118 14.061c-.001 7.767 6.32 14.061 14.118 14.061z" fill="currentColor"/><ellipse cx="47.046" cy="40.984" rx="12.703" ry="12.656" fill="currentColor"/><path d="M18.214 55.984c6.313 0 11.433-5.096 11.433-11.386c0-6.292-5.12-11.39-11.433-11.39c-6.315 0-11.433 5.098-11.433 11.39c0 6.291 5.117 11.386 11.433 11.386z" fill="currentColor"/><path d="M18.214 58.585c-7.25 0-12.565 6.363-12.565 12.936v4.425c0 .626.512 1.14 1.142 1.14h22.843c.632 0 1.144-.514 1.144-1.14v-4.425c0-6.573-5.315-12.936-12.564-12.936z" fill="currentColor"/><path d="M47.046 56.526c-8.055 0-13.962 7.071-13.962 14.376v4.917c0 .695.569 1.267 1.269 1.267h25.382a1.27 1.27 0 0 0 1.271-1.267v-4.917c.001-7.304-5.905-14.376-13.96-14.376z" fill="currentColor"/><path d="M78.839 54.243c-8.95 0-15.512 7.856-15.512 15.974v5.462c0 .773.632 1.407 1.41 1.407h28.2c.782 0 1.414-.635 1.414-1.407v-5.462c0-8.117-6.562-15.974-15.512-15.974z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $skype_url ) :
						echo '<li><a href="' . esc_url( $skype_url ) . '" title="' . esc_html__( 'Skype', 'majalahpro' ) . '" class="skype" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M21.435 14.156a9.586 9.586 0 0 0 .211-2.027a9.477 9.477 0 0 0-9.54-9.422a9.114 9.114 0 0 0-1.625.141A5.536 5.536 0 0 0 2 7.466a5.429 5.429 0 0 0 .753 2.756a10.02 10.02 0 0 0-.189 1.884a9.339 9.339 0 0 0 9.54 9.258a8.567 8.567 0 0 0 1.743-.166a5.58 5.58 0 0 0 2.616.802a5.433 5.433 0 0 0 4.97-7.844zm-4.995 1.837a3.631 3.631 0 0 1-1.625 1.225a6.34 6.34 0 0 1-2.52.447a6.217 6.217 0 0 1-2.898-.612a3.733 3.733 0 0 1-1.32-1.178a2.574 2.574 0 0 1-.494-1.413a.88.88 0 0 1 .307-.684a1.09 1.09 0 0 1 .776-.282a.944.944 0 0 1 .637.212a1.793 1.793 0 0 1 .447.659a3.398 3.398 0 0 0 .495.873a1.79 1.79 0 0 0 .73.564a3.014 3.014 0 0 0 1.249.236a2.922 2.922 0 0 0 1.72-.447a1.332 1.332 0 0 0 .66-1.131a1.135 1.135 0 0 0-.354-.871a2.185 2.185 0 0 0-.92-.52c-.376-.117-.895-.235-1.53-.376a13.99 13.99 0 0 1-2.144-.636a3.348 3.348 0 0 1-1.366-1.013a2.474 2.474 0 0 1-.495-1.578a2.63 2.63 0 0 1 .542-1.602a3.412 3.412 0 0 1 1.53-1.084a6.652 6.652 0 0 1 2.38-.376a6.403 6.403 0 0 1 1.885.258a4.072 4.072 0 0 1 1.318.66a2.916 2.916 0 0 1 .778.872a1.803 1.803 0 0 1 .236.87a.962.962 0 0 1-.307.708a.991.991 0 0 1-.753.306a.974.974 0 0 1-.636-.189a2.382 2.382 0 0 1-.471-.611a2.937 2.937 0 0 0-.778-.967a2.376 2.376 0 0 0-1.46-.353a2.703 2.703 0 0 0-1.508.377a1.076 1.076 0 0 0-.565.896a.958.958 0 0 0 .188.565a1.419 1.419 0 0 0 .542.4a2.693 2.693 0 0 0 .683.26c.236.07.613.164 1.154.282c.66.142 1.273.306 1.815.471a5.43 5.43 0 0 1 1.389.636a2.857 2.857 0 0 1 .895.942a2.828 2.828 0 0 1 .33 1.39a2.89 2.89 0 0 1-.542 1.814z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $youtube_url ) :
						echo '<li><a href="' . esc_url( $youtube_url ) . '" title="' . esc_html__( 'Youtube', 'majalahpro' ) . '" class="youtube" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1.13em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597c-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821c11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205l-142.739 81.201z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $picassa_url ) :
						echo '<li><a href="' . esc_url( $picassa_url ) . '" title="' . esc_html__( 'Picassa', 'majalahpro' ) . '" class="picassa" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.96em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 464 488"><path d="M138 333h301q-26 55-76 89.5T253 462h-42q-40-3-73-19V333zM327 22Q281 2 232 2q-41 0-80 15q3 3 87.5 79.5T327 176V22zm-200 5q-58 30-91.5 85T2 232q0 28 8 60q3-2 102.5-92.5T214 107q-2-2-44-40.5T127 27zm-14 403V231q-4 4-49 45t-46 42q30 73 95 112zM351 36v272h98q13-35 13-76q0-60-29.5-112.5T351 36z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $flickr_url ) :
						echo '<li><a href="' . esc_url( $flickr_url ) . '" title="' . esc_html__( 'Flickr', 'majalahpro' ) . '" class="flickrs" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path d="M8 0C3.582 0 0 3.606 0 8.055s3.582 8.055 8 8.055s8-3.606 8-8.055S12.418 0 8 0zM4.5 10.5a2.5 2.5 0 1 1 0-5a2.5 2.5 0 0 1 0 5zm7 0a2.5 2.5 0 1 1 0-5a2.5 2.5 0 0 1 0 5z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $blogger_url ) :
						echo '<li><a href="' . esc_url( $blogger_url ) . '" title="' . esc_html__( 'Blogger', 'majalahpro' ) . '" class="blogger" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.593 21.96c3.48 0 6.307-2.836 6.327-6.297l.039-5.095l-.059-.278l-.167-.348l-.283-.22c-.367-.287-2.228.02-2.729-.435c-.355-.324-.41-.91-.518-1.706c-.2-1.54-.326-1.62-.568-2.142C16.76 3.585 14.382 2.193 12.75 2H8.325C4.845 2 2 4.839 2 8.307v7.356c0 3.461 2.845 6.296 6.325 6.296h7.268zM8.406 7.151h3.507c.67 0 1.212.544 1.212 1.205c0 .657-.542 1.206-1.212 1.206H8.406c-.67 0-1.21-.549-1.21-1.206c0-.661.54-1.205 1.21-1.205zm-1.21 8.418c0-.66.54-1.2 1.21-1.2h7.127c.665 0 1.205.54 1.205 1.2c0 .652-.54 1.2-1.205 1.2H8.406a1.21 1.21 0 0 1-1.21-1.2z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $spotify_url ) :
						echo '<li><a href="' . esc_url( $spotify_url ) . '" title="' . esc_html__( 'Spotify', 'majalahpro' ) . '" class="spotify" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 1.2A8.798 8.798 0 0 0 1.2 10A8.8 8.8 0 1 0 10 1.2zm3.478 13.302c-.173 0-.294-.066-.421-.143c-1.189-.721-2.662-1.099-4.258-1.099c-.814 0-1.693.097-2.61.285l-.112.028c-.116.028-.235.059-.326.059a.651.651 0 0 1-.661-.656c0-.373.21-.637.562-.703a14.037 14.037 0 0 1 3.152-.372c1.855 0 3.513.43 4.931 1.279c.243.142.396.306.396.668a.655.655 0 0 1-.653.654zm.913-2.561c-.207 0-.343-.079-.463-.149c-2.143-1.271-5.333-1.693-7.961-.993a3.742 3.742 0 0 0-.12.037c-.099.031-.191.062-.321.062a.786.786 0 0 1-.783-.788c0-.419.219-.712.614-.824c1.013-.278 1.964-.462 3.333-.462c2.212 0 4.357.555 6.038 1.561c.306.175.445.414.445.771a.784.784 0 0 1-.782.785zm1.036-2.92c-.195 0-.315-.047-.495-.144c-1.453-.872-3.72-1.391-6.069-1.391c-1.224 0-2.336.135-3.306.397a2.072 2.072 0 0 0-.098.027a1.281 1.281 0 0 1-.365.068a.914.914 0 0 1-.919-.929c0-.453.254-.799.68-.925c1.171-.346 2.519-.521 4.006-.521c2.678 0 5.226.595 6.991 1.631c.332.189.495.475.495.872a.908.908 0 0 1-.92.915z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $delicious_url ) :
						echo '<li><a href="' . esc_url( $delicious_url ) . '" title="' . esc_html__( 'Delicious', 'majalahpro' ) . '" class="delicious" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.96em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 464 488"><path d="M444 142q-26-62-83-101q-30-19-60-29q-31-10-69-10q-48 0-90 18q-62 26-101 83q-19 31-29 61T2 232q0 48 18 90q26 62 83 101q31 19 61 29t68 10q48 0 90-18q62-26 101-83q19-30 29-60q10-31 10-69q0-48-18-90zm-28 168q-26 56-73 87q-23 16-52 25q-27 9-59 9V232H33q0-42 15-78q26-56 73-87q23-16 52-25q27-9 59-9v199h199q0 42-15 78z" fill="currentColor"/></svg></a></li>';
					endif;
					
					if ( $tiktok_url ) :
						echo '<li><a href="' . esc_url( $tiktok_url ) . '" title="' . esc_html__( 'Tiktok', 'majalahpro' ) . '" class="tiktok" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.88em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 448 512"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25v178.72A162.55 162.55 0 1 1 185 188.31v89.89a74.62 74.62 0 1 0 52.23 71.18V0h88a121.18 121.18 0 0 0 1.86 22.17A122.18 122.18 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $telegram_url ) :
						echo '<li><a href="' . esc_url( $telegram_url ) . '" title="' . esc_html__( 'Telegram', 'majalahpro' ) . '" class="telegram" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 .5C7.437.5.5 7.438.5 16S7.438 31.5 16 31.5c8.563 0 15.5-6.938 15.5-15.5S24.562.5 16 .5zm7.613 10.619l-2.544 11.988c-.188.85-.694 1.056-1.4.656l-3.875-2.856l-1.869 1.8c-.206.206-.381.381-.781.381l.275-3.944l7.181-6.488c.313-.275-.069-.431-.482-.156l-8.875 5.587l-3.825-1.194c-.831-.262-.85-.831.175-1.231l14.944-5.763c.694-.25 1.3.169 1.075 1.219z" fill="currentColor"/></svg></a></li>';
					endif;

					if ( $soundcloud_url ) :
						echo '<li><a href="' . esc_url( $soundcloud_url ) . '" title="' . esc_html__( 'Soundcloud', 'majalahpro' ) . '" class="soundcloud" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M2.971 12.188c-.041 0-.078.038-.083.082l-.194 1.797l.194 1.756c.005.049.042.082.083.082s.075-.033.084-.082l.211-1.756l-.225-1.797c0-.046-.037-.082-.074-.082m-.75.691c-.051 0-.076.03-.088.079l-.138 1.109l.138 1.092c0 .046.037.078.075.078c.039 0 .073-.038.087-.087l.176-1.1l-.176-1.112c0-.051-.037-.076-.075-.076m1.526-1.025c-.052 0-.1.039-.1.087l-.176 2.139l.188 2.051c0 .049.037.1.099.1c.052 0 .089-.051.102-.1l.211-2.064l-.211-2.126c-.013-.049-.052-.1-.102-.1m.79-.075c-.063 0-.114.051-.126.113l-.161 2.201l.177 2.123c.012.063.061.114.122.114c.064 0 .113-.051.125-.124l.201-2.113l-.201-2.187a.11.11 0 0 0-.111-.112l-.026-.015zm.962.301a.128.128 0 0 0-.133-.125a.134.134 0 0 0-.137.125l-.182 2.026l.169 2.138a.13.13 0 0 0 .132.131c.062 0 .123-.055.123-.132l.189-2.139l-.189-2.036l.028.012zm.674-1.426a.154.154 0 0 0-.148.15l-.176 3.3l.156 2.139c0 .077.066.137.15.137c.078 0 .145-.074.15-.15l.174-2.137l-.173-3.313c-.007-.088-.074-.152-.15-.152m.8-.762a.178.178 0 0 0-.17.163l-.15 4.063l.138 2.125c0 .1.075.174.163.174c.086 0 .161-.074.174-.174l.162-2.125l-.161-4.052c-.013-.1-.088-.175-.175-.175m.826-.372c-.102 0-.176.073-.188.173l-.139 4.4l.139 2.102c.012.1.086.188.188.188a.193.193 0 0 0 .187-.188l.163-2.102l-.164-4.4c0-.1-.087-.188-.188-.188m1.038.038a.196.196 0 0 0-.199-.199a.205.205 0 0 0-.201.199l-.125 4.538l.124 2.089c.015.111.101.199.214.199s.201-.088.201-.199l.136-2.089l-.136-4.55l-.014.012zm.625-.111c-.113 0-.213.1-.213.211l-.125 4.439l.125 2.063c0 .125.1.213.213.213a.221.221 0 0 0 .214-.224l.125-2.064l-.14-4.428c0-.122-.1-.225-.225-.225m.838.139a.236.236 0 0 0-.237.237l-.086 4.29l.113 2.063c0 .124.1.231.236.231c.125 0 .227-.1.237-.237l.101-2.038l-.112-4.265c-.01-.137-.113-.238-.237-.238m.988-.786a.27.27 0 0 0-.139-.037c-.05 0-.1.013-.137.037a.25.25 0 0 0-.125.214v.05l-.086 5.044l.096 2.043v.007c.006.05.024.112.06.15c.05.051.12.086.196.086a.28.28 0 0 0 .175-.074a.262.262 0 0 0 .076-.188l.013-.201l.097-1.838l-.113-5.075a.24.24 0 0 0-.111-.199l-.002-.019zm.837-.457a.155.155 0 0 0-.124-.052a.283.283 0 0 0-.174.052a.265.265 0 0 0-.1.201v.023l-.114 5.513l.063 1.014l.052.988a.274.274 0 0 0 .548-.012l.125-2.013l-.125-5.536a.273.273 0 0 0-.138-.231m7.452 3.15c-.336 0-.663.072-.949.193a4.34 4.34 0 0 0-5.902-3.651c-.188.075-.227.151-.238.301v7.812a.31.31 0 0 0 .275.29h6.827a2.428 2.428 0 0 0 2.45-2.438a2.457 2.457 0 0 0-2.45-2.463" fill="currentColor"/></svg></a></li>';
					endif;

					if ( 0 === $rssicon ) :
						echo '<li><a href="' . esc_url( get_bloginfo( 'rss2_url' ) ) . '" title="' . esc_html__( 'RSS', 'majalahpro' ) . '" class="rss" target="_blank" rel="nofollow"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M14.92 18H18C18 9.32 10.82 2.25 2 2.25v3.02c7.12 0 12.92 5.71 12.92 12.73zm-5.44 0h3.08C12.56 12.27 7.82 7.6 2 7.6v3.02c2 0 3.87.77 5.29 2.16A7.292 7.292 0 0 1 9.48 18zm-5.35-.02c1.17 0 2.13-.93 2.13-2.09c0-1.15-.96-2.09-2.13-2.09c-1.18 0-2.13.94-2.13 2.09c0 1.16.95 2.09 2.13 2.09z" fill="currentColor"/></svg></a></li>';
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

		$output  = '';
		$output .= '<ul class="gmr-socialicon-share">';
		$output .= '<li class="facebook">';
		$output .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode( esc_url( get_permalink() ) ) . '" class="gmr-share-facebook" rel="nofollow" title="' . __( 'Share this', 'majalahpro' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="0.49em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 486.037 1000"><path d="M124.074 1000V530.771H0V361.826h124.074V217.525C124.074 104.132 197.365 0 366.243 0C434.619 0 485.18 6.555 485.18 6.555l-3.984 157.766s-51.564-.502-107.833-.502c-60.9 0-70.657 28.065-70.657 74.646v123.361h183.331l-7.977 168.945H302.706V1000H124.074" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="twitter">';
		$output .= '<a href="https://twitter.com/share?url=' . rawurlencode( esc_url( get_permalink() ) ) . '&amp;text=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ) . '" class="gmr-share-twitter" rel="nofollow" title="' . __( 'Tweet this', 'majalahpro' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1.24em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1231.051 1000"><path d="M1231.051 118.453q-51.422 76.487-126.173 130.403q.738 14.46.738 32.687q0 101.273-29.53 202.791q-29.53 101.519-90.215 194.343q-60.685 92.824-144.574 164.468q-83.889 71.644-201.677 114.25q-117.788 42.606-252.474 42.606q-210.2 0-387.147-113.493q31.406 3.495 60.242 3.495q175.605 0 313.687-108.177q-81.877-1.501-146.654-50.409q-64.777-48.907-89.156-124.988q24.097 4.59 47.566 4.59q33.782 0 66.482-8.812q-87.378-17.5-144.975-87.04q-57.595-69.539-57.595-160.523v-3.126q53.633 29.696 114.416 31.592q-51.762-34.508-82.079-89.999q-30.319-55.491-30.319-120.102q0-68.143 34.151-126.908q95.022 116.607 230.278 186.392q135.258 69.786 290.212 77.514q-6.609-27.543-6.621-57.485q0-104.546 73.994-178.534Q747.623 0 852.169 0q109.456 0 184.392 79.711q85.618-16.959 160.333-61.349q-28.785 90.59-110.933 139.768q75.502-8.972 145.088-39.677z" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="pinterest">';
		$output .= '<a href="https://pinterest.com/pin/create/button/?url=' . rawurlencode( esc_url( get_permalink() ) ) . '&amp;media=' . $thumb . '&amp;description=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ) . '" class="gmr-share-pinit" rel="nofollow" title="' . __( 'Pin this', 'majalahpro' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16.75.406C10.337.406 4 4.681 4 11.6c0 4.4 2.475 6.9 3.975 6.9c.619 0 .975-1.725.975-2.212c0-.581-1.481-1.819-1.481-4.238c0-5.025 3.825-8.588 8.775-8.588c4.256 0 7.406 2.419 7.406 6.863c0 3.319-1.331 9.544-5.644 9.544c-1.556 0-2.888-1.125-2.888-2.737c0-2.363 1.65-4.65 1.65-7.088c0-4.137-5.869-3.387-5.869 1.613c0 1.05.131 2.212.6 3.169c-.863 3.713-2.625 9.244-2.625 13.069c0 1.181.169 2.344.281 3.525c.212.238.106.213.431.094c3.15-4.313 3.038-5.156 4.463-10.8c.769 1.463 2.756 2.25 4.331 2.25c6.637 0 9.619-6.469 9.619-12.3c0-6.206-5.363-10.256-11.25-10.256z" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="telegram">';
		$output .= '<a href="https://t.me/share/url?url=' . rawurlencode( esc_url( get_the_permalink() ) ) . '&amp;text=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ) . '" target="_blank" rel="nofollow" title="' . esc_html__( 'Telegram Share', 'majalahpro' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48"><path d="M41.42 7.309s3.885-1.515 3.56 2.164c-.107 1.515-1.078 6.818-1.834 12.553l-2.59 16.99s-.216 2.489-2.159 2.922c-1.942.432-4.856-1.515-5.396-1.948c-.432-.325-8.094-5.195-10.792-7.575c-.756-.65-1.62-1.948.108-3.463L33.648 18.13c1.295-1.298 2.59-4.328-2.806-.649l-15.11 10.28s-1.727 1.083-4.964.109l-7.016-2.165s-2.59-1.623 1.835-3.246c10.793-5.086 24.068-10.28 35.831-15.15z" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="whatsapp">';
		$output .= '<a href="https://api.whatsapp.com/send?text=' . rawurlencode( wp_strip_all_tags( get_the_title() ) ) . ' ' . rawurlencode( esc_url( get_permalink() ) ) . '" class="gmr-share-whatsapp" rel="nofollow" title="' . __( 'Whatsapp', 'majalahpro' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M15.271 13.21a7.014 7.014 0 0 1 1.543.7l-.031-.018c.529.235.986.51 1.403.833l-.015-.011c.02.061.032.13.032.203l-.001.032v-.001c-.015.429-.11.832-.271 1.199l.008-.021c-.231.463-.616.82-1.087 1.01l-.014.005a3.624 3.624 0 0 1-1.576.411h-.006a8.342 8.342 0 0 1-2.988-.982l.043.022a8.9 8.9 0 0 1-2.636-1.829l-.001-.001a20.473 20.473 0 0 1-2.248-2.794l-.047-.074a5.38 5.38 0 0 1-1.1-2.995l-.001-.013v-.124a3.422 3.422 0 0 1 1.144-2.447l.003-.003a1.17 1.17 0 0 1 .805-.341h.001c.101.003.198.011.292.025l-.013-.002c.087.013.188.021.292.023h.003a.642.642 0 0 1 .414.102l-.002-.001c.107.118.189.261.238.418l.002.008q.124.31.512 1.364c.135.314.267.701.373 1.099l.014.063a1.573 1.573 0 0 1-.533.889l-.003.002q-.535.566-.535.72a.436.436 0 0 0 .081.234l-.001-.001a7.03 7.03 0 0 0 1.576 2.119l.005.005a9.89 9.89 0 0 0 2.282 1.54l.059.026a.681.681 0 0 0 .339.109h.002q.233 0 .838-.752t.804-.752zm-3.147 8.216h.022a9.438 9.438 0 0 0 3.814-.799l-.061.024c2.356-.994 4.193-2.831 5.163-5.124l.024-.063c.49-1.113.775-2.411.775-3.775s-.285-2.662-.799-3.837l.024.062c-.994-2.356-2.831-4.193-5.124-5.163l-.063-.024c-1.113-.49-2.411-.775-3.775-.775s-2.662.285-3.837.799l.062-.024c-2.356.994-4.193 2.831-5.163 5.124l-.024.063a9.483 9.483 0 0 0-.775 3.787a9.6 9.6 0 0 0 1.879 5.72l-.019-.026l-1.225 3.613l3.752-1.194a9.45 9.45 0 0 0 5.305 1.612h.047zm0-21.426h.033c1.628 0 3.176.342 4.575.959L16.659.93c2.825 1.197 5.028 3.4 6.196 6.149l.029.076c.588 1.337.93 2.896.93 4.535s-.342 3.198-.959 4.609l.029-.074c-1.197 2.825-3.4 5.028-6.149 6.196l-.076.029c-1.327.588-2.875.93-4.503.93h-.034h.002h-.053c-2.059 0-3.992-.541-5.664-1.488l.057.03L-.001 24l2.109-6.279a11.505 11.505 0 0 1-1.674-6.01c0-1.646.342-3.212.959-4.631l-.029.075C2.561 4.33 4.764 2.127 7.513.959L7.589.93A11.178 11.178 0 0 1 12.092 0h.033h-.002z" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';
		$output .= '<li class="comment-icon">';
		$output .= '<a href="#comment-wrap" class="gmr-share-comment" rel="nofollow" title="' . __( 'Comment', 'newkarma' ) . '">';
		$output .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 23a1 1 0 0 1-1-1v-3H7a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-4.1l-3.7 3.71c-.2.19-.45.29-.7.29H12m1-6v3.08L16.08 17H21V7H7v10h6M3 15H1V3a2 2 0 0 1 2-2h16v2H3v12z" fill="currentColor"/></svg>';
		$output .= '</a>';
		$output .= '</li>';

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
