<?php
/**
 * Customize for dropdown categories, extend the WP customizer
 *
 * @package Customizer_Library
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Class to Customize for dropdown categories, extend the WP customizer.
 */
class Customizer_Library_Categories extends WP_Customize_Control {
	/**
	 * Render the content of the category dropdown
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function render_content() {
		$dropdown = wp_dropdown_categories(
			array(
				'name'              => '_customize-dropdown-categories-' . $this->id,
				'echo'              => 0,
				'show_option_none'  => __( '&mdash; Select &mdash;', 'newkarma' ),
				'option_none_value' => '0',
				'selected'          => $this->value(),
			)
		);

		// Hackily add in the data link parameter.
		$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

		printf(
			'<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
			$this->label, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$dropdown // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
}
