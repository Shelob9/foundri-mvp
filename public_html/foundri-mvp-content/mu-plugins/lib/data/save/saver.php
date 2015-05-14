<?php
/**
 * Abstract class for other save classes to extend.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */


namespace foundri\lib\data\save;


abstract class saver implements save_interface {

	/**
	 * Prepare data to be saved, sanaitizing and removing unneeded fields from request.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $_data Data from request.
	 *
	 * @return array
	 */
	protected static function prepare_data( $_data ) {
		$data = array();
		foreach( self::save_fields() as $field ) {
			$data[ $field ] = pods_v_sanitized( $field, $_data );
		}

		return $data;
	}

	/**
	 * Fields to include in the saving
	 *
	 * Make sure to set in the extending class.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @return array
	 */
	protected static function save_fields() {
		return array(

		);
	}
	
}
