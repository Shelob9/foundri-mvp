<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */

namespace foundri\lib\api;


use foundri\lib\views\view_loader;

class view_api {

	public static $nonce_field = 'foundri-view-api-nonce';

	public static $action_field = 'foundri-view-action';

	public static $endpoint = 'foundri-view-api';

	public static $nonce_action = 'foundri-view-api-nonce';

	/**
	 * Run API if possible
	 *
	 * @since 0.0.1
	 *
	 * @uses "template_redirect" action
	 */
	public static function do_api() {

		$action = $_REQUEST[ view_api::$endpoint ];


		if ( isset( $_GET[ self::$nonce_field ] ) && self::auth() ) {
			$code = 200;
			$response = self::route( $action );
		} else {
			$code     = 401;
			$response = __( 'Nonce invalid.', 'foundri' );
		}




		self::respond( $response, $code );

	}

	/**
	 * Check nonce

	 */
	protected static function auth( ) {
		$valid = wp_verify_nonce( $_GET[ self::$nonce_field ], self::$nonce_action );
		return $valid;

	}

	/**
	 * Route the data to the right callback.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param string $action The AJAX action we are processing.
	 *
	 * @return mixed
	 */
	protected static function route( $action ) {
		if( view_loader::allowed_view( $action ) ) {
			return view_loader::get_view( $action );
		}


	}

	/**
	 * Respond to request.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array|string $response The response message to send.
	 * @param bool|int $code Response code or bool. If is bool, response code will be 200 or 401
	 */
	protected static function respond( $response, $code ) {
		if ( true === $code ) {
			$code = 200;
		}

		if ( false == $code ) {
			$code = 401;
		}


		status_header( $code );
		nocache_headers();
		wp_die( $response );

	}

	/**
	 * Holds the instance of this class.
	 *
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Returns an instance of this class.
	 *
	 * @access public
	 *
	 * @return route|object
	 */
	public static function init() {

		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;

	}

}
