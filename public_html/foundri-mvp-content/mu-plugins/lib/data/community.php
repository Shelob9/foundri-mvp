<?php
/**
 * Get data for a community.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data;


use foundri\lib\forms\load\form_load;
use foundri\lib\forms\load\output;

class community extends get_item {

	/**
	 * The name of the Pod.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $pod_name = FOUNDRI_COMMUNITY;

	/**
	 * Array of fields to use to construct output.
	 *
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected $display_fields = array(
		'post_title' => array(),
		'post_content' => array(),
		'post_name'=> array(),
		'members' => array(
			'ID',
			'display_name',
		),
		'logo' => array(),
		'location' => array(),
	);



	/**
	 * Set up the extra fields we need, IE the HTML of the forms.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	protected function set_markup_fields() {
		$fields = array(
			'forms' => array(
				'ask_make' => output::ask_make(),
				'ask_search' => output::ask_search(),
				'login_form' => output::login_or_register()
			),

		);

		if ( ! foundri_is_member( $this->id ) ) {
			$fields[ 'join_button'] = foundri_join_community_link_markup( $this->id );
		}else{
			$fields[ 'join_button'] = '<span style="display:none;" id="is-already-member"></span>';
		}

		$fields[ 'home_button' ] = foundri_link_markup( 'home',
			__( 'Foundri Home', 'foundri' ),
			__( 'Back to Foundri Home', 'foundri' ),
			true
		);

		$fields[ 'home_link' ] = foundri_link_markup( 'home',
			__( 'Foundri', 'foundri' ),
			__( 'Back to Foundri Home', 'foundri' ),
			false
		);

		$fields[ 'foundri_logo' ] = trailingslashit( content_url() ) . '/mu-plugins/lib/templates/img/hammer-logo-trans.png';

		$fields[ 'comment_form' ] = $fields[ 'forms' ][ 'comment_form' ] = output::comment();

		return $fields;

	}

	/**
	 * Add a user to a community
	 *
	 * @param int $user_id
	 */
	public function join( $user_id ) {
		$this->pods->add_to( 'members', $user_id );
	}


}
