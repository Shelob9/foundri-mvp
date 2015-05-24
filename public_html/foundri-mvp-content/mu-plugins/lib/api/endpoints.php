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


use foundri\lib\api\callbacks\community;
use foundri\lib\data\ask;
use foundri\lib\data\ask_query;

class endpoints extends vars {

	protected $ask_cb_class;

	protected $community_cb_class;

	public function __construct() {
		$this->set_ask_cb_class();
		$this->set_community_cb_class();
	}

	protected function set_ask_cb_class() {
		$this->ask_cb_class = new \foundri\lib\api\callbacks\ask();
	}

	protected function set_community_cb_class() {
		$this->community_cb_class = new community();
	}

	/**
	 * Register routes for the API
	 */
	public function register_routes() {
		$root = $this->api_root;
		$version = $this->version;

		/**
		 * Get Asks
		 */
		register_rest_route( "{$root}/{$version}", '/asks', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this->ask_cb_class, 'get_items' ),
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
						),
						$this->nonce_field => array(
							'default' => 0,
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
					),
					'permission_callback' => array( $this, 'permissions_check' )
				),

			)
		);

		/**
		 * Get a single Ask
		 */
		register_rest_route( "{$root}/{$version}", '/ask', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this->ask_cb_class, 'get_item' ),
					'args'            => array(
						'ask' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
						$this->nonce_field => array(
							'default' => 0
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),

					),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);

		/**
		 * Delete a single ask
		 */
		register_rest_route( "{$root}/{$version}", '/ask' . '/(?P<id>[\d]+)', array(
				array(
					'methods'         => \WP_REST_Server::DELETABLE,
					'callback'        => array( $this->ask_cb_class, 'delete_item' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'            => array(
						$this->nonce_field => array(
							'default' => 0,
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
					)
				),
			)
		);

		/**
		 * Get communities
		 *
		 * @todo implement
		 */
		register_rest_route( "{$root}/{$version}", '/communities', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this, 'not_implemented' ),
					'args'            => array(
						'id' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
						$this->nonce_field => array(
							'default' => 0,
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),

					),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);

		/**
		 * Get a single community
		 */
		register_rest_route( "{$root}/{$version}", '/community', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this, 'not_implemented' ),
					'args'            => array(
						'id' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
						$this->nonce_field => array(
							'default' => 0,
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),

					),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);

		/**
		 * Delete a single community
		 */
		register_rest_route( "{$root}/{$version}", '/community' . '/(?P<id>[\d]+)', array(
				array(
					'methods'         => \WP_REST_Server::DELETABLE,
					'callback'        => array( $this, 'not_implemented' ),
					'permission_callback' => array( $this, 'permissions_check' ),
					'args'            => array(
						$this->nonce_field => array(
							'default' => 0,
						)
					),
					'uid'  => array(
						'default' => 0,
						'sanitize_callback' => 'absint',
					),
				),
			)
		);

		/**
		 * Join a community
		 */
		register_rest_route( "{$root}/{$version}", '/community' . '/(?P<id>[\d]+)/join', array(
				array(
					'methods'         => \WP_REST_Server::EDITABLE,
					'callback'        => array( $this->community_cb_class, 'join' ),
					'args'            => array(
						'id' => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),
						$this->nonce_field => array(
							'default' => 0,
						),
						'uid'  => array(
							'default' => 0,
							'sanitize_callback' => 'absint',
						),

					),
					'permission_callback' => array( $this, 'permissions_check' )
				),
			)
		);




	}


	/**
	 * Permissions check
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return bool
	 */
	public function permissions_check( $request ) {

		$params = $request->get_params();

		$nonce = $params[ $this->nonce_field ];

		/**
		 * This is a hack to make shit work for now.
		 *
		 * Must get replaced once we have oAuth
		 */
		$ref = wp_get_referer();
		$ref = parse_url( $ref );
		$foundri = parse_url( home_url() );
		if ( $ref[ 'host'] != $foundri[ 'host'] ) {
			return false;
		}

		$this->uid = $params[ 'uid' ];
		add_filter( 'nonce_user_logged_out', function(){
			if ( 0 == $this->uid ) {
				return 100000000000;
			}

			return $this->uid;
		});

		$verified = wp_verify_nonce( $nonce, $this->nonce_action );

		return $verified;
	}

	/**
	 * Helper for unimplemented endpoints.
	 *
	 * @since 0.0.1
	 *
	 * @param \WP_REST_Request $request Full details about the request
	 *
	 * @return \WP_HTTP_Response
	 */
	public function not_implemented( $request ) {

		$response = new \WP_REST_Response( __( 'API Endpoint not yet implemented.', 'foundri' ), 501, array() );
		$response->set_matched_route(  $request->get_route() );

		return $response;
	}

}
