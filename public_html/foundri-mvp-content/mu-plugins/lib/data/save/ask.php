<?php
/**
 * Save an ask
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */

namespace foundri\lib\data\save;


class ask extends saver implements save_interface {

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
		$pods = pods( FOUNDRI_ASK, null );
		$data = self::prepare_data( $data );
		$data[ 'author' ] = get_current_user_id();
		$id = $pods->save( $data );

		return $id;

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
			'ask_type',
			'community',
			'ask_details'
		);
	}

}
