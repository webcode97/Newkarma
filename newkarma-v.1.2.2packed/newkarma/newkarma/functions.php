<?php
/**
 * Newkarma functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newkarma
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'NEWKARMA_VER' ) ) {
	// Replace the version number of the theme on each release.
	define( 'NEWKARMA_VER', '1.2.2' );
}

/**
 * If using amp endpoint
 *
 * @since v.1.1.3
 */
function newkarma_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

if ( ! function_exists( 'gmr_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since v.1.0.0
	 */
	function gmr_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Newkarma, use a find and replace
		 * to change 'newkarma' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'newkarma', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Add hardcrop in medium and large image.
		add_image_size( 'idt-bigger-thumb', 550, 301, true );
		add_image_size( 'medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
		add_image_size( 'large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'video',
				'gallery',
			)
		);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'      => esc_html__( 'Primary', 'newkarma' ),
				'secondary'    => esc_html__( 'Secondary', 'newkarma' ),
				'topnav'       => esc_html__( 'Top Navigation', 'newkarma' ),
				'copyrightnav' => esc_html__( 'Copyright Navigation', 'newkarma' ),
				'mobilemenu'   => esc_html__( 'Scroll Mobile Menu', 'newkarma' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * RECOMMENDED: No reference to add_editor_style()
		 * Not usefull in theme, just pass theme checker plugin
		 */
		add_editor_style( 'editor-style.css' );

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'newkarma_custom_background_args',
				array(
					'default-color' => 'eeeeee',
					'default-image' => '',
				)
			)
		);

		add_theme_support(
			'amp',
			array(
				'paired'              => true,
				'template_dir'        => 'amp-templates',
				'templates_supported' => 'all',
				'nav_menu_dropdown'   => array(
					'sub_menu_button_class'        => 'dropdown-toggle',
					'sub_menu_button_toggle_class' => 'toggled-on',
					'expand_text '                 => __( 'expand', 'newkarma' ),
					'collapse_text'                => __( 'collapse', 'newkarma' ),
				),
			)
		);
		
		// Remove Gutenberg support in Widget for wp 5.8
		remove_theme_support( 'widgets-block-editor' );

	}
endif; // endif gmr_setup.
add_action( 'after_setup_theme', 'gmr_setup' );

if ( ! function_exists( 'gmr_width_size_image' ) ) :
	/**
	 * Improve performance, it's mean, only when switch theme this functions is active.
	 *
	 * @since v.1.0.2
	 */
	function gmr_width_size_image() {
		// Thumbnail Size Thumbnail.
		update_option( 'thumbnail_size_w', 90 );
		update_option( 'thumbnail_size_h', 90 );
		// force hard crop medium size thumbnail.
		update_option( 'thumbnail_crop', 1 );

		// Medium Size Thumbnail.
		update_option( 'medium_size_w', 150 );
		update_option( 'medium_size_h', 150 );
		// force hard crop medium size thumbnail.
		update_option( 'medium_crop', '1' );

		// Large Size Thumbnail.
		update_option( 'large_size_w', 300 );
		update_option( 'large_size_h', 178 );
		// force hard crop large size thumbnail.
		update_option( 'large_crop', '1' );
	}
endif; // endif gmr_width_size_image.
add_action( 'after_switch_theme', 'gmr_width_size_image' );

if ( ! function_exists( 'gmr_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @since v.1.0.0
	 *
	 * @global int $content_width
	 */
	function gmr_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'gmr_content_width', 1140 );
	}
endif; // endif gmr_content_width.
add_action( 'after_setup_theme', 'gmr_content_width', 0 );

if ( ! function_exists( 'gmr_widgets_init' ) ) :
	/**
	 * Register widget area.
	 *
	 * @since v.1.0.0
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function gmr_widgets_init() {
		// Sidebar right widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'newkarma' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Sidebar right in all pages and posts.', 'newkarma' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);
		// Sidebar left widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar left', 'newkarma' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'Sidebar left in archives and pages.', 'newkarma' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		// Sidebar left single widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar left post', 'newkarma' ),
				'id'            => 'sidebar-3',
				'description'   => esc_html__( 'Sidebar left in all single posts.', 'newkarma' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		// Module home after widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Module 1', 'newkarma' ),
				'id'            => 'module-after-1',
				'description'   => esc_html__( 'Module home after sixth post.', 'newkarma' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="homemodule-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		// Module home after widget areas.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Module 2', 'newkarma' ),
				'id'            => 'module-after-2',
				'description'   => esc_html__( 'Module home after ninth post.', 'newkarma' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="homemodule-title"><span>',
				'after_title'   => '</span></h3>',
			)
		);

		// Footer widget areas.
		// Footer widget areas.
		$mod = get_theme_mod( 'gmr_footer_column', '3col' );
		if ( '4col' === $mod ) {
			$number = 4;
		} elseif ( '3col' === $mod ) {
			$number = 3;
		} elseif ( '2col' === $mod ) {
			$number = 2;
		} else {
			$number = 1;
		}

		for ( $i = 1; $i <= $number; $i++ ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer ', 'newkarma' ) . $i,
					'id'            => 'footer-' . $i,
					'description'   => '',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title"><span>',
					'after_title'   => '</span></h3>',
				)
			);
		}

	}
endif; // endif gmr_widgets_init.
add_action( 'widgets_init', 'gmr_widgets_init' );

if ( ! function_exists( 'gmr_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function gmr_scripts() {
		// Font options.
		$fonts    = array(
			get_theme_mod( 'gmr_primary-font', customizer_library_get_default( 'gmr_primary-font' ) ),
			get_theme_mod( 'gmr_secondary-font', customizer_library_get_default( 'gmr_secondary-font' ) ),
		);
		$font_uri = customizer_library_get_google_font_uri( $fonts );

		// Load Google Fonts.
		wp_enqueue_style( 'newkarma-fonts', $font_uri, array(), NEWKARMA_VER, 'all' );

		// Call if only woocommerce actived.
		if ( class_exists( 'WooCommerce' ) ) {
			// Custom Woocommerce CSS.
			wp_enqueue_style( 'newkarma-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array(), NEWKARMA_VER );
		}

		if ( newkarma_is_amp() ) {
			wp_enqueue_style( 'newkarma-amp', get_template_directory_uri() . '/style-amp.css', array(), NEWKARMA_VER );
		} else {
			wp_enqueue_style( 'newkarma-nonamp', get_template_directory_uri() . '/style-nonamp.css', array(), NEWKARMA_VER );
		}

		// Add stylesheet.
		wp_enqueue_style( 'newkarma-style', get_stylesheet_uri(), array(), NEWKARMA_VER );

		if ( ! newkarma_is_amp() ) {
			// Sidr.
			wp_enqueue_script( 'newkarma-js-plugin', get_template_directory_uri() . '/js/js-plugin-min.js', array(), NEWKARMA_VER, true );
			
			$loadmore = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
			if ( ( 'gmr-infinite' === $loadmore ) || ( 'gmr-more' === $loadmore ) ) {
				wp_enqueue_script( 'newkarma-infscroll', get_template_directory_uri() . '/js/infinite-scroll.pkgd.min.js', array(), NEWKARMA_VER, true );
			}
			
			// Custom script.
			wp_enqueue_script( 'newkarma-customscript', get_template_directory_uri() . '/js/customscript.js', array(), NEWKARMA_VER, true );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		if ( newkarma_is_amp() ) {
			wp_deregister_script( 'jquery' );
		}

	}
endif; // endif gmr_scripts.
add_action( 'wp_enqueue_scripts', 'gmr_scripts' );

/**
 * Custom template tags for this theme.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom module.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/module.php';

/**
 * Customizer additions.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/customizer-library/customizer-library.php';
/* Custom options customizer */
require get_template_directory() . '/inc/customizer-library/gmrtheme-customizer.php';

/**
 * Load Jetpack compatibility file.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Call only if woocommerce actived
 *
 * @since v.1.0.0
 */
if ( class_exists( 'WooCommerce' ) ) {
	/**
	 * Load Woocommerce compatibility file.
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/woocommerce.php';
}

if ( class_exists( 'bbPress' ) ) {
	/**
	 * Load BBpress function
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/bbpress.php';
}

/**
 * Load All Widget
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/widgets/recent-posts-widget.php';
require get_template_directory() . '/inc/widgets/tab-widget.php';
require get_template_directory() . '/inc/widgets/tags-widget.php';
require get_template_directory() . '/inc/widgets/slider-widget.php';

/**
 * Class_exists on plugin working if using plugins_loaded filter
 * Most view widget exist if wp postview plugin installed
 */
if ( class_exists( 'WP_Widget_PostViews' ) ) {
	require get_template_directory() . '/inc/widgets/mostview-posts-widget.php';
}

if ( is_admin() ) {

	/**
	 * Add metabox to post or page
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/metabox.php';
	/**
	 * Include the TGM_Plugin_Activation class.
	 *
	 * Depending on your implementation, you may want to change the include call:
	 *
	 * Parent Theme:
	 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * Child Theme:
	 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * Plugin:
	 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * @since v.1.0.0
	 */
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

	add_action( 'tgmpa_register', 'newkarma_register_required_plugins' );

	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10
	 *
	 * @since v.1.0.0
	 */
	function newkarma_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// Include One Click Demo Import from the WordPress Plugin Repository.
			array(
				'name'     => 'One Click Demo Import',
				'slug'     => 'one-click-demo-import',
				'required' => true,
			),

			// This is an include a plugin bundled with a theme.
			array(
				'name'     => 'Newkarma Core', // The plugin name.
				'slug'     => 'newkarma-core', // The plugin slug (typically the folder name).
				'source'   => 'https://www.dropbox.com/s/3ykrb1j3upsok5c/newkarma-core.zip?dl=1', // The plugin source.
				'required' => true, // If false, the plugin is only 'recommended' instead of required.
			),

			// This is an include a plugin bundled with a theme.
			array(
				'name'     => 'Post View', // The plugin name.
				'slug'     => 'wp-postviews',
				'required' => true,
			),

			// This is an include a plugin bundled with a theme.
			array(
				'name'     => 'AMP', // The plugin name.
				'slug'     => 'amp',
				'required' => false,
			),

		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 */
		$config = array(
			'id'           => 'newkarma',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

	/**
	 * Call only if One Click Demo Import actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'OCDI_Plugin' ) ) {
		/**
		 * Load One Click Demo Import
		 *
		 * @since v.1.0.0
		 */
		require get_template_directory() . '/inc/importer.php';
	}
	/**
	 * Load Theme Update Checker.
	 *
	 * @since v.1.0.1
	 */
	require get_template_directory() . '/inc/theme-update-checker.php';
	/**
	 * Load BBpress function
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/dashboard.php';
}
