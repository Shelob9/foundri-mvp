<?php
/**
 * API endpoints for communities
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\api\callbacks;


use foundri\lib\api\vars;

class community extends vars {

	/**
	 * Join a community
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function join( $request ) {
		$params = $request->get_params();
		$community = new \foundri\lib\data\community( $params[ 'id' ] );

		$id = $community->pods->add_to( 'members', get_current_user_id() );
		if ( $id > 0 ) {
			$response = new \WP_REST_Response( $id, 200, array() );
		}else{
			$response = new \WP_REST_Response( 0, 404, array() );
		}

		$response->set_matched_route(  $request->get_route() );

		return $response;
	}

}
