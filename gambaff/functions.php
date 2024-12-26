<?php
//Translations
add_action( 'after_setup_theme', 'gambaff_load_theme_textdomain' );
function gambaff_load_theme_textdomain() {
    load_theme_textdomain( 'gambaff', get_template_directory() . '/languages' );
}

//Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'gambaff_enqueue_scripts_styles' );
function gambaff_enqueue_scripts_styles() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    //wp_enqueue_style( 'cf7-styles', get_template_directory_uri() . '/css/cf7.css', array(), '1.1', 'all' );
	//wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array(), '1.0.0', true ); 
}
add_action( 'admin_enqueue_scripts', 'gambaff_admin_enqueue_scripts_styles' );
function gambaff_admin_enqueue_scripts_styles() {
	wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/admin-style.css' );
    //wp_enqueue_style( 'cf7-styles', get_template_directory_uri() . '/css/cf7.css', array(), '1.1', 'all' );
	//wp_enqueue_script( 'countdown', get_template_directory_uri() . '/js/countdown.js', array(), '1.0.0', true ); 
}

//Redirect affiliate links
add_action('template_redirect', 'redirect_aff_links');


//Include files
require_once( __DIR__ . '/inc/auto-theme-update-github.php');
require_once( __DIR__ . '/inc/pagespeed.php');
require_once( __DIR__ . '/inc/custom-post-types.php');
require_once( __DIR__ . '/inc/get-operators.php');
require_once( __DIR__ . '/inc/admin-page.php');
require_once( __DIR__ . '/inc/chatgpt-operator-review.php');
require_once( __DIR__ . '/inc/update-operators.php');
require_once( __DIR__ . '/inc/frontend-shortcodes.php');
require_once( __DIR__ . '/inc/set-featured-image-from-url.php');
require_once( __DIR__ . '/inc/cloak-links.php');
require_once( __DIR__ . '/inc/generate-content.php');
require_once( __DIR__ . '/inc/generate-blog-content.php');
// require_once( __DIR__ . '/inc/default-pages.php');
require_once( __DIR__ . '/inc/create-htaccess.php');
require_once( __DIR__ . '/inc/js-to-footer.php');

?>