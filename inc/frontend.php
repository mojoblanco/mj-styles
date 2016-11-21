<?php

// Prevent direct file access
if( ! defined( 'MJS_FILE' ) ) {
	die();
}

/**
 * Enqueue link to add CSS through PHP.
 */
add_action( 'wp_enqueue_scripts', function() {
    $url = home_url();

    if ( is_ssl() ) {
        $url = home_url('/', 'https');
    }

    wp_register_style( 'mjs_style', add_query_arg( [ 'mjs' => 1 ] ), $url );

    wp_enqueue_style('mjs_style');
}, 99 );

/**
 * If the query var is set, print the custom styles.
 */
add_action( 'plugins_loaded', function() {
    if( ! isset( $_GET['mjs'] ) || intval( $_GET['mjs'] ) !== 1 ) {
		return;
	}

	ob_start();
	header( 'Content-type: text/css' );
	$options     = get_option( 'mjs_settings' );
	$raw_content = isset( $options['mjs-content'] ) ? $options['mjs-content'] : '';
	$content     = wp_kses( $raw_content, array( '\'', '\"' ) );
	$content     = str_replace( '&gt;', '>', $content );
	echo $content; //xss okay
	die();
} );
