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

/**
 * Boot Foundri
 */
add_action( 'init', function() {
	include_once( dirname( __FILE__ ) . '/lib/vendor/autoload.php' );
	include_once( dirname( __FILE__ ) . '/lib/includes/functions.php' );
	include_once( dirname( __FILE__ ) . '/lib/includes/shortcodes.php' );
});
