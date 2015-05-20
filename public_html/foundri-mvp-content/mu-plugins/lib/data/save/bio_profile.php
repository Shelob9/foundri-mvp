<?php
/**
 * Save bio/profile for a user
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */
namespace foundri\lib\data\save;


class bio_profile extends saver implements save_interface {
	/**
	 * Do the actual save
	 *
	 * @since 0.0.1
	 *
	 * @param array $data Data from request.
	 *
	 * @return int|bool Item ID.
	 */
	public static function make_save( $data ) {
		$user_id = get_current_user_id();
		if ( 0 < (int) $user_id ) {
			foreach( $data as $field => $datum ) {
				update_user_meta( $user_id, $field, $datum );
			}
		}

		return $user_id;

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
			'profile_cf_entry_id'
		);
	}

}
