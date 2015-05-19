<?php
/**
 * Loads the Foundri Lib
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Foundri
 */

// Useful global constants
define( 'FOUNDRI_MVP_VERSION', '0.1.0' );
define( 'FOUNDRI_ASK', 'ask' );
define( 'FOUNDRI_COMMUNITY', 'community' );
define( 'FOUNDDRI_VIEW_DIR', dirname( __FILE__ ) . '/lib/views/the-views/' );

/**
 * Boot Foundri
 */
add_action( 'init', function() {
	/**
	 * Action before foundri boots
	 *
	 * @since 0.0.1
	 */
	do_action( 'foundri_pre_boot' );

	include_once( dirname( __FILE__ ) . '/lib/vendor/autoload.php' );

	/**
	 * Include functions/shortcodes
	 */
	include_once( dirname( __FILE__ ) . '/lib/includes/functions.php' );
	include_once( dirname( __FILE__ ) . '/lib/includes/shortcodes.php' );

	/**
	 * Load Main class
	 */
	new \foundri\lib\foundri();

	/**
	 * Action after foundri boots
	 *
	 * @since 0.0.1
	 */
	do_action( 'foundri_post_boot' );

});
