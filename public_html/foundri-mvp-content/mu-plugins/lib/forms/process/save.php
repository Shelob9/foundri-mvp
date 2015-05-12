<?php
/**
 * Save data from form.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri_mvp_lib\forms\process;


use foundri_mvp_lib\forms\form;

class save extends form{

	/**
	 * Save data from a form.
	 *
	 * @param array $form Form submission.
	 *
	 * @return int|void ID of saved item or void on failure.
	 */
	public static function  update( $form ) {
		$name = $something = "";//?

		if ( parent::form_allowed( $name ) ) {
			$id = null;
			if ( $form[ 'something' ] ) {
				$id = $form[ 'something' ];
			}

			$pods = parent::pods_object( self::which_pod( $form ), $id );
			if ( ! is_null( $data = self::prepare_data( $form ) ) ) {
				return $pods->save( $data );
			}

		}

	}

	/**
	 * Prepare data to be saved.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $form Form submission.
	 *
	 * @return array|void Form data or void if the sanitization failed.
	 */
	protected static function prepare_data( $form ) {
		$data = $form[ 'something' ];
		$data = ""; //this is where we need per form sanitization
		return $data;
	}

	/**
	 * Determine which form to save to.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $form Form submission.
	 *
	 * @return string Pod name
	 */
	protected static function which_pod( $form ) {
		return $form[ 'something' ];
	}


}
