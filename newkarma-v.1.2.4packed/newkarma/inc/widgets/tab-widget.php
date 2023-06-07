<?php
/**
 * Widget API: Newkarma_Tab_Widget class
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
class Newkarma_Tab_Widget extends WP_Widget {
	/**
	 * Sets up a tabs widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'newkarma-widget-post',
			'description' => __( 'Tab most view and most comments widget.', 'newkarma' ),
		);
		parent::__construct( 'newkarma-ajaxtab', __( 'Tabs Posts(Newkarma)', 'newkarma' ), $widget_ops );

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

		extract( $args );
		extract( $instance );
		wp_enqueue_script( 'newkarma-ajax-tab' );

		// Base Id Widget.
		$newkar_widget_id = $this->id_base . '-' . $this->number;

		// Number Posts.
		$newkar_number_posts = ( ! empty( $instance['newkar_number_posts'] ) ) ? absint( $instance['newkar_number_posts'] ) : absint( 5 );
		// max 20 posts.
		if ( $newkar_number_posts > 20 || $newkar_number_posts < 1 ) {
			$newkar_number_posts = 5;
		}
		// Popular by date.
		$newkar_popular_date = ( ! empty( $instance['newkar_popular_date'] ) ) ? esc_attr( $instance['newkar_popular_date'] ) : esc_attr( 'alltime' );
		// Title Length.
		$newkar_title_length = ( ! empty( $instance['newkar_title_length'] ) ) ? absint( $instance['newkar_title_length'] ) : absint( 80 );
		// Show post date.
		$newkar_show_date = ( isset( $instance['newkar_show_date'] ) ) ? (bool) $instance['newkar_show_date'] : false;
		// Show post view.
		$newkar_show_view = ( isset( $instance['newkar_show_view'] ) ) ? (bool) $instance['newkar_show_view'] : false;

		if ( empty( $tabs ) ) {
			$tabs = array(
				'popular'  => 1,
				'comments' => 1,
			);
		}
		$tabs_count = count( $tabs );

		if ( $tabs_count <= 1 ) {
			$tabs_count = 1;
		} elseif ( $tabs_count > 3 ) {
			$tabs_count = 4;
		}

		$available_tabs = array(
			'popular'  => __( 'Popular', 'newkarma' ),
			'recent'   => __( 'Recents', 'newkarma' ),
			'comments' => __( 'Comments', 'newkarma' ),
		);
		
		wp_enqueue_script( 'newkarma-js-tab', get_template_directory_uri() . '/js/vanilla-js-tabs.js', array(), NEWKARMA_VER, true );
		wp_add_inline_script(
			'newkarma-js-tab',
			'(function() {
				"use strict";
				var tabs = new Tabs({
					elem: "' . esc_attr( $newkar_widget_id ) . '_content"
				});
			})();'
		);

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		?>
			<div class="gmr_widget_content" id="<?php echo esc_attr( $newkar_widget_id ); ?>_content">
				<ul class="gmr-tabs clearfix js-tabs__header">
				<?php
				$i = 0;
				foreach ( $available_tabs as $tab => $label ) {
					if ( ! empty( $tabs[ $tab ] ) ) : ?>
					<li class="tab_title"><a href="#" class="js-tabs__title" rel="nofollow"><?php echo esc_html( $label ); ?></a></li>
					<?php
					endif;
					$i++;
				}
				?>
				</ul> <!--end .tabs-->

				<div class="inside clearfix">
					<?php if ( ! empty( $tabs['popular'] ) ) : ?>
						<div id="popular-tab" class="tab-content js-tabs__content" style="display: none;">
							<?php
							$query_args = array(
								'ignore_sticky_posts'    => true,
								'posts_per_page'         => $newkar_number_posts,
								'post_status'            => 'publish',
								'no_found_rows'          => true,
								'post_status'            => 'publish',
								// make it fast withour update term cache and cache results.
								// https://thomasgriffin.io/optimize-wordpress-queries/.
								'update_post_term_cache' => false,
								'update_post_meta_cache' => false,
							);
							
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
							// run the query: get the latest posts.
							$popular = new WP_Query( apply_filters( 'majpro_tab_widget_popular_args', $query_args ) );
							?>
							<div class="newkarma-rp-widget clearfix">
								<div class="newkarma-rp">
									<ul>
										<?php
										$count = 0;
										while ( $popular->have_posts() ) :
											$popular->the_post();
											if ( has_post_thumbnail() ) {
												$class = 'has-post-thumbnail clearfix';
											} else {
												$class = 'clearfix';
											}
											$count++;
											?>
											<li class="<?php echo esc_html( $class ); ?>">
												<div class="rp-number pull-left"><?php echo esc_html( $count ); ?></div>
												<div class="gmr-rp-number-content">
													<a href="<?php the_permalink(); ?>" class="rp-title" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
														<?php
														if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
															echo esc_html( $post_title );
														} else {
															the_title();
														}
														?>
													</a>
													<div class="gmr-metacontent">
														<?php
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
						</div> <!--end #popular-tab-content-->
					<?php endif; ?>

					<?php if ( ! empty( $tabs['recent'] ) ) : ?>
						<div id="recent-tab" class="tab-content js-tabs__content" style="display: none;">
							<?php
							$query_args = array(
								'ignore_sticky_posts'    => true,
								'posts_per_page'         => $newkar_number_posts,
								'post_status'            => 'publish',
								'orderby'                => 'date',
								'order'                  => 'desc',
								'no_found_rows'          => true,
								'post_status'            => 'publish',
								// make it fast withour update term cache and cache results.
								// https://thomasgriffin.io/optimize-wordpress-queries/.
								'update_post_term_cache' => false,
								'update_post_meta_cache' => false,
							);
							// run the query: get the latest posts.
							$recents = new WP_Query( apply_filters( 'majpro_tab_widget_recents_args', $query_args ) );
							?>
							<div class="newkarma-rp-widget clearfix">
								<div class="newkarma-rp">
									<ul>
										<?php
										while ( $recents->have_posts() ) :
											$recents->the_post();
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
														echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
															array(
																'before' => __( 'Permalink to: ', 'newkarma' ),
																'after' => '',
																'echo' => false,
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
													<a href="<?php the_permalink(); ?>" class="rp-title" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
														<?php
														if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
															echo esc_html( $post_title );
														} else {
															the_title();
														}
														?>
													</a>
													<div class="gmr-metacontent">
														<?php
														if ( $newkar_show_date ) :
															echo get_the_date();
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
						</div> <!--end #recent-tab-content-->
					<?php endif; ?>

					<?php if ( ! empty( $tabs['comments'] ) ) : ?>
						<div id="comments-tab" class="tab-content js-tabs__content" style="display: none;">
							<?php
							$query_args = array(
								'ignore_sticky_posts'    => true,
								'posts_per_page'         => $newkar_number_posts,
								'post_status'            => 'publish',
								'orderby'                => 'comment_count',
								'order'                  => 'desc',
								'no_found_rows'          => true,
								'post_status'            => 'publish',
								// make it fast withour update term cache and cache results.
								// https://thomasgriffin.io/optimize-wordpress-queries/.
								'update_post_term_cache' => false,
								'update_post_meta_cache' => false,
							);
							// run the query: get the latest posts.
							$comments = new WP_Query( apply_filters( 'majpro_tab_widget_comments_args', $query_args ) );
							?>
							<div class="newkarma-rp-widget clearfix">
								<div class="newkarma-rp">
									<ul>
										<?php
										while ( $comments->have_posts() ) :
											$comments->the_post();
											?>
											<li class="clearfix">
												<div class="rp-number-comment text-center pull-left">
													<?php
													$num_comments = get_comments_number(); // get_comments_number returns only a numeric value.

													if ( comments_open() ) {
														if ( 0 === $num_comments ) {
															echo '<div class="tab-comment-number">0</div><div class="gmr-metacontent tab-meta-comment">' . esc_html__( 'Comment', 'newkarma' ) . '</div>';
														} elseif ( $num_comments > 1 ) {
															echo '<div class="tab-comment-number">' . esc_html( $num_comments ) . '</div><div class="gmr-metacontent tab-meta-comment">' . esc_html__( ' Comments', 'newkarma' ) . '</div>';
														} else {
															echo '<div class="tab-comment-number">1</div><div class="gmr-metacontent tab-meta-comment">' . esc_html__( 'Comment', 'newkarma' ) . '</div>';
														}
													}
													?>
												</div>
												<div class="gmr-rp-content-comments">
													<a href="<?php the_permalink(); ?>" class="rp-title" itemprop="url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'newkarma' ), 'after' => '' ) ); ?>">
														<?php
														if ( $post_title = $this->get_the_trimmed_post_title( $newkar_title_length ) ) {
															echo esc_html( $post_title );
														} else {
															the_title();
														}
														?>
													</a>
												</div>
											</li>
											<?php
										endwhile;
										wp_reset_postdata();
										?>
									</ul>
								</div>
							</div>
						</div> <!--end #comments-tab-content-->
					<?php endif; ?>
				</div> <!--end .inside -->
			</div><!--end #tabber -->
		<?php
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
				'newkar_number_posts' => 5,
				'newkar_title_length' => 80,
				'newkar_popular_date' => 'alltime',
				'newkar_show_view'    => false,
				'newkar_show_date'    => false,
			)
		);

		$instance['tabs'] = $new_instance['tabs'];
		// Number posts.
		$instance['newkar_number_posts'] = absint( $new_instance['newkar_number_posts'] );
		// Title Length.
		$instance['newkar_title_length'] = absint( $new_instance['newkar_title_length'] );
		// Popular range.
		$instance['newkar_popular_date'] = esc_attr( $new_instance['newkar_popular_date'] );
		$instance['newkar_show_view']    = (bool) $new_instance['newkar_show_view'];
		$instance['newkar_show_date']    = (bool) $new_instance['newkar_show_date'];

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
				'tabs'                => array(
					'recent'   => 0,
					'popular'  => 1,
					'comments' => 1,
				),
				'newkar_number_posts' => 5,
				'newkar_title_length' => 80,
				'newkar_popular_date' => 'alltime',
				'newkar_show_view'    => true,
				'newkar_show_date'    => true,
			)
		);
		// Number posts.
		$newkar_number_posts = absint( $instance['newkar_number_posts'] );
		// Title Length.
		$newkar_title_length = absint( $instance['newkar_title_length'] );
		// Popular range.
		$newkar_popular_date = esc_attr( $instance['newkar_popular_date'] );
		// Show element.
		$newkar_show_view  = $instance['newkar_show_view'];
		$newkar_show_date  = $instance['newkar_show_date'];

		extract( $instance );

		?>
		<p class="clearfix">
			<label class="alignleft" style="display: block; width: 50%; margin-bottom: 5px;" for="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_recent">
				<input type="checkbox" class="checkbox" id="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_recent" name="<?php echo esc_html( $this->get_field_name( 'tabs' ) ); ?>[recent]" value="1" <?php if ( isset( $tabs['recent'] ) ) { checked( 1, $tabs['recent'], true ); } ?> />
				<?php esc_html_e( 'Recent Tab', 'newkarma' ); ?>
			</label>
			<label class="alignleft" style="display: block; width: 50%; margin-bottom: 5px" for="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_popular">
				<input type="checkbox" class="checkbox" id="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_popular" name="<?php echo esc_html( $this->get_field_name( 'tabs' ) ); ?>[popular]" value="1" <?php if ( isset( $tabs['popular'] ) ) { checked( 1, $tabs['popular'], true ); } ?> />
				<?php esc_html_e( 'Popular Tab', 'newkarma' ); ?>
			</label>
			<label class="alignleft" style="display: block; width: 50%;" for="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_comments">
				<input type="checkbox" class="checkbox wpt_enable_comments" id="<?php echo esc_html( $this->get_field_id( 'tabs' ) ); ?>_comments" name="<?php echo esc_html( $this->get_field_name( 'tabs' ) ); ?>[comments]" value="1" <?php if ( isset( $tabs['comments'] ) ) { checked( 1, $tabs['comments'], true ); } ?> />
				<?php esc_html_e( 'Comments Tab', 'newkarma' ); ?>
			</label>
		</p>
		<p class="clear"></p>
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
			<input class="checkbox" type="checkbox" <?php checked( $newkar_show_view ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_show_view' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_show_view' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_show_view' ) ); ?>"><?php esc_html_e( 'Show View Count?', 'newkarma' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $newkar_show_date ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_show_date' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_show_date' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_show_date' ) ); ?>"><?php esc_html_e( 'Show Date In Recent Posts?', 'newkarma' ); ?></label>
		</p>
		<?php
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

}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Newkarma_Tab_Widget' );
	}
);
