<?php
/**
 * Create RESTful API for Foundri
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\api;


use foundri\lib\data\ask;
use foundri\lib\data\ask_query;

class endpoints extends vars {


	/**
	 * Register routes for the API
	 */
	public function register_routes() {
		$root = $this->api_root;
		$version = $this->version;
		register_rest_route( "{$root}/{$version}", '/asks', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this, 'get_items' ),
					'args'            => array(
						'community' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
						'ask_type' => array(
							'default' => 'talk',
						),
						'search' => array(
							'default' => 0,
							'sanitize_callback' => 'urldecode'
						),
						'page'  => array(
							'default' => 1,
							'sanitize_callback' => 'absint',
						)
					),
					'permission_callback' => array( $this, 'permissions_check' )
				),

			)
		);

		register_rest_route( "{$root}/{$version}", '/ask', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this, 'get_item' ),
					'args'            => array(
						'ask' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),

					),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);

		register_rest_route( "{$root}/{$version}", '/ask' . '/(?P<id>[\d]+)', array(
				array(
					'methods'         => \WP_REST_Server::DELETABLE,
					'callback'        => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);




	}

	/**
	 * Get asks via API
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function get_items( $request ) {
		$params = $request->get_params();
		$text_search = pods_v( 'search', $params );
		if ( $text_search ) {
			$text_search = urldecode( $text_search );
		}

		$type = pods_v( 'ask_type', $params );
		if ( ! in_array( $type, array_keys( foundri_ask_types() ) ) ) {
			$response = new \WP_REST_Response( '', 404, array() );
		}else{
			$id = pods_v( 'community', $params );

			$class_params = array(
				'ask_type'     => $type,
				'search_param' => $text_search,
				'page'         => $params[ 'page' ]
			);

			$query = new ask_query( $id, false, $class_params );
			if ( 0 < $query->pods->total() ) {
				$response = new \WP_REST_Response( $query->display_data, 200, array() );
			} else {
				$response = new \WP_REST_Response( '', 404, array() );
			}
		}

		$response->set_matched_route(  $request->get_route() );

		return $response;


	}

	/**
	 * Get a single ask via API
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function get_item( $request ) {
		$params = $request->get_params();
		if ( ! is_null( $id = pods_v('ask', $params ) ) && 0 < $id ) {
			$query = new ask( $id );
			if( is_object( $query->pods ) && is_array( $query->pods->row ) && $id == $query->pods->row[ 'id' ] ) {
				$response = new \WP_REST_Response( $query->display_data, 200, array() );
			}else {
				$response = new \WP_REST_Response( '', 404, array() );
			}
		}else{
			$response = new \WP_REST_Response( '', 404, array() );
		}

		$response->set_matched_route(  $request->get_route() );

		return $response;

	}

	/**
	 * Delete a single ask via API
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function delete_item( $request ) {
		$params   = $request->get_params();
		$response = new \WP_REST_Response( 0, 404, array() );
		if ( 0 < $params[ 'id' ] ) {
			$pods = pods( FOUNDRI_ASK, $params[ 'id' ] );

			$deleted = $pods->delete( $params[ 'id' ] );
			if ( $deleted ) {
				$response = new \WP_REST_Response( $params[ 'id' ], 200, array() );
			}

		}

		$response->set_matched_route(  $request->get_route() );

		return $response;

	}

	/**
	 * Permissions check
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public function permissions_check() {
		return true;
	}

}
