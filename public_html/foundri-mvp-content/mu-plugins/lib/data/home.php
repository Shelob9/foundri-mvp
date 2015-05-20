<?php
/**
 * Get data for front page.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib\data;


use foundri\lib\data\communities;
use foundri\lib\forms\load\output;

class home {

	/**
	 * The data to use on front end
	 *
	 * @since 0.0.1
	 *
	 * @var array
	 */
	public $display_data;

	/**
	 * Constructor for class
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$this->set_display_data();
	}

	/**
	 * Set display_data property
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 */
	protected function set_display_data() {
		$data = array(
			'public_communities' => array(),
			'users_communities' => array(),
		);

		$query = $this->query_public_communities();
		if( 0 < $query->pods->total() ) {
			$data[ 'public_communities' ] = $query->display_data;
		}

		if ( is_user_logged_in() ) {
			$query = $this->query_users_communities();
			if ( 0 < $query->pods->total() ) {
				$data['users_communities'] = $query->display_data;
			}
		}

		$data[ 'login_form' ] = output::login_or_register();
		$data[ 'profile_form' ] = output::bio_profile();


		$this->display_data = $data;

	}

	/**
	 * Get query class for public communities
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return \foundri\lib\data\communities
	 */
	protected function query_public_communities() {
		$params = array(
			'limit' => 10
		);
		return new communities( 0, false, $params  );
	}

	/**
	 * Get query class for all communities of current user.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return \foundri\lib\data\communities
	 */
	protected function query_users_communities(){
		$params = array(
			'limit' => 10,
			'user_id' => get_current_user_id(),
		);
		return new communities( 0, false, $params );

	}


}
