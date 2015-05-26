<?php
/**
 * This file loads up either local or production config, and then it loads the common elements for wp-config (application.php) then runs WordPress.
 */

/**
 * Set up constants for the basic paths
 */
define( 'WP_ROOT_DIR',  dirname( __FILE__ )  );
define( 'WP_WEBROOT_DIR',  WP_ROOT_DIR  );

/**
 * Define locations for configs
 */
$local_config = WP_ROOT_DIR . '/dev-config.php';
$prod_config = WP_ROOT_DIR . '/production-config.php';
$staging_config = WP_ROOT_DIR . '/staging-config.php';

/**
 * Load production-config.php if possible. If not, use local-config.
 */

//correct if production-config is above root
if ( ! file_exists( $prod_config ) ) {
	$prod_config = WP_ROOT_DIR . '/production-config.php';
}

//load staging-config?
if( file_exists( $staging_config ) ){
    define( 'WP_LOCAL_DEV', false );
    include( $staging_config );
}
//attempt to load production-config
elseif ( file_exists( $prod_config ) ) {
	define( 'WP_LOCAL_DEV', false );
	include( $prod_config );
}
//OK, local config then
elseif ( file_exists( $local_config ) ) {
	define( 'WP_LOCAL_DEV', true );
	include( $local_config  );
}
else {
	//@TODO include a static HTML fallback file before dying
	die( 'No config found:( Much saddness, very failure.' );
}

/**
 * Include the rest of our config
 */
require_once( dirname( __FILE__ ). '/application.php' );

/**
 * Load up WordPress
 */
require_once( ABSPATH . 'wp-settings.php');
