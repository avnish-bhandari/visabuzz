<?php
/**
 * Visabuz Blog Theme Functions
 *
 * @package Visabuz_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Theme setup functions
 */
function visabuz_blog_setup() {
    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable post thumbnails (featured images)
    add_theme_support( 'post-thumbnails' );

    // Set custom thumbnail sizes if needed
    set_post_thumbnail_size( 800, 600, true );

    // HTML5 semantic markup support
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Register primary navigation menu if needed
    register_nav_menus(
        array(
            'primary' => __( 'Primary Menu', 'visabuz-blog' ),
        )
    );
}
add_action( 'after_setup_theme', 'visabuz_blog_setup' );

/**
 * Enqueue scripts and styles
 */
function visabuz_blog_scripts() {
    // Google Fonts - Plus Jakarta Sans
    wp_enqueue_style(
        'visabuz-google-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Bootstrap 5.3.3 CSS
    wp_enqueue_style(
        'bootstrap-5',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Theme Main Stylesheet
    wp_enqueue_style(
        'visabuz-style',
        get_stylesheet_uri(),
        array( 'bootstrap-5', 'visabuz-google-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Bootstrap 5.3.3 JS Bundle
    wp_enqueue_script(
        'bootstrap-5-bundle',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

    // Theme Custom JS
    wp_enqueue_script(
        'visabuz-main-js',
        get_template_directory_uri() . '/assets/js/main.js',
        array( 'bootstrap-5-bundle' ),
        wp_get_theme()->get( 'Version' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'visabuz_blog_scripts' );

/**
 * Control custom excerpt length
 */
function visabuz_custom_excerpt_length( $length ) {
    return 18;
}
add_filter( 'excerpt_length', 'visabuz_custom_excerpt_length', 999 );

/**
 * Custom excerpt more string
 */
function visabuz_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'visabuz_excerpt_more' );
