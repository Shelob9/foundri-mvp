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
						)
					),
					'permission_callback' => array( $this, 'permissions_check' )
				),

			)
		);

		register_rest_route( "{$root}/{$version}", '/ask', array(
				array(
					'methods'         => \WP_REST_Server::READABLE,
					'callback'        => array( $this->ask_cb_class, 'get_item' ),
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
					'callback'        => array( $this->ask_cb_class, 'delete_item' ),
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
	 * @return bool
	 */
	public function permissions_check() {
		return true;
	}

}
