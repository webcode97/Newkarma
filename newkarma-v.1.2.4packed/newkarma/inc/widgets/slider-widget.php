<?php
/**
 * Widget API: Newkarma_SliderPost_Wgt class
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
 * Add the RPSL widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Newkarma_SliderPost_Wgt extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'newkarma-widget-slider',
			'description' => __( 'Recent posts using slider widget.', 'newkarma' ),
		);
		parent::__construct( 'newkarma-slider', __( 'Slider Posts (Newkarma)', 'newkarma' ), $widget_ops );

		// add action for admin_register_scripts.
		add_action( 'admin_footer-widgets.php', array( $this, 'admin_print_scripts' ), 9999 );
	}

	/**
	 * Print scripts.
	 *
	 * @since 1.0
	 */
	public function admin_print_scripts() {
		?>
		<script>
			function setSuggest_cat_recent(id) {
				jQuery('#' + id).suggest("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>?action=ajax-tag-search&tax=category", {multiple:true, multipleSep: ","});
			}
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

		wp_enqueue_script( 'newkarma-slider-widget' );

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
		// Excerpt Length.
		$newkar_number_posts = ( ! empty( $instance['newkar_number_posts'] ) ) ? absint( $instance['newkar_number_posts'] ) : absint( 5 );
		// Title Length.
		$newkar_title_length = ( ! empty( $instance['newkar_title_length'] ) ) ? absint( $instance['newkar_title_length'] ) : absint( 80 );
		// Style.
		$newkar_imagesize = ( ! empty( $instance['newkar_imagesize'] ) ) ? wp_strip_all_tags( $instance['newkar_imagesize'] ) : wp_strip_all_tags( 'big_image' );
		// Hide current post.
		$newkar_hide_current_post = ( isset( $instance['newkar_hide_current_post'] ) ) ? (bool) $instance['newkar_hide_current_post'] : false;
		$newkar_show_meta         = ( isset( $instance['newkar_show_meta'] ) ) ? (bool) $instance['newkar_show_meta'] : false;

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

		// set order of posts in widget.
		$query_args['orderby'] = 'date';
		$query_args['order']   = 'DESC';

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

		if ( 'small_image' === $newkar_imagesize ) {
			$image_size = 'large';
		} else {
			$image_size = 'idt-bigger-thumb';
		}
		
			wp_add_inline_script(
				'newkarma-js-plugin',
				'
(function( slider ) {
"use strict";
	var slider = tns({
		container: \'.' . esc_html( $newkar_widget_id ) . '\',
		loop: true,
		gutter: 0,
		edgePadding: 0,
		items: 3,
		swipeAngle: false,
		mouseDrag: true,
		nav: true,
		controls: false,
		autoplay: true,
		autoplayButtonOutput: false,
		responsive : {
			0 : {
				items : 1,
			},
			250 : {
				items : 1,
			},
			400 : {
				items : 1,
			},
			600 : {
				items : 1,
			},
			1000 : {
				items : 1,
			}
		}
	});
})( window.slider );
			  '
			);
		

		// run the query: get the latest posts.
		$rp = new WP_Query( apply_filters( 'newkar_rp_widget_posts_args', $query_args ) );

		?>

				<div class="gmr-widget-carousel owl-carousel owl-theme <?php echo esc_html( $newkar_widget_id ); ?>">
					<?php
					while ( $rp->have_posts() ) :
						$rp->the_post();
						?>
						<div class="item gmr-slider-content">
							<?php
							// look for featured image.
							if ( has_post_thumbnail() ) {
								echo '<div class="other-content-thumbnail">';
									echo '<a href="' . esc_url( get_permalink() ) . '" itemprop="url" title="' . the_title_attribute(
										array(
											'before' => __( 'Permalink to: ', 'newkarma' ),
											'after'  => '',
											'echo'   => false,
										)
									) . '" rel="bookmark">';
										the_post_thumbnail( $image_size );
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

							} // has_post_thumbnail
							?>
							<div class="gmr-slide-title">
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
									if ( $newkar_show_meta ) :
										echo '<span class="cat-links">';
											echo $this->get_the_categories( $rp->post->ID ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										echo '</span>';
										echo '<span class="posted-on">';
										echo '<span class="byline">|</span>';
											echo get_the_date();
										echo '</span>';
									endif;
									?>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
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
	 *                           Newkarma_SliderPost_Wgt::form().
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
				'newkar_number_posts'      => 5,
				'newkar_title_length'      => 80,
				'newkar_imagesize'         => 'big_image',
				'newkar_hide_current_post' => false,
				'newkar_show_meta'         => false,
			)
		);
		// Title.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		// URL.
		$instance['newkar_url'] = esc_url( $new_instance['newkar_url'] );
		// Category IDs.
		$instance['newkar_category'] = wp_strip_all_tags( $new_instance['newkar_category'] );
		// Image size.
		$instance['newkar_imagesize'] = wp_strip_all_tags( $new_instance['newkar_imagesize'] );
		// Number posts.
		$instance['newkar_number_posts'] = absint( $new_instance['newkar_number_posts'] );
		// Title Length.
		$instance['newkar_title_length'] = absint( $new_instance['newkar_title_length'] );
		// Hide current post.
		$instance['newkar_hide_current_post'] = (bool) $new_instance['newkar_hide_current_post'];
		// Show element.
		$instance['newkar_show_meta'] = (bool) $new_instance['newkar_show_meta'];

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
				'title'                    => 'Recent Post',
				'newkar_url'               => '',
				'newkar_category'          => '',
				'newkar_imagesize'         => 'big_image',
				'newkar_number_posts'      => 5,
				'newkar_title_length'      => 80,
				'newkar_hide_current_post' => false,
				'newkar_show_meta'         => false,
			)
		);
		// Title.
		$title = sanitize_text_field( $instance['title'] );
		// URL.
		$newkar_url = esc_url( $instance['newkar_url'] );
		// Category ID.
		$newkar_category = wp_strip_all_tags( $instance['newkar_category'] );
		// Image size.
		$newkar_imagesize = wp_strip_all_tags( $instance['newkar_imagesize'] );
		// Number posts.
		$newkar_number_posts = absint( $instance['newkar_number_posts'] );
		// Title Length.
		$newkar_title_length = absint( $instance['newkar_title_length'] );
		// Hide current post.
		$newkar_hide_current_post = (bool) $instance['newkar_hide_current_post'];
		// Show element.
		$newkar_show_meta = (bool) $instance['newkar_show_meta'];

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
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_imagesize' ) ); ?>"><?php esc_html_e( 'Thumbnail Size', 'newkarma' ); ?></label>
			<select class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_imagesize', 'newkarma' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_imagesize' ) ); ?>">
				<option value="big_image" <?php echo selected( $instance['newkar_imagesize'], 'big_image', false ); ?>><?php esc_html_e( 'Big Thumb 550px x 301px ( For Module Widget )', 'newkarma' ); ?></option>
				<option value="small_image" <?php echo selected( $instance['newkar_imagesize'], 'small_image', false ); ?>><?php esc_html_e( 'Small Thumb 300px x 178px ( For sidebar Widget )', 'newkarma' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_number_posts' ) ); ?>"><?php esc_html_e( 'Number post', 'newkarma' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'newkar_number_posts' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_number_posts' ) ); ?>" type="number" value="<?php echo esc_attr( $newkar_number_posts ); ?>" />
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
			<input class="checkbox" type="checkbox" <?php checked( $newkar_show_meta ); ?> id="<?php echo esc_html( $this->get_field_id( 'newkar_show_meta' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'newkar_show_meta' ) ); ?>" />
			<label for="<?php echo esc_html( $this->get_field_id( 'newkar_show_meta' ) ); ?>"><?php esc_html_e( 'Show Meta?', 'newkarma' ); ?></label>
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
		register_widget( 'Newkarma_SliderPost_Wgt' );
	}
);
