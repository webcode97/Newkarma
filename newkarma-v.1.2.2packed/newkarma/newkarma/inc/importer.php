<?php
/**
 * Importer plugin filter.
 *
 * @link https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'newkarma_ocdi_import_files' ) ) :
	/**
	 * Set one click import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return array
	 */
	function newkarma_ocdi_import_files() {

		$arr = array(
			array(
				'import_file_name'             => 'Demo Import Newkarma',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer.dat',
				'import_notice'                => __( 'Import demo from http://demo.idtheme.com/newkarma/.', 'newkarma' ),
			),
		);
		return $arr;
	}
endif;
add_filter( 'pt-ocdi/import_files', 'newkarma_ocdi_import_files' );

if ( ! function_exists( 'newkarma_ocdi_after_import' ) ) :
	/**
	 * Set action after import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 * @param array $selected_import selection importer data.
	 *
	 * @return void
	 */
	function newkarma_ocdi_after_import( $selected_import ) {

		if ( 'Demo Import Newkarma' === $selected_import['import_file_name'] ) {
			// Menus to Import and assign - you can remove or add as many as you want.
			$top_menu    = get_term_by( 'name', 'Top menus', 'nav_menu' );
			$second_menu = get_term_by( 'name', 'Second menus', 'nav_menu' );
			$third_menu  = get_term_by( 'name', 'Top nav', 'nav_menu' );
			$fourth_menu = get_term_by( 'name', 'Top nav', 'nav_menu' );

			set_theme_mod(
				'nav_menu_locations',
				array(
					'primary'      => $top_menu->term_id,
					'secondary'    => $second_menu->term_id,
					'topnav'       => $third_menu->term_id,
					'copyrightnav' => $fourth_menu->term_id,
				)
			);
		}

	}
endif;
add_action( 'pt-ocdi/after_import', 'newkarma_ocdi_after_import' );

if ( ! function_exists( 'newkarma_change_time_of_single_ajax_call' ) ) :
	/**
	 * Change ajax call timeout
	 *
	 * @link https://github.com/awesomemotive/one-click-demo-import/blob/master/docs/import-problems.md.
	 */
	function newkarma_change_time_of_single_ajax_call() {
		return 60;
	}
endif;
add_action( 'pt-ocdi/time_for_one_ajax_call', 'newkarma_change_time_of_single_ajax_call' );

// disable generation of smaller images (thumbnails) during the content import.
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// disable the branding notice.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
