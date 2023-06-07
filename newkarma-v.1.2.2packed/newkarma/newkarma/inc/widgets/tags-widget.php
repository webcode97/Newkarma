<?php
/**
 * Widget API: Newkarma_Tag_Widget class
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @package Newkarma Core
 * @subpackage Widgets
 * @since 1.0.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the Tag widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Newkarma_Tag_Widget extends WP_Widget {
	/**
	 * Sets up a Recent Posts widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'newkarma-tag-cloud',
			'description'                 => __( 'A cloud of your most used tags.', 'newkarma' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'newkarma_tag_cloud', __( 'Tag Cloud(Newkarma Core)', 'newkarma' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current Tag Cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Tag Cloud widget instance.
	 */
	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy( $instance );
		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' === $current_taxonomy ) {
				$title = __( 'Tags', 'newkarma' );
			} else {
				$tax   = get_taxonomy( $current_taxonomy );
				$title = $tax->labels->name;
			}
		}

		// Number tags.
		$newkar_number_tags = ( ! empty( $instance['newkar_number_tags'] ) ) ? absint( $instance['newkar_number_tags'] ) : absint( 10 );
		// Orderby.
		$newkar_orderby_tags = ( ! empty( $instance['newkar_orderby_tags'] ) ) ? wp_strip_all_tags( $instance['newkar_orderby_tags'] ) : wp_strip_all_tags( 'name' );
		// Format.
		$newkar_format_tags = ( ! empty( $instance['newkar_format_tags'] ) ) ? wp_strip_all_tags( $instance['newkar_format_tags'] ) : wp_strip_all_tags( 'flat' );

		/**
		 * Filters the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 1.0.0
		 * Added taxonomy drop-down.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $args Args used for the tag cloud widget.
		 */
		$tag_cloud = wp_tag_cloud(
			apply_filters(
				'widget_newkarma_tag_cloud_args',
				array(
					'taxonomy' => $current_taxonomy,
					'number'   => $newkar_number_tags,
					'format'   => $newkar_format_tags,
					'orderby'  => $newkar_orderby_tags,
					'echo'     => false,
				)
			)
		);

		if ( empty( $tag_cloud ) ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '<div class="tagcloud">';

			echo $tag_cloud; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo "</div>\n";
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Handles updating settings for the current Tag Cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array(
			'newkar_orderby_tags' => 'name',
			'newkar_format_tags'  => 'flat',
			'newkar_number_tags'  => 10,
		);
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['taxonomy'] = stripslashes( $new_instance['taxonomy'] );
		// Number tag.
		$instance['newkar_number_tags'] = absint( $new_instance['newkar_number_tags'] );
		// Orderby tag.
		$instance['newkar_orderby_tags'] = wp_strip_all_tags( $new_instance['newkar_orderby_tags'] );
		// Format tag.
		$instance['newkar_format_tags'] = wp_strip_all_tags( $new_instance['newkar_format_tags'] );
		return $instance;
	}

	/**
	 * Outputs the Tag Cloud widget settings form.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance          = wp_parse_args(
			(array) $instance,
			array(
				'newkar_orderby_tags' => 'name',
				'newkar_format_tags'  => 'flat',
				'newkar_number_tags'  => 10,
			)
		);
		$current_taxonomy  = $this->_get_current_taxonomy( $instance );
		$title_id          = $this->get_field_id( 'title' );
		$instance['title'] = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		// Number tags.
		$newkar_number_tags = absint( $instance['newkar_number_tags'] );
		// Orderby tags.
		$newkar_orderby_tags = wp_strip_all_tags( $instance['newkar_orderby_tags'] );
		// Format tags.
		$newkar_format_tags = wp_strip_all_tags( $instance['newkar_format_tags'] );

		echo '<p><label for="' . esc_html( $title_id ) . '">' . esc_html__( 'Title:', 'newkarma' ) . '</label>
			<input type="text" class="widefat" id="' . esc_html( $title_id ) . '" name="' . esc_html( $this->get_field_name( 'title', 'newkarma' ) ) . '" value="' . esc_html( $instance['title'] ) . '" />
		</p>';

		echo '<p>
			<label for="' . esc_html( $this->get_field_id( 'newkar_number_tags' ) ) . '">' . esc_html__( 'Number post', 'newkarma' ) . '</label>
			<input class="widefat" id="' . esc_html( $this->get_field_id( 'newkar_number_tags' ) ) . '" name="' . esc_html( $this->get_field_name( 'newkar_number_tags' ) ) . '" type="number" value="' . esc_attr( $newkar_number_tags ) . '" />
		</p>';

		echo '<p>
			<label for="' . esc_html( $this->get_field_id( 'newkar_orderby_tags' ) ) . '">' . esc_html__( 'Order By', 'newkarma' ) . '</label>
            <select class="widefat" id="' . esc_html( $this->get_field_id( 'newkar_orderby_tags', 'newkarma' ) ) . '" name="' . esc_html( $this->get_field_name( 'newkar_orderby_tags' ) ) . '">
				<option value="name" ' . selected( $instance['newkar_orderby_tags'], 'name', false ) . '>' . esc_html__( 'Name', 'newkarma' ) . '</option>
				<option value="count" ' . selected( $instance['newkar_orderby_tags'], 'count', false ) . '>' . esc_html__( 'Count', 'newkarma' ) . '</option>
            </select>
		</p>';

		echo '<p>
			<label for="' . esc_html( $this->get_field_id( 'newkar_format_tags' ) ) . '">' . esc_html__( 'Style', 'newkarma' ) . '</label>
            <select class="widefat" id="' . esc_html( $this->get_field_id( 'newkar_format_tags', 'newkarma' ) ) . '" name="' . esc_html( $this->get_field_name( 'newkar_format_tags' ) ) . '">
				<option value="flat" ' . selected( $instance['newkar_format_tags'], 'flat', false ) . '>' . esc_html__( 'Flat', 'newkarma' ) . '</option>
				<option value="list" ' . selected( $instance['newkar_format_tags'], 'list', false ) . '>' . esc_html__( 'List', 'newkarma' ) . '</option>
            </select>
		</p>';

		$taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'object' );
		$id         = $this->get_field_id( 'taxonomy' );
		$name       = $this->get_field_name( 'taxonomy' );
		$input      = '<input type="hidden" id="' . $id . '" name="' . $name . '" value="%s" />';

		switch ( count( $taxonomies ) ) {

			// No tag cloud supporting taxonomies found, display error message.
			case 0:
				echo '<p>' . esc_html__( 'The tag cloud will not be displayed since there are no taxonomies that support the tag cloud widget.', 'newkarma' ) . '</p>';
				printf( $input, '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				break;

			// Just a single tag cloud supporting taxonomy found, no need to display options.
			case 1:
				$keys     = array_keys( $taxonomies );
				$taxonomy = reset( $keys );
				printf( $input, esc_attr( $taxonomy ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				break;

			// More than one tag cloud supporting taxonomy found, display options.
			default:
				printf(
					'<p><label for="%1$s">%2$s</label>' .
					'<select class="widefat" id="%1$s" name="%3$s">',
					$id, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					esc_html__( 'Taxonomy:', 'newkarma' ),
					$name // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);

				foreach ( $taxonomies as $taxonomy => $tax ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $taxonomy ),
						selected( $taxonomy, $current_taxonomy, false ),
						$tax->labels->name // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					);
				}

				echo '</select></p>';
		}
	}

	/**
	 * Retrieves the taxonomy for the current Tag cloud widget instance.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 * @return string Name of the current taxonomy if set, otherwise 'post_tag'.
	 */
	public function _get_current_taxonomy( $instance ) {
		if ( ! empty( $instance['taxonomy'] ) && taxonomy_exists( $instance['taxonomy'] ) )
			return $instance['taxonomy'];

		return 'post_tag';
	}
}

add_action(
	'widgets_init',
	function() {
		register_widget( 'Newkarma_Tag_Widget' );
	}
);
