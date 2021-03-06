<?php
/**
 * Callbacks for ask API endpoints
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib\api\callbacks;


use foundri\lib\api\vars;
use foundri\lib\data\ask_query;
use foundri\lib\data\comments;

class ask extends vars {

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


		if ( ! in_array( $params[ 'ask_type' ], array_keys( foundri_ask_types() ) ) ) {
			$response = new \WP_REST_Response( '', 404, array() );
		}else{
			$id = pods_v( 'community', $params );

			$class_params = array(
				'ask_type'     => $params[ 'ask_type' ],
				'page'         => $params[ 'page' ]
			);

			if ( $params[ 'text' ] ) {
				$class_params[ 'search_param' ] = $params[ 'text' ];
			}

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
			$query = new \foundri\lib\data\ask(  $id );
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
	 * Get comments for this ask
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function get_comments( $request ) {
		$params = $request->get_params();
		if (  0 != $params[ 'community'] ) {


			$query = new comments( $params[ 'community' ], $params[ 'ask' ] );

			if ( ! empty( $query->display_data ) ) {
				$response = new \WP_REST_Response( $query->display_data, 200, array() );
			} else {
				$response = new \WP_REST_Response( '', 204, array() );
			}

		}else{
			$response = new \WP_REST_Response( '', 404, array() );
		}

		$response->set_matched_route(  $request->get_route() );

		return $response;

	}

}
