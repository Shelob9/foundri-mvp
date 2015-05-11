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
	/**
	 * Action before foundri boots
	 *
	 * @since 0.0.1
	 */
	do_action( 'foundri_pre_boot' );
	include_once( dirname( __FILE__ ) . '/lib/vendor/autoload.php' );
	include_once( dirname( __FILE__ ) . '/lib/includes/functions.php' );
	include_once( dirname( __FILE__ ) . '/lib/includes/shortcodes.php' );

	/**
	 * Load classes
	 */
	new \foundri_mvp_lib\forms\load\form_load();


	/**
	 * Action after foundri boots
	 *
	 * @since 0.0.1
	 */
	do_action( 'foundri_post_boot' );



});
