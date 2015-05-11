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


namespace foundri_mvp_lib\forms\load;


class output {

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
			return \Caldera_Forms::render_form( $name );
		}
	}

	/**
	 * Check if a form is allowed
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param string $name Name of form
	 *
	 * @return bool
	 */
	protected static function form_allowed( $name ) {
		$allowed = form_load::get_instance()->forms;
		if ( in_array( $name, $allowed  ) ) {
			return true;
		}

	}


}
