<?php
/**
 * Prepare data to be saved, sanaitizing and removing unneeded fields from request.
 *
 * @package   foundri
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2015 Foundri
 */


namespace foundri\lib\data\save;


class prepare_data {
	/**
	 * The prepared and sanitized data to save.
	 *
	 * @var array
	 */
	public $data;

	/**
	 * Prepare data to be saved, sanaitizing and removing unneeded fields from request.
	 *
	 * @since 0.0.1
	 *
	 * @access protected
	 *
	 * @param array $_data Data from request.
	 *
	 */
	public function  __construct( $_data, $allowed_fields ) {
		$data = array();

		foreach( $allowed_fields as $field ) {
			$data[ $field ] = pods_v_sanitized( $field, $_data );
		}

		if ( ! empty( $data ) ) {
			$this->data = $data;
		}
	}

	
}
