<?php
/**
 * Process forms
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\forms\process;


use calderawp\helpers\is;
use foundri\lib\data\community;
use foundri\lib\data\save\ask;
use foundri\lib\data\save\bio_profile;
use foundri\lib\data\save\comment;

class process_forms {

	/**
	 * Field of login/register form with the invite code in it
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $invite_code_field = 'invite_code';

	/**
	 * Name of GET var to store ID of community to add user to
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $add_to_com_var = 'foundri_id';

	/**
	 * Name of GET var signup nonce is stored in. Also used as the nonce action
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @var string
	 */
	protected $signup_nonce = 'foundri_signup_nonce';

	/**
	 * Constuctor for class
	 */
	public function __construct() {
		//proccess form submissions
		add_action( 'caldera_forms_submit_complete', array( $this, 'route' ), 55 );

		//invite code proccesor
		add_filter('caldera_forms_get_form_processors', function( $pr ) {
			$pr['foundri_invite'] = array(
				'name'				=>	"foundri_invite",
				'pre_processor'		=>	array( $this, 'invite_validate' ),
			);

			return $pr;

		});

		//on sign on, maybe add user to the community.
		add_action( 'wp_signon', function( $user_email ) {
			if ( isset ( $_GET[ $this->add_to_com_var ] ) && 0 < absint($_GET[ $this->add_to_com_var ]) ) {
				if (! isset( $_GET[ $this->signup_nonce ] ) && ! wp_verify_nonce( $_GET[ $this->signup_nonce ], $this->signup_nonce ) )  {
					return;
				}
				if ( filter_var( $user_email, FILTER_VALIDATE_EMAIL ) ) {
					$user = get_user_by( 'email', $user_email );
					if ( is_object( $user ) ) {
						$uid = $user->ID;
					}else{
						return;
					}
				}else{
					return;
				}

				if ( $uid ) {
					$community = new community( $_GET[ $this->add_to_com_var ] );
					$community->join( $uid ) ;
				}
			}
		}, 55);
		

	}

	/**
	 * Route form data to save cb
	 *
	 * @since 0.0.1
	 *
	 * @param $form
	 */
	public function route( $form ) {
		if ( in_array( $form[ 'ID' ], array(
			'ask_make',
			'bio_profile',
			'comment',
			'login_or_register'
		) ) ) {
			$data= array();
			foreach( $form[ 'fields' ] as $field_id => $field){
				$data[ $field['slug'] ] = \Caldera_Forms::get_field_data( $field_id, $form );
			}

			
			$form_id = $form[ 'ID' ];
			switch( $form_id ) {
				case 'ask_make' == $form_id :
					$embeded_post_id = absint( $_POST[ '_cf_cr_pst' ] );
					$data[ 'community' ] = $embeded_post_id;
					ask::make_save( $data );
					break;
				case 'bio_profile' == $form_id :
					$data[ 'profile_cf_entry_id' ] = \Caldera_Forms::get_field_data( '_entry_id', $form );
					bio_profile::make_save( $data );
					break;
				case 'xlogin_or_register' == $form_id :
					$data[ 'community' ] = null;
					if ( ! is_null( $community_id = pods_v_sanitized( $this->add_to_com_var ) ) ) {
						$data[ 'community' ] = $community_id;
					}
					bio_profile::make_save( $data );
					break;
				case 'comment' == $form_id :
					comment::make_save( $data );
					break;
				default :
					break;
			}


		}


	}

	/**
	 * Validate invite code
	 *
	 * Callback for "foundri_invite" processor
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $config Processor config
	 * @param array $form The form.
	 *
	 * @return array|bool True if valid. Array if error.
	 */
	public function invite_validate( $config, $form ) {
		$code = $this->get_invite_code( $config, $form );
		$code = trim( strtolower( $code ) );
		$codes = $this->codes();
		if ( $code && is_string( $code ) && array_key_exists( $code, $codes ) ) {
			$id = $codes[ $code ];
			$_GET[ $this->add_to_com_var ] = $id;
			$_GET[ $this->signup_nonce ] = wp_create_nonce( $this->signup_nonce );
			return true;
		}else{
			return array(
				'type'	=>	'error',
				'note'	=>	( __( 'Invalid invite code.', 'foundri' ) )
			);
		}

	}

	/**
	 * Array of code => community ID
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	protected function codes() {
		return array(
			'thinkfast' => 31,
			'kamila' => 33,
		);
	}

	/**
	 * Find invite code
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $config Processor config
	 * @param array $form The form.
	 *
	 * @return string|void Code or void if not found
	 */
	protected function get_invite_code( $config, $form ) {
		if ( isset( $form[ 'fields' ][ $this->invite_code_field ] ) ) {
			$invite_code = \Caldera_Forms::get_field_data( $this->invite_code_field, $form );
			return $invite_code;
		}

	}


}
