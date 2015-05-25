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


use foundri\lib\data\save\ask;
use foundri\lib\data\save\bio_profile;
use foundri\lib\data\save\comment;

class process_forms {
	public function __construct() {
		add_action( 'caldera_forms_submit_complete', array( $this, 'route' ), 55 );
	}

	public function route( $form ) {
		if ( in_array( $form[ 'ID' ], array(
			'ask_make',
			'bio_profile',
			'comment'
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
				case 'comment' == $form_id :
					comment::make_save( $data );
					break;
				default :
					break;
			}


		}



	}


}
