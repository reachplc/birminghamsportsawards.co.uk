<?php
/**
 * bpba functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tm-events-2016
 */

/**
 * Load functions files
 */
$function_includes = array(
	'functions/helper.php',						// Helper functions
	'functions/assets.php',						// Scripts and stylesheets
	'functions/template-tags.php',		// Custom template tags
	'functions/media.php',						// Updates to media files
);

foreach ( $function_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', 'tm-events-2016' ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

unset( $file, $filepath );


if ( ! function_exists( 'tm_events_2016_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function tm_events_2016_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on bpba, use a find and replace
		 * to change 'bpba' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'tm-events-2016', get_template_directory() . '/languages' );

		/**
		 * Let the end user add a custom logo via the WordPress admin
		 */
		add_theme_support( 'custom-logo' );

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
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'tm-events-2016' ),
			'social'  => __( 'Social Links Menu', 'tm-events-2016' ),
			'nominate'  => __( 'Nominate Menu', 'tm-events-2016' ),
			'events'  => __( 'Events Sites', 'tm-events-2016' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

	}
	endif;

	add_action( 'after_setup_theme', 'tm_events_2016_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tm_events_2016_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tm_events_2016_content_width', 640 );
}
add_action( 'after_setup_theme', 'tm_events_2016_content_width', 0 );

/**
 * Add custom query variable for failed logins.
 */

function add_query_vars_login( $vars ){
	$vars[] = 'status';
	return $vars;
}

add_filter( 'query_vars', 'add_query_vars_login' );

/**
 * Redirect failed login to referrer page
 */

function my_front_end_login_fail( $username ) {
	// Check if referer is present
	if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
		$referrer = esc_url( $_SERVER['HTTP_REFERER'] );
	}
	// if there's a valid referrer, and it's not the default log-in screen
	if ( ! empty( $referrer ) && ! strstr( $referrer,'wp-login' ) && ! strstr( $referrer,'wp-admin' ) ) {
		wp_redirect( esc_url_raw( add_query_arg( array( 'status' => 'failed' ), $referrer ) ) );
		exit;
	}
}

add_action( 'wp_login_failed', 'my_front_end_login_fail' );

/**
 * WP Admin login branding
 */
function admin_login_branding() { ?>
<style type="text/css">
body {
	background-color: rgb(18,130,197) !important;
	background-image: linear-gradient(to bottom, rgb(18,130,197) 0%, rgb(0,71,113) 100%) !important;
}
body.login div#login h1 a {
	width: 272px;
	height: 96px;
	background-image: url('<?php echo get_template_directory_uri() . '/gui/logo_wp-admin.png'; ?>');
  background-size: 100%;
}
.login #nav {
	color: rgb(255,255,255) !important;
}
.login #nav a,
.login #backtoblog a {
	color: rgb(255,255,255) !important;
}
</style>
<?php }

add_action( 'login_enqueue_scripts', 'admin_login_branding' );

/**
 * Set up Editor stylesheet
 */
function tm_events_2016_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}

add_action( 'admin_init', 'tm_events_2016_add_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
