<?php
/**
 * Load Views
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib\templates;


use foundri\lib\api\view_api;

class loader {

	/**
	 * Allowed views
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected static $views = array(
		'home',
		'community-single',
		'community-preview',
		'ask-single',
		'ask-preview',
		'comment-single',
	);

	/**
	 * Check if a view is allowed
	 *
	 * @since 0.0.1
	 *
	 * @param string $view Name of view to check
	 *
	 * @return bool
	 */
	public static function allowed_view( $view ) {
		if ( in_array( $view, self::$views ) ) {
			return true;

		}

	}

	/**
	 * Get view data and render it.
	 *
	 * @since 0.0.1
	 *
	 * @param null $view
	 *
	 * @return null|string|\WP_Error
	 */
	public static function get_view( $view = null ) {
		if ( is_null( $view ) || ! self::allowed_view( $view ) ) {
			if ( ! self::is_view_api() ) {
				$query = get_queried_object();
				$id = get_queried_object_id();
				if ( FOUNDRI_COMMUNITY == get_post_type( $id ) ) {
					if ( ! is_null( $ask = pods_v_sanitized( 'ask' ) ) && 0 < absint( $ask ) ) {
						$view = 'ask-single';
						//$data = new \foundri\lib\data\asks( $id, true );
					}else {
						$view = 'community-single';
						//$data = new \foundri\lib\data\community( $id, true );
					}

				}

				if ( is_null( $query ) || 0 == $id ) {
					$view = 'home';
				}

			}

		}else{
			$id = pods_v_sanitized( 'id' );
		}

		if ( ! $view || ! self::allowed_view( $view ) ) {
			return new \WP_Error( 'bad-view' );
		}


		$template = $view . '.html';

		switch( $view ) {
			case 'community-single' == $view :
				$data = new \foundri\lib\data\community( $id, true );
				break;
			case 'ask-single' == $view :
				$data = new \foundri\lib\data\asks( $id, true );
				break;
			case 'home' == $view :
				$data = new \foundri\lib\data\home();
				break;
		}

		if ( $data->display_data ) {
			$data    = $data->display_data;
		}else{
			return new \WP_Error( 'bad-view' );
		}

		$template = FOUNDRI_TEMPLATE_DIR . $template;

		if ( file_exists( $template ) ) {
			$output = caldera_metaplate_from_file( $template, null, $data );

			return $output;
		}

	}

	/**
	 * Check if the view API is in use.
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public static function is_view_api() {
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], view_api::$endpoint ) && isset( $_REQUEST[ view_api::$endpoint ] ) ) {
			return true;
		}

	}

}
