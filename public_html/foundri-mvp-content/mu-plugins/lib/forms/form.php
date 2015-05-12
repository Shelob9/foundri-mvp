<?php
/**
 * Abstract class, with useful utilities for working with forms.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri_mvp_lib\forms;


use foundri_mvp_lib\forms\load\form_load;

abstract class form {

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

	/**
	 * @param $name
	 * @param null $id
	 *
	 * @return bool|\Pods
	 */
	protected static function pods_object( $name, $id = null ) {
		$pods = pods( $name, $id );
		if ( ! is_null( $id ) && $id != $pods->ID() ) {
			$pods->fetch( $id );
		}

		return $pods;

	}


}
