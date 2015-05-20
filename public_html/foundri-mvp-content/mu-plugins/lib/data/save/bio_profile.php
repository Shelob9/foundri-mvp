<?php
/**
 * @TODO What this does.
 *
 * @package   @TODO
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link      
 * @copyright 2015 Josh Pollock
 */

namespace foundri\lib\data\save;


class bio_profile extends saver implements save_interface {
	/**
	 * Do the actual save
	 *
	 * @todo make work for update
	 *
	 * @since 0.0.1
	 *
	 * @param array $data Data from request.
	 *
	 * @return int|bool Item ID.
	 */
	public static function make_save( $data ) {



	}

	/**
	 * Fields to include in the saving
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	protected static function save_fields() {
		return array(
			'first_name',
			'last_name',
			'bio',
			'email',
			'twitter',
			'facebook',
		);
	}
}
