<?php
/**
 * Widget API: Majalahpro_Mostview_Widget class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Newkarma
 * @subpackage Widgets
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the Most view widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Majalahpro_Mostview_Widget extends WP_Widget {
	/**
	 * Sets up a Most view Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'newkarma-widget-post',
			'description' => __( 'Most view posts with thumbnails widget.', 'newkarma' ),
		);
		parent::__construct( 'newkarma-mostview', __( 'Most view Posts (Newkarma)', 'newkarma' ), $widget_ops );

		// add action for admin_register_scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_register_scripts' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0
	 *
	 * @param string $hook_suffix Hook Suffix.
	 */
	public function admin_register_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'suggest' );
		wp_enqueue_script( 'underscore' );
	}

	/**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function admin_print_scripts() {
		?>
		<script>
			function setSuggest_cat_view(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=category", {multiple:true, multipleSep: ","});
			}
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}

	/**
	 * Outputs the content for Mailchimp Form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for Mailchimp Form.
	 */
	public function widget( $args, $instance ) {
		global $post;

		// Title.
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		// URL.
		$newkar_url = ( ! empty( $instance['newkar_url'] ) ) ? esc_url( $instance['newkar_url'] ) : '';

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( $newkar_url ) {
				echo '<a href="' . esc_url( $newkar_url ) . '" class="widget-url" title="' . esc_html__( 'Permalink to: ', 'newkarma' ) . esc_url( $newkar_url ) . '">+</a>';
			}
			echo $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		// Base Id Widget.
		$newkar_widget_id = $this->id_base . '-' . $this->number;
		// Category ID.
		$newkar_category = ( ! empty( $instance['newkar_category'] ) ) ? wp_strip_all_tags( $instance['newkar_category'] ) : '';
		// Style.
		$newkar_style = ( ! empty( $instance['newkar_style'] ) ) ? wp_strip_all_tags( $instance['newkar_style'] ) : wp_strip_all_tags( 'style_1' );
		// Number Posts.
		$newkar_number_posts = ( ! empty( $instance['newkar_number_posts'] ) ) ? absint( $instance['newkar_number_posts'] ) : absint( 5 );
		// Title Length.
		$newkar_title_length = ( ! empty( $instance['newkar_title_length'] ) ) ? absint( $instance['newkar_title_length'] ) : absint( 80 );
		// Popular by date.
		$newkar_popular_date = ( isset( $instance['newkar_popular_date'] ) ) ? esc_attr( $instance['newkar_popular_date'] ) : esc_attr( 'alltime' );
		// Hide current post.
		$newkar_hide_current_post = ( isset( $instance['newkar_hide_current_post'] ) ) ? (bool) $instance['newkar_hide_current_post'] : false;
		$newkar_show_categories   = ( isset( $instance['newkar_show_categories'] ) ) ? (bool) $instance['newkar_show_categories'] : false;
		$newkar_show_view         = ( isset( $instance['newkar_show_view'] ) ) ? (bool) $instance['newkar_show_view'] : false;

		// Style.
		$bgcolor    = ( ! empty( $instance['bgcolor'] ) ) ? wp_strip_all_tags( $instance['bgcolor'] ) : '';
		$color_text = ( ! empty( $instance['color_text'] ) ) ? wp_strip_all_tags( $instance['color_text'] ) : '';
		$color_link = ( ! empty( $instance['color_link'] ) ) ? wp_strip_all_tags( $instance['color_link'] ) : '';
		$color_meta = ( ! empty( $instance['color_meta'] ) ) ? wp_strip_all_tags( $instance['color_meta'] ) : '';

		// filter the arguments for the Recent Posts widget:.

		// standard params.
		$query_args = array(
			'posts_per_page'         => $newkar_number_posts,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			// make it fast withour update term cache and cache results.
			// https://thomasgriffin.io/optimize-wordpress-queries/.
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		$query_args['ignore_sticky_posts'] = true;
		
		if ( class_exists( 'Post_Views_Counter' ) ) {
			$query_args['orderby'] = 'post_views';
		} else {
			$query_args['meta_key'] = 'views';
			$query_args['orderby']  = 'meta_value_num';
			$query_args['order']    = 'DESC';
		}

		if ( 'weekly' === $newkar_popular_date ) {
			// Get posts last week.
			$query_args['date_query'] = array(
				array(
					'after' => '1 week ago',
				),
			);
		} elseif ( 'mountly' === $newkar_popular_date ) {
			// Get posts last mount.
			$query_args['date_query'] = array(
				array(
					'after' => '1 month ago',
				),
			);
		} elseif ( 'secondmountly' === $newkar_popular_date ) {
			// Get posts last mount.
			$query_args['date_query'] = array(
				array(
					'after' => '2 months ago',
				),
			);
		} elseif ( 'yearly' === $newkar_popular_date ) {
			// Get posts last mount.
			$query_args['date_query'] = array(
				array(
					'after' => '1 year ago',
				),
			);
		}

		// add categories param only if 'all categories' was not selected.
		$cat_id_array = $this->generate_cat_id_from_name( $newkar_category );
		if ( count( $cat_id_array ) > 0 ) {
			$query_args['category__in'] = $cat_id_array;
		}

		// exclude current displayed post.
		if ( $newkar_hide_current_post ) {
			global $post;
			if ( isset( $post->ID ) && is_singular() ) {
				$query_args['post__not_in'] = array( $post->ID );
			}
		}

		// run the query: get the latest posts.
		$rp = new WP_Query( apply_filters( 'newkar_rp_widget_posts_args', $query_args ) );
		if ( $bgcolor ) {
			$color = ' style="background-color:' . esc_html( $bgcolor ) . '"';
		} else {
			$color = '';
		}
		if ( $color_link ) {
			$colorlink = ' style="color:' . esc_html( $color_link ) . '"';
		} else {
			$colorlink = '';
		}
		if ( $color_meta ) {
			$colormeta = ' style="color:' . esc_html( $color_meta ) . '"';
		} else {
			$colormeta = '';
		}
		if ( 'style_2' === $newkar_style ) :
			?>
			<div class="newkarma-rp-widget"<?php echo $color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="newkarma-rp">
					<ul>
						<?php
						$count = 0;
						while ( $rp->have_posts() ) :
							$rp->the_post();
							if ( has_post_thumbnail() ) {
								$class = 'has-post-thumbnail clearfix';
							} else {
								$class = 'clearfix';
							}
							$count++;
							if ( $count <= 1 ) {
								?>
							<li class="<?php echo esc_html( $class ); ?>">
								<?php
								// look for featured image.
								if ( has_post_thumbnail() ) {
									echo '<div class="content-big-thumbnail">';
										echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
											array(
												'before' => __( 'Permalink to: ', 'newkarma' ),
												'after'  => '',
												'echo'   => false,
											)
										) . '" rel="bookmark">';
											the_post_thumbnail( 'large' );
										echo '</a>';
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
									echo '</div>';
								} // has_post_thumbnail.
								?>
								<div class="gmr-rp-big-content">
									<a href="<?php the_permalink(); ?>" class="rp-title"<?php echo $colorlink; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
									</a>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</li>
							<?php } else { ?>
							<li class="<?php echo esc_html( $class ); ?>">
								<?php
								// look for featured image.
								if ( has_post_thumbnail() ) {
									echo '<div class="content-thumbnail">';
										echo '<a href="' . esc_html( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
											array(
												'before' => __( 'Permalink to: ', 'newkarma' ),
												'after'  => '',
												'echo'   => false,
											)
										) . '" rel="bookmark">';
											the_post_thumbnail( 'thumbnail' );
										echo '</a>';
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
									echo '</div>';

								} // has_post_thumbnail.
								?>
								<div class="gmr-rp-content">
									<a href="<?php the_permalink(); ?>" class="rp-title"<?php echo $colorlink; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
									</a>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</li>
							<?php } ?>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
		<?php elseif ( 'style_3' === $newkar_style ) : ?>
			<div class="newkarma-rp-widget"<?php echo $color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="newkarma-rp">
					<ul>
						<?php
						$count = 0;
						while ( $rp->have_posts() ) :
							$rp->the_post();
							if ( has_post_thumbnail() ) {
								$class = 'has-post-thumbnail clearfix';
							} else {
								$class = 'clearfix';
							}
							$count++;
							if ( $count <= 1 ) {
								?>
							<li class="<?php echo esc_html( $class ); ?>">
								<?php
								// look for featured image.
								if ( has_post_thumbnail() ) {
									echo '<div class="content-big-thumbnail">';
										echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
										the_title_attribute(
											array(
												'before' => __( 'Permalink to: ', 'newkarma' ),
												'after'  => '',
												'echo'   => false,
											)
										);
										echo '" rel="bookmark">';
											the_post_thumbnail( 'large' );
										echo '</a>';
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
									echo '</div>';

								} // has_post_thumbnail.
								?>
								<div class="rp-number pull-left"><?php echo esc_html( $count ); ?></div>
								<div class="gmr-rp-number-content">
									<a href="<?php the_permalink(); ?>" class="rp-title"<?php echo $colorlink; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ','newkarma' ), 'after' => '' ) ); ?>">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
									</a>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</li>
							<?php } else { ?>
							<li>
								<div class="rp-number pull-left"><?php echo esc_html( $count ); ?></div>
								<div class="gmr-rp-number-content">
									<a href="<?php the_permalink(); ?>" class="rp-title"<?php echo $colorlink; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
									</a>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</li>
							<?php } ?>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
		<?php elseif ( 'style_4' === $newkar_style ) : ?>
			<div class="newkarma-rp-widget"<?php echo $color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="newkarma-rp gmr-rp-bigthumbnail-wrap">
					<?php
					while ( $rp->have_posts() ) :
						$rp->the_post();
						?>
						<div class="clearfix gmr-rp-bigthumbnail">
							<a href="<?php the_permalink(); ?>" class="rp-title" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
								<?php
								// look for featured image.
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'large' );
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
								} // has_post_thumbnail
								?>
								<div class="gmr-rp-bigthumb-content">
									<?php
									if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
										echo '<span class="title-bigthumb"';
										if ( $color_link ) {
											echo ' style="color:' . esc_html( $color_link ) . '"';
										}
										echo '>';
										echo esc_html( $post_title );
										echo '</span>';
									} else {
										echo '<span class="title-bigthumb"';
										if ( $color_link ) {
											echo ' style="color:' . esc_html( $color_link ) . '"';
										}
										echo '>';
										the_title();
										echo '</span>';
									}
									?>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</a>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php else : ?>
			<div class="newkarma-rp-widget"<?php echo $color; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<div class="newkarma-rp">
					<ul>
						<?php
						while ( $rp->have_posts() ) :
							$rp->the_post();
							if ( has_post_thumbnail() ) {
								$class = 'has-post-thumbnail clearfix';
							} else {
								$class = 'clearfix';
							}
							?>
							<li class="<?php echo esc_html( $class ); ?>">
								<?php
								// look for featured image.
								if ( has_post_thumbnail() ) {
									echo '<div class="content-thumbnail">';
										echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="';
										the_title_attribute(
											array(
												'before' => __( 'Permalink to: ', 'newkarma' ),
												'after'  => '',
												'echo'   => false,
											)
										);
										echo '" rel="bookmark">';
											the_post_thumbnail( 'thumbnail' );
										echo '</a>';
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
									echo '</div>';

								} // has_post_thumbnail.
								?>
								<div class="gmr-rp-content">
									<a href="<?php the_permalink(); ?>" class="rp-title"<?php echo $colorlink; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
										<?php
										if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
											echo esc_html( $post_title );
										} else {
											the_title();
										}
										?>
									</a>
									<div class="gmr-metacontent"<?php echo $colormeta; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
										<?php
										if ( $newkar_show_categories ) :
											echo '<span class="cat-links">';
												echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											echo '</span>';
										endif;
										if ( $newkar_show_view ) :
											if ( class_exists( 'Post_Views_Counter' ) ) {
												$number = pvc_get_post_views( $post->ID );
												echo absint( $number ) . ' ' . esc_html__( 'Views', 'newkarma' );
											} elseif ( function_exists( 'the_views' ) ) {
												the_views();
											}
										endif;
										?>
									</div>
								</div>
							</li>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
			<?php
		endif;
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Mailchimp widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            Newkarma_Mailchimp_form::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args(
			(array) $new_instance,
			array(
				'title'                    => '',
				'newkar_url'               => '',
				'newkar_category'          => '',
				'newkar_style'             => 'style_1',
				'newkar_number_posts'      => 5,
				'newkar_title_length'      => 80,
				'newkar_hide_current_post' => false,
				'newkar_show_categories'   => false,
				'newkar_popular_date'      => 'alltime',
				'newkar_show_view'         => false,
				'bgcolor'                  => '',
				'color_text'               => '',
				'color_link'               => '',
				'color_meta'               => '',
			)
		);
		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// URL.
		$instance['newkar_url'] = esc_url( $new_instance['newkar_url'] );
		// Category IDs.
		$instance['newkar_category'] = wp_strip_all_tags( $new_instance['newkar_category'] );
		// Style.
		$instance['newkar_style'] = wp_strip_all_tags( $new_instance['newkar_style'] );
		// Number posts.
		$instance['newkar_number_posts'] = absint( $new_instance['newkar_number_posts'] );
		// Title Length.
		$instance['newkar_title_length'] = absint( $new_instance['newkar_title_length'] );
		// Popular range.
		$instance['newkar_popular_date'] = esc_attr( $new_instance['newkar_popular_date'] );
		// Hide current post.
		$instance['newkar_hide_current_post'] = (bool) $new_instance['newkar_hide_current_post'];
		// Show element.
		$instance['newkar_show_categories'] = (bool) $new_instance['newkar_show_categories'];
		$instance['newkar_show_view']       = (bool) $new_instance['newkar_show_view'];
		// Style.
		$instance['bgcolor']    = wp_strip_all_tags( $new_instance['bgcolor'] );
		$instance['color_text'] = wp_strip_all_tags( $new_instance['color_text'] );
		$instance['color_link'] = wp_strip_all_tags( $new_instance['color_link'] );
		$instance['color_meta'] = wp_strip_all_tags( $new_instance['color_meta'] );
		return $instance;
	}

	/**
	 * Outputs the settings form for the Mailchimp widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'                    => 'Most View Post',
				'newkar_url'               => '',
				'newkar_category'          => '',
				'newkar_style'             => 'style_1',
				'newkar_number_posts'      => 5,
				'newkar_title_length'      => 80,
				'newkar_hide_current_post' => false,
				'newkar_show_categories'   => false,
				'newkar_popular_date'      => 'alltime',
				'newkar_show_view'         => true,
				'bgcolor'                  => '',
				'color_text'               => '',
				'color_link'               => '',
				'color_meta'               => '',
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// URL.
		$newkar_url = esc_url( $instance['newkar_url'] );
		// Category ID.
		$newkar_category = wp_strip_all_tags( $instance['newkar_category'] );
		// Style.
		$newkar_style = wp_strip_all_tags( $instance['newkar_style'] );
		// Number posts.
		$newkar_number_posts = absint( $instance['newkar_number_posts'] );
		// Title Length.
		$newkar_title_length = absint( $instance['newkar_title_length'] );
		// Popular range.
		$newkar_popular_date = esc_attr( $instance['newkar_popular_date'] );
		// Hide current post.
		$newkar_hide_current_post = (bool) $instance['newkar_hide_current_post'];
		// Show element.
		$newkar_show_categories = (bool) $instance['newkar_show_categories'];
		$newkar_show_view       = (bool) $instance['newkar_show_view'];
		// Style.
		$bgcolor    = wp_strip_all_tags( $instance['bgcolor'] );
		$color_text = wp_strip_all_tags( $instance['color_text'] );
		$color_link = wp_strip_all_tags( $instance['color_link'] );
		$color_meta = wp_strip_all_tags( $instance['color_meta'] );

		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_url' ) ); ?>"><?php esc_html_e( 'Link URL:', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_url' ) ); ?>" placeholder="http://www.example.com" name="<?php echo esc_html( $this->get_field_name( 'newkar_url' ) ); ?>" type="url" value="<?php echo esc_url( $newkar_url ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_category' ) ); ?>"><?php esc_html_e( 'Selected categories', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_category' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_category' ) ); ?>" type="text" value="<?php echo esc_html( $newkar_category ); ?>" onfocus ="setSuggest_cat_view('<?php echo esc_html( $this->get_field_id( 'newkar_category' ) ); ?>');" />
			<br />
			<small><?php esc_html_e( 'Category Names, separated by commas. Eg: News, Home Design, Technology.', 'newkarma' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_style' ) ); ?>"><?php esc_html_e( 'Style', 'newkarma' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_style', 'newkarma' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_style' ) ); ?>">
				<option value="style_1" <?php echo selected( $instance['newkar_style'], 'style_1', false ); ?>><?php esc_html_e( 'List Thumbnail', 'newkarma' ); ?></option>
				<option value="style_2" <?php echo selected( $instance['newkar_style'], 'style_2', false ); ?>><?php esc_html_e( 'List Thumbnail With 1 Big Thumbnail', 'newkarma' ); ?></option>
				<option value="style_3" <?php echo selected( $instance['newkar_style'], 'style_3', false ); ?>><?php esc_html_e( 'List Number With 1 Big Thumbnail', 'newkarma' ); ?></option>
				<option value="style_4" <?php echo selected( $instance['newkar_style'], 'style_4', false ); ?>><?php esc_html_e( 'List Gallery', 'newkarma' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $newkar_number_posts ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_popular_date' ) ); ?>"><?php esc_html_e( 'Popular range:', 'newkarma' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_popular_date', 'newkarma' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_popular_date' ) ); ?>">
				<option value="alltime" <?php selected( $instance['newkar_popular_date'], 'alltime' ); ?>><?php esc_html_e( 'Alltime', 'newkarma' ); ?></option>
				<option value="yearly" <?php selected( $instance['newkar_popular_date'], 'yearly' ); ?>><?php esc_html_e( '1 Year', 'newkarma' ); ?></option>
				<option value="secondmountly" <?php selected( $instance['newkar_popular_date'], 'secondmountly' ); ?>><?php esc_html_e( '2 Mounts', 'newkarma' ); ?></option>
				<option value="mountly" <?php selected( $instance['newkar_popular_date'], 'mountly' ); ?>><?php esc_html_e( '1 Mount', 'newkarma' ); ?></option>
				<option value="weekly" <?php selected( $instance['newkar_popular_date'], 'weekly' ); ?>><?php esc_html_e( '7 Days', 'newkarma' ); ?></option>
			</select>
			<br/>
			<small><?php esc_html_e( 'Select popular by most view.', 'newkarma' ); ?></small>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_title_length' ) ); ?>"><?php esc_html_e( 'Maximum length of title', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_title_length' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_title_length' ) ); ?>" type="number" value="<?php echo esc_attr( $newkar_title_length ); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $newkar_hide_current_post ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_hide_current_post' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_hide_current_post' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_hide_current_post' ) ); ?>"><?php esc_html_e( 'Do not list the current post?', 'newkarma' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $newkar_show_categories ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_show_categories' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_show_categories' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_show_categories' ) ); ?>"><?php esc_html_e( 'Show Categories?', 'newkarma' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $newkar_show_view ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_show_view' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_show_view' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_show_view' ) ); ?>"><?php esc_html_e( 'Show View Count?', 'newkarma' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'bgcolor' ) ); ?>"><?php esc_html_e( 'Background Color', 'newkarma' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'bgcolor' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'bgcolor' ) ); ?>" type="text" value="<?php echo esc_attr( $bgcolor ); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'color_text' ) ); ?>"><?php esc_html_e( 'Text Color', 'newkarma' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'color_text' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'color_text' ) ); ?>" type="text" value="<?php echo esc_attr( $color_text ); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'color_link' ) ); ?>"><?php esc_html_e( 'Link Color', 'newkarma' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'color_link' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'color_link' ) ); ?>" type="text" value="<?php echo esc_attr( $color_link ); ?>" data-default-color="" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'color_meta' ) ); ?>"><?php esc_html_e( 'Meta Color', 'newkarma' ); ?></label><br />
			<input class="widefat color-picker" id="<?php echo esc_html( $this->get_field_id( 'color_meta' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'color_meta' ) ); ?>" type="text" value="<?php echo esc_attr( $color_meta ); ?>" data-default-color="" />
		</p>
		<?php
	}

	/**
	 * Return the array index of a given ID
	 *
	 * @since 1.0.0
	 * @param array $arr Array.
	 * @param int   $id Post ID.
	 * @access private
	 */
	private function get_cat_parent_index( $arr, $id ) {
		$len = count( $arr );
		if ( 0 === $len ) {
			return false;
		}
		$id = absint( $id );
		for ( $i = 0; $i < $len; $i++ ) {
			if ( $id === $arr[ $i ]['id'] ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Returns the assigned categories of a post in a string
	 *
	 * @access   private
	 * @since     1.0.0
	 * @param int $id Post ID.
	 */
	private function get_the_categories( $id ) {
		$terms = get_the_terms( $id, 'category' );

		if ( is_wp_error( $terms ) ) {
			return __( 'Error on listing categories', 'newkarma' );
		}

		if ( empty( $terms ) ) {
			return __( 'No categories', 'newkarma' );
		}

		$categories = array();

		foreach ( $terms as $term ) {
			$categories[] = $term->name;
		}

		$string  = __( 'In', 'newkarma' ) . ' ';
		$string .= join( ', ', $categories );

		return $string;
	}

	/**
	 * Returns the shortened post title, must use in a loop.
	 *
	 * @since 1.0.0
	 * @param int    $len Number text to display.
	 * @param string $more Text Button.
	 * @return string.
	 */
	private function get_the_trimmed_post_title( $len = 80, $more = '&hellip;' ) {

		// get current post's post_title.
		$post_title = get_the_title();

		// if post_title is longer than desired.
		if ( mb_strlen( $post_title ) > $len ) {
			// get post_title in desired length.
			$post_title = mb_substr( $post_title, 0, $len );
			// append ellipses.
			$post_title .= $more;
		}
		// return text.
		return $post_title;
	}

	/**
	 * Generate Cat id from Cat name
	 *
	 * @param String $cats Cat Name.
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @return array List of cat ids
	 */
	private function generate_cat_id_from_name( $cats ) {
		global $post;

		$cat_id_array = array();

		if ( ! empty( $cats ) ) {
			$cat_array = explode( ',', $cats );

			foreach ( $cat_array as $cat ) {
				$cat_id_array[] = $this->get_cat_ID( trim( $cat ) );
			}
		}

		return $cat_id_array;
	}

	/**
	 * Get cat id from cat name or slug
	 *
	 * @since 1.0.1
	 * @static
	 * @access public
	 *
	 * @param string $cat_name cat name or slug.
	 * @return int Term id. 0 if not found
	 */
	private function get_Cat_ID( $cat_name ) {
		// Try cat name first.
		$cat = get_term_by( 'name', $cat_name, 'category' );
		if ( $cat ) {
			return $cat->term_id;
		} else {
			// if cat name is not found, try cat slug.
			$cat = get_term_by( 'slug', $cat_name, 'category' );
			if ( $cat ) {
				return $cat->term_id;
			}
			return 0;
		}
	}

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Majalahpro_Mostview_Widget' );
	}
);
