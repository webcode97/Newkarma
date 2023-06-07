<?php
/**
 * Defines customizer options
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'newkarma_get_home' ) ) {
	/**
	 * Get homepage without http/https and www
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function newkarma_get_home() {
		$protocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
		return str_replace( $protocols, '', home_url() );
	}
}

/**
 * Option array customizer library
 *
 * @since 1.0.0
 */
function gmr_library_options_customizer() {

	// Prefix_option.
	$gmrprefix = 'gmr';

	/*
	 * Theme defaults
	 *
	 * @since v.1.0.0
	 */

	// General.
	$color_scheme        = '#20409a';
	$second_color_scheme = '#fe8917';

	// Header Default Options.
	$header_bgcolor     = '#ffffff';
	$sitetitle_color    = '#20409a';
	$menu_bgcolor       = '#20409a';
	$menu_color         = '#ffffff';
	$menu_hoverbgcolor  = '#20409a';
	$menu_hovercolor    = '#ffffff';
	$secondmenu_bgcolor = '#dcdcdc';
	$secondmenu_color   = '#444444';
	$sitedesc_color     = '#999999';
	$topnav_bgcolor     = '#ffffff';
	$topnav_color       = '#20409a';
	$topnav_hovercolor  = '#20409a';

	// Logo.
	$default_logo        = get_template_directory_uri() . '/images/logo.png';
	$default_logo_footer = get_template_directory_uri() . '/images/logo-footer.png';

	// Head line.
	$headline_bgcolor        = '#ff0000';
	$headline_linkcolor      = '#ffffff';
	$headline_hoverlinkcolor = '#cccccc';

	// Module.
	$module_bgcolor = '#20409a';
	$module_color_1 = '#ffffff';
	$module_color_2 = '#fed019';

	// Content.
	$content_bgcolor        = '#ffffff';
	$content_color          = '#323233';
	$content_linkcolor      = '#000000';
	$content_hoverlinkcolor = '#e54e2c';

	// Arhive content.
	$archive_bgcolor        = '#20409a';
	$archive_color          = '#ffffff';
	$archive_linkcolor      = '#fed019';
	$archive_hoverlinkcolor = '#ffffff';

	// Imge Link Color.
	$image_linkcolor      = '#ffffff';
	$image_hoverlinkcolor = '#ffff00';

	// Footer.
	$footer_bgcolor               = '#20409a';
	$footersocial_fontcolor       = '#ffffff';
	$footersocial_fontcolor_hover = '#999';
	$copyright_fontcolor          = '#ffffff';
	$copyright_linkcolor          = '#d7d7d7';
	$copyright_hoverlinkcolor     = '#999';
	
	// Add Lcs.
	$hm         = md5( newkarma_get_home() );
	$license    = trim( get_option( 'newkarma_core_license_key' . $hm ) );
	$upload_dir = wp_upload_dir();

	// Stores all the controls that will be added.
	$options = array();

	// Stores all the sections to be added.
	$sections = array();

	// Stores all the panels to be added.
	$panels = array();

	// Adds the sections to the $options array.
	$options['sections'] = $sections;

	/*
	 * General Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_general = 'panel-general';
	$panels[]      = array(
		'id'       => $panel_general,
		'title'    => __( 'General', 'newkarma' ),
		'priority' => '30',
	);

	// Colors.
	$section    = 'colors';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'General Colors', 'newkarma' ),
		'panel'    => $panel_general,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_scheme-color' ] = array(
		'id'      => $gmrprefix . '_scheme-color',
		'label'   => __( 'Base Color Scheme', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $color_scheme,
	);

	$options[ $gmrprefix . '_second-scheme-color' ] = array(
		'id'      => $gmrprefix . '_second-scheme-color',
		'label'   => __( 'Second Color Scheme', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $second_color_scheme,
	);

	$options[ $gmrprefix . '_content-bgcolor' ] = array(
		'id'       => $gmrprefix . '_content-bgcolor',
		'label'    => __( 'Background Color - Content', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_bgcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-color' ] = array(
		'id'       => $gmrprefix . '_content-color',
		'label'    => __( 'Font Color - Body', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_color,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-linkcolor' ] = array(
		'id'       => $gmrprefix . '_content-linkcolor',
		'label'    => __( 'Link Color - Body', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_linkcolor,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_content-hoverlinkcolor' ] = array(
		'id'       => $gmrprefix . '_content-hoverlinkcolor',
		'label'    => __( 'Hover Link Color - Body', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_hoverlinkcolor,
		'priority' => 60,
	);

	$options[ $gmrprefix . '_archive-bgcolor' ] = array(
		'id'       => $gmrprefix . '_archive-bgcolor',
		'label'    => __( 'Background Color - Archive', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $archive_bgcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_archive-color' ] = array(
		'id'       => $gmrprefix . '_archive-color',
		'label'    => __( 'Font Color - Archive', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $archive_color,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_archive-linkcolor' ] = array(
		'id'       => $gmrprefix . '_archive-linkcolor',
		'label'    => __( 'Link Color - Archive', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $archive_linkcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_archive-hoverlinkcolor' ] = array(
		'id'       => $gmrprefix . '_archive-hoverlinkcolor',
		'label'    => __( 'Hover Link Color - Archive', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $archive_hoverlinkcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_image-linkcolor' ] = array(
		'id'       => $gmrprefix . '_image-linkcolor',
		'label'    => __( 'Image Link Color', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $image_linkcolor,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_image-hoverlinkcolor' ] = array(
		'id'       => $gmrprefix . '_image-hoverlinkcolor',
		'label'    => __( 'Image Hover Link Color', 'newkarma' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $image_hoverlinkcolor,
		'priority' => 60,
	);

	$options[ $gmrprefix . '_chrome_mobile_color' ] = array(
		'id'      => $gmrprefix . '_chrome_mobile_color',
		'label'   => __( 'Color In Chrome Mobile', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => '',
	);

	// Colors.
	$section    = 'background_image';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Background Image', 'newkarma' ),
		'panel'       => $panel_general,
		'description' => __( 'Background Image only display, if using box layout.', 'newkarma' ),
		'priority'    => 45,
	);

	// Typography.
	$section      = 'typography';
	$font_choices = customizer_library_get_font_choices();
	$sections[]   = array(
		'id'       => $section,
		'title'    => __( 'Typography', 'newkarma' ),
		'panel'    => $panel_general,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_primary-font' ] = array(
		'id'      => $gmrprefix . '_primary-font',
		'label'   => __( 'Heading Font & URL', 'newkarma' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Montserrat',
	);

	$options[ $gmrprefix . '_secondary-font' ] = array(
		'id'      => $gmrprefix . '_secondary-font',
		'label'   => __( 'Body Font', 'newkarma' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => '',
	);

	$primaryweight = array(
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
	);

	$options[ $gmrprefix . '_body_size' ] = array(
		'id'          => $gmrprefix . '_body_size',
		'label'       => __( 'Body font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '14',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_single_size' ] = array(
		'id'          => $gmrprefix . '_single_size',
		'label'       => __( 'Single font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '16',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_secondary-font-weight' ] = array(
		'id'          => $gmrprefix . '_secondary-font-weight',
		'label'       => __( 'Body font weight', 'newkarma' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $primaryweight,
		'description' => __( 'Note: some font maybe not display properly, if not display properly try to change this font weight.', 'newkarma' ),
		'default'     => '500',
	);

	$options[ $gmrprefix . '_h1_size' ] = array(
		'id'          => $gmrprefix . '_h1_size',
		'label'       => __( 'h1 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '30',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h2_size' ] = array(
		'id'          => $gmrprefix . '_h2_size',
		'label'       => __( 'h2 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '26',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h3_size' ] = array(
		'id'          => $gmrprefix . '_h3_size',
		'label'       => __( 'h3 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '24',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h4_size' ] = array(
		'id'          => $gmrprefix . '_h4_size',
		'label'       => __( 'h4 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '22',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h5_size' ] = array(
		'id'          => $gmrprefix . '_h5_size',
		'label'       => __( 'h5 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '20',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_h6_size' ] = array(
		'id'          => $gmrprefix . '_h6_size',
		'label'       => __( 'h6 font size', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '18',
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	/*
	 * Header Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_header = 'panel-header';
	$panels[]     = array(
		'id'       => $panel_header,
		'title'    => __( 'Header', 'newkarma' ),
		'priority' => '40',
	);

	// Logo.
	$section    = 'title_tagline';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Site Identity', 'newkarma' ),
		'priority'    => 30,
		'panel'       => $panel_header,
		'description' => __( 'Allow you to add icon, logo, change site-title and tagline to your website.', 'newkarma' ),
	);

	$options[ $gmrprefix . '_logoimage' ] = array(
		'id'          => $gmrprefix . '_logoimage',
		'label'       => __( 'Logo', 'newkarma' ),
		'section'     => $section,
		'type'        => 'image',
		'default'     => $default_logo,
		'description' => __( 'If using logo, Site Title and Tagline automatic disappear.', 'newkarma' ),
	);

	$options[ $gmrprefix . '_logo_margintop' ] = array(
		'id'          => $gmrprefix . '_logo_margintop',
		'label'       => __( 'Logo Margin Top', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '0',
		'description' => '',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	);

	$section    = 'header_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Header Color', 'newkarma' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize header color style.', 'newkarma' ),
	);

	$options[ $gmrprefix . '_sitetitle-color' ] = array(
		'id'      => $gmrprefix . '_sitetitle-color',
		'label'   => __( 'Site title color', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitetitle_color,
	);

	$options[ $gmrprefix . '_sitedesc-color' ] = array(
		'id'      => $gmrprefix . '_sitedesc-color',
		'label'   => __( 'Site description color', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $sitedesc_color,
	);

	$options[ $gmrprefix . '_mainmenu-bgcolor' ] = array(
		'id'      => $gmrprefix . '_mainmenu-bgcolor',
		'label'   => __( 'Background Menu', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_bgcolor,
	);

	$options[ $gmrprefix . '_mainmenu-hoverbgcolor' ] = array(
		'id'      => $gmrprefix . '_mainmenu-hoverbgcolor',
		'label'   => __( 'Background Menu Hover and Active', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hoverbgcolor,
	);

	$options[ $gmrprefix . '_mainmenu-color' ] = array(
		'id'      => $gmrprefix . '_mainmenu-color',
		'label'   => __( 'Text color - Menu', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_color,
	);

	$options[ $gmrprefix . '_hovermenu-color' ] = array(
		'id'      => $gmrprefix . '_hovermenu-color',
		'label'   => __( 'Text hover color - Menu', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hovercolor,
	);

	$options[ $gmrprefix . '_secondmenu-bgcolor' ] = array(
		'id'      => $gmrprefix . '_secondmenu-bgcolor',
		'label'   => __( 'Background Second Menu', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_bgcolor,
	);

	$options[ $gmrprefix . '_secondmenu-color' ] = array(
		'id'      => $gmrprefix . '_secondmenu-color',
		'label'   => __( 'Text color - Second Menu', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_color,
	);

	$options[ $gmrprefix . '_topnav-bgcolor' ] = array(
		'id'      => $gmrprefix . '_topnav-bgcolor',
		'label'   => __( 'Background Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_bgcolor,
	);

	$options[ $gmrprefix . '_topnav-color' ] = array(
		'id'      => $gmrprefix . '_topnav-color',
		'label'   => __( 'Text color - Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_color,
	);

	$options[ $gmrprefix . '_hovertopnav-color' ] = array(
		'id'      => $gmrprefix . '_hovertopnav-color',
		'label'   => __( 'Text hover color - Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_hovercolor,
	);

	$section    = 'topnav';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Top Navigation', 'newkarma' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you add top navigation.', 'newkarma' ),
	);

	$sticky = array(
		'sticky'   => __( 'Sticky', 'newkarma' ),
		'nosticky' => __( 'Static', 'newkarma' ),
	);

	$options[ $gmrprefix . '_sticky_menu' ] = array(
		'id'      => $gmrprefix . '_sticky_menu',
		'label'   => __( 'Sticky Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $sticky,
		'default' => 'sticky',
	);

	$options[ $gmrprefix . '_active-searchbutton' ] = array(
		'id'      => $gmrprefix . '_active-searchbutton',
		'label'   => __( 'Disable search button in Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-date' ] = array(
		'id'      => $gmrprefix . '_active-date',
		'label'   => __( 'Disable date in Top Navigation', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	/*
	 * Homepage Section Options
	 *
	 * @since v.1.0.0
	 */

	/*
	* Headline
	*/
	$panel_homepage = 'panel-homepage';
	$panels[]       = array(
		'id'       => $panel_homepage,
		'title'    => __( 'Homepage', 'newkarma' ),
		'priority' => '45',
	);
	
	if ( ! empty( $upload_dir['basedir'] ) ) {
		$upldir = $upload_dir['basedir'] . '/' . $hm;

		if ( @file_exists( $upldir ) ) {
			$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
			if ( @file_exists( $fl ) ) {

				$section    = 'headline_carousel';
				$sections[] = array(
					'id'       => $section,
					'title'    => __( 'Headline Carousel', 'newkarma' ),
					'priority' => 50,
					'panel'    => $panel_homepage,
				);

				$options[ $gmrprefix . '_active-headline' ] = array(
					'id'      => $gmrprefix . '_active-headline',
					'label'   => __( 'Disable Headline Carousel In Homepage', 'newkarma' ),
					'section' => $section,
					'type'    => 'checkbox',
					'default' => 0,
				);

				$options[ $gmrprefix . '_active-headlinearchive' ] = array(
					'id'      => $gmrprefix . '_active-headlinearchive',
					'label'   => __( 'Disable Headline Carousel In Archive', 'newkarma' ),
					'section' => $section,
					'type'    => 'checkbox',
					'default' => 0,
				);

				$options[ $gmrprefix . '_category-headline' ] = array(
					'id'      => $gmrprefix . '_category-headline',
					'label'   => __( 'Select Headline Category', 'newkarma' ),
					'section' => $section,
					'type'    => 'category-select',
					'default' => '',
				);

				$options[ $gmrprefix . '_headline_number' ] = array(
					'id'          => $gmrprefix . '_headline_number',
					'label'       => __( 'Number Post Headlines', 'newkarma' ),
					'section'     => $section,
					'type'        => 'number',
					'default'     => '5',
					'input_attrs' => array(
						'min'  => 5,
						'max'  => 10,
						'step' => 1,
					),
				);

				$options[ $gmrprefix . '_textheadline' ] = array(
					'id'          => $gmrprefix . '_textheadline',
					'label'       => __( 'Headlines text', 'newkarma' ),
					'section'     => $section,
					'type'        => 'text',
					'description' => __( 'Add text headlines here. Default: Headlines.', 'newkarma' ),
				);

				$options[ $gmrprefix . '_headline-bgcolor' ] = array(
					'id'      => $gmrprefix . '_headline-bgcolor',
					'label'   => __( 'Headline Background Color', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $headline_bgcolor,
				);

				$options[ $gmrprefix . '_headline-linkcolor' ] = array(
					'id'      => $gmrprefix . '_headline-linkcolor',
					'label'   => __( 'Headline Link Color', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $headline_linkcolor,
				);

				$options[ $gmrprefix . '_headline-hoverlinkcolor' ] = array(
					'id'      => $gmrprefix . '_headline-hoverlinkcolor',
					'label'   => __( 'Headline Hover Link Color', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $headline_hoverlinkcolor,
				);

				/*
				* Module
				*/
				$section    = 'module';
				$sections[] = array(
					'id'       => $section,
					'title'    => __( 'Module Home', 'newkarma' ),
					'priority' => 50,
					'panel'    => $panel_homepage,
				);

				$options[ $gmrprefix . '_active-module-home' ] = array(
					'id'      => $gmrprefix . '_active-module-home',
					'label'   => __( 'Disable Module Home', 'newkarma' ),
					'section' => $section,
					'type'    => 'checkbox',
					'default' => 0,
				);

				$options[ $gmrprefix . '_module_number' ] = array(
					'id'          => $gmrprefix . '_module_number',
					'label'       => __( 'Number Post Module', 'newkarma' ),
					'section'     => $section,
					'type'        => 'number',
					'default'     => '3',
					'input_attrs' => array(
						'min'  => 3,
						'max'  => 10,
						'step' => 1,
					),
				);

				$options[ $gmrprefix . '_category-module-home' ] = array(
					'id'      => $gmrprefix . '_category-module-home',
					'label'   => __( 'Insert Category Name', 'newkarma' ),
					'section' => $section,
					'type'    => 'category-select',
					'default' => '',
				);

				$options[ $gmrprefix . '_textrelated' ] = array(
					'id'          => $gmrprefix . '_textrelated',
					'label'       => __( 'Related text', 'newkarma' ),
					'section'     => $section,
					'type'        => 'text',
					'description' => __( 'Add text related here. Default: Related News.', 'newkarma' ),
				);

				$options[ $gmrprefix . '_module-bgcolor' ] = array(
					'id'      => $gmrprefix . '_module-bgcolor',
					'label'   => __( 'Module Background Color', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $module_bgcolor,
				);

				$options[ $gmrprefix . '_module-color-1' ] = array(
					'id'      => $gmrprefix . '_module-color-1',
					'label'   => __( 'Module Color 1', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $module_color_1,
				);

				$options[ $gmrprefix . '_module-color-2' ] = array(
					'id'      => $gmrprefix . '_module-color-2',
					'label'   => __( 'Module Color 2', 'newkarma' ),
					'section' => $section,
					'type'    => 'color',
					'default' => $module_color_2,
				);

				/*
				* Module
				*/
				$section    = 'text_homepage';
				$sections[] = array(
					'id'       => $section,
					'title'    => __( 'Text News Feed Homepage', 'newkarma' ),
					'priority' => 50,
					'panel'    => $panel_homepage,
				);

				$options[ $gmrprefix . '_textnewsfeed' ] = array(
					'id'          => $gmrprefix . '_textnewsfeed',
					'label'       => __( 'Text news feed', 'newkarma' ),
					'section'     => $section,
					'type'        => 'text',
					'description' => __( 'Add text news feed here. Default: News Feed.', 'newkarma' ),
				);
			} else {
				$section                                   = 'HomepageLicense';
				$sections[]                                = array(
					'id'       => $section,
					'title'    => __( 'Insert License Key', 'newkarma' ),
					'priority' => 50,
					'panel'    => $panel_homepage,
				);
				$options[ $gmrprefix . '_licensekeyhome' ] = array(
					'id'          => $gmrprefix . '_licensekeyhome',
					'label'       => __( 'Insert License Key', 'newkarma' ),
					'section'     => $section,
					'type'        => 'content',
					'priority'    => 60,
					'description' => __( '<a href="plugins.php?page=newkarma-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'newkarma' ),
				);
			}
		} else {
			$section                                   = 'HomepageLicense';
			$sections[]                                = array(
				'id'       => $section,
				'title'    => __( 'Insert License Key', 'newkarma' ),
				'priority' => 50,
				'panel'    => $panel_homepage,
			);
			$options[ $gmrprefix . '_licensekeyhome' ] = array(
				'id'          => $gmrprefix . '_licensekeyhome',
				'label'       => __( 'Insert License Key', 'newkarma' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => 60,
				'description' => __( '<a href="plugins.php?page=newkarma-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'newkarma' ),
			);
		}
	}

	/*
	 * Blog Section Options
	 *
	 * @since v.1.0.0
	 */

	$panel_blog = 'panel-blog';
	$panels[]   = array(
		'id'       => $panel_blog,
		'title'    => __( 'Blog', 'newkarma' ),
		'priority' => '50',
	);

	$section    = 'bloglayout';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Layout', 'newkarma' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$sidebar = array(
		'sidebar'   => __( 'Sidebar', 'newkarma' ),
		'fullwidth' => __( 'Fullwidth', 'newkarma' ),
	);

	$options[ $gmrprefix . '_active-sticky-sidebar' ] = array(
		'id'      => $gmrprefix . '_active-sticky-sidebar',
		'label'   => __( 'Disable Sticky In Sidebar', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$blogpagination                             = array(
		'gmr-pagination' => __( 'Number Pagination', 'newkarma' ),
		'gmr-infinite'   => __( 'Infinite Scroll', 'newkarma' ),
		'gmr-more'       => __( 'Button Click', 'newkarma' ),
	);
	$options[ $gmrprefix . '_blog_pagination' ] = array(
		'id'      => $gmrprefix . '_blog_pagination',
		'label'   => __( 'Blog Navigation Type', 'newkarma' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $blogpagination,
		'default' => 'gmr-more',
	);

	$section    = 'blogcontent';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Content', 'newkarma' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$options[ $gmrprefix . '_active-blogthumb' ] = array(
		'id'      => $gmrprefix . '_active-blogthumb',
		'label'   => __( 'Disable Blog Thumbnail', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-singlethumb' ] = array(
		'id'      => $gmrprefix . '_active-singlethumb',
		'label'   => __( 'Disable Single Thumbnail', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-metasingle' ] = array(
		'id'      => $gmrprefix . '_active-metasingle',
		'label'   => __( 'Disable meta data in single', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-viewdata' ] = array(
		'id'      => $gmrprefix . '_active-viewdata',
		'label'   => __( 'Disable only view meta data in single, if you using wp postview', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-prevnext-post' ] = array(
		'id'      => $gmrprefix . '_active-prevnext-post',
		'label'   => __( 'Disable post navigation in single', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-excerptarchive' ] = array(
		'id'      => $gmrprefix . '_active-excerptarchive',
		'label'   => __( 'Disable Excerpt In Archives', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-socialshare' ] = array(
		'id'      => $gmrprefix . '_active-socialshare',
		'label'   => __( 'Disable Social Share In Single', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$excerpt = array(
		'excerpt'     => __( 'Excerpt', 'newkarma' ),
		'fullcontent' => __( 'Full Content', 'newkarma' ),
	);

	$options[ $gmrprefix . '_blog_content' ] = array(
		'id'      => $gmrprefix . '_blog_content',
		'label'   => __( 'Blog Content', 'newkarma' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $excerpt,
		'default' => 'excerpt',
	);

	$options[ $gmrprefix . '_excerpt_number' ] = array(
		'id'          => $gmrprefix . '_excerpt_number',
		'label'       => __( 'Excerpt length', 'newkarma' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '22',
		'description' => __( 'If you choose excerpt, you can change excerpt lenght (default is 30).', 'newkarma' ),
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
	);

	$options[ $gmrprefix . '_read_more' ] = array(
		'id'          => $gmrprefix . '_read_more',
		'label'       => __( 'Read more text', 'newkarma' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Add some text here to replace the default [...]. It will automatically be linked to your article.', 'newkarma' ),
		'priority'    => 90,
	);

	$section    = 'blogpopular';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Module Popular', 'newkarma' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$options[ $gmrprefix . '_active-modulepopular' ] = array(
		'id'      => $gmrprefix . '_active-modulepopular',
		'label'   => __( 'Disable Module Popular In Archives', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$popularrange = array(
		'alltime'       => 'alltime',
		'yearly'        => 'yearly',
		'secondmountly' => 'secondmountly',
		'mountly'       => 'mountly',
		'weekly'        => 'weekly',
	);

	$options[ $gmrprefix . '_module-populartime' ] = array(
		'id'          => $gmrprefix . '_module-populartime',
		'label'       => __( 'Popular range', 'newkarma' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $popularrange,
		'description' => __( 'Select popular range by most view. Note: Require is wp_postview plugin, if not install that plugin default is most comments.', 'newkarma' ),
		'default'     => 'alltime',
	);

	/*
	 * Footer Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_footer = 'panel-footer';
	$panels[]     = array(
		'id'       => $panel_footer,
		'title'    => __( 'Footer', 'newkarma' ),
		'priority' => '50',
	);

	$section    = 'widget_section';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Widgets Footer', 'newkarma' ),
		'priority'    => 50,
		'panel'       => $panel_footer,
		'description' => __( 'Footer widget columns.', 'newkarma' ),
	);

	$columns = array(
		'1col' => __( '1 Column', 'newkarma' ),
		'2col' => __( '2 Columns', 'newkarma' ),
		'3col' => __( '3 Columns', 'newkarma' ),
		'4col' => __( '4 Columns', 'newkarma' ),
	);

	$options[ $gmrprefix . '_footer_column' ] = array(
		'id'      => $gmrprefix . '_footer_column',
		'label'   => __( 'Widgets Footer', 'newkarma' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $columns,
		'default' => '3col',
	);

	$section    = 'social_section';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Social Footer', 'newkarma' ),
		'priority'    => 50,
		'panel'       => $panel_footer,
		'description' => __( 'Social Footer.', 'newkarma' ),
	);

	$options[ $gmrprefix . '_active-socialnetwork' ] = array(
		'id'      => $gmrprefix . '_active-socialnetwork',
		'label'   => __( 'Disable social in footer', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-footersocial' ] = array(
		'id'      => $gmrprefix . '_active-footersocial',
		'label'   => __( 'Disable social network in single', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-rssicon' ] = array(
		'id'      => $gmrprefix . '_active-rssicon',
		'label'   => __( 'Disable RSS icon in social', 'newkarma' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_fb_url_icon' ] = array(
		'id'          => $gmrprefix . '_fb_url_icon',
		'label'       => __( 'FB Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_twitter_url_icon' ] = array(
		'id'          => $gmrprefix . '_twitter_url_icon',
		'label'       => __( 'Twitter Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_pinterest_url_icon' ] = array(
		'id'          => $gmrprefix . '_pinterest_url_icon',
		'label'       => __( 'Pinterest Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_tumblr_url_icon' ] = array(
		'id'          => $gmrprefix . '_tumblr_url_icon',
		'label'       => __( 'Tumblr Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_stumbleupon_url_icon' ] = array(
		'id'          => $gmrprefix . '_stumbleupon_url_icon',
		'label'       => __( 'Stumbleupon Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_wordpress_url_icon' ] = array(
		'id'          => $gmrprefix . '_wordpress_url_icon',
		'label'       => __( 'Wordpress Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_instagram_url_icon' ] = array(
		'id'          => $gmrprefix . '_instagram_url_icon',
		'label'       => __( 'Instagram Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_dribbble_url_icon' ] = array(
		'id'          => $gmrprefix . '_dribbble_url_icon',
		'label'       => __( 'Dribbble Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_vimeo_url_icon' ] = array(
		'id'          => $gmrprefix . '_vimeo_url_icon',
		'label'       => __( 'Vimeo Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_linkedin_url_icon' ] = array(
		'id'          => $gmrprefix . '_linkedin_url_icon',
		'label'       => __( 'Linkedin Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_deviantart_url_icon' ] = array(
		'id'          => $gmrprefix . '_deviantart_url_icon',
		'label'       => __( 'Deviantart Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_myspace_url_icon' ] = array(
		'id'          => $gmrprefix . '_myspace_url_icon',
		'label'       => __( 'Myspace Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_skype_url_icon' ] = array(
		'id'          => $gmrprefix . '_skype_url_icon',
		'label'       => __( 'Skype Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_youtube_url_icon' ] = array(
		'id'          => $gmrprefix . '_youtube_url_icon',
		'label'       => __( 'Youtube Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_picassa_url_icon' ] = array(
		'id'          => $gmrprefix . '_picassa_url_icon',
		'label'       => __( 'Picassa Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_flickr_url_icon' ] = array(
		'id'          => $gmrprefix . '_flickr_url_icon',
		'label'       => __( 'Flickr Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_blogger_url_icon' ] = array(
		'id'          => $gmrprefix . '_blogger_url_icon',
		'label'       => __( 'Blogger Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_spotify_url_icon' ] = array(
		'id'          => $gmrprefix . '_spotify_url_icon',
		'label'       => __( 'Spotify Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_delicious_url_icon' ] = array(
		'id'          => $gmrprefix . '_delicious_url_icon',
		'label'       => __( 'Delicious Url', 'newkarma' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'newkarma' ),
		'priority'    => 90,
	);

	$section    = 'copyright_section';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Copyright & Footer Logo', 'newkarma' ),
		'priority' => 60,
		'panel'    => $panel_footer,
	);

	if ( ! empty( $upload_dir['basedir'] ) ) {
		$upldir = $upload_dir['basedir'] . '/' . $hm;

		if ( @file_exists( $upldir ) ) {
			$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
			if ( @file_exists( $fl ) ) {

				$options[ $gmrprefix . '_footer_logo' ] = array(
					'id'       => $gmrprefix . '_footer_logo',
					'label'    => __( 'Footer Logo', 'newkarma' ),
					'section'  => $section,
					'type'     => 'image',
					'priority' => 30,
					'default'  => $default_logo_footer,
				);

				$options[ $gmrprefix . '_copyright' ] = array(
					'id'          => $gmrprefix . '_copyright',
					'label'       => __( 'Footer Copyright.', 'newkarma' ),
					'section'     => $section,
					'type'        => 'textarea',
					'priority'    => 60,
					'description' => __( 'Display your own copyright text in footer.', 'newkarma' ),
				);
			} else {
				$options[ $gmrprefix . '_licensekeycopyright' ] = array(
					'id'          => $gmrprefix . '_licensekeycopyright',
					'label'       => __( 'Insert License Key', 'newkarma' ),
					'section'     => $section,
					'type'        => 'content',
					'priority'    => 60,
					'description' => __( '<a href="plugins.php?page=newkarma-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'newkarma' ),
				);
			}
		} else {
			$options[ $gmrprefix . '_licensekeycopyright' ] = array(
				'id'          => $gmrprefix . '_licensekeycopyright',
				'label'       => __( 'Insert License Key', 'newkarma' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => 60,
				'description' => __( '<a href="plugins.php?page=newkarma-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="http://member.kentooz.com/softsale/license" target="_blank">http://member.kentooz.com/softsale/license</a>', 'newkarma' ),
			);
		}
	}
	$section    = 'footer_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Footer Color', 'newkarma' ),
		'priority'    => 60,
		'panel'       => $panel_footer,
		'description' => __( 'Allow you customize footer color style.', 'newkarma' ),
	);

	$options[ $gmrprefix . '_footer-bgcolor' ] = array(
		'id'      => $gmrprefix . '_footer-bgcolor',
		'label'   => __( 'Background Color - Footer', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_bgcolor,
	);

	$options[ $gmrprefix . '_footersocial-fontcolor' ] = array(
		'id'      => $gmrprefix . '_footersocial-fontcolor',
		'label'   => __( 'Color - Social Footer', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footersocial_fontcolor,
	);

	$options[ $gmrprefix . '_footersocial-fontcolorhover' ] = array(
		'id'      => $gmrprefix . '_footersocial-fontcolorhover',
		'label'   => __( 'Hover Color - Social Footer', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footersocial_fontcolor_hover,
	);

	$options[ $gmrprefix . '_copyright-fontcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-fontcolor',
		'label'   => __( 'Font Color - Copyright', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_fontcolor,
	);

	$options[ $gmrprefix . '_copyright-linkcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-linkcolor',
		'label'   => __( 'Link Color - Copyright', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_linkcolor,
	);

	$options[ $gmrprefix . '_copyright-hoverlinkcolor' ] = array(
		'id'      => $gmrprefix . '_copyright-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Copyright', 'newkarma' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $copyright_hoverlinkcolor,
	);

	/*
	 * Call if only woocommerce actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'WooCommerce' ) ) {

		// Woocommerce options.
		$panel_woo = 'woocommerce';
		$panels[]  = array(
			'id'       => $panel_woo,
			'title'    => __( 'WooCommerce', 'newkarma' ),
			'priority' => '200',
		);

		$section    = 'woocommerce_layout';
		$sections[] = array(
			'id'       => $section,
			'title'    => __( 'Layout Settings', 'newkarma' ),
			'panel'    => $panel_woo,
			'priority' => 100,
		);

		$sidebar = array(
			'sidebar'   => __( 'Sidebar', 'newkarma' ),
			'fullwidth' => __( 'Fullwidth', 'newkarma' ),
		);

		$options[ $gmrprefix . '_wc_sidebar' ] = array(
			'id'      => $gmrprefix . '_wc_sidebar',
			'label'   => __( 'Woocommerce Sidebar', 'newkarma' ),
			'section' => $section,
			'type'    => 'radio',
			'choices' => $sidebar,
			'default' => 'sidebar',
		);

		$options[ $gmrprefix . '_active-cartbutton' ] = array(
			'id'      => $gmrprefix . '_active-cartbutton',
			'label'   => __( 'Remove Cart button from menu', 'newkarma' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);

	}

	// Adds the sections to the $options array.
	$options['sections'] = $sections;
	// Adds the panels to the $options array.
	$options['panels']  = $panels;
	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );
	// To delete custom mods use: customizer_library_remove_theme_mods();.
}
add_action( 'init', 'gmr_library_options_customizer' );

if ( ! function_exists( 'customizer_library_demo_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
	/**
	 * Process user options to generate CSS needed to implement the choices.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_build_styles() {
		/**
		 * Background Color
		 */
		$setting = 'gmr_content-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Color Scheme
		 */
		$setting = 'gmr_scheme-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1.entry-title',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'kbd',
						'a.button',
						'button',
						'.button',
						'button.button',
						'input[type="button"]',
						'input[type="reset"]',
						'input[type="submit"]',
						'.tagcloud a',
						'.tagcloud ul',
						'.prevnextpost-links a .prevnextpost',
						'.page-links .page-link-number',
						'.sidr',
						'#navigationamp',
						'.page-title',
						'.gmr_widget_content ul.gmr-tabs',
						'.index-page-numbers',
						'.widget-title',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);

			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'blockquote',
						'a.button',
						'button',
						'.button',
						'button.button',
						'input[type="button"]',
						'input[type="reset"]',
						'input[type="submit"]',
						'.gmr-theme div.sharedaddy h3.sd-title:before',
						'.gmr_widget_content ul.gmr-tabs li a',
						'.bypostauthor > .comment-body',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

			if ( class_exists( 'WooCommerce' ) ) {
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.woocommerce #respond input#submit',
							'.woocommerce a.button',
							'.woocommerce button.button',
							'.woocommerce input.button',
							'.woocommerce #respond input#submit.alt',
							'.woocommerce a.button.alt',
							'.woocommerce button.button.alt',
							'.woocommerce input.button.alt',
							'.woocommerce #respond input#submit:hover',
							'.woocommerce a.button:hover',
							'.woocommerce button.button:hover',
							'.woocommerce input.button:hover',
							'.woocommerce #respond input#submit:focus',
							'.woocommerce a.button:focus',
							'.woocommerce button.button:focus',
							'.woocommerce input.button:focus',
							'.woocommerce #respond input#submit:active',
							'.woocommerce a.button:active',
							'.woocommerce button.button:active',
							'.woocommerce input.button:active',
							'.woocommerce #respond input#submit.alt:hover',
							'.woocommerce a.button.alt:hover',
							'.woocommerce button.button.alt:hover',
							'.woocommerce input.button.alt:hover',
							'.woocommerce #respond input#submit.alt:focus',
							'.woocommerce a.button.alt:focus',
							'.woocommerce button.button.alt:focus',
							'.woocommerce input.button.alt:focus',
							'.woocommerce #respond input#submit.alt:active',
							'.woocommerce a.button.alt:active',
							'.woocommerce button.button.alt:active',
							'.woocommerce input.button.alt:active',
						),
						'declarations' => array(
							'background-color' => $color,
						),
					)
				);
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.woocommerce-products-header h1.page-title',
						),
						'declarations' => array(
							'color' => $color,
						),
					)
				);
			}
		}

		/**
		 * Second Color Scheme
		 */
		$setting = 'gmr_second-scheme-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-meta-topic a',
						'.newkarma-rp-widget .rp-number',
						'.gmr-owl-carousel .gmr-slide-topic a',
						'.tab-comment-number',
						'.gmr-module-slide-topic a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1.page-title',
						'h2.page-title',
						'h3.page-title',
						'.page-title span',
						'.gmr-menuwrap',
						'.widget-title span',
						'h3.homemodule-title span',
						'.gmr_widget_content ul.gmr-tabs li a.js-tabs__title-active',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-menuwrap #primary-menu > li > a:hover',
						'.gmr-menuwrap #primary-menu > li.page_item_has_children:hover > a',
						'.gmr-menuwrap #primary-menu > li.menu-item-has-children:hover > a',
						'.gmr-mainmenu #primary-menu > li:hover > a',
						'.gmr-mainmenu #primary-menu > .current-menu-item > a',
						'.gmr-mainmenu #primary-menu > .current-menu-ancestor > a',
						'.gmr-mainmenu #primary-menu > .current_page_item > a',
						'.gmr-mainmenu #primary-menu > .current_page_ancestor > a',
					),
					'declarations' => array(
						'-webkit-box-shadow' => 'inset 0px -5px 0px 0px' . $color,
						'-moz-box-shadow'    => 'inset 0px -5px 0px 0px' . $color,
						'box-shadow'         => 'inset 0px -5px 0px 0px' . $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-modulehome .gmr-cat-bg a',
						'.tab-content .newkarma-rp-widget .rp-number',
						'.owl-theme .owl-controls .owl-page.active span',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/**
		 * Link Color Body
		 */
		$setting = 'gmr_content-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'a',
						'.gmr-related-infinite .view-more-button',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-related-infinite .view-more-button',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-related-infinite .view-more-button:hover',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}
		$setting = 'gmr_content-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'a:hover',
						'a:focus',
						'a:active',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Site Title Color
		 */
		$setting = 'gmr_sitetitle-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-title a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Site Description Color
		 */
		$setting = 'gmr_sitedesc-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-description',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Body Size
		 */
		$setting = 'gmr_logo_margintop';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-logo',
					),
					'declarations' => array(
						'margin-top' => $size . 'px',
					),
				)
			);
		}

		/*
		 * Menu Background Color
		 */
		$setting = 'gmr_mainmenu-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-menuwrap',
						'.gmr-sticky .top-header.sticky-menu',
						'.gmr-mainmenu #primary-menu .sub-menu',
						'.gmr-mainmenu #primary-menu .children',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/*
		 * Menu Text Color
		 */
		$setting = 'gmr_mainmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-responsive-menu',
						'.gmr-mainmenu #primary-menu > li > a',
						'.gmr-mainmenu #primary-menu .sub-menu a',
						'.gmr-mainmenu #primary-menu .children a',
						'.sidr ul li ul li a',
						'.sidr ul li a',
						'#navigationamp ul li ul li a',
						'#navigationamp ul li a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li.menu-border > a span',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		/*
		 * Hover Menu text color
		 */
		$setting = 'gmr_hovermenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-responsive-menu:hover',
						'.gmr-mainmenu #primary-menu > li:hover > a',
						'.gmr-mainmenu #primary-menu .current-menu-item > a',
						'.gmr-mainmenu #primary-menu .current-menu-ancestor > a',
						'.gmr-mainmenu #primary-menu .current_page_item > a',
						'.gmr-mainmenu #primary-menu .current_page_ancestor > a',
						'.sidr ul li ul li a:hover',
						'.sidr ul li a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li.menu-border:hover > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-item > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current_page_item > a span',
						'.gmr-mainmenu #primary-menu > li.menu-border.current_page_ancestor > a span',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		/*
		 * Hover Menu Background Color
		 */
		$setting = 'gmr_mainmenu-hoverbgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-mainmenu #primary-menu > li:hover > a',
						'.gmr-mainmenu #primary-menu .current-menu-item > a',
						'.gmr-mainmenu #primary-menu .current-menu-ancestor > a',
						'.gmr-mainmenu #primary-menu .current_page_item > a',
						'.gmr-mainmenu #primary-menu .current_page_ancestor > a',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/*
		 * Second Menu Background Color
		 */
		$setting = 'gmr_secondmenu-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-secondmenuwrap',
						'.gmr-secondmenu #primary-menu .sub-menu',
						'.gmr-secondmenu #primary-menu .children',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/*
		 * Second Menu Color
		 */
		$setting = 'gmr_secondmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-secondmenu #primary-menu > li > a',
						'.gmr-secondmenu #primary-menu .sub-menu a',
						'.gmr-secondmenu #primary-menu .children a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

		}

		/*
		 * Top Nav Background Color
		 */
		$setting = 'gmr_topnav-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-topnavwrap',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/*
		 * Top Nav Color
		 */
		$setting = 'gmr_topnav-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-topnavresponsive-menu',
						'.gmr-topnavmenu #primary-menu > li > a',
						'.gmr-top-date',
						'.search-trigger .gmr-icon',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-topnavmenu #primary-menu > li.menu-border > a span',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		/*
		 * Top Nav Hover Color
		 */
		$setting = 'gmr_hovertopnav-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'#gmr-topnavresponsive-menu:hover',
						'.gmr-topnavmenu #primary-menu > li:hover > a',
						'.gmr-topnavmenu #primary-menu .current-menu-item > a',
						'.gmr-topnavmenu #primary-menu .current-menu-ancestor > a',
						'.gmr-topnavmenu #primary-menu .current_page_item > a',
						'.gmr-topnavmenu #primary-menu .current_page_ancestor > a',
						'.gmr-social-icon ul > li > a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);

			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-topnavmenu #primary-menu > li.menu-border:hover > a span',
						'.gmr-topnavmenu #primary-menu > li.menu-border.current-menu-item > a span',
						'.gmr-topnavmenu #primary-menu > li.menu-border.current-menu-ancestor > a span',
						'.gmr-topnavmenu #primary-menu > li.menu-border.current_page_item > a span',
						'.gmr-topnavmenu #primary-menu > li.menu-border.current_page_ancestor > a span',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);

		}

		/*
		 * Headline
		 */
		$setting = 'gmr_headline-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-element-carousel',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		$setting = 'gmr_headline-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-owl-carousel .gmr-slide-title a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}
		$setting = 'gmr_headline-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-owl-carousel .item:hover .gmr-slide-title a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Module
		 */
		$setting = 'gmr_module-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-modulehome',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}
		$setting = 'gmr_module-color-1';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-modulehome',
						'.gmr-modulehome a',
						'.gmr-modulehome .gmr-cat-bg a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-title-module-related',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
		}
		$setting = 'gmr_module-color-2';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-modulehome a:hover',
						'.gmr-title-module-related',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Content Background Color.
		$setting = 'gmr_content-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-single',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-related-infinite .view-more-button:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Archive Background Color
		 */
		$setting = 'gmr_archive-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive .view-more-button:hover',
						'ul.page-numbers li span.page-numbers',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Archive Color
		 */
		$setting = 'gmr_archive-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive',
						'a.read-more',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		/*
		 * Archive Link Color
		 */
		$setting = 'gmr_archive-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive h2.entry-title a',
						'.site-main-archive .view-more-button',
						'.site-main-archive .gmr-ajax-text',
						'ul.page-numbers li a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive .view-more-button',
						'ul.page-numbers li span.current',
						'ul.page-numbers li a',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive .view-more-button:hover',
						'ul.page-numbers li span.page-numbers',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		/*
		 * Archive Link Hover Color
		 */
		$setting = 'gmr_archive-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-main-archive .gmr-archive:hover h2.entry-title a',
						'ul.page-numbers li a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'ul.page-numbers li a:hover',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
		}

		/*
		 * Image Link Color
		 */
		$setting = 'gmr_image-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-focus-news.gmr-focus-gallery h2.entry-title a',
						'.gmr-widget-carousel .gmr-slide-title a',
						'.newkarma-rp-widget .gmr-rp-bigthumbnail .gmr-rp-bigthumb-content .title-bigthumb',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}
		$setting = 'gmr_image-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.gmr-focus-news.gmr-focus-gallery:hover h2.entry-title a',
						'.gmr-widget-carousel .item:hover .gmr-slide-title a',
						'.newkarma-rp-widget .gmr-rp-bigthumbnail:hover .gmr-rp-bigthumb-content .title-bigthumb',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Primary Font.
		$setting = 'gmr_primary-font';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$stack   = customizer_library_get_font_stack( $mod );
		if ( $mod ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1',
						'h2',
						'h3',
						'h4',
						'h5',
						'h6',
						'a',
						'.rsswidget',
						'.gmr-metacontent',
						'.gmr-ajax-text',
						'.view-more-button',
						'ul.single-social-icon li.social-text',
						'.page-links',
						'.gmr-top-date',
						'ul.page-numbers li',
					),
					'declarations' => array(
						'font-family' => $stack,
					),
				)
			);
		}

		// Secondary Font.
		$setting = 'gmr_secondary-font';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$stack   = customizer_library_get_font_stack( $mod );
		if ( $mod ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'font-family' => $stack,
					),
				)
			);
		}

		$setting = 'gmr_secondary-font-weight';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
						'.gmr-module-posts ul li',
					),
					'declarations' => array(
						'font-weight' => $size,
					),
				)
			);
		}

		// body size.
		$setting = 'gmr_body_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
						'.gmr-module-posts ul li',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// Single size.
		$setting = 'gmr_single_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.entry-content-single',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h1 size.
		$setting = 'gmr_h1_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h1',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h2 size.
		$setting = 'gmr_h2_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h2',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h3 size.
		$setting = 'gmr_h3_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h3',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h4 size.
		$setting = 'gmr_h4_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h4',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h5 size.
		$setting = 'gmr_h5_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h5',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// h6 size.
		$setting = 'gmr_h6_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'h6',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// Footer Background Color.
		$setting = 'gmr_footer-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer',
					),
					'declarations' => array(
						'background-color' => $color,
					),
				)
			);
		}

		// Footer Font Color.
		$setting = 'gmr_footersocial-fontcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'ul.footer-social-icon li a span',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'ul.footer-social-icon li a span',
						'.footer-content',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
		}

		$setting = 'gmr_footersocial-fontcolorhover';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'ul.footer-social-icon li a:hover span',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'ul.footer-social-icon li a:hover span',
					),
					'declarations' => array(
						'border-color' => $color,
					),
				)
			);
		}

		// Copyright Font Color.
		$setting = 'gmr_copyright-fontcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// Copyright Link Color.
		$setting = 'gmr_copyright-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer a',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}

		// copyright Hover Link Color.
		$setting = 'gmr_copyright-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-footer a:hover',
					),
					'declarations' => array(
						'color' => $color,
					),
				)
			);
		}
	}
endif; // endif gmr_library_customizer_build_styles.
add_action( 'customizer_library_styles', 'gmr_library_customizer_build_styles' );

if ( ! function_exists( 'customizer_library_demo_styles' ) ) :
	/**
	 * Generates the style tag and CSS needed for the theme options.
	 *
	 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
	 * It is organized this way to ensure there is only one "style" tag.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_styles() {
		do_action( 'customizer_library_styles' );
		// Echo the rules.
		$css = Customizer_Library_Styles()->build();
		if ( ! empty( $css ) ) {
			wp_add_inline_style( 'newkarma-style', $css );
		}
	}
endif; // endif gmr_library_customizer_styles.
add_action( 'wp_enqueue_scripts', 'gmr_library_customizer_styles' );

if ( ! function_exists( 'gmr_remove_customizer_register' ) ) :
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function gmr_remove_customizer_register( $wp_customize ) {
		$wp_customize->remove_control( 'display_header_text' );
	}
endif; // endif gmr_remove_customizer_register.
add_action( 'customize_register', 'gmr_remove_customizer_register' );
