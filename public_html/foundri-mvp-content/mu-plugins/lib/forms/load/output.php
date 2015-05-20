<?php
/**
 * Output forms
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */


namespace foundri\lib\forms\load;


use foundri\lib\forms\form;

class output extends form{

	/**
	 * Use to call any form, that is set in form_load class.
	 *
	 * USAGE: foundri_mvp_lib\forms\load\output:ask_make()
	 *
	 * @since 0.0.1
	 *
	 * @param string $name Name of form (method name)
	 * @param array $args Not used
	 *
	 * @return mixed|void
	 */
	public static function __callStatic( $name, $args ) {
		if ( self::form_allowed( $name ) ) {
			$entry_id = self::maybe_entry_id( $name );
			return \Caldera_Forms::render_form( $name, $entry_id );
		}

	}

	/**
	 * Find entry ID if possible and relevant
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param string $name Form name
	 *
	 * @return int|null Entry ID or null.
	 */
	protected static function maybe_entry_id( $name ) {
		$entry_id = null;
		if ( 'bio_profile' == $name ) {
			$_entry_id = get_user_meta( get_current_user_id(), 'profile_cf_entry_id', true );
			if ( 0 < absint( $_entry_id ) ) {
				$entry_id = (int) $_entry_id;

			}


		}

		return $entry_id;
	}


}
