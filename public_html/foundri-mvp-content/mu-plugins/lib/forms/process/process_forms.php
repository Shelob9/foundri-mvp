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

class process_forms {
	public function __construct() {
		add_action( 'caldera_forms_submit_complete', array( $this, 'route' ), 55 );
	}

	public function route( $form ) {
		$data= array();
		foreach( $form[ 'fields' ] as $field_id => $field){
			$data[ $field['slug'] ] = \Caldera_Forms::get_field_data( $field_id, $form );
		}

		$embeded_post_id = absint( $_POST[ '_cf_cr_pst' ] );


		$form = strip_tags( $_POST[ '_cf_frm_id' ] );
		if ( in_array( $form, array(
			'ask_make'
		) ) ) {
			$data[ 'community' ] = $embeded_post_id;
			ask::make_save( $data );
		}


	}


}
