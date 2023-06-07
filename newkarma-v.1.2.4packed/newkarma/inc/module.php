<?php
/**
 * Custom homepage category content.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'newkarma_display_carousel' ) ) :
	/**
	 * This function for display slider in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function newkarma_display_carousel() {
		global $post;
		$post_num = get_theme_mod( 'gmr_headline_number', '5' );
		$cat      = get_theme_mod( 'gmr_category-headline', 0 );

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => $post_num,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			// make it fast withour update term cache and cache results
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		$recent = get_posts( $args );
		echo '<div class="clearfix gmr-element-carousel">';
			echo '<div class="gmr-title-carousel">';
			$textheadline = get_theme_mod( 'gmr_textheadline' );
		if ( $textheadline ) :
			// sanitize html output.
			echo esc_html( $textheadline );
		else :
			echo esc_html__( 'Head Lines', 'newkarma' );
		endif;

			echo '</div>';
			echo '<div class="gmr-owl-wrap">';
			echo '<div class="gmr-owl-carousel owl-carousel owl-theme">';
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				?>
				<div class="item gmr-slider-content">
					<?php
					$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
					if ( ! empty( $featured_image_url ) ) {
						?>
						<div class="other-content-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '', 'echo' => true ) ); ?>">
								<?php
								if ( has_post_thumbnail() ) :
									the_post_thumbnail( 'large' );
								endif;
								?>
							</a>
							<?php
							if ( has_post_format( 'gallery' ) ) {
								echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="currentColor"/></svg>';
							} elseif ( has_post_format( 'video' ) ) {
								echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/><path d="M719.4 499.1l-296.1-215A15.9 15.9 0 0 0 398 297v430c0 13.1 14.8 20.5 25.3 12.9l296.1-215a15.9 15.9 0 0 0 0-25.8zm-257.6 134V390.9L628.5 512L461.8 633.1z" fill="currentColor"/></svg>';
								$h = get_post_meta( $post->ID, '_durh', true );
								$m = get_post_meta( $post->ID, '_durm', true );
								$s = get_post_meta( $post->ID, '_durs', true );
								if ( ! empty( $h ) || ! empty( $m ) || ! empty( $s ) ) {
									echo '<div class="duration">';
									if ( ! empty( $h ) && 0 !== $h ) {
										echo esc_html( str_pad( absint( $h ), 2, '0', STR_PAD_LEFT ) . ':' );
									}
									if ( ! empty( $m ) ) {
										echo esc_html( str_pad( absint( $m ), 2, '0', STR_PAD_LEFT ) . ':' );
									} else {
										echo '00';
									}
									if ( ! empty( $s ) ) {
										echo esc_html( str_pad( absint( $s ), 2, '0', STR_PAD_LEFT ) );
									} else {
										echo '00';
									}
									echo '</div>';
								}
							}
							?>
						</div>

					<?php } ?>
					<div class="gmr-slide-title">
						<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</div>
				</div>
				<?php
			endforeach;
			echo '</div>';
			echo '</div>';

		echo '</div>';
	}
endif; // endif newkarma_display_carousel.
add_action( 'newkarma_display_carousel', 'newkarma_display_carousel', 50 );

if ( ! function_exists( 'newkarma_display_modulehome' ) ) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function newkarma_display_modulehome() {
		global $post;
		$post_num = get_theme_mod( 'gmr_module_number', '3' );
		$cat      = get_theme_mod( 'gmr_category-module-home', 0 );

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => $post_num,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			// make it fast withour update term cache and cache results.
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		$recent = get_posts( $args );
		if ( $recent ) {
			echo '<div class="clearfix gmr-modulehome">';
				$count = 0;
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				$count++;
				if ( $count <= 1 ) {
					echo '<div class="gmr-metacontent">';
					echo esc_html( get_the_date() );
					echo '</div>';
					?>
					<h2 class="gmr-module-title">
						<a href="<?php the_permalink(); ?>" class="gmr-module-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="row">
						<div class="gmr-left-module">
							<?php
							$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
							if ( ! empty( $featured_image_url ) ) {
								?>
								<div class="other-content-thumbnail">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '', 'echo' => true ) ); ?>">
										<?php
										if ( has_post_thumbnail() ) :
											the_post_thumbnail( 'idt-bigger-thumb' );
										endif;
										?>
									</a>
									<?php
									if ( has_post_format( 'gallery' ) ) {
										echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="currentColor"/></svg>';
									} elseif ( has_post_format( 'video' ) ) {
										echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/><path d="M719.4 499.1l-296.1-215A15.9 15.9 0 0 0 398 297v430c0 13.1 14.8 20.5 25.3 12.9l296.1-215a15.9 15.9 0 0 0 0-25.8zm-257.6 134V390.9L628.5 512L461.8 633.1z" fill="currentColor"/></svg>';
										$h = get_post_meta( $post->ID, '_durh', true );
										$m = get_post_meta( $post->ID, '_durm', true );
										$s = get_post_meta( $post->ID, '_durs', true );
										if ( ! empty( $h ) || ! empty( $m ) || ! empty( $s ) ) {
											echo '<div class="duration">';
											if ( ! empty( $h ) && 0 !== $h ) {
												echo esc_html( str_pad( absint( $h ), 2, '0', STR_PAD_LEFT ) . ':' );
											}
											if ( ! empty( $m ) ) {
												echo esc_html( str_pad( absint( $m ), 2, '0', STR_PAD_LEFT ) . ':' );
											} else {
												echo '00';
											}
											if ( ! empty( $s ) ) {
												echo esc_html( str_pad( absint( $s ), 2, '0', STR_PAD_LEFT ) );
											} else {
												echo '00';
											}
											echo '</div>';
										}

									}
									?>
								</div>

							<?php } ?>
						</div>

						<?php
							/* translators: used between list items, there is a space after the comma */
							$categories_list = get_the_category_list( esc_html__( ', ', 'newkarma' ) );
							$posted_in       = '';
						if ( $categories_list ) {
							$posted_in = sprintf( '%1$s', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>

						<div class="gmr-right-module">
							<?php
								echo '<div class="gmr-cat-bg">' . $posted_in . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								the_excerpt();
							?>
							<?php
							echo '<div class="gmr-title-module-related">';
							$textrelated = get_theme_mod( 'gmr_textrelated' );
							if ( $textrelated ) :
								// sanitize html output.
								echo esc_html( $textrelated );
							else :
								echo esc_html__( 'Related News', 'newkarma' );
							endif;
							echo '</div>';
							?>
						<?php } else { ?>
							<div class="module-related-wrap"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M8 6l6 4.03L8 14V6z" fill="currentColor"/></svg> <div class="gmr-module-related"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div></div>
						<?php
						}
				endforeach;
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
endif; // endif newkarma_display_modulehome.
add_action( 'newkarma_display_modulehome', 'newkarma_display_modulehome', 50 );

if ( ! function_exists( 'newkarma_display_modulepopuler' ) ) :
	/**
	 * This function for display module populer
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function newkarma_display_modulepopuler() {
		global $post;
		$post_num      = get_theme_mod( 'gmr_module_number', '3' );
		$cat           = get_theme_mod( 'gmr_category-module-home', 0 );
		$popular_range = get_theme_mod( 'gmr_module-populartime', 'alltime' );

		$args = array(
			'post_type'              => 'post',
			'order'                  => 'desc',
			'showposts'              => $post_num,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'meta_value_num',
			'meta_key'               => 'views',
			// make it fast withour update term cache and cache results.
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		// Get Current Tax ID.
		$tax    = get_queried_object();
		$tax_id = $tax->term_id;

		if ( is_category() ) {
			$args['cat'] = $tax_id;
		} elseif ( is_tag() ) {
			$args['tag_id'] = $tax_id;
		} elseif ( is_tax( 'newstopic' ) ) {
			// Get posts last week.
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'newstopic',
					'field'    => 'term_id',
					'terms'    => $tax_id,
				),
			);
		}

		if ( 'weekly' === $popular_range ) {
			// Get posts last week.
			$args['date_query'] = array(
				array(
					'after' => '1 week ago',
				),
			);
		} elseif ( 'mountly' === $popular_range ) {
			// Get posts last mount.
			$args['date_query'] = array(
				array(
					'after' => '1 month ago',
				),
			);
		} elseif ( 'secondmountly' === $popular_range ) {
			// Get posts last second mount.
			$args['date_query'] = array(
				array(
					'after' => '2 months ago',
				),
			);
		} elseif ( 'yearly' === $popular_range ) {
			// Get posts last year.
			$args['date_query'] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}

		$recent = get_posts( $args );
		if ( $recent ) {
			echo '<div class="clearfix gmr-modulehome">';
				$count = 0;
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				$count++;
				if ( $count <= 1 ) {
					echo '<div class="gmr-metacontent">';
					echo esc_html( get_the_date() );
					echo '</div>';
					?>
					<h2 class="gmr-module-title">
						<a href="<?php the_permalink(); ?>" class="gmr-module-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="row">
					<div class="gmr-left-module">
						<?php
						$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );

						if ( ! empty( $featured_image_url ) ) {
							?>
							<div class="other-content-thumbnail">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '', 'echo' => true ) ); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( 'idt-bigger-thumb' );
									endif;
									?>
								</a>
								<?php
								if ( has_post_format( 'gallery' ) ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="currentColor"/></svg>';
								} elseif ( has_post_format( 'video' ) ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448s448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372s372 166.6 372 372s-166.6 372-372 372z" fill="currentColor"/><path d="M719.4 499.1l-296.1-215A15.9 15.9 0 0 0 398 297v430c0 13.1 14.8 20.5 25.3 12.9l296.1-215a15.9 15.9 0 0 0 0-25.8zm-257.6 134V390.9L628.5 512L461.8 633.1z" fill="currentColor"/></svg>';
									$h = get_post_meta( $post->ID, '_durh', true );
									$m = get_post_meta( $post->ID, '_durm', true );
									$s = get_post_meta( $post->ID, '_durs', true );
									if ( ! empty( $h ) || ! empty( $m ) || ! empty( $s ) ) {
										echo '<div class="duration">';
										if ( ! empty( $h ) && 0 !== $h ) {
											echo esc_html( str_pad( absint( $h ), 2, '0', STR_PAD_LEFT ) . ':' );
										}
										if ( ! empty( $m ) ) {
											echo esc_html( str_pad( absint( $m ), 2, '0', STR_PAD_LEFT ) . ':' );
										} else {
											echo '00';
										}
										if ( ! empty( $s ) ) {
											echo esc_html( str_pad( absint( $s ), 2, '0', STR_PAD_LEFT ) );
										} else {
											echo '00';
										}
										echo '</div>';
									}

								}
								?>
							</div>

						<?php } ?>
					</div>

						<?php
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( esc_html__( ', ', 'newkarma' ) );
						$posted_in       = '';
						if ( $categories_list ) {
							$posted_in = sprintf( '%1$s', $categories_list ); // WPCS: XSS OK.
						}
						?>

						<div class="gmr-right-module">
							<?php
								echo '<div class="gmr-cat-bg">' . $posted_in . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								the_excerpt();
							?>
							<?php
							echo '<div class="gmr-title-module-related">';
							$textrelated = get_theme_mod( 'gmr_textrelated' );
							if ( $textrelated ) :
								// sanitize html output.
								echo esc_html( $textrelated );
							else :
								echo esc_html__( 'Related News', 'newkarma' );
							endif;
							echo '</div>';
							?>
						<?php } else { ?>
							<div class="module-related-wrap"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M8 6l6 4.03L8 14V6z" fill="currentColor"/></svg> <div class="gmr-module-related"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div></div>
						<?php
						}
				endforeach;
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
	}
endif; // endif newkarma_display_modulepopuler.
add_action( 'newkarma_display_modulepopuler', 'newkarma_display_modulepopuler', 50 );
