<?php
/**
 * Add controls for arbitrary heading, description, line
 *
 * @package Customizer_Library
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Class wrapper with useful methods for interacting with the theme customizer.
 */
class Customizer_Library_Content extends WP_Customize_Control {
	/**
	 * Whitelist content parameter.
	 *
	 * @var $content Content.
	 */
	public $content = '';

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function render_content() {

		switch ( $this->type ) {
			case 'content':
				if ( isset( $this->label ) ) {
					echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';
				}
				if ( isset( $this->content ) ) {
					echo $this->content; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */
				}
				if ( isset( $this->description ) ) {
					echo '<span class="description customize-control-description">' . $this->description . '</span>';
				}
				break;
		}

	}

}
